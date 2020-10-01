<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php bloginfo("name"); wp_title('|'); ?></title>
    <!-- WP Head -->
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <header class="header container">
        <a href="/"><img src="<?= get_stylesheet_directory_uri(); ?>/img/handel.svg" alt="Logo do Handel"></a>

        <div class="busca">
            <?php //get_product_search_form(); - Opção nativa para campo de busca ?>

            <form action="<?php bloginfo('url'); ?>/loja/" method="get">
                <input type="text" name="s" id="s" placeholder="Buscar" value="<?php the_search_query(); ?>">
                <input type="text" name="post_type" value="product" class="hidden">
                <input type="submit" id="searchbutton" value="Buscar">
            </form>
        </div>

        <nav class="conta">
            <a href="/minha-conta" class="minha-conta">Minha Conta</a>
            <a href="/carrinho" class="carrinho">
                Carrinho
                <?php if (WC()->cart->get_cart_contents_count()) { ?>
                    <span class="carrinho-count"><?= WC()->cart->get_cart_contents_count(); ?></span>
                <?php } ?>
            </a>
        </nav>
    </header>

    <?php
        wp_nav_menu([
            'menu' => 'categorias',
            'container' => 'nav',
            'container_class' => 'menu-categorias'
        ]);
    ?>
