<?php
//***********************                   tworzenie ankiety EQ-5D
add_action( 'init', 'rejsm_eq5d_init' );
function rejsm_eq5d_init() {
    $labels = array(
        'name'               => _x( 'Ankieta EQ-5D', 'post type general name', 'your-plugin-textdomain' ),
        'singular_name'      => _x( 'Ankieta', 'post type singular name', 'your-plugin-textdomain' ),
        'menu_name'          => _x( 'Ankiety EQ-5D', 'admin menu', 'your-plugin-textdomain' ),
        'name_admin_bar'     => _x( 'Ankietê EQ-5D', 'add new on admin bar', 'your-plugin-textdomain' ),
        'add_new'            => _x( 'Dodaj now¹ ankietê', 'book', 'your-plugin-textdomain' ),
        'add_new_item'       => __( 'Wype³nij now¹ ankietê EQ-5D', 'your-plugin-textdomain' ),
        'new_item'           => __( 'Nowa ankieta', 'your-plugin-textdomain' ),
        'edit_item'          => __( 'Edytuj ankietê', 'your-plugin-textdomain' ),
        'view_item'          => __( 'Zobacz ankietê', 'your-plugin-textdomain' ),
        'all_items'          => __( 'Wszystkie ankiety', 'your-plugin-textdomain' ),
        'search_items'       => __( 'Szukaj ankiety', 'your-plugin-textdomain' ),
        'parent_item_colon'  => __( 'Parent Books:', 'your-plugin-textdomain' ),
        'not_found'          => __( 'Nie znaleziono ankiety.', 'your-plugin-textdomain' ),
        'not_found_in_trash' => __( 'Nie znaleziono ankiety w koszu.', 'your-plugin-textdomain' ),
    );
    $args = array(
        'labels'             => $labels,
        'description'        => __( 'Skala wp³ywu stwardnienia rozsianego (EQ-5D).', 'your-plugin-textdomain' ),
        'public'             => false, //it's not public, it shouldn't have it's own permalink, and so on
        'exclude_from_search'=> true, // you should exclude it from search results
        'publicly_queryable' => false, // you should be able to query it
        'show_ui'            => true, // you should be able to edit it in wp-admin
        'show_in_menu'       => true,
        'show_in_nav_menus'  => false,  // you shouldn't be able to add it to menus
        'show_in_admin_bar'  => true,
        'menu_position'      => 102,
        'menu_icon'          => 'dashicons-pressthis',
        'query_var'          => false,
        'rewrite'            => false,
        'capability_type'    => 'post',
        'hierarchical'       => false,
        'has_archive'        => false,  // it shouldn't have archive page
        'rewrite'            => false,  // it shouldn't have rewrite rules
        'capabilities'       => array(
            'read_post'          => 'read_eq5d',
            'edit_post'          => 'edit_eq5d',
            'edit_posts'         => 'edit_eq5ds',
            'delete_posts'       => 'delete_eq5d',
            'edit_others_posts'  => 'edit_others_eq5d',
            'publish_posts'      => 'publish_eq5d',
            'read_private_posts' => 'read_private_eq5d',
            'create_posts'       => 'edit_eq5d',
        ),
        'supports'           => array( '' ),
    );
    register_post_type( 'eq5d', $args );
}




//***********************                   tworzenie ankiety MSIS_29  -> koniec




// **************************   Pole u¿ytkownika
function eq5d_lista_pytan ()
{
    $lista_pytan_eq5d = array(

        'Nie mam problemów z chodzeniem',
        'Mam trochê problemów z chodzeniem',
        'Jestem zmuszony pozostawaæ w ³ó¿ku',


        'Nie mam ¿adnych problemów z samoopiek¹',
        'Mam trochê problemów z myciem i ubieraniem siê',
        'Nie mogê sam siê umyæ ani ubraæ',

        'Nie mam problemów z wykonywaniem moich zwyk³ych czynnoœci',
        'Mam trochê problemów z wykonywaniem moich zwyk³ych czynnoœci',
        'Nie mogê wykonywaæ moich zwyk³ych czynnoœci',

        'Nie odczuwam bólu ani dyskomfortu',
        'Odczuwam umiarkowany ból lub dyskomfort',
        'Odczuwam krañcowy ból lub dyskomfort',

        'Nie jestem niespokojny ani przygnêbiony',
        'Jestem umiarkowanie niespokojny lub przygnêbiony',
        'Jestem krañcowo niespokojny lub przygnêbiony',
    );
    return $lista_pytan_eq5d;
}





add_action( 'add_meta_boxes', 'rejsm_eq5d_create' );
function rejsm_eq5d_create() {
    remove_meta_box('slugdiv', 'eq5d', 'normal');
	add_meta_box( 'eq5d_1', 'Zdolnoœæ poruszania siê', 'rejsm_eq5d_add_metabox_1', 'eq5d', 'normal', 'high' );
    add_meta_box( 'eq5d_2', 'Samoopieka', 'rejsm_eq5d_add_metabox_2', 'eq5d', 'normal', 'high' );
    add_meta_box( 'eq5d_3', 'Zwyk³a dzia³alnoœæ (np. praca, nauka, zajêcia domowe, aktywnoœæ rodzinna, zajêcia w czasie wolnym)', 'rejsm_eq5d_add_metabox_3', 'eq5d', 'normal', 'high' );
    add_meta_box( 'eq5d_4', 'Ból/Dyskomfort', 'rejsm_eq5d_add_metabox_4', 'eq5d', 'normal', 'high' );
    add_meta_box( 'eq5d_5', 'Niepokój/Przygnêbienie', 'rejsm_eq5d_add_metabox_5', 'eq5d', 'normal', 'high' );
    //    add_meta_box( 'eq5d_6', 'Twój aktualny stan zdrowia', 'rejsm_eq5d_add_metabox_6', 'eq5d', 'normal', 'high' );



}


function rejsm_eq5d_add_metabox_1( $post ) {
	print_eq5d($post, 1, 3, 1 );
}
function rejsm_eq5d_add_metabox_2( $post ) {
    print_eq5d($post, 4 , 3, 2);
}
function rejsm_eq5d_add_metabox_3( $post ) {
    print_eq5d($post, 7, 3, 3);
}
function rejsm_eq5d_add_metabox_4( $post ) {
    print_eq5d($post, 10, 3, 4);
}
function rejsm_eq5d_add_metabox_5( $post ) {
    print_eq5d($post, 13, 3, 5);
}
//

//parametr1 $post
//param2 nr pierwszego pytania
//par3 to liczba pytan
function print_eq5d ($post, $nr_pierwszego_pytania, $ile_pytan, $nr_pytania){
    $lista = eq5d_lista_pytan();

?>    <div class="ankieta"> <?php
    for ($i=$nr_pierwszego_pytania; $i<$nr_pierwszego_pytania+$ile_pytan; $i++) {
        $j = ($i -1)  % $ile_pytan;
        $wartosc_w_bazie_danych = get_post_meta( $post->ID, '_rejsm_eq5d_'.$nr_pytania , true );
                                ?> <p><label for=" <?php  echo $lista[$i-1] ?>"> <?php  echo $lista[$i-1] ?>
            <input id=" <?php  echo $lista[$i-1] ?>" class="msis_eq5d_check" name="rejsm_eq5d_<?php    echo $nr_pytania    ?>" value="<?php echo $j; ?>" type="radio" <?php checked( $wartosc_w_bazie_danych, $j );?> <?php if ($j == 0) echo 'checked'; ?> </input>
        </label></p>
        <?php
                                                                                                                                                                                                                            //        echo $j;
                                                                                                                                                                                                                            //        echo $wartosc_w_bazie_danych;
    }
        ?>    </div><?php
}

// Zaczep pozwalaj¹cy na zapis danych pola u¿ytkownika.
add_action( 'save_post', 'rejsm_eq5d_save_meta' );
function rejsm_eq5d_save_meta( $post_id ) {

    for ($i =1; $i<=5; $i++){
        $name='rejsm_eq5d_'.$i;
        if ( isset( $_POST[$name] ) ) {
            update_post_meta($post_id, '_'.$name, intval(strip_tags($_POST[$name])));
        }
    }
    $name2='eq5d_wynik';
    if ( isset( $_POST[$name2] ) ) {
        update_post_meta($post_id, '_'.$name2, intval(strip_tags($_POST[$name2])));
    }
}

add_action( 'admin_enqueue_scripts', 'rejsm_css_eq5d_custom_post_type_add_style');
function rejsm_css_eq5d_custom_post_type_add_style(){
    $handle = 'css_custom_post_type';
    $src =  '/wp-content/plugins/rejsm_superwtyczka/includes/css/css_custom_post_type.css';
    wp_enqueue_style( $handle, $src);
    //add_filter( 'wpcf7_support_html5_fallback', '__return_true' );
}

//function eq5d_29_get_result($post_id)
//{
//    for ($i =1; $i <= 6; $i++) {
//        $name = 'rejsm_eq5d_'.$i;
//        $name2 = '_'.$name;
//        if ( isset( $_POST[$name] ) ) {
//            update_post_meta( $post_id, $name2, strip_tags( $_POST[$name] ) );
////            $wynik = intval (strip_tags( $_POST[$name] ) );
//        }
//    }
////    return $wynik;
//}
//

function my_redirect_eq5d_after_save( $location, $post_id ) {
    if ( 'eq5d' == get_post_type( $post_id ) ) {
        $location = admin_url( 'edit.php?post_type=eq5d' );
    }
    return $location;
}

add_filter( 'redirect_post_location', 'my_redirect_eq5d_after_save' );



//***************************** dodaje style css
add_action( 'admin_enqueue_scripts', 'rejsm_eq5d_radio_button_css');
function rejsm_eq5d_radio_button_css(){
    $handle = 'rejsm_css';
    $src =  '/wp-content/plugins/rejsm_superwtyczka/includes/css/css_style_dane_demograficzne.css';
    wp_enqueue_style( $handle, $src);
}



//zmien automatycznie tytul ka¿dej ankiety
add_filter( 'wp_insert_post_data' , 'modify_eq5d_title' , '99', 1 ); // Grabs the inserted post data so you can modify it.
function modify_eq5d_title( $data )
{
    if ( $data['post_type'] == 'eq5d' ) {
        // If the actual field name of the rating date is different, you'll have to update this.
        //$date = date('m/d/Y h:i:s a', time());
        $typBadania = $data['post_type'];
        $autorid = $data['post_author'];
        $autor = get_userdata($autorid);
        $date = $data['post_date'];
        $title = 'Ankieta ' . $typBadania . '_' . $autor->user_login . '_' . $date;
        $data['post_title'] =  $title ; //Updates the post title to your new title.
    }
    return $data; // Returns the modified data.
}


//
//function add_housecategory_automatically($post_ID) {
//    global $wpdb;
//    if(!wp_is_post_revision($post_ID)) {
//        $housecat = array (5);
//        wp_set_object_terms( $post_ID, $housecat, 'kategoria_msis_29');
//    }
//}
//add_action('publish_msis_29', 'add_housecategory_automatically');




//***************************                           taksonomie i podpunkty ankiety

/**
 * Register 'kategoria_eq5d' custom taxonomy.
 */
add_action( 'init', 'register_kategoria_eq5d_taxonomy' );
function register_kategoria_eq5d_taxonomy() {
	$args = array(
		'label'             => __( 'Samopoczucie' ),
		'hierarchical'      => false,
		'show_ui'           => true,
		'show_admin_column' => true,
		'meta_box_cb'       => 'wynik_eq5d_meta_box',
        'show_admin_column ' => true,
	);
	register_taxonomy( 'kategoria_eq5d', 'eq5d', $args );
    //    register_taxonomy_for_object_type( 'kategoria_msis_29', 'msis_29' );

}

add_action( 'init', 'add_taxonomy_terms_eq5d_kategoria' );
function add_taxonomy_terms_eq5d_kategoria () {
    wp_insert_term ('bardzo z³e', 'kategoria_eq5d', array( 'description' => 'bardzo z³e samopoczucie', 'slug' => '1 – 25' ));
    wp_insert_term ('z³e', 'kategoria_eq5d', array( 'description' => 'z³e samopoczucie', 'slug' => '26 – 50' ));
    wp_insert_term ('dobre', 'kategoria_eq5d', array( 'description' => 'dobre samopoczucie', 'slug' => '51 – 75' ));
    wp_insert_term ('bardzo dobre', 'kategoria_eq5d', array( 'description' => 'bardzo dobre samopoczucie', 'slug' => '76 – 100' ));
}

/**
 * Display wynik meta box
 */
function wynik_eq5d_meta_box( $post ) {
    $wynik = get_post_meta( $post->ID, '_eq5d_wynik', true );
                ?>
    <span float="left" >Z³e  </span>
    <span float="center"> <input name="rejsm_eq5d_wynik"  type="range" min="1" max="100" value="<?php echo $wynik; ?>"> </input></span>
    <span float="right" >Dobre  </span>
<?php
}

//function eq5d_get_result($post_id)
//{
//    $wynik=0;
//    if ( isset( $_POST['rejsm_eq5d_wynik'] ) ) {
//        update_post_meta( $post_id, '_rejsm_eq5d_wynik', strip_tags( $_POST['rejsm_eq5d_wynik'] ) );
//        $wynik = intval (strip_tags( $_POST['rejsm_eq5d_wynik'] ) );
//    }
//    return $wynik;
//}

add_action( 'publish_eq5d', 'add_taxonomy_eq5d_to_post' );
function add_taxonomy_eq5d_to_post($post_id ) {
    //    $wynik = eq5d_get_result($post_id);
    $wynik=0;
    if ( isset( $_POST['rejsm_eq5d_wynik'] ) ) {
        $wynik = intval (strip_tags( $_POST['rejsm_eq5d_wynik'] ) );
    }
    $kategoria ='';
    if ( $wynik >= 1 && $wynik <= 25 ) $kategoria = 'bardzo z³e';
    if ( $wynik >= 26 && $wynik <= 50 ) $kategoria = 'z³e';
    if ( $wynik >= 51 && $wynik <= 75 ) $kategoria = 'dobre';
    if ( $wynik >= 76 && $wynik <= 100 ) $kategoria = 'bardzo dobre';

    wp_set_object_terms( $post_id, $kategoria, 'kategoria_eq5d',  false );
    update_post_meta($post_id, '_eq5d_wynik', $wynik );//strip_tags($_POST[$name3]));
}




add_filter( 'manage_edit-eq5d_columns', 'my_edit_eq5d_columns' ) ;
function my_edit_eq5d_columns( $columns ) {
    $columns = array(
        'cb' => '<input type="checkbox" />',
    );
    if( current_user_can('lekarz') || current_user_can('administrator') )  {
        $columns = array_merge(
            $columns,
            array(
                'author' => __( 'Pacjent' ),
        ));
    }
	$columns = array_merge($columns, array(

		//'title' => __( 'Tytu³' ),
//		'plec' => __( 'Wynik' ),

        'kategoria' => __( 'Samopoczucie' ),
        'eq5d_wynik' => __( 'Wynik samopoczucia' ),
		'date' => __( 'Date' )
	));
	return $columns;
}

add_action( 'manage_eq5d_posts_custom_column', 'my_manage_eq5d_columns', 10, 2 );
function my_manage_eq5d_columns( $column, $post_id ) {
	global $post;

	switch( $column ) {

        /* If displaying the 'duration' column. */
        case 'eq5d_wynik' :

            /* Get the post meta. */
            //$wynik = msis_29_get_result($post_id);
            $wynik = get_post_meta($post_id, '_eq5d_wynik', true);

            /* If no duration is found, output a default message. */
            if (is_null($wynik)) {
                $out = sprintf('<a href="%s">%s</a>',
                    esc_url(add_query_arg(array('post' => $post_id, 'action' => 'edit'), 'post.php')), 'N/A');
            }
			/* If there is a duration, append 'minutes' to the text string. */
			else {
                $out = sprintf('<a href="%s">%s</a>',
                    esc_url( add_query_arg( array( 'post' => $post_id, 'action' => 'edit' ), 'post.php' ) ), $wynik    );
                //                    esc_html( sanitize_term_field( 'name', $wynik->name, $term->term_id, 'wynik_msis_29', 'display' ) )

            }
            echo $out;
			break;

        /* If displaying the 'genre' column. */
        case 'kategoria' :

            /* Get the genres for the post. */
            $terms = get_the_terms( $post_id, 'kategoria_eq5d' );

            /* If terms were found. */
            if ( !empty( $terms ) ) {

                $out = array();

                /* Loop through each term, linking to the 'edit posts' page for the specific term. */
                foreach ( $terms as $term ) {
                    $out[] = sprintf( '<a href="%s">%s</a>',
                        esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'kategoria_eq5d' => $term->slug ), 'edit.php' ) ),
                        esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'kategoria_eq5d', 'display' ) )
                    );
                }

                /* Join the terms, separating them with a comma. */
                echo join( ', ', $out );
            }

            /* If no terms were found, output a default message. */
            else {
                _e( 'Brak wyniku' );
            }

            break;

        /* Just break out of the switch statement for everything else. */
        default :
            break;
	}
}












//************************* tworzenie sortowanej kolumny w widoku wszystkich ankiet

//
add_filter( 'manage_edit-eq5d_sortable_columns', 'eq5d_sortable_columns' );
function eq5d_sortable_columns( $columns ) {

    //	$columns['wynik_eq5d'] = 'wynik_eq5d';
    $columns['author'] = 'author';
    //    $columns['kategoria'] = 'kategoria';
    return $columns;
}

//
//
///* Only run our customization on the 'edit.php' page in the admin. */
//add_action( 'load-edit.php', 'my_edit_msis_29_load' );
//
//function my_edit_msis_29_load() {
//	add_filter( 'request', 'my_sort_msis_29' );
//}
//
///* Sorts the plec. */
//function my_sort_msis_29( $vars ) {
//
//	/* Check if we're viewing the 'dane_demograficzne' post type. */
//	if ( isset( $vars['post_type'] ) && 'msis_29' == $vars['post_type'] ) {
//
//		/* Check if 'orderby' is set to 'plec'. */
//		if ( isset( $vars['orderby'] ) && '_wynik_msis_29' == $vars['orderby'] ) {
//
//			/* Merge the query vars with our custom variables. */
//			$vars = array_merge(
//				$vars,
//				array(
//                    //'post_type' => 'msis_29',
//					'meta_key' => '_wynik_msis_29',
//					'orderby' => 'meta_value_num',// meta_value_num jeœli cyfra
//				)
//			);
//		}
//        if ( isset( $vars['orderby'] ) && 'kategoria' == $vars['orderby'] ) {
//
//            /* Merge the query vars with our custom variables. */
//            $vars = array_merge(
//                $vars,
//                array(
//                    //'post_type' => 'msis_29',
//                    'ff' => 'f',
//                    'orderby' => 'meta_value_num',// meta_value_num jeœli cyfra
//                )
//            );
//        }
//	}
//	return $vars;
//}

add_action( 'pre_get_posts', function( $query ) {

    //Note that current_user_can('edit_others_posts') check for
    //capability_type like posts, custom capabilities may be defined for custom posts
    if( is_admin() && ! current_user_can('edit_others_eq5d') && $query->is_main_query() ) {

        $query->set('author', get_current_user_id());

        //For standard posts
        add_filter('views_edit-eq5d', 'views_eq5d_filter_for_own_posts' );

        //For gallery post type
        //add_filter('views_edit-gallery', 'views_eq5d_filter_for_own_posts' );

        //You can add more similar filters for more post types with no extra changes
    }

} );

                                                                                                  function views_eq5d_filter_for_own_posts( $views ) {

                                                                                                      $post_type = get_query_var('post_type');
                                                                                                      $author = get_current_user_id();

                                                                                                      unset($views['mine']);

                                                                                                      $new_views = array(
                                                                                                          'all'       => __('All'),
                                                                                                          'publish'   => __('Published'),
                                                                                                          'private'   => __('Private'),
                                                                                                          'pending'   => __('Pending Review'),
                                                                                                          'future'    => __('Scheduled'),
                                                                                                          'draft'     => __('Draft'),
                                                                                                          'trash'     => __('Trash')
                                                                                                      );

                                                                                                      foreach( $new_views as $view => $name ) {

                                                                                                          $query = array(
                                                                                                              'author'      => $author,
                                                                                                              'post_type'   => $post_type
                                                                                                          );

                                                                                                          if($view == 'all') {

                                                                                                              $query['all_posts'] = 1;
                                                                                                              $class = ( get_query_var('all_posts') == 1 || get_query_var('post_status') == '' ) ? ' class="current"' : '';
                                                                                                              $url_query_var = 'all_posts=1';

                                                                                                          } else {

                                                                                                              $query['post_status'] = $view;
                                                                                                              $class = ( get_query_var('post_status') == $view ) ? ' class="current"' : '';
                                                                                                              $url_query_var = 'post_status='.$view;

                                                                                                          }

                                                                                                          $result = new WP_Query($query);

                                                                                                          if($result->found_posts > 0) {

                                                                                                              $views[$view] = sprintf(
                                                                                                                  '<a href="%s"'. $class .'>'.__($name).' <span class="count">(%d)</span></a>',
                                                                                                                  admin_url('edit.php?'.$url_query_var.'&post_type='.$post_type),
                                                                                                                  $result->found_posts
                                                                                                              );

                                                                                                          } else {

                                                                                                              unset($views[$view]);

                                                                                                          }

                                                                                                      }

                                                                                                      return $views;
                                                                                                  }



                                                                                                  //***********************                   tworzenie ankiety -> koniec

















                                                                                                  //***********        dotyczy zak³adki 'POMOC'



                                                                                                  //wyœwietla pomoc
                                                                                                  add_action( 'contextual_help', 'eq5d_codex_add_help_text', 10, 3 );
                                                                                                  function eq5d_codex_add_help_text( $contextual_help, $screen_id, $screen ) {
                                                                                                      //$contextual_help .= var_dump( $screen ); // use this to help determine $screen->id
                                                                                                      if ( 'msis_29' == $screen->id ) {
                                                                                                          $contextual_help =
                                                                                                            '<ul>' .
                                                                                                            '<li>' . __('Poni¿sze pytania dotycz¹ Pani/Pana zdania na temat wp³ywu stwardnienia rozsianego na Pani/Pana ¿ycie codzienne w ci¹gu ostatnich 14 dni', 'your_text_domain') . '</li>' .
                                                                                                            '<li>' . __('Przy ka¿dym pytaniu proszê zaznaczyæ jedn¹ cyfrê, która najlepiej opisuje Pani/Pana sytuacjê.', 'your_text_domain') . '</li>' .
                                                                                                            '<li>' . __('Prosimy odpowiedzieæ na wszystkie pytania.', 'your_text_domain') . '</li>' .
                                                                                                            '</ul>';

                                                                                                      } elseif ( 'edit-eq5d' == $screen->id ) {
                                                                                                          $contextual_help =
                                                                                                            '<p>' . __('To jest ekran pomocy wyœwietlania tabeli zawartoœci ankiet.', 'your_text_domain') . '</p>' ;
                                                                                                      }
                                                                                                      return $contextual_help;
                                                                                                  }
                                                                                                  //wyœwietla pomoc
                                                                                                  add_action('admin_head', 'eq5d_codex_custom_help_tab');
                                                                                                  function eq5d_codex_custom_help_tab() {

                                                                                                      $screen = get_current_screen();

                                                                                                      // Return early if we're not on the book post type.
                                                                                                      if ( 'msis_29' != $screen->post_type )
                                                                                                          return;

                                                                                                      // Setup help tab args.
                                                                                                      $args = array(
                                                                                                        'id'      => 'eq5d', //unique id for the tab
                                                                                                        'title'   => 'Pomoc', //unique visible title for the tab
                                                                                                        'content' => '<h3>Pomoc</h3><p>Jak nie wiesz jak wype³niæ t¹ ankiete skontaktuj siê ze swoim lekarzem.</p>',  //actual help text
                                                                                                      );
                                                                                                      
                                                                                                      // Add the help tab.
                                                                                                      $screen->add_help_tab( $args );
                                                                                                  }


                                                                                                  //private post 
                                                                                                  add_action( 'transition_post_status', 'eq5d_post_status_new', 10, 3 );
                                                                                                  function eq5d_post_status_new( $new_status, $old_status, $post ) {
                                                                                                      if ( $post->post_type == 'dane_demograficzne' && $new_status == 'publish' && $old_status  != $new_status ) {
                                                                                                          $post->post_status = 'private';
                                                                                                          wp_update_post( $post );
                                                                                                      }
                                                                                                  } 
                                                                                                  //private post - interface
                                                                                                  add_action( 'post_submitbox_misc_actions' , 'eq5d_change_visibility_metabox' );
                                                                                                  function eq5d_change_visibility_metabox(){
                                                                                                      global $post;
                                                                                                      if ($post->post_type != 'eq5d')
                                                                                                          return;
                                                                                                      $message = __('<strong>Note:</strong> Publikowane ankiety s¹ zawsze <strong>prywatne</strong>.');
                                                                                                      $post->post_password = '';
                                                                                                      $visibility = 'private';
                                                                                                      $visibility_trans = __('Private');

                                                                                                      global $_wp_admin_css_colors;
                                                                                                      global $admin_colors; // only needed if colors must be available in classes
                                                                                                      $admin_colors = $_wp_admin_css_colors;
?>
    <style type="text/css">
        .priv_pt_note {
            background-color: <?php $admin_colors; ?>
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








                                                                                                  //***********        dotyczy zak³adki 'pomoc'              ->koniec






                                                                                                  //
                                                                                                  //// Show only posts and media related to logged in author
                                                                                                  //add_action('pre_get_posts', 'query_set_only_author' );
                                                                                                  //function query_set_only_author( $wp_query ) {
                                                                                                  //    global $current_user;
                                                                                                  //    if( is_admin() && !current_user_can('edit_others_posts') ) {
                                                                                                  //        $wp_query->set( 'author', $current_user->ID );
                                                                                                  //        add_filter('views_edit-post', 'fix_post_counts');
                                                                                                  //        add_filter('views_upload', 'fix_media_counts');
                                                                                                  //    }
                                                                                                  //}
                                                                                                  //
                                                                                                  //// Fix post counts
                                                                                                  //function fix_post_counts($views) {
                                                                                                  //    global $current_user, $wp_query;
                                                                                                  //    unset($views['mine']);
                                                                                                  //    $types = array(
                                                                                                  //        array( 'status' =>  NULL ),
                                                                                                  //        array( 'status' => 'publish' ),
                                                                                                  //        array( 'status' => 'draft' ),
                                                                                                  //        array( 'status' => 'pending' ),
                                                                                                  //        array( 'status' => 'trash' )
                                                                                                  //    );
                                                                                                  //    foreach( $types as $type ) {
                                                                                                  //        $query = array(
                                                                                                  //            'author'      => $current_user->ID,
                                                                                                  //            'post_type'   => 'msis_29',
                                                                                                  //            'post_status' => $type['status']
                                                                                                  //        );
                                                                                                  //        $result = new WP_Query($query);
                                                                                                  //        if( $type['status'] == NULL ):
                                                                                                  //            $class = ($wp_query->query_vars['post_status'] == NULL) ? ' class="current"' : '';
                                                                                                  //            $views['all'] = sprintf(
                                                                                                  //                '<a href="%1$s"%2$s>%4$s <span class="count">(%3$d)</span></a>',
                                                                                                  //                admin_url('edit.php?post_type=post'),
                                                                                                  //                $class,
                                                                                                  //                $result->found_posts,
                                                                                                  //                __('All')
                                                                                                  //            );
                                                                                                  //        elseif( $type['status'] == 'publish' ):
                                                                                                  //            $class = ($wp_query->query_vars['post_status'] == 'publish') ? ' class="current"' : '';
                                                                                                  //            $views['publish'] = sprintf(
                                                                                                  //                '<a href="%1$s"%2$s>%4$s <span class="count">(%3$d)</span></a>',
                                                                                                  //                admin_url('edit.php?post_type=post'),
                                                                                                  //                $class,
                                                                                                  //                $result->found_posts,
                                                                                                  //                __('Publish')
                                                                                                  //            );
                                                                                                  //        elseif( $type['status'] == 'draft' ):
                                                                                                  //            $class = ($wp_query->query_vars['post_status'] == 'draft') ? ' class="current"' : '';
                                                                                                  //            $views['draft'] = sprintf(
                                                                                                  //                '<a href="%1$s"%2$s>%4$s <span class="count">(%3$d)</span></a>',
                                                                                                  //                admin_url('edit.php?post_type=post'),
                                                                                                  //                $class,
                                                                                                  //                $result->found_posts,
                                                                                                  //                __('Draft')
                                                                                                  //            );
                                                                                                  //        elseif( $type['status'] == 'pending' ):
                                                                                                  //            $class = ($wp_query->query_vars['post_status'] == 'pending') ? ' class="current"' : '';
                                                                                                  //            $views['pending'] = sprintf(
                                                                                                  //                '<a href="%1$s"%2$s>%4$s <span class="count">(%3$d)</span></a>',
                                                                                                  //                admin_url('edit.php?post_type=post'),
                                                                                                  //                $class,
                                                                                                  //                $result->found_posts,
                                                                                                  //                __('Pending')
                                                                                                  //            );
                                                                                                  //        elseif( $type['status'] == 'trash' ):
                                                                                                  //            $class = ($wp_query->query_vars['post_status'] == 'trash') ? ' class="current"' : '';
                                                                                                  //            $views['trash'] = sprintf(
                                                                                                  //                '<a href="%1$s"%2$s>%4$s <span class="count">(%3$d)</span></a>',
                                                                                                  //                admin_url('edit.php?post_type=post'),
                                                                                                  //                $class,
                                                                                                  //                $result->found_posts,
                                                                                                  //                __('Trash')
                                                                                                  //            );
                                                                                                  //        endif;
                                                                                                  //    }
                                                                                                  //    return $views;
                                                                                                  //}
                                                                                                  //
                                                                                                  //// Fix media counts
                                                                                                  //function fix_media_counts($views) {
                                                                                                  //    global $wpdb, $current_user, $post_mime_types, $avail_post_mime_types;
                                                                                                  //    $views = array();
                                                                                                  //    $count = $wpdb->get_results( "
                                                                                                  //        SELECT post_mime_type, COUNT( * ) AS num_posts
                                                                                                  //        FROM $wpdb->posts
                                                                                                  //        WHERE post_type = 'attachment'
                                                                                                  //        AND post_author = $current_user->ID
                                                                                                  //        AND post_status != 'trash'
                                                                                                  //        GROUP BY post_mime_type
                                                                                                  //    ", ARRAY_A );
                                                                                                  //    foreach( $count as $row )
                                                                                                  //        $_num_posts[$row['post_mime_type']] = $row['num_posts'];
                                                                                                  //    $_total_posts = array_sum($_num_posts);
                                                                                                  //    $detached = isset( $_REQUEST['detached'] ) || isset( $_REQUEST['find_detached'] );
                                                                                                  //    if ( !isset( $total_orphans ) )
                                                                                                  //        $total_orphans = $wpdb->get_var("
                                                                                                  //            SELECT COUNT( * )
                                                                                                  //            FROM $wpdb->posts
                                                                                                  //            WHERE post_type = 'attachment'
                                                                                                  //            AND post_author = $current_user->ID
                                                                                                  //            AND post_status != 'trash'
                                                                                                  //            AND post_parent < 1
                                                                                                  //        ");
                                                                                                  //    $matches = wp_match_mime_types(array_keys($post_mime_types), array_keys($_num_posts));
                                                                                                  //    foreach ( $matches as $type => $reals )
                                                                                                  //        foreach ( $reals as $real )
                                                                                                  //            $num_posts[$type] = ( isset( $num_posts[$type] ) ) ? $num_posts[$type] + $_num_posts[$real] : $_num_posts[$real];
                                                                                                  //    $class = ( empty($_GET['post_mime_type']) && !$detached && !isset($_GET['status']) ) ? ' class="current"' : '';
                                                                                                  //    $views['all'] = "<a href='upload.php'$class>" . sprintf( __('All <span class="count">(%s)</span>', 'uploaded files' ), number_format_i18n( $_total_posts )) . '</a>';
                                                                                                  //    foreach ( $post_mime_types as $mime_type => $label ) {
                                                                                                  //        $class = '';
                                                                                                  //        if ( !wp_match_mime_types($mime_type, $avail_post_mime_types) )
                                                                                                  //            continue;
                                                                                                  //        if ( !empty($_GET['post_mime_type']) && wp_match_mime_types($mime_type, $_GET['post_mime_type']) )
                                                                                                  //            $class = ' class="current"';
                                                                                                  //        if ( !empty( $num_posts[$mime_type] ) )
                                                                                                  //            $views[$mime_type] = "<a href='upload.php?post_mime_type=$mime_type'$class>" . sprintf( translate_nooped_plural( $label[2], $num_posts[$mime_type] ), $num_posts[$mime_type] ) . '</a>';
                                                                                                  //    }
                                                                                                  //    $views['detached'] = '<a href="upload.php?detached=1"' . ( $detached ? ' class="current"' : '' ) . '>' . sprintf( __( 'Unattached <span class="count">(%s)</span>', 'detached files' ), $total_orphans ) . '</a>';
                                                                                                  //    return $views;
                                                                                                  //}


    ?>