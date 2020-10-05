<?php

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
