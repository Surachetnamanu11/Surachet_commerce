<?php
require_once '../../includes/db.php';
require_once '../../includes/config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price = floatval($_POST['price'] ?? 0);
    $stock = intval($_POST['stock'] ?? 0);
    $image = $_FILES['image']['name'] ?? null;

    if (!$name || $price <= 0 || $stock < 0) {
        $error = 'กรุณากรอกข้อมูลให้ครบถ้วน';
    }

    if ($image) {
            $imageName = time() . '_' . basename($image);
            $targetPath = __DIR__ . '/uploads' . $imageName;

            if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                $error = "ไม่สามารถอัปโหลดรูปภาพได้";
            }
        }

    if (!$error) {
        $imageName = null;
        if ($image) {
            $imageName = time() . '_' . basename($image);
            move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $imageName);
        }

        $stmt = $pdo->prepare("INSERT INTO products (name, description, price, stock, image) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $description, $price, $stock, $imageName]);

        header('Location: product.php');
        exit;
    }
}
?>

<?php ob_start(); ?>
<h2>เพิ่มสินค้าใหม่</h2>

<?php if ($error): ?>
<p style="color: red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 16px;">
    <input type="text" name="name" placeholder="ชื่อสินค้า" required>
    <textarea name="description" placeholder="รายละเอียดสินค้า"></textarea>
    <input type="number" step="0.01" name="price" placeholder="ราคาสินค้า" required>
    <input type="number" name="stock" placeholder="จำนวนในสต๊อก" required>
    <input type="file" name="image">
    <button type="submit">💾 บันทึก</button>
    <a href="product.php">↩ กลับ</a>
</form>
<?php
$content = ob_get_clean();
$title = "เพิ่มสินค้า";
include __DIR__ . '/../layouts/layout.php';
?>
