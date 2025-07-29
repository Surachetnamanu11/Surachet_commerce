<?php
require_once '../../includes/db.php';
require_once '../../includes/config.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: product.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    echo "ไม่พบข้อมูลสินค้า";
    exit;
}

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

    if (!$error) {
        $imageName = $product['image'];
        if ($image) {
            $imageName = time() . '_' . basename($image);
            move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $imageName);
        }

        $stmt = $pdo->prepare("UPDATE products SET name = ?, description = ?, price = ?, stock = ?, image = ? WHERE id = ?");
        $stmt->execute([$name, $description, $price, $stock, $imageName, $id]);

        header('Location: product.php');
        exit;
    }
}
?>

<?php ob_start(); ?>
<h2>แก้ไขสินค้า</h2>

<?php if ($error): ?>
<p style="color: red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 16px;">
    <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>
    <textarea name="description"><?= htmlspecialchars($product['description']) ?></textarea>
    <input type="number" step="0.01" name="price" value="<?= $product['price'] ?>" required>
    <input type="number" name="stock" value="<?= $product['stock'] ?>" required>
    <label>ภาพปัจจุบัน:
        <?php if ($product['image']): ?>
            <img src="uploads/<?= htmlspecialchars($product['image']) ?>" width="100">
        <?php else: ?>
            ไม่มีภาพ
        <?php endif; ?>
    </label>
    <input type="file" name="image">
    <button type="submit">💾 บันทึก</button>
    <a href="product.php">↩ กลับ</a>
</form>
<?php
$content = ob_get_clean();
$title = "แก้ไขสินค้า";
include __DIR__ . '/../layouts/layout.php';
?>
