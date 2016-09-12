<?php
//function registration_errors_check ($errors) {
//    if ( empty( $_POST['key_pesel'] ) || ! empty( $_POST['key_pesel'] ) && trim( $_POST['key_pesel'] ) == '' ) {
//        $errors->add( 'pesel_error', __( '<strong>B£¥D</strong>: Proszê wprowadziæ pesel.', 'mydomain' ) );
//    }
//    else if (! validatepesel($_POST['key_pesel'] ) ) {
//        $errors->add( 'pesel_error', __( '<strong>B£¥D</strong>: Nieprawid³owy format numeru pesel.', 'mydomain' ) );
//    }
//    else if ( pesel_exists($_POST['key_pesel'] ) ) {
//        $errors->add( 'pesel_error', __( '<strong>B£¥D</strong>: Pesel jest ju¿ w systemie.', 'mydomain' ) );
//    }
//    if (empty( $errors->errors ) ) {
//        add_action('login_head', 'wpb_remove_loginshake');
//        function wpb_remove_loginshake() {
//            add_action('login_head', 'wp_shake_js', 12);
//        }
//    }
//    return $errors;
//}


?>