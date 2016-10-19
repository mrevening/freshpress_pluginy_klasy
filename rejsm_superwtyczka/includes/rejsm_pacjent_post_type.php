<?php
require_once dirname(__FILE__) . '/class_user_dane.php';
require_once dirname(__FILE__) . '/add_styles.php';
require_once dirname(__FILE__) . '/rejsm_listy.php';

add_action( 'init', 'rejsm_pacjent_init' );
function rejsm_pacjent_init() {
    $labels = array(
        'name'               => _x( 'Dane pacjenta', 'post type general name', 'your-plugin-textdomain' ),
        'singular_name'      => _x( 'Dane pacjenta', 'post type singular name', 'your-plugin-textdomain' ),
        'menu_name'          => _x( 'Dane pacjenta', 'admin menu', 'your-plugin-textdomain' ),
        'name_admin_bar'     => _x( 'Dane pacjenta', 'add new on admin bar', 'your-plugin-textdomain' ),
        'add_new'            => _x( 'Dodaj daną pacjenta', 'book', 'your-plugin-textdomain' ),
        'add_new_item'       => __( 'Wypełnij nowe dane pacjenta', 'your-plugin-textdomain' ),
        'new_item'           => __( 'Nowy pacjent', 'your-plugin-textdomain' ),
        'edit_item'          => __( 'Edytuj dane', 'your-plugin-textdomain' ),
        'view_item'          => __( 'Zobacz pacjenta', 'your-plugin-textdomain' ),
        'all_items'          => __( 'Wszyscy pacjenci', 'your-plugin-textdomain' ),
        'search_items'       => __( 'Szukaj pacjenta', 'your-plugin-textdomain' ),
        'parent_item_colon'  => __( 'Parent Books:', 'your-plugin-textdomain' ),
        'not_found'          => __( 'Nie znaleziono ankiety.', 'your-plugin-textdomain' ),
        'not_found_in_trash' => __( 'Nie znaleziono ankiety w koszu.', 'your-plugin-textdomain' ),
    );
    $args = array(
        'labels'             => $labels,
        'description'        => __( 'Dane pacjenta.', 'your-plugin-textdomain' ),
        'public'             => false, //it's not public, it shouldn't have it's own permalink, and so on
        'exclude_from_search'=> true, // you should exclude it from search results
        'publicly_queryable' => false, // you should be able to query it
        'show_ui'            => true, // you should be able to edit it in wp-admin
        'show_in_menu'       => true,
        'show_in_nav_menus'  => false,  // you shouldn't be able to add it to menus
        'show_in_admin_bar'  => true,
        'menu_position'      => 100,
        'menu_icon'          => 'dashicons-groups',
        'query_var'          => false,
        'rewrite'            => false,
        'capability_type'    => 'post',
        'hierarchical'       => false,
        'has_archive'        => false,  // it shouldn't have archive page
        'rewrite'            => false,  // it shouldn't have rewrite rules
        'capabilities'       => array(
            'read_post'          => 'read_dane_pacjenta',
            'edit_post'          => 'edit_dane_pacjenta',
            'edit_posts'         => 'edit_dane_pacjenta',
            'delete_posts'       => 'delete_dane_pacjenta',
            'edit_others_posts'  => 'edit_others_dane_pacjenta',
            'publish_posts'      => 'publish_dane_pacjenta',
            'read_private_posts' => 'read_private_dane_pacjenta',
            'create_posts'       => 'edit_dane_pacjenta',
        ),
        'supports'           => array( '' ),
    );
    register_post_type( 'dane_pacjenta', $args );
}
//***********************                   tworzenie ankiety MSIS_29  -> koniec
// **************************   Pole użytkownika

add_action( 'user_register', 'myplugin_registration_save', 10, 1 );

function myplugin_registration_save( $user_id ) {
    if ( isset( $_POST['role'] )  || $_POST['role'] = 'pacjent') {
        wp_insert_post( array(
                    'post_type' => 'dane_pacjenta',
                    'post_title' => get_userdata($user_id)->user_login,
                    'post_status' => 'publish',
                    'post_author' => get_userdata($user_id)->user_login,
                     )
                );
    }
}



add_action( 'add_meta_boxes', 'rejsm_pacjent_post_type_create' );
function rejsm_pacjent_post_type_create($user) {

    $tytuly = array('danedemograficzne', 'wywiad', 'diagnostyka');
    $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'danedemograficzne';
    foreach ($tytuly as $tytul) {
?>
    <h2 class="nav-tab-wrapper">
        <?php
        foreach ($tytuly as $tytul) {
            $naglowek = get_lista($tytul, 'naglowek');
        ?>
            <a href="?post_type=pacjent&user_id=<?php echo $user->ID; ?>&tab=<?php echo $tytul; ?>" class="nav-tab <?php echo $active_tab == $tytul ? 'nav-tab-active' : ''; ?>"><?php echo $naglowek[0]; ?></a>
            </h2>
            <?php
            //$userrole = $user->roles;
            //if ($userrole[0] == 'pacjent') {
            $lista_tytulow_i_typow=array();
            $lista_wyborow=array();
            $naglowek = '';
            foreach ($tytuly as $tytul) {
                $lista_tytulow_i_typow = get_lista($tytul,'tytuly_typy');
                $lista_wyborow = get_lista($tytul,'wybory');
                $naglowek = get_lista($tytul, 'naglowek');
                foreach ($lista_tytulow_i_typow as $key => $value) {
                    new class_user_dane($user, $key, $value[0], $value[1], $lista_wyborow[$key]);
                }
            ?>
                <table class="form-table">
                <?php
                $lista_objektow = class_user_dane::get_lista_objektow();
                //echo '<pre>';
                //var_dump ($lista_objektow);
                foreach ($lista_objektow as $objekt) {
                    $objekt->print_it();
                }
                ?>
                </table><?php
                class_user_dane::reset_lista_objektow();
            }
        }
    }
}
?>