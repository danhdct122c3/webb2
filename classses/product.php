<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../lib/database.php');
include_once($filepath . '/../helpers/format.php');
?>
<?php
class product
{
    private $db;
    private $fm;

    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }
    public function insert_product($data, $files)
    {
        // kết nối với cơ sở dữ liệu
        $productName = mysqli_real_escape_string($this->db->link, $data["productName"]);
        $category = mysqli_real_escape_string($this->db->link, $data["category"]);
        $typeProduct = mysqli_real_escape_string($this->db->link, $data["typeProduct"]);
        $brand = mysqli_real_escape_string($this->db->link, $data["brand"]);
        $product_desc = mysqli_real_escape_string($this->db->link, $data["product_desc"]);
        $price = mysqli_real_escape_string($this->db->link, $data["price"]);
       
        $quantity = mysqli_real_escape_string($this->db->link, $data["productQuantity"]);

        //kiểm tra hình ảnh và lấy hình ảnh cho vào folder uploads
        $permited = array('jpg', 'jpeg', 'png', 'gif');
        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_temp = $_FILES['image']["tmp_name"];

        $div = explode('.', $file_name);
        $file_ext = strtolower(end($div));
        $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
        $uploaded_image = "upload/" . $unique_image;
        if ($productName == "" ||  $brand == "" || $typeProduct == "" ||  $category == "" ||  $product_desc == "" ||  $price == ""  ||  $file_name == "" || $quantity == "") {
            $alert = "Không được bỏ trống";
            return $alert;
        } elseif($quantity < 0){
            return "Số lượng không được âm";
        }elseif($price <0){
            return "Giá không được âm";
        }else{
            $sql_check_name = "SELECT * FROM tbl_product WHERE productName = '$productName'";
            $result_check_name = $this->db->select($sql_check_name);
            if($result_check_name){
                return "Tên sản phẩm đã tồn tại";
            }else{
                move_uploaded_file($file_temp, $uploaded_image);
                $query = "INSERT INTO tbl_product(productName,brandId,catId,product_desc,price,quantity,image,typeProductId) VALUES('$productName',
                    '$brand','$category','$product_desc','$price','$quantity','$unique_image','$typeProduct')";
                $result = $this->db->insert($query);
                if ($result) {
                    $alert = "<span class='success'> Thêm thành công  </span>";
                    return $alert;
                } else {
                    $alert = "<span class='error'> Thêm không thành công  </span>";
                    return $alert;
                }
            }
        }
    }

    // public function show_product()
    // {
    //     $query = "SELECT pd.*, cat.catName, br.brandName, tpd.typeProductName, od.productId AS orderProductId
    //                 FROM tbl_product AS pd 
    //                 INNER JOIN category AS cat ON pd.catId = cat.catId   
    //                 INNER JOIN tbl_brand AS br ON pd.brandId = br.brandId
    //                 INNER JOIN tbl_type_product AS tpd ON pd.typeProductId = tpd.typeProductID
    //                 INNER JOIN tbl_order AS od ON pd.productId = od.productId
    //                 ORDER BY pd.productId DESC";
    //     $result = $this->db->select($query);
    //     return $result;
    // }

    public function show_product()
{
    $query = "SELECT pd.*, cat.catName, br.brandName, tpd.typeProductName, 
              SUM(od.quantity) AS total_sold,od.status 
             
              FROM tbl_product AS pd
              INNER JOIN category AS cat ON pd.catId = cat.catId
              INNER JOIN tbl_brand AS br ON pd.brandId = br.brandId
              INNER JOIN tbl_type_product AS tpd ON pd.typeProductId = tpd.typeProductID
              LEFT JOIN tbl_order AS od ON pd.productId = od.productId
              WHERE pd.status_product=0
              GROUP BY pd.productId
              ORDER BY pd.productId DESC";

    $result = $this->db->select($query);
    return $result;
}
public function show_product1()
{
    $query = "SELECT pd.*, cat.catName, br.brandName, tpd.typeProductName, 
              SUM(od.quantity) AS total_sold,od.status 
            --   CASE WHEN od.status = '2' THEN 'Đã bán' ELSE 'Chưa bán' END AS status_product
              FROM tbl_product AS pd
              INNER JOIN category AS cat ON pd.catId = cat.catId
              INNER JOIN tbl_brand AS br ON pd.brandId = br.brandId
              INNER JOIN tbl_type_product AS tpd ON pd.typeProductId = tpd.typeProductID
              LEFT JOIN tbl_order AS od ON pd.productId = od.productId AND od.status=2
             
              GROUP BY pd.productId
              ORDER BY total_sold DESC";

    $result = $this->db->select($query);
    return $result;
}


    public function getproductbyId($id)
    {
        $query = "SELECT * FROM tbl_product where productId = '$id'";
        $result = $this->db->select($query);
        return $result;
    }
    public function getproductbyBrandId($id)
    {
        $sp_tungtrang = 8;
        if(!isset($_GET['trang'])){
            $trang = 1;
        }else{
            $trang = $_GET['trang'];
        }

        $product_start = ($trang-1)*$sp_tungtrang;

        $query = "SELECT pd.* , br.brandName 
        FROM tbl_product AS pd INNER JOIN tbl_brand AS br ON pd.brandId=br.brandId 
        WHERE pd.brandId  = '$id' AND pd.status_product=0  LIMIT $product_start,$sp_tungtrang";
        $result = $this->db->select($query);
        return $result;
    }
    public function getproductbyCategory($id)
    {
        $sp_tungtrang = 8;
        if(!isset($_GET['trang'])){
            $trang = 1;
        }else{
            $trang = $_GET['trang'];
        }

        $product_start = ($trang-1)*$sp_tungtrang;

        $query = "SELECT pd.* 
        FROM tbl_product AS pd
        WHERE pd.catId  = '$id' AND pd.status_product=0 LIMIT $product_start,$sp_tungtrang";
        $result = $this->db->select($query);
        return $result;
    } 
    public function getproductbyTypeProductId($id)
    {
        $sp_tungtrang = 8;
        if(!isset($_GET['trang'])){
            $trang = 1;
        }else{
            $trang = $_GET['trang'];
        }

        $product_start = ($trang-1)*$sp_tungtrang;

        $query = "SELECT pd.* , tpd.typeProductName 
        FROM tbl_product AS pd  INNER JOIN tbl_type_product AS tpd ON pd.typeProductId= tpd.typeProductID
        WHERE pd.typeProductId  = '$id' AND pd.status_product=0  LIMIT $product_start,$sp_tungtrang";
        $result = $this->db->select($query);
        return $result;
    }

    public function getproductbyBrandId_number_page($id)
    {
        $query = "SELECT pd.* , br.brandName 
        FROM tbl_product AS pd INNER JOIN tbl_brand AS br ON pd.brandId=br.brandId 
        WHERE pd.brandId  = '$id' AND pd.status_product=0 ";
        $result = $this->db->select($query);
        return $result;
    }
    public function getproductbyTypeProductId_number_page($id)
    {
        $query = "SELECT pd.* , tpd.typeProductName 
        FROM tbl_product AS pd  INNER JOIN tbl_type_product AS tpd ON pd.typeProductId= tpd.typeProductID
        WHERE pd.typeProductId  = '$id'  AND pd.status_product=0";
        $result = $this->db->select($query);
        return $result;
    }
    public function update_product($data, $files, $id)
    {
        // kết nối với cơ sở dữ liệu
        $productName = mysqli_real_escape_string($this->db->link, $data["productName"]);
        $category = mysqli_real_escape_string($this->db->link, $data["category"]);
        $typeProduct = mysqli_real_escape_string($this->db->link, $data["typeProduct"]);
        $brand = mysqli_real_escape_string($this->db->link, $data["brand"]);
        $product_desc = mysqli_real_escape_string($this->db->link, $data["product_desc"]);
        $price = mysqli_real_escape_string($this->db->link, $data["price"]);
       
        $product_status = mysqli_real_escape_string($this->db->link, $data["status_product"]);
        $addQuantity = mysqli_real_escape_string($this->db->link, $data["addQuantity"]);

        //kiểm tra hình ảnh và lấy hình ảnh cho vào folder uploads
        $permited = array('jpg', 'jpeg', 'png', 'gif');
        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_temp = $_FILES['image']["tmp_name"];

        $div = explode('.', $file_name);
        $file_ext = strtolower(end($div));
        $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
        $uploaded_image = "upload/" . $unique_image;

        //Kiểm tra tên sản phẩm có trùng hay không
        $sql_check_name = "SELECT * FROM tbl_product WHERE productName = '$productName' AND productId NOT IN ('$id')";
        $result_check_name = $this->db->select($sql_check_name);

        if($result_check_name){
            return "Tên sản phẩm đã tồn tại";
        }

        if($addQuantity <  0){
            return "Số lượng không được âm";
        }elseif($price < 0){
            return "Giá không được âm";
        }
        if (!empty($file_name)) {
            // Nếu người dùng chọn ảnh
            if ($file_size > 20480) {
                $alert = "<span class='error'> Chỉ có thể tải ảnh dưới 20MB </span>";
                return $alert;
            } elseif (in_array($file_ext, $permited) === false) {
                $alert = "<span class='error'> Chỉ có thể:" . implode(',', $permited) . "</span>";
                return $alert;
            }
            $query = "UPDATE tbl_product SET 
                        productName = '$productName',
                        brandId = '$brand',
                        catId = '$category',
                      
                        quantity = '$addQuantity'+quantity,
                        price = '$price',
                        image = '$unique_image',
                        status_product='$product_status',
                        product_desc = '$product_desc',
                        typeProductId = '$typeProduct'
                    WHERE productId = '$id'";
        } else {
            $query = "UPDATE tbl_product SET 
                        productName = '$productName',
                        brandId = '$brand',
                        catId = '$category',
                        
                        quantity = '$addQuantity'+quantity,
                        price = '$price',
                        status_product='$product_status',
                        product_desc = '$product_desc',
                        typeProductId = '$typeProduct'
                    WHERE productId = '$id'";
        }
        $result = $this->db->update($query);
        if ($result) {
            $alert = "<span class='success'> Cập nhập thành công  </span>";
            return $alert;
        } else {
            $alert = "<span class='error'> Cập nhập không thành công  </span>";
            return $alert;
        }
    }
    public function update_status($id)
    {
        $query="UPDATE tbl_product
        SET status_product = 1
        WHERE productId = '$id'";
        $result=$this->db->update($query);
        return $result;

    }
    public function del_product($id)
    {
        $query = "DELETE FROM tbl_product where productId = '$id'";
        $result = $this->db->delete($query);
        if ($result) {
            $alert = "<span class='success'> Xóa thành công  </span>";
            return $alert;
        } else {
            $alert = "<span class='error'> Xóa không thành công  </span>";
            return $alert;
        }
    }



    // END BACKEND
    // hiện thị best seller quần áo nam
    public function getProduct_Men()
    {
        $query = "SELECT *,SUM(od.quantity) as quantitysales FROM tbl_product AS pd
        INNER JOIN tbl_order AS od ON od.productId = pd.productId
        where type = '0' AND od.status='2' 
        GROUP BY od.productId
        ORDER BY od.quantity DESC LIMIT 8 ";
        $result = $this->db->select($query);
        return $result;
    }
    public function getProduct_seller()
    {
        $query = "SELECT *,SUM(od.quantity) as quantitysales FROM tbl_product AS pd
        INNER JOIN tbl_order AS od ON od.productId = pd.productId
        where od.status='2' 
        GROUP BY od.productId
        ORDER BY od.quantity DESC LIMIT 8 ";
        $result = $this->db->select($query);
        return $result;
    }
    // hiện thị best seller quần áo nữ
    public function getProduct_Women()
    {
        $query = "SELECT *,SUM(od.quantity) as quantitysales FROM tbl_product AS pd
        INNER JOIN tbl_order AS od ON od.productId = pd.productId
        where type = '1' AND od.status='2' 
        GROUP BY od.productId
        ORDER BY od.quantity DESC LIMIT 8 ";
        $result = $this->db->select($query);
        return $result;
    }
    public function getProduct()
    {
        $query = "SELECT *,SUM(od.quantity) as quantitysales FROM tbl_product AS pd
        INNER JOIN tbl_order AS od ON od.productId = pd.productId
        where  od.status='2'";
        $result = $this->db->select($query);
        return $result;
    }
    // hiện thị best seller quần áo trẻ em
    public function getProduct_Kid()
    {
        $query = "SELECT *,SUM(od.quantity) as quantitysales FROM tbl_product AS pd
        INNER JOIN tbl_order AS od ON od.productId = pd.productId
        where type = '2' AND od.status='2' 
        GROUP BY od.productId
        ORDER BY od.quantity DESC LIMIT 8 ";
        $result = $this->db->select($query);
        return $result;
    }
    // hiển thị chi tiết sản phẩm
    public function getProduct_Details($id)
    {
        $query = "SELECT pd.* , cat.catName , br.brandName
            FROM tbl_product AS pd INNER JOIN category AS cat ON pd.catId=cat.catId   
            INNER JOIN tbl_brand AS br ON pd.brandId=br.brandId
            WHERE pd.productId = '$id' ";
        $result = $this->db->select($query);
        return $result;
    }
    // tìm kiếm sản phẩm theo tên
    public function searchProduct($productName)
    {
        $item_per_page = !empty($_GET['per_page'])?$_GET['per_page']:6;
        $current_page = !empty($_GET['page'])?$_GET['page']:1;
        $offsset = ($current_page-1)*$item_per_page;
        $sql = "SELECT * FROM tbl_product WHERE productName like '%$productName%' LIMIT $item_per_page OFFSET $offsset" ;
        $result = $this->db->select($sql);
        return $result;
    }
    // tìm kiếm sản phẩm theo khoảng giá
    public function searchProductPrice()
    {
        $sql = "SELECT * FROM tbl_product order by tbl_product.price desc LIMIT 20";
        $result = $this->db->select($sql);
        return $result;
    }
     // từ id kiểm tra số lượng sản phẩm còn < 0 hay không ?
     public function checkQuantityProduct($id)
     {
         $sql = "SELECT * FROM tbl_product WHERE productId = '$id' AND quantity > 0 ";
         $result = $this->db->select($sql);
         return $result;
     }
    // tìm kiếm sản phẩm theo khoảng giá
    public function searchProductRangePrice($data)
    {
        $range = mysqli_real_escape_string($this->db->link, $data['range']);
        $category = mysqli_real_escape_string($this->db->link, $data['category']);
        $brand = mysqli_real_escape_string($this->db->link, $data['brand']);
        $sql = "SELECT pd.*
            FROM tbl_product AS pd 
            INNER JOIN category AS cat ON pd.catId=cat.catId   
            INNER JOIN tbl_brand AS br ON pd.brandId=br.brandId
            WHERE cat.catName='$category' AND br.brandName='$brand' AND pd.status_product=0 AND pd.price <='$range'";
        $result = $this->db->select($sql);
        return $result;
    }
    // search category
    public function display_product_category($rowcategory)
    {
        $sp_tungtrang = 6;
        if(!isset($_GET['trang'])){
            $trang = 1;
        }else{
            $trang = $_GET['trang'];
        }
        $tungtrang = ($trang-1)*$sp_tungtrang;
        $sql = "SELECT * FROM tbl_product WHERE catId IN ($rowcategory) LIMIT $tungtrang,$sp_tungtrang";
        $result = $this->db->select($sql);
        return $result;
    }
    // all product category
    public function get_all_product_category($rowcategory, $rowbrand, $rowprice){
        $sql = "SELECT * FROM tbl_product WHERE catId IN ('$rowcategory') OR brandId IN ('$rowbrand') OR price <= ('$rowprice')";
        $result = $this->db->select($sql);
        return $result;
    }
    // search brand
    public function display_product_brand($rowbrand)
    {
        $sql = "SELECT * FROM tbl_product WHERE brandId IN ($rowbrand)";
        $result = $this->db->select($sql);
        return $result;
    }
    //search price
    public function display_product_price($rowprice){
        $sp_tungtrang = 6;
        if(!isset($_GET['trang'])){
            $trang = 1;
        }else{
            $trang = $_GET['trang'];
        }
        $tungtrang = ($trang-1)*$sp_tungtrang;
        $sql = "SELECT * FROM tbl_product WHERE price <= ($rowprice) LIMIT $tungtrang,$sp_tungtrang";
        $result = $this->db->select($sql);
        return $result;
    }
    // get all product price
    public function get_all_product_price($rowprice){
        $sql = "SELECT * FROM tbl_product WHERE price <= ($rowprice) ";
        $result = $this->db->select($sql);
        return $result;
    }
    // display product sort price
    public function display_product_sortprice($sort_option){
        $item_per_page = !empty($_GET['per_page'])?$_GET['per_page']:6;
        $current_page = !empty($_GET['page'])?$_GET['page']:1;
        $offsset = ($current_page-1)*$item_per_page;
        $sql = "SELECT * FROM tbl_product  ORDER BY price $sort_option LIMIT $item_per_page OFFSET $offsset";
        $result = $this->db->select($sql);
        return $result;
    }
    // display category
    public function show_nameCategory()
    {
        $sql = "SELECT * FROM category";
        $result = $this->db->select($sql);
        return $result;
    }
    // display brand
    public function show_nameBrand()
    {
        $sql = "SELECT * FROM tbl_brand";
        $result = $this->db->select($sql);
        return $result;
    }
    // all product
    public function get_all_product(){
        $sql = "SELECT * FROM tbl_product 
        WHERE status_product=0";
        $result = $this->db->select($sql);
        return $result;
    }

// chọn ngẫu nhiên cac sp cung brand trừ sp hiện tại 
    public function getProduct_Relationship($br,$id)
    {
        $query = "SELECT * FROM tbl_product where brandId='$br' and productId not in ('$id') 
                  ORDER BY rand() limit 5
          ";
        $result = $this->db->select($query);
        return $result;
    }
//Tìm kiếm nâng cao
    public function search_Advanced($category,$brand,$price,$search)
    {
        $sp_tungtrang = 6;
        if(!isset($_GET['trang'])){
            $trang = 1;
        }else{
            $trang = $_GET['trang'];
        }
        $product_start = ($trang-1)*$sp_tungtrang;

        if($search ==""){

            if($category == '(-1)' && $brand == '(-1)' && $price !=-1){
                $sql = "SELECT * FROM tbl_product WHERE price <= '$price' AND status_product=0 LIMIT $product_start,$sp_tungtrang";
            }elseif($category !='(-1)' && $brand =='(-1)' && $price ==-1){
                $sql = "SELECT * FROM tbl_product WHERE catId IN $category AND status_product=0 LIMIT $product_start,$sp_tungtrang";
            }elseif($category =='(-1)' && $brand !='(-1)' && $price ==-1){
                $sql = "SELECT * FROM tbl_product WHERE brandId IN $brand AND status_product=0 LIMIT $product_start,$sp_tungtrang";
            }elseif($category !='(-1)' && $brand !='(-1)' && $price ==-1){
                $sql = "SELECT * FROM tbl_product WHERE catId IN $category AND  status_product=0 AND brandId IN $brand  LIMIT $product_start,$sp_tungtrang";
            }elseif($category !='(-1)' && $brand =='(-1)' && $price !=-1){
                $sql = "SELECT * FROM tbl_product WHERE catId IN $category AND status_product=0 AND price <= '$price'  LIMIT $product_start,$sp_tungtrang";
            }elseif($category =='(-1)' && $brand !='(-1)' && $price !=-1){
                $sql = "SELECT * FROM tbl_product WHERE brandId IN $brand AND status_product=0 AND price <= '$price'  LIMIT $product_start,$sp_tungtrang";
            }elseif($category !='(-1)' && $brand !='(-1)' && $price !=-1){
                $sql = "SELECT * FROM tbl_product WHERE catId IN $category AND status_product=0 AND brandId IN $brand AND price <= '$price'   LIMIT $product_start,$sp_tungtrang";
            }elseif($category =='(-1)' && $brand =='(-1)' && $price ==-1){
                $sql = "SELECT * FROM tbl_product WHERE status_product=0 LIMIT $product_start,$sp_tungtrang";
            }

        }else{

            if($category =='(-1)' && $brand =='(-1)' && $price ==-1)
                $sql = "SELECT * FROM tbl_product WHERE productName like '%$search%' AND status_product=0  LIMIT $product_start,$sp_tungtrang";
        }

        $result = $this->db->select($sql);
        return $result;
    }
    public function getProductsByIdCategory_number_page($categoryName)
    {
        // Escaping và chuẩn hóa tên loại áo
        $categoryName = $this->db->link->real_escape_string($categoryName);

        // Câu truy vấn SQL để lấy các sản phẩm thuộc vào một loại áo cụ thể
        $query = "SELECT * FROM tbl_product WHERE catId = '$categoryName'";
        
        // Thực hiện truy vấn và trả về kết quả
        return $this->db->select($query);
    }
    public function countProductsByCategory($categoryId) {
        // Escape $categoryId để tránh SQL injection
        $categoryId = $this->db->link->real_escape_string($categoryId);
        
        // Truy vấn SQL để đếm số lượng sản phẩm trong danh mục có catId là $categoryId
        $sql = "SELECT COUNT(*) AS count FROM tbl_product WHERE catId =  '$categoryId'";
        
        // Thực hiện truy vấn
        $result = $this->db->select($sql);
        
        // Kiểm tra xem có kết quả hay không
        if ($result) {
            // Lấy số lượng sản phẩm từ kết quả truy vấn
            $count = $result->fetch_assoc()['count'];
            return $count;
        } else {
            // Trả về 0 nếu không có kết quả
            return 0;
        }
    }
    
    //Tìm kiếm nâng cao
    public function number_page($category,$brand,$price,$search)
    {

        if($search ==""){

            if($category =='(-1)' && $brand =='(-1)' && $price !=-1){
                $sql = "SELECT * FROM tbl_product WHERE price <= '$price' ";
            }elseif($category !='(-1)' && $brand =='(-1)' && $price ==-1){
                $sql = "SELECT * FROM tbl_product WHERE catId IN $category  ";
            }elseif($category =='(-1)' && $brand !='(-1)' && $price ==-1){
                $sql = "SELECT * FROM tbl_product WHERE brandId IN $brand  ";
            }elseif($category !='(-1)' && $brand !='(-1)' && $price ==-1){
                $sql = "SELECT * FROM tbl_product WHERE catId IN $category AND brandId IN $brand ";
            }elseif($category !='(-1)' && $brand =='(-1)' && $price !=-1){
                $sql = "SELECT * FROM tbl_product WHERE catId IN $category AND price <= '$price'  ";
            }elseif($category =='(-1)' && $brand !='(-1)' && $price !=-1){
                $sql = "SELECT * FROM tbl_product WHERE brandId IN $brand AND price <= '$price'  ";
            }elseif($category !='(-1)' && $brand !='(-1)' && $price !=-1){
                $sql = "SELECT * FROM tbl_product WHERE catId IN $category AND brandId IN $brand AND price <= '$price'  ";
            }elseif($category =='(-1)' && $brand =='(-1)' && $price ==-1){
                $sql = "SELECT * FROM tbl_product ";
            }

        }else{

            if($category =='(-1)' && $brand =='(-1)' && $price ==-1)
                $sql = "SELECT * FROM tbl_product WHERE  productName like '%$search%' ";
        }

        $result = $this->db->select($sql);
        return $result;
    }

}
?>