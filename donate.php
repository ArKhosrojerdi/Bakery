<?php
include "db1.php";

$check = $_POST["donate_check"];
print_r($_POST["donate_count"]);
print_r($_POST["donate_check"]);

if (empty($check)) {
    echo "<script type='text/javascript'>" .
        "alert('هیچ خانواری انتخاب نشده است.');" .
        "window.location.replace('edit.php');" .
        "</script>";
} else {
    if (!empty($count)) {
        $count = $_POST["donate_count"];
        foreach ($check as $key => $value) {
            echo $key . "<br />";
            echo $value . "<br />";
        }
    }
}
