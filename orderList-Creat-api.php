<?php
//input: {"Pname":"奶茶", "Price":"50", "Sugar":"全糖", "Num":"10", "Delivery":"true", "Added":"不要", "Pay":"現金", "Total":"500"}
// $data = '{"Pname":"奶茶", "Price":"500", "Sugar":"全糖", "Num":"10", "Delivery":"true", "Added":"不要", "Pay":"現金", "Total":"500"}';

$data = file_get_contents("php://input", "r"); //讀外部丟給php的東西
if ($data != "") {
    $mydata = array(); // php宣告陣列的方法
    $mydata = json_decode($data, true); //轉換成json的方法，左邊是要轉的資料，右邊要寫true

    if (isset($mydata["OrderNumber"]) && isset($mydata["mapShopcarProId"]) && isset($mydata["mapShopcarOrderNum"]) && $mydata["OrderNumber"] != "" && $mydata["mapShopcarProId"] != "" && $mydata["mapShopcarOrderNum"] != "") {

        $p_OrderNumber = $mydata["OrderNumber"];
        $p_mapShopcarProId = $mydata["mapShopcarProId"];
        $p_mapShopcarOrderNum = $mydata["mapShopcarOrderNum"];

        $servername = "localhost";
        $username = "owner01";
        $password = "123456";
        $dbname = "Fraus";

        $conn = mysqli_connect($servername, $username, $password, $dbname);

        if (!$conn) {
            die("失敗" . mysqli_connect_error());
        }

        $sql = "INSERT INTO orderList(OrderNumber, ProId, OrderNum) VALUES ('$p_OrderNumber','$p_mapShopcarProId', '$p_mapShopcarOrderNum')";

        if (mysqli_query($conn, $sql)) {

            echo '{"state" : true, "message" : "訂購商品新增成功"}';
        } else {
            echo '{"state" : false, "message" : "訂購商品新增失敗"}';
        }
        mysqli_close($conn);
    } else {
        echo '{"state" : false, "message" : "格式錯"}';
    }
} else {
    echo '{"state" : false, "message" : "沒資料"}';
}
