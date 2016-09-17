<?php
require_once dirname(__FILE__) . '/class_user_dane.php';
require_once dirname(__FILE__) . '/add_styles.php';
require_once dirname(__FILE__) . '/rejsm_listy.php';


                                    add_action( 'edit_user_profile', 'rejsm_display_metadata');
if ( current_user_can('pacjent') )  add_action( 'profile_personal_options', 'rejsm_display_metadata' ); //dodaje treść za sekcją personalizacja
function rejsm_display_metadata( $user ){

    $userrole = $user->roles;
    if ($userrole[0] == 'pacjent') {
        $lista_nazw_demograficzne = get_lista_nazw_demograficzne();
        $lista_nazw_eurems = get_lista_nazw_eurems();
        $lista_wyborow_demograficzne = get_lista_wyborow_demograficzne();
        $lista_wyborow_eurems = get_lista_wyborow_eurems();


        foreach ($lista_nazw_demograficzne as $key => $nazwa) {
            if (array_key_exists($key, $lista_wyborow_demograficzne)) $typ = 'drop-down'; else $typ = 'calendar';
            new class_user_dane($user, $key, $nazwa, $typ, $lista_wyborow_demograficzne[$key]);
        }

        ?><h2>EUReMS</h2>
        <table class="form-table"><?php
        $lista_objektow = class_user_dane::get_lista_objektow();
        foreach ($lista_objektow as $objekt) {
            if ($objekt->get_typ() == 'drop-down') $objekt->print_dropdown_list();
            if ($objekt->get_typ() == 'calendar') $objekt->print_calendar();
//            $objekt->get_user_meta_method();
        }
        ?></table><?php
    }
}


add_action( 'personal_options_update', 'rejsm_update_metadata' );
add_action( 'edit_user_profile_update', 'rejsm_update_metadata' );
function rejsm_update_metadata( $userid ) {

    $lista_nazw = get_lista_nazw();
    foreach ($lista_nazw as $nazwa => $value)
    if( isset( $_POST['key_'.$nazwa] ) ) {
        update_user_meta( $userid, $nazwa, $_POST['key_'.$nazwa]);
    }
}
?>


