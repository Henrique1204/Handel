<?php

// Adiciona o tema do woocommerce
function handel_add_woocommerce_support() {
    add_theme_support('woocommerce');
}

add_action('after_setup_theme', 'handel_add_woocommerce_support');

// Define o css do site
function handel_css() {
    wp_register_style('handel-style', get_template_directory_uri().'/style.css', [], '1.0.0');

    wp_enqueue_style('handel-style');
}

add_action('wp_enqueue_scripts', 'handel_css');

// Manipula tamanho das imagens inseridas
function handel_custom_image() {
    // Nome, largura, altura, crop
    // O array pode ser substituído por ture.
    // O array recebe configurações, no caso diz pro crop ser apartir do centro e não cortar o topo
    add_image_size('slide', 1000, 800, ['center', 'top']);
    update_option('medium_crop', 1);
}

add_action('after_setup_theme', 'handel_custom_image');

// Filtrar classes
function remover_classes_body($classes) {
    $classe_woo = array_search('woocommerce', $classes);
    $classe_woo_page = array_search('woocommerce-page', $classes);

    $pagina = in_array('archive', $classes) || in_array('product-template-default', $classes);

    if ($classe_woo && $classe_woo_page && $pagina) {
        unset($classes[$classe_woo]);
        unset($classes[$classe_woo_page]);
    }

    return $classes;
}

add_filter('body_class', 'remover_classes_body');

// Filtro pra limitar número de produtos mostrados em loja
function handel_loop_shop_per_page() {
    return 6;
}

add_filter('loop_shop_per_page', 'handel_loop_shop_per_page');

function handel_listar_produtos($produtos) { ?>
    <ul class="lista-produtos">
        <?php foreach($produtos as $produto) { ?>
            <li class="item-produto">
                <a href="<?= $produto["link"]; ?>">
                    <div class="info-produto">
                        <img src="<?= $produto["img"]; ?>" alt="<?= $produto["nome"]; ?>">
                        <h2><?= $produto["nome"]; ?> - <span><?= $produto["preco"]; ?></span></h2>
                    </div>

                    <div class="overlay-produto">
                        <span class="btn-link">Ver mais</span>
                    </div>
                </a>
            </li>
        <?php } ?>
    </ul>
<?php }

function formatar_produtos($produtos, $tamanho_img = 'medium') {
    $produtos_finais = [];

    foreach($produtos as $produto) {
        $produtos_finais[] = [
            'nome' => $produto->get_name(),
            'preco' => $produto->get_price_html(),
            'link' => $produto->get_permalink(),
            'img' => wp_get_attachment_image_src($produto->get_image_id(), $tamanho_img)[0]
        ];
    }

    return $produtos_finais;
}
