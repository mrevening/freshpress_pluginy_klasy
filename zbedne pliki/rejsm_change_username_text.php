<?php

//add_action( 'profile_personal_options', 'test');
//add_action( 'user_register', 'rejsm_login_head');
//add_action( 'register_form', 'rejsm_login_head');
//add_action( 'show_user_profile', 'rejsm_login_head');
//add_action( 'admin_head-profile', 'rejsm_login_head');
//add_action( 'show_user_profile', 'my_show_extra_profile_fields' );
//add_action( 'edit_user_profile', 'my_show_extra_profile_fields' );




function remove_fields_edit_user()
{
    echo '<style>tr.user-url-wrap{ display: none; }</style>';
}
add_action( 'admin_head-user-edit.php', 'remove_fields_edit_user' );
add_action( 'admin_head-profile.php',   'remove_fields_edit_user' );
















?>