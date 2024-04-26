<?php
// ư
$conn= new mysqli("localhost","root","","web2");
if($conn->connect_errno)
{
    echo "lỗi" . $conn->connect_error;
    exit();
}
?>
