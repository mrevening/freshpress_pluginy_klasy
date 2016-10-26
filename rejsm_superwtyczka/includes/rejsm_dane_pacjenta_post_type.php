<?php
add_action( 'init', 'rejsm_dane_pacjenta_init' );
function rejsm_dane_pacjenta_init() {
    register_post_type('custom-post-type', array(
'label'=>"Custom Post Type Name",
'supports'=>array('title'),
'public'=>false,
'show_ui'=>true,
'show_in_menu'=>true,
'rewrite'=>false,
'menu_icon'=>plugin_dir_url(__FILE__).'res/menu_icon.png',
'query_var'=>false,
'publicly_queryable'=>false,
'menu_position'=>80,
'exclude_from_search'=>true
));
    if (post_type_exists('custom-post-type')) echo 'asfjlksadfjlkasjlf';
}
?>