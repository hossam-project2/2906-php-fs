<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// الاتصال بقاعدة البيانات
$conn = new mysqli("localhost", "root", "", "company_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// جلب جميع المشاريع
$sql = "SELECT * FROM projects";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم المدير</title>
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
                <li><a href="admin_dashboard.php">لوحة تحكم المدير</a></li>
                <li><a href="logout.php">تسجيل الخروج</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h1>لوحة تحكم المدير</h1>

        <div class="dashboard">
            <h2>جميع المشاريع</h2>
            <table>
                <thead>
                    <tr>
                        <th>اسم المشروع</th>
                        <th>العميل</th>
                        <th>الوصف</th>
                        <th>الحالة</th>
                        <th>التكلفة</th>
                        <th>الموافقة النهائية</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['project_name'] ?></td>
                            <td><?= $row['client_name'] ?></td>
                            <td><?= $row['project_description'] ?></td>
                            <td><?= $row['status'] ?></td>
                            <td><?= $row['estimated_cost'] ?> ج.م</td>
                            <td>
                                <a href="project_details.php?project_id=<?= $row['project_id'] ?>">عرض التفاصيل</a>
                                <a href="approve_project.php?project_id=<?= $row['project_id'] ?>">موافقة نهائية</a>
                                <a href="edit_price.php?project_id=<?= $row['project_id'] ?>">تعديل السعر</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <div class="notifications">
            <h2>الإشعارات</h2>
            <ul>
                <li>مشروع "اسم المشروع" في انتظار الموافقة.</li>
                <li>تم استلام طلب جديد من خدمة العملاء لمشروع "اسم المشروع".</li>
                <!-- هنا يمكن إضافة المزيد من الإشعارات حسب الحاجة -->
            </ul>
        </div>
    </main>

</body>
</html>
/*
شرح الكود:

    التحقق من صلاحيات المدير:
    "admin".  في بداية الصفحة، يتم التحقق من أن المستخدم قد قام بتسجيل الدخول وله صلاحية "admin". 
    إذا لم يكن لديه هذه الصلاحية، يتم توجيهه إلى صفحة تسجيل الدخول.

    الاتصال بقاعدة البيانات:
        تم إنشاء الاتصال بقاعدة البيانات واسترجاع جميع المشاريع من جدول projects لعرضها في الجدول.

        يتم عرض المشاريع في جدول مع تفاصيل مثل اسم العميل، وصف المشروع، الحالة، التكلفة المقدرة، والروابط للموافقة النهائية وتعديل السعر.

    إدارة المشاريع:
        يحتوي الجدول على روابط:
            عرض التفاصيل: لعرض تفاصيل المشروع.
            موافقة نهائية: للموافقة على المشروع بعد مراجعة التفاصيل.
            تعديل السعر: لتعديل التكلفة المقدرة إذا لزم الأمر.

    الإشعارات:
        هناك قسم خاص للإشعارات التي تخبر المدير بتحديثات حول المشاريع مثل وجود مشاريع في انتظار الموافقة أو طلبات جديدة.

2. الجداول في قاعدة البيانات (SQL)

إذا لم تكن قد أنشأت جدول projects بشكل كامل بعد، إليك استعلام SQL لإضافة العمود estimated_cost الذي يخزن التكلفة المقدرة للمشروع:

ALTER TABLE projects ADD COLUMN estimated_cost DECIMAL(10, 2) NOT NULL;

هذا العمود سيسمح للمدير بتعديل تكلفة المشروع عند الحاجة.
إجراءات إضافية:

    إضافة صفحة لتعديل السعر (edit_price.php): يمكنك إضافة صفحة تسمح للمدير بتعديل السعر عبر النموذج. تأكد من التعامل مع التحقق من البيانات بشكل مناسب.

    إضافة صفحة لتفاصيل المشروع (project_details.php): صفحة تعرض تفاصيل دقيقة حول المشروع الذي يمكن للمدير مراجعتها قبل اتخاذ القرار.

    إضافة صفحة للموافقة النهائية (approve_project.php): بعد مراجعة التفاصيل، يمكن للمدير الموافقة على المشروع أو رفضه.

ختامًا:

بإضافة هذه الصفحة، يستطيع المدير إدارة المشاريع بشكل فعال، مع القدرة على تعديل الأسعار، الموافقة على المشاريع، ومتابعة الأداء العام.
You said:
*/