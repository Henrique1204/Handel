<?php

function handel_checkout_customizado($campos) {
    // $campos['billing']['billing_first_name']['label'] = "Primeiro Nome"; -- Altera o label do campo
    unset($campos['billing']['billing_phone']);

    $campos['billing']['billing_presente'] = [
        'label' => 'Embrulhar para presente?',
        'required' => false,
        'class' => ['form-row-wide'],
        'clear' => true,
        'type' => 'select',
        'options' => [
            'nao' => 'Não',
            'sim' => 'Sim'
        ]
    ];

    return $campos;
}

add_filter('woocommerce_checkout_fields', 'handel_checkout_customizado');

// Mostra na interface
function mostrar_campo_customizado_presente($pedido) {
    $presente = get_post_meta($pedido->get_id(), '_billing_presente', true);
    echo "<p><strong>Presente:</strong> $presente</p>";
}

add_action('woocommerce_admin_order_data_after_shipping_address', 'mostrar_campo_customizado_presente');

// Adiciona campo
function handel_campo_customizado_chekcout($campo) {
    woocommerce_form_field('mensagem_personalizada', [
        'type' => 'textarea',
        'class' => ['form-row-wide mensagem-personalizada'],
        'label' => 'Mensagem Personalizada',
        'placeholder' => 'Escreva uma mensagem para a pessoa que você está presenteando',
        'required' => true
    ], $campo->get_value('mensagem_personalizada'));
}

add_action('woocommerce_after_order_notes', 'handel_campo_customizado_chekcout');

// Validar campo
function handel_processo_customizado_checkout() {
    if (!$_POST['mensagem_personalizada']) {
        wc_add_notice( 'Por favor uma mensagem personalizada', 'error');
    }
}

add_action('woocommerce_checkout_process', 'handel_processo_customizado_checkout');

// Adicionar no Banco de Dados
function handel_atualizar_campos_customizados_checkout($pedido_id) {
    $conteudo = !empty($_POST['mensagem_personalizada']);
    if ($conteudo) {
        update_post_meta($pedido_id, 'mensagem_personalizada', sanitize_text_field($_POST['mensagem_personalizada']));
    }
}

add_action('woocommerce_checkout_update_order_meta', 'handel_atualizar_campos_customizados_checkout');


// Mostra na interface
function mostrar_campo_customizado_msg($pedido) {
    $msg = get_post_meta($pedido->get_id(), 'mensagem_personalizada', true);
    echo "<p><strong>Mensagem Personalizada:</strong> $msg</p>";
}

add_action('woocommerce_admin_order_data_after_shipping_address', 'mostrar_campo_customizado_msg');
