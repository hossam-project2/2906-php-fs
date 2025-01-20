<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// الاتصال بقاعدة البيانات
$conn = new mysqli("localhost", "root", "", "company_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM projects WHERE status = 'قيد التنفيذ'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الصفحة الرئيسية</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <img src="logo.png" alt="شعار الشركة" class="logo">
        <nav>
            <ul>
                <li><a href="projects.php">متابعة المشاريع</a></li>
                <li><a href="add_project.php">إضافة مشروع</a></li>
                <li><a href="customer_service.php">خدمة العملاء</a></li>
                <li><a href="settings.php">إعدادات الحساب</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h1>مرحبًا بك في لوحة تحكم الشركة</h1>
        <div class="notifications">
            <h2>المشاريع قيد التنفيذ</h2>
            <table>
                <thead>
                    <tr>
                        <th>اسم المشروع</th>
                        <th>العميل</th>
                        <th>الحالة</th>
                        <th>تاريخ الإنتهاء المتوقع</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['project_name'] ?></td>
                            <td><?= $row['client_name'] ?></td>
                            <td><?= $row['status'] ?></td>
                            <td><?= $row['due_date'] ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
