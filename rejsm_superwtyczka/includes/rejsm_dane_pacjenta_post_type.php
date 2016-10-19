<?php
add_action( 'init', 'rejsm_dane_pacjenta_init' );
function rejsm_dane_pacjenta_init() {
    $labels = array(
        'name'               => _x( 'Dane pacjenta', 'post type general name', 'your-plugin-textdomain' ),
        'singular_name'      => _x( 'Dane pacjenta', 'post type singular name', 'your-plugin-textdomain' ),
        'menu_name'          => _x( 'Dane pacjenta', 'admin menu', 'your-plugin-textdomain' ),
        'name_admin_bar'     => _x( 'Dane pacjenta', 'add new on admin bar', 'your-plugin-textdomain' ),
        'add_new'            => _x( 'Dodaj nową Dane pacjenta', 'book', 'your-plugin-textdomain' ),
        'add_new_item'       => __( 'Wypełnij nową Dane pacjenta', 'your-plugin-textdomain' ),
        'new_item'           => __( 'Nowa Dane pacjenta', 'your-plugin-textdomain' ),
        'edit_item'          => __( 'Edytuj Dane pacjenta', 'your-plugin-textdomain' ),
        'view_item'          => __( 'Zobacz Dane pacjenta', 'your-pluginextdomain' ),
        'all_items'          => __( 'Wszystkie Dane pacjenta', 'your-plugin-textdomain' ),
        'search_items'       => __( 'Szukaj Dane pacjenta', 'your-plugin-textdomain' ),
        'parent_item_colon'  => __( 'Dane pacjenta:', 'your-plugin-textdomain' ),
        'not_found'          => __( 'Nie znaleziono Dane pacjenta.', 'your-plugin-textdomain' ),
        'not_found_in_trash' => __( 'Nie znaleziono Dane pacjenta w koszu.', 'your-plugin-textdomain' ),
    );
    $args = array(
        'labels'             => $labels,
        'description'        => __( 'Dane pacjenta.', 'your-plugin-textdomain' ),
        'public'             => false, //it's not public, it shouldn't have it's own permalink, and so on
        'exclude_from_search'=> true, // you should exclude it from search results
        'publicly_queryable' => false, // you should be able to query it
        'show_ui'            => true, // you should be able to edit it in wp-admin
        'show_in_menu'       => true,
        'show_in_nav_menus'  => false,  // you shouldn't be able to add it to menus
        'show_in_admin_bar'  => true,
        'menu_position'      => 103,
        'menu_icon'          => 'dashicons-clipboard',
        'query_var'          => false,
        'rewrite'            => false,
        'capability_type'    => 'post',
        'hierarchical'       => false,
        'has_archive'        => false,  // it shouldn't have archive page
        'rewrite'            => false,  // it shouldn't have rewrite rules
        'capabilities'       => array(
            'read_post'          => 'read_dane_pacjenta',
            'edit_post'          => 'edit_dane_pacjenta',
            'edit_posts'         => 'edit_dane_pacjentas',
            'delete_posts'       => 'delete_dane_pacjenta',
            'edit_others_posts'  => 'edit_others_dane_pacjenta',
            'publish_posts'      => 'publish_dane_pacjentaa',
            'read_private_posts' => 'read_private_dane_pacjenta',
            'create_posts'       => 'edit_dane_pacjenta',
        ),
        'supports'           => array( '' ),
    );
    register_post_type( 'dane_pacjenta', $args );
}
//***********************                   tworzenie ankiety MSIS_29  -> koniec
// **************************   Pole użytkownika
function dane_pacjenta_lista_pytan ()
{
    $lista_pytan_dane_pacjenta = array(
        'Wykonywania czynności wymagających wysiłku fizycznego:',
        'Silnego chwytania przedmiotów (np. odkręcania kurków):',
        'Noszenia przedmiotów ?',
        'Problemy z równowagą ?',
        'Trudności z poruszaniem się w pomieszczeniach ?',
        'Niezręczność:',
        'Sztywność:',
        'Uczucie ciężkości rąk i/lub nóg:',
        'Drżenie rąk lub nóg:',
        'Kurcze rąk lub nóg:',
        'Brak kontroli nad swoim ciałem:',
        'Zależność od innych związana z wykonywaniem różnych czynności za Pana/Panią:',
        'Ograniczenia odwiedzin w Pani/Pana domu oraz czynności wykonywanych w czasie wolnym:',
        'Konieczność pozostania w domu dłużej niż by Pan/Pani sobie życzył/a:',
        'Trudności z używaniem rąk w codziennych czynnościach:',
        'Konieczność ograniczenia czasu, który Pan/i poświęca na pracę lub inne czynności codzienne:',
        'Trudności w korzystaniu środków transportu (np. samochodu, autobusu, pociągu, taksówki itp.):',
        'Dłuższy niż normalnie czas wykonywaniu czynności:',
        'Trudności ze spontanicznym wykonywaniem czynności (np. pójcie gdzieś pod wpływem impulsu chwili):',
        'Nagła potrzeba pójścia do toalety:',
        'Złe samopoczucie:',
        'Problemy ze snem :',
        'Poczucie psychicznego zmęczenia :',
        'Obawy związane z Pani/Pana chorobą (SM):',
        'Uczucie niepokoju lub napięcia :',
        'Uczucie rozdrażnienia, zniecierpliwienia lub wybuchowość:',
        'Problemy z koncentracją uwagi:',
        'Brak pewności siebie :',
        'Uczucie depresji :',
    );
    return $lista_pytan_dane_pacjenta;
}
add_action( 'add_meta_boxes', 'rejsm_dane_pacjenta_create' );
function rejsm_dane_pacjenta_create() {
	// Utworzenie własnego pola użytkownika.
    remove_meta_box('slugdiv', 'dane_pacjenta', 'normal');
//    remove_meta_box('submitdiv', 'msis_29', 'normal');
    add_meta_box( 'dane_pacjenta_1', 'W ciągu ostatnich 14 dni jak bardzo stwardnienie rozsiane ograniczyło Pani/Pana zdolność do:', 'rejsm_dane_pacjenta_add_metabox_1', 'dane_pacjenta', 'normal', 'high' );
	add_meta_box( 'dane_pacjenta_2', 'Wciągu ostatnich 14 dni jak bardzo przeszkadzały Pani/Panu:', 'rejsm_dane_pacjenta_add_metabox_2', 'dane_pacjenta', 'normal', 'high' );
    add_meta_box( 'dane_pacjenta_3', 'Wciągu ostatnich 14 dni jak bardzo przeszkadzały Pani/Panu:', 'rejsm_dane_pacjenta_add_metabox_3', 'dane_pacjenta', 'normal', 'high' );
//    add_meta_box( 'submitdiv', 'Publikuj', 'rejsm_msis_29_add_publish_metabox', 'msis_29', 'side', 'low' );
}
function rejsm_dane_pacjenta_add_metabox_1( $post ) {
	print_dane_pacjenta($post, 1, 3);
}
function rejsm_dane_pacjenta_add_metabox_2( $post ) {
    print_dane_pacjenta($post, 4 , 9);
}
function rejsm_dane_pacjenta_add_metabox_3( $post ) {
    print_dane_pacjenta($post, 13, 17);
}

function print_dane_pacjenta ($post, $nr_pierwszego_pytania, $ile_pytan){
    $lista = dane_pacjenta_lista_pytan();
?>    <div class="ankieta">
    <?php
    for ($i=$nr_pierwszego_pytania; $i<$nr_pierwszego_pytania+$ile_pytan; $i++) {
        $nazwa = '_rejsm_dane_pacjenta_'.$i;
        $wartosc_w_bazie_danych = get_post_meta( $post->ID, $nazwa, true );
    ?> <p> <?php  echo $lista[$i-1] ?>
    <p>
        Wcale nie
        <input class="msis_check" name="rejsm_dane_pacjenta_<?php    echo $i;    ?>" value="0" type="radio" <?php checked( $wartosc_w_bazie_danych, '0' );?> checked </input>
        <input class="msis_check" name="rejsm_dane_pacjenta_<?php    echo $i;    ?>" value="1" type="radio" <?php checked( $wartosc_w_bazie_danych, '1' );?> </input>
        <input class="msis_check" name="rejsm_dane_pacjenta_<?php    echo $i;    ?>" value="2" type="radio" <?php checked( $wartosc_w_bazie_danych, '2' );?> </input>
        <input class="msis_check" name="rejsm_dane_pacjenta_<?php    echo $i;    ?>" value="3" type="radio" <?php checked( $wartosc_w_bazie_danych, '3' );?> </input>
        <input class="msis_check" name="rejsm_dane_pacjenta_<?php    echo $i;    ?>" value="4" type="radio" <?php checked( $wartosc_w_bazie_danych, '4' );?> </input>
        Bardzo mocno
    </p>
    <?php
    }
    ?>
</div><?php
}

?>