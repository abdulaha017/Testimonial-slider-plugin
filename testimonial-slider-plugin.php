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


// register jquery and style on initialization
function ab_tes_register_script() {

    wp_register_style( 'owl-carousel-css', plugins_url('/assets/css/owl.carousel.min.css', __FILE__), false, '1.3.3', 'all');
    wp_register_style( 'owl-theme-css', plugins_url('/assets/css/owl.theme.min.css', __FILE__), false, '1.3.3', 'all');


    wp_register_style( 'slick-theme-css', plugins_url('/assets/css/slick-theme.css', __FILE__), false, '1.5.0', 'all');
    wp_register_style( 'slick-min-css', plugins_url('/assets/css/slick.min.css', __FILE__), false, '1.5.0', 'all');


    wp_register_style( 'style-css', plugins_url('/assets/css/style.css', __FILE__), false, '1.3.3', 'all');


    wp_register_script( 'owl-carousel-min-js', plugins_url('/assets/js/owl.carousel.min.js', __FILE__), array('jquery'), '1.3.3' );
    wp_register_script( 'slick-min-js', plugins_url('/assets/js/slick.min.js', __FILE__), array('jquery'), '1.5.0' );
    
    wp_register_script( 'main-js', plugins_url('/assets/js/main.js', __FILE__), array('jquery'), '1.0.0' );
}

add_action('init', 'ab_tes_register_script');


// use the registered jquery and style above
function ab_tes_enqueue_style(){
    wp_enqueue_style('owl-carousel-css');
    wp_enqueue_style('owl-theme-css');
    wp_enqueue_style('slick-theme-css');
    wp_enqueue_style('slick-min-css');
    wp_enqueue_style('style-css');

    wp_enqueue_script( 'owl-carousel-min-js' );
    wp_enqueue_script( 'slick-min-js' );
    wp_enqueue_script( 'main-js' );
}

add_action('wp_enqueue_scripts', 'ab_tes_enqueue_style');








/**
 * Register a custom post type called "book".
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


function ab_testimonial_custom_box(){
    add_meta_box(
        '_ab_testimonials_info',      // Unique ID
        'Additional Information',    // Box title
        'ab_testimonials_box_html',  // Content callback, must be of type callable
        'abtestimonial',             // Post type
        'normal'                     // context
    );
}

add_action('add_meta_boxes', 'ab_testimonial_custom_box');


function ab_testimonials_box_html(){

    // global $post;

    // Use nonce for verification to secure data sending
    // wp_nonce_field( basename( __FILE__ ), 'wpse_our_nonce' );

    ?>

    <table class="form-table editcomment" role="presentation">
        <tbody>
            <tr>
                <td class="first">
                    <label for="name">Company Name</label>
                </td>
                <td>
                    <input type="text" class="widefat" name="abt_company_name" size="" value="" id="">
                </td>
            </tr>
            <tr>
                <td class="first">
                    <label for="email">Designation</label>
                </td>
                <td>
                    <input type="text" class="widefat" name="abt_designation" size="" value="" id="">
                </td>
            </tr>
        </tbody>
    </table>

    <?php
}

function ab_testimonial_post_save($post_id) {
    $ab_company_name = $_POST['abt_company_name'];
    $ab_designation = $_POST['abt_designation'];
    update_post_meta(
        $post_id,
        '_ab_testimonials_info',
        $ab_company_name
    );
    update_post_meta(
        $post_id,
        '_ab_testimonials_info',
        $ab_designation
    );
}

add_action('save_post', 'ab_testimonial_post_save');














function wporg_add_custom_box() {
    $screens = [ 'post', 'wporg_cpt' ];
    foreach ( $screens as $screen ) {
        add_meta_box(
            'wporg_box_id',                 // Unique ID
            'Custom Meta Box Title',      // Box title
            'wporg_custom_box_html',  // Content callback, must be of type callable
            $screen                            // Post type
        );
    }
}
add_action( 'add_meta_boxes', 'wporg_add_custom_box' );


//making the meta box (Note: meta box != custom meta field)
function wpse_add_custom_meta_box_2() {
   add_meta_box(
       'custom_meta_box-2',       // $id
       'Dauer2',                  // $title
       'show_custom_meta_box_2',  // $callback
       'abtestimonial',                 // $page
       'normal',                  // $context
       'high'                     // $priority
   );
}
add_action('add_meta_boxes', 'wpse_add_custom_meta_box_2');




//showing custom form fields
function show_custom_meta_box_2() {
    global $post;

    // Use nonce for verification to secure data sending
    wp_nonce_field( basename( __FILE__ ), 'wpse_our_nonce' );

    ?>

    <!-- my custom value input -->
    <input type="text" name="wpse_value" value="">

    <?php
}












/**
 * Setup query to show the ‘services’ post type with all posts filtered by 'home' category.
 * Output is linked title with featured image and excerpt.
 */
   
    // $args = array(  
    //     'post_type' => 'services',
    //     'post_status' => 'publish',
    //     'posts_per_page' => -1, 
    //     'orderby' => 'title', 
    //     'order' => 'ASC',
    //     'cat' => 'home',
    // );

    // $loop = new WP_Query( $args ); 
        
    // while ( $loop->have_posts() ) : $loop->the_post(); 
    //     $featured_img = wp_get_attachment_image_src( $post->ID );
    //     print the_title();
    //     if ( $feature_img ) {
    //        < img src="print $featured_img['url']" width=”print $featured_img['width']" height="print $featured_img['height']" />
    //     }
    //     the_excerpt(); 
    // endwhile;

    // wp_reset_postdata(); 



// // [bartag foo="foo-value"]
// function bartag_func( $atts ) {
//     $a = shortcode_atts( array(
//         'foo' => 'something',
//         'bar' => 'something else',
//     ), $atts );

//     return "foo = {$a['foo']}";
// }
// add_shortcode( 'bartag', 'bartag_func' );


// function query(){
//     ob_start();

//     $prefix = '_ab_prefix_';
//     $ab_testimonials = new WP_Query(array(
//         'post_type' => 'abtestimonial',
//         'posts_per_page' -1
//     ));

//     while($ab_testimonials->have_posts()) : $ab_testimonials->the_post();
//         ?>

//     <?php

//     endwhile;
//     return ob_get_clean();
// }
