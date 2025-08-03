<?php get_header(); ?>
<main>
    <article>
        <h1><?php the_title(); ?> </h1>
        <?php if (has_post_thumbnail()) : ?>
            <?php the_post_thumbnail('large'); ?>
            <?php endif; ?>
            <?php the_content(); ?>
        </artcle>
        </main>
<?php the_footer(); ?>