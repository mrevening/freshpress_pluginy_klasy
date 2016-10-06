<?php

/*Konfiguracja typu wpisu */
add_action( 'init', 'fresh_badanie');
/*Rejestracja typu wpisu bloga*/
function fresh_badanie(){
    /*Ustawienie argumentów dla typu wpisu badania */
    $badanie_args = array(
        'public' => true,
        'query_var' => 'badanie',
        'menu_position' => 3,
        //'taxonomies' => 'szpital',
        'menu_icon' => 'dashicons-edit',
        'labels' => array(
            'name' => 'Badania',
            'singular name' => 'Badanie',
            'add_new' => 'Dodaj nowe badanie',
            'add_new_item' => 'Dodaj nowe badanie',
            'edit_item' => 'Edytuj badanie',
            'new_item' => 'Nowe badanie',
            'view_item' => 'Wyświetl badanie',
            'search_item' => 'Szukaj w badaniach',
            'now_found' => 'Nie znaleziono badania',
            'not_found_in_trash' => 'Nie znaleziono badania w koszu'
       ),
       'capabilities' => array(
            'edit_post' => 'edit_badanie',
            'edit_posts' => 'edit_badania',
            'edit_others_posts' => 'edit_other_badania',
            'publish_posts' => 'publish_badania',
            'read_post' => 'read_badania',
            'read_private_posts' => 'read_private_badania',
            'delete_posts' => 'delete_badania',
        ),
    );
    /*Rejestracja typu wpisu bloga*/
    register_post_type( 'badanie', $badanie_args);
}

function remove_box()
{
    remove_post_type_support('badanie', 'title');
    remove_post_type_support('badanie', 'editor');
}
add_action("admin_init", "remove_box");

///zmien tytul każdego wpisu badanie
add_filter( 'wp_insert_post_data' , 'modify_post_title' , '99', 1 ); // Grabs the inserted post data so you can modify it.
function modify_post_title( $data )
{
    if ( $data['post_type'] == 'badanie' ) { // If the actual field name of the rating date is different, you'll have to update this.
        //$date = date('m/d/Y h:i:s a', time());
        $typBadania = $data['post_type'];
        $autorid = $data['post_author'];
        $autor = get_userdata($autorid);
        $date = $data['post_date'];
        $title = 'Badanie ' . $typBadania . '_' . $autor->user_login . '_' . $date;
        $data['post_title'] =  $title ; //Updates the post title to your new title.
    }
    return $data; // Returns the modified data.
}

// Zaczep pozwalający na dodanie pola użytkownika.
add_action( 'add_meta_boxes', 'boj_mbe_create' );
function boj_mbe_create() {
	// Utworzenie własnego pola użytkownika.
	add_meta_box( 'id-div', 'title', 'rejsm_add_metabox', 'badanie', 'normal', 'high' );
}
function rejsm_add_metabox( $post ) {
	// Pobranie wartości metadanych, o ile istnieją.
	$boj_mbe_name = get_post_meta( $post->ID, '_boj_mbe_name', true );
	$boj_mbe_costume = get_post_meta( $post->ID, '_boj_mbe_costume', true );
	echo 'Proszę wypełnić poniższe pola';
?>
	<p>Imię: <input type="text" name="boj_mbe_name" value="<?php echo esc_attr( $boj_mbe_name ); ?>" /></p>
    <p>Kostium:
    <select name="boj_mbe_costume">
        <option value="vampire" <?php selected( $boj_mbe_costume, 'vampire' ); ?>q>Wampir</option>
        <option value="zombie" <?php selected( $boj_mbe_costume, 'zombie' ); ?>>Zombie</option>
        <option value="smurf" <?php selected( $boj_mbe_costume, 'smurf' ); ?>>Smerf</option>
    </select>
    </p>
	<?php
}


// Zaczep pozwalający na zapis danych pola użytkownika.
add_action( 'save_post', 'boj_mbe_save_meta' );
function boj_mbe_save_meta( $post_id ) {

	// Sprawdzenie, czy metadane zostały podane.
	if ( isset( $_POST['boj_mbe_name'] ) ) {
		// Zapis metadanych.
		update_post_meta( $post_id, '_boj_mbe_name', strip_tags( $_POST['boj_mbe_name'] ) );
		update_post_meta( $post_id, '_boj_mbe_costume', strip_tags( $_POST['boj_mbe_costume'] ) );
	}

}
?>