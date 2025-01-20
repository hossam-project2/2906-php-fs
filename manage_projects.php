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

// جلب المشاريع
$sql = "SELECT * FROM projects";
$result = $conn->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_status'])) {
    $project_id = $_POST['project_id'];
    $new_status = $_POST['new_status'];

    // تحديث حالة المشروع
    $update_sql = "UPDATE projects SET status = '$new_status' WHERE project_id = $project_id";
    if ($conn->query($update_sql) === TRUE) {
        echo "تم تحديث الحالة بنجاح!";
    } else {
        echo "حدث خطأ أثناء تحديث الحالة: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة المشاريع</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <img src="logo.png" alt="شعار الشركة" class="logo">
        <nav>
            <ul>
                <li><a href="index.php">الصفحة الرئيسية</a></li>
                <li><a href="customer_service.php">خدمة العملاء</a></li>
                <li><a href="department_head.php">رئيس الأقسام</a></li>
                <li><a href="manage_projects.php">إدارة المشاريع</a></li>
                <li><a href="logout.php">تسجيل الخروج</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h1>إدارة المشاريع</h1>

        <div class="project-list">
            <table>
                <thead>
                    <tr>
                        <th>اسم المشروع</th>
                        <th>العميل</th>
                        <th>الوصف</th>
                        <th>الحالة</th>
                        <th>تحديث الحالة</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['project_name'] ?></td>
                            <td><?= $row['client_name'] ?></td>
                            <td><?= $row['project_description'] ?></td>
                            <td><?= $row['status'] ?></td>
                            <td>
                                <form action="manage_projects.php" method="POST">
                                    <input type="hidden" name="project_id" value="<?= $row['project_id'] ?>">
                                    <select name="new_status">
                                        <option value="جديد" <?= $row['status'] == 'جديد' ? 'selected' : '' ?>>جديد</option>
                                        <option value="قيد التنفيذ" <?= $row['status'] == 'قيد التنفيذ' ? 'selected' : '' ?>>قيد التنفيذ</option>
                                        <option value="مكتمل" <?= $row['status'] == 'مكتمل' ? 'selected' : '' ?>>مكتمل</option>
                                        <option value="مؤجل" <?= $row['status'] == 'مؤجل' ? 'selected' : '' ?>>مؤجل</option>
                                    </select>
                                    <button type="submit" name="update_status">تحديث</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
