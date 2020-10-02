<?php
    // Template Name: Home
    get_header();
?>

<pre>
<?php 
    $produtos_slide = wc_get_products([
        'limit' => 6,
        'tag' => ['slide']
    ]);

    function formatar_produtos($produtos, $tamanho_img) {
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

    $novos_produtos = wc_get_products([
        'limit' => 9,
        'orderby' => 'date',
        'order' => 'DESC'
    ]);

    $produtos_vendas = wc_get_products([
        'limit' => 9,
        'meta_key' => 'total_sales',
        'orderby' => 'meta_value_num',
        'order' => 'DESC'
    ]);

    $dados = [
        'slide' => formatar_produtos($produtos_slide, 'slide'),
        'lancamentos' => formatar_produtos($novos_produtos, 'medium'),
        'vendas' => formatar_produtos($produtos_vendas, 'medium')
    ];
?>
</pre>

<ul class='vantagens'>
    <li>Frete Gratis</li>
    <li>Troca Fácil</li>
    <li>Até 12x</li>
</ul>

<?php if(have_posts()) { while(have_posts()) { the_post(); ?>
    <section class='slide-wrapper'>
        <ul class='slide'>
            <?php foreach($dados['slide'] as $item) { ?>
                <li class='slide-item'>
                    <img src='<?= $item['img']; ?>' alt='<?php $item['nome']; ?>'>
                    <div class='slide-info'>
                        <span class='slide-preco'><?= $item['preco']; ?></span>
                        <h2 class='slide-nome'><?= $item['nome']; ?></h2>
                        <a href='<?= $item['link']; ?>' class='btn-link'>Ver Produto</a>
                    </div>
                </li>
            <?php } ?>
        </ul>
    </section>

    <section class='container'>
        <h1 class='subtitulo'>Lançamento</h1>

        <?php handel_listar_produtos($dados['lancamentos']); ?>
    </section>

    <section class='container'>
        <h1 class='subtitulo'>Mais vendidos</h1>

        <?php handel_listar_produtos($dados['vendas']); ?>
    </section>
<?php } } ?>

<?php get_footer(); ?>
