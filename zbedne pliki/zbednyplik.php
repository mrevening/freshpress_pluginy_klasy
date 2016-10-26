<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



//add_action ('init', 'rejsm_add_custom_post_types');
//function rejsm_add_custom_post_types(){
//    $custom_post_types= array(
//        'msis_29'=>'MSIS 29',
//        'eq5d'=>'EQ-5D',
//        'dane_pacjenta'=>'Dane pacjenta'
//    );
//    $roles = array ('administrator', 'pacjent', 'lekarz');
//    $i = 101;
//    foreach ($custom_post_types as $post_type_name => $post_type_name2 ){

//        switch ($post_type_name){
//            case 'msis_29':
//                $labels = array(
//                    'name'               => _x( 'Ankieta MSIS-29', 'post type general name', 'your-plugin-textdomain' ),
//                    'singular_name'      => _x( 'Ankieta', 'post type singular name', 'your-plugin-textdomain' ),
//                    'menu_name'          => _x( 'Ankiety MSIS-29', 'admin menu', 'your-plugin-textdomain' ),
//                    'name_admin_bar'     => _x( 'Ankietę MSIS-29', 'add new on admin bar', 'your-plugin-textdomain' ),
//                    'add_new'            => _x( 'Dodaj nową ankietę', 'book', 'your-plugin-textdomain' ),
//                    'add_new_item'       => __( 'Wypełnij nową ankietę MSIS 29', 'your-plugin-textdomain' ),
//                    'new_item'           => __( 'Nowa ankieta', 'your-plugin-textdomain' ),
//                    'edit_item'          => __( 'Edytuj ankietę', 'your-plugin-textdomain' ),
//                    'view_item'          => __( 'Zobacz ankietę', 'your-plugin-textdomain' ),
//                    'all_items'          => __( 'Wszystkie ankiety', 'your-plugin-textdomain' ),
//                    'search_items'       => __( 'Szukaj ankiety', 'your-plugin-textdomain' ),
//                    'parent_item_colon'  => __( 'Parent Books:', 'your-plugin-textdomain' ),
//                    'not_found'          => __( 'Nie znaleziono ankiety.', 'your-plugin-textdomain' ),
//                    'not_found_in_trash' => __( 'Nie znaleziono ankiety w koszu.', 'your-plugin-textdomain' ),
//                );
//                $description = "Skala wpływu stwardnienia rozsianego (MSIS-29).";
//                $menu_icon = 'dashicons-pressthis';
//                break;
//            case 'eq5d':
//                $labels = array(
//                    'name'               => _x( 'Ankieta EQ-5D', 'post type general name', 'your-plugin-textdomain' ),
//                    'singular_name'      => _x( 'Ankieta', 'post type singular name', 'your-plugin-textdomain' ),
//                    'menu_name'          => _x( 'Ankiety EQ-5D', 'admin menu', 'your-plugin-textdomain' ),
//                    'name_admin_bar'     => _x( 'Ankietę EQ-5D', 'add new on admin bar', 'your-plugin-textdomain' ),
//                    'add_new'            => _x( 'Dodaj nową ankietę', 'book', 'your-plugin-textdomain' ),
//                    'add_new_item'       => __( 'Wypełnij nową ankietę EQ-5D', 'your-plugin-textdomain' ),
//                    'new_item'           => __( 'Nowa ankieta', 'your-plugin-textdomain' ),
//                    'edit_item'          => __( 'Edytuj ankietę', 'your-plugin-textdomain' ),
//                    'view_item'          => __( 'Zobacz ankietę', 'your-plugin-textdomain' ),
//                    'all_items'          => __( 'Wszystkie ankiety', 'your-plugin-textdomain' ),
//                    'search_items'       => __( 'Szukaj ankiety', 'your-plugin-textdomain' ),
//                    'parent_item_colon'  => __( 'Parent Books:', 'your-plugin-textdomain' ),
//                    'not_found'          => __( 'Nie znaleziono ankiety.', 'your-plugin-textdomain' ),
//                    'not_found_in_trash' => __( 'Nie znaleziono ankiety w koszu.', 'your-plugin-textdomain' ),
//                );
//                $description = "Skala wpływu stwardnienia rozsianego (MSIS-29).";
//                $menu_icon = 'dashicons-clipboard';
//                break;
//            case 'dane_pacjenta':
//                $labels = array(
//                    'name'               => _x( 'Dane pacjenta', 'post type general name', 'your-plugin-textdomain' ),
//                    'singular_name'      => _x( 'Dane pacjenta', 'post type singular name', 'your-plugin-textdomain' ),
//                    'menu_name'          => _x( 'Dane pacjenta', 'admin menu', 'your-plugin-textdomain' ),
//                    'name_admin_bar'     => _x( 'Dane pacjenta', 'add new on admin bar', 'your-plugin-textdomain' ),
//                    'add_new'            => _x( 'Dodaj daną pacjenta', 'book', 'your-plugin-textdomain' ),
//                    'add_new_item'       => __( 'Wypełnij nowe dane pacjenta', 'your-plugin-textdomain' ),
//                    'new_item'           => __( 'Nowy pacjent', 'your-plugin-textdomain' ),
//                    'edit_item'          => __( 'Edytuj dane', 'your-plugin-textdomain' ),
//                    'view_item'          => __( 'Zobacz pacjenta', 'your-plugin-textdomain' ),
//                    'all_items'          => __( 'Wszyscy pacjenci', 'your-plugin-textdomain' ),
//                    'search_items'       => __( 'Szukaj pacjenta', 'your-plugin-textdomain' ),
//                    'parent_item_colon'  => __( 'Parent Books:', 'your-plugin-textdomain' ),
//                    'not_found'          => __( 'Nie znaleziono ankiety.', 'your-plugin-textdomain' ),
//                    'not_found_in_trash' => __( 'Nie znaleziono ankiety w koszu.', 'your-plugin-textdomain' ),
//                );
//                $description = "Wszystkie dane pacjenta";
//                $menu_icon = 'dashicons-groups';
//                break;
//        }
//        register_post_type( $post_type_name, array (
//            'labels'             => $labels,
//            'description'        => __( $description, 'your-plugin-textdomain' ),
//            'public'             => false, //it's not public, it shouldn't have it's own permalink, and so on
//            'exclude_from_search'=> true, // you should exclude it from search results
//            'publicly_queryable' => false, // you should be able to query it
//            'show_ui'            => true, // you should be able to edit it in wp-admin
//            'show_in_menu'       => true,
//            'show_in_nav_menus'  => false,  // you shouldn't be able to add it to menus
//            'show_in_admin_bar'  => true,
//            'menu_position'      => $i++,
//            'menu_icon'          => $menu_icon,
//            'query_var'          => false,
//            'rewrite'            => false,
//            'capability_type'    => 'post',
//            'hierarchical'       => false,
//            'has_archive'        => false,  // it shouldn't have archive page
//            'rewrite'            => false,  // it shouldn't have rewrite rules
//            'capabilities'       => array(
//                'read_post'          => 'read_'.$post_type_name,
//                'edit_post'          => 'edit_'.$post_type_name,
//                'edit_posts'         => 'edit_'.$post_type_name.'s',
//                'delete_posts'       => 'delete_'.$post_type_name,
//                'edit_others_posts'  => 'edit_others_'.$post_type_name,
//                'publish_posts'      => 'publish_'.$post_type_name,
//                'read_private_posts' => 'read_private_'.$post_type_name,
//                'create_posts'       => 'edit_'.$post_type_name,
//            ),
//            'supports'           => array( '' ),
//        ) );
//        foreach ($roles as $rola){
//            $role = get_role( $rola );
//            if ( !empty ($role) ){
//                $role->add_cap('read_'.$post_type_name);
//                $role->add_cap('read_private_'.$post_type_name);
//                $role->add_cap('edit_'.$post_type_name);
//                $role->add_cap('edit_'.$post_type_name.'s');
//                $role->add_cap('edit_others_'.$post_type_name);
//                $role->add_cap('publish_'.$post_type_name);
//                $role->add_cap('delete_'.$post_type_name);
//            }
//        }
//    }
//}
