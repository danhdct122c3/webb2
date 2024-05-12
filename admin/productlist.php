<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1">
    <link rel="stylesheet" href="assets/font/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="assets/css/sp.css">
    <title>Sản phẩm</title>
</head>
<?php 
    include '../classses/brand.php';
    include '../classses/category.php';
    include '../classses/product.php';
    include_once '../helpers/format.php';
?>
<?php
	$pd = new product();
	$fm = new Format();
    if (isset($_GET['delid'])) {
		$id = $_GET['delid'];
		$delproduct = $pd->del_product($id);
	}
    if(isset($_GET['hide']))
    {
        $id = $_GET['hide'];
        $updatestatus= $pd->update_status($id);
    }
   
?>
<?php
function checkproduct()
{
    
}
?>
<body>
    <?php include './inc/sidebar.php' ?>
    <div class="main-content">
        <?php include './inc/header.php' ?>
        <main>
            <section class="recent">
            <div class="activity-grid">
                <div class="activity-card">
                    <div class="activity-header">
                        <h3>Danh sách sản phẩm</h3>
                        <div class="activity-more">
                            <span class="ti-plus"></span>
                            <a href="productadd.php"> <h4>Thêm sản phẩm</h4></a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Số lượng</th>
                                    <th>Giá sản phẩm</th>
                                    <th>Đã bán</th>
                                    <th>Ảnh sản phẩm</th>
                                    <th>Kiểu sản phâm</th>
                                    <th>Danh mục</th>
                                    <th>Thương hiệu</th>
                                    <th>trạng thái</th>
                                    <th>Mô tả</th>
                                    <!-- <th>Kiểu</th> -->
                                    <th colspan="2" >Hoạt động</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $pd = new product();
                                $pdlist = $pd->show_product1();
                                $getqty=$pd->getProduct();
                                if ($pdlist) {
                                    $i=0;
                                    
                                       
                                            while ($result = $pdlist->fetch_assoc()) {
                                                $i++;	
                            ?>
                            <tr>
                                <td><?php echo $result['productId'] ?></td>
                                <td><?php echo $result['productName'] ?></td>
                                <td><?php echo $result['quantity'] ?></td>
                                <td><?php echo $result['price'] ?></td>
                                <!-- <td><?php echo $result['total_sold'] ?></td> -->
                                <!-- <td><?php echo ($result['status_product'] == '0') ? $result['total_sold'] : '0' ?></td> -->
                                <td>
                                    <?php
                                        // if($result['status_product']==0)
                                        // {
                                        //     echo $result['total_sold'];
                                        
                                        // }
                                        if($result['total_sold']>0) echo $result['total_sold'];
                                        else echo "0"
                                       
                                    ?>
                                    
                                </td>

                                <td><img src="upload/<?php echo $result['image'] ?>" style="width: 50px; height: 50px;" ></td>
                                <td><?php echo $result['typeProductName'] ?></td>
                                <td><?php echo $result['catName'] ?></td>
                                <td><?php echo $result['brandName'] ?></td>
                                <td><?php if($result['status_product']==0) echo "đang hiển thị ";
                                elseif($result['status_product']==1) echo "đã ẩn"
                                ?>
                            </td>
                                <td>
                                    <?php 
                                        echo $fm->textShorten($result['product_desc'],20);
                                    ?>
                                </td>
                                <td>
                                    <!-- <?php 
                                        if ($result['type']==0) {
                                            echo 'Quần áo nam';
                                        } else if ($result['type']==1) {
                                            echo 'Quần áo nữ';
                                        } else if ($result['type']==2) {
                                            echo 'Quần áo trẻ em';
                                        }
                                    ?> -->
                                </td>
                                <td><a href="productedit.php?productId=<?php echo $result['productId']?>">Edit</a> 
                                <?php 
                                    if($result['total_sold']>0)
                                    { 

                                ?>
                                ||<a onclick="return confirm('Bạn có chắc chắn muốn ẩn')" href="?hide=<?php echo $result['productId'] ?>">Ẩn</a>
                                    <?php } 
                                     elseif($result['total_sold']==0)
                                     {
                                     
                                    ?>
                                        || <a onclick="return confirm('Bạn có chắc chắn muốn xóa')" href="?delid=<?php echo $result['productId'] ?>">Delete</a></td>

                                <?php
                               
                                

                                }
                                ?>        
                               
                             </tr>
                                <?php
                                    }
                                 }

                                
                                ?>
                        </table>
                    </div>
                </div>
            </div>
            </section>
        </main>
    </div>
</body>
</html>