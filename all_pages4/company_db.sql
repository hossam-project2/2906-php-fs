CREATE DATABASE company_db;

USE company_db;

-- جدول المستخدمين (users)
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL, 
    role VARCHAR(50) NOT NULL -- (مثل رئيس الأقسام, موظف خدمة العملاء, المدير)
);

-- جدول المشاريع (projects)
CREATE TABLE projects (
    project_id INT AUTO_INCREMENT PRIMARY KEY,
     project_name VARCHAR(255) NOT NULL,
    client_name VARCHAR(100) NOT NULL,
    phone_number VARCHAR(20),
    email VARCHAR(100),
    project_description TEXT,
     status ENUM('جديد', 'قيد التنفيذ', 'مكتمل', 'مؤجل') DEFAULT 'جديد',
    due_date DATE,
    estimated_cost DECIMAL(10, 2) NOT NULL,
    assigned_to VARCHAR(100) -- القسم المعني
);

-- جدول التعليقات والإشعارات (notifications)
CREATE TABLE notifications (
    notification_id INT AUTO_INCREMENT PRIMARY KEY,
    message TEXT,
    project_id INT,
    read_status BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (project_id) REFERENCES projects(project_id)
);
