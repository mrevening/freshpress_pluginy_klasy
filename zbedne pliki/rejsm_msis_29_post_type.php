<?php

//***********************                   tworzenie ankiety MSIS_29 
add_action( 'init', 'rejsm_msis_29_init' );
function rejsm_msis_29_init() {
    $labels = array(
        'name'               => _x( 'Ankieta MSIS-29', 'post type general name', 'your-plugin-textdomain' ),
        'singular_name'      => _x( 'Ankieta', 'post type singular name', 'your-plugin-textdomain' ),
        'menu_name'          => _x( 'Ankiety MSIS-29', 'admin menu', 'your-plugin-textdomain' ),
        'name_admin_bar'     => _x( 'Ankietę MSIS-29', 'add new on admin bar', 'your-plugin-textdomain' ),
        'add_new'            => _x( 'Dodaj nową ankietę', 'book', 'your-plugin-textdomain' ),
        'add_new_item'       => __( 'Wypełnij nową ankietę MSIS 29', 'your-plugin-textdomain' ),
        'new_item'           => __( 'Nowa ankieta', 'your-plugin-textdomain' ),
        'edit_item'          => __( 'Edytuj ankietę', 'your-plugin-textdomain' ),
        'view_item'          => __( 'Zobacz ankietę', 'your-plugin-textdomain' ),
        'all_items'          => __( 'Wszystkie ankiety', 'your-plugin-textdomain' ),
        'search_items'       => __( 'Szukaj ankiety', 'your-plugin-textdomain' ),
        'parent_item_colon'  => __( 'Parent Books:', 'your-plugin-textdomain' ),
        'not_found'          => __( 'Nie znaleziono ankiety.', 'your-plugin-textdomain' ),
        'not_found_in_trash' => __( 'Nie znaleziono ankiety w koszu.', 'your-plugin-textdomain' ),
    );
    $args = array(
        'labels'             => $labels,
        'description'        => __( 'Skala wpływu stwardnienia rozsianego (MSIS-29).', 'your-plugin-textdomain' ),
        'public'             => false, //it's not public, it shouldn't have it's own permalink, and so on
        'exclude_from_search'=> true, // you should exclude it from search results
        'publicly_queryable' => false, // you should be able to query it
        'show_ui'            => true, // you should be able to edit it in wp-admin
        'show_in_menu'       => true,
        'show_in_nav_menus'  => false,  // you shouldn't be able to add it to menus
        'show_in_admin_bar'  => true,
        'menu_position'      => 101,
        'menu_icon'          => 'dashicons-clipboard',
        'query_var'          => false,
        'rewrite'            => false,
        'capability_type'    => 'post',
        'hierarchical'       => false,
        'has_archive'        => false,  // it shouldn't have archive page
        'rewrite'            => false,  // it shouldn't have rewrite rules
        'capabilities'       => array(
            'read_post'          => 'read_msis_29',
            'edit_post'          => 'edit_msis_29',
            'edit_posts'         => 'edit_msis_29s',
            'delete_posts'       => 'delete_msis_29',
            'edit_others_posts'  => 'edit_others_msis_29',
            'publish_posts'      => 'publish_msis_29',
            'read_private_posts' => 'read_private_msis_29',
            'create_posts'       => 'edit_msis_29',
        ),
        'supports'           => array( '' ),
    );
    register_post_type( 'msis_29', $args );

}




//***********************                   tworzenie ankiety MSIS_29  -> koniec




// **************************   Pole użytkownika
function msis_29_lista_pytan ()
{
    $lista_pytan_msis_29 = array(
        'Wykonywania czynności wymagających wysiłku fizycznego:',
        'Silnego chwytania przedmiotów (np. odkręcania kurków):',
        'Noszenia przedmiotów ?',

        'Problemy z równowagą ?',
        'Trudności z poruszaniem się w pomieszczeniach ?',
        'Niezręczność:',
        'Sztywność:',
        'Uczucie ciężkości rąk i/lub nóg:',
        'Drżenie rąk lub nóg:',
        'Kurcze rąk lub nóg:',
        'Brak kontroli nad swoim ciałem:',
        'Zależność od innych związana z wykonywaniem różnych czynności za Pana/Panią:',

        'Ograniczenia odwiedzin w Pani/Pana domu oraz czynności wykonywanych w czasie wolnym:',
        'Konieczność pozostania w domu dłużej niż by Pan/Pani sobie życzył/a:',
        'Trudności z używaniem rąk w codziennych czynnościach:',
        'Konieczność ograniczenia czasu, który Pan/i poświęca na pracę lub inne czynności codzienne:',
        'Trudności w korzystaniu środków transportu (np. samochodu, autobusu, pociągu, taksówki itp.):',
        'Dłuższy niż normalnie czas wykonywaniu czynności:',
        'Trudności ze spontanicznym wykonywaniem czynności (np. pójcie gdzieś pod wpływem impulsu chwili):',
        'Nagła potrzeba pójścia do toalety:',
        'Złe samopoczucie:',
        'Problemy ze snem :',
        'Poczucie psychicznego zmęczenia :',
        'Obawy związane z Pani/Pana chorobą (SM):',
        'Uczucie niepokoju lub napięcia :',
        'Uczucie rozdrażnienia, zniecierpliwienia lub wybuchowość:',
        'Problemy z koncentracją uwagi:',
        'Brak pewności siebie :',
        'Uczucie depresji :',
    );
    return $lista_pytan_msis_29;
}





add_action( 'add_meta_boxes', 'rejsm_msis_29_create' );
function rejsm_msis_29_create() {
	// Utworzenie własnego pola użytkownika.
    remove_meta_box('slugdiv', 'msis_29', 'normal');
//    remove_meta_box('submitdiv', 'msis_29', 'normal');
    add_meta_box( 'msis_29_1', 'W ciągu ostatnich 14 dni jak bardzo stwardnienie rozsiane ograniczyło Pani/Pana zdolność do:', 'rejsm_msis_29_add_metabox_1', 'msis_29', 'normal', 'high' );
	add_meta_box( 'msis_29_2', 'Wciągu ostatnich 14 dni jak bardzo przeszkadzały Pani/Panu:', 'rejsm_msis_29_add_metabox_2', 'msis_29', 'normal', 'high' );
    add_meta_box( 'msis_29_3', 'Wciągu ostatnich 14 dni jak bardzo przeszkadzały Pani/Panu:', 'rejsm_msis_29_add_metabox_3', 'msis_29', 'normal', 'high' );
//    add_meta_box( 'submitdiv', 'Publikuj', 'rejsm_msis_29_add_publish_metabox', 'msis_29', 'side', 'low' );

}


function rejsm_msis_29_add_metabox_1( $post ) {
	print_msis_29($post, 1, 3);
}
function rejsm_msis_29_add_metabox_2( $post ) {
    print_msis_29($post, 4 , 9);
}
function rejsm_msis_29_add_metabox_3( $post ) {
    print_msis_29($post, 13, 17);
}

//function rejsm_msis_29_add_publish_metabox ( $post) {
//    ?>
<!--    <div id="submit-div" class="postbox">-->
<!--    <div class="inside"-->
<!--    <div id="major-publishing-actions">-->
<!--        <div id="publishing-action">-->
<!--            <input id="" >-->
<!--            <input id="publish" class="button-primary button-large" name="publish" value="Opublikuj" type="submit"</input>-->
<!--        </div>-->
<!--    </div>-->
<!--    </div>-->
<!--    </div>-->
<!---->
<!--    --><?php
           //}

           add_action( 'admin_enqueue_scripts', 'rejsm_css_custom_post_type_add_style');
           function rejsm_css_custom_post_type_add_style(){
               $handle = 'css_custom_post_type';
               $src =  '/wp-content/plugins/rejsm_superwtyczka/includes/css/css_custom_post_type.css';
               wp_enqueue_style( $handle, $src);
               //add_filter( 'wpcf7_support_html5_fallback', '__return_true' );
           }

           //parametr1 $post
           //param2 nr pierwszego pytania
           //par3 to liczba pytan
        function print_msis_29 ($post, $nr_pierwszego_pytania, $ile_pytan){
               $lista = msis_29_lista_pytan();
           ?>    <div class="ankieta"> <?php
               for ($i=$nr_pierwszego_pytania; $i<$nr_pierwszego_pytania+$ile_pytan; $i++) {

                   $nazwa = '_rejsm_msis_29_'.$i;
                   $wartosc_w_bazie_danych = get_post_meta( $post->ID, $nazwa, true );
                                               ?> <p> <?php  echo $lista[$i-1] ?>
        <p>Wcale nie
            <input class="msis_check" name="rejsm_msis_29_<?php    echo $i;    ?>" value="0" type="radio" <?php checked( $wartosc_w_bazie_danych, '0' );?> checked </input>
            <input class="msis_check" name="rejsm_msis_29_<?php    echo $i;    ?>" value="1" type="radio" <?php checked( $wartosc_w_bazie_danych, '1' );?> </input>
            <input class="msis_check" name="rejsm_msis_29_<?php    echo $i;    ?>" value="2" type="radio" <?php checked( $wartosc_w_bazie_danych, '2' );?> </input>
            <input class="msis_check" name="rejsm_msis_29_<?php    echo $i;    ?>" value="3" type="radio" <?php checked( $wartosc_w_bazie_danych, '3' );?> </input>
            <input class="msis_check" name="rejsm_msis_29_<?php    echo $i;    ?>" value="4" type="radio" <?php checked( $wartosc_w_bazie_danych, '4' );?> </input>
        Bardzo mocno
        </p>
        <?php
               }
        ?></div><?php
           }






           //***************************** dodaje style css
           add_action( 'admin_enqueue_scripts', 'rejsm_radio_button_css');
           function rejsm_radio_button_css(){
               $handle = 'rejsm_css';
               $src =  '/wp-content/plugins/rejsm_superwtyczka/includes/css/css_style_dane_demograficzne.css';
               wp_enqueue_style( $handle, $src);
           }


           ////***************************** css buttony dodaje skrytt css
           //add_action( 'admin_enqueue_scripts', 'rejsm_radio_button_css');
           //function rejsm_radio_button_css(){
           //    $handle = 'rejsm_radio_button_css';
           //    $src =  '/wp-content/plugins/rejsm_superwtyczka/includes/css/button-style.css';
           //    wp_enqueue_style( $handle, $src);
           //}


           // **************************  dodaje skrypt javascript automatycznie uzupełniający wynik ankiety
           add_action( 'admin_enqueue_scripts', 'rejsm_js_wynik_actualize');
           function rejsm_js_wynik_actualize($hook){
               global $post;

               if ( $hook == 'post-new.php' || $hook == 'post.php' ) {
                   if ( 'msis_29' === $post->post_type ) {     
                       $handle = 'js_wynik_actualize';
                       $src =  '/wp-content/plugins/rejsm_superwtyczka/includes/js/js_wynik_actualize.js';
                       wp_enqueue_script( $handle, $src);
                   }
               }
           }


           /**
            * Display wynik meta box
            */
           function wynik_msis_29_meta_box( $post ) {

            ?>
    <progress id="health_status_msis" class="scale_result" name ="msis_29_wynik" value="" max="116"  >    </progress>
    <?php
               //
               //    $terms = get_terms( 'kategoria_msis_29', array( 'hide_empty' => false ) );
               //    //$post  = get_post();
               //    $rating = wp_get_object_terms( $post->ID, 'kategoria_msis_29', array( 'orderby' => 'term_id', 'order' => 'ASC' ) );
               //    $name  = '';
               //    if ( ! is_wp_error( $rating ) ) {
               //        if ( isset( $rating[0] ) && isset( $rating[0]->name ) ) {
               //            $name = $rating[0]->name;
               //        }
               //    }
               //    foreach ( $terms as $term ) {
               //    ?>
<!--        <label title='--><?php //esc_attr_e( $term->name ); ?><!--'>-->
<!--            <input type="radio" name="kategoria_msis_29" value="--><?php //esc_attr_e( $term->name ); ?><!--" --><?php //checked( $term->name, $name ); ?><!-- disabled >-->
<!--            <span>--><?php //esc_html_e( $term->name ); ?><!--</span>-->
<!--        </label><br>-->
<!--        --><?php
                               //    }
                               ////
                               //    $kategorie = wp_get_object_terms( $post->ID,  'kategoria_msis_29' );
                               //    if ( ! empty( $kategorie ) ) {
                               //        if ( ! is_wp_error( $kategorie ) ) {
                               //            echo '<ul>';
                               //            foreach( $kategorie as $kat ) {
                               //                echo '<li><a href="' . get_term_link( $kat->slug, 'kategoria_msis_29' ) . '">' . esc_html( $kat->name ) . '</a></li>';
                               //            }
                               //            echo '</ul>';
                               //        }
                               //
                               //    }
                               //    else echo 'brak kategori';
           }

           //zapisuje dane z ankiety i zwraca sumę
           function msis_29_get_result($post_id)
           {
               $lista = msis_29_lista_pytan();
               $suma = 0;
               for ($i =1; $i < count($lista)+1; $i++) {
                   $name = 'rejsm_msis_29_'.$i;
                   $name2 = '_'.$name;
                   if ( isset( $_POST[$name] ) ) {
                       update_post_meta( $post_id, $name2, strip_tags( $_POST[$name] ) );
                       $wynik = intval (strip_tags( $_POST[$name] ) );
                       $suma =  $suma + $wynik;
                   }
               }
               return $suma;
           }

           //// Zaczep pozwalający na zapis danych pola użytkownika.
           //add_action( 'save_post', 'rejsm_msis_29_save_meta' );
           //function rejsm_msis_29_save_meta( $post_id ) {
           //    $suma = msis_29_get_result($post_id);
           //    $name3='msis_29_wynik';
           //    //if ( isset( $_POST[$name3] ) ) {
           //    update_post_meta($post_id, $name3, $suma );//strip_tags($_POST[$name3]));
           //    //}
           ////    $term_id = term_exists( 'msis_29', '0 – 29' );
           //    $kategoria = '';
           ////    if ($suma > 0 && $suma < 29) {
           ////        $kategoria = '0 – 29';
           ////    }
           //}

           add_action( 'publish_msis_29', 'add_taxonomy_to_post' );
           function add_taxonomy_to_post($post_id ) {
               $wynik = msis_29_get_result($post_id);
               $kategoria ='';
               if ( $wynik >= 0 && $wynik <= 29 ) $kategoria = 'minimalny';
               if ( $wynik >= 30 && $wynik <= 58 ) $kategoria = 'średni';
               if ( $wynik >= 59 && $wynik <= 87 ) $kategoria = 'mocny';
               if ( $wynik >= 88 && $wynik <= 116 ) $kategoria = 'bardzo mocny';

               wp_set_object_terms( $post_id, $kategoria, 'kategoria_msis_29',  false );
               update_post_meta($post_id, '_msis_29_wynik', $wynik );//strip_tags($_POST[$name3]));

           }



           function my_redirect_after_save( $location, $post_id ) {
               if ( 'msis_29' == get_post_type( $post_id ) ) {
                   $location = admin_url( 'edit.php?post_type=msis_29' );
               }
               return $location;
           }

           add_filter( 'redirect_post_location', 'my_redirect_after_save' );



           //zmien automatycznie tytul każdej ankiety
           add_filter( 'wp_insert_post_data' , 'modify_post_title' , '99', 1 ); // Grabs the inserted post data so you can modify it.
           function modify_post_title( $data )
           {
               if ( $data['post_type'] == 'msis_29' ) {
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
            * Register 'kategoria_msis_29' custom taxonomy.
            */
           add_action( 'init', 'register_kategoria_msis_29_taxonomy' );
           function register_kategoria_msis_29_taxonomy() {
               $args = array(
                   'label'             => __( 'Progres choroby' ),
                   'hierarchical'      => false,
                   'show_ui'           => true,
                   'show_admin_column' => true,
                   'meta_box_cb'       => 'wynik_msis_29_meta_box',
                   'show_admin_column ' => true,
               );
               register_taxonomy( 'kategoria_msis_29', 'msis_29', $args );
               //    register_taxonomy_for_object_type( 'kategoria_msis_29', 'msis_29' );

           }

           add_action( 'init', 'add_taxonomy_terms_kategoria' );
           function add_taxonomy_terms_kategoria () {
               wp_insert_term ('minimalny', 'kategoria_msis_29', array( 'description' => '0 – 29 stwardnienie rozsiane wpływa na mnie „wcale nie” do „minimalnie”', 'slug' => '0 – 29' ));
               wp_insert_term ('średni', 'kategoria_msis_29', array( 'description' => '30 – 58 stwardnienie rozsiane wpływa na mnie „minimalnie” do „średnio”', 'slug' => '30 – 58' ));
               wp_insert_term ('mocny', 'kategoria_msis_29', array( 'description' => '59 – 87 stwardnienie rozsiane wpływa na mnie „średnio” do „mocno”', 'slug' => '59 – 87' ));
               wp_insert_term ('bardzo mocny', 'kategoria_msis_29', array( 'description' => '88 – 116 stwardnienie rozsiane wpływa na mnie „mocno” do „bardzo mocno”', 'slug' => '88 – 116' ));
           }







           add_filter( 'manage_edit-msis_29_columns', 'my_edit_msis_29_columns' ) ;
           function my_edit_msis_29_columns( $columns ) {
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

                   //'title' => __( 'Tytuł' ),
           //		'plec' => __( 'Wynik' ),

                   'kategoria' => __( 'Wpływ choroby' ),
                   'wynik_msis_29' => __( 'Wynik' ),
                   'date' => __( 'Date' )
               ));
               return $columns;
           }

           add_action( 'manage_msis_29_posts_custom_column', 'my_manage_msis_29_columns', 10, 2 );
           function my_manage_msis_29_columns( $column, $post_id ) {
               global $post;

               switch( $column ) {

                   /* If displaying the 'duration' column. */
                   case 'wynik_msis_29' :

                       /* Get the post meta. */
                       //$wynik = msis_29_get_result($post_id);
                       $wynik = get_post_meta($post_id, '_msis_29_wynik', true);

                       /* If no duration is found, output a default message. */
                       if (is_null($wynik)) {
                           $out = sprintf('<a href="%s">%s</a>',
                               esc_url(add_query_arg(array('post' => $post_id, 'action' => 'edit'), 'post.php')), 'N/A');
                       }
                       /* If there is a duration, append 'minutes' to the text string. */
                       else {
                           $out = sprintf('<a href="%s">%s</a>',
                               esc_url( add_query_arg( array( 'post' => $post_id, 'action' => 'edit' ), 'post.php' ) ), $wynik    ); ///$wynik
                           //                    esc_html( sanitize_term_field( 'name', $wynik->name, $term->term_id, 'wynik_msis_29', 'display' ) )

                       }
                       echo $out;
                       break;

                   /* If displaying the 'genre' column. */
                   case 'kategoria' :

                       /* Get the genres for the post. */
                       $terms = get_the_terms( $post_id, 'kategoria_msis_29' );

                       /* If terms were found. */
                       if ( !empty( $terms ) ) {

                           $out = array();

                           /* Loop through each term, linking to the 'edit posts' page for the specific term. */
                           foreach ( $terms as $term ) {
                               $out[] = sprintf( '<a href="%s">%s</a>',
                                   esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'kategoria_msis_29' => $term->slug ), 'edit.php' ) ),
                                   esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'kategoria_msis_29', 'display' ) )
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
           add_filter( 'manage_edit-msis_29_sortable_columns', 'msis_29_sortable_columns' );
           function msis_29_sortable_columns( $columns ) {

               //	$columns['wynik_msis_29'] = 'wynik_msis_29';
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
           //					'orderby' => 'meta_value_num',// meta_value_num jeśli cyfra
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
           //                    'orderby' => 'meta_value_num',// meta_value_num jeśli cyfra
           //                )
           //            );
           //        }
           //	}
           //	return $vars;
           //}

           add_action( 'pre_get_posts', function( $query ) {

               //Note that current_user_can('edit_others_posts') check for
               //capability_type like posts, custom capabilities may be defined for custom posts
               if( is_admin() && ! current_user_can('edit_others_msis_29') && $query->is_main_query() ) {

                   $query->set('author', get_current_user_id());

                   //For standard posts
                   add_filter('views_edit-msis_29', 'views_filter_for_own_posts' );

                   //For gallery post type
                   // add_filter('views_edit-gallery', 'views_filter_for_own_posts' );

                   //You can add more similar filters for more post types with no extra changes
               }

           } );

                           function views_filter_for_own_posts( $views ) {

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

















                           //***********        dotyczy zakładki 'POMOC'



                           //wyświetla pomoc
                           add_action( 'contextual_help', 'msis_29_codex_add_help_text', 10, 3 );
                           function msis_29_codex_add_help_text( $contextual_help, $screen_id, $screen ) {
                               //$contextual_help .= var_dump( $screen ); // use this to help determine $screen->id
                               if ( 'msis_29' == $screen->id ) {
                                   $contextual_help =
                                     '<ul>' .
                                     '<li>' . __('Poniższe pytania dotyczą Pani/Pana zdania na temat wpływu stwardnienia rozsianego na Pani/Pana życie codzienne w ciągu ostatnich 14 dni', 'your_text_domain') . '</li>' .
                                     '<li>' . __('Przy każdym pytaniu proszę zaznaczyć jedną cyfrę, która najlepiej opisuje Pani/Pana sytuację.', 'your_text_domain') . '</li>' .
                                     '<li>' . __('Prosimy odpowiedzieć na wszystkie pytania.', 'your_text_domain') . '</li>' .
                                     '</ul>';

                               } elseif ( 'edit-msis_29' == $screen->id ) {
                                   $contextual_help =
                                     '<p>' . __('To jest ekran pomocy wyświetlania tabeli zawartości ankiet.', 'your_text_domain') . '</p>' ;
                               }
                               return $contextual_help;
                           }
                           //wyświetla pomoc
                           add_action('admin_head', 'msis_29_codex_custom_help_tab');
                           function msis_29_codex_custom_help_tab() {

                               $screen = get_current_screen();

                               // Return early if we're not on the book post type.
                               if ( 'msis_29' != $screen->post_type )
                                   return;

                               // Setup help tab args.
                               $args = array(
                                 'id'      => 'msis_29', //unique id for the tab
                                 'title'   => 'Pomoc', //unique visible title for the tab
                                 'content' => '<h3>Pomoc</h3><p>Jak nie wiesz jak wypełnić tą ankiete skontaktuj się ze swoim lekarzem.</p>',  //actual help text
                               );
                               
                               // Add the help tab.
                               $screen->add_help_tab( $args );
                           }


                           //private post 
                           add_action( 'transition_post_status', 'wpse118970_post_status_new', 10, 3 );
                           function wpse118970_post_status_new( $new_status, $old_status, $post ) { 
                               if ( $post->post_type == 'dane_demograficzne' && $new_status == 'publish' && $old_status  != $new_status ) {
                                   $post->post_status = 'private';
                                   wp_update_post( $post );
                               }
                           } 
                           //private post - interface
                           add_action( 'post_submitbox_misc_actions' , 'msis_29_change_visibility_metabox' );
                           function msis_29_change_visibility_metabox(){
                               global $post;
                               if ($post->post_type != 'msis_29')
                                   return;
                               $message = __('<strong>Note:</strong> Publikowane ankiety są zawsze <strong>prywatne</strong>.');
                               $post->post_password = '';
                               $visibility = 'private';
                               $visibility_trans = __('Private');

                               global $_wp_admin_css_colors;
                               global $admin_colors; // only needed if colors must be available in classes
                               $admin_colors = $_wp_admin_css_colors;
               ?>
    <style type="text/css">
        .priv_pt_note {
            background-color: <?php $admin_colors; ?>;
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

                           //***********        dotyczy zakładki 'pomoc'              ->koniec






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