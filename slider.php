<?php 
$slider_args = [
    'posts_per_page' => 3,
    'post_status' => 'publish',
    'meta_key' => 'has_slider_image',
    'meta_value' => 'yes',
];

$slider_query = new WP_Query($slider_args);

if ($slider_query->have_posts()) : ?>
    <div class="slider">
        <?php while ($slider_query->have_posts()) : $slider_query->the_post(); ?>
        <div class="slide">
            <?php if (has_post_thumbnail()) : ?> 
                <a href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail('slider-image'); ?>
                </a>
                <div class="slide-caption">
                    <h3><?php the_title(); ?></h3>
                </div>
            <?php endif; ?>
        </div>
        <?php endwhile; ?>
    </div>

    <?php wp_reset_postdata(); ?>

<?php endif; ?>