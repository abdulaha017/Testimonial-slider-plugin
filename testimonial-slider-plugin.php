<?php
/**
 * Plugin Name:       Testimonial Slider
 * Plugin URI:        https://example.com/
 * Description:       Handle the basics with this plugin.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Abdulaha Islam
 * Author URI:        https://www.linkedin.com/in/abdulaha-islam/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       testimonial-slider
 * Domain Path:       /languages
 */


/**
 * If this file is called directly, then abort execution.
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


/**
 * Load plugin textdomain.
 */
function ab_tes_load_textdomain() {
    load_plugin_textdomain( 'testimonial-slider', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
}

add_action('init', 'ab_tes_load_textdomain');


// register javascript and css on initialization
function ab_tes_register_script() {

    wp_register_style( 'owl-carousel-css', plugins_url('/assets/css/owl.carousel.min.css', __FILE__), false, '1.3.3', 'all');
    wp_register_style( 'owl-theme-css', plugins_url('/assets/css/owl.theme.min.css', __FILE__), false, '1.3.3', 'all');


    wp_register_style( 'slick-theme-css', plugins_url('/assets/css/slick-theme.css', __FILE__), false, '1.5.0', 'all');
    wp_register_style( 'slick-min-css', plugins_url('/assets/css/slick.min.css', __FILE__), false, '1.5.0', 'all');
    wp_register_style( 'font-awesome-css', '//maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css', false, '4.7.0', 'all');


    wp_register_style( 'bootstrap-css', plugins_url('/assets/css/bootstrap.min.css', __FILE__), false, '4.1.3', 'all');
    wp_register_style( 'style-css', plugins_url('/assets/css/style.css', __FILE__), false, '1.3.3', 'all');


    wp_register_script( 'popper-js', plugins_url('/assets/js/popper.min.js', __FILE__), array('jquery'), '1.12.9' );
    wp_register_script( 'bootstrap-js', plugins_url('/assets/js/bootstrap.min.js', __FILE__), array('jquery'), '4.0.0' );
    wp_register_script( 'owl-carousel-min-js', plugins_url('/assets/js/owl.carousel.min.js', __FILE__), array('jquery'), '1.3.3' );
    wp_register_script( 'slick-min-js', plugins_url('/assets/js/slick.min.js', __FILE__), array('jquery'), '1.5.0' );
    
    wp_register_script( 'main-js', plugins_url('/assets/js/main.js', __FILE__), array('jquery'), '1.0.0' );
}

add_action('init', 'ab_tes_register_script');


// use the registered javascript and css above
function ab_tes_enqueue_style(){
    wp_enqueue_style('owl-carousel-css');
    wp_enqueue_style('owl-theme-css');
    wp_enqueue_style('slick-theme-css');
    wp_enqueue_style('slick-min-css');
    wp_enqueue_style('font-awesome-css');
    wp_enqueue_style('bootstrap-css');
    wp_enqueue_style('style-css');

    wp_enqueue_style('popper-js');
    wp_enqueue_style('bootstrap-js');
    wp_enqueue_script( 'owl-carousel-min-js' );
    wp_enqueue_script( 'slick-min-js' );
    wp_enqueue_script( 'main-js' );
}

add_action('wp_enqueue_scripts', 'ab_tes_enqueue_style');


/**
 * Register a custom post type called "Testimonial".
 *
 * @see get_post_type_labels() for label keys.
 */
function ab_tes_codex_testimonial_init() {
    $labels = array(
        'name'                  => _x( 'Testimonials', 'Post type general name', 'textdomain' ),
        'singular_name'         => _x( 'Testimonial', 'Post type singular name', 'textdomain' ),
        'menu_name'             => _x( 'Testimonials', 'Admin Menu text', 'textdomain' ),
        'name_admin_bar'        => _x( 'Testimonial', 'Add New on Toolbar', 'textdomain' ),
        'add_new'               => __( 'Add New', 'textdomain' ),
        'add_new_item'          => __( 'Add New Testimonial', 'textdomain' ),
        'new_item'              => __( 'New Testimonial', 'textdomain' ),
        'edit_item'             => __( 'Edit Testimonial', 'textdomain' ),
    );
 
    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'ab-testimonial' ),
        'menu_icon'          => 'dashicons-slides',
        'capability_type'    => 'post',
        'has_archive'        => true,
        'menu_position'      => 26,
        'supports'           => array( 'title', 'editor', 'thumbnail' ),
    );
 
    register_post_type( 'abtestimonial', $args );
}
 
add_action( 'init', 'ab_tes_codex_testimonial_init' );


/* Meta box setup function. */
function ab_testimonial_custom_box(){
    add_meta_box(
        '_ab_testimonials_info',     // Unique ID
        'Additional Information',    // Box title
        'ab_testimonials_box_html',  // Content callback, must be of type callable
        'abtestimonial',             // Post type
        'normal'                     // context
    );
}

add_action('add_meta_boxes', 'ab_testimonial_custom_box');


/* Display the post meta box. */
function ab_testimonials_box_html($post){

    global $post;

    // Use nonce for verification to secure data sending
    wp_nonce_field( plugin_basename( __FILE__ ), 'abt_meta_box_nonce' );


    $ab_company_name = get_post_meta( $post->ID, 'abt_company_name', true );
    $ab_designation = get_post_meta( $post->ID, 'abt_designation', true );

    ?>

    <table class="form-table editcomment" role="presentation">
        <tbody>
            <tr>
                <td class="first">
                    <label for="name">Company Name</label>
                </td>
                <td>
                    <input type="text" class="widefat" name="abt_company_name" size="" value="<?php echo $ab_company_name; ?>" id="">
                </td>
            </tr>
            <tr>
                <td class="first">
                    <label for="email">Designation</label>
                </td>
                <td>
                    <input type="text" class="widefat" name="abt_designation" size="" value="<?php echo $ab_designation; ?>" id="">
                </td>
            </tr>
        </tbody>
    </table>

    <?php
}


/* Save post meta on the 'save_post' hook. */
function ab_testimonial_post_save($post_id) {

    // Bail if we're doing an auto save
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

    // if our nonce isn't there, or we can't verify it, bail
    if( !isset( $_POST['abt_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['abt_meta_box_nonce'], plugin_basename( __FILE__ ) ) ) return;
     
    // if our current user can't edit this post, bail
    if( !current_user_can( 'edit_post' ) ) return;


    if(isset($_POST['abt_company_name'])) {
        $ab_company_name = $_POST['abt_company_name'];
    }
    if(isset($_POST['abt_designation'])) {
        $ab_designation = $_POST['abt_designation'];
    }

    // update company name
    update_post_meta(
        $post_id,
        'abt_company_name',
        $ab_company_name
    );

    // update designation
    update_post_meta(
        $post_id,
        'abt_designation',
        $ab_designation
    );
}

add_action('save_post', 'ab_testimonial_post_save');


// Testimonial One Shortcode

function testimonial_style_one_func( $atts ) {

    ob_start(); ?>


    <!-- Testimonial Carousel -->
    <div class="ab-one-testimonial-slider">
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-2">

                    <?php
                        $ab_testimonials = new WP_Query(array(
                            'post_type'         => 'abtestimonial',
                            'posts_per_page'    => 3
                        ));
                    ?>

                    <div class="ab-one-slider slider ab-one-slider-for">
                        <?php while($ab_testimonials->have_posts()) : $ab_testimonials->the_post(); ?>

                        <article class="test-item-content text-center">
                            <?php the_content(); ?>
                            <span><?php the_title(); ?> - <?php echo get_post_meta( get_the_id(), 'abt_company_name', true ); ?>, <?php echo get_post_meta( get_the_id(), 'abt_designation', true ); ?></span>
                        </article>

                        <?php endwhile; ?>
                    </div>

                    <div class="ab-one-slider slider ab-one-slider-nav ab-test-slider-nav text-center">

                    <?php while($ab_testimonials->have_posts()) : $ab_testimonials->the_post(); ?>
                        <figure class="image">
                            <?php the_post_thumbnail( 'thumbnail', array( 'class' => 'img-fluid rounded-circle' ) ); ?>
                        </figure>
                    <?php endwhile; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php 
    return ob_get_clean();


}
add_shortcode( 'ab-testimonial-style-one', 'testimonial_style_one_func' );



// Testimonial two Shortcode

function testimonial_style_two_func( $atts ) {

    ob_start(); 
    $ab_two_testimonials = new WP_Query(array(
        'post_type'         => 'abtestimonial',
        'posts_per_page'    => -1
    ));
    
    ?>
        <!-- Testimonial Carousel -->
        <section class="testimonial-section">
            <div class="testimonials-two">
                <?php while($ab_two_testimonials->have_posts()) : $ab_two_testimonials->the_post(); ?>
                    <div class="testimonial">
                        <article class="test-content">
                            <?php the_content(); ?>
                        </article>
                        <?php the_post_thumbnail( 'thumbnail', array( 'class' => 'img-fluid rounded-circle' ) ); ?>
                        <div class="details">
                            <h5> <?php the_title(); ?> </h5>
                            <span class="info"> 
                            <?php echo get_post_meta( get_the_id(), 'abt_company_name', true ); ?> /
                            <?php echo get_post_meta( get_the_id(), 'abt_designation', true ); ?>
                            </span>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </section>

    <?php 
    return ob_get_clean();

}
add_shortcode( 'ab-testimonial-style-two', 'testimonial_style_two_func' );



// Testimonial three Shortcode

function testimonial_style_three_func( $atts ) {

    ob_start(); 
    $ab_three_testimonials = new WP_Query(array(
        'post_type'         => 'abtestimonial',
        'posts_per_page'    => -1
    ));
    
    ?>

    <!-- Testimonial Carousel -->
    <div class="testimonial-reel">
        <?php while($ab_three_testimonials->have_posts()) : $ab_three_testimonials->the_post(); ?>
        <!-- Testimonial -->
        <div class="box">
            <!-- Testimonial Image -->
            <figure class="image">
                <?php the_post_thumbnail( 'thumbnail', array( 'class' => 'img-fluid rounded-circle' ) ); ?>
            </figure>
            <!-- / Testimonial Image -->

            <div class="test-component">
                <!-- Title -->
                <article class="test-title">
                    <h4><?php the_title(); ?></h4>
                </article>
                <!-- / Title -->

                <article class="test-content">
                    <p><?php the_content(); ?></p>
                </article>
            </div>
        </div>
        <!-- / Testimonial -->
        <?php endwhile; ?>
    </div>
    <!-- / Testimonial Carousel -->


    <?php 
    return ob_get_clean();


}
add_shortcode( 'ab-testimonial-style-three', 'testimonial_style_three_func' );




// Testimonial four Shortcode

function testimonial_style_four_func( $atts ) {

    ob_start(); 
    $ab_four_testimonials = new WP_Query(array(
        'post_type'         => 'abtestimonial',
        'posts_per_page'    => -1
    ));
    
    ?>


    <section class="testimonial_section">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="about_content">
                        <div class="background_layer"></div>
                        <div class="layer_content">
                            <div class="section_title">
                                <h5>CLIENTS</h5>
                                <h2>Happy with<strong>Customers & Clients</strong></h2>
                                <div class="heading_line"><span></span></div>
                                <p>If you need any industrial solution we are available for you. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                            </div>
                            <a href="#">Contact Us<i class="icofont-long-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="testimonial_box">
                        <div class="testimonial_container">
                            <div class="background_layer"></div>
                            <div class="layer_content">
                                <div class="testimonial_owlCarousel">

                                <?php while($ab_four_testimonials->have_posts()) : $ab_four_testimonials->the_post(); ?>
                                    <div class="testimonials">
                                        <div class="testimonial_content">
                                            <div class="testimonial_caption">
                                                <h6><?php the_title(); ?></h6>
                                                <span>
                                                    <?php echo get_post_meta( get_the_id(), 'abt_designation', true ); ?>, <?php echo get_post_meta( get_the_id(), 'abt_company_name', true ); ?>
                                                </span>
                                            </div>
                                            <p><?php the_content(); ?></p>
                                        </div>
                                        <div class="images_box">
                                            <div class="testimonial_img">
                                                <?php the_post_thumbnail( 'medium', array( 'class' => 'img-center' ) ); ?>
                                            </div>
                                        </div>
                                    </div>

                                <?php endwhile; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php 
    return ob_get_clean();


}
add_shortcode( 'ab-testimonial-style-four', 'testimonial_style_four_func' );



