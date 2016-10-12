<?php
require_once dirname(__FILE__) . '/rejsm_script_user_login_string.php';



function rejsm_add_users_oldrejsm( $role = 'pacjent' ) {

    function add_category_msis_29 ($wynik)
    {
        $kategoria = '';
        if ($wynik >= 0 && $wynik <= 29) $kategoria = 'minimalny';
        if ($wynik >= 30 && $wynik <= 58) $kategoria = 'średni';
        if ($wynik >= 59 && $wynik <= 87) $kategoria = 'mocny';
        if ($wynik >= 88 && $wynik <= 116) $kategoria = 'bardzo mocny';
        return $kategoria;
    }
    function add_category_eq5d ($wynik) {
        $kategoria ='';
        if ( $wynik >= 1 && $wynik <= 25 ) $kategoria = 'bardzo złe';
        if ( $wynik >= 26 && $wynik <= 50 ) $kategoria = 'złe';
        if ( $wynik >= 51 && $wynik <= 75 ) $kategoria = 'dobre';
        if ( $wynik >= 76 && $wynik <= 100 ) $kategoria = 'bardzo dobre';
        return $kategoria;

    }

    global $wpdb;
//    rejsm_delete_users_oldrejsm();

    $sql = "SELECT PESEL, email, password FROM patients ORDER BY PESEL ASC LIMIT 30";
    $dane_patient = $wpdb->get_results($sql, OBJECT);
    if ($wpdb->last_error) {

        return new WP_Error('broke', __("Błąd bazy danych. "));
    }else if ( empty ($dane_patient) ) {
        echo "patients FALSE,  ";
    }
    else {
        foreach ($dane_patient as $row_dane) {
           // var_dump($row_dane);

//            echo $i++;
            $userdata = array(
                'user_login' => $row_dane->{'PESEL'},
                'user_email' => 'test_' . $row_dane->{'email'},
                'user_pass' => $row_dane->{'password'},
                'role'      => 'pacjent',
            );

            if (! $user_created_new_id = wp_insert_user($userdata) ) {
                return new WP_Error('broke', __("Użytkownik już istnieje. ") );
            }
            else {


                echo $row_dane->{'PESEL'};
                echo " -> ";

                $sql2 = "SELECT `PESEL`, `MiejsceZamieszkania`, `Wojewodztwo`, `StanRodzinny`, `Wyksztalcenie`, `Porody`, `SMwRodzinie`
                         FROM `patients_demog` WHERE `PESEL` = " . $row_dane->{'PESEL'};
//            echo $row_dane->{'PESEL'};

                $row = $wpdb->get_row($sql2, OBJECT);

//            var_dump($row);
                if ($wpdb->last_error) {
                    return new WP_Error('broke', __("Błąd podczas pobierania metadanych w patients_demog. "));
                } else if ( empty ($row) ){
                    echo "demogr FALSE,  ";
                }
                else {
                    echo "demogr ok,  ";
                    $user = get_user_by('id', $user_created_new_id);
//                    $user->set_role('pacjent');
                    add_user_meta($user_created_new_id, 'miejsce_zamieszkania', $row->{'MiejsceZamieszkania'});
                    add_user_meta($user_created_new_id, 'wojewodztwo', $row->{'Wojewodztwo'});
                    add_user_meta($user_created_new_id, 'stan_rodzinny', $row->{'StanRodzinny'});
                    add_user_meta($user_created_new_id, 'wyksztalcenie', $row->{'Wyksztalcenie'});
                    add_user_meta($user_created_new_id, 'porody', $row->{'Porody'});
                    add_user_meta($user_created_new_id, 'sm_w_rodzinie', $row->{'SMwRodzinie'});
                }


                $sql3 = "SELECT Pesel, PostacSM, PierwszeObjawyData, DiagnozaSM, Mri, BadaniePlynu, Immunomodulujace, Objawowe, Praca, PracaZarobek
                     FROM patients_eurems WHERE PESEL = " . $row_dane->{'PESEL'};

                $row = $wpdb->get_row($sql3, OBJECT);
                if ($wpdb->last_error) {
                    return new WP_Error('broke', __("Błąd podczas pobierania metadanych w eurems. "));
                } else if ( empty ($row) ){
                    echo "eurems FALSE, ";
                }
                else {
                    echo "eurems ok, ";
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




                $sql4 = "SELECT *
                     FROM patients_msis WHERE PESEL = " . $row_dane->{'PESEL'};

                $row = $wpdb->get_row($sql4, OBJECT);
                if ($wpdb->last_error) {
                    return new WP_Error('broke', __("Błąd podczas pobierania metadanych w msis. "));
                } else if ( empty ($row) ){
                    echo " msis29 FALSE";
                }
                else {
                    echo "msis29 ok ";

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

//                        'Wynik',
//                        'Data',
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
//                        echo  $row->{$name2};
                        $j++;
                    }
//                    $wynik = $wynik-29;
                    update_post_meta($id, '_msis_29_wynik', $wynik );

//                    echo ' - wynik = ' . $row->{'Wynik'};
                    wp_set_object_terms( $id, add_category_msis_29($wynik), 'kategoria_msis_29',  false ); //add_category_msis_29(intval($wynik))

//                    echo '</BR>' . $user_created_new_id . ' <- id usera | id postu -> ' . $id . ' | wynik -> '. $row->{'Wynik'} . '</BR>';

                }

                $sql5 = "SELECT *
                     FROM patients_eq5d WHERE PESEL = " . $row_dane->{'PESEL'};

                $row = $wpdb->get_row($sql5, OBJECT);
                if ($wpdb->last_error) {
                    return new WP_Error('broke', __("Błąd podczas pobierania metadanych w eq5d. "));
                } else if ( empty ($row) ){
                    echo " eq5d FALSE";
                }
                else {
                    echo "eq5d ok ";

                    $list = array (
                        'movement',
                        'self_care',
                        'normal_activity',
                        'pain_discomfort',
                        'anxiety_depression',
                        'health_total',
//                        'Wynik',
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
//                    $wynik = 0;

                    foreach ($list as $name ) {
                        if ($name == 'health_total')  $name2 = '_eq5d_wynik';
                        else  $name2 = '_rejsm_eq5d_'.$j;
                        $value = $row->{$name};
                        update_post_meta($id, $name2, $value );
//                        $wynik = $wynik + $value;
//                        echo  $row->{$name2};
                        $j++;
                    }
//                    $wynik = $wynik-29;
//                    update_post_meta($id, '_msis_29_wynik', $wynik );

//                    echo ' - wynik = ' . $row->{'Wynik'};
                    wp_set_object_terms( $id, add_category_eq5d($row->{'health_total'}), 'kategoria_eq5d',  false ); //add_category_msis_29(intval($wynik))

//                    echo '</BR>' . $user_created_new_id . ' <- id usera | id postu -> ' . $id . ' | wynik -> '. $row->{'Wynik'} . '</BR>';

                }








                echo "</BR>";
            }

        }
    }

}

$return = rejsm_add_users_oldrejsm();
if ( is_wp_error( $return )) {
    echo '<div id="message" class="error">Zaistniał błąd podczas wykonywania skryptu. '.$return->get_error_message().'</div>';
}
else {
    echo '<div id="message" class="updated">Pomyślnie wykonano skrypt - dodano użytkowników. </div>';
}


?>