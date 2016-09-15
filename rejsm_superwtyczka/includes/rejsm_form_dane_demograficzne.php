<?php
require_once ABSPATH . '/wp-includes/pluggable.php' ; //błąd wordpressa, musi być ta komenda.

error_reporting(E_ALL);
ini_set('display_errors', 1); //raportowanie błędów. POTEM USUNĄĆ




add_action( 'admin_enqueue_scripts', 'rejsm_css_add_style');
function rejsm_css_add_style(){
    $handle = 'css_style_form_dane_demograficzne';
    $src =  '/wp-content/plugins/rejsm_superwtyczka/includes/css/css_style_dane_demograficzne.css';
    wp_enqueue_style( $handle, $src);

    wp_enqueue_script('jquery-ui-datepicker');
    wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');

    $handle2 = 'rejsm_ankieta';
    $src2 =  '/wp-content/plugins/rejsm_superwtyczka/includes/js/rejsm_ankieta.js';
    wp_enqueue_script( $handle2, $src2);

    $handle = 'rejsm_datepicker';
    $src =  '/wp-content/plugins/rejsm_superwtyczka/includes/js/rejsm_datepicker.js';
    wp_enqueue_script( $handle, $src);

    wp_enqueue_style('jquery-style', 'https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js');


//
//    $handle = 'rejsm_praca';
//    $src =  '/wp-content/plugins/rejsm_superwtyczka/includes/js/dane_js';
//    wp_enqueue_script( $handle, $src);
    //add_filter( 'wpcf7_support_html5_fallback', '__return_true' );
}
//add_action( 'admin_enqueue_scripts', 'rejsm_pesel_verification');
if ( current_user_can('pacjent') ) {
    add_action( 'profile_personal_options', 'rejsm_display_danedemograficzne_metadata' ); //dodaje treść za sekcją personalizacja
}
//if (! current_user_can('pacjent') ) {
    add_action('edit_user_profile', 'rejsm_display_danedemograficzne_metadata');
//}
function rejsm_display_danedemograficzne_metadata( $user ){
    $userrole = $user->roles;
    if ($userrole[0] == 'pacjent')
    {
        $userid = $user->ID;
        $user_info = get_userdata(1);
        $pesel = $user->user_login;
//        $pesel = get_user_meta( $userid, 'pesel', true );

        $miejsce_zamieszkania = get_user_meta($userid, 'miejsce_zamieszkania', true);
        $wojewodztwo = get_user_meta($userid, 'wojewodztwo', true);
        $recznosc = get_user_meta($userid, 'recznosc', true);
        $porody = get_user_meta($userid, 'porody', true);
        $wyksztalcenie = get_user_meta($userid, 'wyksztalcenie', true);
        $stan_rodzinny = get_user_meta($userid, 'stan_rodzinny', true);
        $zatrudnienie = get_user_meta($userid, 'zatrudnienie', true);
        $praca_dochod = get_user_meta($userid, 'praca_dochod', true);
        $sm_w_rodzinie = get_user_meta($userid, 'sm_w_rodzinie', true);
        $inicjaly = get_user_meta($userid, 'inicjaly', true);
        $data_zgonu = get_user_meta($userid, 'data_zgonu', true);

        $plec = 0;
        if (substr($pesel, 9, 1) % 2 == 0) $plec = 1;
        else if (substr($pesel, 9, 1) % 2 == 1) $plec = 2;

        $przebieg_choroby = get_user_meta($userid, 'przebieg_choroby', true);
        $data_pierwszych_objawow = get_user_meta($userid, 'data_pierwszych_objawow', true);
        $data_rozpoznania_choroby = get_user_meta($userid, 'data_rozpoznania_choroby', true);

        $badanie_mri = get_user_meta($userid, 'badanie_mri', true);
        $badanie_plynu = get_user_meta($userid, 'badanie_plynu', true);
        $leczenie_immunomodulujace = get_user_meta($userid, 'leczenie_immunomodulujace', true);
        $leczenie_objawowe = get_user_meta($userid, 'leczenie_objawowe', true);
        ?>
        <h2>EUReMS</h2>
        <table class="form-table">
            <tr>
                <th scope="row">Płeć</th>
                <td>
                    <select id="plec" name="key_plec" disabled>
                        <?php if ($plec == 0) { ?>
                            <option disabled selected value></option>
                        <?php } else if ($plec == 1) { ?>
                            <option value="1"> Kobieta</option>
                        <?php } else if ($plec == 2) { ?>
                            <option value="2"> Mężczyzna</option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th scope="row">Przebieg choroby</th>
                <td>
                    <select id="przebieg_choroby" name="key_przebieg_choroby">
                        <option disabled selected value></option>
                        <option value="1" <?php selected('1', $przebieg_choroby); ?>>Rzutowo-remisyjna</option>
                        <option value="2" <?php selected('2', $przebieg_choroby); ?>>Wtórnie-postępująca</option>
                        <option value="3" <?php selected('3', $przebieg_choroby); ?>>Pierwotnie-postępująca</option>
                        <option value="4" <?php selected('4', $przebieg_choroby); ?>>CIS</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th scope="row">Data pierwszych objawów (miesiąc / rok)</th>
                <td>
                    <input id="data_pierwszych_objawow" type="text" class="MyDate" name="key_data_pierwszych_objawow"
                           value="<?php echo $data_pierwszych_objawow; ?>"/>
                </td>
            </tr>
            <tr>
                <th scope="row">Data rozpoznania choroby (miesiąc / rok</th>
                <td>
                    <input id="data_rozpoznania_choroby" type="text" class="MyDate" name="key_data_rozpoznania_choroby"
                           value="<?php echo $data_rozpoznania_choroby; ?>"/>
                </td>
            </tr>
            <tr>
                <th scope="row">Badanie MRI</th>
                <td>
                    <select id="badanie_mri" name="key_badanie_mri">
                        <option disabled selected value></option>
                        <option value="1" <?php selected('1', $badanie_mri); ?>>Tak</option>
                        <option value="2" <?php selected('2', $badanie_mri); ?>>Nie</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th scope="row">Badanie płynu mózgowo-rdzeniowego</th>
                <td>
                    <select id="badanie_plynu" name="key_badanie_plynu">
                        <option disabled selected value></option>
                        <option value="1" <?php selected('1', $badanie_plynu); ?>>Tak</option>
                        <option value="2" <?php selected('2', $badanie_plynu); ?>>Nie</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th scope="row">Leczenie immunomodulujące</th>
                <td>
                    <select id="leczenie_immunomodulujace" name="key_leczenie_immunomodulujace">
                        <option disabled selected value></option>
                        <option value="1" <?php selected('1', $leczenie_immunomodulujace); ?>>Obecnie</option>
                        <option value="2" <?php selected('2', $leczenie_immunomodulujace); ?>>W przeszłości</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th scope="row">Leczenie objawowe</th>
                <td>
                    <select id="leczenie_objawowe" name="key_leczenie_objawowe">
                        <option disabled selected value></option>
                        <option value="1" <?php selected('1', $leczenie_objawowe); ?>>Obecnie</option>
                        <option value="2" <?php selected('2', $leczenie_objawowe); ?>>W przeszłości</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th scope="row">Zatrudnienie / praca</th>
                <td>
                    <select id="zatrudnienie" name="key_zatrudnienie">
                        <option disabled selected value></option>
                        <option value="1" <?php selected('1', $zatrudnienie); ?>>Nie pracuje</option>
                        <option value="2" <?php selected('2', $zatrudnienie); ?>>Pracuje</option>
                        <option value="3" <?php selected('3', $zatrudnienie); ?>>Renta</option>
                        <option value="4" <?php selected('4', $zatrudnienie); ?>>Emerytura</option>
                    </select>
                </td>
            </tr>

            <tr id="row-hide" <?php if ($zatrudnienie != "2") { ?> style="display:none" <?php } else {
            }; ?> >
                <th scope="row">Dochód z pracy</th>
                <td>
                    <select id="praca_dochod" name="key_praca_dochod">
                        <option disabled selected value></option>
                        <option value="1" <?php selected('1', $praca_dochod); ?>>Tak</option>
                        <option value="2" <?php selected('2', $praca_dochod); ?>>Nie</option>
                    </select>
                </td>
            </tr>

        </table>
        <h2>Dane demograficzne</h2>
        <table class="form-table">
            <tr>
                <th scope="row">Miejsce zamieszkania</th>
                <td>
                    <select id="miejsce_zamieszkania" name="key_miejsce_zamieszkania">
                        <option disabled selected value></option>
                        <option value="1" <?php selected('1', $miejsce_zamieszkania); ?>>Miasto</option>
                        <option value="2" <?php selected('2', $miejsce_zamieszkania); ?>>Wieś</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th scope="row">Województwo</th>
                <td>
                    <select id="wojewodztwo" name="key_wojewodztwo">
                        <option disabled selected value></option>
                        <option value="1" <?php selected('1', $wojewodztwo); ?>>dolnośląskie</option>
                        <option value="2" <?php selected('2', $wojewodztwo); ?>>kujawsko-pomorskie</option>
                        <option value="3" <?php selected('3', $wojewodztwo); ?>>lubelskie</option>
                        <option value="4" <?php selected('4', $wojewodztwo); ?>>lubuskie</option>
                        <option value="5" <?php selected('5', $wojewodztwo); ?>>łódzkie</option>
                        <option value="6" <?php selected('6', $wojewodztwo); ?>> małopolskie</option>
                        <option value="7" <?php selected('7', $wojewodztwo); ?>>mazowieckie</option>
                        <option value="8" <?php selected('8', $wojewodztwo); ?>>opolskie</option>
                        <option value="9" <?php selected('9', $wojewodztwo); ?>>podkarpackie</option>
                        <option value="10" <?php selected('10', $wojewodztwo); ?>>podlaskie</option>
                        <option value="11" <?php selected('11', $wojewodztwo); ?>>pomorskie</option>
                        <option value="12" <?php selected('12', $wojewodztwo); ?>>śląskie</option>
                        <option value="13" <?php selected('13', $wojewodztwo); ?>>świętokrzyskie</option>
                        <option value="14" <?php selected('14', $wojewodztwo); ?>>warmińsko-mazurskie</option>
                        <option value="15" <?php selected('15', $wojewodztwo); ?>>wielkopolskie</option>
                        <option value="16" <?php selected('16', $wojewodztwo); ?>>zachodniopomorskie</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th scope="row">Ręczność</th>
                <td>
                    <select id="recznosc" name="key_recznosc">
                        <option disabled selected value></option>
                        <option value="1"<?php selected('1', $recznosc); ?>>Praworęczny</option>
                        <option value="2"<?php selected('2', $recznosc); ?>>Leworęczny</option>
                    </select>
                </td>
            </tr>
            <?php
            if ($plec == 1) {
                ?>
                <tr>
                    <th scope="row">Porody</th>
                    <td>
                        <select id="porody" name="key_porody">
                            <option disabled selected value></option>
                            <option value="1" <?php selected('1', $porody); ?>>0</option>
                            <option value="2" <?php selected('2', $porody); ?>>1</option>
                            <option value="3" <?php selected('3', $porody); ?>>2</option>
                            <option value="4" <?php selected('4', $porody); ?>>3 lub więcej</option>
                            </option>
                        </select>
                    </td>
                </tr>
                <?php
            }
            ?>
            <tr>
                <th scope="row">Wykształcenie</th>
                <td>
                    <select id="wyksztalcenie" name="key_wyksztalcenie">
                        <option disabled selected value></option>
                        <option value="1" <?php selected('1', $wyksztalcenie); ?>>Podstawowe</option>
                        <option value="2" <?php selected('2', $wyksztalcenie); ?>>Średnie</option>
                        <option value="3" <?php selected('3', $wyksztalcenie); ?>>Wyższe</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th scope="row">Stan rodzinny</th>
                <td>
                    <select id="stan_rodzinny" name="key_stan_rodzinny">
                        <option disabled selected value></option>
                        <option
                            value="1" <?php selected('1', $stan_rodzinny); ?>><?php if ($plec == 1) echo 'Panna'; else if ($plec == 2) echo 'Kawaler'; ?></option>
                        <option
                            value="2" <?php selected('2', $stan_rodzinny); ?>><?php if ($plec == 1) echo 'Zamężna'; else if ($plec == 2) echo 'Żonaty'; ?></option>
                        <option
                            value="3" <?php selected('3', $stan_rodzinny); ?>><?php if ($plec == 1) echo 'Rozwiedziona'; else if ($plec == 2) echo 'Rozwiedziony'; ?></option>
                        <option
                            value="4" <?php selected('4', $stan_rodzinny); ?>><?php if ($plec == 1) echo 'Wdowa'; else if ($plec == 2) echo 'Wdowiec'; ?></option>
                    </select>
                </td>
            </tr>

            <tr>
                <th scope="row">SM w rodzinie</th>
                <td>
                    <select id="sm_w_rodzinie" name="key_sm_w_rodzinie">
                        <option disabled selected value></option>
                        <option value="1" <?php selected('1', $sm_w_rodzinie); ?>>Tak</option>
                        <option value="2" <?php selected('2', $sm_w_rodzinie); ?>>Nie</option>
                    </select>
                </td>
            </tr>
            <?php
            if (get_role($userid) == 'pacjent') {
                ?>
                <tr>
                    <th scope="row">Data Zgonu</th>
                    <td>
                        <input type="text" id="data_zgonu" class="MyDate" name="key_data_zgonu"
                               value="<?php echo $data_zgonu; ?>"/>
                        <span class="description">yyyy-mm</span>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
        <?php
    }
}

add_action( 'personal_options_update', 'rejsm_update_dane_demograficzne_metadata' );
add_action( 'edit_user_profile_update', 'rejsm_update_dane_demograficzne_metadata' );
function rejsm_update_dane_demograficzne_metadata( $userid ) {
    if( isset( $_POST['key_pesel'] ) ) {
        $var_pesel = $_POST['key_pesel'];
        update_user_meta( $userid, 'pesel', $var_pesel);
    }
    if( isset( $_POST['key_plec'] ) ) {
        $var_plec = $_POST['key_plec'];
        update_user_meta( $userid, 'plec', $var_plec);
    }
    if( isset( $_POST['key_miejsce_zamieszkania'] ) ) {
        $var_miejsce_zamieszkania = $_POST['key_miejsce_zamieszkania'];
        update_user_meta( $userid, 'miejsce_zamieszkania', $var_miejsce_zamieszkania);
    }
    if( isset( $_POST['key_wojewodztwo'] ) ) {
        $var_wojewodztwo = $_POST['key_wojewodztwo'];
        update_user_meta( $userid, 'wojewodztwo', $var_wojewodztwo);
    }
    if( isset( $_POST['key_recznosc'] ) ) {
        $var_recznosc = $_POST['key_recznosc'];
        update_user_meta( $userid, 'recznosc', $var_recznosc);
    }
    if( isset( $_POST['key_porody'] ) ) {
        $var_porody = $_POST['key_porody'];
        update_user_meta( $userid, 'porody', $var_porody);
    }
    if( isset( $_POST['key_wyksztalcenie'] ) ) {
        $var_wyksztalcenie = $_POST['key_wyksztalcenie'];
        update_user_meta( $userid, 'wyksztalcenie', $var_wyksztalcenie);
    }
    if( isset( $_POST['key_stan_rodzinny'] ) ) {
        $var_stan_rodzinny = $_POST['key_stan_rodzinny'];
        update_user_meta( $userid, 'stan_rodzinny', $var_stan_rodzinny);
    }
    if( isset( $_POST['key_zatrudnienie'] ) ) {
        $var_zatrudnienie = $_POST['key_zatrudnienie'];
        update_user_meta( $userid, 'zatrudnienie', $var_zatrudnienie);
    }
    if( isset( $_POST['key_praca_dochod'] ) ) {
        $var_praca_dochod = $_POST['key_praca_dochod'];
        update_user_meta( $userid, 'praca_dochod', $var_praca_dochod);
    }
    if( isset( $_POST['key_sm_w_rodzinie'] ) ) {
        $var_sm_w_rodzinie = $_POST['key_sm_w_rodzinie'];
        update_user_meta( $userid, 'sm_w_rodzinie', $var_sm_w_rodzinie);
    }
    if( isset( $_POST['key_inicjaly'] ) ) {
        $var_inicjaly = $_POST['key_inicjaly'];
        update_user_meta( $userid, 'inicjaly',  $var_inicjaly);
    }
    if( isset( $_POST['key_data_zgonu'] ) ) {
        $var_data_zgonu = $_POST['key_data_zgonu'];
        update_user_meta( $userid, 'data_zgonu', $var_data_zgonu);
    }
    if( isset( $_POST['key_przebieg_choroby'] ) ) {
        $var_przebieg_choroby = $_POST['key_przebieg_choroby'];
        update_user_meta( $userid, 'przebieg_choroby', $var_przebieg_choroby);
    }
    if( isset( $_POST['key_data_rozpoznania_choroby'] ) ) {
        $var_data_rozpoznania_choroby = $_POST['key_data_rozpoznania_choroby'];
        update_user_meta( $userid, 'data_rozpoznania_choroby', $var_data_rozpoznania_choroby);
    }
    if( isset( $_POST['key_data_pierwszych_objawow'] ) ) {
        $var_data_pierwszych_objawow = $_POST['key_data_pierwszych_objawow'];
        update_user_meta( $userid, 'data_pierwszych_objawow', $var_data_pierwszych_objawow);
    }
    if( isset( $_POST['key_badanie_mri'] ) ) {
        $var_badanie_mri = $_POST['key_badanie_mri'];
        update_user_meta( $userid, 'badanie_mri', $var_badanie_mri);
    }
    if( isset( $_POST['key_badanie_plynu'] ) ) {
        $var_badanie_plynu = $_POST['key_badanie_plynu'];
        update_user_meta( $userid, 'badanie_plynu', $var_badanie_plynu);
    }
    if( isset( $_POST['key_badanie_plynu'] ) ) {
        $var_badanie_plynu = $_POST['key_badanie_plynu'];
        update_user_meta( $userid, 'badanie_plynu', $var_badanie_plynu);
    }
    if( isset( $_POST['key_leczenie_immunomodulujace'] ) ) {
        $var_leczenie_immunomodulujace = $_POST['key_leczenie_immunomodulujace'];
        update_user_meta( $userid, 'leczenie_immunomodulujace', $var_leczenie_immunomodulujace);
    }
    if( isset( $_POST['key_leczenie_objawowe'] ) ) {
        $var_leczenie_objawowe = $_POST['key_leczenie_objawowe'];
        update_user_meta( $userid, 'leczenie_objawowe', $var_leczenie_objawowe);
    }
}

//function lista_zmiennych (){
//    $lista = array(
//
//        array( 'Płeć', 'plec'),
//        array( 'Przebieg choroby', 'przebieg_choroby'),
//        array( 'Data pierwszych objawów','data_pierwszych_objawow'),
//        array( 'Data rozpoznania choroby', 'data_rozpoznania_choroby' ),
//        array( 'Badanie MRI', 'badanie_mri'),
//        array( 'Badanie płynu mózgowo-rdzeniowego', 'badanie_plynu'),
//        array( 'Leczenie immunomodulujące', 'leczenie_immunomodulujace'),
//        array( 'Leczenie objawowe', 'leczenie_objawowe'),
//        array( 'Zatrudnienie / praca', 'praca'),
//        array( 'Dochód z pracy', 'dochod'),
//
//        array( 'Miejsce zamieszkania', 'miejsce_zamieszkania'),
//        array( 'Województwo', 'wojewodztwo'),
//        array( 'Ręczność', 'recznosc'),
//        array( 'Porody', 'porody'),
//        array( 'Wykształcenie', 'wyksztalcenie'),
//        array( 'Stan rodzinny', 'stan_rodzinny'),
//        array( 'SM w rodzinie', 'sm_w_rodzinie'),
//        array( 'Data Zgonu', 'data_zgonu'),
//
//    );
//    return $lista;
//}
//
//function wybory(){
//    $wybor = array(
//
//        array('',''),
//    );
//    return $wybor;
//}
//    $userid = $user->ID;
//    $a = lista_zmiennych();
//    $user_meta = array();
//    for ($i = 0; $i < count($a); $i++){
//        $user_meta[$i] = get_user_meta( $userid, $a[$i][1], true );
//
//    }
//    for ($i = 0; $i < count($a); $i++){
//        echo $a[$i][0];
//        echo $user_meta[$i];
//        echo '<BR>';
//    }
//
//
?>