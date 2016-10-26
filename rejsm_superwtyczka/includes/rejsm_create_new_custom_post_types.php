<?php
require_once dirname(__FILE__) . '/add_styles.php';
require_once dirname(__FILE__) . '/rejsm_class_form_fields.php';
require_once dirname(__FILE__) . '/rejsm_listy.php';

class new_custom_post_type {
    protected $roles = array ('administrator', 'pacjent', 'lekarz');
    static protected $menu_position = 101;
    static protected $metabox_nr = 1;
    public function __construct(){
        add_action ('init', array($this,'rejsm_add_custom_post_types'));
        add_action( 'add_meta_boxes', array($this,'rejsm_create_metaboxes'));
        add_action( 'save_post', array($this, 'rejsm_save_meta') );
        add_action( 'admin_enqueue_scripts', array($this, 'rejsm_css_add_style'));
        add_filter( 'redirect_post_location', array($this, 'rejsm_redirect_after_save') );
        add_filter( 'wp_insert_post_data' , array($this, 'rejsm_modify_title'));
        add_action( 'personal_options_update', array($this, 'rejsm_update_metadata'));
        add_action( 'edit_user_profile_update', array($this, 'rejsm_update_metadata'));
    }
    public function __destructor(){
        new_custom_post_type::$metabox_nr = 1;
    }
    public function rejsm_add_custom_post_types(){
        register_post_type( $this->post_type_name, array (
            'labels'             => $this->labels,
            'description'        => $this->description,
            'public'             => false, //it's not public, it shouldn't have it's own permalink, and so on
            'exclude_from_search'=> true, // you should exclude it from search results
            'publicly_queryable' => false, // you should be able to query it
            'show_ui'            => true, // you should be able to edit it in wp-admin
            'show_in_menu'       => true,
            'show_in_nav_menus'  => false,  // you shouldn't be able to add it to menus
            'show_in_admin_bar'  => true,
            'menu_position'      => new_custom_post_type::$menu_position++,
            'menu_icon'          => $this->menu_icon,
            'query_var'          => false,
            'rewrite'            => false,
            'capability_type'    => 'post',
            'hierarchical'       => false,
            'has_archive'        => false,  // it shouldn't have archive page
            'rewrite'            => false,  // it shouldn't have rewrite rules
            'capabilities'       => array(
                'read_post'          => 'read_'.$this->post_type_name,
                'edit_post'          => 'edit_'.$this->post_type_name,
                'edit_posts'         => 'edit_'.$this->post_type_name.'s',
                'delete_posts'       => 'delete_'.$this->post_type_name,
                'edit_others_posts'  => 'edit_others_'.$this->post_type_name,
                'publish_posts'      => 'publish_'.$this->post_type_name,
                'read_private_posts' => 'read_private_'.$this->post_type_name,
                'create_posts'       => 'edit_'.$this->post_type_name,
            ),
            'supports'           => array( '' ),
        ) );
        foreach ($this->roles as $rola){
            $role = get_role( $rola );
            if ( !empty ($role) ){
                $role->add_cap('read_'.$this->post_type_name);
                $role->add_cap('read_private_'.$this->post_type_name);
                $role->add_cap('edit_'.$this->post_type_name);
                $role->add_cap('edit_'.$this->post_type_name.'s');
                $role->add_cap('edit_others_'.$this->post_type_name);
                $role->add_cap('publish_'.$this->post_type_name);
                $role->add_cap('delete_'.$this->post_type_name);
            }
        }
    }
    public function rejsm_create_metaboxes() {
        remove_meta_box('slugdiv', $this->post_type_name, 'normal');
        $metabox = new_custom_post_type::$metabox_nr;
        foreach ($this->lista_naglowkow as $naglowek){
            add_meta_box( $this->post_type_name.'_'.$metabox++, $naglowek, array($this,'rejsm_print_metabox'), $this->post_type_name, 'normal', 'high' );     
        }
    }
    public function rejsm_save_meta( $post_id ) {
        $liczba_naglowkow = count($this->lista_naglowkow);
        for ($i =1; $i<=$liczba_naglowkow; $i++){
            $name='rejsm_'.$this->post_type_name.'_'.$i;
            if ( isset( $_POST[$name] ) ) {
                update_post_meta($post_id, '_'.$name, intval(strip_tags($_POST[$name])));
            }
        }
        $wynik_name=$this->post_type_name.'_wynik';
        if ( isset( $_POST[$wynik_name] ) ) {
            update_post_meta($post_id, '_'.$wynik_name, intval(strip_tags($_POST[$wynik_name])));
        }
    }
    public function rejsm_modify_title( $data ) {
//        var_dump(get_userdata($data['post_author'])->user_login);
        $title = $data['post_type'] . '_' . get_userdata($data['post_author'])->user_login . '_' . $data['post_date'];
        $data['post_title'] =  $title ;
        return $data; 
    }
    public function rejsm_register_taxonomy() {
        $args = array(
                'label'             => $this->kategoria_label,
                'hierarchical'      => false,
                'show_ui'           => true,
                'show_admin_column' => true,
                'meta_box_cb'       => array($this,'rejsm_wynik_meta_box'),
        'show_admin_column ' => true,
        );
        register_taxonomy( 'kategoria_'.$this->post_type_name, $this->post_type_name, $args );
    }

    public function rejsm_redirect_after_save( $location, $post_id ) {
//        if ( 'eq5d' == get_post_type( $post_id ) ) {
            $location = admin_url( 'edit.php?post_type='.get_post_type( $post_id ) );
//        }
//        if ( 'msis_29' == get_post_type( $post_id ) ) {
//            $location = admin_url( 'edit.php?post_type=msis_29' );
//        }
        return $location;
    }
    public function rejsm_css_add_style(){
        $handle = 'css_custom_post_type';
        $src =  '/wp-content/plugins/rejsm_superwtyczka/includes/css/css_custom_post_type.css';
        wp_enqueue_style( $handle, $src);
        //add_filter( 'wpcf7_support_html5_fallback', '__return_true' );
    }
    public function rejsm_print_metabox ($user){

        ?> <div class="ankieta"> <?php
        $metabox = new_custom_post_type::$metabox_nr;
        foreach ($this->lista_pytan[$metabox-1] as $key => $value){
            new form_field($user, $key, $value[0], $value[1], $this->wybory[$metabox-1][$key]);
        }
        foreach (form_field::get_lista_objektow() as $objekt) {
           ?> <p> <?php 
            $objekt->print_it();
            ?> </p> <?php
        }
        ?></div><?php
        form_field::reset_lista_objektow();
        new_custom_post_type::$metabox_nr++;
    }
    public function rejsm_add_taxonomy_terms () {
        foreach ($this->kategoria as $cat){
            wp_insert_term ($cat[0], 'kategoria_'.$this->post_type_name, array( 'description' => $cat[0] .'', 'slug' => $cat[1].' - '.$cat[2] ));
        }
    }
    public function rejsm_add_taxonomy_to_post($post_id ) {
    //    $wynik = eq5d_get_result($post_id);
        $wynik=0;
        if ( isset( $_POST['rejsm_'.$this->post_type_name.'_wynik'] ) ) {
            $wynik = intval (strip_tags( $_POST['rejsm_'.$this->post_type_name.'_wynik'] ) );
        }
        $kategoria ='';
        foreach ($this->kategoria as $cat){
            if ($wynik >= $cat[1] && $wynik <= $cat[2]) $kategoria = $cat[0];
        }
        wp_set_object_terms( $post_id, $kategoria, 'kategoria_'.$this->post_type_name,  false );
        update_post_meta($post_id, '_'.$this->post_type_name.'_wynik', $wynik );//strip_tags($_POST[$name3]));
    }
    public function rejsm_update_metadata( $userid ) {
        foreach ($this->lista_nazw as $nazwa => $value)
            if( isset( $_POST['key_'.$nazwa] ) ) {
                update_user_meta( $userid, $nazwa, $_POST['key_'.$nazwa]);
            }
    }

}
class ankieta extends new_custom_post_type{
    public function __construct() {
        parent::__construct();
        add_action( 'init', array($this, 'rejsm_register_taxonomy' ));
        add_action( 'init', array($this, 'rejsm_add_taxonomy_terms' ));
        add_action( 'publish_'.$this->post_type_name, array($this, 'rejsm_add_taxonomy_to_post' ));
        add_filter( 'manage_edit-'.$this->post_type_name.'_columns', array($this, 'rejsm_edit_columns' )) ;
        add_action( 'manage_'.$this->post_type_name.'_posts_custom_column', array($this, 'rejsm_manage_columns'), 10, 2 );
     }
    public function rejsm_edit_columns( $columns ) {
        $columns = array(
            'cb' => '<input type="checkbox" />',
        );
        if( current_user_can('lekarz') || current_user_can('administrator') )  {
            $columns = array_merge($columns,  array( 'author' => __( 'Pacjent' ),  ));
        }
        $columns = array_merge($columns, array( 'kategoria' => __( $this->kategoria_label ),  $this->post_type_name.'_wynik' => __( 'Wynik' ), 'date' => __( 'Date' )  ));
        return $columns;
    }
    public function rejsm_manage_columns( $column, $post_id ) {
	global $post;
        switch( $column ) {
            case $this->post_type_name.'_wynik' :
                //$wynik = msis_29_get_result($post_id);
                $wynik = get_post_meta($post_id, '_'.$this->post_type_name.'_wynik', true);
                if (is_null($wynik)) {
                    $out = sprintf('<a href="%s">%s</a>',
                        esc_url(add_query_arg(array('post' => $post_id, 'action' => 'edit'), 'post.php')), 'N/A');
                }
                else {
                    $out = sprintf('<a href="%s">%s</a>',
                        esc_url( add_query_arg( array( 'post' => $post_id, 'action' => 'edit' ), 'post.php' ) ), $wynik    );
    //                    esc_html( sanitize_term_field( 'name', $wynik->name, $term->term_id, 'wynik_msis_29', 'display' ) )
                }
                echo $out;
                break;
            case 'wynik_msis_29' :

                   /* Get the post meta. */
                   //$wynik = msis_29_get_result($post_id);
                   $wynik = get_post_meta($post_id, '_msis_29_wynik', true);

                   /* If no duration is found, output a default message. */
                   if (is_null($wynik)) {
                       $out = sprintf('<a href="%s">%s</a>',
                           esc_url(add_query_arg(array('post' => $post_id, 'action' => 'edit'), 'post.php')), 'N/A');
                   }
                   /* If there is a duration, append 'minutes' to the text string. */
                   else {
                       $out = sprintf('<a href="%s">%s</a>',
                           esc_url( add_query_arg( array( 'post' => $post_id, 'action' => 'edit' ), 'post.php' ) ), $wynik    ); ///$wynik
                       //                    esc_html( sanitize_term_field( 'name', $wynik->name, $term->term_id, 'wynik_msis_29', 'display' ) )

                   }
                   echo $out;
                   break;
            case 'kategoria' :
                /* Get the genres for the post. */
                $terms = get_the_terms( $post_id, 'kategoria_'.$this->post_type_name );
                /* If terms were found. */
                if ( !empty( $terms ) ) {
                    $out = array();
                    /* Loop through each term, linking to the 'edit posts' page for the specific term. */
                    foreach ( $terms as $term ) {
                        $out[] = sprintf( '<a href="%s">%s</a>',
                            esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'kategoria_'.$this->post_type_name => $term->slug ), 'edit.php' ) ),
                            esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'kategoria_'.$this->post_type_name, 'display' ) )
                        );
                    }
                    echo join( ', ', $out );
                }
                else {
                    _e( 'Brak wyniku' );
                }
                break;
            /* Just break out of the switch statement for everything else. */
            default :
            break;
        }
    }
}
class dane_pacjenta extends new_custom_post_type{
    public function __construct() {
        parent::__construct();
        add_filter( 'manage_edit-'.$this->post_type_name.'_columns', array($this, 'rejsm_edit_columns' )) ;
        add_action( 'manage_'.$this->post_type_name.'_posts_custom_column', array($this, 'rejsm_manage_columns'), 10, 2 );
    }
    public function rejsm_save_meta( $user_id ) {
        $liczba_naglowkow = count($this->lista_naglowkow);
        foreach ($this->lista_pytan as $key => $value){
            $name=$key;
            $name_formularz = 'key_'.$name;
            if ( isset( $_POST[$name_formularz] ) ) {
                update_user_meta($user_id, $name, intval(strip_tags($_POST[$name_formularz])));
            }
        }
    }
    public function rejsm_edit_columns( $columns ) {
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'title' => 'tytul',
            'author' => __( 'Pacjent' ),
            'date' => __( 'Date' ),
        );
//        $columnyKeys=array();
//        $columnyValues=array();
//        $col=array();
//        foreach ($this->lista_pytan as $tablica_asoc){
//            $columnyKeys = array_merge($columnyKeys,array_keys ($tablica_asoc));
//            $columnyValues = array_merge($columnyValues, array_values ($tablica_asoc)); 
//        }
//        foreach ($columnyValues as $arr){
//            $col = array_merge($col,$arr[0]);
//        }
//        $columny = array_combine($columnyKeys, $col);
//        $columns = array_merge($columns, $columny);
        return $columns;
    }
    public function rejsm_manage_columns( $column, $post_id ) {
	global $post;
        switch( $column ) {
            case $this->post_type_name.'_wynik' :
                //$wynik = msis_29_get_result($post_id);
                $wynik = get_post_meta($post_id, '_'.$this->post_type_name.'_wynik', true);
                if (is_null($wynik)) {
                    $out = sprintf('<a href="%s">%s</a>',
                        esc_url(add_query_arg(array('post' => $post_id, 'action' => 'edit'), 'post.php')), 'N/A');
                }
                else {
                    $out = sprintf('<a href="%s">%s</a>',
                        esc_url( add_query_arg( array( 'post' => $post_id, 'action' => 'edit' ), 'post.php' ) ), $wynik    );
    //                    esc_html( sanitize_term_field( 'name', $wynik->name, $term->term_id, 'wynik_msis_29', 'display' ) )
                }
                echo $out;
                break;
            case 'wynik_msis_29' :
                   $wynik = get_post_meta($post_id, '_msis_29_wynik', true);
                   if (is_null($wynik)) {
                       $out = sprintf('<a href="%s">%s</a>',
                           esc_url(add_query_arg(array('post' => $post_id, 'action' => 'edit'), 'post.php')), 'N/A');
                   }
                   else {
                       $out = sprintf('<a href="%s">%s</a>',
                           esc_url( add_query_arg( array( 'post' => $post_id, 'action' => 'edit' ), 'post.php' ) ), $wynik    ); ///$wynik
                       //                    esc_html( sanitize_term_field( 'name', $wynik->name, $term->term_id, 'wynik_msis_29', 'display' ) )

                   }
                   echo $out;
                   break;
            case 'kategoria' :
                $terms = get_the_terms( $post_id, 'kategoria_'.$this->post_type_name );
                if ( !empty( $terms ) ) {
                    $out = array();
                    /* Loop through each term, linking to the 'edit posts' page for the specific term. */
                    foreach ( $terms as $term ) {
                        $out[] = sprintf( '<a href="%s">%s</a>',
                            esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'kategoria_'.$this->post_type_name => $term->slug ), 'edit.php' ) ),
                            esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'kategoria_'.$this->post_type_name, 'display' ) )
                        );
                    }
                    echo join( ', ', $out );
                }
                else {
                    _e( 'Brak wyniku' );
                }
                break;
            /* Just break out of the switch statement for everything else. */
            default :
            break;
        }
    }
}
class msis_29 extends ankieta {
    public function __construct() {
        parent::__construct();
        add_action( 'admin_enqueue_scripts', array($this, 'rejsm_js_wynik_actualize'));
    }
    protected $numer_pytania = 1;
    protected $post_type_name = 'msis_29';
    protected $kategoria_label = 'Wpływ choroby';
    protected $kategoria = array(
        array ('minimalny', 0 ,29),
        array ('średni', 30 ,58),
        array ('mocny',59 ,87),
        array ('bardzo mocny', 88 ,116),
    );
    protected $labels = array(
        'name'               => 'Ankieta MSIS-29',
        'singular_name'      => 'Ankieta',
        'menu_name'          => 'Ankiety MSIS-29',
        'name_admin_bar'     => 'Ankietę MSIS-29', 
        'add_new'            => 'Dodaj nową ankietę',
        'add_new_item'       => 'Wypełnij nową ankietę MSIS 29',
        'new_item'           => 'Nowa ankieta',
        'edit_item'          => 'Edytuj ankietę',
        'view_item'          => 'Zobacz ankietę',
        'all_items'          => 'Wszystkie ankiety',
        'search_items'       => 'Szukaj ankiety',
        'parent_item_colon'  => 'Ankiety dziedziczone',
        'not_found'          => 'Nie znaleziono ankiety.',
        'not_found_in_trash' => 'Nie znaleziono ankiety w koszu.',
    );
    protected $description = "Skala wpływu stwardnienia rozsianego (MSIS-29).";
    protected $menu_icon = 'dashicons-pressthis';
    protected $lista_naglowkow = array(
        'W ciągu ostatnich 14 dni jak bardzo stwardnienie rozsiane ograniczyło Pani/Pana zdolność do:',
        'Wciągu ostatnich 14 dni jak bardzo przeszkadzały Pani/Panu:',
        'Wciągu ostatnich 14 dni jak bardzo przeszkadzały Pani/Panu:',
    );
    protected $lista_pytan = array(
        array(
            'Wykonywania czynności wymagających wysiłku fizycznego:',
            'Silnego chwytania przedmiotów (np. odkręcania kurków):',
            'Noszenia przedmiotów ?',
        ),
        array(
            'Problemy z równowagą ?',
            'Trudności z poruszaniem się w pomieszczeniach ?',
            'Niezręczność:',
            'Sztywność:',
            'Uczucie ciężkości rąk i/lub nóg:',
            'Drżenie rąk lub nóg:',
            'Kurcze rąk lub nóg:',
            'Brak kontroli nad swoim ciałem:',
            'Zależność od innych związana z wykonywaniem różnych czynności za Pana/Panią:',
        ),
        array (
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
        ),
    );
    public function rejsm_print_metabox ($post){
        $metabox = new_custom_post_type::$metabox_nr;
        ?> <div class="ankieta"> <?php
        foreach ($this->lista_pytan[$metabox-1] as $pytanie){
            $nazwa = '_rejsm_'.$this->post_type_name.'_'.$this->numer_pytania;
            $wartosc_w_bazie_danych = get_post_meta( $post->ID, $nazwa, true );
            ?><p><?php echo $pytanie; ?><p>Wcale nie<?php
            for ($i=0; $i<5; $i++){?>
                <input class="msis_check" name="<?php echo 'rejsm_'.$this->post_type_name.'_'.$this->numer_pytania; ?>" value="<?php echo $i;?>" type="radio" <?php checked( $wartosc_w_bazie_danych, $i ); ?> </input>
            <?php
            } ?>  Bardzo mocno</p>
            <?php $this->numer_pytania++;
        } ?></div><?php
        new_custom_post_type::$metabox_nr++;
    }
    public function rejsm_wynik_meta_box( $post ) {
        ?><progress id="health_status_msis" class="scale_result" name ="rejsm_msis_29_wynik" value="" max="116"  ></progress> <?php
    }
    function rejsm_js_wynik_actualize($hook){
        global $post;
        if ( $hook == 'post-new.php' || $hook == 'post.php' ) {
            if ( 'msis_29' === $post->post_type ) {     
                $handle = 'js_wynik_actualize';
                $src =  '/wp-content/plugins/rejsm_superwtyczka/includes/js/js_wynik_actualize.js';
                wp_enqueue_script( $handle, $src);
            }
        }
    }

}
class eq5d extends ankieta {
    protected $nr_pytania = 1;
    protected $post_type_name = 'eq5d';
    protected $kategoria_label = 'Samopoczucie';
    protected $kategoria = array(
        array ('bardzo złe', 1 ,25),
        array ('złe', 26 ,50),
        array ('dobre',51 ,75),
        array ('bardzo dobre', 76 ,100),
    );
    protected $labels = array(
        'name'               => 'Ankieta EQ-5D',
        'singular_name'      => 'Ankieta',
        'menu_name'          => 'Ankiety EQ-5D',
        'name_admin_bar'     => 'Ankietę EQ-5D',
        'add_new'            => 'Dodaj nową ankietę',
        'add_new_item'       => 'Wypełnij nową ankietę EQ-5D',
        'new_item'           => 'Nowa ankieta',
        'edit_item'          => 'Edytuj ankietę',
        'view_item'          => 'Zobacz ankietę',
        'all_items'          => 'Wszystkie ankiety',
        'search_items'       => 'Szukaj ankiety',
        'parent_item_colon'  => 'Ankiety dziedziczone',
        'not_found'          => 'Nie znaleziono ankiety.',
        'not_found_in_trash' => 'Nie znaleziono ankiety w koszu.',
    );
    protected $description = "Skala wpływu stwardnienia rozsianego (EQ-5D).";
    protected $menu_icon = 'dashicons-clipboard';
    protected $lista_naglowkow = array(
        'Zdolność poruszania się',
        'Samoopieka',
        'Zwykła działalność (np. praca, nauka, zajęcia domowe, aktywność rodzinna, zajęcia w czasie wolnym)',
        'Ból/Dyskomfort',
        'Niepokój/Przygnębienie',
    );
    protected $lista_pytan = array(
        array( 'Nie mam problemów z chodzeniem', 'Mam trochę problemów z chodzeniem', 'Jestem zmuszony pozostawać w łóżku' ),
        array( 'Nie mam żadnych problemów z samoopieką', 'Mam trochę problemów z myciem i ubieraniem się', 'Nie mogę sam się umyć ani ubrać'),
        array( 'Nie mam problemów z wykonywaniem moich zwykłych czynności', 'Mam trochę problemów z wykonywaniem moich zwykłych czynności', 'Nie mogę wykonywać moich zwykłych czynności' ),
        array( 'Nie odczuwam bólu ani dyskomfortu', 'Odczuwam umiarkowany ból lub dyskomfort', 'Odczuwam krańcowy ból lub dyskomfort' ),
        array( 'Nie jestem niespokojny ani przygnębiony', 'Jestem umiarkowanie niespokojny lub przygnębiony', 'Jestem krańcowo niespokojny lub przygnębiony'),
    );

    public function rejsm_print_metabox ($post){
        ?> <div class="ankieta"> <?php
        $i=0;
        $metabox = new_custom_post_type::$metabox_nr;
        foreach ($this->lista_pytan[$metabox-1] as $pytanie){
            $wartosc_w_bazie_danych = get_post_meta( $post->ID, '_rejsm_eq5d_'.$metabox , true );
            $oczekiwana_wartosc = ($i++)%3; 
            ?> <p><label for="<?php  echo $this->post_type_name.'_'.$metabox.'_'.$i; ?>"><?php  echo $pytanie; ?>
            <input id=" <?php  echo $this->post_type_name.'_'.$metabox.'_'.$i; ?>" class="radio_button" name="<?php echo 'rejsm_'.$this->post_type_name . '_' . $metabox;?>" value="<?php echo $oczekiwana_wartosc; ?>" type="radio" <?php checked( $wartosc_w_bazie_danych, $oczekiwana_wartosc ); if ($oczekiwana_wartosc == 0) {echo 'checked';} ?> 
            </label></p> <?php
        }
        ?></div><?php
        new_custom_post_type::$metabox_nr++;
    }
    public function rejsm_wynik_meta_box( $post ) {
    $wynik = get_post_meta( $post->ID, '_'.$this->post_type_name.'_wynik', true );
    ?>
        <span float="left" >Złe  </span>
        <span float="center"> <input name="<?php echo 'rejsm_'.$this->post_type_name.'_wynik'; ?>"  type="range" min="1" max="100" value="<?php echo $wynik; ?>"> </input></span>
        <span float="right" >Dobre  </span>
    <?php
    }
}
class dane_demograficzne extends dane_pacjenta {
    protected $post_type_name = 'dane_demograficzne';
    protected $labels = array(
        'name'               => 'Dane demograficzne',
        'singular_name'      => 'Dane demograficzne',
        'menu_name'          => 'Dane demograficzne',
        'name_admin_bar'     => 'Dane demograficzne',
        'add_new'            => 'Dodaj pacjenta',
        'add_new_item'       => 'Wypełnij nową daną demograficzną',
        'new_item'           => 'Nowy pacjent',
        'edit_item'          => 'Edytuj pacjenta',
        'view_item'          => 'Zobacz pacjenta',
        'all_items'          => 'Wszyscy pacjenci',
        'search_items'       => 'Szukaj pacjenta', 
        'parent_item_colon'  => 'Rodzic:',
        'not_found'          => 'Nie znaleziono pacjenta.',
        'not_found_in_trash' => 'Nie znaleziono pacjenta w koszu.',
    );
    protected $description = "Wszystkie dane demograficzne";
    protected $menu_icon = 'dashicons-groups';
    protected $lista_naglowkow = array(
        'Dane demograficzne', 
        'Aktywność'
    );
    protected $lista_pytan = array(
        array(
            'MiejsceZamieszkania' => array('Miejsce zamieszkania','drop-down'),
            'Wojewodztwo' => array('Województwo','drop-down'),
            'StanRodzinny'=>array('Stan rodzinny','drop-down'),
            'Recznosc'=>array('Ręczność','drop-down'),
        ),
         array(
            'Porody'=>array('Porody','drop-down-porody'),
            'Wyksztalcenie'=>array('Wykształcenie','drop-down'),
            'SMwRodzinie'=>array('SM w rodzinie','drop-down'),
            'Zatrudnienie'=>array('Zatrudnienie','drop-down'),
            'PracaZarobek'=>array('Dochód','drop-down-dochod'),
        ),
//        'Data_zgonu'=>array('Data Zgonu','calendar-zgon'),
    );
    protected $wybory = array (
        array(
            'MiejsceZamieszkania' => array('Miasto', 'Wieś',),
            'Wojewodztwo' => array('dolnośląskie', 'kujawsko-pomorskie', 'lubelskie', 'lubuskie', 'łódzkie', 'małopolskie', 'mazowieckie', 'opolskie', 'podkarpackie', 'podlaskie', 'pomorskie', 'śląskie', 'świętokrzyskie', 'warmińsko-mazurskie', 'wielkopolskie', 'zachodniopomorskie'),
            'StanRodzinny'=>array('Panna/Kawaler', 'Zamężna/Żonaty', 'Rozwiedziona/Rozwiedziony', 'Wdowa/Wdowiec'),
            'Recznosc'=>array('Praworęczny', 'Leworęczny',),
        ),
        array(
            'Porody'=>array('0', '1', '2', '3 lub więcej',),
            'Wyksztalcenie'=>array('Podstawowe', 'Średnie', 'Wyższe'),
            'SMwRodzinie'=>array('Tak', 'Nie',),
            'Zatrudnienie'=>array('Nie pracuje', 'Pracuje', 'Renta', 'Emerytura'),
            'PracaZarobek'=>array('Tak', 'Nie',),
        ),
//        'Data_zgonu'=>array(),
    );
}

$msis_29 = new msis_29();
$eq5d = new eq5d();
$dane_demograficzne = new dane_demograficzne();


