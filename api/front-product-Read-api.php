<?php
    $servername = "localhost";
    $username = "owner01";
    $password = "123456";
    $dbname = "Fraus";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if(!$conn){
        die("連線錯".mysqli_connect_error());
    }

    $sql = "SELECT * FROM product WHERE Sell = 'Y'";
    $result = mysqli_query($conn, $sql);

    $mydata = array();
    if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_assoc($result)){
            $mydata[] = $row;
        }
        echo '{"state" : true, "data" : '. json_encode($mydata) . ',"message" : "查詢資料成功"}';
    }else{
        echo '{"state" : false, "message" : "查詢資料失敗,查無資料!"}';
    }

    mysqli_close($conn);
?>