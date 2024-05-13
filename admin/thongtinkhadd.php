<?php 
session_start();
include '../classses/user.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href=".././assets/css/dangnhap.css">
    <link rel="stylesheet" href=".././assets/css/base.css">
    <link rel="stylesheet" href=".././assets/css/main.css">
    <link rel="stylesheet" href=".././assets/css/grid.css">
    <link rel="stylesheet" href="assets/css/thongtin.css">
    <link rel="stylesheet" href="assets/font/themify-icons/themify-icons.css">
    <link rel="shortcut icon" href="assets/img/favicon_created_by_logaster.ico" type="image/x-icon">
    <title>Đăng ký tài khoản</title>
</head>

<?php
    $user = new User(); 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $insertProduct = $user->insert_user($_POST);
    if ($insertProduct !== "Success") {
        echo '<div class="error-message">' . $insertProduct . '</div>';
    } else {
        // Nếu thành công, chuyển hướng người dùng đến trang chính
        header('Location: thongtinkh.php');
        exit;
    }
    
}

$name = isset($_POST['name']) ? $_POST['name'] : "";
$email = isset($_POST['email']) ? $_POST['email'] : "";
$phone = isset($_POST['phone']) ? $_POST['phone'] : "";

$ngaySinh = isset($_POST['ngaySinh']) ? $_POST['ngaySinh'] : "";
$street = isset($_POST['street']) ? $_POST['street'] : "";
$city = isset($_POST['city']) ? $_POST['city'] : "";
$district = isset($_POST['district']) ? $_POST['district'] : "";
$ward = isset($_POST['ward']) ? $_POST['ward'] : "";
$username = isset($_POST['username']) ? $_POST['username'] : "";
$password = isset($_POST['password']) ? $_POST['password'] : "";
$relyPassword = isset($_POST['relyPassword']) ? $_POST['relyPassword'] : "";
$category = isset($_POST['category']) ? $_POST['category'] : "";
$cauHoiBiMat= isset($_POST['cauHoiBiMat']) ? $_POST['cauHoiBiMat'] : "";
?>

<body>
    <?php include './inc/sidebar.php' ?>
    <div class="main-content">
            <?php include './inc/header.php' ?>
            <main>
                <div class="row">
                    <div class="auth__form-header">
                        <h2>ĐĂNG KÝ</h2>
                    </div>
                </div>
                <form action="" method="post" class="auth__form-form">

                    <div class="row">
                        <div class="col c-6">
                            <div class="auth__form">
                                <div class="auth__form-container">
                                    <div class="auth__form-container-title">Thông tin khách hàng</div>
                                    <div class="row">
                                        <div class="auth__form-group col c-6 ">
                                            <div class="auth__form-group-title">
                                                <span>Họ và tên</span>
                                                <span style="color: red;">*</span>
                                            </div>
                                            <input type="text" name="name" class="auth__form-input" placeholder="Nhập họ và tên"  value="<?php echo $name; ?>">
                                        </div>
                                        <div class="auth__form-group col c-6">
                                            <div class="auth__form-group-title">
                                                <span>Email</span>
                                                <span style="color: red;">*</span>
                                            </div>
                                            <input type="text" name="email" class="auth__form-input" placeholder="Nhập địa chỉ email"  value="<?php echo $email; ?>">
                                        </div>
                                        <div class="auth__form-group col c-6">
                                            <div class="auth__form-group-title">
                                                <span>Số điện thoại</span>
                                                <span style="color: red;">*</span>
                                            </div>
                                            <input type="text" name="phone" class="auth__form-input" placeholder="Nhập số điện thoại"  value="<?php echo $phone; ?>">
                                        </div>
                                       
                                        <div class="auth__form-group col c-6">
                                            <div class="auth__form-group-title">
                                                <span>Ngày sinh</span>
                                                <span style="color: red;">*</span>
                                            </div>
                                            <input type="date" name="ngaySinh" class="auth__form-input" placeholder="Nhập ngày sinh"  value="<?php  echo date('d/m/Y', strtotime($ngaysinh)); ?>">
                                        </div>
                                        <div class="auth__form-group col c-6">
                                            <div class="auth__form-group-title">
                                                <span>Thành phố</span>
                                                <span style="color: red;">*</span>
                                            </div>
                                            <select name="city" id="" class="auth__form-input">
                                                <option value="">Chọn tỉnh/thành phố</option>
                                                <option value="Hồ Chí Minh">Hồ Chí Minh</option>
                                                <option value="Hà Nội">Hà Nội</option>
                                                <option value="Đà Nẵng">Đà Nẵng</option>
                                                <option value="Hải Phòng">Hải Phòng</option>
                                                <option value="Huế">Huế</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        
                                       
                                        <div class="auth__form-group col c-6">
                                            <div class="auth__form-group-title">
                                                <span>Quận/ Huyện</span>
                                                <span style="color: red;">*</span>
                                            </div>
                                            <select name="district" id="" class="auth__form-input">
                                                <option value="">Chọn quận/huyện</option>
                                                <option value="Quận 1">Quận 1</option>
                                                <option value="Quận 3">Quận 3</option>
                                                <option value="Quận 5">Quận 5</option>
                                                <option value="Quận 10">Quận 10</option>
                                                <option value="Huyện Củ Chi">Huyện Củ Chi</option>
                                                <option value="Huyện Hóc Môn">Huyện Hóc Môn</option>
                                            </select>
                                        </div>
                                        <div class="auth__form-group col c-6">
                                            <div class="auth__form-group-title">
                                                <span>Phường/ Xã</span>
                                                <span style="color: red;">*</span>
                                            </div>
                                            <select name="ward" id="" class="auth__form-input">
                                                <option value="">Chọn phường/xã</option>
                                                <option value="Phường 1">Phường 1</option>
                                                <option value="Phường 3">Phường 3</option>
                                                <option value="Phường 10">Phường 10</option>
                                                <option value="Phường 15">Phường 1</option>
                                                <option value="Xã Tân Phú Trung">Xã Tân Phú Trung</option>
                                                <option value="Xã Bà Điểm">Xã Bà Điểm</option>
                                                <option value="Xã Phước Vĩnh An">Xã Phước Vĩnh An</option>
                                            </select>
                                        </div>
                                        <div class="auth__form-group col c-12">
                                            <span class="auth__form-group-title">
                                                <span>Tên đường</span>
                                                <span style="color: red;">*</span>
                                            </span>
                                            <!-- <input type="text" name="street" class="auth__form-input" placeholder="Nhập tên đường"> -->
                                            <select name="street" id="" class="auth__form-input">
                                                <option value="">Chọn đường</option>
                                                <option value="Trường Chinh">Trường Chinh</option>
                                                <option value="An Dương Vương">An Dương Vương</option>
                                                <option value="Âu Cơ">Âu Cơ</option>
                                                <option value="Lý Thường Kiệt">Lý Thường Kiệt</option>
                                                <option value="Thành Thái">Thành Thái</option>
                                                <option value="Kinh Dương Vương">Kinh Dương Vương</option>
                                            </select>
                                            
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="auth__form-group col c-12">
                                            <div class="auth__form-group-title">
                                                <span>Địa chỉ</span>
                                                <span style="color: red;">*</span>
                                            </div>
                                            <textarea name="address" id="" cols="10" rows="10"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col c-6">
                            <div class="auth__form-container-title">Thông tin đăng ký</div>
                            <div class="row">
                                <div class="auth__form-group col c-12 ">
                                    <div class="auth__form-group-title">
                                        <span>Tên đăng nhập</span>
                                        <span style="color: red;">*</span>
                                    </div>
                                    <input type="text" name="username" class="auth__form-input" placeholder="Nhập tên đăng nhập"  value="<?php echo $username; ?>">
                                </div>
                                <div class="auth__form-group col c-12 ">
                                    <div class="auth__form-group-title">
                                        <span>Mật khẩu</span>
                                        <span style="color: red;">*</span>
                                    </div>
                                    <input type="password" name="password" class="auth__form-input" placeholder="Nhập mật khẩu"  value="<?php echo $password; ?>">
                                </div>
                                <div class="auth__form-group col c-12 ">
                                    <div class="auth__form-group-title">
                                        <span>Nhập lại mật khẩu</span>
                                        <span style="color: red;">*</span>
                                    </div>
                                    <input type="password" name="relyPassword" class="auth__form-input" placeholder="Nhập lại mật khẩu"  value="<?php echo $relyPassword; ?>">
                                </div>
                                
                            </div>
                            <div class="baoloi">
                                <?php
                                if (isset($insertProduct)) {
                                    echo $insertProduct;
                                }
                                
                                ?>
                            </div>
                            <input type="submit" name="submit" value="Thêm khách hàng" class="btn btn-login mt-16">
                            

                        </div>
                    </div>
                </form>
            </main>
        </div>
        
</body>

<script src=".././assets/js/dangnhap.js"></script>

</html>