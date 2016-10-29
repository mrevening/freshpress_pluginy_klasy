<?php
/**
 * Created by PhpStorm.
 * User: mrevening
 * Date: 2016-09-17
 * Time: 18:22
 */

function get_lista($tabele, $type){

    $lista = array();
    $listy = array();

    foreach ((array)$tabele as $tabela){
        switch ($tabela){
            case 'patients_demog':
                switch ($type) {
                    case 'tytuly_typy':
                        $lista = array(
                            'MiejsceZamieszkania',
                            'Wojewodztwo',
                            'StanRodzinny',
                            'Wyksztalcenie',
                            'Porody',
                            'SMwRodzinie'
                        );
                        break;
                }
                break;
            case 'patients_eurems':
                switch ($type){
                    case 'tytuly_typy':
                        $lista = array (
                            'Plec'=> array( 'Płeć', 'drop-down-plec'),
                            'PostacSM' => array ('Przebieg choroby', 'drop-down'),
                            'PierwszeObjawyData' => array ('Data pierwszych objawów (miesiąc / rok)', 'calendar'),
                            'DiagnozaSM'=>array('Data rozpoznania choroby (miesiąc / rok)', 'calendar'),
                            'Mri'=>array ('Badanie MRI', 'drop-down'),
                            'BadaniePlynu'=>array('Badanie płynu mózgowo-rdzeniowego','drop-down'),
                            'Immunomodulujace'=>array('Leczenie immunomodulujące','drop-down'),
                            'Objawowe'=>array('Leczenie objawowe','drop-down'),
                            'Praca'=>array('Zatrudnienie / praca','drop-down'),
                            'PracaZarobPracaZarobekek'=>array('Dochód z pracy','drop-down-dochod'),
                        );
                        break;
                    case 'wybory':
                        $lista = array(
                            'Plec' => array( 'Kobieta', 'Mężczyzna'),
                            'PostacSM' =>array( 'Rzutowo-remisyjna', 'Wtórnie-postępująca', 'Pierwotnie-postępująca', 'CIS'),
                            'PierwszeObjawyData' => array(),
                            'DiagnozaSM'=>array(),
                            'Mri'=>array( 'Tak', 'Nie' ),
                            'BadaniePlynu'=>array( 'Tak', 'Nie' ),
                            'Immunomodulujace'=>array( 'Obecnie', 'W przeszłości' ),
                            'Objawowe'=>array( 'Obecnie', 'W przeszłości' ),
                            'Praca'=> array('Nie pracuje', 'Pracuje', 'Renta', 'Emerytura'),
                            'PracaZarobPracaZarobekek'=> array( 'Tak', 'Nie' ),
                        );
                        break;
                    case 'lista':
                        $lista = array(
                            'PostacSM',
                            'PierwszeObjawyData',
                            'DiagnozaSM',
                            'Mri',
                            'BadaniePlynu',
                            'Immunomodulujace',
                            'Objawowe',
                            'Praca'
                        );
                        break;
                }
                break;
            case 'patients_msis':
                switch ($type) {
                    case 'lista':
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
                }
                break;
            case 'patients_eq5d':
                switch ($type){
                    case 'lista':
                        $lista = array (
                            'movement',
                            'self_care',
                            'normal_activity',
                            'pain_discomfort',
                            'anxiety_depression',
                            'health_total',
                        );
                        break;
                }
                break;
            case 'danedemograficzne':
                switch ($type){
                    case 'naglowek':
                        $lista = array( 'Dane demograficzne');
                        break;
                    case 'tytuly_typy':
                        $lista = array(
                            'MiejsceZamieszkania' => array('Miejsce zamieszkania','drop-down'),
                            'Wojewodztwo' => array('Województwo','drop-down'),
                            'Recznosc'=>array('Ręczność','drop-down'),
                            'Porody'=>array('Porody','drop-down-porody'),
                            'Wyksztalcenie'=>array('Wykształcenie','drop-down'),
                            'Zatrudnienie'=>array('Zatrudnienie','drop-down'),
                            'PracaZarobek'=>array('Dochod','drop-down-dochod'),
                            'StanRodzinny'=>array('Stan rodzinny','drop-down'),
                            'SMwRodzinie'=>array('SM w rodzinie','drop-down'),
                            'Data_zgonu'=>array('Data Zgonu','calendar-zgon'),
                        );
                        break;
                    case 'wybory':
                        $lista = array (
                            'MiejsceZamieszkania' => array('Miasto', 'Wieś',),
                            'Wojewodztwo' => array('dolnośląskie', 'kujawsko-pomorskie', 'lubelskie', 'lubuskie', 'łódzkie', 'małopolskie', 'mazowieckie', 'opolskie', 'podkarpackie', 'podlaskie', 'pomorskie', 'śląskie', 'świętokrzyskie', 'warmińsko-mazurskie', 'wielkopolskie', 'zachodniopomorskie'),
                            'Recznosc'=>array('Praworęczny', 'Leworęczny',),
                            'Porody'=>array('0', '1', '2', '3 lub więcej',),
                            'Wyksztalcenie'=>array('Podstawowe', 'Średnie', 'Wyższe'),
                            'Zatrudnienie'=>array('Nie pracuje', 'Pracuje', 'Renta', 'Emerytura'),
                            'PracaZarobek'=>array('Tak', 'Nie',),
                            'StanRodzinny'=>array('Panna/Kawaler', 'Zamężna/Żonaty', 'Rozwiedziona/Rozwiedziony', 'Wdowa/Wdowiec'),
                            'SMwRodzinie'=>array('Tak', 'Nie',),
                            'Data_zgonu'=>array(),
                        );
                        break;
                    case 'lista':
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
                            'Data_zgonu'
                        );
                        break;
                }
                break;
            case 'wywiad':
                switch ($type) {
                    case 'naglowek':
                        $lista = array( 'Wywiad');
                        break;
                    case 'tytuly_typy':
                        $lista = array(
                            'PierwszeObjawy'=> array( 'Pierwsze objawy', 'drop-down'),
                            'PierwszeObjawyData' => array ('Pierwsze objawy (miesiąc / rok)', 'calendar'),
                            'DiagnozaSM' => array ('Data diagnozy SM (miesiąc / rok)', 'calendar'),
                            'ZapalenieNerwowWzrokowych'=>array('Zapalenie nerwów wzrokowych:', 'drop-down'),
                            'NadcisnienieTetnicze'=>array ('Nadciśnienie tętnicze', 'drop-down'),
                            'Cukrzyca'=>array('Cukrzyca','drop-down'),
                            'Tarczyca'=>array('Choroby tarczycy','drop-down'),
                            'ZakrzepowoZatorowe'=>array('Choroby zakrzepowo-zatorowe','drop-down'),
                            'Nowotwory'=>array('Nwotwory','drop-down'),
                            'PostacSM'=>array('Postać SM:','drop-down'),
                            'KryteriumMcDonald'=>array('Czy spełnia kryteria McDonalda (2010):','drop-down'),
                        );
                        break;
                    case 'wybory':
                        $lista = array(
                            'PierwszeObjawy' => array( 'Wzrokowe','Czuciowe','Piramidowe','Móżdżkowe','Inne'),
                            'PierwszeObjawyData' =>array(),
                            'DiagnozaSM' => array(),
                            'ZapalenieNerwowWzrokowych'=>array('Tak', 'Nie'),
                            'NadcisnienieTetnicze'=>array( 'Tak', 'Nie' ),
                            'Cukrzyca'=>array( 'Tak', 'Nie' ),
                            'Tarczyca'=>array( 'Tak', 'Nie' ),
                            'ZakrzepowoZatorowe'=>array( 'Tak', 'Nie' ),
                            'Nowotwory'=> array('Tak', 'Nie'),
                            'PostacSM'=> array( 'Rzutowo-Remisyjna (RR)', 'Wtórnie Przewlekła (SP)', 'Pierwotnie Przewlekła (PP)', 'Rzutowo-Przewlekła' ),
                            'KryteriumMcDonald'=> array( 'Tak', 'Nie'),
                        );
                        break;
                    case 'lista':
                        $lista =array(
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
                }
                break;
            case 'diagnostyka':
                switch ($type){
                    case 'naglowek':
                        $lista = array ('Diagnostyka');
                        break;
                    case 'tytuly_typy':
                        $lista = array(
                            'Data'=> array( 'Rezonans magnetyczny - data badania', 'calendar-mri', 'multiple' ),
                            'Potencjaly'=>array( 'Badanie potencjalów wzrokowych - wykonanie badania', 'drop-down'),
                            'Wynik'=>array( 'Badanie potencjalów wzrokowych - wynik', 'drop-down'),
                            'BadaniePlynu'=>array('Badanie płynu mózgowo-rdzeniowego- Wykonanie badania', 'drop-down'),
                            'Prazki'=>array('Badanie płynu mózgowo-rdzeniowego - Prążki oligoklonalne:', 'drop-down'),
                        );
                        break;
                    case 'wybory':
                        $lista = array(
                            'Data' => array(),
                            'Potencjaly'=>array('Tak','Nie'),
                            'Wynik'=>array( 'Prawidłowe', 'Nieprawidkłowe'),
                            'BadaniePlynu'=>array('Tak','Nie'),
                            'Prazki'=>array( 'Prawidłowe', 'Nieprawidkłowe'),
                        );
                        break;
                }
        }
        $listy = array_merge ($listy, $lista);
    }
    return $listy;
}