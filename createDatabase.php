<?php
include "db.php";

$query = "CREATE DATABASE IF NOT EXISTS bakery DEFAULT CHARACTER SET UTF8;";
$create_db = mysqli_query($connection, $query);
if (!$create_db) {
    die(mysqli_error($connection));
} else {
    $query = "USE bakery;";
    $useDB = mysqli_query($connection, $query);
    if (!$useDB) {
        die(mysqli_error($connection));
    } else {
        $query = "CREATE TABLE customer(id        CHAR(10)    NOT NULL, first_name VARCHAR (250), last_name VARCHAR (250), family INT(50) NOT NULL, active INT(1) NOT NULL, remaining INT(50) NOT NULL, total  INT(50)    NOT NULL, PRIMARY KEY (id));";
        $create_customer = mysqli_query($connection, $query);
        if (!$create_customer) {
            die(mysqli_error($connection));
        } else {
            $query = "CREATE TABLE bread(price        INT(50)    NOT NULL, date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP);";
            $create_bread = mysqli_query($connection, $query);
            if (!$create_bread) {
                die(mysqli_error($connection));
            } else {
                $query = "CREATE TABLE transaction (cid CHAR(10) NOT NULL, amount INT(50), price        INT(50)    NOT NULL, date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP);";
                $create_bread = mysqli_query($connection, $query);
                if (!$create_bread) {
                    die(mysqli_error($connection));
                } else {
                    $query = "CREATE TABLE domination (value INT(50) NOT NULL, money INT (1) NOT NULL, date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP);";
                    $create_dom = mysqli_query($connection, $query);
                    if (!$create_dom) {
                        die(mysqli_error($connection));
                    }
                }
            }
        }
    }
}
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
                   formaction="initDatabase.php">
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