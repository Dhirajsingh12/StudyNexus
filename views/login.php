<h2>Login</h2>
<form method="POST" action="">
    <input type="text" name="email_or_user" placeholder="Email or Username" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit" name="login">Login</button>
</form>

<?php
if (isset($_POST['login'])) {
    $input = $_POST['email_or_user'];
    $pass = $_POST['password'];

    $stmt = $db->prepare("SELECT * FROM users WHERE email = ? OR username = ?");
    $stmt->bind_param("ss", $input, $input);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($user = $result->fetch_assoc()) {
        if (password_verify($pass, $user['password_hash'])) {
            $_SESSION['user'] = $user;
            flash("Login successful.");
        } else {
            echo "<p style='color:red'>Incorrect password.</p>";
        }
    } else {
        echo "<p style='color:red'>User not found.</p>";
    }
}
?>
