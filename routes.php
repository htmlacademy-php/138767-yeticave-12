<?php

function get_url_lot_page($url_params = [])
{
    return "./lot.php?" . http_build_query($url_params);
}

function get_url_login_page($url_params = [])
{
    return "./login.php?" . http_build_query($url_params);
}

function get_sign_up_page($url_params = [])
{
    return "./sign-up.php?" . http_build_query($url_params);
}
