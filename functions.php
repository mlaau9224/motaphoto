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
}
add_action('wp_enqueue_scripts', 'load_scripts');