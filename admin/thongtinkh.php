<?php session_start();
     include '../classses/user.php' ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1">
        <link rel="stylesheet" href="assets/font/themify-icons/themify-icons.css">
        <link rel="stylesheet" href="assets/css/thongtin.css">
        <title>Thông tin khách hàng</title>
        <style>
            .activity-more{
            display: flex;
            align-items: center;
            padding: 1rem;
            justify-content: end;
            }
            .activity-more span{
                background-color: rgb(24, 22, 22);
                color: #fff;
                border-radius: 50%;
                font-weight: 700;
            }
            .activity-more h4{
                color: #1D2231;
            }
            .activity-more a:hover{
            cursor: pointer;
            color: var(--text-grey);
            }
        </style>
    </head>
    
    <?php
    if (isset($_GET['banid'])) {
        $id = $_GET['banid'];
        $user = new user(); // Assuming your user class is named 'user'
        $banuser = $user->ban_user($id);
    }
    ?>
    <?php
    if (isset($_GET['unbanid'])) {
        $id = $_GET['unbanid'];
        $user = new user(); // Assuming your user class is named 'user'
    $unbanuser = $user->unban_user($id);
    echo $unbanuser;
    }
    ?>
    <body>
        <?php include './inc/sidebar.php' ?>
        <div class="main-content">
            <?php include './inc/header.php' ?>
            <main>
                <h2 class="dash-title">Thông tin khách hàng</h2>
                <div class="activity-more">
                    <span class="ti-plus"></span>
                    <a href="thongtinkhadd.php"> <h4>Thêm khách hàng</h4></a>
                </div>
                <section class="recent">
                    <div class="activity-grid">
                        <div class="activity-card">
                            <div class="table-responsive">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Mã KH</th>
                                            <th>Tên khách hàng</th>
                                            <th>SĐT</th>
                                            <th>Địa chỉ</th>
                                            <th>Ngày sinh</th>
                                            <th>Giới tính</th>
                                            <th>Hành động</th>
                                            <th>Trạng thái</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $user = new user();
                                    $show_User = $user->showKHAdmin();
                                    while ($result = $show_User->fetch_assoc()) {
                                        ?>
                                            <tr>
                                                <td><?php echo $result['userId'] ?></td>
                                                <td><?php echo $result['name'] ?></td>
                                                <td><?php echo $result['sdt'] ?></td>
                                                <td><?php echo $result['diaChi'] ?></td>
                                                <td><?php echo $result['ngaySinh'] ?></td>
                                                <td><?php echo $result['gioiTinh'] ?></td>
                                                <td>
                                                    <?php if ($result['trangThai'] == 0): ?>
                                                        <!-- Nếu trạng thái là 0 (đã bị khóa) -->
                                                        <span style="color: green;  padding-right: 3px;">Mở</span>
                                                        <a style="color: gray;" href="?banid=<?php echo $result['userId'] ?>">Khóa</a>
                                                    <?php else: ?>
                                                        <!-- Nếu trạng thái là 1 (đang mở) -->
                                                        <a style="color: green;" href="?unbanid=<?php echo $result['userId'] ?>">Mở</a>
                                                        <span style="color: red;">Khóa</span>
                                                    <?php endif ?>
                                                </td>
                                                <td>
                                                <?php 
                                                    // Kiểm tra và hiển thị trạng thái dưới dạng "Mở" hoặc "Khóa"
                                                    if ($result['trangThai'] == 0) {
                                                        echo "Mở";
                                                    } else {
                                                        echo "Khóa";
                                                    }
                                                ?>
                                                </td>
                                                
                                                <td>
                                                <a href="chinhsua.php?userId=<?php echo $result['userId']?>">Sửa</a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
               

            </main>
        </div>
    </body>
    </html>