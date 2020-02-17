<?php
include "db1.php";
$i = 0;
$code = 5050505050;
$remaining = 200;
for (; $i < 150; $i = $i + 1) {
    if ($i < 50) {
        $family = rand(4, 7);
        $query = "INSERT INTO customer (id, active, family, remaining, total, vip) VALUES ('{$code}', 1, '{$family}', 200, 0, 1)";
        $code = $code + 1;
        $initDB = mysqli_query($connection, $query);
        if (!$initDB) {
            die(mysqli_error($connection));
        }
    } else {
        $family = rand(2, 4);
        $query = "INSERT INTO customer (id, active, family, remaining, total, vip) VALUES ('{$code}', 1, '{$family}', 200, 0, 0)";
        $code = $code + 1;
        $initDB = mysqli_query($connection, $query);
        if (!$initDB) {
            die(mysqli_error($connection));
        }
    }
}
$query = "INSERT INTO bread (price) VALUE (500)";
$initDB = mysqli_query($connection, $query);
if (!$initDB) {
    die(mysqli_error($connection));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>سامانه مدیریت سهمیه نان | راه‌اندازی</title>

  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="./stylesheets/stylesheet.css" rel="stylesheet">
  <script src="JsBarcode.all.min.js"></script>
</head>

<body>
<div class="container">
  <div class="col-lg-6 mx-auto mt-5">
    <div class="card card-border card-body">
      <div class="card-body">
        <h4 class="card-title mb-4 mt-1 text-right" id="price">
          راه‌اندازی
        </h4>
        <hr>
        <form action="" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <input class="btn btn-success form-control" type="submit" value="شروع"
                   formaction="index.php">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="persianTypeIndex.js"></script>
</body>
</html>
