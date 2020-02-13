<?php
include "db1.php";
include "entope.php";

$q = $_REQUEST["q"];
$q = convertNumbers($q, false);
$query = "SELECT * FROM customer WHERE id = '{$q}'";
$select_query = mysqli_query($connection, $query);
if (!$select_query) {
    echo "کد نامعتبر";
    die(mysqli_error($connection));
}

while ($row = mysqli_fetch_assoc($select_query)) {
    $row['remaining'] = convertNumbers($row['remaining']);
    echo $row['remaining'];
    break;
}
