<?php
    // Template Name: Home
    get_header();
?>

<?php 
    $produtos_slide = wc_get_products([
        'limit' => 6,
        'tag' => ['slide']
    ]);

    function formatar_produtos($produtos) {
        $produtos_finais = [];

        foreach($produtos as $produto) {
            $produtos_finais[] = [
                "nome" => $produto->get_name(),
                "preco" => $produto->get_price_html(),
                "link" => $produto->get_permalink(),
                "img" => wp_get_attachment_image_src($produto->get_image_id(), 'slide')[0]
            ];
        }

        return $produtos_finais;
    }

    $slide = formatar_produtos($produtos_slide);
?>

<ul class="vantagens">
    <li>Frete Gratis</li>
    <li>Troca Fácil</li>
    <li>Até 12x</li>
</ul>

<?php if(have_posts()) { while(have_posts()) { the_post(); ?>
    <section class="slide-wrapper">
        <ul class="slide">
            <?php foreach($slide as $item) { ?>
                <li class="slide-item">
                    <img src="<?= $item["img"]; ?>" alt="<?php $item["nome"]; ?>">
                    <div class="slide-info">
                        <span class="slide-preco"><?= $item["preco"]; ?></span>
                        <h2 class="slide-nome"><?= $item["nome"]; ?></h2>
                        <a href="<?= $item['link']; ?>" class="slide-link">Ver Produto</a>
                    </div>
                </li>
            <?php } ?>
        </ul>
    </section>
<?php } } ?>

<?php get_footer(); ?>
