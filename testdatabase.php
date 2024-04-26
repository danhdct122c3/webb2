<?php include './inc/handle.php' ?>
 <?php include './config/connect.php' ?> 
 <?php include './inc/header.php'?>
<?php
    $category= new category();
    
?>


<!DOCTYPE html>
<html lang="en">
<head>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sản phẩm</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" type="text/css" href="assets/css/main.css">
    <link rel="stylesheet" type="text/css" href="assets/css/listProduct.css">
    <link rel="stylesheet" type="text/css" href="assets/css/grid.css">
    <link rel="stylesheet" href="assets/font/themify-icons/themify-icons.css">
    <link rel="shortcut icon" href="assets/img/favicon_created_by_logaster.ico" type="image/x-icon">
</head>
</head>

<body>
    <!-- <?php 
        $cate= $category->show_category();
        if ($cate) {
            while ($result = $cate->fetch_assoc()) {
                echo $result['catName'] . "<br>";
            }
        } else {
            echo "Không có danh mục nào được tìm thấy.";
        }
    ?> -->
    <!-- <a href="testdatabase.php">trang chủ</a>
        <a href="?idType=34&type=0">sản phẩm</a>
        <?php
            if (isset($_GET['idType'])) {
                $mod = $_GET['idType'];
            } else {
                $mod = '';
            }
            if (isset($_GET['type'])) {
                $type = $_GET['type'];
            } else {
                $type = '';
            }
            echo "<br>Module:{$mod}";
            echo "<br>Id:{$type}";
        ?> -->
        <?php
        
        $sql= "SELECT *
        FROM `tbl_product` AS pr
        INNER JOIN `category` AS ca ON pr.catId = ca.catId 
        WHERE ca.catId = 40 ";
        $result=mysqli_query($conn,$sql);
        // $row=mysqli_num_rows($result);
        // echo $row;
        if(mysqli_num_rows($result)>0)
        {
            while($row= mysqli_fetch_assoc($result))
            {
                echo "<div class='col l-3'>";
                echo "<a style='text-decoration: none;shape-rendering: #333;color: #333;' href='chitietsanpham.php?productId=" . $row['productId'] . "&&brandId=" . $row['brandId'] . "&&type=" . $row['type'] . "'>";
                echo "<div class='home-product-item'>";
                echo "<img src='./admin/upload/". $row['image']."' alt=''>";
                
                echo "<span class='home-product-item_name'>" . $row['productName'] . "</span>";
                echo "<div class='home-product-item_price'>";
                echo "<span class='home-product-item_price'>" . number_format($row['price'], 0, ',', '.') . "" . "đ" . "</span>";
                echo "</div>";
                echo "</div>";
                 echo "</a>";
                echo "</div>";
                // echo ":" .$row['productName'];
                // echo "<img src='./admin/upload/". $row['image']."' alt='' >" ;
                // echo "<br> ". $row['catName'];
            }
            
        }
        ?>
        <img src="./admin/upload/057244455f.jpg" alt="">
</body>
</html>