<?php $categorie = get_the_terms(get_the_ID(), 'categorie'); ?>

<div class="photo-block">
    <?= get_the_post_thumbnail(); ?>
    <div class="photo-content">
        <a class="full-screen" href="<?= get_the_post_thumbnail_url(); ?>"><img src="<?= get_stylesheet_directory_uri() . '/img/full-screen.png' ?>" alt=""></a>
        <a class="eye-white" href="<?= get_permalink(); ?>"><img src="<?= get_stylesheet_directory_uri() . '/img/eye-white.png' ?>" alt=""></a>
        <p class="title-single"><?= the_title(); ?></p>
        <p class="title-cat"><?= $categorie[0]->name; ?></p>
    </div> 
</div>