<?php
/**
 * Created by PhpStorm.
 * User: mrevening
 * Date: 2016-09-17
 * Time: 18:22
 */
function get_lista_tytulow_i_typow_eurems(){
    return $lista = array(
        'plec'=> array( 'Płeć', 'drop-down-plec'),
        'przebieg_choroby' => array ('Przebieg choroby', 'drop-down'),
        'data_pierwszych_objawow' => array ('Data pierwszych objawów (miesiąc / rok)', 'calendar'),
        'data_rozpoznania_choroby'=>array('Data rozpoznania choroby (miesiąc / rok)', 'calendar'),
        'badanie_mri'=>array ('Badanie MRI', 'drop-down'),
        'badanie_plynu'=>array('Badanie płynu mózgowo-rdzeniowego','drop-down'),
        'leczenie_immunomodulujace'=>array('Leczenie immunomodulujące','drop-down'),
        'leczenie_objawowe'=>array('Leczenie objawowe','drop-down'),
        'zatrudnienie'=>array('Zatrudnienie / praca','drop-down'),
        'praca_dochod'=>array('Dochód z pracy','drop-down-dochod'),
    );
}
function get_lista_wyborow_eurems(){
    return $lista_nazw = array(
        'plec' => array( 'Kobieta', 'Mężczyzna'),
        'przebieg_choroby' =>array( 'Rzutowo-remisyjna', 'Wtórnie-postępująca', 'Pierwotnie-postępująca', 'CIS'),
        'data_pierwszych_objawow' => array(),
        'data_rozpoznania_choroby'=>array(),
        'badanie_mri'=>array( 'Tak', 'Nie' ),
        'badanie_plynu'=>array( 'Tak', 'Nie' ),
        'leczenie_immunomodulujace'=>array( 'Obecnie', 'W przeszłości' ),
        'leczenie_objawowe'=>array( 'Obecnie', 'W przeszłości' ),
        'zatrudnienie'=> array('Nie pracuje', 'Pracuje', 'Renta', 'Emerytura'),
        'praca_dochod'=> array( 'Tak', 'Nie' ),
    );

}

function get_lista_tytulow_i_typow_demograficzne(){
    return $lista_nazw = array(
        'miejsce_zamieszkania' => array('Miejsce zamieszkania','drop-down'),
        'wojewodztwo' => array('Województwo','drop-down'),
        'recznosc'=>array('Ręczność','drop-down'),
        'porody'=>array('Porody','drop-down-porody'),
        'wyksztalcenie'=>array('Wykształcenie','drop-down'),
        'stan_rodzinny'=>array('Stan rodzinny','drop-down'),
        'sm_w_rodzinie'=>array('SM w rodzinie','drop-down'),
        'data_zgonu'=>array('Data Zgonu','calendar-zgon'),
    );
}
function get_lista_wyborow_demograficzne(){
    return $lista_wyborow = array(
        'miejsce_zamieszkania' => array('Miasto', 'Wieś',),
        'wojewodztwo' => array(
            'dolnośląskie', 'kujawsko-pomorskie', 'lubelskie', 'lubuskie', 'łódzkie', 'małopolskie', 'mazowieckie', 'opolskie', 'podkarpackie', 'podlaskie', 'pomorskie', 'śląskie', 'świętokrzyskie', 'warmińsko-mazurskie', 'wielkopolskie', 'zachodniopomorskie',
        ),
        'recznosc'=>array('Praworęczny', 'Leworęczny',),
        'porody'=>array('0', '1', '2', '3 lub więcej',),
        'wyksztalcenie'=>array('Podstawowe', 'Średnie', 'Wyższe'),
        'stan_rodzinny'=>array('Panna/Kawaler', 'Zamężna/Żonaty', 'Rozwiedziona/Rozwiedziony', 'Wdowa/Wdowiec'),
        'sm_w_rodzinie'=>array('Tak', 'Nie',),
        'data_zgonu'=>array(),
    );
}

function get_wszyskie_tytuly (){
    return array_merge(get_lista_tytulow_i_typow_eurems(),get_lista_tytulow_i_typow_demograficzne());
}
function get_wszyskie_wybory (){
    return array_merge(get_lista_wyborow_eurems(), get_lista_wyborow_demograficzne());
}