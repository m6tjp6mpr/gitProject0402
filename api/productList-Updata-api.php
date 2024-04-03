<?php
    //input: {"ID":"1","Pname":"奶茶", "Price":"50"}
    // output:
    // {"state" : true, "message" : "更新成功!"}
    // {"state" : false, "message" : "更新失敗!"}
    // {"state" : false, "message" : "傳遞參數格式錯誤!"}
    // {"state" : false, "message" : "未傳遞任何參數!"}

    $data = file_get_contents("php://input", "r"); //讀外部丟給php的東西
    if($data != ""){
        $mydata = array(); // php宣告陣列的方法
        $mydata = json_decode($data, true); //轉換成json的方法，左邊是要轉的資料，右邊要寫true

        if(isset($mydata["ID"]) && isset($mydata["Pname"]) && isset($mydata["Price"]) && isset($mydata["Num"]) && isset($mydata["Type"]) && isset($mydata["Intro"]) && isset($mydata["Photo"]) && isset($mydata["Home"]) && isset($mydata["Sell"]) && $mydata["ID"] != "" && $mydata["Pname"] != "" && $mydata["Price"] != "" && $mydata["Num"] != "" && $mydata["Type"] != "" && $mydata["Intro"] != "" && $mydata["Photo"] != "" && $mydata["Home"] != "" && $mydata["Sell"] != ""){

            $p_ID = $mydata["ID"];
            $p_Pname = $mydata["Pname"];
            $p_Price = $mydata["Price"];
            $p_Num = $mydata["Num"];
            $p_Type = $mydata["Type"];
            $p_Intro = $mydata["Intro"];
            $p_Photo = $mydata["Photo"];
            $p_Home = $mydata["Home"];
            $p_Sell = $mydata["Sell"];

            $servername = "localhost";
            $username = "owner01";
            $password = "123456";
            $dbname = "Fraus";

            $conn = mysqli_connect($servername, $username, $password, $dbname);

            if(!$conn){
                die("失敗".mysqli_connect_error());
            }

            $sql = "UPDATE product SET Pname = '$p_Pname', Price = '$p_Price', Num = '$p_Num', Type = '$p_Type', Intro = '$p_Intro', Photo = '$p_Photo', Home = '$p_Home', Sell = '$p_Sell' WHERE ID = '$p_ID'";

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