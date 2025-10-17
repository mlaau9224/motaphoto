<?php
$post = get_post();
$args = array(
    'post_type' => 'photo',
    'posts_per_page' => 1,
    'p' => $post->ID,
);
$single = new WP_Query($args);
$fields = get_field_objects($post->ID);
$categorie = get_the_terms($post->ID, 'categorie');
$format = get_the_terms($post->ID, 'format');

$next_post = get_next_post();
$prev_post = get_previous_post();

$args2 = array(
    'post_type' => 'photo',
    'posts_per_page' => 1,
    'order' => 'DESC',
);

$args3 = array(
    'post_type' => 'photo',
    'posts_per_page' => 1,
    'order' => 'ASC',
);

$prev = new WP_Query($args2);
$next = new WP_Query($args3);
?>

<?php
get_header();
?>

<?php if($single->have_posts()): ?>
<div class="single">
    <div class="single-block">
        <?php while($single->have_posts()) : $single->the_post(); ?>
            <div class="single-content">
                <h2><?= the_title(); ?></h2>
                <p><?= $fields['reference']['name']; ?> : <span class="reference"><?= $fields['reference']['value']; ?></span></p>
                <p><?= $categorie[0]->taxonomy; ?> : <?= $categorie[0]->name; ?></p>
                <p><?= $format[0]->taxonomy; ?> : <?= $format[0]->name; ?></p>
                <p><?= $fields['type']['name']; ?> : <?= $fields['type']['value']; ?></p>
                <p>Année : <?= get_the_date('Y'); ?></p>
            </div>
            <div class="single-picture">
                <?= get_the_post_thumbnail(); ?>
            </div>
        <?php endwhile; ?>
    </div>
</div>
<div class="single-bottom">
    <div class="bottom">
        <div class="single-contact">
            <p>Cette photo vous intéresse ?</p>
            <button class="btn-contact">Contact</button>
        </div>
        <div class="single-nav">
            <div class="images">
                <?php if(!empty($prev_post)): ?>
                    <img class="prevImg" src="<?= get_the_post_thumbnail_url($prev_post); ?>" alt="">
                <?php else: ?>
                    <?php if($prev->have_posts()): ?>
                        <?php while($prev->have_posts()) : $prev->the_post(); ?>
                            <img class="prevImg" src="<?= get_the_post_thumbnail_url($prev->ID); ?>" alt="">
                        <?php endwhile; ?>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if(!empty($next_post)): ?>
                    <img class="nextImg" src="<?= get_the_post_thumbnail_url($next_post); ?>" alt="">
                <?php else: ?>
                    <?php if($next->have_posts()): ?>
                        <?php while($next->have_posts()) : $next->the_post(); ?>
                            <img class="nextImg" src="<?= get_the_post_thumbnail_url($next->ID); ?>" alt="">
                        <?php endwhile; ?>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            
            <div class="arrows">
                <?php if(!empty($prev_post)): ?>
                    <a class="arrowLeft" href="<?= get_permalink($prev_post); ?>"><img src="<?= get_stylesheet_directory_uri() . '/img/left.png' ?>" alt=""></a>
                <?php else: ?>
                    <?php if($prev->have_posts()): ?>
                        <?php while($prev->have_posts()) : $prev->the_post(); ?>
                            <a class="arrowLeft" href="<?= get_permalink($prev->ID); ?>">
                                <img src="<?= get_stylesheet_directory_uri() . '/img/left.png' ?>" alt="">
                            </a>
                        <?php endwhile; ?>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if(!empty($next_post)): ?>
                    <a class="arrowRight" href="<?= get_permalink($next_post); ?>"><img src="<?= get_stylesheet_directory_uri() . '/img/right.png' ?>" alt=""></a> 
                <?php else: ?> 
                    <?php if($next->have_posts()): ?>
                        <?php while($next->have_posts()) : $next->the_post(); ?>
                            <a class="arrowRight" href="<?= get_permalink($next->ID); ?>">
                                <img src="<?= get_stylesheet_directory_uri() . '/img/right.png' ?>" alt="">
                            </a>
                        <?php endwhile; ?>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?> 

<?php
get_footer();
?>