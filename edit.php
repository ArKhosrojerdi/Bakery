<?php
include "db1.php";
include "entope.php";

if (isset($_POST['update-price'])) {
    $new_price = $_POST['price'];
    $new_price = convertNumbers($new_price, false);
    if ($new_price !== "" || $new_price !== "0") {
        $query = "INSERT INTO bread (price) VALUE ('{$new_price}') ";
        $update_price = mysqli_query($connection, $query);
        if (!$update_price) {
            die(mysqli_error($connection));
        } else {
            $message = "قیمت هر قرص نان به‌روز شد.";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }
    } else {
        $message = "فیلد قیمت جدید خالی است.";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
}

if (isset($_POST['dominatebtn'])) {
    $domination_price = $_POST['domination'];
    $domination_price = convertNumbers($domination_price, false);
    if ($domination_price !== "") {
        $query = "INSERT INTO domination (value) VALUE ('{$domination_price}')";
        $dominate = mysqli_query($connection, $query);
        if (!$dominate) {
            die(mysqli_error($connection));
        } else {
            $query = "SELECT count(id) as cid FROM customer WHERE active = '1'";
            $count_actives = mysqli_query($connection, $query);
            if (!$count_actives) {
                die(mysqli_error($connection));
            } else {
                if ($row = mysqli_fetch_assoc($count_actives)) {
                    $c_act = $row['cid'];
                    $query = "SELECT price FROM bread ORDER BY date DESC LIMIT 1";
                    $select_price = mysqli_query($connection, $query);
                    if (!$select_price) {
                        die(mysqli_error($connection));
                    } else {
                        if ($row = mysqli_fetch_assoc($select_price)) {
                            $breads_dominate = $domination_price / ($c_act * $row['price']);
                            $query = "SELECT * FROM customer WHERE active = '1'";
                            $select_customers = mysqli_query($connection, $query);
                            if (!$select_customers) {
                                die(mysqli_error($connection));
                            } else {
                                while ($row1 = mysqli_fetch_assoc($select_customers)) {
                                    $cus_id = $row1['id'];
                                    $cus_rem = $row1['remaining'];
                                    $cus_rem = $cus_rem + $breads_dominate;
                                    $query = "SELECT remaining FROM customer WHERE id = '{$cus_id}'";
                                    $find_cus = mysqli_query($connection, $query);
                                    if (!$find_cus) {
                                        die(mysqli_error($connection));
                                    } else {
                                        if ($row_cus = mysqli_fetch_assoc($find_cus)) {
                                            $cus_rem = $row_cus['remaining'];
                                            $new_rem = $cus_rem + $breads_dominate;
                                            $query = "UPDATE customer SET remaining = {$new_rem} WHERE id = '{$cus_id}'";
                                            $upd_rem = mysqli_query($connection, $query);
                                            if (!$upd_rem) {
                                                die(mysqli_error($connection));
                                            }
                                        }
                                    }
                                }
                                $message = "کمک مالی لحاظ شد و تعداد مناسب به هر خانوار اضافه گردید.";
                                echo "<script type='text/javascript'>alert('$message');</script>";

                            }
                        }
                    }
                }
            }
        }
    } else {
        $message = "فیلد مبلغ اهدایی خالی است.";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }

}

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
  <div class="col-lg-6 col-md-9 col-sm-12 mx-auto mt-5">
    <div class="card card-body">
      <div class="card-body">
        <a href="index.php" class="float-left btn btn-secondary">برگرد</a>
        <h4 class="card-title mb-4 mt-1 text-right">صفحه ویرایش</h4>
        <hr>
        <form action="" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label for="price" class="text-right">قیمت هر قرص نان</label>
            <input name="price" class="form-control" id="price" onkeypress="validate(event)"
                   placeholder="قیمت روز <?php
                   $query = "SELECT price FROM bread ORDER BY date DESC LIMIT 1";
                   $select_price = mysqli_query($connection, $query);
                   if (!$select_price) {
                       die(mysqli_error($connection));
                   } else {
                       if ($row = mysqli_fetch_assoc($select_price)) {
                           $row['price'] = convertNumbers($row['price'], true);
                           echo $row['price'];
                       }
                   }
                   ?> تومان">
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

<div class="container">
  <div class="col-lg-6 col-md-9 col-sm-12 mx-auto mt-5">
    <div class="card card-body">
      <div class="card-body">
        <h4 class="card-title mb-4 mt-1 text-right">اهداییه</h4>
        <hr>
        <form action="" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label for="domination" class="text-right">مقدار کمک مالی به تومان</label>
            <input name="domination" class="form-control" id="domination" onkeypress="validate(event)">
          </div>
          <div class="form-group">
            <input class="btn btn-success form-control" type="submit" name="dominatebtn"
                   value="اضافه کردن به حساب">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!--<div class="container">-->
<!--  <div class="col-lg-6 col-md-9 col-sm-12 mx-auto mt-5 mb-5">-->
<!--    <div class="card card-body">-->
<!--      <div class="card-body">-->
<!--        <h4 class="card-title mb-4 mt-1 text-right">صفحه ویرایش</h4>-->
<!--        <hr>-->
<!--        <form action="" method="post" enctype="multipart/form-data">-->
<!--          <div class="form-group">-->
<!--            <label for="price" class="text-right">قیمت هر قرص نان</label>-->
<!--            <input name="price" class="form-control" id="" autofocus onkeypress="validate(event)">-->
<!--          </div>-->
<!---->
<!--        </form>-->
<!--        <form action="" method="post" enctype="multipart/form-data">-->
<!--          <div class="form-group">-->
<!--            <input class="btn btn-success form-control" type="submit" name="update-price"-->
<!--                   value="بروزرسانی قیمت">-->
<!--          </div>-->
<!--        </form>-->
<!--      </div>-->
<!--    </div>-->
<!--  </div>-->
<!--</div>-->

<!--<div class="container">-->
<!--  <div class="col-lg-6 col-md-9 col-sm-12 mx-auto mt-5 mb-5">-->
<!--    <div class="card card-body">-->
<!--      <div class="card-body">-->
<!--        <h4 class="card-title mb-4 mt-1 text-right">صفحه ویرایش</h4>-->
<!--        <hr>-->
<!--        <form action="" method="post" enctype="multipart/form-data">-->
<!--          <div class="form-group">-->
<!--            <label for="help" class="text-right">مقدار کمک مالی (تومان)</label>-->
<!--            <input name="help" class="form-control" id="" onkeypress="validate(event)">-->
<!--          </div>-->
<!--          <div class="form-group">-->
<!--            <input class="btn btn-success form-control" type="submit" name="help-money"-->
<!--                   value="اضافه کردن به حساب">-->
<!--          </div>-->
<!--        </form>-->
<!--      </div>-->
<!--    </div>-->
<!--  </div>-->
<!--</div>-->

<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="persianTypeEdit.js"></script>
<script>
    function validate(event) {
        var theEvent = event || window.event;

        if (theEvent.type === 'paste') {
            key = event.clipboardData.getData('text/plain');
        } else {
            var key = theEvent.keyCode || theEvent.which;
            key = String.fromCharCode(key);
        }
        var regex = /[0-9,۰-۹]|\./;
        if (!regex.test(key)) {
            theEvent.returnValue = false;
            if (theEvent.preventDefault) theEvent.preventDefault();
        }
    }
</script>
</body>
</html>