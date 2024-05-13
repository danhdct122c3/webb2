<?php include './inc/handle.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/dangnhap.css">
    <link rel="stylesheet" href="assets/css/base.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/grid.css">
    <link rel="stylesheet" href="assets/font/themify-icons/themify-icons.css">
    <link rel="shortcut icon" href="assets/img/favicon_created_by_logaster.ico" type="image/x-icon">
    <title>Đăng ký tài khoản</title>
</head>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $insertProduct = $user->insert_user($_POST);
}
?>

<body>
    <!-- Phần header -->
    <?php include 'inc/header.php' ?>
    <div class="app">
        <div class="grid wide">
            <div class="app_content-all">
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
                                            <input type="text" name="name" class="auth__form-input" placeholder="Nhập họ và tên">
                                        </div>
                                        <div class="auth__form-group col c-6">
                                            <div class="auth__form-group-title">
                                                <span>Email</span>
                                                <span style="color: red;">*</span>
                                            </div>
                                            <input type="email" name="email" class="auth__form-input" placeholder="Nhập địa chỉ email">
                                        </div>
                                        <div class="auth__form-group col c-6">
                                            <div class="auth__form-group-title">
                                                <span>Số điện thoại</span>
                                                <span style="color: red;">*</span>
                                            </div>
                                            <input type="text" name="phone" class="auth__form-input" placeholder="Nhập số điện thoại">
                                        </div>
                                        
                                        <div class="auth__form-group col c-6">
                                            <div class="auth__form-group-title">
                                                <span>Ngày sinh</span>
                                                <span style="color: red;">*</span>
                                            </div>
                                            <input type="date" name="ngaySinh" class="auth__form-input" placeholder="Nhập ngày sinh">
                                        </div>
                                        <div class="auth__form-group col c-6">
                                            <span class="auth__form-group-title">
                                                <span>Thành Phố</span>
                                                <span style="color: red;">*</span>
                                            </span>
                                            <!-- <input type="text" name="city" class="auth__form-input" placeholder="Nhập Tỉnh/Thành Phố"> -->
                                            <select name="city" id="" class="auth__form-input">
                                                <option value="">Chọn tỉnh/thành phố</option>
                                                <option value="Hồ Chí Minh">Hồ Chí Minh</option>
                                                <option value="Hà Nội">Hà Nội</option>
                                                <option value="Đà Nẵng">Đà Nẵng</option>
                                                <option value="Hải Phòng">Hải Phòng</option>
                                                <option value="Huế">Huế</option>
                                            </select>

                                        </div>

                                        
                                        <div class="auth__form-group col c-6">
                                            <span class="auth__form-group-title">
                                                <span>Quận/Huyện </span>
                                                <span style="color: red;">*</span>
                                            </span>
                                            <!-- <input type="text" name="district" class="auth__form-input" placeholder="Nhập Quận/Huyện"> -->
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
                                            <span class="auth__form-group-title">
                                                <span>Phường/Xã</span>
                                                <span style="color: red;">*</span>
                                            </span>
                                            <!-- <input type="text" name="ward" class="auth__form-input" placeholder="Nhập Phường/Xã"> -->
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
                                    <input type="text" name="username" class="auth__form-input" placeholder="Nhập tên đăng nhập">
                                </div>
                                <div class="auth__form-group col c-12 ">
                                    <div class="auth__form-group-title">
                                        <span>Mật khẩu</span>
                                        <span style="color: red;">*</span>
                                    </div>
                                    <input type="password" name="password" class="auth__form-input" placeholder="Nhập mật khẩu">
                                </div>
                                <div class="auth__form-group col c-12 ">
                                    <div class="auth__form-group-title">
                                        <span>Nhập lại mật khẩu</span>
                                        <span style="color: red;">*</span>
                                    </div>
                                    <input type="password" name="relyPassword" class="auth__form-input" placeholder="Nhập lại mật khẩu">
                                </div>
                                
                            </div>
                            <div class="baoloi">
                                <?php
                                if (isset($insertProduct)) {
                                    echo $insertProduct;
                                }
                                ?>
                            </div>
                            <input type="submit" name="submit" value="Đăng ký" class="btn btn-login mt-16">
                            <div style="text-align: right ; padding: 15px 0;">
                                <a href="login.php" style="color: #221f20; font-size:1.5rem; font-family: var(--font-family-sans-serif);margin: 24px;text-decoration:underline; ">Đăng nhập</a>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?php include './inc/footer.php' ?>
    </div>
</body>

</html>