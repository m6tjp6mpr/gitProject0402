// 前台註冊用
var flag_account = false;
var flag_username = false;
var flag_password = false;
var flag_re_password = false;
var flag_email = false;
var flag_phone = false;
var flag_chk01 = false;
$(function () {

    //即時監聽account
    $("#account").bind("input propertychange", function () {
        if ($(this).val().length > 3 && $(this).val().length < 9) {
            //字數合規定，傳遞至後端
            var dataJSON = {};
            dataJSON["Account"] = $("#account").val();
            // console.log(JSON.stringify(dataJSON));

            $.ajax({
                type: "POST",
                url: "member-CheckAccount-api.php",
                data: JSON.stringify(dataJSON),
                dataType: "json",
                success: showdata_check_account,
                error: function () {
                    alert("error-member-CheckAccount-api.php");
                }
            })
            // $(this).removeClass("is-invalid");
            // $(this).addClass("is-valid");
            // flag_username = true;
        } else {
            //字數不合規定
            $(this).removeClass("is-valid");
            $(this).addClass("is-invalid");
            $("#account").next().next().text("字數不可");
            flag_account = false;
        }
    });

    //即時監聽username
    $("#username").bind("input propertychange", function () {
        if ($(this).val().length > 1 && $(this).val().length < 11) {
            $(this).removeClass("is-invalid");
            $(this).addClass("is-valid");
            flag_username = true;
        } else {
            $(this).removeClass("is-valid");
            $(this).addClass("is-invalid");
            flag_username = false;
        }
    });

    //即時監聽password
    $("#password").bind("input propertychange", function () {
        if ($(this).val().length > 4 && $(this).val().length < 11) {
            $(this).removeClass("is-invalid");
            $(this).addClass("is-valid");
            flag_password = true;
        } else {
            $(this).removeClass("is-valid");
            $(this).addClass("is-invalid");
            flag_password = false;
        }
    });

    //即時監聽re_password
    $("#re_password").bind("input propertychange", function () {
        if ($(this).val() == $("#password").val()) {
            $(this).removeClass("is-invalid");
            $(this).addClass("is-valid");
            flag_re_password = true;
        } else {
            $(this).removeClass("is-valid");
            $(this).addClass("is-invalid");
            flag_re_password = false;
        }
    });

    //即時監聽email
    $("#email").bind("input propertychange", function () {
        if ($(this).val().length > 4 && $(this).val().length < 20) {
            $(this).removeClass("is-invalid");
            $(this).addClass("is-valid");
            flag_email = true;
        } else {
            $(this).removeClass("is-valid");
            $(this).addClass("is-invalid");
            flag_email = false;
        }
    });

    //即時監聽phone
    $("#phone").bind("input propertychange", function () {
        if ($(this).val().length > 8 && $(this).val().length < 11) {
            $(this).removeClass("is-invalid");
            $(this).addClass("is-valid");
            flag_phone = true;
        } else {
            $(this).removeClass("is-valid");
            $(this).addClass("is-invalid");
            flag_phone = false;
        }
    });

    //即時監聽 checkbox chk01
    $("#chk01").change(function () {
        if ($(this).is(":checked")) {
            flag_chk01 = true;
        } else {
            flag_chk01 = false;
        }
    });

    //監聽 reg_btn
    $("#reg_btn").click(function () {
        if (flag_account && flag_username && flag_password && flag_re_password && flag_email && flag_phone && flag_chk01) {
            var dataJSON = {};
            dataJSON["Account"] = $("#account").val();
            dataJSON["Username"] = $("#username").val();
            dataJSON["Password"] = $("#password").val();
            dataJSON["Email"] = $("#email").val();
            dataJSON["Phone"] = $("#phone").val();
            dataJSON["Grade"] = "40";
            // console.log(JSON.stringify(dataJSON));

            //傳遞至後端
            $.ajax({
                type: "POST",
                url: "memberList-Create-api.php",
                data: JSON.stringify(dataJSON),
                dataType: "json",
                success: showdata,
                error: function () {
                    alert("error-memberList-Create-api.php");
                }
            });
        } else {
            alert("欄位錯誤");
        }
    });

});

function showdata(data) {
    // console.log(data);
    if (data.state) {
        alert(data.message);
        location.href = "front-home.html";
    } else {
        alert(data.message);
    }
}

function showdata_check_account(data) {
    // console.log(data);
    if (data.state) {
        //帳號不存在，可使用
        $("#account").removeClass("is-invalid");
        $("#account").addClass("is-valid");
        $("#account").next().text("帳號不存在，可使用");
        flag_account = true;
    } else {
        //帳號存在，不可使用
        $("#account").removeClass("is-valid");
        $("#account").addClass("is-invalid");
        $("#account").next().next().text("帳號存在，不可使用");
        flag_account = false;
    }
}