<?php

include "entope.php";
include "functions.php";

ob_start();
session_start();
buyBread();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>سامانه مدیریت سهمیه نان</title>

  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="./stylesheets/main.css">
  <script src="./JsBarcode.all.min.js"></script>
</head>

<body>
<div class="container">
  <div class="col-lg-6 mx-auto mt-5">
    <div class="card card-border card-body">
      <div class="card-body">
        <?php
        if (isset($_SESSION['username'])) {
          echo "<a href='edit' class='float-left btn btn-dark'>ویرایش</a>";
        } else {
          echo "<a href='login' class='float-left btn btn-outline-success ml-1'>ورود</a>";
        }
        ?>
        <h4 class="card-title mb-4 mt-1 text-right" id="price">
          قیمت نان
          <?php echo convertNumbers(getBreadPrice(), true); ?>
          تومان
        </h4>
        <hr>
        <form action="" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label for="code" class="text-right">کد</label>
            <input type="text" id="code" name="code" class="form-control" autofocus onkeyup="showPro(this.value);"
                   onkeypress="validate(event);">
          </div>
          <div class="form-group">
            <label for="amount" class="text-right">تعداد</label>
            <input class="form-control" id="amount" name="amount" onkeypress="validate(event)" onpaste="return false;"
                   required>
          </div>
          <div class="form-group">
            <label for="remaining" class="text-right">باقیمانده</label>
            <input disabled class="form-control" id="remaining" name="remaining"/>
          </div>
          <div>
            <img id="barcode" class="form-row">
          </div>
          <div class="form-group">
            <input class="btn btn-primary form-control" type="submit" name="buy-bread" value="ثبت">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="persianTypeIndex.js"></script>
<script>

    function changeBarcode(val) {
        if (val !== "") {
            JsBarcode("#barcode", val, {
                format: "code39",
                fontSize: 16,
                font: "Arial-black"
            });
        }
    }

    function validate(event) {
        var theEvent = event || window.event;

        if (theEvent.type === 'paste') {
            key = event.clipboardData.getData('text/plain');
        } else {
            var key = theEvent.keyCode || theEvent.which;
            key = String.fromCharCode(key);
        }
        var regex = /[0-9۰-۹]/;
        if (!regex.test(key)) {
            theEvent.returnValue = false;
            if (theEvent.preventDefault) theEvent.preventDefault();
        }
    }

    function showPro(val) {
        var xhttps;
        var enVal = val.toEnglishDigit();
        changeBarcode(enVal);

        xhttps = new XMLHttpRequest();
        xhttps.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                document.getElementById("remaining").value = this.responseText;
                document.getElementById("remaining").innerText = this.responseText;
                document.getElementById("remaining").style.direction = "ltr";
                if (this.responseText === "") {
                    document.getElementById("remaining").value = "کد نامتعبر است";
                    document.getElementById("remaining").innerText = "کد نامتعبر است";
                    document.getElementById("remaining").style.direction = "rtl";
                }
            }
        };
        xhttps.open("GET", "sth.php?q=" + val, true);
        xhttps.send();
    }
</script>
</body>
</html>