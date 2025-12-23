<?php 
include 'db.php'; 
include 'header.php'; 

if(isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$error = "";
$success = "";


if(isset($_POST['register_btn'])) {
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    $confirm_pass = $_POST['confirm_password'];

    if($password !== $confirm_pass) {
        $error = "كلمتا المرور غير متطابقتين.";
    } 

    elseif(strlen($password) < 6) {
        $error = "يجب أن تكون كلمة المرور 6 أحرف على الأقل.";
    }
    else {

        $check_email = $conn->query("SELECT id FROM users WHERE email='$email'");
        if($check_email->num_rows > 0) {
            $error = "هذا البريد الإلكتروني مسجل بالفعل.";
        } else {

            $hashed_pass = password_hash($password, PASSWORD_DEFAULT);
            $role = 'user';

            $sql = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$hashed_pass', '$role')";
            
            if($conn->query($sql)) {
                $success = "تم إنشاء الحساب بنجاح! يمكنك الآن تسجيل الدخول.";
            } else {
                $error = "حدث خطأ في النظام، يرجى المحاولة لاحقاً.";
            }
        }
    }
}
?>
<head>
<link rel="stylesheet" href="style/auth.css">
</head>

<div class="login-wrapper">
    <div class="login-card">
        <h2 class="login-title">إنشاء حساب جديد</h2>
        
        <?php if($error != ""): ?>
            <div class="error-msg"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if($success != ""): ?>
            <div class="error-msg" style="background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0;">
                <?php echo $success; ?>
                <br>
                <a href="login.php" style="font-weight:bold; color:#065f46; margin-top:10px; display:inline-block;">انقر هنا لتسجيل الدخول</a>
            </div>
        <?php else: ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label>الاسم الكامل:</label>
                    <input type="text" name="username" class="form-control" required placeholder="محمد أحمد">
                </div>

                <div class="form-group">
                    <label>البريد الإلكتروني:</label>
                    <input type="email" name="email" class="form-control" required placeholder="example@suez.com">
                </div>
                
                <div class="form-group">
                    <label>كلمة المرور:</label>
                    <input type="password" name="password" class="form-control" required placeholder="********">
                </div>

                <div class="form-group">
                    <label>تأكيد كلمة المرور:</label>
                    <input type="password" name="confirm_password" class="form-control" required placeholder="********">
                </div>

                <button type="submit" name="register_btn" class="btn-login">تسجيل حساب جديد</button>
            </form>

            <div style="margin-top: 20px; font-size: 0.9rem;">
                لديك حساب بالفعل؟ <a href="login.php" style="color: var(--primary-mid); font-weight:bold;">سجل دخولك الآن</a>
            </div>
        
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>