<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
include "entope.php";
include "functions.php";

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

<nav id="nav-cus" class="navbar fixed-top" hidden>
  <label class="nav nav-item mx-auto"> نان کمک کنید &nbsp;<span id="t_bread"></span>&nbsp; شما می‌توانید </label>
</nav>

<nav id="nav-ext" class="navbar fixed-bottom" hidden>
  <label class="nav nav-item mx-auto">
    <span id="extra">&nbsp;</span><span style="direction: rtl; text-align: right">باقیمانده: </span>
  </label>
</nav>

<!--<div class="container">-->
<!--  <div class="col-lg-6 col-md-9 col-sm-12 mx-auto mt-5">-->
<!--    <div class="card card-body">-->
<!--      <div class="card-body">-->
<!--        <h4 class="card-title mb-4 mt-1 text-right">اهداییه</h4>-->
<!--        <hr>-->
<!--        <form action="" method="post" enctype="multipart/form-data">-->
<!--          <div class="form-group">-->
<!--            <label for="donation" class="text-right">مقدار کمک مالی به تومان</label>-->
<!--            <input name="donation" class="form-control" id="donation" onkeypress="validate(event)">-->
<!--          </div>-->
<!--          <div class="form-group">-->
<!--            <input class="btn btn-success form-control" type="submit" name="donatebtn"-->
<!--                   value="اضافه کردن به حساب">-->
<!--          </div>-->
<!--        </form>-->
<!--      </div>-->
<!--    </div>-->
<!--  </div>-->
<!--</div>-->

<div class="mx-auto" style="width: 95% !important;">
  <div class="mt-5">
    <div class="card card-body">
      <div class="card-body">
        <a href="index.php" class="float-left btn btn-outline-dark">برگرد</a>
        <a href="editBreadPrice.php" class="float-left btn btn-outline-dark ml-1">قیمت نان</a>
        <a href="addMember.php" class="float-left btn btn-outline-dark ml-1">اضافه‌کردن خانوار</a>
        <a href="logout.php" class="float-left btn btn-danger ml-1">خروج</a>
        <h4 class="card-title mb-4 mt-1 text-right">اهداییه</h4>
        <hr>
        <form action="donate.php" method="post" enctype="multipart/form-data">

          <div class="col" style="direction: rtl">
            <div class="row text-right">
              <p class="details col-6"> تعداد کل خانوارها:
                  <?php getAllMembersCount(); ?>
              </p>
              <p class="details col-6"> تعداد کل خانوارهای فعال:
                  <?php getAllActiveMembersCount(); ?>
              </p>
            </div>
            <div class="row">
              <p class="details col-6"> تعداد خانوارهای VIP فعال:
                  <?php getVipActiveMembersCount(); ?>
              </p>
              <p class="details col-6">تعداد خانوار‌های VIP (کل):
                  <?php getAllVipMembersCount(); ?>
              </p>
            </div>
            <div class="row">
              <p class="details col-6"> تعداد خانوارهای عادی فعال:
                  <?php getNormalActiveMembersCount(); ?>
              </p>
              <p class="details col-6"> تعداد خانوارهای عادی (کل):
                  <?php getAllNormalMembersCount(); ?>
              </p>
            </div>
          </div>


          <div class="row" style="direction: rtl;">
            <div class="radio col-3">
              <label>وارد کردن مبلغ
                <input type="radio" name="cdon" id="mcd" onchange="showInputField()" checked>
              </label>
            </div>
            <div class="radio col-3">
              <label>وارد کردن تعداد
                <input type="radio" name="cdon" id="acd" onchange="showInputField()">
              </label>
            </div>

            <div>
              <input class="col-12 form-control" id="money_custom_donation" name="money_custom_donation"
                     onkeypress="validate(event);" onclick="this.select();"
                     placeholder="مبلغ را وارد کنید" onkeyup="fillFields(this.value);"
                     style="width: 100%; text-align: left; direction: ltr" onpaste="return false;">
              <input class="col-12 form-control " id="amount_custom_donation" name="amount_custom_donation"
                     onkeypress="validate(event);" onclick="this.select();"
                     placeholder="تعداد را وارد کنید" onkeyup="fillFieldsCount(this.value);"
                     style="width: 100%; text-align: left; direction: ltr" onpaste="return false;" hidden>
              <br>
            </div>
          </div>


          <table class="table table-bordered table-striped ">
            <tr>
              <th style="width: 5%;">VIP</th>
              <th style="width: 5%;">عائله</th>
              <th>نام خانوادگی</th>
              <th>نام</th>
              <th style="width: 12%;">کد</th>
              <th style="width: 8%;">.ت.ب</th>
              <th style="width: 10%;">تعداد</th>
              <th style="text-align: right; width: 3%; margin: 0"><input class="" type="checkbox" id="select_all_vip"
                                                                         onclick="toggleVipChecks();">
              </th>
              <th style="text-align: right; width: 3%; margin: 0"><input class="" type="checkbox" id="select_all"
                                                                         onclick="toggleAllChecks();">
              </th>
              <th style="text-align: right; width: 3%; margin: 0">فعال</th>
            </tr>
              <?php
              $query = "SELECT * FROM customer";
              $select_menu_items_vip = mysqli_query($connection, $query);
              while ($row = mysqli_fetch_assoc($select_menu_items_vip)) {
              if ($row['vip'] === '1') { ?>
            <tr>
              <td id="vip[<?php echo $row['id']; ?>]"><?php echo "<h5 style='color: #5cb85c'>&#10003;</h5>"; ?></td>
              <td id="family[<?php echo $row['id']; ?>]"><?php echo convertNumbers($row['family'], true); ?></td>
              <td><?php echo $row['last_name']; ?></td>
              <td><?php echo $row['first_name']; ?></td>
              <td><?php echo convertNumbers($row['id'], true); ?>
              <td><?php echo convertNumbers($row['remaining'], true); ?>
              <td><input class="form-control" type="text" name="donate_count[<?php echo $row['id']; ?>]"
                         id="donate_count[<?php echo $row['id']; ?>]" value="<?php
                  echo convertNumbers(0, true);
                  ?>" onkeypress="validate(event)" onclick="this.select();" onpaste="return false;" onkeyup="" disabled>
              </td>
              <td colspan="2"><input class="mx-auto" type="checkbox" name="donate_check[<?php echo $row['id']; ?>]"
                                     id="donate_check[<?php echo $row['id']; ?>]" onclick="toggleItems(this.id)"
                      <?php
                      if ($row['active'] === '0')
                          echo 'disabled';
                      ?>>
              </td>
              <td><input class="mx-auto" type="checkbox" name="active_check[<?php echo $row['id']; ?>]"
                         id="active_check[<?php echo $row['id']; ?>]" onclick="toggleActive(this.id)"
                  <?php
                  if ($row['active'] === '1')
                      echo 'checked';
                  ?>
              </td>
                <?php
                }
                }
                ?>
                <?php
                $select_menu_items = mysqli_query($connection, $query);
                while ($row = mysqli_fetch_assoc($select_menu_items)) {
                if ($row['vip'] === '0') { ?>
            <tr>
              <td><?php echo "<h5 style='color: red'>&#10008;</h5>"; ?></td>
              <td id="family[<?php echo $row['id']; ?>]"><?php echo convertNumbers($row['family'], true); ?></td>
              <td><?php echo $row['last_name']; ?></td>
              <td><?php echo $row['first_name']; ?></td>
              <td><?php echo convertNumbers($row['id'], true); ?>
              <td><?php echo convertNumbers($row['remaining'], true); ?>
              <td><input class="form-control" type="text" name="donate_count[<?php echo $row['id']; ?>]"
                         id="donate_count[<?php echo $row['id']; ?>]" value="<?php
                  echo convertNumbers(0, true);
                  ?>" onkeypress="validate(event)" onclick="this.select();" onpaste="return false;" disabled>
              </td>
              <td colspan="2"><input class="mx-auto" type="checkbox" name="donate_check[<?php echo $row['id']; ?>]"
                                     id="donate_check[<?php echo $row['id']; ?>]" onclick="toggleItems(this.id)"
                      <?php
                      if ($row['active'] === '0')
                          echo 'disabled';
                      ?>>
              </td>
              <td><input class="mx-auto" type="checkbox" name="active_check[<?php echo $row['id']; ?>]"
                         id="active_check[<?php echo $row['id']; ?>]" onclick="toggleActive(this.id)"
                      <?php
                      if ($row['active'] === '1')
                          echo 'checked';
                      ?>>
              </td>
                <?php
                }
                }
                ?>
          </table>
          <input class="form-control btn btn-primary" type="submit" name="exec" value="ثبت">
        </form>
      </div>
    </div>
  </div>
</div>

<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="persianTypeEdit.js"></script>
<script>
    var detailsLength = document.getElementsByClassName("details").length;
    for (var i = 0; i < detailsLength; i++)
        document.getElementsByClassName("details").item(i).innerHTML = document.getElementsByClassName("details").item(i).innerHTML.toPersianDigit();

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

    function toggleVipChecks() {
        var counter = 5050505050;
        var status = document.getElementById('select_all_vip').checked;

        for (var i = 0; i < <?php getAllActiveMembersCount(); ?>; i++) {
            var select_all_count = "donate_count[" + (counter + i) + "]";
            var select_vip_check = "donate_check[" + (counter + i) + "]";
            var select_all_active = "active_check[" + (counter + i) + "]";
            var select_vip = "vip[" + counter + "]";
            var inputs = document.getElementById(select_all_count);
            var checks = document.getElementById(select_vip_check);
            var active = document.getElementById(select_all_active);
            var vip = document.getElementById(select_vip);
            if (vip !== null && active.checked) {
                inputs.value = "۰";
                inputs.disabled = !status;
                checks.checked = status;
            }
        }

        if (document.getElementById("mcd").checked)
            fillFields(document.getElementById("money_custom_donation").value);
        if (document.getElementById("acd").checked) {
            fillFieldsCount();
        }
    }


    function toggleAllChecks() {
        var counter = 5050505050;
        var status = document.getElementById('select_all').checked;
        document.getElementById('select_all_vip').checked = status;
        toggleVipChecks();

        for (var i = 0; i < <?php getAllActiveMembersCount(); ?>; i++) {
            var select_all_count = "donate_count[" + (counter + i) + "]";
            var select_all_check = "donate_check[" + (counter + i) + "]";
            var select_all_active = "active_check[" + (counter + i) + "]";
            var inputs = document.getElementById(select_all_count);
            var checks = document.getElementById(select_all_check);
            var active = document.getElementById(select_all_active);
            if (active.checked) {
                inputs.value = "۰";
                inputs.disabled = !status;
                checks.checked = status;
            }
        }

        // fillFields(document.getElementById("money_custom_donation").value);
        if (document.getElementById("mcd").checked)
            fillFields(document.getElementById("money_custom_donation").value);
        // if (document.getElementById("acd").value !== "۰")
        //     fillFieldsCount();
        if (document.getElementById("acd").checked) {
            fillFieldsCount();
        }
    }


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

    function fillFields(val) {
        document.getElementById('nav-cus').hidden = document.getElementById('money_custom_donation').value === "";
        document.getElementById('nav-ext').hidden = document.getElementById('money_custom_donation').value === "";
        val = val.toEnglishDigit();

        let xhttps;
        xhttps = new XMLHttpRequest();
        xhttps.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                let id = 5050505050;
                document.getElementById("t_bread").innerText = this.responseText;
                let strBread = document.getElementById("t_bread").innerText;
                // Number of breads we can donate with value entered in the money_custom_donation
                let sbc = strBread.split(') ')[1];
                sbc = sbc.toEnglishDigit();

                let check, input, family, active, extra, flag = true, nAllMembers = 0;
                let fml = 0, nAllBreads = 0;
                for (var i = 0; i < <?php getAllActiveMembersCount(); ?>; i++) {
                    check = document.getElementById("donate_check[" + (id + i) + "]");
                    active = document.getElementById("active_check[" + (id + i) + "]");
                    if (check.checked && active.checked) {
                        family = document.getElementById("family[" + (id + i) + "]");
                        fml = family.innerText.toEnglishDigit();
                        fml = parseInt(fml, 10);
                        nAllMembers += fml;
                    }
                }
                for (i = 0; i < <?php getAllActiveMembersCount(); ?>; i++) {
                    check = document.getElementById("donate_check[" + (id + i) + "]");
                    active = document.getElementById("active_check[" + (id + i) + "]");
                    if (check.checked && active.checked) {
                        flag = false;
                        family = document.getElementById("family[" + (id + i) + "]");
                        fml = family.innerText.toEnglishDigit();
                        fml = parseInt(fml, 10);
                        var quotaForEachPerson = sbc * fml / nAllMembers;
                        quotaForEachPerson = parseInt(quotaForEachPerson, 10);
                        nAllBreads = nAllBreads + quotaForEachPerson;
                        input = document.getElementById("donate_count[" + (id + i) + "]");
                        input.value = quotaForEachPerson.toString().toPersianDigit();
                    }
                }
                extra = sbc - nAllBreads;
                extra = parseInt(extra, 10);
                if (this.responseText === "") {
                    document.getElementById("t_bread").innerText = "۰";
                } else {
                    if (flag) {
                        extra = sbc - nAllBreads;
                        extra = parseInt(extra, 10);
                        document.getElementById("extra").innerText = extra.toString().toPersianDigit();
                    } else if (extra !== undefined)
                        document.getElementById("extra").innerText = extra.toString().toPersianDigit();
                }
            }
        };
        xhttps.open("GET", "showNav.php?q=" + val, true);
        xhttps.send();
    }

    function fillFieldsCount() {
        document.getElementById("nav-ext").hidden = document.getElementById("amount_custom_donation").value === "";
        let id = 5050505050;

        let check, input, family, active, extra, flag = true, nAllMembers = 0;
        let fml = 0, nAllBreads = 0;
        let sbc = document.getElementById("amount_custom_donation").value.toEnglishDigit();
        for (var i = 0; i < <?php getAllActiveMembersCount(); ?>; i++) {
            check = document.getElementById("donate_check[" + (id + i) + "]");
            active = document.getElementById("active_check[" + (id + i) + "]");
            if (check.checked && active.checked) {
                family = document.getElementById("family[" + (id + i) + "]");
                fml = family.innerText.toEnglishDigit();
                fml = parseInt(fml, 10);
                nAllMembers += fml;
            }
        }
        for (i = 0; i < <?php getAllActiveMembersCount(); ?>; i++) {
            check = document.getElementById("donate_check[" + (id + i) + "]");
            active = document.getElementById("active_check[" + (id + i) + "]");
            if (check.checked && active.checked) {
                flag = false;
                family = document.getElementById("family[" + (id + i) + "]");
                fml = family.innerText.toEnglishDigit();
                fml = parseInt(fml, 10);
                var quotaForEachPerson = sbc * fml / nAllMembers;
                quotaForEachPerson = parseInt(quotaForEachPerson, 10);
                nAllBreads = nAllBreads + quotaForEachPerson;
                input = document.getElementById("donate_count[" + (id + i) + "]");
                input.value = quotaForEachPerson.toString().toPersianDigit();
            }
        }
        extra = sbc - nAllBreads;
        extra = parseInt(extra, 10);
        if (flag) {
            extra = sbc - nAllBreads;
            extra = parseInt(extra, 10);
            document.getElementById("extra").innerText = extra.toString().toPersianDigit();
        } else if (extra !== undefined)
            document.getElementById("extra").innerText = extra.toString().toPersianDigit();
    }

    function changeField() {

    }

    function toggleItems(dc) {
        var id = dc.substring(13, 23);
        console.log(id);
        var donate_count_str = "donate_count[" + id + "]";
        var family = "family[" + id + "]";
        console.log(family);
        var status = document.getElementById(donate_count_str).disabled;
        document.getElementById(donate_count_str).value = "۰";
        document.getElementById(donate_count_str).disabled = !status;
    }

    function showInputField() {
        var mcdStatus = document.getElementById("money_custom_donation").hidden;
        var acdStatus = document.getElementById("amount_custom_donation").hidden;
        if (!mcdStatus) {
            document.getElementById("money_custom_donation").hidden = !mcdStatus;
            document.getElementById("amount_custom_donation").value = "";
            document.getElementById("amount_custom_donation").hidden = !acdStatus;

        } else if (!acdStatus) {
            document.getElementById("amount_custom_donation").hidden = !acdStatus;
            document.getElementById("money_custom_donation").value = "";
            document.getElementById("money_custom_donation").hidden = !mcdStatus;
        }
        document.getElementById("nav-cus").hidden = true;
        document.getElementById("nav-ext").hidden = true;
    }

    function showHint(str) {
        if (str.length === 0) {
            document.getElementById("txtHint").innerHTML = "";
            return;
        } else {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState === 4 && this.status === 200) {
                }
            };
            xmlhttp.open("GET", "donate.php?q=" + str, true);
            xmlhttp.send();
        }
    }

    function toggleActive() {

    }

</script>
</body>
</html>