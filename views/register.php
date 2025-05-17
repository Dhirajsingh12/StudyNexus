<h2>Register</h2>
<form method="POST" action="">
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <input type="password" name="confirm_password" placeholder="Confirm Password" required><br>
    <button type="submit" name="register">Register</button>
</form>

<?php
if (isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $pass = $_POST['password'];
    $cpass = $_POST['confirm_password'];

    if ($pass !== $cpass) {
        echo "<p style='color:red'>Passwords do not match!</p>";
    } elseif (strlen($pass) < 6) {
        echo "<p style='color:red'>Password must be at least 6 characters!</p>";
    } else {
        $hash = password_hash($pass, PASSWORD_DEFAULT);
        $stmt = $db->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hash);
        if ($stmt->execute()) {
            flash("Registration successful. Please log in.");
        } else {
            echo "<p style='color:red'>Error: Email may already exist.</p>";
        }
    }
}
?>
