<?php 
include 'db.php'; 
include 'header.php'; 


?>
<head>
    <link rel="stylesheet" href="style/dashboard.css">
</head>

<?php

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

$msg = "";

if (isset($_POST['handle_request'])) {
    $req_id = $_POST['req_id'];
    $action = $_POST['action']; 
    $ship_name = $_POST['ship_name'];
    $ship_type = $_POST['ship_type'];

    $stmt = $conn->prepare("UPDATE requests SET request_status = ? WHERE id = ?");
    $stmt->bind_param("si", $action, $req_id);
    $stmt->execute();

    if ($action === 'Accepted') {
        $stmt_ship = $conn->prepare("INSERT INTO ships (ship_name, ship_type, status, arrival_time) VALUES (?, ?, 'Scheduled', NOW())");
        $stmt_ship->bind_param("ss", $ship_name, $ship_type);
        $stmt_ship->execute();
        $msg = "<p style='color:green;'>تم قبول السفينة ($ship_name).</p>";
    }
}

if (isset($_POST['post_news'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);
    $conn->query("INSERT INTO news (title, content) VALUES ('$title', '$content')");
    $msg = "<p style='color:green;'>تم نشر الخبر بنجاح.</p>";
}

if (isset($_POST['delete_msg'])) {
    $msg_id = $_POST['msg_id'];
    $conn->query("DELETE FROM messages WHERE id = $msg_id");
    $msg = "<p style='color:red;'>تم حذف الرسالة.</p>";
}
?>

<div style="padding-top: 100px; padding-bottom: 50px;">
    <div class="container">
        <h1 class="page-title">لوحة تحكم الإدارة</h1>
        
        <?php if($msg != "") echo "<div class='news-card' style='padding:15px; text-align:center;'>$msg</div>"; ?>

        <div class="dashboard-grid">
            
            <div class="news-card" style="padding: 30px; margin:0;">
                <h3 class="dash-title">📋 طلبات العبور المعلقة</h3>
                <table style="font-size: 0.9rem;">
                    <thead>
                        <tr>
                            <th>السفينة</th>
                            <th>الإجراء</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $res_req = $conn->query("SELECT r.*, u.username FROM requests r JOIN users u ON r.manager_id = u.id WHERE r.request_status = 'Pending'");
                        if ($res_req->num_rows > 0) {
                            while ($row = $res_req->fetch_assoc()) {
                                echo "<tr>
                                    <td><strong>{$row['ship_name']}</strong><br><small>{$row['request_type']}</small></td>
                                    <td>
                                        <form method='POST'>
                                            <input type='hidden' name='req_id' value='{$row['id']}'>
                                            <input type='hidden' name='ship_name' value='{$row['ship_name']}'>
                                            <input type='hidden' name='ship_type' value='{$row['request_type']}'>
                                            <button type='submit' name='handle_request' onclick=\"this.form.action.value='Accepted'\" class='btn-action btn-accept'>✓</button>
                                            <button type='submit' name='handle_request' onclick=\"this.form.action.value='Rejected'\" class='btn-action btn-reject'>✗</button>
                                            <input type='hidden' name='action' value=''>
                                        </form>
                                    </td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='2' style='text-align:center;'>لا يوجد طلبات</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>


            <div class="news-card" style="padding: 30px; margin:0;">
                <h3 class="dash-title">📢 نشر خبر جديد</h3>
                <form method="POST">
                    <div class="form-group">
                        <input type="text" name="title" class="form-control" required placeholder="عنوان الخبر">
                    </div>
                    <div class="form-group">
                        <textarea name="content" class="form-control" rows="3" required placeholder="التفاصيل..."></textarea>
                    </div>
                    <button type="submit" name="post_news" class="btn123" style="padding: 8px;">نشر</button>
                </form>
            </div>


            <div class="news-card" style="padding: 30px; margin:0; grid-column: 1 / -1;">
                <h3 class="dash-title">📩 رسائل الزوار (الوارد)</h3>
                
                <table style="width:100%; font-size: 0.95rem;">
                    <thead>
                        <tr>
                            <th style="width: 20%;">المرسل</th>
                            <th style="width: 60%;">الرسالة</th>
                            <th style="width: 10%;">التاريخ</th>
                            <th style="width: 10%;">تحكم</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql_msg = "SELECT * FROM messages ORDER BY sent_at DESC";
                        $res_msg = $conn->query($sql_msg);

                        if ($res_msg->num_rows > 0) {
                            while ($row = $res_msg->fetch_assoc()) {
                                $date = date("Y-m-d", strtotime($row['sent_at']));
                                echo "<tr>
                                    <td style='vertical-align: top;'>
                                        <strong>{$row['sender_name']}</strong><br>
                                        <small style='color:#888;'>{$row['sender_email']}</small>
                                    </td>
                                    <td>
                                        <span class='msg-subject'>{$row['subject']}</span>
                                        <div class='msg-text'>".nl2br(htmlspecialchars($row['message']))."</div>
                                    </td>
                                    <td style='vertical-align: top; color:#888;'>$date</td>
                                    <td style='vertical-align: top;'>
                                        <form method='POST' onsubmit='return confirm(\"هل أنت متأكد من حذف هذه الرسالة؟\");'>
                                            <input type='hidden' name='msg_id' value='{$row['id']}'>
                                            <button type='submit' name='delete_msg' class='btn-delete-msg'>حذف 🗑️</button>
                                        </form>
                                    </td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4' style='text-align:center; padding:20px;'>صندوق الوارد فارغ.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<?php include 'footer.php'; ?>