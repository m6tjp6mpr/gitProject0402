<?php
    //input: {"Username":"XX"}


    $data = file_get_contents("php://input", "r"); //讀外部丟給php的東西
    if($data != ""){
        $mydata = array(); // php宣告陣列的方法
        $mydata = json_decode($data, true); //轉換成json的方法，左邊是要轉的資料，右邊要寫true

        if(isset($mydata["Account"]) &&  $mydata["Account"] != "" ){

            $p_Account = $mydata["Account"];

            $servername = "localhost";
            $username = "owner01";
            $password = "123456";
            $dbname = "Fraus";

            $conn = mysqli_connect($servername, $username, $password, $dbname);

            if(!$conn){
                die("失敗".mysqli_connect_error());
            }

            $sql = "SELECT * FROM member WHERE Account = '$p_Account'";
            // 也可寫成$sql = "SELECT Username FROM member WHERE Username = '$p_Username'";
            $result = mysqli_query($conn, $sql);

            if(mysqli_num_rows($result)==0){
                echo '{"state" : true, "message" : "帳號不存在, 可以使用"}';
            }else{
                echo '{"state" : false, "message" : "帳號已存在,不可以使用!"}';
            }
            mysqli_close($conn);
        }else{
            echo '{"state" : false, "message" : "傳遞參數格式錯誤"}';
        }

    }else{
        echo '{"state" : false, "message" : "未傳遞任何參數"}';
    }

?>