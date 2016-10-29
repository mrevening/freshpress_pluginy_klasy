<?php
require_once dirname(__FILE__) . '/class_user_dane.php';
require_once dirname(__FILE__) . '/add_styles.php';
require_once dirname(__FILE__) . '/rejsm_listy.php';

//function add_query_vars_filter( $vars ){
//    $vars[] = "tab";
//    return $vars;
//}
//add_filter( 'query_vars', 'add_query_vars_filter',1,1 );

//add_action( 'admin_head-user-edit.php', 'remove_default_form_edit_user' );
//add_action( 'admin_head-profile.php',   'remove_default_form_edit_user' );
//function remove_default_form_edit_user()
//{
//    if( get_query_var ('tab') == 'dane_demograficzne' )  echo '<style>#your-profile{ display: none; }</style>';
//}

//add_action('init','your_func');
//function your_func(){
//    global $wp_query;
//    //echo '<pre>';
//    //var_dump($wp_query);
//    //echo '</pre>';
//    // or  var_dump($GLOBALS['wp_query']);
//}

//                                    add_action( 'edit_user_profile', 'rejsm_display_metadata');
//if ( current_user_can('pacjent') )  add_action( 'profile_personal_options', 'rejsm_display_metadata' ); //dodaje treść za sekcją personalizacja
//add_action( 'personal_options', 'rejsm_display_metadata');
//if ( current_user_can('pacjent') )  add_action( 'profile_personal_options', 'rejsm_display_metadata' ); //dodaje treść za sekcją personalizacja
function rejsm_display_metadata( $user ){

    ///////////////t/////////////////////////////////////taby
    $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'konto';

    $tabs = array(
        'konto'=> 'Konto',
        'dane_demograficzne'=>'Dane demograficzne'
        );

?>
    <h2 class="nav-tab-wrapper"><?php
    foreach ($tabs as $tab => $napis){
        $params = array('user_id' => $user->ID, 'tab' => $tab);?>
    <a href="<?php echo esc_url( add_query_arg( $params, get_permalink( ) ) ); ?>" class="nav-tab <?php echo $active_tab == $tab ? 'nav-tab-active' : ''; ?>"><?php echo $napis; ?></a><?php
    }
                                                                                                                                                                                       ?>
    <!--<a href="?user_id=<?php echo $user->ID; ?>&tab=konto" class="nav-tab <?php echo $active_tab == 'konto' ? 'nav-tab-active' : ''; ?>">Konto</a>-->
    <!--<a href="?user_id=<?php echo $user->ID; ?>&tab=dane_demograficzne" class="nav-tab <?php echo $active_tab == 'dane_demograficzne' ? 'nav-tab-active' : ''; ?>">Dane demograficzne</a>-->
    </h2>
    <?php


                                                                                                ////////////////////////////////////////////koniec tabow

}
add_action( 'add_meta_boxes', 'rejsm_users_metaboxes' );
function rejsm_users_metaboxes() {
	add_meta_box( 'konto', 'Konto', 'rejsm_metabox_konto', 'user', 'normal', 'high' );
}



function rejsm_metabox_konto($user){

//print all
//if( $active_tab == 'dane_demograficzne' ) {
    $userrole = $user->roles;
    if ($userrole[0] == 'pacjent') {

        $tytuly = array('danedemograficzne', 'wywiad', 'diagnostyka');
        $lista_tytulow_i_typow=array();
        $lista_wyborow=array();
        $naglowek = '';
        foreach ($tytuly as $tytul) {
            $lista_tytulow_i_typow = get_lista($tytul,'tytuly_typy');
            $lista_wyborow = get_lista($tytul,'wybory');
            $naglowek = get_lista($tytul, 'naglowek');
            foreach ($lista_tytulow_i_typow as $key => $value) {
                new class_user_dane($user, $key, $value[0], $value[1], $lista_wyborow[$key]);
            }?>
<a name="<?php echo $tytul;?>">
<h3>
    <?php echo $naglowek[0]; ?>
</h3>
</a>
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




add_action( 'personal_options_update', 'rejsm_update_metadata' );
add_action( 'edit_user_profile_update', 'rejsm_update_metadata' );
function rejsm_update_metadata( $userid ) {

    //$lista_nazw = get_wszyskie_tytuly();
    $tabele = array ('danedemograficzne', 'wywiad', 'diagnostyka');
    $lista_nazw = get_lista ($tabele, 'tytuly_typy');
    foreach ($lista_nazw as $nazwa => $value)
        if( isset( $_POST['key_'.$nazwa] ) ) {
            update_user_meta( $userid, $nazwa, $_POST['key_'.$nazwa]);
        }
}



