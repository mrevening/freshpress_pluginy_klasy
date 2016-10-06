<?php
/**
 * Created by PhpStorm.
 * User: mrevening
 * Date: 2016-09-17
 * Time: 18:22
 */

function get_lista_tytulow_i_typow_demograficzne(){
    return array(
        'MiejsceZamieszkania' => array('Miejsce zamieszkania','drop-down'),
        'Wojewodztwo' => array('Województwo','drop-down'),
        'Recznosc'=>array('Ręczność','drop-down'),
        'Porody'=>array('Porody','drop-down-porody'),
        'Wyksztalcenie'=>array('Wykształcenie','drop-down'),
        'StanRodzinny'=>array('Stan rodzinny','drop-down'),
        'SMwRodzinie'=>array('SM w rodzinie','drop-down'),
        'Data_zgonu'=>array('Data Zgonu','calendar-zgon'),
    );
}
function get_lista_wyborow_demograficzne(){
    return array(
        'MiejsceZamieszkania' => array('Miasto', 'Wieś',),
        'Wojewodztwo' => array(
            'dolnośląskie', 'kujawsko-pomorskie', 'lubelskie', 'lubuskie', 'łódzkie', 'małopolskie', 'mazowieckie', 'opolskie', 'podkarpackie', 'podlaskie', 'pomorskie', 'śląskie', 'świętokrzyskie', 'warmińsko-mazurskie', 'wielkopolskie', 'zachodniopomorskie',
        ),
        'Recznosc'=>array('Praworęczny', 'Leworęczny',),
        'Porody'=>array('0', '1', '2', '3 lub więcej',),
        'Wyksztalcenie'=>array('Podstawowe', 'Średnie', 'Wyższe'),
        'StanRodzinny'=>array('Panna/Kawaler', 'Zamężna/Żonaty', 'Rozwiedziona/Rozwiedziony', 'Wdowa/Wdowiec'),
        'SMwRodzinie'=>array('Tak', 'Nie',),
        'Data_zgonu'=>array(),
    );
}


function get_lista_tytulow_i_typow_eurems(){
    return array(
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
}
function get_lista_wyborow_eurems(){
    return array(
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
}
function get_lista_tytulow_i_typow_wywiad(){
    return array(
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
}
function get_lista_wyborow_wywiad(){
    return array(
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
}
function get_wszyskie_tytuly (){
    return array_merge(get_lista_tytulow_i_typow_eurems(),get_lista_tytulow_i_typow_demograficzne());
}
function get_wszyskie_wybory (){
    return array_merge(get_lista_wyborow_eurems(), get_lista_wyborow_demograficzne());
}