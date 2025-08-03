<?php get_header(); ?>
<main> 
    <h1>Welcome to My Custome Theme.</h1>
    <?php get_template_part('slider'); ?>
    <?php 
    $featured_args = [
        'posts_per_page' => 1,
        'meta_key' => 'is_featured',
        'meta_value' => 'yes',
    ];

    // Creates new query instance for featured post

    $featured_query = new WP_Query($featured_args);
    if ($featured_query->have_posts()) : ?>
        <section class="featured-post">
            <h2>Featured Post</h2>
            <?php while ($featured_query->have_posts()) : $featured_query->the_post(); ?>
            <article>
                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <?php the_excerpt(); ?>
            </article>
            <?php endwhile; ?>
        </section>

        <?php wp_reset_postdata(); ?>
    <?php endif; ?>    

    <!-- Container for latest posts section -->

    <section class="latest-posts">
        <h2>
            Latest Posts
        </h2>
        <div class="filter-controls">
            <button class="filter-btn" data-category="all">All</button>
            <?php $categories = get_categories();
            foreach ($categories as $category)
                echo '<button class="filter-btn" data-category="'.esc_attr($category->slug) . '">' . esc_html($category->name) . '</button>';
            ?>
        </div>

        <!-- Container for posts grid -->

        <div class="post-grid" id="post-grid">
            <?php
            $latest_args = [
                'posts_per_page' => 6,
                'post_status' => 'publish',
            ];

            $latest_query = new WP_Query($latest_args);
            if ($latest_query->have_posts()) : ?>
                <?php while ($latest_query->have_posts()) : $latest_query->the_post(); ?>
                    <article> 
                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <?php the_excerpt(); ?>
                    </article>
                <?php endwhile; ?>
                <?php wp_reset_postdata(); ?>

            <?php else : ?>
                <p>No posts found.</p>
            <?php endif ?>

        </div>
            </section>
            </main>
            <?php get_footer(); ?>