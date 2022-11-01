<?php
/**Try to sign in user, and return WP_User if success, else WP_Error */
function basic_login_user($login, $password, $remember = false)
{
    $creds = array(
        'user_login'    => $login,
        'user_password' => $password,
        'remember'      => $remember
    );
    $user = wp_signon($creds, is_ssl());

    return $user;
}

//user registration
function basic_register_user($name, $password, $email)
{
    $user = wp_create_user($name, $password, $email);
    return $user;
}