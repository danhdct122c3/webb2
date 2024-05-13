<?php
    
    include '.././classses/user.php';
    $user = new user();
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="stylesheet" href="assets/css/grid.css">
        <link rel="stylesheet" href="../assets/css/account.css">
        <link rel="stylesheet" href="assets/css/main.css">
        <link rel="stylesheet" href="assets/css/dangnhap.css">
        <link rel="shortcut icon" href="assets/img/favicon_created_by_logaster.ico" type="image/x-icon">
        <link rel="stylesheet" href="https://pro.fontawesome.com/rel    eases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
        <link rel="stylesheet" href="assets/font/themify-icons/themify-icons.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Thông tin tài khoản </title>
    </head>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
        session_start();
        if(isset($_SESSION['user_id'])) {
            $idUser = $_SESSION['user_id'];
            $update_user = $user->update_user($idUser, $_POST);
        } else {
            // Handle the case when user_id is not set in the session
            // For example, redirect the user to the login page
            header("Location: login.php");
            exit; // Stop further execution
        }
    }
    function checkAddress($address,$value)
    {
        if($address == $value)
        {
            echo "selected";
        }
    }
    ?>


    <body>
    <?php include './inc/sidebar.php' ?>
    <div class="main-content">
            <?php include './inc/header.php' ?>
        <div class="content">
        
            <div class="grid wide" style="border-top: 1px solid #ccc; padding-top:3rem;">
                <div class="account-body">
                    <div class="row">
                        
                        <div class="col m-12 l-13">
                            <div class="account-me">
                                <div class="row">
                                    <div class="col l-13 m-12 underline">
                                        <div class="account-tt">
                                            <span class="account-title">Thông tin cá nhân</span>
                                        </div>
                                        
                                        <form action="" method="post">
                                            <?php
                                            $userId = isset($_GET['userId']) ? $_GET['userId'] : Session::get('user_id');
                                            $infor_user = $user->show_User($userId);
                                            while ($result_infor_user = $infor_user->fetch_assoc()) {
                                            ?>
                                                <div class="information">
                                                    <div class="information-name">
                                                        <label>Họ & Tên</label>
                                                        <input type="text" name="name" value="<?php echo $result_infor_user['name'] ?>" >
                                                    </div>
                                                    <div class="information-name">
                                                        <label>Số điện thoại</label>
                                                        <input type="text" name="phone" value="<?php echo $result_infor_user['sdt'] ?>" >
                                                    </div> 
                                                    <div class="information-name">
                                                        <label>Email</label>
                                                        <input type="text" name="email" value="<?php echo $result_infor_user['email'] ?>" >
                                                    </div>
                                                    <div class="information-name">
                                                        <label>Ngày sinh</label>
                                                        <input type="text" name="date" value="<?php echo date('d/m/Y', strtotime($result_infor_user['ngaySinh'])); ?>" >

                                                    </div>
                                                    <div class="information-name">
                                                        <div class="auth__form-group col c-6" style="margin-left: -11px;">
                                                            <div class="auth__form-group-title">
                                                                <span>Tên đường</span>
                                                        
                                                            </div>
                                                            <select name="street" id="" class="auth__form-input">
                                                            <option value="">Chọn đường</option>
                                                            <option value="Trường Chinh" <?php checkAddress('Trường Chinh', $result_infor_user['street'] ) ?>>Trường Chinh</option>
                                                            <option value="An Dương Vương"<?php checkAddress('An Dương Vương', $result_infor_user['street'] ) ?>>An Dương Vương</option>
                                                            <option value="Âu Cơ"<?php checkAddress('Âu Cơ', $result_infor_user['street'] ) ?>>Âu Cơ</option>
                                                            <option value="Lý Thường Kiệt"<?php checkAddress('Lý Thường Kiệt', $result_infor_user['street'] ) ?>>Lý Thường Kiệt</option>
                                                            <option value="Thành Thái"<?php checkAddress('Thành Thái', $result_infor_user['street'] ) ?>>Thành Thái</option>
                                                            <option value="Kinh Dương Vương"<?php checkAddress('Kinh Dương Vương', $result_infor_user['street'] ) ?>>Kinh Dương Vương</option>
                                                        </select>
                                                        </div>
                                                        <div class="auth__form-group col c-6">
                                                            <div class="information-name">
                                                                <span>Thành phố</span>

                                                            </div>
                                                            <select name="city" id="" class="auth__form-input" style="margin-top:-0.1rem;">
                                                                <option value="" selected disabled>Chọn tỉnh/thành phố</option>
                                                                <option value="Hồ Chí Minh"<?php checkAddress('Hồ Chí Minh',$result_infor_user['city'] ); ?>>Hồ Chí Minh</option>
                                                                <option value="Hà Nội"<?php checkAddress('Hà Nội', $result_infor_user['city'] ); ?>>Hà Nội</option>
                                                                <option value="Đà Nẵng"<?php checkAddress('Đà Nẵng', $result_infor_user['city'] ); ?>>Đà Nẵng</option>
                                                                <option value="Hải Phòng"<?php checkAddress('Hải Phòng', $result_infor_user['city'] ) ;?>>Hải Phòng</option>
                                                                <option value="Huế" <?php checkAddress('Huế', $result_infor_user['city'] ); ?>>Huế</option>
                                                            </select>
                                                            
                                                            
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="information-name">
                                                        <div class="auth__form-group col c-6" style="margin-left:-0.7rem;">
                                                            <div class="auth__form-group-title">
                                                                <span>Quận huyện</span>
                                                            </div>
                                                            <select name="district" id="" class="auth__form-input">
                                                            <option value="">Chọn quận/huyện</option>
                                                            <option value="Quận 1" <?php checkAddress('Quận 1', $result_infor_user['district'] ) ?>>Quận 1</option>
                                                            <option value="Quận 3"<?php checkAddress('Quận 3', $result_infor_user['district'] ) ?>>Quận 3</option>
                                                            <option value="Quận 5"<?php checkAddress('Quận 5', $result_infor_user['district'] ) ?>>Quận 5</option>
                                                            <option value="Quận 10"<?php checkAddress('Quận 10', $result_infor_user['district'] ) ?>>Quận 10</option>
                                                            <option value="Huyện Củ Chi"<?php checkAddress('Huyện Củ Chi', $result_infor_user['district'] ) ?>>Huyện Củ Chi</option>
                                                            <option value="Huyện Hóc Môn"<?php checkAddress('Huyện Hóc Môn', $result_infor_user['district'] ) ?>>Huyện Hóc Môn</option>
                                                        </select>                            
                                                        </div>
                                                        <div class="auth__form-group col c-6">
                                                            <div class="auth__form-group-title">
                                                                <span>Phường/ Xã</span>
                                                            </div>
                                                            
                                                            <select name="ward" id="" class="auth__form-input">
                                                            <option value="">Chọn phường/xã</option>
                                                            <option value="Phường 1" <?php checkAddress('Phường 1', $result_infor_user['ward'] ) ?>>Phường 1</option>
                                                            <option value="Phường 3" <?php checkAddress('Phường 3', $result_infor_user['ward'] ) ?>>Phường 3</option>
                                                            <option value="Phường 10"<?php checkAddress('Phường 10', $result_infor_user['ward'] ) ?>>Phường 10</option>
                                                            <option value="Phường 15"<?php checkAddress('Phường 15', $result_infor_user['ward'] ) ?>>Phường 1</option>
                                                            <option value="Xã Tân Phú Trung"<?php checkAddress('Xã Tân Phú Trung', $result_infor_user['ward'] ) ?>>Xã Tân Phú Trung</option>
                                                            <option value="Xã Bà Điểm"<?php checkAddress('Xã Bà Điểm', $result_infor_user['ward'] ) ?>>Xã Bà Điểm</option>
                                                            <option value="Xã Phước Vĩnh An"<?php checkAddress('Xã Phước Vĩnh An', $result_infor_user['ward'] ) ?>>Xã Phước Vĩnh An</option>
                                                        </select>                                                                                                                       
                                                            </div>
                                                    </div>
                                                    <div class="auth__form-group col c-6" style="margin-left:-0.7rem;">
                                                            <div class="auth__form-group-title">
                                                                <span>Số nhà</span>
                                                            </div>
                                                            <input type="text" style="width:71.5rem;height: 2.5rem;border: 1px solid #E7E8E9;border-radius: 4px;">
                                                    </div>
                                                    
                                                        <div style="text-align: center;margin: 15px;">
                                                            <?php
                                                            if (isset($update_user)) {
                                                                echo $update_user;
                                                            }
                                                            ?>
                                                        </div>

                                                        <div class="infotmation-save">
                                                            <input type="submit" name="save" value="Lưu thay đổi">
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                        </form>  
                                            <?php
                                            if(isset($_GET['userId'])) {
                                                $userId = $_GET['userId'];
                                            } else { 
                                                echo "Người dùng không được xác định";
                                            }
                                            ?>                                      
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
           const citySelect = document.getElementById('city');
            const districtSelect = document.getElementById('district');
            const wardSelect = document.getElementById('ward');

            const cities = {
                'Hồ Chí Minh': ['Quận 1', 'Quận 2', 'Quận 7'],
                'Đà Nẵng': ['Quận Sơn Trà', 'Quận Cẩm Lệ'],
            };

            const wardsByDistrict = {
                'Quận 1': ['Phường 4', 'Phường Bến Nghé', 'Phường Cô Giang'],
                'Quận 2': ['Phường 7', 'Phường Thảo Điền', 'Phường An Phú'],
                'Quận 7': ['Phường Phú Mỹ', 'Phường Tân Phú', 'Phường Tân Quy'],
                'Quận Sơn Trà' : ['Phường Phước Mỹ', 'Phường Thọ Quang'],
                'Quận Cẩm Lệ' : ['Phường Hòa An', 'Phường Hòa Xuân']
            };

            // Tạo các option cho dropdown thành phố
            // Tạo các option cho dropdown thành phố
            Object.keys(cities).forEach(function(city) {
                const optionElem = document.createElement('option');
                optionElem.textContent = city;
                optionElem.value = city;
                citySelect.appendChild(optionElem);
            });

            // Xử lý sự kiện khi chọn thành phố
            citySelect.addEventListener("change", function() {
                const selectedCity = this.value;
                const districts = cities[selectedCity];
                populateDropdown(districtSelect, districts);
                populateWardOptions(selectedCity); // Tự động điền các tùy chọn cho phường
            });

            // Xử lý sự kiện khi chọn quận
            districtSelect.addEventListener('change', function() {
                const selectedDistrict = this.value;
                if (selectedDistrict) {
                    const wards = wardsByDistrict[selectedDistrict];
                    populateDropdown(wardSelect, wards);
                } else {
                    clearDropdown(wardSelect);
                }
            });

            // Hàm để điền các tùy chọn vào dropdown phường
            function populateDropdown(select, options) {
                select.innerHTML = '';
                options.forEach(function(option) {
                    const optionElem = document.createElement('option');
                    optionElem.textContent = option;
                    optionElem.value = option;
                    select.appendChild(optionElem);
                });
            }

            // Hàm để xóa tất cả các tùy chọn trong dropdown
            function clearDropdown(select) {
                // Lưu trữ các tùy chọn mặc định
                const defaultOption = select.options[0];
                select.innerHTML = '';
                // Thêm lại các tùy chọn mặc định
                select.appendChild(defaultOption);
            }

            // Populate wards based on the selected city
            function populateWardOptions(selectedCity) {
                const districts = cities[selectedCity];
                const wards = wardsByDistrict[districts[0]];
                populateDropdown(wardSelect, wards);
            }
        });

    </script>
    </body>

    </html>