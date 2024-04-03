<?php
    //input: {"Pname":"奶茶", "Price":"50", "Sugar":"全糖", "Num":"10", "Delivery":"true", "Added":"不要", "Pay":"現金", "Total":"500"}
    // $data = '{"Pname":"奶茶", "Price":"500", "Sugar":"全糖", "Num":"10", "Delivery":"true", "Added":"不要", "Pay":"現金", "Total":"500"}';

    $data = file_get_contents("php://input", "r"); //讀外部丟給php的東西
    if($data != ""){
        $mydata = array(); // php宣告陣列的方法
        $mydata = json_decode($data, true); //轉換成json的方法，左邊是要轉的資料，右邊要寫true

        if(isset($mydata["Pname"]) && isset($mydata["Price"]) && isset($mydata["Num"]) && isset($mydata["Type"]) && isset($mydata["Intro"]) && isset($mydata["Photo"]) && isset($mydata["Home"]) && isset($mydata["Sell"]) && $mydata["Pname"] != "" && $mydata["Price"] != "" && $mydata["Num"] != "" && $mydata["Type"] != "" && $mydata["Intro"] != "" && $mydata["Photo"] != "" && $mydata["Home"] != "" && $mydata["Sell"] != "" ){

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

            $sql = "INSERT INTO product(Pname, Price, Num, Type, Intro, Photo, Home, Sell) VALUES ('$p_Pname','$p_Price', '$p_Num', '$p_Type', '$p_Intro', '$p_Photo', '$p_Home', '$p_Sell')";

            if(mysqli_query($conn, $sql)){
                echo '{"state" : true, "message" : "新增成功"}';
            }else{
                echo '{"state" : false, "message" : "新增失敗"}';
            }
            mysqli_close($conn);
        }else{
            echo '{"state" : false, "message" : "格式錯"}';
        }

    }else{
        echo '{"state" : false, "message" : "沒資料"}';
    }

?>