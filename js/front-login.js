// 前台登入用
var MemberData = []; //縣市區資料
$(function () {

    //判斷是否登入
    if (getCookie("UID01") != "" && getCookie("UID02") != "") {
        //UID01存在，傳至後端api判斷是否正確
        var dataJSON = {};
        dataJSON["UID01"] = getCookie("UID01");
        dataJSON["UID02"] = getCookie("UID02");
        // console.log(JSON.stringify(dataJSON));
        $.ajax({
            type: "POST",
            url: "member-UIDLogin-api.php",
            data: JSON.stringify(dataJSON),
            dataType: "json",
            success: showdata_Check_UID,
            error: function () {
                alert("error-member-UIDLogin-api.php");
            }
        });
    }

    //監聽 login_btn
    $("#login_btn").click(function () {
        // console.log($("#login_username").val() + $("#login_password").val());
        var dataJSON = {};
        dataJSON["Account"] = $("#login_account").val();
        dataJSON["Password"] = $("#login_password").val();
        // console.log(JSON.stringify(dataJSON));

        $.ajax({
            type: "POST",
            url: "member-Login-api.php",
            data: JSON.stringify(dataJSON),
            dataType: "json",
            success: showdata_login,
            error: function () {
                alert("error-member-Login-api.php");
            }
        });
    });

});


function showdata_login(data) {
    // console.log(data);
    MemberData = data.data;
    // console.log(MemberData);
    if (data.state) {
        // alert(data.message);
        Swal.fire({
            title: "登入成功",
            showDenyButton: false,
            showCancelButton: false,
            confirmButtonText: "確認",
            denyButtonText: `Don't save`
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                // Swal.fire("Saved!", "", "success");
                location.href = "#";
            } else if (result.isDenied) {
                Swal.fire("Changes are not saved", "", "info");
            }
        });


        $("#loginModal").modal("hide");
        $("#user_message").text(data.data.Username + "登入中");
        $("#meun_login_btn").addClass("d-none");
        $("#meun_reg_btn").addClass("d-none");

        var uid01 = data.data.UID01;
        var uid02 = data.data.UID02;
        setCookie("UID01", uid01, 7);
        setCookie("UID02", uid02, 7);

        //顯示登出鈕
        $("#logout_btn").removeClass("d-none");

        //顯示管理按鈕
        if(data.data.Grade < 35){
            $("#manager_btn").removeClass("d-none");
        }
        // $("#manager_btn").removeClass("d-none");
    } else {
        alert(data.message);
    }
}

function showdata_Check_UID(data) {
    // console.log("test");
    // console.log(data);
    MemberData = data.data;
    // console.log(MemberData);
    if (data.state) {
        //驗證成功
        $("#user_message").text(data.data[0].Username + "登入中");
        $("#meun_login_btn").addClass("d-none");
        $("#meun_reg_btn").addClass("d-none");

        //顯示登出鈕
        $("#logout_btn").removeClass("d-none");

        //顯示管理按鈕
        if(data.data[0].Grade < 35){
            $("#manager_btn").removeClass("d-none");
        }
        // $("#manager_btn").removeClass("d-none");
    } else {

    }
}

//w3c
function setCookie(cname, cvalue, exdays) {
    const d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    let expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}