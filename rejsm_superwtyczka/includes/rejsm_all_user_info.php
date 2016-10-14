<?php
require_once dirname(__FILE__) . '/class_user_dane.php';
require_once dirname(__FILE__) . '/add_styles.php';
require_once dirname(__FILE__) . '/rejsm_listy.php';



                                    add_action( 'edit_user_profile', 'rejsm_display_metadata');
if ( current_user_can('pacjent') )  add_action( 'profile_personal_options', 'rejsm_display_metadata' ); //dodaje treść za sekcją personalizacja
function rejsm_display_metadata( $user ){

?>
<h2 class="nav-tab-wrapper">
    <a href="#" class="nav-tab">Display Options</a>
    <a href="#" class="nav-tab">Social Options</a>
</h2>
<?php




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
                //if ($value[2]=='multiple'){
                //    while (get_meta($user->id, $key) != ''){//zrob cos
                //    }
                //}
                new class_user_dane($user, $key, $value[0], $value[1], $lista_wyborow[$key]);
            }
?><a name="<?php echo $tytul;?>"><h3><?php echo $naglowek[0]; ?></h3></a>
            <table class="form-table"><?php
            $lista_objektow = class_user_dane::get_lista_objektow();
            //echo '<pre>';
            //var_dump ($lista_objektow);
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

    //$lista_nazw = get_wszyskie_tytuly();
    $tabele = array ('danedemograficzne', 'wywiad', 'diagnostyka');
    $lista_nazw = get_lista ($tabele, 'tytuly_typy');
    foreach ($lista_nazw as $nazwa => $value)
    if( isset( $_POST['key_'.$nazwa] ) ) {
        update_user_meta( $userid, $nazwa, $_POST['key_'.$nazwa]);
    }
}
?>


