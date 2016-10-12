<?php
require_once dirname(__FILE__) . '/class_user_dane.php';
require_once dirname(__FILE__) . '/add_styles.php';
require_once dirname(__FILE__) . '/rejsm_listy.php';


                                    add_action( 'edit_user_profile', 'rejsm_display_metadata');
if ( current_user_can('pacjent') )  add_action( 'profile_personal_options', 'rejsm_display_metadata' ); //dodaje treść za sekcją personalizacja
function rejsm_display_metadata( $user ){

    $userrole = $user->roles;
    if ($userrole[0] == 'pacjent') {

        $tytuly = array('Dane demograficzne', 'EUREMS');
        $lista_tytulow_i_typow=array();
        $lista_wyborow=array();
        foreach ($tytuly as $tytul){
            switch ($tytul){
                case 'Dane demograficzne':
                    $lista_tytulow_i_typow = get_lista_tytulow_i_typow_demograficzne();
                    $lista_wyborow = get_lista_wyborow_demograficzne();
                    break;
                case 'EUREMS':
                    $lista_tytulow_i_typow = get_lista_tytulow_i_typow_eurems();
                    $lista_wyborow = get_lista_wyborow_eurems();
                    break;
            }
            foreach ($lista_tytulow_i_typow as $key => $value) {
                new class_user_dane($user, $key, $value[0], $value[1], $lista_wyborow[$key]);
            }
            ?><h2><?php echo $tytul; ?></h2>
            <table class="form-table"><?php
            $lista_objektow = class_user_dane::get_lista_objektow();
            foreach ($lista_objektow as $objekt) {
                $objekt->print_it();
            }
            ?></table><?php
            class_user_dane::reset_lista_objektow();
        }
    }    
}


add_action( 'personal_options_update', 'rejsm_update_metadata' );
add_action( 'edit_user_profile_update', 'rejsm_update_metadata' );
function rejsm_update_metadata( $userid ) {

    $lista_nazw = get_wszyskie_tytuly();
    foreach ($lista_nazw as $nazwa => $value)
    if( isset( $_POST['key_'.$nazwa] ) ) {
        update_user_meta( $userid, $nazwa, $_POST['key_'.$nazwa]);
    }
}
?>


