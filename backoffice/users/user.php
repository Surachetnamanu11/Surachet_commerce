<?php ob_start(); ?>

<div class="table-header">
    <h2> รายชื่อผู้ใช้</h2>
    <a href="create_user.php" class="button">+ สร้างผู้ใช้</a>
</div>
<table border="1" cellpadding="10" cellspacing="0" style="width:100%; margin-top: 20px">
<thead>
    <tr>
        <th>ชื่อผู้ใช้</th>
        <th>อีเมล</th>
        <th>จัดการ</th>
    </tr>
</thead>
<tbody>
    <tr>
        <td>demo_user</td>
        <td>demo@example.com</td>
        <td>
            <a href="edit_user.php?id=1">✏️</a>
            <a href="#" onclick="confirmDelete('delete_user.php?id=1')">🗑️</a>
        </td>
    </tr>
</tbody>
</table>

<div style="margin-top: 20px;">
  <a href="?page=1">1</a>
  <a href="?page=1">2</a>
  <a href="?page=1">3</a>
</div>

<?php
$content = ob_get_clean();
$title = "Users";
include __DIR__ . '/../layouts/layout.php';
?>