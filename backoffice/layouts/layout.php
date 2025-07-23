<?php
require_once __DIR__ . '/../../includes/config.php'; // เพิ่มบรรทัดนี้ด้านบน
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Backoffice' ?></title>
    <link rel="stylesheet" href="<?= BASE_PATH ?>/assets/css/style.css">
</head>

<body style="margin: 0; font-family: sans-serif;">

    <?php include __DIR__ . '/sidebar.php'; ?>
    <?php include __DIR__ . '/navbar.php'; ?>

    <div class="content" style="margin-left: 250px; padding: 80px 20px 20px;">
        <?php if (isset($content)) echo $content; ?>
    </div>

</body>
</html>
