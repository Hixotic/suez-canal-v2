<?php 
include 'db.php'; 
include 'header.php'; 

if(isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$error = "";


if(isset($_POST['login_btn'])) {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];


    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        

        if(password_verify($password, $row['password'])) {

            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];


            if($row['role'] == 'admin') {
                header("Location: dashboard.php");
            } elseif ($row['role'] == 'manager') {
                header("Location: request.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            $error = "كلمة المرور غير صحيحة";
        }
    } else {
        $error = "البريد الإلكتروني غير مسجل";
    }
}
?>
<head>
<link rel="stylesheet" href="style/auth.css">
</head>
<div class="login-wrapper">
    <div class="login-card">
        <h2 class="login-title">تسجيل الدخول</h2>
        
        <?php if($error != ""): ?>
            <div class="error-msg"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label>البريد الإلكتروني:</label>
                <input type="email" name="email" class="form-control" required placeholder="example@suez.com">
            </div>
            
            <div class="form-group">
                <label>كلمة المرور:</label>
                <input type="password" name="password" class="form-control" required placeholder="********">
            </div>

            <button type="submit" name="login_btn" class="btn-login">دخول النظام</button>
        </form>

        <div style="margin-top: 20px; font-size: 0.9rem; color: #777;">
            <p><a href='register.php'>إنشاء حساب جديد</a></p>
            <p>حسابات تجريبية:</p>
            <p><strong>Admin:</strong> admin@suez.com / 123456</p>
            <p><strong>Manager:</strong> manager@suez.com / 123456</p>
            <p><strong>User:</strong> atef@suez.com / 123456</p>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>