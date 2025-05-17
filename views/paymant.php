<h2>Payment</h2>
<?php
$total_amount = array_sum(array_column($_SESSION['cart'] ?? [], 'price'));
if ($total_amount == 0) {
    flash("Your cart is empty.");
}
$email = isLoggedIn() ? $_SESSION['user']['email'] : '';
$qr_data = urlencode("upi://pay?pa=YOUR_UPI_ID@okhdfcbank&pn=" . urlencode(SITE_TITLE) . "&am={$total_amount}.00&cu=INR&tn=OrderPayment" . time());
$qr_img = "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=$qr_data";
?>

<img src="<?= $qr_img ?>" alt="QR Code"><br>
<p>Scan to pay ₹<?= $total_amount ?>. After payment, enter your details below:</p>
<form method="POST">
    <input type="email" name="payer_email" placeholder="Your Email" value="<?= $email ?>" required><br>
    <input type="text" name="txn_id" placeholder="Transaction ID" required><br>
    <button type="submit" name="confirm_payment">Confirm Purchase</button>
</form>
<a href="?view=cart">Back to Cart</a>

<?php
if (isset($_POST['confirm_payment'])) {
    $payer_email = $_POST['payer_email'];
    $txn_id = $_POST['txn_id'];
    $courses = implode(', ', array_column($_SESSION['cart'], 'name'));
    $uid = isLoggedIn() ? $_SESSION['user']['id'] : null;

    $stmt = $db->prepare("INSERT INTO transactions (user_id, email, transaction_id, courses_purchased, total_amount) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("isssi", $uid, $payer_email, $txn_id, $courses, $total_amount);
    if ($stmt->execute()) {
        $_SESSION['cart'] = [];
        flash("Payment recorded successfully. PDFs will be delivered soon.");
    } else {
        echo "<p style='color:red'>Error saving transaction.</p>";
    }
}
?>
