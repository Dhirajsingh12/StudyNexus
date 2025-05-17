<h2>Your Cart</h2>
<?php if (empty($_SESSION['cart'])): ?>
    <p>Your cart is empty.</p>
<?php else: ?>
    <ul>
        <?php
        $total = 0;
        foreach ($_SESSION['cart'] as $item) {
            echo "<li><img src='{$item['img']}' width='50'> {$item['name']} - ₹{$item['price']} 
                <a href='?view=cart&remove={$item['id']}'>[Remove]</a></li>";
            $total += $item['price'];
        }
        ?>
    </ul>
    <p><strong>Total:</strong> ₹<?= $total ?></p>
    <a href="index.php" class="btn">Continue Shopping</a>
    <a href="?view=payment" class="btn">Proceed to Payment</a>
<?php endif; ?>

<?php
if (isset($_GET['remove'])) {
    unset($_SESSION['cart'][$_GET['remove']]);
    flash("Item removed from cart.");
}
?>
