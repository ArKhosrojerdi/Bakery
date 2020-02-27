<?php
include "db1.php";

function getBreadPrice()
{
    global $connection;
    $query = "SELECT price FROM bread ORDER BY date DESC LIMIT 1";
    $select_price = mysqli_query($connection, $query);
    if (!$select_price) {
        die(mysqli_error($connection));
    } else {
        if ($row = mysqli_fetch_assoc($select_price)) {
//            $row['price'] = convertNumbers($row['price'], true);
            return $row['price'];
        }
    }
}

function updateBreadPrice()
{
    global $connection;
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
}

function buyBread()
{
    global $connection;
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
                        }
                        $query = "SELECT total as t FROM customer WHERE id = '{$customer_id}'";
                        $select_total = mysqli_query($connection, $query);
                        if ($row = mysqli_fetch_assoc($select_total)) {
                            $total = $row['t'];
                            $total += $amount;
                            $query = "UPDATE customer SET total = '{$total}' WHERE id = '{$customer_id}'";
                            $update_total = mysqli_query($connection, $query);
                            if (!$update_total)
                                die(mysqli_error($connection));
                        }
                        $query = "SELECT price FROM bread ORDER BY date DESC LIMIT 1";
                        $select_price = mysqli_query($connection, $query);
                        if (!$select_price) {
                            die(mysqli_error($connection));
                        }
                        if ($row = mysqli_fetch_assoc($select_price)) {
                            $query = "INSERT INTO transaction(cid, amount, price) VALUES ('{$customer_id}', '{$amount}', '{$row['price']}')";
                            $transaction = mysqli_query($connection, $query);
                            if (!$transaction) {
                                die(mysqli_error($connection));
                            }
                            $message = "خرید با موفقیت انجام شد.";
                            echo "<script type='text/javascript'>alert('$message');</script>";
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
}

function getAllActiveMembersCount()
{
    global $connection;
    $query = "SELECT count(distinct id) as cm FROM customer WHERE active = '1'";
    $getAllActiveMembers = mysqli_query($connection, $query);
    if ($row = mysqli_fetch_assoc($getAllActiveMembers))
        echo $row['cm'];
}

function getVipActiveMembersCount()
{
    global $connection;
    $query = "SELECT count(distinct id) as cm FROM customer WHERE active = '1' and vip = '1'";
    $getAllActiveMembers = mysqli_query($connection, $query);
    if ($row = mysqli_fetch_assoc($getAllActiveMembers))
        echo $row['cm'];
}

function getNormalActiveMembersCount()
{
    global $connection;
    $query = "SELECT count(distinct id) as cm FROM customer WHERE active = '1' and vip = '0'";
    $getAllActiveMembers = mysqli_query($connection, $query);
    if ($row = mysqli_fetch_assoc($getAllActiveMembers))
        echo $row['cm'];
}

function getAllMembersCount()
{
    global $connection;
    $query = "SELECT count(distinct id) as cm FROM customer";
    $getAllActiveMembers = mysqli_query($connection, $query);
    if ($row = mysqli_fetch_assoc($getAllActiveMembers))
        echo $row['cm'];
}

function getAllVipMembersCount()
{
    global $connection;
    $query = "SELECT count(distinct id) as cm FROM customer WHERE vip = '1'";
    $getAllActiveMembers = mysqli_query($connection, $query);
    if ($row = mysqli_fetch_assoc($getAllActiveMembers))
        echo $row['cm'];
}

function getAllNormalMembersCount()
{
    global $connection;
    $query = "SELECT count(distinct id) as cm FROM customer WHERE vip = '0'";
    $getAllActiveMembers = mysqli_query($connection, $query);
    if ($row = mysqli_fetch_assoc($getAllActiveMembers))
        echo $row['cm'];
}

function getStore() {
    global $connection;
    $query = "SELECT sum(money) as bank FROM store;";
    $get_bank = mysqli_query($connection, $query);
    if ($row = mysqli_fetch_assoc($get_bank))
        echo $row['bank'];
}