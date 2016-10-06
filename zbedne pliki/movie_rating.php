<?php
/*
Plugin Name: movie rating
Plugin URI: https://github.com/mrevening/freshpress_plugins
Description: Dodaje nowy typ wpisu - dane demograficzne
Version: 0.1
Author: Dominik Wieczorek
Author URI: https://github.com/mrevening/
License: GPLv2
 */
/**
 * Register 'Movie Rating' custom taxonomy.
 */
function register_movie_rating_taxonomy() {
	$args = array(
		'label'             => __( 'Rating' ),
		'hierarchical'      => false,
		'show_ui'           => true,
		'show_admin_column' => true,
		'meta_box_cb'       => 'movie_rating_meta_box',
	);
	register_taxonomy( 'movie_rating', 'dane_demograficzne', $args );
}
add_action( 'init', 'register_movie_rating_taxonomy' );


/**
 * Display Movie Rating meta box
 */
function movie_rating_meta_box( $post ) {
	$terms = get_terms( 'movie_rating', array( 'hide_empty' => false ) );
	$post  = get_post();
	$rating = wp_get_object_terms( $post->ID, 'movie_rating', array( 'orderby' => 'term_id', 'order' => 'ASC' ) );
	$name  = '';
    if ( ! is_wp_error( $rating ) ) {
    	if ( isset( $rating[0] ) && isset( $rating[0]->name ) ) {
			$name = $rating[0]->name;
	    }
    }
	foreach ( $terms as $term ) {
?>
		<label title='<?php esc_attr_e( $term->name ); ?>'>
		    <input type="radio" name="tax_input[movie_rating]" value="<?php esc_attr_e( $term->name ); ?>" <?php checked( $term->name, $name ); ?>>
			<span><?php esc_html_e( $term->name ); ?></span>
		</label><br>
<?php
    }
}


///**
// * Save the movie meta box results.
// *
// * @param int $post_id The ID of the post that's being saved.
// */
//function save_movie_rating_meta_box( $post_id ) {
//    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
//        return;
//    }
//    if ( ! isset( $_POST['movie_rating'] ) ) {
//        return;
//    }
//    $rating = sanitize_text_field( $_POST['movie_rating'] );
	
//    // A valid rating is required, so don't let this get published without one
//    if ( empty( $rating ) ) {
//        // unhook this function so it doesn't loop infinitely
//        remove_action( 'save_post_movie', 'save_movie_rating_meta_box' );
//        $postdata = array(
//            'ID'          => $post_id,
//            'post_status' => 'draft',
//        );
//        wp_update_post( $postdata );
//    } else {
//        $term = get_term_by( 'name', $rating, 'movie_rating' );
//        if ( ! empty( $term ) && ! is_wp_error( $term ) ) {
//            wp_set_object_terms( $post_id, $term->term_id, 'movie_rating', false );
//        }
//    }
//}
//add_action( 'save_post_movie', 'save_movie_rating_meta_box' );


/**
 * Display an error message at the top of the post edit screen explaining that ratings is required.
 *
 * Doing this prevents users from getting confused when their new posts aren't published, as we
 * require a valid rating custom taxonomy.
 *
 * @param WP_Post The current post object.
 */
function show_required_field_error_msg( $post ) {
	if ( 'movie' === get_post_type( $post ) && 'auto-draft' !== get_post_status( $post ) ) {
	    $rating = wp_get_object_terms( $post->ID, 'movie_rating', array( 'orderby' => 'term_id', 'order' => 'ASC' ) );
        if ( is_wp_error( $rating ) || empty( $rating ) ) {
			printf(
				'<div class="error below-h2"><p>%s</p></div>',
				esc_html__( 'Rating is mandatory for creating a new movie post' )
			);
		}
	}
}
// Unfortunately, 'admin_notices' puts this too high on the edit screen
add_action( 'edit_form_top', 'show_required_field_error_msg' );


add_action( 'init', 'add_taxonomy_terms_movie' );
function add_taxonomy_terms_movie () {
    wp_insert_term ('yes', 'movie_rating');
    wp_insert_term ('no', 'movie_rating');
}

?>