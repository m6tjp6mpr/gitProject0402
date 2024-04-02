<?php
//input : {"UID01":"XXXXXXXXXXX"}

$data = file_get_contents("php://input", "r");
if($data != ""){
    $mydata = array(); // php宣告陣列的方法
    $mydata = json_decode($data, true); //轉換成json的方法，左邊是要轉的資料，右邊要寫true

    if(isset($mydata["UID01"]) && isset($mydata["UID02"]) && $mydata["UID01"] != "" && $mydata["UID02"] != ""){

        $p_UID01 = $mydata["UID01"];
        $p_UID02 = $mydata["UID02"];

        $servername = "localhost";
        $username = "owner01";
        $password = "123456";
        $dbname = "Fraus";

        $conn = mysqli_connect($servername, $username, $password, $dbname);

        if(!$conn){
            die("失敗".mysqli_connect_error());
        }

        $sql = "SELECT ID, Account, Username, Email, Phone, Grade, UID01, UID02 FROM member WHERE UID01 = '$p_UID01' AND UID02 = '$p_UID02' AND Useing = 'Y' AND (Grade = '10' OR Grade = '1')";
        $result = mysqli_query($conn, $sql);


        if(mysqli_num_rows($result)==1){
            //驗證成功
            $mydata = array();
            while($row = mysqli_fetch_assoc($result)){
                $mydata[] = $row;
            }
                    
                echo '{"state" : true, "data":'. json_encode($mydata).',   "message" : "驗證成功，可以登入!"}';
            }else{
            //驗證失敗
            echo '{"state" : false, "message" : "驗證失敗，不許登入"}';
        }
        mysqli_close($conn);
    }else{
        echo '{"state" : false, "message" : "傳遞參數格式錯誤"}';
    }

}else{
    echo '{"state" : false, "message" : "未傳遞任何參數"}';
}
?>