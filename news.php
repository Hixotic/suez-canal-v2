<?php 
include 'db.php'; 
include 'header.php'; 
?>
<head>
<link rel="stylesheet" href="style/news.css">
</head>
<div style="padding-top: 120px;">
    
    <h1 class="page-title">المركز الإعلامي</h1>
    <p style="text-align: center; color: #666; margin-bottom: 40px;">
        آخر الأخبار والقرارات الرسمية المتعلقة بحركة الملاحة
    </p>

    <div class="news-container">
        
        <?php

        $sql = "SELECT * FROM news ORDER BY created_at DESC";
        

        $result = $conn->query($sql);


        if ($result->num_rows > 0) {

            while($row = $result->fetch_assoc()) {

                $date = date("Y-m-d", strtotime($row['created_at']));
                

                echo '
                <div class="news-card">
                    <div class="news-content">
                        <div class="news-date">📅 ' . $date . '</div>
                        <h3 class="news-title">' . htmlspecialchars($row['title']) . '</h3>
                        <p class="news-body">' . nl2br(htmlspecialchars($row['content'])) . '</p>
                        
                        <a href="view_news.php?id=' . $row['id'] . '" class="read-more">قراءة التفاصيل ←</a>
                    </div>
                </div>
                ';
            }
        } else {

            echo '
            <div class="news-card" style="text-align:center;">
                <div class="news-content">
                    <h3 class="news-title">لا توجد أخبار حالياً</h3>
                    <p>يرجى التحقق لاحقاً للحصول على تحديثات.</p>
                </div>
            </div>
            ';
        }
        ?>

    </div>

</div>

<?php include 'footer.php'; ?>