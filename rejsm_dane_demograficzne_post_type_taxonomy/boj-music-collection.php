<?php
/*
Plugin Name: Kolekcja muzyczna
Plugin URI: http://przyklad.pl
Description: Pozwala uporządkować kolekcję muzyczną względem albumu, artysty i gatunku.
Version: 0.1
Author: WROX
Author URI: http://wrox.com
*/

/* Konfiguracja typu wpisu bloga. */
add_action( 'init', 'boj_music_collection_register_post_types' );

/* Rejestracja typu wpisu bloga. */
function boj_music_collection_register_post_types() {

    /* Ustawienie argumentów dla typu wpisu bloga 'music_album'. */
    $album_args = array(
        'public' => true,
        'query_var' => 'music_album',
        'rewrite' => array(
            'slug' => 'music/albums',
            'with_front' => false,
        ),
        'supports' => array(
            'title',
            'thumbnail'
        ),
        'labels' => array(
            'name' => 'Albumy',
            'singular_name' => 'Album',
            'add_new' => 'Dodaj nowy album',
            'add_new_item' => 'Dodaj nowy album',
            'edit_item' => 'Edytuj album',
            'new_item' => 'Nowy album',
            'view_item' => 'Wyświetl album',
            'search_items' => 'Szukaj w albumach',
            'not_found' => 'Nie znaleziono albumów',
            'not_found_in_trash' => 'Nie znaleziono albumów w koszu'
        ),
    );

    /* Rejestracja typu wpisu bloga music_album. */
    register_post_type( 'music_album', $album_args );
}

/* Konfiguracja nowych taksonomii. */
add_action( 'init', 'boj_music_collection_register_taxonomies' );

/* Rejestracja taksonomii. */
function boj_music_collection_register_taxonomies() {

    /* Konfiguracja argumentów taksonomii artysty. */
    $artist_args = array(
        'hierarchical' => false,
        'query_var' => 'album_artist', 
        'show_tagcloud' => true,
        'rewrite' => array(
            'slug' => 'music/artists',
            'with_front' => false
        ),
        'labels' => array(
            'name' => 'Artyści',
            'singular_name' => 'Artysta',
            'edit_item' => 'Edytuj artystę',
            'update_item' => 'Uaktualnij artystę',
            'add_new_item' => 'Dodaj nowego artystę',
            'new_item_name' => 'Nowa nazwa artysty',
            'all_items' => 'Wszyscy artyści',
            'search_items' => 'Wyszukaj artystów',
            'popular_items' => 'Popularni artyści',
            'separate_items_with_commas' => 'Rozdziel artystów przecinkami',
            'add_or_remove_items' => 'Dodaj lub usuń artystów',
            'choose_from_most_used' => 'Wybierz z najpopularniejszych artystów',
        ),
    );

    /* Konfiguracja argumentów taksonomii gatunku. */
    $genre_args = array(
        'hierarchical' => true,
        'query_var' => 'album_genre', 
        'show_tagcloud' => true,
        'rewrite' => array(
            'slug' => 'music/genres',
            'with_front' => false
        ),
        'labels' => array(
            'name' => 'Gatunki',
            'singular_name' => 'Gatunek',
            'edit_item' => 'Edytuj gatunek',
            'update_item' => 'Uaktualnij gatunek',
            'add_new_item' => 'Dodaj nowy gatunek',
            'new_item_name' => 'Nowa nazwa gatunku',
            'all_items' => 'Wszystkie gatunki',
            'search_items' => 'Wyszukaj gatunki',
            'parent_item' => 'Gatunek nadrzędny',
            'parent_item_colon' => 'Gatunek nadrzędny:',
        ),
    );

    /* Rejestracja taksonomii artysty albumu. */
    register_taxonomy( 'album_artist', array( 'music_album' ), $artist_args );

    /* Rejestracja taksonomii gatunku albumu. */
    register_taxonomy( 'album_genre', array( 'music_album' ), $genre_args );
}

?>
