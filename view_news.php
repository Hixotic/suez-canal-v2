<?php 
include 'db.php'; 
include 'header.php'; 


if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<div class='container'><h3>خطأ: لم يتم تحديد الخبر.</h3></div>";
    include 'footer.php';
    exit();
}

$news_id = $_GET['id'];


$msg = "";
if (isset($_POST['submit_comment'])) {
    if (isset($_SESSION['user_id'])) {
        $comment = $conn->real_escape_string($_POST['comment']);
        $user_id = $_SESSION['user_id'];

        $insert_sql = "INSERT INTO comments (news_id, user_id, comment_text) VALUES ('$news_id', '$user_id', '$comment')";
        if ($conn->query($insert_sql)) {
            $msg = "<p style='color:green'>تم إضافة تعليقك بنجاح!</p>";
        }
    }
}


$sql_news = "SELECT * FROM news WHERE id = $news_id";
$result_news = $conn->query($sql_news);

if ($result_news->num_rows == 0) {
    echo "<div class='container'><h3>عفواً، الخبر غير موجود.</h3></div>";
    include 'footer.php';
    exit();
}

$news = $result_news->fetch_assoc();
?>

<head>
<link rel="stylesheet" href="style/news.css">
</head>
<div style="padding-top: 120px; padding-bottom: 50px;">
    
    <div class="news-container">
        <!-- The Main Article -->
        <div class="news-card" style="padding: 40px; cursor: default; transform: none;">
            <div class="single-news-header">
                <div class="single-news-meta">
                    <span>📅 <?php echo date("Y-m-d", strtotime($news['created_at'])); ?></span>
                    <span>📝 بواسطة: الإدارة</span>
                    <?php
                           if(isset($_SESSION['user_id'])){
                            if($_SESSION['role'] == 'admin'){ 
                                if (isset($_POST['delete_news'])) {
                                    $news_id = $_POST['newsid'];
                                    $conn->query("DELETE FROM news WHERE `news`.`id` = $news_id");
                                }
                    echo "<form method='POST' onsubmit='setTimeout(function () { window.location.reload(); }, 10)'>
                        <input type='hidden' name='newsid' value='{$news['id']}'>
                        <button type='submit' name='delete_news' class='btn-delete-news'style='font-family:Tajwal;background:rgb(200, 83, 83);color:rgb(255, 250, 250);border: 1px solid #fecaca;padding: 5px 10px;border-radius: 5px;cursor: pointer;font-size: 0.8rem;transition: 0.2s;'>حذف 🗑️</button>
                    </form>";
                }
            }
            ?>
        </div>
        <h1 class="single-news-title"><?php echo htmlspecialchars($news['title']); ?></h1>
    </div>

    <div class="news-body" style="font-size: 1.1rem; min-height: 200px;">
        <?php echo nl2br(htmlspecialchars($news['content'])); ?>
    </div>
</div>


        <div class="comments-section">
            <h3 style="color: var(--primary-dark); margin-bottom: 20px;">التعليقات والمناقشات</h3>


            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="news-card" style="padding: 20px; margin-bottom: 40px; box-shadow: none; border: 1px solid #ddd;">
                    <?php echo $msg; ?>
                    <form method="POST" class="comment-form">
                        <input type="hidden" name="news_id" value="<?php echo $news_id; ?>">
                        <label style="display:block; margin-bottom:10px; font-weight:bold;">أضف تعليقك:</label>
                        <textarea name="comment" rows="3" required placeholder="اكتب رأيك هنا..."></textarea>
                        <button type="submit" name="submit_comment" class="btn123" style="margin-top: 10px; border:none; cursor:pointer;">نشر التعليق</button>
                    </form>
                </div>
            <?php else: ?>
                <div class="login-alert">
                    يجب عليك <a href="login.php" style="color: var(--primary-dark); text-decoration: underline;">تسجيل الدخول</a> للمشاركة في التعليقات.
                </div>
                <br>
            <?php endif; ?>


            <?php
            $sql_comments = "SELECT c.*, u.username FROM comments c 
                             JOIN users u ON c.user_id = u.id 
                             WHERE c.news_id = $news_id 
                             ORDER BY c.created_at DESC";
            $result_comments = $conn->query($sql_comments);

            if ($result_comments->num_rows > 0) {
                while($comment = $result_comments->fetch_assoc()) {

                    $initial = mb_substr($comment['username'], 0, 1, "UTF-8");
                    
                    echo '
                    <div class="comment-box">
                        <div class="comment-avatar">' . $initial . '</div>
                        <div class="comment-content">
                            <h4>' . htmlspecialchars($comment['username']) . '</h4>
                            <p>' . nl2br(htmlspecialchars($comment['comment_text'])) . '</p>
                            <span class="comment-date">' . $comment['created_at'] . '</span>
                        </div>
                    </div>';
                }
            } else {
                echo "<p style='text-align:center; color:#888;'>لا توجد تعليقات حتى الآن. كن أول المعلقين!</p>";
            }
            ?>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>