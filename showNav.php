<?php
include "db1.php";
include "entope.php";

$q = $_REQUEST["q"];
$q = convertNumbers($q, false);

$query = "SELECT price FROM bread ORDER BY date DESC LIMIT 1";
$select_price = mysqli_query($connection, $query);
if (!$select_price) {
    die(mysqli_error($connection));
} else {
    if ($row = mysqli_fetch_assoc($select_price)) {
        $bread_price = $row['price'];
    }
}

if (!empty($q) || $q !== "") {
    $total_bread = $q / $bread_price;
    $total_bread = floor($total_bread);
    $rem = $q - ($total_bread * $bread_price);
    $str = " (مبلغ اضافه" . convertNumbers($rem, true) . ") ";
    $str .= " " . convertNumbers($total_bread, true) . " ";
    echo $str;
} else {
    echo ') ۰';
}