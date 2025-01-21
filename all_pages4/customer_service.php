<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $client_name = $_POST['client_name'];
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email'];
    $project_description = $_POST['project_description'];

    // الاتصال بقاعدة البيانات
    $conn = new mysqli("localhost", "root", "", "company_db");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO projects (client_name, phone_number, email, project_description, status)
            VALUES ('$client_name', '$phone_number', '$email', '$project_description', 'جديد')";
    
    if ($conn->query($sql) === TRUE) {
        echo "تم إرسال المشروع بنجاح!";
    } else {
        echo "حدث خطأ أثناء إرسال المشروع: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>خدمة العملاء</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <img src="logo.png" alt="شعار الشركة" class="logo">
        <nav>
            <ul>
                <li><a href="index.php">الصفحة الرئيسية</a></li>
                <li><a href="projects.php">متابعة المشاريع</a></li>
                <li><a href="add_project.php">إضافة مشروع</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h1>نموذج تقديم مشروع جديد</h1>
        <form action="customer_service.php" method="POST">
            <label for="client_name">اسم العميل</label>
            <input type="text" id="client_name" name="client_name" required>
            <label for="phone_number">رقم الهاتف</label>
            <input type="text" id="phone_number" name="phone_number" required>
            <label for="email">البريد الإلكتروني</label>
            <input type="email" id="email" name="email" required>
            <label for="project_description">وصف المشروع</label>
            <textarea id="project_description" name="project_description" required></textarea>
            <button type="submit">إرسال</button>
        </form>
    </main>
</body>
</html>
