<?php include './inc/handle.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <link rel="stylesheet" href="assets/css/base.css"> -->
    <link rel="stylesheet" href="assets/css/grid.css">
    <link rel="stylesheet" href="assets/css/productCart.css">
    <link rel="stylesheet" href="assets/css/base.css">
    <link rel="stylesheet" href="assets/css/thanhtoan.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/hoadon.css">
    <link rel="stylesheet" href="assets/font/themify-icons/themify-icons.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hóa đơn</title>
    
</head>
<body>
<?php include 'inc/header.php' ?>
		<div  class="app">
        <div class="receipt-main col-xs-10 col-sm-10 col-md-6 col-xs-offset-1 col-sm-offset-1 col-md-offset-3">
            <div class="row">
    			<div class="receipt-header">
					<div class="col-xs-6 col-sm-6 col-md-6">
						<div class="receipt-left">
							<img class="img-responsive" alt="iamgurdeeposahan" src="https://bootdey.com/img/Content/avatar/avatar6.png" style="width: 71px; border-radius: 43px;">
						</div>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6 text-right">
						<div class="receipt-right">
							<h5>Company Name.</h5>
							<p>+1 3649-6589 <i class="fa fa-phone"></i></p>
							<p>company@gmail.com <i class="fa fa-envelope-o"></i></p>
							<p>USA <i class="fa fa-location-arrow"></i></p>
						</div>
					</div>
				</div>
            </div>
			
			<div class="row">
				<div class="receipt-header receipt-header-mid">
					<div class="col-xs-8 col-sm-8 col-md-8 text-left">
						<div class="receipt-right">
							<h5>Customer Name </h5>
							<p><b>Mobile :</b> +1 12345-4569</p>
							<p><b>Email :</b> customer@gmail.com</p>
							<p><b>Address :</b> New York, USA</p>
						</div>
					</div>
					<div class="col-xs-4 col-sm-4 col-md-4">
						<div class="receipt-left">
							<h3>INVOICE # 102</h3>
						</div>
					</div>
				</div>
            </div>
			
            <div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Mã hóa đơn</th>
                            <th>Tên sản phẩm</th>
                            <th>Hình ảnh</th>
                            <th>Số lượng</th>
                            <th>Đơn giá</th>
                            <th>Thành tiền</th>
                            <th>phương thức thanh toán</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="col-md-9">Payment for August 2016</td>
                            <td class="col-md-3"><i class="fa fa-inr"></i> 15,000/-</td>
                            <td> <img class="app_cart-img" src="admin/upload/057244455f.jpg" alt=""></td>
                            <td>2</td>
                            <td>200,000đ</td>
                            <td>400,000đ</td>
                            <td>chuyển khoản</td>
                        </tr>
                        <tr>
                            <td class="col-md-9">Payment for June 2016</td>
                            <td class="col-md-3"><i class="fa fa-inr"></i> 6,00/-</td>
                        </tr>
                        <tr>
                            <td class="col-md-9">Payment for May 2016</td>
                            <td class="col-md-3"><i class="fa fa-inr"></i> 35,00/-</td>
                        </tr>
                        <tr>
                            <td class="text-right">
                            <p>
                                <strong>Total Amount: </strong>
                            </p>
                            <p>
                                <strong>Late Fees: </strong>
                            </p>
							<p>
                                <strong>Payable Amount: </strong>
                            </p>
							<p>
                                <strong>Balance Due: </strong>
                            </p>
							</td>
                            <td>
                            <p>
                                <strong><i class="fa fa-inr"></i> 65,500/-</strong>
                            </p>
                            <p>
                                <strong><i class="fa fa-inr"></i> 500/-</strong>
                            </p>
							<p>
                                <strong><i class="fa fa-inr"></i> 1300/-</strong>
                            </p>
							<p>
                                <strong><i class="fa fa-inr"></i> 9500/-</strong>
                            </p>
							</td>
                        </tr>
                        <tr>
                           
                            <td class="text-right"><h2><strong>Total: </strong></h2></td>
                            <td class="text-left text-danger"><h2><strong><i class="fa fa-inr"></i> 31.566/-</strong></h2></td>
                        </tr>
                    </tbody>
                </table>
            </div>
			
			<div class="row">
				<div class="receipt-header receipt-header-mid receipt-footer">
					<div class="col-xs-8 col-sm-8 col-md-8 text-left">
						<div class="receipt-right">
							<p><b>Date :</b> 15 Aug 2016</p>
							<h5 style="color: rgb(140, 140, 140);">Thanks for shopping.!</h5>
						</div>
					</div>
					<div class="col-xs-4 col-sm-4 col-md-4">
						<div class="receipt-left">
							<h1>Stamp</h1>
						</div>
					</div>
				</div>
            </div>
			
        </div>    
        <?php include './inc/footer.php' ?>
        </div>
</body>
</html>