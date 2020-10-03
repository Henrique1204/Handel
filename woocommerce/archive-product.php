<?php get_header(); ?>

<?php
    $produtos = [];

    if (have_posts()) {
        while(have_posts()) {
            the_post();
            $produtos[] = wc_get_product(get_the_ID());
        }
    }

    $dados = [
        'produtos' => formatar_produtos($produtos)
    ];
?>

<div class="container breadcrumb">
    <?php woocommerce_breadcrumb(['delimiter' => ' > ']); ?>
</div>

<main>
    <article class="container products-archive">
        <nav class="filtros">
            <div class="filtro">
                <h3 class="filtro-titulo">Categorias</h3>
                <?php
                    wp_nav_menu([
                        'menu' => 'categoria-interna',
                        'menu_class' => 'filtro-cat',
                        'container' => false
                    ]);
                ?>
            </div>

            <div class="filtro">
                <?php
                    $atributo_taxonomies = wc_get_attribute_taxonomies();

                    foreach($atributo_taxonomies as $atributo) {
                        the_widget('WC_Widget_Layered_Nav', [
                            'title' => $atributo->attribute_label,
                            'attribute' => $atributo->attribute_name
                        ]);
                    }
                ?>
            </div>

            <div class="filtro">
                <h3 class="filtro-titulo">Filtrar por preço</h3>

                <form class="filtro-preco">
                    <div>
                        <label for="min_price">De R$</label>
                        <input type="text" name="min_price" id="min_price" value="<?php $_GET['min_price']; ?>" required>
                    </div>

                    <div>
                        <label for="max_price">Até R$</label>
                        <input type="text" name="max_price" id="max_price" value="<?php $_GET['max_price']; ?>" required>
                    </div>

                    <button type="submit">Filtrar</button>
                </form>
            </div>
        </nav>

        <div>
            <h1 class="hidden">Prdutos</h1>
            <?php if ($dados['produtos'][0]) {
                    woocommerce_catalog_ordering();
                    handel_listar_produtos($dados['produtos']);
                    echo get_the_posts_pagination();
                } else {
            ?>
                <h2>Não encontramos resultados para sua pesquisa!</h2>
            <?php } ?>
            
        </div>
    </article>
</main>

<?php get_footer(); ?>
