<?php
include "db1.php";
include "entope.php";
include "functions.php";

$q = $_REQUEST["q"];
$q = convertNumbers($q, false);

$bread_price = getBreadPrice();

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