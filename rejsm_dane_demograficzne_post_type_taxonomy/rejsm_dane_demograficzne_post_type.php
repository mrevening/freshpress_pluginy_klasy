<?php
///*
//Plugin Name: Rejsm Dane demograficzne
//Plugin URI: https://github.com/mrevening/freshpress_plugins
//Description: Dodaje nowy typ wpisu - dane demograficzne
//Version: 0.1
//Author: Dominik Wieczorek
//Author URI: https://github.com/mrevening/
//License: GPLv2
// */
add_action( 'init', 'rejsm_register_dane_demograficzne_post_type' );
function rejsm_register_dane_demograficzne_post_type() {
    $args = array (
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
            'add_new' => 'Dodaj nowe dane demograficzne',
            'add_new_item' => 'Dodaj nową daną demograficzną',
            'edit_item' => 'Edytuj dane demograficzne',
            'new_item' => 'Nowe dane demograficzne',
            'view_item' => 'Wyświetl dane demograficzne',
            'search_items' => 'Szukaj w danych demograficznych',
            'not_found' => 'Nie znaleziono danych demograficznych',
            'not_found_in_trash' => 'Nie znaleziono danych demograficznych w koszu'
        ),
    );
    /* Rejestracja typu wpisu bloga music_album. */
    register_post_type( 'dane_demograficzne', $args );
}
//add_action( 'add_meta_box', 'rejsm_pole_create');
//function rejsm_pole_create() {
//    add_meta_box( 'id-pole', 'Własne pole użytkownika', 'rejsm_pole_function', 'dane_demograficzne', 'normal', 'high');
//}
//function rejsm_pole_function() {
//    echo 'Witaj w polu użytkownika';
//}



/* Konfiguracja nowych taksonomii. */
add_action( 'init', 'rejsm_dane_demograficzne_register_taxonomies' );

/* Rejestracja taksonomii. */
function rejsm_dane_demograficzne_register_taxonomies() {

    ///* Konfiguracja argumentów taksonomii . */
    //$artist_args = array(
    //    'public' => false,
    //    'show_ui' => true,
    //    'hierarchical' => false,
    //    'query_var' => 'plec_term', 
    //    'show_tagcloud' => false,
    //    'rewrite' => array(
    //        'slug' => 'user/dane_demograficzne',
    //        'with_front' => false
    //    ),
    //    'labels' => array(
    //        'name' => 'Płeć',
    //        'singular_name' => 'Płeć',
    //        'edit_item' => 'Edytuj płeć',
    //        'update_item' => 'Uaktualnij płeć',
    //        'add_new_item' => 'Dodaj nową płeć',
    //        'new_item_name' => 'Nowa nazwa płeć',
    //        'all_items' => 'Wszystkie płci',
    //        'search_items' => 'Wyszukaj płeć',
    //        'popular_items' => 'Popularne płcie',
    //        'separate_items_with_commas' => 'Rozdziel płcie przecinkami',
    //        'add_or_remove_items' => 'Dodaj lub usuń płcie',
    //        'choose_from_most_used' => 'Wybierz z najpopularniejszych płci',
    //    ),
    //    'capabilities' =>array(
    //        'manage_terms' => '',
    //        'edit_terms' => '',
    //        'delete_terms' => '',
    //        'assign_terms' => 'edit_posts',)
    //);

   // /* Konfiguracja argumentów taksonomii gatunku. */
   // $genre_args = array(
   //     'hierarchical' => false,
   //     'query_var' => 'miasto_term', 
   //     'show_tagcloud' => true,
   //     'rewrite' => array(
   //         'slug' => 'music/genres',
   //         'with_front' => false
   //     ),
   //     'labels' => array(
   //         'name' => 'Miasto',
   //         'singular_name' => 'Miasto',
   //         'edit_item' => 'Edytuj miasto',
   //         'update_item' => 'Uaktualnij miasto',
   //         'add_new_item' => 'Dodaj nowe miasto',
   //         'new_item_name' => 'Nowa nazwa miasta',
   //         'all_items' => 'Wszystkie miasta',
   //         'search_items' => 'Wyszukaj miasto',
   //         'parent_item' => 'Gatunek nadrzędny',
   //         'parent_item_colon' => 'Gatunek nadrzędny:',
   //     ),

   // );

   // /* Rejestracja taksonomii artysty albumu. */
   //// register_taxonomy( 'plec_term', array( 'dane_demograficzne' ), $artist_args );

   // /* Rejestracja taksonomii gatunku albumu. */
   // register_taxonomy( 'miasto_term', array( 'dane_demograficzne' ), $genre_args );

    register_taxonomy('sex', 'dane_demograficzne', array(
      'capabilities' => array(
        'manage_terms' => '',
        'edit_terms' => '',
        'delete_terms' => '',
        'assign_terms' => 'edit_posts'
      ),
      'label' => 'Płeć',
      'labels' => array(
        'name' => 'Płeć',
        'add_new_item' => 'Dodaj nową płeć',
        'new_item_name' => "Dodaj nową płeć"
      ),
      'query_var' => 'sex', 
      'public' => true,
      'show_admin_column' => true,
      'show_in_nav_menus' => false,
      'show_tagcloud' => false,
      'show_ui' => true,
      'hierarchical' => true
    ));

}


add_action( 'init', 'add_taxonomy_terms' );
function add_taxonomy_terms () {
    wp_insert_term ('mężczyzna', 'sex');
    wp_insert_term ('kobieta', 'sex');
}
//$term = term_exists ('sex');
//$termid = $term['term_id'];
//add_action( 'create_term', 'add_taxonomy_terms2' );
//function add_taxonomy_terms2 () {
//    wp_insert_term ('Mężczyzna', '$termid');
//    wp_insert_term ('Kobieta', '$termid');
//}





////dodaje możliwość filtrowania przez taxonomie w panelu administratora
//add_action( 'restrict_manage_posts', 'my_restrict_manage_posts' );
//function my_restrict_manage_posts() {
//    global $typenow;
//    $taxonomy = $typenow;
//    if( $typenow != "page" && $typenow != "post" ){
//        $filters = array($taxonomy);
//        foreach ($filters as $tax_slug) {
//            $tax_obj = get_taxonomy($tax_slug);
//            $tax_name = $tax_obj->labels->name;
//            $terms = get_terms($tax_slug);
//            echo "<select name='$tax_slug' id='$tax_slug' class='postform'>";
//            echo "<option value=''>Show All $tax_name</option>";
//            foreach ($terms as $term) { echo '<option value='. $term->slug, $_GET[$tax_slug] == $term->slug ? ' selected="selected"' : '','>' . $term->name .' (' . $term->count .')</option>'; }
//            echo "</select>";
//        }
//    }
//}

?>






















