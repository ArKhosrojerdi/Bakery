<?php
include "functions.php";
include "entope.php";

if (isset($_POST['execute-donation'])) {
    $count = $_POST["donate_count"];
    print_r($_POST["donate_count"]);
    $extra = convertNumbers($_POST["extrai"], false);
    echo "<br>" . $extra . "</br>";
    if ($extra < 0) {
        echo "<script type='text/javascript'>" .
            "alert('بیش از حد مجاز نان توزیع کرده‌اید.');" .
            "window.location.replace('edit.php');" .
            "</script>";
    } else {
        $money = $extra * getBreadPrice();
//    echo "<br>" . $money . "</br>";

        if (empty($count)) {
            echo "<script type='text/javascript'>" .
                "alert('هیچ خانواری انتخاب نشده است.');" .
                "window.location.replace('edit.php');" .
                "</script>";
        } else {
            if (!empty($count)) {
                foreach ($count as $key => $value) {
                    $query = "SELECT remaining FROM customer WHERE id = '{$key}'";
                    $select_remaining = mysqli_query($connection, $query);
                    if (!$select_remaining)
                        die(mysqli_error($connection));
                    if ($row = mysqli_fetch_assoc($select_remaining)) {
                        $remaining = $row['remaining'];
                        $value = convertNumbers($value, false);
                        $new_remaining = $remaining + $value;
                        echo $new_remaining . "<br />";
                        $query = "UPDATE customer SET remaining = '{$new_remaining}' WHERE id = '{$key}'";
                        $update_remaining_query = mysqli_query($connection, $query);
                        if (!$update_remaining_query)
                            die(mysqli_error($connection));
//                    header("Location: edit.php");
                    }
                }
                $query = "INSERT INTO store (money) VALUE ('{$money}')";
                $add_money_to_store = mysqli_query($connection, $query);
                if (!$add_money_to_store)
                    die(mysqli_error($connection));
            }
        }
    }
}