<h2>Admin Panel</h2>
<?php
$result = $db->query("SELECT t.*, u.username FROM transactions t LEFT JOIN users u ON t.user_id = u.id ORDER BY t.id DESC");
echo "<table border='1' cellpadding='5'><tr><th>ID</th><th>User</th><th>Email</th><th>Courses</th><th>Amount</th><th>Status</th><th>Time</th><th>Action</th></tr>";
while ($row = $result->fetch_assoc()) {
    echo "<tr>
        <td>{$row['id']}</td>
        <td>" . ($row['username'] ?? 'Guest') . "</td>
        <td>{$row['email']}</td>
        <td>{$row['courses_purchased']}</td>
        <td>₹{$row['total_amount']}</td>
        <td>{$row['order_status']}</td>
        <td>{$row['purchase_timestamp']}</td>
        <td>";
    if ($row['order_status'] === 'Pending') {
        echo "<a href='?view=admin&confirm={$row['id']}'>Confirm</a>";
    } else {
        echo "-";
    }
    echo "</td></tr>";
}
echo "</table>";

if (isset($_GET['confirm'])) {
    $id = intval($_GET['confirm']);
    $db->query("UPDATE transactions SET order_status = 'Confirmed' WHERE id = $id");
    flash("Order #$id confirmed.");
}
?>
