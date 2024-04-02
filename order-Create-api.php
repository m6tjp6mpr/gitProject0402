<?php
//input: {"Pname":"奶茶", "Price":"50", "Sugar":"全糖", "Num":"10", "Delivery":"true", "Added":"不要", "Pay":"現金", "Total":"500"}
// $data = '{"Pname":"奶茶", "Price":"500", "Sugar":"全糖", "Num":"10", "Delivery":"true", "Added":"不要", "Pay":"現金", "Total":"500"}';

$data = file_get_contents("php://input", "r"); //讀外部丟給php的東西
if ($data != "") {
    $mydata = array(); // php宣告陣列的方法
    $mydata = json_decode($data, true); //轉換成json的方法，左邊是要轉的資料，右邊要寫true

    if (isset($mydata["User"]) && isset($mydata["orderDate"]) && isset($mydata["radPay"]) && isset($mydata["radTake"]) && isset($mydata["Addr"]) && isset($mydata["Now"]) && isset($mydata["OrderNumber"]) && $mydata["User"] != "" && $mydata["orderDate"] != "" && $mydata["radPay"] != "" && $mydata["radTake"] != "" && $mydata["Addr"] != "" && $mydata["Now"] != "" && $mydata["OrderNumber"] != "") {

        $p_User = $mydata["User"];
        $p_orderDate = $mydata["orderDate"];
        $p_radPay = $mydata["radPay"];
        $p_radTake = $mydata["radTake"];
        $p_Addr = $mydata["Addr"];
        $p_Now = $mydata["Now"];
        $p_OrderNumber = $mydata["OrderNumber"];


        $servername = "localhost";
        $username = "owner01";
        $password = "123456";
        $dbname = "Fraus";

        $conn = mysqli_connect($servername, $username, $password, $dbname);

        if (!$conn) {
            die("失敗" . mysqli_connect_error());
        }

        $sql = "INSERT INTO `order`(User, Date, Pay, Take, Addr, Now, OrderNumber) VALUES ('$p_User','$p_orderDate', '$p_radPay', '$p_radTake', '$p_Addr', '$p_Now', '$p_OrderNumber')";

        if (mysqli_query($conn, $sql)) {

            echo '{"state" : true, "message" : "訂購人新增成功"}';
        } else {
            echo '{"state" : false, "message" : "訂購人新增失敗"}';
        }
        mysqli_close($conn);
    } else {
        echo '{"state" : false, "message" : "格式錯"}';
    }
} else {
    echo '{"state" : false, "message" : "沒資料"}';
}
