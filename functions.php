<?php
defined('ABSPATH') || exit;

// Functions to enqueue styles and scripts for the frontend
function mycustometheme_enqueue_assets() {
    wp_enqueue_style('mycustomtheme-style', get_stylesheet_uri());

    wp_enqueue_script('mycustomtheme-slider', get_template_directory_uri() . '/slider.js', [],'1.0', true);

    wp_enqueue_script('mycustomtheme-ajax', get_template_directory_uri() . '/ajax-filter.js', ['jquery'], '1.0', true);

    wp_localize_script('mycustomtheme-ajax', 'ajax_object', ['ajax_url' => admin_url('admin-ajax.php')]);


}

add_action('wp_enqueue_scripts', 'mycustometheme_enqueue_assets');

function mycustomtheme_setup(){
    register_nav_menus([
        'main-menu' => __('Main Menu', 'mycustomtheme'),
    ]);
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_image_size('slider-image', 800, 400, true);

    // Register Portfolio custom post type (cpt)
    register_post_type('portfolio', [
        'labels' => [
            'name' => __('Portfolio', 'mycustomtheme'),
            'singular_name' => __('Portfolio Item', 'mycustomtheme'),
        ],
        'public' => true,
        'has_archive' => true,
        'supports' => ['title', 'editor', 'thumbnail'],
        'rewrite' => ['slug' => 'portfolio'],
        'show_in_rest' => true, // Optional: for block editor / API
    ]);
    
}

add_action('after_setup_theme', 'mycustomtheme_setup');

// Function to add a meta box for post settings
function mycustomtheme_add_box(){
    add_meta_box(
        'mycustomtheme_settings',
        __('Post Settings', 'mycustomtheme'),
        'mycustomtheme_meta_box_callback',
        ['post','portfolio'],
        'side',
    );
}
add_action('add_meta_boxes', 'mycustomtheme_add_box');

// Callback function to render meta box content
function mycustomtheme_meta_box_callback($post){
    $is_featured = get_post_meta($post->ID, 'is_featured', true);

    $has_slider_image = get_post_meta($post->ID, 'has_slider_image', true);

?>
<p>
    <label for="is_featured">Mark ad Featured:</label>
        <select name="is_featured" id="is_featured">
            <option value="">Select</option>
            <option value="yes" <?php selected($is_featured, 'yes'); ?>>Yes</option>
            <option value="no" <?php selected($is_featured, 'no'); ?>>No</option>
        </select>
</p>

<p>
    <label for="has_slider_image"> Include in Slider: </label>
    <select name="has_slider_image" id="has_slider_image">
        <option value="" >Select</option>
        <option value="yes" <?php selected($has_slider_image, 'yes'); ?>> Yes </option>
        <option value="no" <?php selected($has_slider_image, 'no'); ?>> No </option>
    </select>

</p>
<?php 

}

// Function to save meta box data
function mycustomtheme_save_meta_box($post_id){
    if (isset($_POST['is_featured'])){
        update_post_meta($post_id, 'is_featured', sanitize_text_field($_POST['is_featured']));
    }

    if (isset($_POST['has_slider_image'])){
        update_post_meta($post_id, 'has_slider_image', sanitize_text_field($_POST['has_slider_image']));
    }

}

add_action('save_post', 'mycustomtheme_save_meta_box');


// Function to register a custom block
function mycustomtheme_register_block(){
    wp_register_script(
        'mycustomtheme-greeting-block', 
        get_template_directory_uri() . '/block.js',
        ['wp-blocks', 'wp-element', 'wp-block-editor'],
        '1.0',
        true
    );

    register_block_type('mycustomtheme/greeting', [
        'editor_script' => 'mycustomtheme-greeting-block', 
        'render_callback' => 'mycustomtheme_greeting_render',
    ]);
}

add_action('init', 'mycustomtheme_register_block');

// Function to render the custom block
function mycustomtheme_greeting_render($attributes){
    $greeting = isset($attributes['greeting']) ? esc_html($attributes['greeting']) : 
    'Hello, World';
    return "<div class='greeting-block'>$greeting</div>";
}

// Define social media widget class
class MyCustomTheme_Social_Widget extends WP_Widget {
    public function __construct(){
        parent::__construct(
            'mycustomtheme_social_widget',
            __('Social Media Links', 'mycustomtheme'),
            ['description' => __('Display social media links', 'mycustomtheme' )]
        );
    }

    public function widget($args, $instance){
        echo $args['before_widget'];

        $twitter = !empty($instance['twitter']) ? asc_url($instance['twitter']) : '';

        $linkedin = !empty($instance['linkedin']) ? asc_url($instance['linkedin']) : '';
        ?>

        <div class="social-widget">
            <h3><?php echo esc_html($instance['title']); ?></h3>
            <ul>
                <?php if ($twitter) : ?>
                    <li><a href="<?php echo $twitter; ?>">Twitter</a></li>
                <?php endif;?>

                <?php if ($linkedin) : ?>
                    <li><a href="<?php echo $linkedin; ?>">Linkedin</a></li>
                <?php endif;?>

            </ul>
        </div>

        <?php 
        echo $args['after_widget'];

    }

    public function form($instance){
        $title = !empty($instance['title']) ? $instance['title'] : '';

        $twitter = !empty($instance['twitter']) ? $instance['twitter'] : '';

        $linkedin = !empty($instance['linkedin']) ? $instance['linkedin'] : '';

    

    ?>

    <p>
        <label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
    </p>

    <p>
        <label for="<?php echo $this->get_field_id('twitter'); ?>">Twitter:</label>
        <input class="widefat" id="<?php echo $this->get_field_id('twitter'); ?>" name="<?php echo $this->get_field_name('twitter'); ?>" type="text" value="<?php echo esc_attr($twitter); ?>">
    </p>

    <p>
        <label for="<?php echo $this->get_field_id('linkedin'); ?>">Linkedin:</label>
        <input class="widefat" id="<?php echo $this->get_field_id('linkedin'); ?>" name="<?php echo $this->get_field_name('linkedin'); ?>" type="text" value="<?php echo esc_attr($linkedin); ?>">
    </p>

    <?php 
}
    public function update($new_instance, $old_instace){
        $instance = [];
        $instance['title'] = !empty($new_instance['title']) ? sanitize_text_field($new_instance['title']) : '';

        $instance['twitter'] = !empty($new_instance['twitter']) ? esc_url_raw($new_instance['twitter']) : '';

        $instance['linkedin'] = !empty($new_instance['linkedin']) ? esc_url_raw($new_instance['linkedin']) : '';

        return $instance;

    }
}

    // Function to register the widget
    function mycustomtheme_register_widgets(){
        register_widget('MyCustomTheme_Social_Widget');
    }

    add_action('widgets_init', 'mycustomtheme_register_widgets');

    // Function to handle AJAX post filtering
    function mycustomtheme_filter_posts(){
        $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : 'all';

        $args = [
            'posts_per_page' => 6,
            'post_status' => 'publish'
        ];

        if ($category !== 'all') {
            $args['category_name'] = $category;
        }

        $query = new WP_Query($args);
        ob_start();

        if($query->have_posts()) :
            while ($query->have_posts()) : $query->the_post();
            ?>
            <article>
                <h3>
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?> </a>
                   
                
                </h3>
                <?php the_excerpt(); ?>
        </article>
        <?php 
        endwhile;
        wp_reset_postdata();
    else:
        ?>
        <p>No posts found.</p>

        <?php 
        endif;

        $output = ob_get_clean();
        wp_send_json_success(['html' => $output]);
    }

    add_action('wp_ajax_filter_posts', 'mycustomtheme_filter_posts');

    add_action('wp_ajax_nopriv_filter_posts', 'mycustomtheme_filter_posts');


