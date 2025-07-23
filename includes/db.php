<?php
// โหลด ENV
$env = parse_ini_file(__DIR__ . '/../.env');

// ตั้งค่าจากไฟล์ .env
$host = $env['DB_HOST'] ?? 'localhost';
$db   = $env['DB_NAME'] ?? 'Surachet_commerce';
$user = $env['DB_USER'] ?? 'root';
$pass = $env['DB_PASS'] ?? '';
$charset = 'utf8mb4';

// สร้าง Data Source Name (DSN)
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// ตัวเลือกการตั้งค่า PDO
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // แจ้ง error ด้วย exception
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // คืนค่าข้อมูลแบบ associative array
    PDO::ATTR_EMULATE_PREPARES   => false,                  // ใช้ prepare statement จริง
];

// พยายามเชื่อมต่อฐานข้อมูล
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    echo "❌ Database connection failed: " . $e->getMessage();
    exit;
}