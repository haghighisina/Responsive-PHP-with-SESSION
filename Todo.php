<?php
session_start();
$product_id = array();
if (filter_input(INPUT_POST, 'add')){
    if (isset($_SESSION['shopping_cart'])){

        $count      = count($_SESSION['shopping_cart']);

        $product_id = array_column($_SESSION['shopping_cart'], 'id');

        if (!in_array(filter_input(INPUT_GET, 'id'), $product_id)){
            $_SESSION['shopping_cart'][$count] = array(
                'id'       => filter_input(INPUT_GET, 'id'),
                'name'     => filter_input(INPUT_POST, 'name'),
                'price'    => filter_input(INPUT_POST, 'price'),
                'quantity' => filter_input(INPUT_POST, 'quantity')
            );
        }else{
            for ($i = 0; $i < count($product_id); $i++){
                if ($product_id[$i] == filter_input(INPUT_GET, 'id')){
                    $_SESSION['shopping_cart'][$i]['quantity'] += filter_input(INPUT_POST, 'quantity');
                }
            }
        }
    }else{
        $_SESSION['shopping_cart'][0] = array(
            'id'       => filter_input(INPUT_GET, 'id'),
            'name'     => filter_input(INPUT_POST, 'name'),
            'price'    => filter_input(INPUT_POST, 'price'),
            'quantity' => filter_input(INPUT_POST, 'quantity')
        );
    }
    header("location: index.php");
}

if (filter_input(INPUT_GET,'action') == 'delete'){
    foreach ($_SESSION['shopping_cart'] as $key => $product){
        if ($product['id'] == filter_input(INPUT_GET, 'id')){
            unset($_SESSION['shopping_cart'][$key]);
        }
    }
    $_SESSION['shopping_cart'] = array_values($_SESSION['shopping_cart']);

    header("location: index.php");
}

if (filter_input(INPUT_GET, 'cart') == 'ok'){
    session_destroy();
    header("location: index.php");
}