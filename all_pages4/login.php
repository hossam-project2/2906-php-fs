<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // الاتصال بقاعدة البيانات
    $conn = new mysqli("localhost", "root", "", "company_db");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // التحقق من وجود المستخدم وكلمة المرور
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            header("Location: index.php");
        } else {
            $error_message = "كلمة المرور غير صحيحة.";
        }
    } else {
        $error_message = "اسم المستخدم غير موجود.";
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-form">
        <h2>تسجيل الدخول</h2>
        <form action="login.php" method="POST">
            <label for="username">اسم المستخدم</label>
            <input type="text" id="username" name="username" required>
            <label for="password">كلمة المرور</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">دخول</button>
        </form>
        <?php if (isset($error_message)) { echo "<p>$error_message</p>"; } ?>
        <a href="#">استعادة كلمة المرور</a>
    </div>
</body>
</html>
