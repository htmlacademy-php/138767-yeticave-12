<?php

function get_url_lot_page ($url_params) {
    return "./lot.php?" . http_build_query($url_params);
}