<?php
$formats = get_terms('format');
$categories = get_terms('categorie');

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

<div class="select-block">
    <div class="cat-formats">
        <div class="categories">
            <select name="" id="categorie">
                <option value="">Catégories</option>
                <?php foreach($categories as $c): ?>
                    <option value="<?= $c->name; ?>"><?= $c->name; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="formats">
            <select name="" id="format">
                <option value="">Formats</option>
                <?php foreach($formats as $f): ?>
                    <option value="<?= $f->name; ?>"><?= $f->name; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="date">
        <div class="trier">
            <select name="" id="date">
                <option value="">Trier par</option>
                <option value="DESC">A partir des plus récentes</option>
                <option value="ASC">A partir des plus anciennes</option>
            </select>
        </div>
    </div>
</div>

<?php if($photos->have_posts()): ?>
    <div class="liste-photos">
        <?php while($photos->have_posts()) : $photos->the_post(); ?>
            <?= get_template_part('templates_part/photo_block'); ?>
        <?php endwhile; ?>
    </div>
<?php endif; ?>

<form action="<?= admin_url('admin-ajax.php'); ?>" method="POST" class="form-load">
    <input type="hidden" id="action" value="load_posts">
    <input type="hidden" id="nonce" value="<?= wp_create_nonce('load_posts'); ?>">
    <button class="btn-load">Charger plus</button>
</form>

<?php
get_footer();
?>