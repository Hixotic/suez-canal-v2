<?php 
include 'db.php'; 
include 'header.php'; 
?>

<head>
<link rel="stylesheet" href="style/contact.css">
</head>

<?php
$msg = "";

if(isset($_POST['send_message'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];


    $stmt = $conn->prepare("INSERT INTO messages (sender_name, sender_email, subject, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $subject, $message);
    
    if($stmt->execute()) {
        $msg = "<div class='success-msg'>شكراً لك! تم استلام رسالتك وسنقوم بالرد عليك قريباً.</div>";
    } else {
        $msg = "<div class='error-msg'>عذراً، حدث خطأ أثناء الإرسال.</div>";
    }
}
?>

<div style="padding-top: 100px; padding-bottom: 50px;">
    <div class="container">
        
        <h1 class="page-title">اتصل بنا</h1>
        <p style="text-align: center; color: #666; margin-bottom: 50px;">
            هل لديك استفسار؟ نحن هنا لمساعدتك على مدار الساعة.
        </p>

        <div class="contact-grid">
            
            <div class="contact-form-card">
                <?php echo $msg; ?>
                <form method="POST">
                    <div class="form-group">
                        <label>الاسم الكامل:</label>
                        <input type="text" name="name" class="contact-input" required placeholder="ادخل اسمك هنا">
                    </div>

                    <div class="form-group">
                        <label>البريد الإلكتروني:</label>
                        <input type="email" name="email" class="contact-input" required placeholder="email@example.com">
                    </div>

                    <div class="form-group">
                        <label>موضوع الرسالة:</label>
                        <input type="text" name="subject" class="contact-input" required placeholder="استفسار بخصوص...">
                    </div>

                    <div class="form-group">
                        <label>نص الرسالة:</label>
                        <textarea name="message" class="contact-input" required placeholder="اكتب رسالتك هنا..."></textarea>
                    </div>

                    <button type="submit" name="send_message" class="btn-send">إرسال الرسالة</button>
                </form>
            </div>


            <div class="contact-info-card">
                <h3 style="margin-bottom: 30px; border-bottom: 1px solid rgba(255,255,255,0.3); padding-bottom: 15px;">بيانات التواصل</h3>
                
                <div class="info-item">
                    <div class="info-icon">📍</div>
                    <div class="info-text">
                        <h4>العنوان الرئيسي</h4>
                        <p>محافظة الإسماعيلية، مصر<br>مبنى هيئة قناة السويس، شارع محمد علي</p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon">📞</div>
                    <div class="info-text">
                        <h4>الهاتف</h4>
                        <p>+20 64 339 0000<br>الخط الساخن: 16555</p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon">✉️</div>
                    <div class="info-text">
                        <h4>البريد الإلكتروني</h4>
                        <p>info@suezcanal.gov.eg<br>support@suez.com</p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon">🕒</div>
                    <div class="info-text">
                        <h4>ساعات العمل</h4>
                        <p>الأحد - الخميس: 8:00 ص - 4:00 م<br>غرفة العمليات: 24/7</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include 'footer.php'; ?>