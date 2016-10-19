<?php

/**
 * Created by PhpStorm.
 * User: mrevening
 * Date: 2016-09-18
 * Time: 16:48
 */

//require_once WP_PLUGIN_DIR . '/rejsm_superwtyczka/includes/rejsm_listy.php';

class rejsm_migrate
{
    private $db;
    private $limit_users = ' ORDER BY PESEL ASC LIMIT 20';//' '; //WHERE PESEL LIKE 57112417752
    private $limit_patients = ' ORDER BY PESEL ASC LIMIT 10';//LIMIT 50
    private $limit_lekarze = 'LIMIT 1';// LIMIT 20';
    public function __construct() {
        // Connect To Database
        try {
//            $this->db = new wpdb('mrevening', 'Pmy2tDLS3Ve5NPYD', 'freshpress', 'localhost');
//            $this->db = new wpdb('dwieczo1', '9BHRsd7p', 'dwieczo1', 'mysql.agh.edu.pl');
            $this->db = new wpdb('mrevening', 'Pmy2tDLS3Ve5NPYD', 'rejsm_original', 'localhost');
//            $this->db = new wpdb(DB_USER, DB_PASS, DB_NAME, DB_HOST);
            $this->db->show_errors(); // Debug
        } catch (Exception $e) {    // Database Error
            echo $e->getMessage();
        }
    }
    private function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';//!@#$%^&*()_+=-[]}{;:/.,<>?';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 15; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
    private function add_category_msis_29 ($wynik)
    {
        $kategoria = '';
        if ($wynik >= 0 && $wynik <= 29) $kategoria = 'minimalny';
        if ($wynik >= 30 && $wynik <= 58) $kategoria = 'średni';
        if ($wynik >= 59 && $wynik <= 87) $kategoria = 'mocny';
        if ($wynik >= 88 && $wynik <= 116) $kategoria = 'bardzo mocny';
        return $kategoria;
    }
    private function add_category_eq5d ($wynik) {
        $kategoria ='';
        if ( $wynik >= 1 && $wynik <= 25 ) $kategoria = 'bardzo złe';
        if ( $wynik >= 26 && $wynik <= 50 ) $kategoria = 'złe';
        if ( $wynik >= 51 && $wynik <= 75 ) $kategoria = 'dobre';
        if ( $wynik >= 76 && $wynik <= 100 ) $kategoria = 'bardzo dobre';
        return $kategoria;
    }
//    public function create_users_from_patients()
//    {

//        $sql = "SELECT PESEL, email, password FROM patients ORDER BY PESEL ASC LIMIT 10";
//        $dane_patient = $this->db->get_results($sql, OBJECT);
//        if ($this->db->last_error) {
//            echo "Błąd podczas pobierania metadanych z modulu pacjenta. ";
//            return new WP_Error('broke', __("Błąd podczas pobierania metadanych. "));
//        }
//        foreach ($dane_patient as $row_dane) {
//            $userdata = array(
//                'user_login' => $row_dane->{'PESEL'},
//                'user_email' => $row_dane->{'email'},
//                'user_pass'  => $row_dane->{'password'},
//                'role'       => 'pacjent',
//            );

//            if ( username_exists($row_dane->{'PESEL'} ) ) {
//                echo $row_dane->{'PESEL'} . " -> Użytkownik już istnieje. " ;
////                    return new WP_Error('broke', __($row_dane->{'PESEL'}." -> Użytkownik już istnieje. ") );
//            }
//            else {
//                $user_created_new_id = wp_insert_user($userdata);
//                echo $row_dane->{'PESEL'};
//                echo " -> ";

//                $sql = "SELECT `PESEL`, `MiejsceZamieszkania`, `Wojewodztwo`, `StanRodzinny`, `Wyksztalcenie`, `Porody`, `SMwRodzinie`
//                         FROM `patients_demog` WHERE `PESEL` = " . $row_dane->{'PESEL'};
//                $row = $this->db->get_row($sql, OBJECT);
//                if( empty ($row) ){
//                    echo "DEMOGR,  ";
//                }
//                else {
//                    echo "demogr,  ";
//                    add_user_meta($user_created_new_id, 'miejsce_zamieszkania', $row->{'MiejsceZamieszkania'});
//                    add_user_meta($user_created_new_id, 'wojewodztwo', $row->{'Wojewodztwo'});
//                    add_user_meta($user_created_new_id, 'stan_rodzinny', $row->{'StanRodzinny'});
//                    add_user_meta($user_created_new_id, 'wyksztalcenie', $row->{'Wyksztalcenie'});
//                    add_user_meta($user_created_new_id, 'porody', $row->{'Porody'});
//                    add_user_meta($user_created_new_id, 'sm_w_rodzinie', $row->{'SMwRodzinie'});
//                }
//                $sql = "SELECT Pesel, PostacSM, PierwszeObjawyData, DiagnozaSM, Mri, BadaniePlynu, Immunomodulujace, Objawowe, Praca, PracaZarobek
//                        FROM patients_eurems WHERE PESEL = " . $row_dane->{'PESEL'};
//                $row = $this->db->get_row($sql, OBJECT);
//                if ( empty ($row) ){
//                    echo "EUREMS, ";
//                }
//                else {
//                    echo "eurems, ";
//                    add_user_meta($user_created_new_id, 'przebieg_choroby', $row->{'PostacSM'});
//                    add_user_meta($user_created_new_id, 'data_pierwszych_objawow', $row->{'PierwszeObjawyData'});
//                    add_user_meta($user_created_new_id, 'data_rozpoznania_choroby', $row->{'DiagnozaSM'});
//                    add_user_meta($user_created_new_id, 'badanie_mri', $row->{'BadaniePlynu'});
//                    add_user_meta($user_created_new_id, 'leczenie_immunomodulujace', $row->{'Immunomodulujace'});
//                    add_user_meta($user_created_new_id, 'leczenie_objawowe', $row->{'Objawowe'});
//                    add_user_meta($user_created_new_id, 'zatrudnienie', $row->{'Praca'});
//                    add_user_meta($user_created_new_id, 'praca_dochod', $row->{'PracaZarobek'});
//                    add_user_meta($user_created_new_id, 'badanie_mri', $row->{'Mri'});

//                }
//                $sql = "SELECT *
//                        FROM patients_msis WHERE PESEL = " . $row_dane->{'PESEL'};
//                $row = $this->db->get_row($sql, OBJECT);
//                if ( empty ($row) ){
//                    echo "MSIS29, ";
//                }
//                else {
//                    echo "msis29, ";
//                    $list = array (
//                        'physical_activity',
//                        'grabbing',
//                        'carrying',

//                        'balance',
//                        'room_movement',
//                        'clumsiness',
//                        'stiffness',
//                        'leg_arms_heavy',
//                        'leg_arms_shakes',
//                        'leg_arms_contraption',
//                        'no_body_control',
//                        'activity_dependancy',

//                        'visitation_limitation',
//                        'prolonged_home_stay',
//                        'hands_usage_problem',
//                        'activity_time_limitation',
//                        'transport_usage_problem',
//                        'longer_activity_completion',
//                        'spontaneous_activity_problem',
//                        'urgent_bathroom_visit',
//                        'bad_mood',
//                        'sleep_problem',
//                        'mental_fatigue',
//                        'fear_of_SM',
//                        'stress_anxiety',
//                        'irritation_impatience_impulsiveness',
//                        'concentration_problems',
//                        'lack_of_confidence',
//                        'depression',
//                    );
//                    $title = 'Ankieta msis_29_'.$user_created_new_id.'_'.$row->{'Data'};
//                    $my_post = array(
//                        'post_type'     => 'msis_29',
//                        'post_title'    => $title,
//                        'post_status'   => 'publish',
//                        'post_author'   => $user_created_new_id,
//                        'post_date'     => $row->{'Data'},
//                    );
//                    $id = wp_insert_post( $my_post );
//                    $j=1;
//                    $wynik = 0;
//                    foreach ($list as $name ) {
//                        $name2 = '_rejsm_msis_29_'.$j;
//                        $value = $row->{$name}-1;
//                        update_post_meta($id, $name2, $value );
//                        $wynik = $wynik + $value;
//                        $j++;
//                    }
//                    update_post_meta($id, '_msis_29_wynik', $wynik );
//                    wp_set_object_terms( $id, self::add_category_msis_29($wynik), 'kategoria_msis_29',  false ); //add_category_msis_29(intval($wynik))
//                }

//                $sql5 = "SELECT *
//                         FROM patients_eq5d WHERE PESEL = " . $row_dane->{'PESEL'};

//                $row = $this->db->get_row($sql5, OBJECT);
//                if ($this->db->last_error) {
//                    return new WP_Error('broke', __("Błąd podczas pobierania metadanych w eq5d. "));
//                } else if ( empty ($row) ){
//                    echo " EQ5D ";
//                }
//                else {
//                    echo "eq5d ";

//                    $list = array (
//                        'movement',
//                        'self_care',
//                        'normal_activity',
//                        'pain_discomfort',
//                        'anxiety_depression',
//                        'health_total',
//                    );
//                    $title = 'Ankieta eq5d_'.$user_created_new_id.'_'.$row->{'Data'};
//                    $my_post = array(
//                        'post_type'     => 'eq5d',
//                        'post_title'    => $title,
//                        'post_status'   => 'publish',
//                        'post_author'   => $user_created_new_id,
//                        'post_date'     => $row->{'Data'},
//                    );
//                    $id = wp_insert_post( $my_post );
//                    $j=1;
//                    foreach ($list as $name ) {
//                        if ($name == 'health_total')  $name2 = '_eq5d_wynik';
//                        else  $name2 = '_rejsm_eq5d_'.$j;
//                        $value = $row->{$name};
//                        update_post_meta($id, $name2, $value );
//                        $j++;
//                    }
//                    wp_set_object_terms( $id, self::add_category_eq5d($row->{'health_total'}), 'kategoria_eq5d',  false ); //add_category_msis_29(intval($wynik))
//                }
//            }
//            echo "</BR>";
//        }
//    }
    private function insert_ankieta($tytul, $user_id, $row, $list){
        if ($row == NULL) return;
        $my_post = array();
        switch ($tytul) {
            case 'patients_msis':
                $title = 'Ankieta msis_29_'.$user_id.'_'.$row->{'Data'};
                $my_post = array(
                    'post_type' => 'msis_29',
                    'post_title' => $title,
                    'post_status' => 'publish',
                    'post_author' => $user_id,
                    'post_date' => $row->{'Data'},
                );
                break;
            case 'patients_eq5d':
                $title = 'Ankieta eq5d_'.$user_id.'_'.$row->{'Data'};
                $my_post = array(
                    'post_type' => 'eq5d',
                    'post_title' => 'eq5d',
                    'post_status' => 'publish',
                    'post_author' => $user_id,
                    'post_date' => $row->{'Data'},
                );
                break;
        }
        $id = wp_insert_post( $my_post );
        $j=1;
        $wynik = 0;
        switch ($tytul) {
            case 'patients_msis':
                foreach ($list as $name ) {
                    $name2 = '_rejsm_msis_29_'.$j;
                    $value = $row->{$name}-1;
                    update_post_meta($id, $name2, $value );
                    $wynik = $wynik + $value;
                    $j++;
                }
                update_post_meta($id, '_msis_29_wynik', $wynik );
                wp_set_object_terms( $id, self::add_category_msis_29($wynik), 'kategoria_msis_29',  false ); //add_category_msis_29(intval($wynik))
                break;
            case 'patients_eq5d':
                foreach ($list as $name ) {
                    $name2 = '_rejsm_eq5d_'.$j;
                    $value = $row->{$name}-1;
                    update_post_meta($id, $name2, $value );
                    $wynik = $wynik + $value;
                    $j++;
                }
                update_post_meta($id, '_eq5d_wynik', $wynik );
                wp_set_object_terms( $id, self::add_category_eq5d($wynik), 'kategoria_eq5d',  false ); //add_category_eq5d(intval($wynik))
                break;
        }
    }

//    public function create_users_from_dane_demograficzne ()
//    {
//        $sql = "SELECT Pesel, Plec, MiejsceZamieszkania, Wojewodztwo, Recznosc, Porody, Wyksztalcenie, StanRodzinny, Zatrudnienie,
//                        SMwRodzinie, Inicjaly, PracaZarobek, Data_zgonu, Deleted FROM danedemograficzne Limit ".$this->limit;//WHERE PESEL = ".$row_dane->{'PESEL'};
//        $dane = $this->db->get_results($sql, OBJECT);
//        if ($this->db->last_error) {
//            echo "Błąd podczas pobierania metadanych z dane_demograficzne. ";
//            return new WP_Error('broke', __("Błąd podczas pobierania metadanych. "));
//        }
//        foreach ($dane as $row) {
//            if ( username_exists($row->{'Pesel'} ) ) {
//                echo $row->{'Pesel'} . " -> Użytkownik już istnieje. " ;
//            }
//            else if( $row->{'Deleted'} == 0) {
//                echo $row->{'Pesel'} . " dane_demogr, ";
//                $userdata = array(
//                    'user_login' => $row->{'Pesel'},
//                    'user_email' => $row->{'Pesel'} . '_zastepczy@mail.com',
//                    'user_pass' => self::randomPassword(),
//                    'role' => 'pacjent',
//                    'nickname' => $row->{'Inicjaly'},
//                );
//                $user_created_new_id = wp_insert_user($userdata);
//                add_user_meta($user_created_new_id, 'miejsce_zamieszkania', $row->{'MiejsceZamieszkania'});
//                add_user_meta($user_created_new_id, 'wojewodztwo', $row->{'Wojewodztwo'});
//                add_user_meta($user_created_new_id, 'recznosc', $row->{'Recznosc'});
//                add_user_meta($user_created_new_id, 'porody', $row->{'Porody'});
//                add_user_meta($user_created_new_id, 'wyksztalcenie', $row->{'Wyksztalcenie'});
//                add_user_meta($user_created_new_id, 'stan_rodzinny', $row->{'StanRodzinny'});
//                add_user_meta($user_created_new_id, 'zatrudnienie', $row->{'Zatrudnienie'});
//                add_user_meta($user_created_new_id, 'praca_dochod', $row->{'PracaZarobek'});
//                add_user_meta($user_created_new_id, 'sm_w_rodzinie', $row->{'SMwRodzinie'});
//                add_user_meta($user_created_new_id, 'data_zgonu', $row->{'Data_zgonu'});


//                $sql = "SELECT * FROM wywiad WHERE PESEL = ".$row->{'Pesel'};
//                $wywiad = $this->db->get_row($sql, OBJECT);
////                echo $sql;
////                if(is_object($wywiad)) echo 'obiekt'; else echo 'nieobiekt';
////                if(is_array($wywiad)) echo 'array'; else echo 'niearray';
//                if ($this->db->last_error) {
//                    echo "Błąd podczas pobierania metadanych z dane_demograficzne. ";
//                    return new WP_Error('broke', __("Błąd podczas pobierania metadanych. "));
//                }
////                var_dump( $wywiad);
////                echo $wywiad;
//                add_user_meta($user_created_new_id, 'pierwsze_objawy', $wywiad->{'PierwszeObjawy'});
//                add_user_meta($user_created_new_id, 'pierwsze_objawy_data', $wywiad->{'PierwszeObjawyData'});
//                add_user_meta($user_created_new_id, 'diagnozaSM', $wywiad->{'DiagnozaSM'});
//                add_user_meta($user_created_new_id, 'zapalenie_nerwow_wzrokowych', $wywiad->{'ZapalenieNerwowWzrokowych'});
//                add_user_meta($user_created_new_id, 'nadcisnienie_tetnicze', $wywiad->{'NadcisnienieTetnicze'});
//                add_user_meta($user_created_new_id, 'cukrzyca', $wywiad->{'Cukrzyca'});
//                add_user_meta($user_created_new_id, 'tarczyca', $wywiad->{'Tarczyca'});
//                add_user_meta($user_created_new_id, 'zakrzepowozatorowe', $wywiad->{'ZakrzepowoZatorowe'});
//                add_user_meta($user_created_new_id, 'nowotwory', $wywiad->{'Nowotwory'});
//                add_user_meta($user_created_new_id, 'postacSM', $wywiad->{'PostacSM'});
//                add_user_meta($user_created_new_id, 'kryterium_McDonald', $wywiad->{'KryteriumMcDonald'});
//            }
//            echo "</BR>";
//        }
//        echo "</BR>";
//    }
    private function get_lista($tabela){
        $lista = array();
        switch ($tabela){
            case 'patients_demog':
                $lista = array(
                    //'PESEL',
                    'MiejsceZamieszkania',
                    'Wojewodztwo',
                    'StanRodzinny',
                    'Wyksztalcenie',
                    'Porody',
                    'SMwRodzinie');
                break;
            case 'patients_eurems':
                $lista = array(
                    'PostacSM',
                    'PierwszeObjawyData',
                    'DiagnozaSM',
                    'Mri',
                    'BadaniePlynu',
                    'Immunomodulujace',
                    'Objawowe',
                    'Praca');
                break;
            case 'patients_msis':
                $lista = array (
                    'physical_activity',
                    'grabbing',
                    'carrying',
                    'balance',
                    'room_movement',
                    'clumsiness',
                    'stiffness',
                    'leg_arms_heavy',
                    'leg_arms_shakes',
                    'leg_arms_contraption',
                    'no_body_control',
                    'activity_dependancy',
                    'visitation_limitation',
                    'prolonged_home_stay',
                    'hands_usage_problem',
                    'activity_time_limitation',
                    'transport_usage_problem',
                    'longer_activity_completion',
                    'spontaneous_activity_problem',
                    'urgent_bathroom_visit',
                    'bad_mood',
                    'sleep_problem',
                    'mental_fatigue',
                    'fear_of_SM',
                    'stress_anxiety',
                    'irritation_impatience_impulsiveness',
                    'concentration_problems',
                    'lack_of_confidence',
                    'depression',
                );
                break;
            case 'patients_eq5d':
                $lista = array (
                    'movement',
                    'self_care',
                    'normal_activity',
                    'pain_discomfort',
                    'anxiety_depression',
                    'health_total',
                );
                break;
            case 'danedemograficzne':
                $lista = array(
                    'MiejsceZamieszkania',
                    'Wojewodztwo',
                    'Recznosc',
                    'Porody',
                    'Wyksztalcenie',
                    'StanRodzinny',
                    'Zatrudnienie',
                    'SMwRodzinie',
                    'PracaZarobek',
                    'Data_zgonu');
                break;
            case 'wywiad':
                $lista = array(
                    'PierwszeObjawy',
                    'PierwszeObjawyData',
                    'DiagnozaSM',
                    'ZapalenieNerwowWzrokowych',
                    'NadcisnienieTetnicze',
                    'Cukrzyca',
                    'Tarczyca',
                    'ZakrzepowoZatorowe',
                    'Nowotwory',
                    'PostacSM',
                    'KryteriumMcDonald',
                );
                break;
            case 'mri':
                $lista = array(
                    'Data',
                );
                break;
            case 'potencjaly':
                $lista = array(
                    'Potencjaly',
                    'DodatniUjemny'
                    );
                break;
            case 'plynmozgowy':
                $lista = array(
                    'BadaniePlynu',
                    'Prazki',
                    );
                break;

        }
        return $lista;
    }
    private function add_user_metas($user_id, $lista, $row, $tryb='single' ){
        if ($row == NULL) return;
        foreach ($lista as $kolumna) {
        switch ($tryb) {
            case 'single':
                {
                    add_user_meta($user_id, $kolumna, $row->$kolumna);
                }
                break;
            case 'multiple':
                foreach ($row as $single_row){
                    $prev_value = get_user_meta ($user_id, $kolumna, 'true');
                    //var_dump ($prev_value);
                    if( $prev_value ) {
                        $new_value = $prev_value . ', ' . $single_row->$kolumna;
                        //echo $new_value;
                        update_user_meta($user_id, $kolumna, $new_value);
                    }
                    else {
                        $new_value = $single_row->$kolumna;
                        //echo $new_value;
                        add_user_meta($user_id, $kolumna, $new_value);
                        //echo ( get_user_meta ($user_id, $kolumna, 'true'));
                    }

                    //echo "jestem";
                    //var_dump ($prev_value);
                    //var_dump ($new_value);
                }
            break;
            }
        }
    }



    private function create_new_user($user_dane, $pesel_nazwa){
        if (username_exists($user_dane->$pesel_nazwa)) echo $user_dane->$pesel_nazwa . " -> Użytkownik już istnieje. ";
//        else if ($user_dane->deleted == 0) {
//            echo $user_dane->{'Pesel'} . " podstawowe dane ok,  ";
            $userdata = array(
                'user_login' => $user_dane->$pesel_nazwa,
                'user_email' => $user_dane->$pesel_nazwa . '_zastepczy@mail.com',
                'user_pass' => self::randomPassword(),
                'role' => 'pacjent',
//                'nickname' => $user_dane->Inicjaly,
            );
            return wp_insert_user($userdata);
        }
//    }



    public function create_users (){
        $sql = "SELECT * FROM danedemograficzne " .$this->limit_users;
        $danedemograficzne_wszystkich_pacjentow = $this->db->get_results($sql, OBJECT);
        $user_created_new_id = 0;
        $user_dane = array();
        $nazwy_tabeli = array('danedemograficzne','wywiad', 'mri', 'potencjaly');
        foreach ($danedemograficzne_wszystkich_pacjentow as $dane_pacjenta) {

            wp_insert_post( array(
                'post_type' => 'dane_pacjenta',
                'post_title' => $dane_pacjenta->Pesel,
                'post_status' => 'publish',
                'post_author' => $dane_pacjenta->Pesel,
                 )
            );



            if ( isset( $dane_pacjenta->Pesel )) $pesel = $dane_pacjenta->Pesel;
            else {echo '</BR>nie ma pesla'; return;}

            foreach ($nazwy_tabeli as $tabela) {
                $tryb = 'single';
                switch ($tabela) {
                    case 'danedemograficzne':
                        $user_created_new_id = $this->create_new_user($dane_pacjenta, 'Pesel');
                        $user_dane = $dane_pacjenta;
                        break;
                    case 'mri':
                        $tryb = 'multiple';
                        $sql = "SELECT * FROM ".$tabela." WHERE PESEL = ".$pesel;
                        $user_dane = $this->db->get_results($sql, OBJECT);
                        break;
                    //case 'potencjaly':
                    //case 'plynmozgowy'
                    //case 'wywiad':
                    default:
                        $sql = "SELECT * FROM ".$tabela." WHERE PESEL = ".$pesel;
                        $user_dane = $this->db->get_row($sql, OBJECT);
                        break;
                }
                //var_dump ($user_dane);
                $lista = $this->get_lista($tabela);
                $this->add_user_metas($user_created_new_id, $lista, $user_dane, $tryb);
            }
        }
    }
    public function create_patients()
    {
        $sql = "SELECT PESEL, email, password FROM patients  ".$this->limit_patients;
        $dane_podstawowe_pacjentow = $this->db->get_results($sql, OBJECT);
        $user_created_new_id = 0;
        $user_dane = array();
        $nazwy_tabeli = array('patients', 'patients_demog', 'patients_eurems');
        $nazwy_tabeli_taksonomii = array( 'patients_eq5d', 'patients_msis');
        foreach ($dane_podstawowe_pacjentow as $dane_pacjenta) {
            $pesel = $dane_pacjenta->PESEL;
            //echo $pesel.'</BR>';
            foreach ($nazwy_tabeli as $tabela) {
                switch ($tabela) {
                    case 'patients':
                        $user_created_new_id = $this->create_new_user($dane_pacjenta, 'PESEL');
                        $user_dane = $dane_pacjenta;
                        break;
                    case 'patients_eurems':
                    case 'patients_demog':
                        $sql = "SELECT * FROM ".$tabela." WHERE `PESEL` = " . $pesel;
                        $user_dane = $this->db->get_row($sql, OBJECT);
                        break;
                }
                $lista = $this->get_lista($tabela,'lista');
                $this->add_user_metas($user_created_new_id, $lista, $user_dane);
            }
            foreach ($nazwy_tabeli_taksonomii as $tabela) {
                $lista = $this->get_lista($tabela, 'lista');
                $sql = "SELECT * FROM ".$tabela." WHERE PESEL = " . $pesel;
                $user_dane = $this->db->get_row($sql, OBJECT);
                //echo ('<pre>');
                //var_dump ($user_dane);
                //echo ('</pre>');
                $this->insert_ankieta($tabela, $user_created_new_id, $user_dane, $lista);
            }
        }
    }
    public function create_lekarze ()
    {
        $sql = "SELECT UserName, UserPassword, UserImie, UserNazwisko, SzpitalMiasto, Admin FROM users ".$this->limit_lekarze;
        $dane = $this->db->get_results($sql, OBJECT);
        if ($this->db->last_error) {
            echo "Błąd podczas pobierania metadanych lekarzy. ";
            return new WP_Error('broke', __("Błąd podczas pobierania metadanych. "));
        }
        foreach ($dane as $row) {
            $rola = $row->{'Admin'};
            if ($rola == '2') $rola = 'administrator';
            else if ($rola == '0' || $rola == '1') $rola = 'lekarz';
            //echo $row->{'UserName'} . " created ";
            $userdata = array(
                'user_login' => $row->{'UserImie'} . ' ' . $row->{'UserNazwisko'},
                'user_email' => $row->{'UserName'},
                'user_pass' => $row->{'UserPassword'},
                'role' => $rola,
            );
            if (!email_exists($row->{'UserName'})) {
                $user_created_new_id = wp_insert_user($userdata);
                $term = $row->{'SzpitalMiasto'};
                $taxonomy = 'szpital';
                if (taxonomy_exists($taxonomy) && !term_exists($term, $taxonomy)) {
                    wp_insert_term($term, $taxonomy);
                    echo 'dodaje nowy term';
                }
                wp_set_object_terms($user_created_new_id, $term, $taxonomy, true);
                //echo ' ' . $rola;
            }
            echo "</BR>";
        }
    }
}