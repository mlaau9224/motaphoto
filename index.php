<?php
$formats = get_terms('format');

$args = array(
    'post_type' => 'photo',
    'posts_per_page' => 1,
    'orderby' => 'rand',
    'tax_query' => [
        [
            'taxonomy' => $formats[0]->taxonomy,
            'field' => 'slug',
            'terms' => $formats[0]->name,
        ],
    ],
);

$paged = get_query_var('paged') ? get_query_var('paged') : 1;

$hero = new WP_Query($args);

$args2 = array(
    'post_type' => 'photo',
    'posts_per_page' => 8,
    'paged' => $paged,
);

$photos = new WP_Query($args2);
?>

<?php
get_header();
?>

<?php if($hero->have_posts()): ?>
    <div class="hero">
        <?php while($hero->have_posts()) : $hero->the_post(); ?>
            <?= get_the_post_thumbnail(); ?>
        <?php endwhile; ?>
        <div class="hero-title">
            <h1>Photographe Event</h1>
        </div>  
    </div>
<?php endif; ?>

<?php if($photos->have_posts()): ?>
    <div class="liste-photos">
        <?php while($photos->have_posts()) : $photos->the_post(); ?>
            <?= get_template_part('templates_part/photo_block'); ?>
        <?php endwhile; ?>
    </div>
<?php endif; ?>

<?php
get_footer();
?>