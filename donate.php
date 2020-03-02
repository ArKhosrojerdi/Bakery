<?php
include "functions.php";
include "entope.php";

if (isset($_POST['execute-donation'])) {
  $count = $_POST["donate_count"];
//  print_r($_POST["donate_count"]);
  $extra = convertNumbers($_POST["a-extra"], false);
  if (isset($_POST["bank_usage"])) {
    $bank = $_POST["bank_usage"];
    $bank = convertNumbers($bank, false);
  }
//  $remaining_money = $_POST['a-rmoney'];

  if ($_POST["bank_usage"] > getBreadsInBank()) {
    echo "<script type='text/javascript'>" .
      "alert('این مقدار نان در انبار موجود نیست.');" .
      "window.location.replace('edit');" .
      "</script>";
  } else {
    if ($extra < 0) {
      echo "<script type='text/javascript'>" .
        "alert('بیش از حد مجاز نان توزیع کرده‌اید.');" .
        "window.location.replace('edit');" .
        "</script>";
    } else {
      if (empty($count)) {
        echo "<script type='text/javascript'>" .
          "alert('هیچ خانواری انتخاب نشده است.');" .
          "window.location.replace('edit');" .
          "</script>";
      } else {
        foreach ($count as $key => $value) {
          $query = "SELECT remaining FROM customer WHERE id = '{$key}'";
          $select_remaining = mysqli_query($connection, $query);
          if (!$select_remaining)
            die(mysqli_error($connection));
          if ($row = mysqli_fetch_assoc($select_remaining)) {
            $remaining = $row['remaining'];
            $value = convertNumbers($value, false);
            $new_remaining = $remaining + $value;
//            echo $new_remaining . "<br />";
            $query = "UPDATE customer SET remaining = '{$new_remaining}' WHERE id = '{$key}'";
            $update_remaining_query = mysqli_query($connection, $query);
            if (!$update_remaining_query)
              die(mysqli_error($connection));
                    header("Location: edit");
          }
        }
        // Add money to cellar for later donations.
        $money = $extra * getBreadPrice();
        if ($money != 0) {
          $query = "INSERT INTO bank (money) VALUE ('{$money}')";
          $add_money_to_store = mysqli_query($connection, $query);
          if (!$add_money_to_store)
            die(mysqli_error($connection));
        }

//        echo "<br>" . $remaining_money . "</br>";
        if ($bank != 0) {
          $bank = -1 * $bank * getBreadPrice();
          $query = "INSERT INTO bank (money) VALUE ('{$bank}')";
          $withdrawal_from_bank = mysqli_query($connection, $query);
          if (!$withdrawal_from_bank)
            die(mysqli_error($connection));
        } else {

        }
      }
    }
  }
}