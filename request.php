<?php 
include 'db.php'; 
include 'header.php'; 

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'manager') {
    header("Location: index.php");
    exit();
}

$msg = "";


if (isset($_POST['submit_req'])) {
    $ship_name = $conn->real_escape_string($_POST['ship_name']);
    $type = $conn->real_escape_string($_POST['type']);
    $manager_id = $_SESSION['user_id'];


    $sql = "INSERT INTO requests (manager_id, ship_name, request_type) VALUES ('$manager_id', '$ship_name', '$type')";
    
    if ($conn->query($sql)) {
        $msg = "<div class='error-msg' style='background:#d1fae5; color:#065f46; border-color:#a7f3d0;'>تم إرسال طلبك بنجاح! في انتظار موافقة الإدارة.</div>";
    } else {
        $msg = "<div class='error-msg'>حدث خطأ أثناء الإرسال.</div>";
    }
}
?>
<head>
    <link rel="stylesheet" href="style/dashboard.css">
</head>

<div style="padding-top: 100px; padding-bottom: 50px;">
    <div class="container">
        
        <h1 class="page-title">بوابة مديري السفن</h1>
        <p style="text-align:center; color:#666; margin-bottom: 40px;">
            مرحباً بك، <?php echo $_SESSION['username']; ?>. يمكنك تقديم طلبات العبور ومتابعة حالتها من هنا.
        </p>

        <div class="dashboard-grid">
            
            <div class="news-card" style="padding: 30px; margin:0; height: fit-content;">
                <h3 class="dash-title">تقديم طلب جديد</h3>
                <?php echo $msg; ?>
                
                <form method="POST">
                    <div class="form-group">
                        <label>اسم السفينة:</label>
                        <input type="text" name="ship_name" class="form-control" required placeholder="مثال: إيفر جيفن">
                    </div>

                    <div class="form-group">
                        <label>نوع السفينة / الطلب:</label>
                        <select name="type" class="form-control" required>
                            <option value="Container Ship">سفينة حاويات (Container)</option>
                            <option value="Oil Tanker">ناقلة نفط (Oil Tanker)</option>
                            <option value="Bulk Carrier">بضائع صب (Bulk Carrier)</option>
                            <option value="LNG Carrier">ناقلة غاز (LNG)</option>
                            <option value="Maintenance">طلب صيانة طارئة</option>
                        </select>
                    </div>

                    <button type="submit" name="submit_req" class="btn123" style="margin-top: 20px;">إرسال الطلب</button>
                </form>
            </div>

            <div class="news-card" style="padding: 30px; margin:0;">
                <h3 class="dash-title">سجل طلباتي السابقة</h3>
                
                <table class="history-table">
                    <thead>
                        <tr>
                            <th>السفينة</th>
                            <th>النوع</th>
                            <th>تاريخ الطلب</th>
                            <th>الحالة</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $my_id = $_SESSION['user_id'];
                        $sql_history = "SELECT * FROM requests WHERE manager_id = $my_id ORDER BY request_date DESC";
                        $res_hist = $conn->query($sql_history);

                        if ($res_hist->num_rows > 0) {
                            while ($row = $res_hist->fetch_assoc()) {

                                $status_text = $row['request_status'];
                                switch($status_text) {
                                    case 'Pending': $status_ar = "قيد المراجعة"; break;
                                    case 'Accepted': $status_ar = "تم القبول"; break;
                                    case 'Rejected': $status_ar = "مرفوض"; break;
                                    default: $status_ar = $status_text;
                                }

                                $date_short = date("Y-m-d", strtotime($row['request_date']));

                                echo "<tr>
                                    <td style='font-weight:bold;'>{$row['ship_name']}</td>
                                    <td>{$row['request_type']}</td>
                                    <td style='font-size:0.9rem; color:#888;'>$date_short</td>
                                    <td><span class='req-status req-{$status_text}'>$status_ar</span></td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4' style='text-align:center; padding:20px;'>لم تقم بإرسال أي طلبات بعد.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<?php include 'footer.php'; ?>