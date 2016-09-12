<?php
/*
Plugin Name: Dane demograficzne i taksonomie
Plugin URI: https://github.com/mrevening/freshpress_plugins
Description: Dodaje nowy typ wpisu - dane demograficzne, oraz związane z tym typem taksonomie
Version: 0.1
Author: Dominik Wieczorek
Author URI: https://github.com/mrevening/
License: GPLv2
 */


add_action( 'init', 'rejsm_register_dane_demograficzne_post_type' );
function rejsm_register_dane_demograficzne_post_type() {

    register_post_type( 'dane_demograficzne', array (
        'public' => true,
        'query_var' => 'dane_demograficzne',
        'rewrite' => array(
            'slug' => 'dane_demograficzne',
            'with_front' => false,
        ),
        'menu_position' => 3,
        'menu_icon' => 'dashicons-edit',
        'supports' => array(
            //'title'//,
            //'thumbnail'
        ),
        'labels' => array(
            'name' => 'Dane demograficzne',
            'singular_name' => 'Dana demograficzna',
            'add_new' => 'Dodaj nową',
            'add_new_item' => 'Dodaj nową daną demograficzną',
            'edit_item' => 'Edytuj dane demograficzne',
            'new_item' => 'Nowa dana demograficzna',
            'view_item' => 'Wyświetl dana demograficzną',
            'search_items' => 'Szukaj w danych demograficznych',
            'not_found' => 'Nie znaleziono danych demograficznych',
            'not_found_in_trash' => 'Nie znaleziono danych demograficznych w koszu',
            'name_admin_bar' => 'Daną demograficzną',
            'all_items' => "Wszystkie"
        ),
        'description' => 'Zbiór informacji prywatnych o pacjentach.',
    ) ); 
}



/**
 * Register 'plec' custom taxonomy.
 */
function register_plec_taxonomy() {
	$args = array(
		'label'             => __( 'Płeć' ),
		'hierarchical'      => false,
		'show_ui'           => true,
		'show_admin_column' => true,
		'meta_box_cb'       => 'plec_meta_box',
	);
	register_taxonomy( 'plec', 'dane_demograficzne', $args );
}
add_action( 'init', 'register_plec_taxonomy' );


/**
 * Display plec meta box
 */
function plec_meta_box( $post ) {
	$terms = get_terms( 'plec', array( 'hide_empty' => false ) );
	$post  = get_post();
	$rating = wp_get_object_terms( $post->ID, 'plec', array( 'orderby' => 'term_id', 'order' => 'ASC' ) );
	$name  = '';
    if ( ! is_wp_error( $rating ) ) {
    	if ( isset( $rating[0] ) && isset( $rating[0]->name ) ) {
			$name = $rating[0]->name;
	    }
    }
	foreach ( $terms as $term ) {
?>
		<label title='<?php esc_attr_e( $term->name ); ?>'>
		    <input type="radio" name="tax_input[plec]" value="<?php esc_attr_e( $term->name ); ?>" <?php checked( $term->name, $name ); ?>>
			<span><?php esc_html_e( $term->name ); ?></span>
		</label><br>
<?php
    }
}

add_action( 'init', 'add_taxonomy_terms_plec' );
function add_taxonomy_terms_plec () {
    wp_insert_term ('mężczyzna', 'plec');
    wp_insert_term ('kobieta', 'plec');
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


///**
// * Display an error message at the top of the post edit screen explaining that ratings is required.
// *
// * Doing this prevents users from getting confused when their new posts aren't published, as we
// * require a valid rating custom taxonomy.
// *
// * @param WP_Post The current post object.
// */
//function show_required_field_error_msg( $post ) {
//    if ( 'movie' === get_post_type( $post ) && 'auto-draft' !== get_post_status( $post ) ) {
//        $rating = wp_get_object_terms( $post->ID, 'movie_rating', array( 'orderby' => 'term_id', 'order' => 'ASC' ) );
//        if ( is_wp_error( $rating ) || empty( $rating ) ) {
//            printf(
//                '<div class="error below-h2"><p>%s</p></div>',
//                esc_html__( 'Rating is mandatory for creating a new movie post' )
//            );
//        }
//    }
//}
//// Unfortunately, 'admin_notices' puts this too high on the edit screen
//add_action( 'edit_form_top', 'show_required_field_error_msg' );


add_filter( 'manage_edit-dane_demograficzne_columns', 'my_edit_dane_demograficzne_columns' ) ;
function my_edit_dane_demograficzne_columns( $columns ) {

	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Pesel' ),
		'plec' => __( 'Płeć' ),
        'miejsce_zamieszkania' => __( 'Miejsce zamieszkania' ),
		'date' => __( 'Date' )
	);

	return $columns;
}

add_action( 'manage_dane_demograficzne_posts_custom_column', 'my_manage_dane_demograficzne_columns', 10, 2 );
function my_manage_dane_demograficzne_columns( $column, $post_id ) {
	global $post;

	switch( $column ) {

		/* If displaying the 'duration' column. */
		case 'niewasadfljalsfjlajf' :

			/* Get the post meta. */
			$plec = get_post_meta( $post_id, 'plec', true );

			/* If no duration is found, output a default message. */
			if ( empty( $plec ) )
				echo __( 'Unknown' );

			/* If there is a duration, append 'minutes' to the text string. */
			else
				echo  $plec ;

			break;

        /* If displaying the 'genre' column. */
        case 'plec' :

            /* Get the genres for the post. */
            $terms = get_the_terms( $post_id, 'plec' );

            /* If terms were found. */
            if ( !empty( $terms ) ) {

                $out = array();

                /* Loop through each term, linking to the 'edit posts' page for the specific term. */
                foreach ( $terms as $term ) {
                    $out[] = sprintf( '<a href="%s">%s</a>',
                        esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'plec' => $term->slug ), 'edit.php' ) ),
                        esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'plec', 'display' ) )
                    );
                }

                /* Join the terms, separating them with a comma. */
                echo join( ', ', $out );
            }

            /* If no terms were found, output a default message. */
            else {
                _e( 'No Genres' );
            }

            break;

        /* Just break out of the switch statement for everything else. */
        default :
            break;
	}
}

add_filter( 'manage_edit-dane_demograficzne_sortable_columns', 'dane_demograficzne_sortable_columns' );
function dane_demograficzne_sortable_columns( $columns ) {

	$columns['plec'] = 'plec';

	return $columns;
}

/* Only run our customization on the 'edit.php' page in the admin. */
//add_action( 'load-edit.php', 'my_edit_dane_demograficzne_load' );

function my_edit_dane_demograficzne_load() {
	add_filter( 'request', 'my_sort_dane_demograficzne' );
}

/* Sorts the plec. */
function my_sort_dane_demograficzne( $vars ) {

	/* Check if we're viewing the 'dane_demograficzne' post type. */
	if ( isset( $vars['post_type'] ) && 'dane_demograficzne' == $vars['post_type'] ) {

		/* Check if 'orderby' is set to 'plec'. */
		if ( isset( $vars['orderby'] ) && 'plec' == $vars['orderby'] ) {

			/* Merge the query vars with our custom variables. */
			$vars = array_merge(
				$vars,
				array(
                    'post_type' => 'dane_demograficzne',
					'meta_key' => 'plec',
					'orderby' => 'meta_value',// meta_value_num jeśli cyfra
				)
			);
		}
	}

	return $vars;
}




//add_action( 'post_creation_limits_custom_checks', 'post_per_day_limit' );

//function post_per_author_limit( $type, $user_id ) {
//    global $wpdb;

//    $time_in_days = 1; // 1 means in last day
//    $count = $wpdb->get_var(
//        $wpdb->prepare("
//            SELECT COUNT(*) 
//            FROM $wpdb->posts 
//            WHERE post_status = 'publish' 
//            AND post_type = %s 
//            AND post_author = %s",
//            $type,
//            $user_id
//        )
//    );
//    if ( 1 < $count ) {
//        // return limit reached message using the plugin class
//        exit( $bapl->bapl_not_allowed( 'you can not posts more them two posts a day' ) );
//    }
//}


//private post 
add_action( 'transition_post_status', 'wpse118970_post_status_new', 10, 3 );
function wpse118970_post_status_new( $new_status, $old_status, $post ) { 
    if ( $post->post_type == 'dane_demograficzne' && $new_status == 'publish' && $old_status  != $new_status ) {
        $post->post_status = 'private';
        wp_update_post( $post );
    }
} 
//private post - interface
add_action( 'post_submitbox_misc_actions' , 'wpse118970_change_visibility_metabox' );
function wpse118970_change_visibility_metabox(){
    global $post;
    if ($post->post_type != 'dane_demograficzne')
        return;
        $message = __('<strong>Note:</strong> Published posts are always <strong>private</strong>.');
        $post->post_password = '';
        $visibility = 'private';
        $visibility_trans = __('Private');
    ?>
    <style type="text/css">
        .priv_pt_note {
            background-color: lightgreen;
            border: 1px solid green;
            border-radius: 2px;
            margin: 4px;
            padding: 4px;
        }
    </style>
    <script type="text/javascript">
        (function($){
            try {
                $('#post-visibility-display').text('<?php echo $visibility_trans; ?>');
                $('#hidden-post-visibility').val('<?php echo $visibility; ?>');
            } catch(err){}
        }) (jQuery);
    </script>
    <div class="priv_pt_note">
        <?php echo $message; ?>
    </div>
    <?php
}

?>