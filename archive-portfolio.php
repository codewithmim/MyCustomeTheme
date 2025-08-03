<?php get_header(); ?>
<main>
    <h1>Portfolio</h1>
    <div class="post-grid">
        <?php if (have_posts()) :?>
            <?php while (have_posts()) : the_post(); ?>
                <article>
                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?> </a></h3>
                    <?php if (has_post_thumbnail()) : ?>
                        <?php the_post_thumbnail('thumbnail'); ?>
                            <?php endif; ?>
                        <?php the_excerpt(); ?>
                </article>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No portfolio items found.</p>
            <?php endif; ?>
    </div>
        </main>
<?php the_footer(); ?>