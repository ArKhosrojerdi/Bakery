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

if (isset($_POST['donatebtn'])) {
    $domination_price = $_POST['donation'];
    $domination_price = convertNumbers($domination_price, false);
    if ($domination_price !== "") {
        $query = "INSERT INTO domination (value) VALUE ('{$domination_price}')";
        $donate = mysqli_query($connection, $query);
        if (!$donate) {
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
                            $breads_donate = $domination_price / ($c_act * $row['price']);
                            $query = "SELECT * FROM customer WHERE active = '1'";
                            $select_customers = mysqli_query($connection, $query);
                            if (!$select_customers) {
                                die(mysqli_error($connection));
                            } else {
                                while ($row1 = mysqli_fetch_assoc($select_customers)) {
                                    $cus_id = $row1['id'];
                                    $cus_rem = $row1['remaining'];
                                    $cus_rem = $cus_rem + $breads_donate;
                                    $query = "SELECT remaining FROM customer WHERE id = '{$cus_id}'";
                                    $find_cus = mysqli_query($connection, $query);
                                    if (!$find_cus) {
                                        die(mysqli_error($connection));
                                    } else {
                                        if ($row_cus = mysqli_fetch_assoc($find_cus)) {
                                            $cus_rem = $row_cus['remaining'];
                                            $new_rem = $cus_rem + $breads_donate;
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
            <label for="donation" class="text-right">مقدار کمک مالی به تومان</label>
            <input name="donation" class="form-control" id="donation" onkeypress="validate(event)">
          </div>
          <div class="form-group">
            <input class="btn btn-success form-control" type="submit" name="donatebtn"
                   value="اضافه کردن به حساب">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="container">
  <div class="col-lg-12 col-md-12 col-sm-12 mx-auto mt-5">
    <div class="card card-body">
      <div class="card-body">
        <h4 class="card-title mb-4 mt-1 text-right">اهداییه</h4>
        <hr>
        <form action="donate.php" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label for="custom_donation" class="text-right">کمک به تومان</label>
            <input class="form-control" id="custom_donation" name="custom_donation" onkeypress="validate(event)">
          </div>
          <table class="table table-bordered">
            <tr>
              <th>عائله</th>
              <th>نام خانوادگی</th>
              <th>نام</th>
              <th>کد</th>
              <th>تعداد باقیمانده</th>
              <th>تعداد</th>
              <th style="text-align: right"><input class="form-check-inline" type="checkbox" id="select_all" onclick="toggle()"></th>
            </tr>

              <?php
              $query = "SELECT * FROM customer";
              $select_menu_items = mysqli_query($connection, $query);
              while ($row = mysqli_fetch_assoc($select_menu_items)) { ?>
            <tr>
              <td><?php echo convertNumbers($row['family'], true); ?></td>
              <td><?php echo $row['last_name']; ?></td>
              <td><?php echo $row['first_name']; ?></td>
              <td><?php echo convertNumbers($row['id'], true); ?>
              <td><?php echo convertNumbers($row['remaining'], true); ?>
              <td><input class="form-control" type="text" name="donate_count"
                         id="donate_count[<?php echo $row['id']; ?>]" value="<?php
                  echo convertNumbers(0, true);
                  ?>" onkeypress="validate(event)" onclick="this.select();" disabled>
              </td>
              <td><input class="form-check-inline" type="checkbox" name="donate_check"
                         id="donate_check[<?php echo $row['id']; ?>]" onclick="toggleInput(this.id)"></td>
                <?php
                }
                ?>
          </table>
          <input class="form-control btn btn-primary" type="submit" value="ثبت">
        </form>
      </div>
    </div>
  </div>
</div>

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
        xhttps.open("GET", "don.php?q=" + val, true);
        xhttps.send();
    }

    function toggle() {
        var inputs = document.getElementsByName("donate_count");
        var checks = document.getElementsByName("donate_check");
        var status = document.getElementById('select_all').checked;

        for (var i = 0; i < inputs.length; i++) {
            inputs[i].disabled = !status;
            checks[i].checked = status;
        }
    }

    function toggleInput(dc) {
        var id = dc.substring(13, 23);
        var donate_count_str = "donate_count[" + id + "]";
        var status = document.getElementById(donate_count_str).disabled;
        if (!status) {
            document.getElementById(donate_count_str).value = '۰';
        }
        document.getElementById(donate_count_str).disabled = !status;

    }
</script>
</body>
</html>