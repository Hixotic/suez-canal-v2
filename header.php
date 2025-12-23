<?php include_once 'db.php'; ?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نظام مراقبة قناة السويس</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>

<header>
    <div class="logo">
        ⚓ Suez<span style="color: #48cae4">Track</span>
    </div>
    <nav>
        </a>
            <ul>
                <li><a href="index.php">الرئيسية</a></li>
                <li><a href="monitor.php">حركة السفن</a></li>
                <li><a href="weather.php">الطقس</a></li>
                <li><a href="news.php">الأخبار</a></li>
                <li><a href="contact.php">اتصل بنا</a></li>


        <?php if(isset($_SESSION['user_id'])): ?>
            <?php if($_SESSION['role'] == 'admin'): ?>
                <li><a href="dashboard.php" style="color: var(--foam);">لوحة التحكم</a></li>
            <?php elseif($_SESSION['role'] == 'manager'): ?>
                <li><a href="request.php" style="color: var(--foam);">طلباتي</a></li>
            <?php endif; ?>
           <li><a href="logout.php" class="cta-button" style="padding: 5px 15px; font-size: 0.9rem;">خروج</a></li>
        <?php else: ?>
            <li><a href="login.php">تسجيل الدخول</a></li>
        <?php endif; ?>
        </ul>
    </nav>
</header>