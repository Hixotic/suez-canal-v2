<?php 
include 'db.php'; 
include 'header.php'; 
?>
<head>
<link rel="stylesheet" href="style/weather.css">
</head>
<div> 

    <h1 class="page-title">حالة الطقس والملاحة</h1>
    <p style="text-align: center; color: #666; margin-bottom: 50px; margin-top: -20px;">
        بيانات محدثة للظروف الجوية في القطاعين الشمالي والجنوبي للقناة
    </p>

    <div class="weather-grid">
        

        <div class="weather-card">
            <div class="city-name">📍 بورسعيد (شمالاً)</div>
            <div class="weather-icon">⛅</div>
            <div class="temp-display">24°C</div>
            
            <div class="weather-details">
                <p><span>💨</span> سرعة الرياح: <strong>15 عقدة</strong></p>
                <p><span>💧</span> الرطوبة: <strong>65%</strong></p>
                <p><span>🌊</span> الموج: <strong>1.2 متر</strong></p>
            </div>
        </div>


        <div class="weather-card">
            <div class="city-name">📍 السويس (جنوباً)</div>
            <div class="weather-icon">☀️</div>
            <div class="temp-display">28°C</div>
            
            <div class="weather-details">
                <p><span>💨</span> سرعة الرياح: <strong>10 عقدة</strong></p>
                <p><span>💧</span> الرطوبة: <strong>40%</strong></p>
                <p><span>🌊</span> الموج: <strong>0.8 متر</strong></p>
            </div>
        </div>

    </div>


    <div class="nav-notice">
        <h3 style="color: var(--primary-dark); margin-bottom: 10px;">⚠️ نشرة ملاحية</h3>
        <p style="line-height: 1.8; color: #444;">
            الظروف الجوية في كلا القطاعين (الشمالي والجنوبي) <strong>مناسبة تماماً</strong> لعبور جميع أنواع السفن.
            الرؤية الأفقية ممتازة (أكثر من 10 كم). يرجى من القبطان الالتزام بالسرعات المقررة داخل المجرى الملاحي
            والتواصل الفوري مع مركز التحكم في حالة تغير سرعة الرياح المفاجئ.
        </p>
    </div>

</div>

<?php include 'footer.php'; ?>