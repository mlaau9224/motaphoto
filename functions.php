<?php
add_action('after_setup_theme', function() {
	add_theme_support('title-tag');

	add_theme_support('custom-logo', [
		'height'      => 22,
		'width'       => 345,
		'flex-height' => true,
		'flex-width'  => true,
	]);

    register_nav_menus([
		'primary' => __('Menu principal', 'mon-theme'),
		'footer'  => __('Menu du pied de page', 'mon-theme'),
	]);
});

function load_scripts(){
    wp_enqueue_style('mon-theme', get_stylesheet_directory_uri() . '/style.css');
    wp_enqueue_script('scripts', get_stylesheet_directory_uri() . '/js/scripts.js', array('jquery'), '1.0', true);
	wp_enqueue_script('select-2-js', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js');
	wp_enqueue_style('select-2-css', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css');
}

add_action('wp_enqueue_scripts', 'load_scripts');

add_action('wp_ajax_load_posts', 'load_posts');
add_action('wp_ajax_nopriv_load_posts', 'load_posts');

function load_posts(){
	$nonce = sanitize_text_field($_REQUEST['nonce']);
	$action = sanitize_text_field($_POST['paged']);
	$posts_per_page = intval(8);
	$paged = intval($_POST['paged']);
	$categorie = sanitize_text_field($_POST['categorie']);
	$format = sanitize_text_field($_POST['format']);
	$date = sanitize_text_field($_POST['date']);

	$ajaxposts = new WP_Query([
		'post_type' => 'photo',
		'posts_per_page' => $posts_per_page,
		'paged' => $paged,
	]);

	if(!empty($categorie)){
		$ajaxposts = new WP_Query([
			'post_type' => 'photo',
			'posts_per_page' => $posts_per_page,
			'paged' => $paged,
			'tax_query' => [
				[
					'taxonomy' => 'categorie',
					'field' => 'slug',
					'terms' => $categorie,
				],
			],
		]);
	}

	if(!empty($format)){
		$ajaxposts = new WP_Query([
			'post_type' => 'photo',
			'posts_per_page' => $posts_per_page,
			'paged' => $paged,
			'tax_query' => [
				[
					'taxonomy' => 'format',
					'field' => 'slug',
					'terms' => $format,
				],
			],
		]);
	}

	if(!empty($date)){
		$ajaxposts = new WP_Query([
			'post_type' => 'photo',
			'posts_per_page' => $posts_per_page,
			'paged' => $paged,
			'order' => $date,
		]);
	}

	if(!empty($categorie) && !empty($format)){
		$ajaxposts = new WP_Query([
			'post_type' => 'photo',
			'posts_per_page' => $posts_per_page,
			'paged' => $paged,
			'tax_query' => [
				'relation' => 'AND',
				[
					'taxonomy' => 'categorie',
					'field' => 'slug',
					'terms' => $categorie,
				],

				[
					'taxonomy' => 'format',
					'field' => 'slug',
					'terms' => $format,
				],
			],
		]);
	}

	if(!empty($categorie) && !empty($date)){
		$ajaxposts = new WP_Query([
			'post_type' => 'photo',
			'posts_per_page' => $posts_per_page,
			'paged' => $paged,
			'order' => $date,
			'tax_query' => [
				[
					'taxonomy' => 'categorie',
					'field' => 'slug',
					'terms' => $categorie,
				],
			],
		]);
	}

	if(!empty($format) && !empty($date)){
		$ajaxposts = new WP_Query([
			'post_type' => 'photo',
			'posts_per_page' => $posts_per_page,
			'paged' => $paged,
			'order' => $date,
			'tax_query' => [
				[
					'taxonomy' => 'format',
					'field' => 'slug',
					'terms' => $format,
				],
			],
		]);
	}

	if(!empty($categorie) && !empty($format) && !empty($date)){
		$ajaxposts = new WP_Query([
			'post_type' => 'photo',
			'posts_per_page' => $posts_per_page,
			'paged' => $paged,
			'order' => $date,
			'tax_query' => [
				'relation' => 'AND',
				[
					'taxonomy' => 'categorie',
					'field' => 'slug',
					'terms' => $categorie,
				],
				[
					'taxonomy' => 'format',
					'field' => 'slug',
					'terms' => $format,
				],
			],
		]);
	}

	$response = '';
	$max_pages = $ajaxposts->max_num_pages;

	if($ajaxposts->have_posts()){
		ob_start();
		while($ajaxposts->have_posts()) : $ajaxposts->the_post();
			$response .= get_template_part('templates_part/photo_block');
		endwhile;
		$output = ob_get_contents();
		ob_end_clean();
	} else{
		$response = '';
	}

	$result = [
		'max' => $max_pages,
		'html' => $output,
	];
	
	echo json_encode($result);
	exit;
}