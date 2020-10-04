<?php get_header(); ?>

<?php
    function formatar_single_product($id, $img_size = 'medium') {
        $produto = wc_get_product($id);

        $imgs_galeira = $produto->get_gallery_attachment_ids();
        $galeria = [];

        if ($imgs_galeira) {
            foreach($imgs_galeira as $img) {
                $galeria[] = wp_get_attachment_image_src($img, $img_size)[0];
            }
        }

        return [
            'id' => $id,
            'nome' => $produto->get_name(),
            'preco' => $produto->get_price_html(),
            'link' => $produto->get_permalink(),
            'sku' => $produto->get_sku(),
            'descricao' => $produto->get_description(),
            'img' => wp_get_attachment_image_src($produto->get_image_id(), $img_size)[0],
            'galeria' => $galeria
        ];
    }
?>

<div class="container breadcrumb">
    <?php woocommerce_breadcrumb(['delimiter' => ' > ']); ?>
</div>

<div class="container notificacao">
    <?php wc_print_notices(); ?>
</div>

<main class="container produto">
    <?php
        if (have_posts()) { while (have_posts()) { the_post();
            $produto = formatar_single_product(get_the_ID());
    ?>

        <div class="galeria-produto" data-galeria="galeria">
            <div class="lista-galeria-produto">
                <?php foreach($produto['galeria'] as $img) { ?>
                    <img src="<?= $img ?>" alt="<?= $produto['nome'] ?>" data-galeria="lista">
                <?php } ?>
            </div>

            <div class="produto-galeria-main">
                <img src="<?= $produto['img']; ?>" alt="<?= $produto['nome']; ?>" data-galeria="main">
            </div>
        </div>
        <div class="detalhe-produto">
            <small><?= $produto['sku'];  ?></small>
            <h1><?= $produto['nome']; ?></h1>
            <p class="preco-produto"><?= $produto['preco']; ?></p>
            <?php woocommerce_template_single_add_to_cart(); ?>
            <h2>Descrição</h2>
            <p><?= $produto['descricao']; ?></p>
        </div>
    <?php } } ?>
</main>

<?php
    $ids_relacionados = wc_get_related_products($produto['id'], 6);

    $produtos_relacionados = [];

    foreach($ids_relacionados as $id) {
        $produtos_relacionados[] = wc_get_product($id);
    }

    $relacionados = formatar_produtos($produtos_relacionados);
?>

<section class="relacionados">
    <div class="container">
        <h1>Relacionados</h2>

        <?php handel_listar_produtos($relacionados); ?>
    </div>
</section>

<?php get_footer(); ?>
