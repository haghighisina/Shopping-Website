<?php session_start();
require_once __DIR__.'/includes.php';
if (empty(countCartItemsInCart($userId))):
    notificationErrorMessage('your cart is empty');
    header('location: shopping_cart.php');
    exit();
    else:
$cartItems = countCartItemsInCart($userId);?>
<div class="container mt-5">
    <div class="container-fluid mt-5">
        <section class="row text-center">
            <p class="col-12 font-weight-bold">Thank you for your cooperation</p>
        </section>
        <section id="products">
            <table class="table table-striped">
                <thead>
                <tr class="text-white bg-dark">
                    <th>Name.</th><th>Quantity</th><th>Price (€)</th><th>Total price (€)</th><th>Total all product's price (€)</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($cartItems as $item):;?>
                    <tr>
                        <td><?= $item['product_name'] ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td><?= convertToMoney($item['price']);?></td>
                        <td><?= convertToMoney($item['product_price']);?></td>
                <?php endforeach;?>
                        <td><?= convertToMoney($cartSum);?> €</td>
                    </tr>
                </tbody>
            </table>
        </section>
    </div>
</div>
<?php endif;?>
