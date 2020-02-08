<?php
include "db1.php";
include "entope.php";

if (isset($_POST['buy-bread'])) {
    $customer_id = $_POST['code'];
    $amount = $_POST['amount'];
    $amount = convertNumbers($amount, false);
    $customer_id = convertNumbers($customer_id, false);
    if ($customer_id != "" || $amount != "" || $amount !== "0" || $customer_id !== "0") {
        if (strlen($customer_id) == 10) {
            $query = "SELECT remaining FROM customer WHERE id = '{$customer_id}'";
            $q = mysqli_query($connection, $query);
            $row = mysqli_fetch_assoc($q);
            if ($row['remaining'] !== "") {
                if ($row['remaining'] >= $amount) {
                    $remaining = $row['remaining'] - $amount;
                    $query = "UPDATE customer SET remaining = {$remaining} WHERE id = '{$customer_id}'";
                    $buy = mysqli_query($connection, $query);
                    if (!$buy) {
                        die(mysqli_error($connection));
                    } else {
                        $query = "SELECT price FROM bread ORDER BY date DESC LIMIT 1";
                        $select_price = mysqli_query($connection, $query);
                        if (!$select_price) {
                            die(mysqli_error($connection));
                        } else {
                            if ($row = mysqli_fetch_assoc($select_price)) {
                                $query = "INSERT INTO transaction(cid, amount, price) VALUES ('{$customer_id}', '{$amount}', '{$row['price']}')";
                                $transaction = mysqli_query($connection, $query);
                                if (!$transaction) {
                                    die(mysqli_error($connection));
                                } else {
                                    $message = "خرید با موفقیت انجام شد.";
                                    echo "<script type='text/javascript'>alert('$message');</script>";
                                }
                            }
                        }
                    }
                } else {
                    $message = "تعداد انتخاب شده در محدوده مجاز نمی‌باشد و ";
                    $message .= "شما حداکثر می‌توانید {$row['remaining']} نان خریداری نمایید.";
                    echo "<script type='text/javascript'>alert('$message');</script>";
                }
            } else {
                $message = "کد در دیتابیس موجود نیست.";
                echo "<script type='text/javascript'>alert('$message');</script>";
            }
        } else {
            $message = "تعداد ارقام کد، نامعتبر است. (کد باید ۱۰ رقمی باشد)";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }
    } else {
        $message = "لطفا همه فیلدها را پر نمایید!";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>سامانه مدیریت سهمیه نان</title>

  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="./stylesheets/stylesheet.css" rel="stylesheet">
  <script src="./JsBarcode.all.min.js"></script>
</head>

<body>
<div class="container">
  <div class="col-lg-6 mx-auto mt-5">
    <div class="card card-border card-body">
      <div class="card-body">
        <a href="edit.php" class="float-left btn btn-secondary">ویرایش</a>
        <h4 class="card-title mb-4 mt-1 text-right" id="price">
          قیمت نان
            <?php
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
            ?>
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
            <input class="form-control" id="amount" name="amount" onkeypress="validate(event)">
          </div>
          <div class="form-group">
            <label for="remaining" class="text-right">باقیمانده</label>
            <input disabled class="form-control" id="remaining" name="remaining"/>
          </div>
          <div>
            <svg id="barcode" class="form-row"></svg>
          </div>
          <div class="form-group">
            <input class="btn btn-success form-control" type="submit" name="buy-bread" value="ثبت">
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
                displayValue: true,
                height: 70,
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
        var regex = /[0-9,۰-۹]|\./;
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