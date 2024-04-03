<?php
    //input: {"ID":"1"}
    // output:
    // {"state" : true, "message" : "刪除成功!"}
    // {"state" : false, "message" : "刪除失敗!"}
    // {"state" : false, "message" : "傳遞參數格式錯誤!"}
    // {"state" : false, "message" : "未傳遞任何參數!"}

    $data = file_get_contents("php://input", "r"); //讀外部丟給php的東西
    if($data != ""){
        $mydata = array(); // php宣告陣列的方法
        $mydata = json_decode($data, true); //轉換成json的方法，左邊是要轉的資料，右邊要寫true

        if(isset($mydata["ID"]) && $mydata["ID"] != ""){

            $p_ID = $mydata["ID"];


            $servername = "localhost";
            $username = "owner01";
            $password = "123456";
            $dbname = "Fraus";

            $conn = mysqli_connect($servername, $username, $password, $dbname);

            if(!$conn){
                die("失敗".mysqli_connect_error());
            }

            $sql = "DELETE FROM product WHERE ID = '$p_ID'";

            if(mysqli_query($conn, $sql)){
                echo '{"state" : true, "message" : "刪除成功"}';
            }else{
                echo '{"state" : false, "message" : "刪除失敗"}';
            }
            mysqli_close($conn);
        }else{
            echo '{"state" : false, "message" : "傳遞參數格式錯誤!"}';
        }

    }else{
        echo '{"state" : false, "message" : "未傳遞任何參數!"}';
    }

?>