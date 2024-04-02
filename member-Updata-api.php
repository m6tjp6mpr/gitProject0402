<?php
    //input: {"ID":"1", "Username":"XX", "Password":"XXX", "Email":"XXXXX"}
    // output:
    // {"state" : true,  "message" : "更新成功!"}
    // {"state" : false, "message" : "更新失敗!"}
    // {"state" : false, "message" : "傳遞參數格式錯誤!"}
    // {"state" : false, "message" : "未傳遞任何參數!"}

    $data = file_get_contents("php://input", "r"); //讀外部丟給php的東西
    if($data != ""){
        $mydata = array(); // php宣告陣列的方法
        $mydata = json_decode($data, true); //轉換成json的方法，左邊是要轉的資料，右邊要寫true

        if(isset($mydata["ID"]) && isset($mydata["Username"]) && isset($mydata["Email"]) && isset($mydata["Phone"]) && $mydata["ID"] != "" && $mydata["Username"] != "" && $mydata["Email"] != "" && $mydata["Phone"] != ""){

            $p_ID = $mydata["ID"];
            $p_Username = $mydata["Username"];
            $p_Email = $mydata["Email"];
            $p_Phone = $mydata["Phone"];

            $servername = "localhost";
            $username = "owner01";
            $password = "123456";
            $dbname = "Fraus";

            $conn = mysqli_connect($servername, $username, $password, $dbname);

            if(!$conn){
                die("失敗".mysqli_connect_error());
            }

            $sql = "UPDATE member SET Username = '$p_Username', Email = '$p_Email', Phone = '$p_Phone' WHERE ID = '$p_ID'";

            if(mysqli_query($conn, $sql)){
                echo '{"state" : true, "message" : "更新成功"}';
            }else{
                echo '{"state" : false, "message" : "更新失敗"}';
            }
            mysqli_close($conn);
        }else{
            echo '{"state" : false, "message" : "傳遞參數格式錯誤!"}';
        }

    }else{
        echo '{"state" : false, "message" : "未傳遞任何參數!"}';
    }

?>