<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../lib/database.php');
include_once($filepath . '/../helpers/format.php');
?>
<?php
class user
{
    private $db;
    private $fm;

    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();

    }
    
    // thêm user vào DB
    public function insert_user($data) 
    {
        // kết nối với cơ sở dữ liệu
        $username = mysqli_real_escape_string($this->db->link, $data["username"]);
        $password = mysqli_real_escape_string($this->db->link, md5($data["password"]));
        // $password = mysqli_real_escape_string($this->db->link, md5($data["password"]));
        // $relyPassword = mysqli_real_escape_string($this->db->link, md5($data["relyPassword"]));
        $relyPassword = mysqli_real_escape_string($this->db->link, md5($data["relyPassword"]));
        $name = mysqli_real_escape_string($this->db->link, $data["name"]);
        $email = mysqli_real_escape_string($this->db->link, $data["email"]);
        $phone = mysqli_real_escape_string($this->db->link, $data["phone"]);
        $gender = isset($_POST['sex']) ? mysqli_real_escape_string($this->db->link, $data["sex"]) : "";
        $ngaySinh = isset($_POST['ngaySinh']) ? mysqli_real_escape_string($this->db->link, $data["ngaySinh"]): "";
        $street = mysqli_real_escape_string($this->db->link, $data["street"]);
        $address = mysqli_real_escape_string($this->db->link, $data["address"]);
        $ward = isset($_POST['ward']) ? mysqli_real_escape_string($this->db->link, $data["ward"]) : "";
        $district = isset($_POST['district']) ? mysqli_real_escape_string($this->db->link, $data["district"]) : "";
        $city = isset($_POST['city']) ? mysqli_real_escape_string($this->db->link, $data["city"]) : "";
        $cauHoiBiMat = mysqli_real_escape_string($this->db->link, $data["cauHoiBiMat"]);
        $trangThai = 0;
        
    
        if (
            $username == "" ||  $password == "" ||  $relyPassword == "" ||  $name == "" ||  $email == ""
            ||  $phone == ""||  $ngaySinh == "" || $street == "" || $ward == "" || $district == "" || $city == "" || $cauHoiBiMat == "" 
        ) {
            // $alert = "<span class='error'>Nhập đầy đủ thông tin</span>";
           
            return var_dump($username, $password, $relyPassword, $name, $email, $phone, $gender, $ngaySinh, $street, $ward, $district, $city, $cauHoiBiMat);;
        } else {
            if ($password != $relyPassword) {
                $alert = "<span class='error'> Mật khẩu nhập lại không trùng khớp </span>";
                return $alert;
            } else {
                $check_username = "SELECT * FROM tbl_uer WHERE username='$username' AND email='$email'  LIMIT 1";
                $result_check = $this->db->select($check_username);
                if ($result_check) {
                    $alert = "<span class='error'> Tên đăng nhập của bạn đã tồn tại </span>";
                    return $alert;
                } else {
                    $check_email = "SELECT * FROM tbl_uer WHERE email='$email'  LIMIT 1";
                    $result_mail = $this->db->select($check_email);
                    if ($result_mail) {
                        $alert = "<span class='error'> Email của bạn đã được đăng ký </span>";
                        return $alert;
                    } else {
                        $query = "INSERT INTO tbl_uer(name,username,userPassword,email,gioiTinh,sdt,ngaySinh,diaChi,street,ward,district,city,cauHoiBM,trangThai) VALUES('$name','$username','$password'
                        ,'$email','$gender','$phone','$ngaySinh','$address','$street','$ward','$district','$city','$cauHoiBiMat','$trangThai')";
                        $result = $this->db->insert($query);
                        if ($result) {
                            $alert = "<span class='success'> Đăng ký thành công  </span>";
                            return $alert;
                        } else {
                            $alert = "<span class='error'> Đăng ký thất bại  </span>";
                            return $alert;
                        }
                    }
                }
            }
        }
    }

    // đăng nhập
    public function login_user($data)
    {
        $username = mysqli_real_escape_string($this->db->link, $data["username"]);
        $password = mysqli_real_escape_string($this->db->link, md5($data["password"]));
        if ($username == "" ||  $password == "") {
            $alert = "<span class='error'>Nhập đầy đủ thông tin</span>";
            return $alert;
        } else {
            $check_username = "SELECT * FROM tbl_uer WHERE username='$username' AND userPassword='$password' ";
            $result = $this->db->select($check_username);
            if ($result) {
                $value = $result->fetch_assoc();
                if ($value['trangThai'] == 1) {
                    // Nếu tài khoản đã bị cấm, hiển thị thông báo và ngăn họ đăng nhập
                    $alert = "<span class='error'>Tài khoản của bạn đã bị khóa</span>";
                    return $alert;
                } else {
                // người dùng đã đăng nhập thành công 
                Session::set('user_login', true);
                Session::set('user_id', $value['userId']);
                Session::set('user_name', $value['name']);
                header('Location:index.php');
                exit();
                }
            } else {
                $alert = "<span class='error'>Tên đăng nhập hoặc mật khẩu không đúng</span>";
                return $alert;
            }
        }
    }

    //Khóa người dùng
public function ban_user($user_Id) {
    $trangThai = 1; // Cập nhật trạng thái thành 1 khi khóa
    
    $query = "UPDATE tbl_uer SET trangThai='$trangThai' WHERE userId='$user_Id'";
    $result_check = $this->db->update($query);
    if ($result_check) {
        $alert = "<span class='success'>Khách hàng đã bị khóa thành công</span>";
        return $alert;
    } else {
        $alert = "<span class='error'>Có lỗi xảy ra khi khóa khách hàng</span>";
        return $alert;
    }
}

//Mở khóa người dùng
public function unban_user($user_Id) {
    $trangThai = 0; // Cập nhật trạng thái thành 0 khi mở khóa
    
    $query = "UPDATE tbl_uer SET trangThai='$trangThai' WHERE userId='$user_Id'";
    $result_check = $this->db->update($query);
    if ($result_check) {
        $alert = "<span class='success'>Khách hàng đã được mở khóa thành công</span>";
        return $alert;
    } else {
        $alert = "<span class='error'>Có lỗi xảy ra khi mở khóa khách hàng</span>";
        return $alert;
    }
}

    public function show_User ($userId)
    {
        $query = "SELECT*  FROM tbl_uer WHERE userId = '$userId'";
        $result = $this->db->select($query);
        return $result;
    }
    // hiển thị khách hàng trong admin
        public function showKHAdmin()
        {
            $query = "SELECT us.* , CONCAT(us.street, ', ', us.ward, ', ', us.district, ', ', us.city) AS diaChi 
              FROM tbl_uer AS us
              LEFT JOIN tbl_order AS od ON us.userId = od.userId
              GROUP BY us.userId
              ORDER BY us.userId";
    $result = $this->db->select($query);
    return $result;
        }
    
    public function showthongkeAdmin()
    {
        $query = "SELECT us.* , SUM(od.thanhtien) AS sumTT, CONCAT(us.street, ', ', us.ward, ', ', us.district, ', ', us.city) AS diaChi
        FROM tbl_uer AS us 
        LEFT JOIN tbl_order AS od ON us.userId =od.userId
        GROUP BY us.userId
        ORDER BY us.userId";
        $result = $this->db->select($query);
        return $result;
    }

    public function addressString($street, $ward, $district, $city) {
        return $street . ', ' . $ward . ', ' . $district . ', ' . $city;
    }
    

    public function showCauHoiBiMat($username, $cauHoiBiMat)
    {
        $cauHoiBiMat = mysqli_real_escape_string($this->db->link, $cauHoiBiMat);
        $username = mysqli_real_escape_string($this->db->link, $username);
        if ($cauHoiBiMat == "" || $username == "") {
            $alert = "<span class='error'>Bạn chưa nhập câu hỏi</span>";
            return $alert;
        } else {
            $update_user = "SELECT * FROM tbl_uer WHERE username='$username' AND cauHoiBM='$cauHoiBiMat'";
            $result_check = $this->db->select($update_user);
            if ($result_check) {
                header('Location:nhapLaiMK.php');
            }
        }
    }
    public function updatePass($data)
    {
        // kết nối với cơ sở dữ liệu
        $password = mysqli_real_escape_string($this->db->link, md5($data["passWord"]));
        $relyPassword = mysqli_real_escape_string($this->db->link, md5($data["RelypassWord"]));
        if ($password == "" ||  $relyPassword == "") {
            $alert = "<span class='error'>Nhập đầy đủ thông tin</span>";
            return $alert;
        } else {
            if ($password != $relyPassword) {
                $alert = "<span class='success'> Mật khẩu nhập lại không trùng khớp </span>";
                return $alert;
            } else {
                $update_user = "UPDATE tbl_uer SET userPassword='$password'";
                $result_check = $this->db->update($update_user);
                if ($result_check) {
                    $alert = "<span class='success'> Update Successfully </span>";
                    return $alert;
                } else {
                    $alert = "<span class='error'> Update Fail  </span>";
                    return $alert;
                }
            }
        }
    }
    public function update_user($user_Id, $data)
    {
        // kết nối với cơ sở dữ liệu
        $name = mysqli_real_escape_string($this->db->link, $data["name"]);
        $email = mysqli_real_escape_string($this->db->link, $data["email"]);
        $phone = mysqli_real_escape_string($this->db->link, $data["phone"]);
        $sex = isset($_POST['sex']) ? mysqli_real_escape_string($this->db->link, $data["sex"]) : "";
        $ngaySinh = mysqli_real_escape_string($this->db->link, $data["ngaySinh"]);
        $street = mysqli_real_escape_string($this->db->link, $data["street"]);
        $ward = isset($_POST['ward']) ? mysqli_real_escape_string($this->db->link, $data["ward"]) : "";
        $district = isset($_POST['district']) ? mysqli_real_escape_string($this->db->link, $data["district"]) : "";
        $city = isset($_POST['city']) ? mysqli_real_escape_string($this->db->link, $data["city"]) : "";
        

        if ($name == "" ||  $email == "" ||  $phone == "" ||  $sex == "" ||  $ngaySinh == "" || $street == "" || $ward == "" || $district =="" || $city == "" 
        ) {
            $alert = "<span class='error'>Nhập đầy đủ thông tin</span>";
            return $alert;
        } else {
            $update_user = "UPDATE tbl_uer SET name='$name', email='$email', sdt='$phone', gioiTinh='$sex', ngaySinh='$ngaySinh', street='$street', ward='$ward', district='$district', city='$city'
            WHERE userId='$user_Id'";
            $result_check = $this->db->update($update_user);
            if ($result_check) {
                $alert = "<span class='success'> Update Successfully </span>";
                return $alert;
            } else {
                $alert = "<span class='error'> Update Fail  </span>";
                return $alert;
            }
        }
    }
    //doi mat khau
    public function doimatkhau($taikhoan, $matkhaucu)
    {
        $taikhoan = $_POST['username'];
        $matkhaucu = md5($_POST['password_cu']);
        $sql = "SELECT * FROM tbl_uer WHERE username= '$taikhoan' AND userPassword = '$matkhaucu'";
        $result = $this->db->select($sql);
        return $result;
    }
    //update mat khau
    public function updatedoimatkhau($matkhaumoi)
    {
        $matkhaumoi = md5($_POST['password_moi']);

        $sql_update = $this->db->update("UPDATE tbl_uer SET userPassword= '$matkhaumoi' ");

        if ($sql_update == true) {
            $alert = '<span class="Update_pass">Đổi mật khẩu thành công !</span>';
            return $alert;
        }
    }
}
?>