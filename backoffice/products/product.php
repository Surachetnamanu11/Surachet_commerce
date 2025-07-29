<?php
require_once '../../includes/db.php';
require_once '../../includes/config.php';

$stmt = $pdo->query("SELECT * FROM products ORDER BY created_at DESC");
$products = $stmt->fetchAll();
?>

<?php ob_start(); ?>
<div style="max-width: 1000px; margin: auto;">
    <h2>รายการสินค้า</h2>
    <a href="create_product.php" class="button">+ เพิ่มสินค้า</a>

    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; margin-top: 20px;">
        <thead>
            <tr>
                <th>#</th>
                <th>ชื่อสินค้า</th>
                <th>รายละเอียด</th>
                <th>ราคา</th>
                <th>จำนวน</th>
                <th>ภาพ</th>
                <th>จัดการ</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($products) > 0): ?>
                <?php foreach ($products as $i => $product): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= htmlspecialchars($product['name']) ?></td>
                        <td><?= nl2br(htmlspecialchars($product['description'])) ?></td>
                        <td><?= number_format($product['price'], 2) ?> ฿</td>
                        <td><?= $product['stock'] ?></td>
                        <td>
                            <?php if ($product['image']): ?>
                                <img src="uploads/<?= htmlspecialchars($product['image']) ?>" alt="" width="80">
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="edit_product.php?id=<?= $product['id'] ?>">✏ แก้ไข</a> | 
                            <a href="delete_product.php?id=<?= $product['id'] ?>" onclick="return confirm('คุณแน่ใจหรือไม่ที่จะลบ?')">🗑 ลบ</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align: center;">ไม่มีข้อมูลสินค้า</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php
$content = ob_get_clean();
$title = "Product List";
include __DIR__ . '/../layouts/layout.php';
?>
