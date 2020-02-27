<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
include "entope.php";
include "functions.php";
updateBreadPrice();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>سامانه مدیریت سهمیه نان | ویرایش قیمت</title>

  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="./stylesheets/stylesheet.css" rel="stylesheet">
  <script src="JsBarcode.all.min.js"></script>
</head>
<body>
<div class="container">
  <div class="col-lg-6 col-md-6 col-sm-6 mx-auto mt-5">
    <div class="card card-body">
      <div class="card-body">
        <a href="edit.php" class="float-left btn btn-outline-dark">برگرد</a>
        <a href="logout.php" class="float-left btn btn-danger ml-1">خروج</a>
        <h4 class="card-title mb-4 mt-1 text-right">صفحه ویرایش</h4>
        <hr>
        <form action="" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label for="price" class="text-right">قیمت هر قرص نان</label>
            <input name="price" class="form-control" id="price" onkeypress="validate(event)"
                   placeholder="قیمت روز <?php echo convertNumbers(getBreadPrice(), true); ?> تومان">
          </div>
          <div class="form-group">
            <input class="btn btn-success form-control" type="submit" name="update-price"
                   value="بروزرسانی قیمت">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="ptEdit.js"></script>
<script>
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