<?php 
include 'db.php'; 
include 'header.php'; 
?>
<head>
<link rel="stylesheet" href="style\monitor.css">
</head>

<?php

?>

<div class="container">
    
    <h1 class="page-title">حركة السفن الحية</h1>

    <div style="display: flex; justify-content: center; gap: 20px; margin-bottom: 40px; flex-wrap: wrap;">
        <div style="background: white; padding: 20px 40px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); text-align: center; border-bottom: 3px solid var(--primary-mid);">
            <span style="display: block; font-size: 2rem; font-weight: 900; color: var(--primary-dark);">
                <?php 
                $q = $conn->query("SELECT COUNT(*) as c FROM ships");
                echo $q->fetch_assoc()['c']; 
                ?>
            </span>
            <span style="color: #888;">إجمالي السفن</span>
        </div>
        
        <div style="background: white; padding: 20px 40px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); text-align: center; border-bottom: 3px solid #10b981;">
            <span style="display: block; font-size: 2rem; font-weight: 900; color: #10b981;">
                <?php 
                $q = $conn->query("SELECT COUNT(*) as c FROM ships WHERE status='Passing'");
                echo $q->fetch_assoc()['c']; 
                ?>
            </span>
            <span style="color: #888;">تعبر الآن</span>
        </div>
    </div>


    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>اسم السفينة</th>
                    <th>نوع السفينة</th>
                    <th>الحالة</th>
                    <th>وقت الوصول / العبور</th>
                        <?php if(isset($_SESSION['user_id'])){
                        if($_SESSION['role'] == 'admin'){ ?>
                            <th>إدارة</th>
                        <?php }} ?>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM ships ORDER BY arrival_time DESC";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $status_arabic = "";
                        $status_class = $row['status'];
                        
                        switch($row['status']) {
                            case 'Docked': $status_arabic = "عبرت القناة"; break;
                            case 'Passing': $status_arabic = "تعبر القناة"; break;
                            case 'Waiting': $status_arabic = "في الانتظار"; break;
                            case 'Scheduled': $status_arabic = "مجدولة"; break;
                            default: $status_arabic = $row['status'];
                        }

                        echo "<tr>
                            <td><span style='font-weight:bold; color:var(--primary-dark);'>{$row['ship_name']}</span></td>
                            <td>{$row['ship_type']}</td>
                            <td><span class='status-badge status-{$status_class}'>{$status_arabic}</span></td>
                            <td style='direction:ltr; text-align:right;'>{$row['arrival_time']}</td>";
                            
                            if(isset($_SESSION['user_id'])){
                            if($_SESSION['role'] == 'admin'){ 
                                if (isset($_POST['delete_ship'])) {
                                    $ship_id = $_POST['ship_id'];
                                    $conn->query("DELETE FROM ships WHERE `ships`.`id` = $ship_id");
                                }
                                if (isset($_POST['status'])) {
                                    $status = $_POST['status'];
                                    $ship_id = $_POST['ship_id'];
                                    $conn->query("UPDATE ships SET `status` = '$status' WHERE id = $ship_id");
                                }
                                echo "<td> <form method='POST' onsubmit=\"setTimeout(function () { window.location.reload(); }, 10)\">
                                            <input type='hidden' name='ship_id' value='{$row['id']}'>
                                            <button type='submit' name='delete_ship' class='btn-delete-ship' style='font-family:Tajwal;background:rgb(200, 83, 83);color:rgb(255, 250, 250);border: 1px solid #fecaca;padding: 5px 10px;border-radius: 5px;cursor: pointer;font-size: 0.8rem;transition: 0.2s;'>حذف 🗑️</button>
                                            <input type='hidden' name='ship_id' value='{$row['id']}'>
                                            <select name='status' onchange='this.form.submit()'>
                                                <option value='' disabled selected hidden>تغيير الحالة</option>
                                                <option value='Docked'>عبرت القناة</option>
                                                <option value='Passing'>تعبر القناة</option>
                                                <option value='Waiting'>في الانتظار</option>
                                                <option value='Scheduled'>مجدولة</option>
                                            </select>
                                        </form></td>";
                            }
                        echo "</tr>";
                    }}
                } else {
                    echo "<tr><td colspan='4' style='text-align:center; padding: 30px;'>لا توجد بيانات متاحة حالياً</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</div>

<div class="ocean" style="position: fixed; height: 5%; z-index: -1;">
    <div class="wave"></div>
    <div class="wave"></div>
</div>

<?php include 'footer.php'; ?>

</body>
</html>