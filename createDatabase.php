<?php
include "migration.php";

function exeQuery($string)
{
  global $connection;
  $query = $string;
  $exe = mysqli_query($connection, $query);
  if (!$exe) {
    die(mysqli_error($connection));
  }
}

exeQuery("CREATE DATABASE IF NOT EXISTS bakery DEFAULT CHARACTER SET UTF8;");
exeQuery("USE bakery;");
$query = "CREATE TABLE IF NOT EXISTS customer(id BIGINT NOT NULL AUTO_INCREMENT, first_name VARCHAR (250), ";
$query .= "last_name VARCHAR (250), family INT(50) NOT NULL, active INT(1) NOT NULL, vip INT(1) NOT NULL, ";
$query .= "remaining INT(50) NOT NULL, total INT(50) NOT NULL, PRIMARY KEY (id));";
exeQuery($query);
exeQuery("ALTER TABLE customer AUTO_INCREMENT = 5050505050;");
exeQuery("CREATE TABLE IF NOT EXISTS bank (money BIGINT NOT NULL, date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP);");
exeQuery("CREATE TABLE IF NOT EXISTS bread(price INT(50) NOT NULL, date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP);");
exeQuery("CREATE TABLE IF NOT EXISTS transaction (cid BIGINT NOT NULL, amount INT(50), price INT(50) NOT NULL, date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP);");
exeQuery("CREATE TABLE IF NOT EXISTS donation (cid BIGINT NOT NULL, amount INT (10) NOT NULL, date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP);");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>سامانه مدیریت سهمیه نان | مقداردهی</title>

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
            <input class="btn btn-success form-control" type="submit" name="create-db" value="مقداردهی دیتابیس"
                   formaction="initDatabase">
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