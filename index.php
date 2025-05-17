<?php
// --- PHP INITIALIZATION ---
ini_set('display_errors', 1); // For development, remove/disable in production
error_reporting(E_ALL);     // For development

session_start();

// --- CONFIGURATION ---
define('DB_HOST', 'localhost');       // Replace with your DB host
define('DB_USER', 'root');     // Replace with your DB username
define('DB_PASS', 'Dhiraj@2009'); // Replace with your DB password
define('DB_NAME', 'StudyNexus');   // Replace with your DB name
define('SITE_TITLE', 'StudyNexus');
define('BASE_URL', strtok($_SERVER["REQUEST_URI"], '?')); // Gets the base path for cleaner URLs

// --- DATABASE CONNECTION (PDO) ---
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// --- COURSE DATA ---
$courses_data = [
    [
        'id' => 1,
        'name' => 'Web Development Fundamentals',
        'description' => 'Master HTML, CSS, and JavaScript basics to build modern websites.',
        'price' => 49,
        'image' => 'https://images.unsplash.com/photo-1542831371-29b0f74f9713?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3wzNjAzNTV8MHwxfHNlYXJjaHwyfHx3ZWIlMjBkZXZlbG9wbWVudHxlbnwwfHx8fDE3MTU4NjA0ODV8MA&ixlib=rb-4.0.3&q=80&w=400'
    ],
    [
        'id' => 2,
        'name' => 'Graphic Design Principles',
        'description' => 'Learn the core principles of visual communication and design.',
        'price' => 39,
        'image' => 'https://images.unsplash.com/photo-1626785774573-4b799315345d?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3wzNjAzNTV8MHwxfHNlYXJjaHw0fHxncmFwaGljJTIwZGVzaWdufGVufDB8fHx8MTcxNTg2MDUzMXww&ixlib=rb-4.0.3&q=80&w=400'
    ],
    [
        'id' => 3,
        'name' => 'Python for Data Science',
        'description' => 'Unlock data insights with Python, Pandas, NumPy, and Matplotlib.',
        'price' => 59,
        'image' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3wzNjAzNTV8MHwxfHNlYXJjaHwyfHxkYXRhJTIwc2NpZW5jZXxlbnwwfHx8fDE3MTU4NjA1Njd8MA&ixlib=rb-4.0.3&q=80&w=400'
    ],
    [
        'id' => 4,
        'name' => 'Digital Marketing Mastery',
        'description' => 'Strategies for SEO, SEM, social media, and content marketing.',
        'price' => 45,
        'image' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3wzNjAzNTV8MHwxfHNlYXJjaHwxMHx8ZGlnaXRhbCUyMG1hcmtldGluZ3xlbnwwfHx8fDE3MTU4NjA2MDV8MA&ixlib=rb-4.0.3&q=80&w=400'
    ],
    [
        'id' => 5,
        'name' => 'Mobile App Development (React Native)',
        'description' => 'Build cross-platform mobile apps using React Native framework.',
        'price' => 69,
        'image' => 'https://images.unsplash.com/photo-1607252650355-f7fd0460ccdb?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3wzNjAzNTV8MHwxfHNlYXJjaHwyfHxtb2JpbGUlMjBhcHAlMjBkZXZlbG9wbWVudHxlbnwwfHx8fDE3MTU4NjA2NDJ8MA&ixlib=rb-4.0.3&q=80&w=400'
    ],
    [
        'id' => 6,
        'name' => 'Cybersecurity Essentials',
        'description' => 'Understand threats and defenses in the digital world.',
        'price' => 55,
        'image' => 'https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3wzNjAzNTV8MHwxfHNlYXJjaHw2fHxjeWJlcnNlY3VyaXR5fGVufDB8fHx8MTcxNTg2MDY4Nnww&ixlib=rb-4.0.3&q=80&w=400'
    ],
    [
        'id' => 7,
        'name' => 'Cloud Computing with AWS',
        'description' => 'Explore AWS services for scalable cloud solutions.',
        'price' => 79,
        'image' => 'https://images.unsplash.com/photo-1605647540924-852290ab8b58?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3wzNjAzNTV8MHwxfHNlYXJjaHw0fHxhd3MlMjBjbG91ZHxlbnwwfHx8fDE3MTU4NjA3MTl8MA&ixlib=rb-4.0.3&q=80&w=400'
    ],
    [
        'id' => 8,
        'name' => 'Project Management (PMP Prep)',
        'description' => 'Learn PMBOK principles and prepare for PMP certification.',
        'price' => 89,
        'image' => 'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3wzNjAzNTV8MHwxfHNlYXJjaHw0fHxwcm9qZWN0JTIwbWFuYWdlbWVudHxlbnwwfHx8fDE3MTU4NjA3NTV8MA&ixlib=rb-4.0.3&q=80&w=400'
    ]
];

$hero_slides_data = [
    [
        'course_id' => 1,
        'image' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8Y29kaW5nJTIwaGVyb3xlbnwwfHwwfHx8MA%3D%3D&auto=format&fit=crop&w=1200&q=80',
        'name' => 'Web Development Fundamentals',
        'description' => 'Start your coding journey with our foundational web development course.'
    ],
    [
        'course_id' => 4,
        'image' => 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTV8fGJ1c2luZXNzJTIwc3RyYXRlZ3l8ZW58MHx8MHx8fDA%3D&auto=format&fit=crop&w=1200&q=80',
        'name' => 'Digital Marketing Mastery',
        'description' => 'Elevate your brand with cutting-edge digital marketing strategies.'
    ],
    [
        'course_id' => 7,
        'image' => 'https://images.unsplash.com/photo-1587620962725-abab7fe55159?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTV8fGxlYXJuaW5nJTIwaGVyb3xlbnwwfHwwfHx8MA&auto=format&fit=crop&w=1200&q=80',
        'name' => 'Cloud Computing with AWS',
        'description' => 'Master the cloud with Amazon Web Services and scale your applications.'
    ]
];

// --- HELPER FUNCTIONS ---
function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

function set_flash_message($message, $type = 'success') {
    $_SESSION['flash_message'] = ['message' => $message, 'type' => $type];
}

function display_flash_message() {
    if (isset($_SESSION['flash_message'])) {
        $flash = $_SESSION['flash_message'];
        echo "<div class='flash-message {$flash['type']}'>{$flash['message']}</div>";
        unset($_SESSION['flash_message']);
    }
}

function get_cart_item_count() {
    return isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
}

function get_course_by_id($id) {
    global $courses_data;
    foreach ($courses_data as $course) {
        if ($course['id'] == $id) {
            return $course;
        }
    }
    return null;
}

function get_cart_total() {
    $total = 0;
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $course_id => $item) {
            $course = get_course_by_id($course_id);
            if ($course) {
                $total += $course['price'];
            }
        }
    }
    return $total;
}

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function is_admin() {
    return is_logged_in() && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

// --- ACTION HANDLING (Forms, AJAX) ---
$action_message = '';
$action_message_type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        // REGISTRATION
        if ($_POST['action'] === 'register') {
            $username = sanitize_input($_POST['username']);
            $email = sanitize_input($_POST['email']);
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];
            $errors = [];

            if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
                $errors[] = "All fields are required.";
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Invalid email format.";
            }
            if (strlen($password) < 6) {
                $errors[] = "Password must be at least 6 characters long.";
            }
            if ($password !== $confirm_password) {
                $errors[] = "Passwords do not match.";
            }

            if (empty($errors)) {
                try {
                    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = :username OR email = :email");
                    $stmt->execute(['username' => $username, 'email' => $email]);
                    if ($stmt->fetch()) {
                        $errors[] = "Username or email already exists.";
                    } else {
                        $password_hash = password_hash($password, PASSWORD_DEFAULT);
                        $stmt = $pdo->prepare("INSERT INTO users (username, email, password_hash) VALUES (:username, :email, :password_hash)");
                        $stmt->execute(['username' => $username, 'email' => $email, 'password_hash' => $password_hash]);
                        set_flash_message("Registration successful! Please login.", "success");
                        header("Location: " . BASE_URL . "?view=login");
                        exit;
                    }
                } catch (PDOException $e) {
                    $errors[] = "Database error: " . $e->getMessage(); // Simplified error
                }
            }
            if (!empty($errors)) {
                $action_message = implode("<br>", $errors);
                $action_message_type = 'error';
            }
        }
        // LOGIN
        elseif ($_POST['action'] === 'login') {
            $login_identifier = sanitize_input($_POST['login_identifier']); // Email or Username
            $password = $_POST['password'];
            $errors = [];

            if (empty($login_identifier) || empty($password)) {
                $errors[] = "Email/Username and Password are required.";
            }

            if (empty($errors)) {
                try {
                    $stmt = $pdo->prepare("SELECT id, username, email, password_hash, role FROM users WHERE username = :identifier OR email = :identifier");
                    $stmt->execute(['identifier' => $login_identifier]);
                    $user = $stmt->fetch();

                    if ($user && password_verify($password, $user['password_hash'])) {
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['username'] = $user['username'];
                        $_SESSION['user_email'] = $user['email'];
                        $_SESSION['user_role'] = $user['role'];
                        set_flash_message("Welcome back, " . htmlspecialchars($user['username']) . "!", "success");
                        header("Location: " . BASE_URL);
                        exit;
                    } else {
                        $errors[] = "Invalid credentials.";
                    }
                } catch (PDOException $e) {
                    $errors[] = "Database error: " . $e->getMessage();
                }
            }
             if (!empty($errors)) {
                $action_message = implode("<br>", $errors);
                $action_message_type = 'error';
            }
        }
        // ADD TO CART (AJAX)
        elseif ($_POST['action'] === 'add_to_cart' && isset($_POST['course_id'])) {
            header('Content-Type: application/json'); // Ensure JSON response for AJAX
            $course_id = intval($_POST['course_id']);
            $course = get_course_by_id($course_id);

            if ($course) {
                if (!isset($_SESSION['cart'])) {
                    $_SESSION['cart'] = [];
                }
                // For PDFs, usually quantity is 1. If already in cart, don't re-add.
                if (!isset($_SESSION['cart'][$course_id])) {
                     $_SESSION['cart'][$course_id] = [
                        'name' => $course['name'],
                        'price' => $course['price'],
                        'image' => $course['image']
                        // quantity could be added here if needed
                    ];
                }
                echo json_encode(['success' => true, 'message' => 'Item added to cart!', 'cart_count' => get_cart_item_count()]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Course not found.']);
            }
            exit;
        }
        // REMOVE FROM CART
        elseif ($_POST['action'] === 'remove_from_cart' && isset($_POST['course_id'])) {
            $course_id = intval($_POST['course_id']);
            if (isset($_SESSION['cart'][$course_id])) {
                unset($_SESSION['cart'][$course_id]);
                set_flash_message("Item removed from cart.", "success");
            }
            header("Location: " . BASE_URL . "?view=cart");
            exit;
        }
        // CONFIRM PURCHASE (Payment Page)
        elseif ($_POST['action'] === 'confirm_purchase') {
            $payer_email = sanitize_input($_POST['payer_email']);
            $transaction_id_input = sanitize_input($_POST['transaction_id']);
            $errors = [];

            if (empty($payer_email) || !filter_var($payer_email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Valid email for PDF delivery is required.";
            }
            if (empty($transaction_id_input)) {
                $errors[] = "Transaction ID is required.";
            }
            if (empty($_SESSION['cart'])) {
                $errors[] = "Your cart is empty.";
            }

            if (empty($errors)) {
                $user_id_to_log = is_logged_in() ? $_SESSION['user_id'] : null;
                $cart_items = [];
                foreach ($_SESSION['cart'] as $item) {
                    $cart_items[] = $item['name'];
                }
                $courses_purchased_str = implode(', ', $cart_items);
                $total_amount = get_cart_total();

                try {
                    $stmt = $pdo->prepare("INSERT INTO transactions (user_id, email, transaction_id, courses_purchased, total_amount, order_status) VALUES (:user_id, :email, :transaction_id, :courses_purchased, :total_amount, 'Pending')");
                    $stmt->execute([
                        'user_id' => $user_id_to_log,
                        'email' => $payer_email,
                        'transaction_id' => $transaction_id_input,
                        'courses_purchased' => $courses_purchased_str,
                        'total_amount' => $total_amount
                    ]);
                    
                    unset($_SESSION['cart']); // Clear cart
                    set_flash_message("Purchase confirmed! Your order is pending. PDFs will be sent to " . htmlspecialchars($payer_email) . " upon verification.", "success");
                    header("Location: " . BASE_URL . "?payment_success=true"); // Using GET param for success message on main page
                    exit;

                } catch (PDOException $e) {
                    $errors[] = "Database error during purchase: " . $e.getMessage();
                }
            }
             if (!empty($errors)) {
                // Stay on payment page and show errors
                $_GET['view'] = 'payment'; // Force payment view
                $action_message = implode("<br>", $errors);
                $action_message_type = 'error';
            }
        }
    }
}

// ADMIN ACTIONS (GET based for simplicity, POST recommended for state changes)
if (isset($_GET['action'])) {
    if ($_GET['action'] === 'logout') {
        session_destroy();
        header("Location: " . BASE_URL);
        exit;
    }
    elseif ($_GET['action'] === 'confirm_order' && isset($_GET['order_id']) && is_admin()) {
        $order_id = intval($_GET['order_id']);
        try {
            $stmt = $pdo->prepare("UPDATE transactions SET order_status = 'Confirmed' WHERE id = :id AND order_status = 'Pending'");
            $stmt->execute(['id' => $order_id]);
            if ($stmt->rowCount() > 0) {
                set_flash_message("Order #{$order_id} confirmed.", "success");
            } else {
                set_flash_message("Order #{$order_id} could not be confirmed or was already confirmed.", "warning");
            }
        } catch (PDOException $e) {
            set_flash_message("Database error confirming order: " . $e->getMessage(), "error");
        }
        header("Location: " . BASE_URL . "?view=admin");
        exit;
    }
}

// Handle payment success flash message from GET param
if (isset($_GET['payment_success']) && $_GET['payment_success'] == 'true' && !isset($_SESSION['flash_message'])) {
    // This message is set by the 'confirm_purchase' action before redirect
    // If somehow it's missed, set a generic one. But ideally it's already set.
    // set_flash_message("Payment successful! Your order is being processed.", "success");
}

// ROUTING (Determine current view)
$view = isset($_GET['view']) ? $_GET['view'] : 'main';

// Check admin access for admin page
if ($view === 'admin' && !is_admin()) {
    set_flash_message("Access denied. You must be an admin.", "error");
    header("Location: " . BASE_URL . "?view=login");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_TITLE . (isset($courses_data[$view-1]['name']) ? ' - ' . $courses_data[$view-1]['name'] : ($view !== 'main' ? ' - ' . ucfirst($view) : ' - Home')); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        /* --- CSS STYLES --- */
        :root {
            --primary-color: #007bff; /* A nice blue */
            --primary-hover-color: #0056b3;
            --secondary-color: #6c757d; /* Grey */
            --success-color: #28a745;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
            --font-family: 'Open Sans', sans-serif;
            --border-radius: 25px; /* Pill shape for buttons */
            --card-border-radius: 8px;
            --header-height: 70px;
        }

        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: var(--font-family);
            line-height: 1.6;
            color: var(--dark-color);
            background-color: #f4f7f6; /* Light neutral background */
            padding-top: var(--header-height); /* For sticky header */
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px 0;
        }

        /* Header */
        header {
            background: linear-gradient(135deg, #ffffff 0%, #eef2f7 100%); /* Subtle gradient */
            color: var(--dark-color);
            padding: 0 20px;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: var(--header-height);
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        header .site-title {
            font-size: 1.8em;
            font-weight: 700;
            color: var(--primary-color);
            text-decoration: none;
        }

        header nav ul {
            list-style: none;
            display: flex;
        }

        header nav ul li {
            margin-left: 20px;
        }

        header nav ul li a {
            text-decoration: none;
            color: var(--dark-color);
            font-weight: 600;
            padding: 8px 12px;
            border-radius: var(--border-radius);
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        header nav ul li a:hover, header nav ul li a.active {
            background-color: var(--primary-color);
            color: white;
        }
        .cart-count {
            background-color: var(--danger-color);
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 0.8em;
            margin-left: 4px;
            vertical-align: super;
        }

        /* Hero Slider */
        .hero-slider {
            position: relative;
            width: 100%;
            max-height: 500px; /* Adjust as needed */
            overflow: hidden;
            margin-bottom: 40px;
            background-color: var(--dark-color); /* Fallback */
        }
        .hero-slider .slide {
            display: none; /* Hidden by default, JS will show active */
            width: 100%;
            height: 500px; /* Ensure slides are same height */
            background-size: cover;
            background-position: center;
            position: relative;
        }
        .hero-slider .slide.active {
            display: block;
        }
        .hero-slider .slide-content {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            background: rgba(0,0,0,0.6);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .hero-slider .slide-content h2 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }
        .hero-slider .slide-content p {
            font-size: 1.2em;
            margin-bottom: 20px;
        }
        .hero-slider .slide-dots {
            position: absolute;
            bottom: 15px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
        }
        .hero-slider .dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255,255,255,0.5);
            margin: 0 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .hero-slider .dot.active {
            background: white;
        }

        /* Section Titles */
        .section-title {
            font-size: 2.2em;
            font-weight: 700;
            margin-bottom: 30px;
            text-align: center;
            position: relative;
            padding-bottom: 10px;
            color: var(--dark-color);
        }
        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background-color: var(--primary-color);
            border-radius: 2px;
        }

        /* Course Listings */
        .courses-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
        }
        .course-card {
            background: white;
            border-radius: var(--card-border-radius);
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .course-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 8px 25px rgba(0,0,0,0.12);
        }
        .course-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }
        .course-card-content {
            padding: 20px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        .course-card-content h3 {
            font-size: 1.4em;
            margin-bottom: 10px;
            color: var(--primary-color);
        }
        .course-card-content p.description {
            font-size: 0.95em;
            color: var(--secondary-color);
            margin-bottom: 15px;
            flex-grow: 1;
        }
        .course-card-content .price {
            font-size: 1.5em;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 15px;
        }

        /* Buttons */
        .btn {
            display: inline-block;
            padding: 10px 25px;
            font-size: 1em;
            font-weight: 600;
            text-decoration: none;
            color: white;
            background-color: var(--primary-color);
            border: none;
            border-radius: var(--border-radius);
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            text-align: center;
        }
        .btn:hover {
            background-color: var(--primary-hover-color);
            transform: translateY(-2px);
        }
        .btn-secondary {
            background-color: var(--secondary-color);
        }
        .btn-secondary:hover {
            background-color: #545b62;
        }
        .btn-success {
            background-color: var(--success-color);
        }
        .btn-success:hover {
            background-color: #1e7e34;
        }
        .btn-danger {
            background-color: var(--danger-color);
        }
        .btn-danger:hover {
            background-color: #bd2130;
        }
        .btn-block {
            display: block;
            width: 100%;
        }

        /* Forms */
        .form-container {
            max-width: 500px;
            margin: 30px auto;
            padding: 30px;
            background: white;
            border-radius: var(--card-border-radius);
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--secondary-color);
        }
        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="password"],
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px; /* Slightly less rounded than buttons */
            font-size: 1em;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        .form-group input[type="text"]:focus,
        .form-group input[type="email"]:focus,
        .form-group input[type="password"]:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
        }
        .form-message {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 6px;
            font-weight: 500;
        }
        .form-message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .form-message.success {
             background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        /* Flash Messages */
        .flash-message {
            padding: 15px;
            margin: 20px auto;
            border-radius: var(--card-border-radius);
            font-weight: 500;
            text-align: center;
            max-width: 800px; /* Or container width */
        }
        .flash-message.success {
            background-color: var(--success-color);
            color: white;
        }
        .flash-message.error {
            background-color: var(--danger-color);
            color: white;
        }
        .flash-message.warning {
            background-color: var(--warning-color);
            color: var(--dark-color);
        }
        
        /* Cart Page */
        .cart-items {
            margin-bottom: 30px;
        }
        .cart-item {
            display: flex;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }
        .cart-item:last-child {
            border-bottom: none;
        }
        .cart-item img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: var(--card-border-radius);
            margin-right: 20px;
        }
        .cart-item-details {
            flex-grow: 1;
        }
        .cart-item-details h4 {
            margin-bottom: 5px;
            font-size: 1.1em;
        }
        .cart-item-details p {
            color: var(--secondary-color);
        }
        .cart-item .price {
            font-size: 1.2em;
            font-weight: 600;
            margin-right: 20px;
        }
        .cart-summary {
            background: var(--light-color);
            padding: 20px;
            border-radius: var(--card-border-radius);
            text-align: right;
            margin-bottom: 20px;
        }
        .cart-summary h3 {
            font-size: 1.8em;
            margin-bottom: 15px;
        }
        .cart-actions {
            display: flex;
            justify-content: space-between;
        }

        /* Payment Page */
        .payment-container {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            align-items: flex-start;
        }
        .payment-qr-section {
            flex: 1;
            min-width: 250px;
            text-align: center;
            padding: 20px;
            background: white;
            border-radius: var(--card-border-radius);
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }
        .payment-qr-section img {
            max-width: 200px; /* QR code size */
            height: auto;
            margin-bottom: 15px;
        }
        .payment-form-section {
            flex: 1.5;
            min-width: 300px;
        }

        /* Admin Panel */
        .admin-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        .admin-table th, .admin-table td {
            border: 1px solid #ddd;
            padding: 10px 12px;
            text-align: left;
            font-size: 0.95em;
        }
        .admin-table th {
            background-color: var(--light-color);
            font-weight: 600;
        }
        .admin-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .admin-table .status-Pending { color: var(--warning-color); font-weight: bold; }
        .admin-table .status-Confirmed { color: var(--success-color); font-weight: bold; }

        /* Animations */
        [data-animate] {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }
        [data-animate].is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            header {
                padding: 0 10px;
                flex-direction: column;
                height: auto;
                padding-bottom: 10px; /* adjust if needed */
            }
            body {
                padding-top: 100px; /* Adjust if header becomes taller */
            }
            header .site-title {
                margin-bottom: 10px;
                text-align: center;
                width: 100%;
            }
            header nav ul {
                flex-wrap: wrap;
                justify-content: center;
                padding-left: 0;
            }
            header nav ul li {
                margin: 5px;
            }
            .hero-slider, .hero-slider .slide {
                max-height: 350px;
                height: 350px;
            }
            .hero-slider .slide-content h2 { font-size: 1.8em; }
            .hero-slider .slide-content p { font-size: 1em; }

            .section-title { font-size: 1.8em; }
            .courses-grid {
                grid-template-columns: 1fr; /* Single column on mobile */
            }
            .cart-item {
                flex-direction: column;
                align-items: flex-start;
            }
            .cart-item img { margin-bottom: 10px; }
            .cart-item .price { margin-top:10px; margin-right: 0; }
            .cart-actions { flex-direction: column; }
            .cart-actions .btn { margin-bottom: 10px; width: 100%; }
            
            .payment-container { flex-direction: column; }
            .admin-table { font-size: 0.8em; }
            .admin-table th, .admin-table td { padding: 6px 8px; }
        }

        @media (max-width: 480px) {
             header nav ul li a { padding: 6px 8px; font-size: 0.9em; }
             .container { width: 95%; }
        }
    </style>
</head>
<body>
    <header>
        <a href="<?php echo BASE_URL; ?>" class="site-title"><?php echo SITE_TITLE; ?></a>
        <nav>
            <ul>
                <li><a href="<?php echo BASE_URL; ?>" class="<?php echo ($view === 'main' ? 'active' : ''); ?>">Courses</a></li>
                <li>
                    <a href="<?php echo BASE_URL; ?>?view=cart" class="<?php echo ($view === 'cart' ? 'active' : ''); ?>">
                        Cart <span class="cart-count" id="cart-item-count-header"><?php echo get_cart_item_count(); ?></span>
                    </a>
                </li>
                <?php if (is_logged_in()): ?>
                    <li><span style="padding: 8px 12px; color: var(--secondary-color);">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span></li>
                    <?php if (is_admin()): ?>
                        <li><a href="<?php echo BASE_URL; ?>?view=admin" class="<?php echo ($view === 'admin' ? 'active' : ''); ?>">Admin</a></li>
                    <?php endif; ?>
                    <li><a href="<?php echo BASE_URL; ?>?action=logout">Logout</a></li>
                <?php else: ?>
                    <li><a href="<?php echo BASE_URL; ?>?view=login" class="<?php echo ($view === 'login' ? 'active' : ''); ?>">Login</a></li>
                    <li><a href="<?php echo BASE_URL; ?>?view=register" class="<?php echo ($view === 'register' ? 'active' : ''); ?>">Register</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main>
        <?php display_flash_message(); ?>
        <?php if (!empty($action_message) && ($view === 'login' || $view === 'register' || $view === 'payment')): // Display form-specific messages ?>
            <div class="container">
                <div class="form-message <?php echo $action_message_type; ?>"><?php echo $action_message; ?></div>
            </div>
        <?php endif; ?>

        <?php
        // --- PAGE CONTENT ROUTING ---
        switch ($view) {
            case 'register':
                // --- REGISTRATION PAGE ---
                ?>
                <div class="container" data-animate>
                    <h1 class="section-title">Register</h1>
                    <div class="form-container">
                        <form action="<?php echo BASE_URL; ?>?view=register" method="POST" id="registerForm">
                            <input type="hidden" name="action" value="register">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" id="username" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password (min 6 chars)</label>
                                <input type="password" id="password" name="password" required minlength="6">
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">Confirm Password</label>
                                <input type="password" id="confirm_password" name="confirm_password" required>
                            </div>
                            <p id="passwordMatchError" style="color:red; display:none;">Passwords do not match.</p>
                            <p id="formError" style="color:red; display:none;">Please fill all fields correctly.</p>
                            <button type="submit" class="btn btn-block">Register</button>
                        </form>
                        <p style="text-align:center; margin-top:15px;">Already have an account? <a href="<?php echo BASE_URL; ?>?view=login">Login here</a>.</p>
                    </div>
                </div>
                <?php
                break;

            case 'login':
                // --- LOGIN PAGE ---
                ?>
                <div class="container" data-animate>
                    <h1 class="section-title">Login</h1>
                    <div class="form-container">
                        <form action="<?php echo BASE_URL; ?>?view=login" method="POST">
                            <input type="hidden" name="action" value="login">
                            <div class="form-group">
                                <label for="login_identifier">Email or Username</label>
                                <input type="text" id="login_identifier" name="login_identifier" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-block">Login</button>
                        </form>
                         <p style="text-align:center; margin-top:15px;">Don't have an account? <a href="<?php echo BASE_URL; ?>?view=register">Register here</a>.</p>
                    </div>
                </div>
                <?php
                break;

            case 'cart':
                // --- SHOPPING CART PAGE ---
                ?>
                <div class="container" data-animate>
                    <h1 class="section-title">Your Shopping Cart</h1>
                    <?php if (empty($_SESSION['cart'])): ?>
                        <p style="text-align:center; font-size:1.2em;">Your cart is empty.</p>
                        <div style="text-align:center; margin-top:20px;">
                             <a href="<?php echo BASE_URL; ?>" class="btn">Continue Shopping</a>
                        </div>
                    <?php else: ?>
                        <div class="cart-items">
                            <?php foreach ($_SESSION['cart'] as $course_id => $item): ?>
                                <?php $course_details = get_course_by_id($course_id); // Get full details if needed later ?>
                                <div class="cart-item" data-animate>
                                    <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                                    <div class="cart-item-details">
                                        <h4><?php echo htmlspecialchars($item['name']); ?></h4>
                                    </div>
                                    <span class="price">₹<?php echo htmlspecialchars($item['price']); ?></span>
                                    <form action="<?php echo BASE_URL; ?>?view=cart" method="POST" style="display:inline;">
                                        <input type="hidden" name="action" value="remove_from_cart">
                                        <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
                                        <button type="submit" class="btn btn-danger btn-small" style="padding: 5px 10px; font-size:0.9em;">Remove</button>
                                    </form>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="cart-summary" data-animate>
                            <h3>Total: ₹<?php echo get_cart_total(); ?></h3>
                        </div>
                        <div class="cart-actions" data-animate>
                            <a href="<?php echo BASE_URL; ?>" class="btn btn-secondary">Continue Shopping</a>
                            <a href="<?php echo BASE_URL; ?>?view=payment" class="btn btn-success">Proceed to Payment</a>
                        </div>
                    <?php endif; ?>
                </div>
                <?php
                break;

            case 'payment':
                // --- PAYMENT PAGE ---
                if (empty($_SESSION['cart'])) {
                    set_flash_message("Your cart is empty. Add items before proceeding to payment.", "warning");
                    header("Location: " . BASE_URL . "?view=cart");
                    exit;
                }
                $total_amount = get_cart_total();
                $qr_data = urlencode("upi://pay?pa=YOUR_UPI_ID@okhdfcbank&pn=" . urlencode(SITE_TITLE) . "&am={$total_amount}.00&cu=INR&tn=OrderPayment" . time()); // Replace YOUR_UPI_ID
                $qr_code_url = "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={$qr_data}";
                $prefill_email = is_logged_in() ? $_SESSION['user_email'] : '';
                ?>
                <div class="container" data-animate>
                    <h1 class="section-title">Payment</h1>
                    <p style="text-align:center; margin-bottom:20px; font-size:1.2em;">Total Amount: <strong>₹<?php echo $total_amount; ?></strong></p>
                    
                    <div class="payment-container">
                        <div class="payment-qr-section" data-animate>
                            <h4>Scan to Pay (Simulated)</h4>
                            <img src="<?php echo $qr_code_url; ?>" alt="Payment QR Code">
                            <p><strong>Instructions:</strong></p>
                            <ol style="text-align:left; margin-left:20px; font-size:0.9em;">
                                <li>Scan the QR code with your UPI app.</li>
                                <li>Complete the payment of ₹<?php echo $total_amount; ?>.</li>
                                <li>Enter the Transaction ID from your app below.</li>
                                <li>Enter your email for PDF delivery.</li>
                            </ol>
                        </div>

                        <div class="payment-form-section form-container" style="margin-top:0;" data-animate>
                             <form action="<?php echo BASE_URL; ?>?view=payment" method="POST">
                                <input type="hidden" name="action" value="confirm_purchase">
                                <div class="form-group">
                                    <label for="payer_email">Email Address (for PDF delivery)</label>
                                    <input type="email" id="payer_email" name="payer_email" value="<?php echo htmlspecialchars($prefill_email); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="transaction_id">Transaction ID</label>
                                    <input type="text" id="transaction_id" name="transaction_id" required>
                                </div>
                                <button type="submit" class="btn btn-success btn-block">Confirm Purchase</button>
                            </form>
                        </div>
                    </div>
                     <div style="margin-top: 30px; text-align:center;" data-animate>
                        <a href="<?php echo BASE_URL; ?>?view=cart" class="btn btn-secondary">« Back to Cart</a>
                    </div>
                </div>
                <?php
                break;

            case 'admin':
                // --- ADMIN PANEL ---
                if (!is_admin()) { /* Redundant check, already handled above, but good for direct access attempt */
                    header("Location: " . BASE_URL . "?view=login"); exit;
                }
                try {
                    $stmt = $pdo->query("SELECT t.*, u.username FROM transactions t LEFT JOIN users u ON t.user_id = u.id ORDER BY t.purchase_timestamp DESC");
                    $transactions = $stmt->fetchAll();
                } catch (PDOException $e) {
                    $transactions = [];
                    set_flash_message("Error fetching transactions: " . $e->getMessage(), "error");
                }
                ?>
                <div class="container" data-animate>
                    <h1 class="section-title">Admin Panel - Transactions</h1>
                    <?php if (empty($transactions)): ?>
                        <p>No transactions found.</p>
                    <?php else: ?>
                        <div style="overflow-x:auto;">
                        <table class="admin-table" data-animate>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Payer Email</th>
                                    <th>Courses Purchased</th>
                                    <th>Total (₹)</th>
                                    <th>Txn ID</th>
                                    <th>Status</th>
                                    <th>Timestamp</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($transactions as $txn): ?>
                                <tr>
                                    <td><?php echo $txn['id']; ?></td>
                                    <td><?php echo $txn['username'] ? htmlspecialchars($txn['username']) : 'Guest'; ?></td>
                                    <td><?php echo htmlspecialchars($txn['email']); ?></td>
                                    <td style="max-width:200px; overflow-wrap:break-word;"><?php echo htmlspecialchars($txn['courses_purchased']); ?></td>
                                    <td><?php echo $txn['total_amount']; ?></td>
                                    <td><?php echo htmlspecialchars($txn['transaction_id']); ?></td>
                                    <td class="status-<?php echo htmlspecialchars($txn['order_status']); ?>"><?php echo htmlspecialchars($txn['order_status']); ?></td>
                                    <td><?php echo $txn['purchase_timestamp']; ?></td>
                                    <td>
                                        <?php if ($txn['order_status'] === 'Pending'): ?>
                                            <a href="<?php echo BASE_URL; ?>?view=admin&action=confirm_order&order_id=<?php echo $txn['id']; ?>" class="btn btn-success" style="padding:3px 8px; font-size:0.8em;">Confirm</a>
                                        <?php else: echo '-'; endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        </div>
                    <?php endif; ?>
                </div>
                <?php
                break;

            default: // MAIN PAGE (Course Listings)
                // --- HERO SLIDER ---
                ?>
                <section class="hero-slider" id="heroSlider">
                    <?php foreach ($hero_slides_data as $index => $slide): ?>
                        <div class="slide <?php echo $index === 0 ? 'active' : ''; ?>" style="background-image: url('<?php echo htmlspecialchars($slide['image']); ?>');">
                            <div class="slide-content">
                                <h2 data-animate><?php echo htmlspecialchars($slide['name']); ?></h2>
                                <p data-animate><?php echo htmlspecialchars($slide['description']); ?></p>
                                <a href="#course-<?php echo $slide['course_id']; ?>" class="btn" data-animate>View Course</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div class="slide-dots">
                        <?php foreach ($hero_slides_data as $index => $slide): ?>
                            <span class="dot <?php echo $index === 0 ? 'active' : ''; ?>" data-slide-index="<?php echo $index; ?>"></span>
                        <?php endforeach; ?>
                    </div>
                </section>

                <div class="container">
                    <h1 class="section-title" data-animate>Our Courses</h1>
                    <div class="courses-grid">
                        <?php foreach ($courses_data as $course): ?>
                        <div class="course-card" id="course-<?php echo $course['id']; ?>" data-animate>
                            <img src="<?php echo htmlspecialchars($course['image']); ?>" alt="<?php echo htmlspecialchars($course['name']); ?>">
                            <div class="course-card-content">
                                <h3><?php echo htmlspecialchars($course['name']); ?></h3>
                                <p class="description"><?php echo htmlspecialchars($course['description']); ?></p>
                                <p class="price">₹<?php echo $course['price']; ?></p>
                                <button class="btn add-to-cart-btn" data-course-id="<?php echo $course['id']; ?>">Add to Cart</button>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php
        }
        ?>
    </main>

    <footer style="text-align: center; padding: 20px 0; margin-top: 40px; background-color: var(--dark-color); color: var(--light-color);">
        <p>© <?php echo date("Y"); ?> <?php echo SITE_TITLE; ?>. All rights reserved.</p>
    </footer>
    
    <div id="ajax-feedback" style="position:fixed; bottom:20px; right:20px; background-color:var(--success-color); color:white; padding:10px 20px; border-radius:5px; z-index:1001; display:none; box-shadow: 0 2px 10px rgba(0,0,0,0.2);">
        Item added to cart!
    </div>

    <script>
    // --- JAVASCRIPT ---
    document.addEventListener('DOMContentLoaded', function() {

        // --- Sticky Header Active Link ---
        const currentPath = window.location.href;
        const navLinks = document.querySelectorAll('header nav ul li a');
        navLinks.forEach(link => {
            if (link.href === currentPath) {
                // link.classList.add('active'); // Already handled by PHP, but good for dynamic client-side updates
            }
        });

        // --- Hero Slider ---
        const heroSlider = document.getElementById('heroSlider');
        if (heroSlider) {
            const slides = heroSlider.querySelectorAll('.slide');
            const dots = heroSlider.querySelectorAll('.dot');
            let currentSlide = 0;
            let slideInterval;

            function showSlide(index) {
                slides.forEach(s => s.classList.remove('active'));
                dots.forEach(d => d.classList.remove('active'));
                slides[index].classList.add('active');
                dots[index].classList.add('active');
                currentSlide = index;
            }

            function nextSlide() {
                currentSlide = (currentSlide + 1) % slides.length;
                showSlide(currentSlide);
            }

            dots.forEach(dot => {
                dot.addEventListener('click', function() {
                    showSlide(parseInt(this.dataset.slideIndex));
                    resetInterval();
                });
            });
            
            function startInterval() {
                 slideInterval = setInterval(nextSlide, 5000); // Auto-cycle every 5 seconds
            }
            function resetInterval() {
                clearInterval(slideInterval);
                startInterval();
            }

            if (slides.length > 0) {
                showSlide(0); // Show first slide initially
                startInterval();
            }
        }

        // --- Scroll Animations (Intersection Observer) ---
        const animatedElements = document.querySelectorAll('[data-animate]');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    // observer.unobserve(entry.target); // Optional: stop observing once animated
                } else {
                    // Optional: remove class if you want animation to repeat on scroll up/down
                    // entry.target.classList.remove('is-visible'); 
                }
            });
        }, { threshold: 0.1 }); // Trigger when 10% of element is visible

        animatedElements.forEach(el => observer.observe(el));

        // --- Add to Cart (AJAX) ---
        const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
        const cartCountHeader = document.getElementById('cart-item-count-header');
        const ajaxFeedbackDiv = document.getElementById('ajax-feedback');

        addToCartButtons.forEach(button => {
            button.addEventListener('click', function() {
                const courseId = this.dataset.courseId;
                
                const formData = new FormData();
                formData.append('action', 'add_to_cart');
                formData.append('course_id', courseId);

                fetch('<?php echo BASE_URL; ?>', { // Post to the same index.php
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        cartCountHeader.textContent = data.cart_count;
                        ajaxFeedbackDiv.textContent = data.message || 'Item added!';
                        ajaxFeedbackDiv.style.backgroundColor = 'var(--success-color)';
                        ajaxFeedbackDiv.style.display = 'block';
                        setTimeout(() => {
                            ajaxFeedbackDiv.style.display = 'none';
                            window.location.href = '<?php echo BASE_URL; ?>?view=cart'; // Redirect to cart page
                        }, 1500); // Show feedback for 1.5 seconds then redirect
                    } else {
                        ajaxFeedbackDiv.textContent = data.message || 'Failed to add item.';
                        ajaxFeedbackDiv.style.backgroundColor = 'var(--danger-color)';
                        ajaxFeedbackDiv.style.display = 'block';
                        setTimeout(() => {
                            ajaxFeedbackDiv.style.display = 'none';
                        }, 3000);
                    }
                })
                .catch(error => {
                    console.error('Error adding to cart:', error);
                    ajaxFeedbackDiv.textContent = 'Error: Could not add item.';
                    ajaxFeedbackDiv.style.backgroundColor = 'var(--danger-color)';
                    ajaxFeedbackDiv.style.display = 'block';
                     setTimeout(() => {
                        ajaxFeedbackDiv.style.display = 'none';
                    }, 3000);
                });
            });
        });

        // --- Registration Form Client-Side Validation ---
        const registerForm = document.getElementById('registerForm');
        if (registerForm) {
            const passwordField = document.getElementById('password');
            const confirmPasswordField = document.getElementById('confirm_password');
            const passwordMatchError = document.getElementById('passwordMatchError');
            const formError = document.getElementById('formError');

            function validateRegistrationForm() {
                let isValid = true;
                formError.style.display = 'none';
                passwordMatchError.style.display = 'none';

                // Basic required field check (HTML5 `required` attribute also helps)
                const inputs = registerForm.querySelectorAll('input[required]');
                inputs.forEach(input => {
                    if (!input.value.trim()) isValid = false;
                });
                
                if (passwordField.value.length < 6) {
                    // Handled by minlength attribute, but can add visual feedback
                    isValid = false;
                }

                if (passwordField.value !== confirmPasswordField.value) {
                    passwordMatchError.style.display = 'block';
                    isValid = false;
                }
                
                if (!isValid) {
                    formError.style.display = 'block';
                }
                return isValid;
            }

            registerForm.addEventListener('submit', function(event) {
                if (!validateRegistrationForm()) {
                    event.preventDefault(); // Stop submission if validation fails
                }
            });
            
            // Live password match check
            if(passwordField && confirmPasswordField && passwordMatchError){
                confirmPasswordField.addEventListener('keyup', function() {
                    if (passwordField.value !== confirmPasswordField.value) {
                        passwordMatchError.style.display = 'block';
                    } else {
                        passwordMatchError.style.display = 'none';
                    }
                });
                 passwordField.addEventListener('keyup', function() { // also check when original password changes
                    if (confirmPasswordField.value && passwordField.value !== confirmPasswordField.value) {
                        passwordMatchError.style.display = 'block';
                    } else {
                        passwordMatchError.style.display = 'none';
                    }
                });
            }
        }

    });
    </script>
</body>
</html>