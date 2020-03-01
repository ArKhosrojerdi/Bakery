<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login");
    exit();
}
include "entope.php";
include "functions.php";

if (isset($_POST['add_member'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $family = $_POST['family'];
    $family = convertNumbers($family, false);
    if (isset($_POST['vip_check'])) $vip = 1;
    else $vip = 0;
    if (isset($_POST['active_check'])) $active = 1;
    else $active = 0;

    $remaining = $_POST['remaining'];
    $remaining = convertNumbers($remaining, false);
    $query = "INSERT INTO customer (first_name, last_name, family, active, vip, remaining, total) ";
    $query .= "VALUES ('{$first_name}', '{$last_name}', '{$family}', '{$active}', '{$vip}', '{$remaining}', 0);";
    $addMember = mysqli_query($connection, $query);
    if (!$addMember) {
        die(mysqli_error($connection));
    }
    header("Location: addMember");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>سامانه مدیریت سهمیه نان | ویرایش قیمت</title>

  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="./stylesheets/main.css">
  <script src="JsBarcode.all.min.js"></script>
</head>
<body>

<div class="mx-auto" style="width: 75% !important;">
  <div class="mt-5">
    <div class="card card-body">
      <div class="card-body">
        <a href="index" class="float-left btn btn-outline-dark">برگرد</a>
        <a href="editBreadPrice" class="float-left btn btn-outline-dark ml-1">قیمت نان</a>
        <a href="edit" class="float-left btn btn-outline-dark ml-1">صفحه اهدا</a>
        <a href="logout" class="float-left btn btn-danger ml-1">خروج</a>
        <h4 class="card-title mb-4 mt-1 text-right">اضافه‌کردن خانوار</h4>
        <hr>

        <?php include "customersStats.php";?>
        <form action="addMember" method="post" enctype="multipart/form-data">
          <table class="table table-bordered table-striped ">
            <tr>
              <th style="width: 5%;">VIP</th>
              <th style="width: 10%;">عائله</th>
              <th style="width: 30%">نام خانوادگی</th>
              <th style="width: 20%">نام</th>
              <th style="width: 8%;">.ت.ب</th>
              <th style="text-align: right; width: 3%; margin: 0">فعال</th>
            </tr>

            <tr>
              <td><input class="mx-auto" type="checkbox" name="vip_check" id="vip_check"></td>
              <td><input class="form-control" type="text" name="family" id="family" value="۳" required
                         oninvalid="this.setCustomValidity('تعداد اعضای هر خانوار را وارد کنید.')"
                         oninput="setCustomValidity('')"></td>
              <td><input style="direction: rtl; text-align: right;" class="form-control" type="text" name="last_name"
                         id="last_name" onpaste="return false;" required
                         oninvalid="this.setCustomValidity('نام خانوادگی را وارد کنید.')"
                         oninput="setCustomValidity('')"></td>
              <td><input style="direction: rtl; text-align: right;" class="form-control" type="text" name="first_name"
                         id="first_name" value="" onpaste="return false;" required
                         oninvalid="this.setCustomValidity('نام را وارد کنید.')"
                         oninput="setCustomValidity('')"></td>
              <td><input class="form-control" type="text" name="remaining"
                         id="remaining" value="۲۰۰" onkeypress="validate(event)" onpaste="return false;" required
                         oninvalid="this.setCustomValidity('تعداد سهمیه اولیه نان را وارد کنید.')"
                         oninput="setCustomValidity('')"></td>
              <td><input class="mx-auto" type="checkbox" name="active_check" id="active_check" checked></td>
          </table>
          <input class="form-control btn btn-primary" type="submit" name="add_member" value="اضافه‌کردن">
        </form>
      </div>
    </div>
  </div>
</div>

<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="persianTypeAddMembers.js"></script>
<script>
    var detailsLength = document.getElementsByClassName("details").length;
    var item = document.getElementsByClassName("details");
    for (let i = 0; i < detailsLength; i++)
        item.item(i).innerHTML = item.item(i).innerHTML.toPersianDigit();

    String.prototype.toEnglishDigit = function () {
        var find = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        var replace = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        var replaceString = this;
        var regex;
        for (var i = 0; i < find.length; i++) {
            regex = new RegExp(find[i], "g");
            replaceString = replaceString.replace(regex, replace[i]);
        }
        return replaceString;
    };


    function validate(event) {
        let theEvent = event || window.event;

        if (theEvent.type === 'paste') {
            key = event.clipboardData.getData('text/plain');
        } else {
            var key = theEvent.keyCode || theEvent.which;
            key = String.fromCharCode(key);
        }

        let regex = /[0-9۰-۹]/;
        if (!regex.test(key)) {
            theEvent.returnValue = false;
            if (theEvent.preventDefault) {
                theEvent.preventDefault();
            }
        }
    }

</script>
</body>
</html>