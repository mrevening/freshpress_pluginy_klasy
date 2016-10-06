<?php
add_action( 'wp_authenticate', 'wp_authenticate_by_pesel' );
// user name is passed in by reference
function wp_authenticate_by_pesel( &$pesel ) {
    $user = get_user_by( 'pesel', $pesel );

    if ( ! $user ) {
        $pesel = $user->user_login;
    }

}
?>