<?php
    //input: {"Username":"XX", "Password":"XXX"}


    $data = file_get_contents("php://input", "r"); //讀外部丟給php的東西
    if($data != ""){
        $mydata = array(); // php宣告陣列的方法
        $mydata = json_decode($data, true); //轉換成json的方法，左邊是要轉的資料，右邊要寫true

        if(isset($mydata["Account"]) && isset($mydata["Password"]) &&  $mydata["Account"] != "" && $mydata["Password"] != "" ){

            $p_Account = $mydata["Account"];
            $p_Password = $mydata["Password"];

            $servername = "localhost";
            $username = "owner01";
            $password = "123456";
            $dbname = "Fraus";

            $conn = mysqli_connect($servername, $username, $password, $dbname);

            if(!$conn){
                die("失敗".mysqli_connect_error());
            }

            $sql = "SELECT Account, Password, Email FROM member WHERE Account = '$p_Account' AND Useing = 'Y'";
            $result = mysqli_query($conn, $sql);


            if(mysqli_num_rows($result)==1){
                //確認帳號符合，密碼不確定
                $row = mysqli_fetch_assoc($result);
                if(password_verify($p_Password, $row["Password"])){
                    //密碼比對正確，撈取不含密碼的使用者資料並產生uid
                    $uid01 = substr(hash("sha256", uniqid(time())), 0, 8);
                    $uid02 = substr(hash("sha512", uniqid(time())), 0, 8);
                    //更新uid至資料庫
                    $sql = "UPDATE member SET UID01 = '$uid01', UID02 = '$uid02' WHERE Account = '$p_Account'";
                    if(mysqli_query($conn, $sql)){
                        $sql = "SELECT Account, Username, Email, Phone, Grade, UID01, UID02 FROM member WHERE Account = '$p_Account'";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        $mydata = array();
                        $mydata = $row;

                        echo '{"state" : true, "data" : '. json_encode($mydata) . ',"message" : "登入成功"}';                        
                    }else{
                       //uid更新錯誤
                        echo '{"state" : false, "message" : "登入失敗,uid更新錯誤"}'; 
                    }



                }else{
                    //密碼比對錯誤
                    echo '{"state" : false, "message" : "登入失敗"}';
                }
            }else{
                //帳號不符合，登入失敗
                echo '{"state" : false, "message" : "登入失敗"}';
            }
            mysqli_close($conn);
        }else{
            echo '{"state" : false, "message" : "傳遞參數格式錯誤"}';
        }

    }else{
        echo '{"state" : false, "message" : "未傳遞任何參數"}';
    }

?>