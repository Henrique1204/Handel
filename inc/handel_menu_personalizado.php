<?php 

function handel_menu_personalizado($links_menu) {
    $links_menu = array_slice($links_menu, 0, 5, true) +
    ['certificados' => 'Certificados'] +
    array_slice($links_menu, 5, null, true);

    // unset($links_menu['downloads']);
    // unset($links_menu['dashboard']);

    return $links_menu;
}

add_filter('woocommerce_account_menu_items', 'handel_menu_personalizado');

function handel_add_endpoint() {
    add_rewrite_endpoint('certificados', EP_PAGES);
}

add_action('init', 'handel_add_endpoint');

function handel_certificados() {
    echo "<p>Esses são seus certificados</p>";
}

add_action('woocommerce_account_certificados_endpoint', 'handel_certificados');

// Recarrega os endpoints, usar só uma vez
// flush_rewrite_rules($hard);
