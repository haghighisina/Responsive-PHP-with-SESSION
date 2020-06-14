<?php session_start(); ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Shopping cart</title>
    <link rel="icon" href="img/birdhouse_tweet_twitter_icon_127117.ico">
    <link rel="stylesheet" href="Cart.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>

<div class="container">
    <?php

    $conn   = mysqli_connect('localhost', 'root', '', 'cart');

    $query  = "SELECT * FROM products ORDER BY id ASC";

    $result = mysqli_query($conn, $query);

    if ($result):
        if (mysqli_num_rows($result) > 0):
            while ($product = mysqli_fetch_assoc($result)):
               ?>
                <div class="col-sm-4 col-md-3">
                    <form method="post" action="Todo.php?action=add&id=<?= $product['id'] ;?>">
                        <div class="products">
                            <img src="img/<?= $product['image'];?>" class="img-responsive">
                            <h4 class="text-info"><?= $product['name'];?></h4>
                            <h4>$ <?= $product['price'];?></h4>
                            <input type="text" name="quantity" value="1" class="form-control">
                            <input type="hidden" name="name" value="<?= $product['name'];?>">
                            <input type="hidden" name="price" value="<?= $product['price'];?>">
                            <input type="submit" name="add" class="btn btn-info" value="Add To Cart">
                        </div>
                    </form>
                </div>
               <?php
            endwhile;
        endif;
    endif;
?>

<div style="clear: both"></div>
<br />
<div class="table-responsive">
    <table class="table">
        <tr class="order">
            <td colspan="3"><h3>Order</h3></td>
            <td colspan="2">
                <a href="Todo.php?cart=ok">
                    <div class="btn-danger" style="text-align: center">Cart Empty</div>
                </a>
            </td>
        </tr>
        <tr>
            <th width="40%">Product</th>
            <th width="10%">Quantity</th>
            <th width="20%">Price</th>
            <th width="15%">Total</th>
            <th width="5%">Action</th>
        </tr>
        <?php
        if (!empty($_SESSION['shopping_cart'])):

            $total = 0;

            foreach ($_SESSION['shopping_cart'] as $key => $product):

        ?>
        <tr>
            <td><?= $product['name'];?></td>
            <td><?= $product['quantity'];?></td>
            <td>$ <?= $product['price'];?></td>
            <td>$ <?= number_format($product['quantity'] * $product['price'], 2);?></td>
            <td>
                <a href="Todo.php?action=delete&id=<?= $product['id']; ?>">
                    <div class="btn-danger">Remove</div>
                </a>
            </td>
        </tr>
        <?php

        $total = $total + ($product['price'] * $product['quantity']);
        endforeach;

        ?>

        <tr>
            <td colspan="3" align="right">Total</td>
            <td align="right">$ <?= number_format($total, 2);?></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="5">
                <?php
                if (isset($_SESSION['shopping_cart'])):
                if (count($_SESSION['shopping_cart']) > 0 ):
                ?>
                <a href="#" class="button">Check</a>
                <?php endif; endif; ?>
            </td>
        </tr>
        <?php
            endif;
        ?>
    </table>
</div>
</div>
</body>
</html>
