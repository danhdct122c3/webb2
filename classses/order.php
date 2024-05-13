<?php
    $filepath = realpath(dirname(__FILE__));
    include_once($filepath.'/../lib/database.php');
    include_once($filepath.'/../helpers/format.php');
?>
<?php
    class order
    {
        private $db;
        private $fm;

        public function __construct()
        {
            $this->db = new Database();
            $this->fm = new Format();
        }
        /*chèn data vào bảng tbl_order*/
        public function insertOder($userId, $date, $payment_method,$city,$district,$ward,$address)
        {
            $sId = session_id();
            $query = "SELECT * FROM tbl_cart WHERE sessionId = '$sId' AND userId='$userId'";
            $getProduct = $this->db->select($query);
            if ($getProduct) {
                while ($result = $getProduct->fetch_assoc()) {
                    $productId = $result['productId'];
                    $size = $result['size'];
                    $price = $result['price'];
                    $image = $result['image'];
                    $quantity = $result['quantity'];
                    $thanhtien = $result['quantity'] * $result['price'];
                    $order_time = $date;
                    $query_order = "INSERT INTO tbl_order(productId,size,price,image,quantity,thanhtien,userId, status,order_time,recieve_time,payment,city,ward,district,address) VALUES('$productId',
                        '$size','$price','$image','$quantity','$thanhtien','$userId','0','$order_time','0','$payment_method','$city','$district','$ward','$address')";
                     $insert_order = $this->db->insert($query_order);
                }
                return $insert_order;
              
            }
        }
//         public function insertOder($userId, $date, $payment_method)
// {
//     $sId = session_id();
//     $query = "SELECT * FROM tbl_cart WHERE sessionId = '$sId' AND userId='$userId'";
//     $getProduct = $this->db->select($query);
    
//     if ($getProduct && $getProduct->num_rows > 0) {
//         // Tạo một mảng để lưu trữ thông tin về các sản phẩm
//         $products = array();

//         // Lặp qua các sản phẩm trong giỏ hàng và thêm chúng vào mảng
//         while ($result = $getProduct->fetch_assoc()) {
//             $productId = $result['productId'];
//             $size = $result['size'];
//             $price = $result['price'];
//             $image = $result['image'];
//             $quantity = $result['quantity'];
//             $thanhtien = $result['quantity'] * $result['price'];

//             // Thêm thông tin của sản phẩm vào mảng
//             $products[] = array(
//                 'productId' => $productId,
//                 'size' => $size,
//                 'price' => $price,
//                 'image' => $image,
//                 'quantity' => $quantity,
//                 'thanhtien' => $thanhtien
//             );
//         }

//         // Tạo đơn hàng
//         $order_time = $date;
//         $query_order = "INSERT INTO tbl_order(productId,size,price,image,quantity,thanhtien,userId, status,order_time,recieve_time,payment) VALUES";

//         foreach ($products as $product) {
//             $query_order .= "('" . $product['productId'] . "', '" . $product['size'] . "', '" . $product['price'] . "', '" . $product['image'] . "', '" . $product['quantity'] . "', '" . $product['thanhtien'] . "', '$userId', '0', '$order_time', '0', '$payment_method'),";
//         }

//         // Xóa dấu ',' cuối cùng trong câu lệnh SQL
//         $query_order = rtrim($query_order, ',');

//         // Thực hiện câu lệnh SQL
//         $insert_order = $this->db->insert($query_order);

//         return $insert_order;
//     }

//     return false; // Trả về false nếu không có sản phẩm nào trong giỏ hàng
// }
        
        // hiển thị  sản phẩm ra trang lich su
        public function getOrderHistory($userId,$status,$date){
            $query = "SELECT od.* , pd.productName 
            FROM tbl_order AS od
            INNER JOIN tbl_product AS pd ON od.productId =pd.productId
            WHERE userId='$userId' AND status IN $status AND od.order_time='$date'";
            $result = $this->db->select($query);
            return $result;
         }
        public function getOrderHistory1($userId,$date){
            $query = "SELECT od.* , pd.productName 
            FROM tbl_order AS od
            INNER JOIN tbl_product AS pd ON od.productId =pd.productId
            WHERE userId='$userId' AND od.order_time='$date'";
            $result = $this->db->select($query);
            return $result;
         }
         // update status
         public function update_Status_Order($orderId,$status,$userId){
            $query= "UPDATE tbl_order SET status = '$status' WHERE orderId IN $orderId AND userId='$userId'";
            $result = $this->db->update($query);
         }
         public function recieve_Order($orderId,$status,$userId,$date_current){
            $query= "UPDATE tbl_order SET status = '$status', recieve_time = '$date_current' WHERE orderId IN $orderId AND userId='$userId'";
            $result = $this->db->update($query);
            return $result;

         }
         // tải data tbl_order lên trang admin
         public function admin_getOrder($status){
            $query = "SELECT DISTINCT username,name, od.userId
            FROM tbl_order AS od
            INNER JOIN tbl_uer AS us ON od.userId =us.userId
            WHERE od.status IN $status";
            $result = $this->db->select($query);
            return $result;
         }

         // hiển thị  sản phẩm ra trang admin
        public function admin_getOrder_waiting($userId,$status,$date){
            $query = "SELECT od.* , pd.productName ,username,us.userId , name,us.diaChi,us.name,pd.brandId,pd.typeProductId
            FROM tbl_order AS od
            INNER JOIN tbl_product AS pd ON od.productId =pd.productId
            INNER JOIN tbl_uer AS us ON od.userId =us.userId
            WHERE od.userId='$userId' AND status IN $status AND od.order_time='$date'";
            $result = $this->db->select($query);
            return $result;
         }

         public function order_date($userId,$status){
            $query = "SELECT od.*,SUM(thanhtien) AS value_sumTT
            FROM tbl_order AS od
            INNER JOIN tbl_product AS pd ON od.productId =pd.productId
            INNER JOIN tbl_uer AS us ON od.userId =us.userId
            WHERE od.userId='$userId' AND status IN $status
            GROUP BY od.order_time ";
            $result = $this->db->select($query);
            return $result;
         }
         public function order_date1($userId){
            // $query = "SELECT od.order_time ,od.recieve_time
            $query = "SELECT  od.*,SUM(thanhtien) AS value_sumTT, us.*

            FROM tbl_order AS od
            INNER JOIN tbl_product AS pd ON od.productId =pd.productId
            INNER JOIN tbl_uer AS us ON od.userId =us.userId
            WHERE od.userId='$userId'
            GROUP BY od.order_time ";
            $result = $this->db->select($query);
            return $result;
         }

         // update số lượng khi admin xác nhận đơn hàng
         public function admin_confirm_order($orderId, $userId,$type){

            if($type==1){
                $sql = "SELECT productId , quantity
                FROM tbl_order 
                WHERE userId='$userId' AND status='1' AND orderId = '$orderId'";
                $result_SQL = $this->db->select($sql);

                if($result_SQL)
                    while($product= $result_SQL->fetch_assoc()){
                        $productId=$product['productId'];
                        $quantity = $product['quantity'];
                        $query= "UPDATE tbl_product SET quantity = quantity -'$quantity'   WHERE productId = '$productId'";
                        $result = $this->db->update($query);
                    }
                }else{
                    $sql = "SELECT productId , quantity
                    FROM tbl_order 
                    WHERE userId='$userId' AND status='4' AND orderId = '$orderId'";
                    $result_SQL = $this->db->select($sql);

                    if($result_SQL)
                        while($product= $result_SQL->fetch_assoc()){
                            $productId=$product['productId'];
                            $quantity = $product['quantity'];
                            echo $productId;
                            $query= "UPDATE tbl_product SET quantity = quantity +'$quantity'   WHERE productId = '$productId'";
                            $result = $this->db->update($query);
                        }
                }
            
         }
    }
?>