<?php
    //input: {"Username":"XX", "Password":"XXX", "Email":"XXXXX"}


    $data = file_get_contents("php://input", "r"); //讀外部丟給php的東西
    if($data != ""){
        $mydata = array(); // php宣告陣列的方法
        $mydata = json_decode($data, true); //轉換成json的方法，左邊是要轉的資料，右邊要寫true

        if(isset($mydata["Account"]) && isset($mydata["Username"]) && isset($mydata["Password"]) && isset($mydata["Email"]) && isset($mydata["Phone"]) && isset($mydata["Grade"]) && $mydata["Account"] != "" && $mydata["Username"] != "" && $mydata["Password"] != "" && $mydata["Email"] != "" && $mydata["Phone"] != "" && $mydata["Grade"] != "" ){

            $p_Account = $mydata["Account"];
            $p_Username = $mydata["Username"];
            // $p_Password = $mydata["Password"];
            //密碼加密
            $p_Password = password_hash($mydata["Password"], PASSWORD_DEFAULT);
            $p_Email = $mydata["Email"];
            $p_Phone = $mydata["Phone"];
            $p_Grade = $mydata["Grade"];

            $servername = "localhost";
            $username = "owner01";
            $password = "123456";
            $dbname = "Fraus";

            $conn = mysqli_connect($servername, $username, $password, $dbname);

            if(!$conn){
                die("失敗".mysqli_connect_error());
            }

            $sql = "INSERT INTO member(Account, Username, Password, Email, Phone, Grade, Useing,  UID01, UID02) VALUES ('$p_Account', '$p_Username','$p_Password', '$p_Email', '$p_Phone', '$p_Grade', 'Y', '', '')";

            if(mysqli_query($conn, $sql)){
                echo '{"state" : true, "message" : "註冊成功"}';
            }else{
                echo '{"state" : false, "message" : "註冊失敗"}';
            }
            mysqli_close($conn);
        }else{
            echo '{"state" : false, "message" : "傳遞參數格式錯誤"}';
        }

    }else{
        echo '{"state" : false, "message" : "未傳遞任何參數"}';
    }

?>