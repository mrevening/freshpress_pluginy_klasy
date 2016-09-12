<?php
function rejsm_user_login ($email) {
        return substr ( strrev ( strpbrk ( strrev( trim( $email) ), '@' ) ), 0, -1 );
}
?>