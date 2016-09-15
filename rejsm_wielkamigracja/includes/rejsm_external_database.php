<?php
/**
 * Created by PhpStorm.
 * User: mrevening
 * Date: 2016-09-08
 * Time: 14:32
 */



class CustomDatabase
{
    private $db;

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
    public function create_users_from_dane_demograficzne ()
    {
        $sql = "SELECT Pesel, Plec, MiejsceZamieszkania, Wojewodztwo, Recznosc, Porody, Wyksztalcenie, StanRodzinny, Zatrudnienie,
                        SMwRodzinie, Inicjaly, PracaZarobek, Data_zgonu, Deleted FROM danedemograficzne Limit 10";//WHERE PESEL = ".$row_dane->{'PESEL'};
        $dane = $this->db->get_results($sql, OBJECT);
        if ($this->db->last_error) {
            echo "Błąd podczas pobierania metadanych z dane_demograficzne. ";
            return new WP_Error('broke', __("Błąd podczas pobierania metadanych. "));
        }
        foreach ($dane as $row) {
            if ( username_exists($row->{'Pesel'} ) ) {
                echo $row->{'Pesel'} . " -> Użytkownik już istnieje. " ;
            }
            else if( $row->{'Deleted'} == 0) {
                echo $row->{'Pesel'} . " dane_demogr, ";
                $userdata = array(
                    'user_login' => $row->{'Pesel'},
                    'user_email' => $row->{'Pesel'} . '_zastepczy@mail.com',
                    'user_pass' => self::randomPassword(),
                    'role' => 'pacjent',
                    'nickname' => $row->{'Inicjaly'},
                );
                $user_created_new_id = wp_insert_user($userdata);
                add_user_meta($user_created_new_id, 'miejsce_zamieszkania', $row->{'MiejsceZamieszkania'});
                add_user_meta($user_created_new_id, 'wojewodztwo', $row->{'Wojewodztwo'});
                add_user_meta($user_created_new_id, 'recznosc', $row->{'Recznosc'});
                add_user_meta($user_created_new_id, 'porody', $row->{'Porody'});
                add_user_meta($user_created_new_id, 'wyksztalcenie', $row->{'Wyksztalcenie'});
                add_user_meta($user_created_new_id, 'stan_rodzinny', $row->{'StanRodzinny'});
                add_user_meta($user_created_new_id, 'zatrudnienie', $row->{'Zatrudnienie'});
                add_user_meta($user_created_new_id, 'praca_dochod', $row->{'PracaZarobek'});
                add_user_meta($user_created_new_id, 'sm_w_rodzinie', $row->{'SMwRodzinie'});
                add_user_meta($user_created_new_id, 'data_zgonu', $row->{'Data_zgonu'});
            }
            echo "</BR>";
        }
        echo "</BR>";
    }

    public function create_users_from_patients() {

        $sql = "SELECT PESEL, email, password FROM patients ORDER BY PESEL ASC LIMIT 10";
        $dane_patient = $this->db->get_results($sql, OBJECT);
        if ($this->db->last_error) {
            echo "Błąd podczas pobierania metadanych z modulu pacjenta. ";
            return new WP_Error('broke', __("Błąd podczas pobierania metadanych. "));
        }
        foreach ($dane_patient as $row_dane) {
            $userdata = array(
                'user_login' => $row_dane->{'PESEL'},
                'user_email' => $row_dane->{'email'},
                'user_pass'  => $row_dane->{'password'},
                'role'       => 'pacjent',
            );

            if ( username_exists($row_dane->{'PESEL'} ) ) {
                echo $row_dane->{'PESEL'} . " -> Użytkownik już istnieje. " ;
//                    return new WP_Error('broke', __($row_dane->{'PESEL'}." -> Użytkownik już istnieje. ") );
            }
            else {
                $user_created_new_id = wp_insert_user($userdata);
                echo $row_dane->{'PESEL'};
                echo " -> ";

                $sql = "SELECT `PESEL`, `MiejsceZamieszkania`, `Wojewodztwo`, `StanRodzinny`, `Wyksztalcenie`, `Porody`, `SMwRodzinie`
                         FROM `patients_demog` WHERE `PESEL` = " . $row_dane->{'PESEL'};
                $row = $this->db->get_row($sql, OBJECT);
                if( empty ($row) ){
                    echo "DEMOGR,  ";
                }
                else {
                    echo "demogr,  ";
                    add_user_meta($user_created_new_id, 'miejsce_zamieszkania', $row->{'MiejsceZamieszkania'});
                    add_user_meta($user_created_new_id, 'wojewodztwo', $row->{'Wojewodztwo'});
                    add_user_meta($user_created_new_id, 'stan_rodzinny', $row->{'StanRodzinny'});
                    add_user_meta($user_created_new_id, 'wyksztalcenie', $row->{'Wyksztalcenie'});
                    add_user_meta($user_created_new_id, 'porody', $row->{'Porody'});
                    add_user_meta($user_created_new_id, 'sm_w_rodzinie', $row->{'SMwRodzinie'});
                }
                $sql = "SELECT Pesel, PostacSM, PierwszeObjawyData, DiagnozaSM, Mri, BadaniePlynu, Immunomodulujace, Objawowe, Praca, PracaZarobek
                        FROM patients_eurems WHERE PESEL = " . $row_dane->{'PESEL'};
                $row = $this->db->get_row($sql, OBJECT);
                if ( empty ($row) ){
                    echo "EUREMS, ";
                }
                else {
                    echo "eurems, ";
                    add_user_meta($user_created_new_id, 'przebieg_choroby', $row->{'PostacSM'});
                    add_user_meta($user_created_new_id, 'data_pierwszych_objawow', $row->{'PierwszeObjawyData'});
                    add_user_meta($user_created_new_id, 'data_rozpoznania_choroby', $row->{'DiagnozaSM'});
                    add_user_meta($user_created_new_id, 'badanie_mri', $row->{'BadaniePlynu'});
                    add_user_meta($user_created_new_id, 'leczenie_immunomodulujace', $row->{'Immunomodulujace'});
                    add_user_meta($user_created_new_id, 'leczenie_objawowe', $row->{'Objawowe'});
                    add_user_meta($user_created_new_id, 'zatrudnienie', $row->{'Praca'});
                    add_user_meta($user_created_new_id, 'praca_dochod', $row->{'PracaZarobek'});
                    add_user_meta($user_created_new_id, 'badanie_mri', $row->{'Mri'});

                }
                $sql = "SELECT *
                        FROM patients_msis WHERE PESEL = " . $row_dane->{'PESEL'};
                $row = $this->db->get_row($sql, OBJECT);
                if ( empty ($row) ){
                    echo "MSIS29, ";
                }
                else {
                    echo "msis29, ";
                    $list = array (
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
                    $title = 'Ankieta msis_29_'.$user_created_new_id.'_'.$row->{'Data'};
                    $my_post = array(
                        'post_type'     => 'msis_29',
                        'post_title'    => $title,
                        'post_status'   => 'publish',
                        'post_author'   => $user_created_new_id,
                        'post_date'     => $row->{'Data'},
                    );
                    $id = wp_insert_post( $my_post );
                    $j=1;
                    $wynik = 0;
                    foreach ($list as $name ) {
                        $name2 = '_rejsm_msis_29_'.$j;
                        $value = $row->{$name}-1;
                        update_post_meta($id, $name2, $value );
                        $wynik = $wynik + $value;
                        $j++;
                    }
                    update_post_meta($id, '_msis_29_wynik', $wynik );
                    wp_set_object_terms( $id, self::add_category_msis_29($wynik), 'kategoria_msis_29',  false ); //add_category_msis_29(intval($wynik))
                }

                $sql5 = "SELECT *
                         FROM patients_eq5d WHERE PESEL = " . $row_dane->{'PESEL'};

                $row = $this->db->get_row($sql5, OBJECT);
                if ($this->db->last_error) {
                    return new WP_Error('broke', __("Błąd podczas pobierania metadanych w eq5d. "));
                } else if ( empty ($row) ){
                    echo " EQ5D ";
                }
                else {
                    echo "eq5d ";

                    $list = array (
                        'movement',
                        'self_care',
                        'normal_activity',
                        'pain_discomfort',
                        'anxiety_depression',
                        'health_total',
                    );
                    $title = 'Ankieta eq5d_'.$user_created_new_id.'_'.$row->{'Data'};
                    $my_post = array(
                        'post_type'     => 'eq5d',
                        'post_title'    => $title,
                        'post_status'   => 'publish',
                        'post_author'   => $user_created_new_id,
                        'post_date'     => $row->{'Data'},
                    );
                    $id = wp_insert_post( $my_post );
                    $j=1;
                    foreach ($list as $name ) {
                        if ($name == 'health_total')  $name2 = '_eq5d_wynik';
                        else  $name2 = '_rejsm_eq5d_'.$j;
                        $value = $row->{$name};
                        update_post_meta($id, $name2, $value );
                        $j++;
                    }
                    wp_set_object_terms( $id, self::add_category_eq5d($row->{'health_total'}), 'kategoria_eq5d',  false ); //add_category_msis_29(intval($wynik))
                    }
                }
            echo "</BR>";
        }
    }

    public function create_lekarze_from_users ()
    {
        $sql = "SELECT UserName, UserPassword, UserImie, UserNazwisko, SzpitalMiasto, Admin FROM users ";
        $dane = $this->db->get_results($sql, OBJECT);
        if ($this->db->last_error) {
            echo "Błąd podczas pobierania metadanych lekarzy. ";
            return new WP_Error('broke', __("Błąd podczas pobierania metadanych. "));
        }
        foreach ($dane as $row) {
            $rola = $row->{'Admin'};
            if ($rola == '2') $rola = 'administrator';
            else if ($rola == '0' || $rola == '1') $rola = 'lekarz';
            echo $row->{'UserName'} . " created ";
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
                echo ' ' . $rola;
            }
            echo "</BR>";
        }
    }



//
//    // Example Query #2 -- Update Student Name
//    public function update_student_id($student_id, $student_name) {
//        return $this->db->update(
//            'students',
//            array('student_name' => $student_name),
//            array('student_id' => $student_id),
//            array('%s'), array('%d')
//        );
//    }
}
$Custom_DB = new CustomDatabase;
$Custom_DB->create_users_from_patients();
$Custom_DB->create_users_from_dane_demograficzne();
$Custom_DB->create_lekarze_from_users();
if ( is_wp_error( $Custom_DB )) {
    echo '<div id="message" class="error">Zaistniał błąd podczas wykonywania skryptu. '.$return->get_error_message().'</div>';
}
else {
    echo '<div id="message" class="updated">Pomyślnie wykonano skrypt - dodano użytkowników</div>';
}

?>