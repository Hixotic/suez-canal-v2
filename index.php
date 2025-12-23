<?php include 'header.php'; ?>
<head>
<link rel="stylesheet" href="style/home.css">
</head>

    <section class="hero">
        <div class="hero-content">
            <div style="font-size: 1.2rem; color: var(--primary-mid); font-weight: 700; margin-bottom: 10px; letter-spacing: 2px;">بوابتك للملاحة العالمية</div>
            <h1>نبض الشريان الملاحي العالمي <br>بين يديك الآن</h1>
            <p>
                نقدم أحدث تقنيات المراقبة اللحظية وتحليل بيانات الطقس لضمان عبور آمن وسلس في قناة السويس.
                رؤية عصرية لخدمات لوجستية لا تتوقف.
            </p>
             <a href="monitor.php" class="cta-button">شاهد حركة السفن الآن</a>
        </div>
        

        <div class="ocean">
            <div class="wave"></div>
            <div class="wave"></div>
            <div class="wave"></div>
        </div>
    </section>

<?php
    $passing_query = $conn->query("SELECT COUNT(*) as count FROM ships WHERE status='Passing'");
    $passing_count = $passing_query ? $passing_query->fetch_assoc()['count'] : 0;

    $waiting_query = $conn->query("SELECT COUNT(*) as count FROM ships WHERE status='Waiting'");
    $waiting_count = $waiting_query ? $waiting_query->fetch_assoc()['count'] : 0;
?>


    <div class="live-stats">
        <div class="stat-card">
            <span class="stat-icon">🚢</span>
            <span class="stat-value"><?php echo $passing_count; ?></span>
            <span class="stat-label">سفينة تعبر الآن</span>
        </div>
        <div class="stat-card">
            <span class="stat-icon">⏱️</span>
            <span class="stat-value"><?php echo $waiting_count; ?></span>
            <span class="stat-label">سفينة في الانتظار</span>
        </div>
        <div class="stat-card">
            <span class="stat-icon">☀️</span>
            <span class="stat-value">24°C</span>
            <span class="stat-label">جو صافي - الإسماعيلية</span>
        </div>
        <div class="stat-card">
            <span class="stat-icon"></span>
            <span class="stat-value">12 Knots</span>
            <span class="stat-label">سرعة الرياح (شمالية)</span>
        </div>
    </div>


    <section class="about-section">
        <div class="about-visual">
            <img src="imgs/canal.jpg" style="height:100%;width:100%;object-fit: fill;z-index: 2;"></img>
        </div>
        <div class="about-text">
            <h2>دقة في المراقبة، أمان في العبور</h2>
            <p>
                تعتبر قناة السويس شريان الحياة للتجارة العالمية، ونحن هنا لنضيف طبقة من الذكاء الرقمي لهذه المنظومة. 
                منصتنا توفر تحليلات دقيقة لحركة السفن، التنبؤات الجوية المتقدمة، وحلول لوجستية ذكية تخدم الخطوط الملاحية العالمية.
            </p>
            <p>
                سواء كنت تدير أسطولاً بحرياً أو تتابع حركة التجارة، نوفر لك المعلومة الموثوقة في الوقت الحقيقي بواجهة عربية عصرية.
            </p>
        </div>
    </section>

    
    <section class="services">
        <h2 class="section-title">ماذا نقدم لك؟</h2>
        <div class="services-grid">
            <div class="service-card">
                <h3>📰 المركز الإعلامي</h3>
                <p>أحدث القرارات الملاحية والأخبار الرسمية من هيئة القناة.</p>
            </div>
            <div class="service-card">
                <h3>🌪️ رصد الطقس البحري</h3>
                <p>نظام متقدم لمراقبة سرعة الرياح، ارتفاع الأمواج، والرؤية الأفقية في بورسعيد والسويس لضمان سلامة الملاحة واتخاذ القرارات الصحيحة.</p>
            </div>
            <div class="service-card">
                <h3>📡 المراقبة الحية</h3>
                <p>تتبع دقيق لموقع السفن داخل المجرى الملاحي لحظة بلحظة باستخدام تقنيات الأقمار الصناعية و AIS، مع تنبيهات فورية لأي تغييرات في الجدول الزمني.</p>
            </div>
        </div>
    </section>

<?php include 'footer.php'; ?>

</body>
</html>