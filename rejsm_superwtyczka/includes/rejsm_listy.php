<?php
/**
 * Created by PhpStorm.
 * User: mrevening
 * Date: 2016-09-17
 * Time: 18:22
 */
function get_lista_nazw_demograficzne(){
    return $lista_nazw = array(
        'miejsce_zamieszkania' => 'Miejsce zamieszkania',
        'wojewodztwo' => 'Województwo',
        'plec'=> 'Płeć',
        'przebieg_choroby' =>'Przebieg choroby',
        'data_pierwszych_objawow' => 'Data pierwszych objawów (miesiąc / rok)',
        'data_rozpoznania_choroby'=>'Data rozpoznania choroby (miesiąc / rok)',
        'badanie_mri'=>'Badanie MRI',
        'badanie_plynu'=>'Badanie płynu mózgowo-rdzeniowego',
        'leczenie_immunomodulujace'=>'Leczenie immunomodulujące',
        'leczenie_objawowe'=>'Leczenie objawowe',
        'zatrudnienie'=>'Zatrudnienie / praca',
        'praca_dochod'=>'Dochód z pracy',
    );
}
function get_lista_wyborow_demograficzne(){
    return $lista_wyborow = array(
        'miejsce_zamieszkania' => array('Miasto', 'Wieś',),
        'wojewodztwo' => array(
            'dolnośląskie', 'kujawsko-pomorskie', 'lubelskie', 'lubuskie', 'łódzkie', 'małopolskie', 'mazowieckie', 'opolskie', 'podkarpackie', 'podlaskie', 'pomorskie', 'śląskie', 'świętokrzyskie', 'warmińsko-mazurskie', 'wielkopolskie', 'zachodniopomorskie',
        ),

    );
}
function get_lista_nazw_eurems(){
    return $lista_nazw = array(
        'miejsce_zamieszkania' => 'Miejsce zamieszkania',
        'wojewodztwo' => 'Województwo',
    );
}
function get_lista_wyborow_eurems(){
    return $lista_nazw = array(
        'miejsce_zamieszkania' => 'Miejsce zamieszkania',
        'wojewodztwo' => 'Województwo',
    );

}