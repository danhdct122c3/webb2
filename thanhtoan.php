<?php include './inc/handle.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <link rel="stylesheet" href="assets/css/base.css"> -->
    <link rel="stylesheet" href="assets/css/grid.css">
    <link rel="stylesheet" href="assets/css/productCart.css">
    <link rel="stylesheet" href="assets/css/base.css">
    <link rel="stylesheet" href="assets/css/thanhtoan.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/font/themify-icons/themify-icons.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>
</head>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['orderid']) && $_POST['orderid'] === 'order') {
    date_default_timezone_set("Asia/Ho_Chi_Minh");
    $date=date('Y-m-d H:i:s');
    $city=$_POST['city'];
    $district=$_POST['district'];
    $ward=$_POST['ward'];
    $address=$_POST['address'];
    $payment_method = $_POST['payment_method'];
    $inserOder = $order->insertOder(Session::get('user_id'),$date,$payment_method,$city,$district,$ward,$address);
    $delCart = $cat->del_Cart(Session::get('user_id'));
    header('Location:donhang.php');
    // var_dump($_POST);
    } else {
        echo "Form chưa được submit.";
    }
}
?>
<body>
    <div class="grid">
        <!-- Phần header -->
        <?php include 'inc/header.php' ?>
    </div>
    <div class="grid" style="border-top: 1px solid #ccc;">
        <form action="" method="POST">
            <div class="grid">
                <div class="app">
                    <div class="grid wide">
                        <div class="row">
                            <div class="col l-8" style="margin-top: 40px;">
                                <div class="col l-12">
                                    <div class="checkout-process-bar block-border">
                                        <ul>
                                            <li class="">
                                                <span>Giỏ hàng</span>
                                            </li>
                                            <li class="active"><span>Đặt hàng</span></li>
                                            <li class=""><span>Thanh toán</span></li>
                                            <li><span>Hoàn thành đơn</span></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col l-12" style="margin: 20px 0;">
                                    <h3 style="padding: 10px;font-family: var(--font-family-sans-serif);">Thông tin sản phẩm</h3>
                                    <div style="border: 1px solid #e7e8e9;border-radius: 32px 0px 0px;">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Ảnh</th>
                                                    <th>Tên</th>
                                                    <th>Size</th>
                                                    <th>Giá</th>
                                                    <th>Số lượng</th>
                                                    <th>Số tiền</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $getProductCat = $cat->getProductCart(Session::get('user_id'));
                                                if ($getProductCat) {
                                                    $dem = 0;
                                                    $subTotal = 0;
                                                    $i = 0;
                                                    while ($result_ProductCat = $getProductCat->fetch_assoc()) {
                                                ?>
                                                        <tr>
                                                            <td><?= ($i = $i + 1); ?></td>
                                                            <td>
                                                                <div class="cart-td_title">
                                                                    <a href="chitietsanpham.php?productId=<?php echo $result_ProductCat['productId']; ?>">
                                                                        <img style="cursor:pointer;" src="./admin/upload/<?php echo $result_ProductCat['image'] ?>" alt="" class="app_cart-img">
                                                                    </a>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <span><?php echo $result_ProductCat['productName'] ?></span>
                                                            </td>
                                                            <td><?php echo $result_ProductCat['size'] ?></td>
                                                            <td>
                                                                <div class="cart-btn">
                                                                    <span><?php echo number_format($result_ProductCat['price'], 0, ',', '.') . "" . "đ" ?></span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <form action="" method="post">
                                                                    <!-- hidden loại type không hiên thị -->
                                                                    <input type="hidden" name="cartId" value="<?php echo $result_ProductCat['cartID'] ?>" />
                                                                    <input style="border: none;background: none;font-family: var(--font-family-sans-serif);" type="button" name="quantity" value="<?php echo $result_ProductCat['quantity'] ?>" width="30px" />
                                                                    <!-- <input type="submit" name="submit" value="Update"/> -->
                                                                </form>
                                                            </td>

                                                            <td>
                                                                <span class="cart-current"><?php $total = $result_ProductCat['price'] * $result_ProductCat['quantity'];
                                                                                            echo number_format($total, 0, ',', '.') . " " . "đ";
                                                                                            ?></span>
                                                            </td>

                                                        </tr>
                                                <?php
                                                        $dem++;
                                                        $subTotal += $total;
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                            <!-- <?php
                                                    if (isset($update_quantity)) {
                                                        echo $update_quantity;
                                                    }
                                                    ?>
                                        <?php
                                        if (isset($delProductCart)) {
                                            echo $delProductCart;
                                        }
                                        ?> -->
                                        </table>
                                    </div>

                                </div>
                                
                                <div class="col l-12" style="margin: 20px 0;">
                                    <h3 style="padding: 10px;font-family: var(--font-family-sans-serif);">Địa chỉ giao hàng</h3>
                                    <div style="border:none; border-radius: 32px 0px 0px;">
                                    <?php
                                        $userId = Session::get('user_id');
                                        $infor_user = $user->show_User($userId);
                                        while ($result_infor_user = $infor_user->fetch_assoc()) {
                                        ?>
                                     
                                          <table>
                                                <tbody>
                                                    <tr style="line-height:50px;">
                                                        <td>Thành Phố: </td>
                                                        <td >
                                                           <input type="text" name="city" value="<?php echo $result_infor_user['city'] ?>"> 
                                                          
                                                        </td>
                                                    </tr>
                                                    <tr style="line-height:50px;">
                                                        <td>Quận/Huyện </td>
                                                        <td >
                                                        <input type="text" name="district" value="<?php echo $result_infor_user['district'] ?>">
                                                        
                                                        </td>
                                                    </tr>
                                                    <tr style="line-height:50px;">
                                                        <td>Phường/Xã</td>
                                                        <td>
                                                        <input type="text" name="ward" value="<?php echo $result_infor_user['ward'] ?>"> 
                                                       
                                                        </td>
                                                    </tr>
                                                    <tr style="line-height:50px;">
                                                        <td>Địa Chỉ: </td>
                                                        <td >
                                                            <!-- <input type="text" name="address" value="đã nhận dữ liệu"> -->
                                                            <input type="text"name="address"  value="<?php echo $result_infor_user['diaChi'] ?>">
                                                            
                                                           
                                                        </td>
                                                    </tr>
                                                    <tr style="line-height:50px;">
                                                        <td  style="cursor:pointer;" colspan="3">
                                                        
                                                       <span class="cart-purchase-button"  ><button type="button" id="updateAddressBtn">Cập nhật địa chỉ giao hàng</button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                </tbody>
                                            <?php
                                        }
                                            ?>
                                            </table>
                                            
                                         
                                    </div>

                                </div>

                            </div>
                            <div class="col l-4">
                            <div class="cart-voucher">
								<h3>Tóm tắt đơn hàng</h3>
								<?php
								$check_cart = $cat->checkCart(Session::get('user_id'));
								if ($check_cart) {
								?>
									<div style="display: flex;justify-content: space-between; margin: 20px 0;">
										<span class="voucher-title">
											<span>Tổng sản phẩm</span>
										</span>
										<span class="sum-product"><?php
																	Session::set('sum', $dem);
																	echo $dem ?>
										</span>
									</div>
									<div style="display: flex;justify-content: space-between; margin: 20px 0;">
										<div class="voucher-title">
											<span>Tổng tiền hàng</span>
										</div>
										<span class="sum-product"><?php echo number_format($subTotal, 0, ',', '.') . "" . "đ" ?></span>
									</div>
									<!-- <div style="display: flex;justify-content: space-between; margin: 20px 0;">
										<span class="sum-product">Tiền thuế(VAT 10%)</span>
										<span class="sum-product">
											<?php
											$vat = $subTotal * 0.1;
											echo number_format($vat, 0, ',', '.') . "" . "đ";
											?>
										</span>
									</div> -->
									<div class="cart-purchase">
										<span class="sum-product">Thành tiền</span>
										<span class="sum-product" style="font-weight: 800;">
											<?php
											$grand_Total = $subTotal;
											// $grand_Total = $subTotal - $vat;
											echo number_format($grand_Total, 0, ',', '.') . "" . "đ"
											?>
										</span>
									</div>
                                    <div class="payment" style="display: flex;justify-content: space-between; margin: 20px 0;">
                                    <div class="voucher-title">
											<span>Hình thức thanh toán</span> 
										</div>
                                        <select name="payment_method" id="">
                                            <option value=1 selected>Thanh toán khi nhận hàng</option>
                                            <option value=2 >Chuyển khoản</option>
                                            
                                        </select>
                                       
                                    </div>
									<div class="cart-purchase-button">
                                    <button type="submit" name="submit" id="btn_order" onclick="return alert('Bạn đã đặt hàng thành công')">Xác nhận đặt hàng</button>
                                    </div>
								<?php
								} else {
								}
								?>
							</div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <input type="hidden" name="orderid" value="order">

        </form>
        <?php include './inc/footer.php' ?>
    </div>
    <script>
        document.getElementById('updateAddressBtn').addEventListener('click', function() {
            alert('Cập nhật địa chỉ thành công');
        });
    </script>                           
</body>

</html>