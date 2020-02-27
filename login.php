<?php
ob_start();
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>سامانه مدیریت سهمیه نان</title>

  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="./stylesheets/main.css">
</head>

<body>
<div class="container">
    <?php
    $msg = '';

    if (isset($_POST['login']) && !empty($_POST['username'])
        && !empty($_POST['password'])) {

        if ($_POST['username'] == 'admin' &&
            $_POST['password'] == '1234') {
            $_SESSION['valid'] = true;
            $_SESSION['timeout'] = time();
            $_SESSION['username'] = 'admin';
            header("Location: edit");

        } else {
            $msg = '!شناسه یا گذرواژه نادرست است';
        }
    }
    ?>
</div>

<div class="container">
  <div class="col-lg-6 col-md-9 col-sm-12 mx-auto mt-5">
    <div class="card card-body">
      <div class="card-body">
        <a href="index" class="float-left btn btn-outline-dark">برگرد</a>
        <h4 class="card-title mb-4 mt-1 text-right">صفحه ورود</h4>
        <hr>
        <form role="form" action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="form-group">
          <label>شناسه</label>
          <input type="text" class="form-control"
                 name="username"
                 required autofocus>
          <br>
          <label>گذرواژه</label>
          <input type="password" class="form-control"
                 name="password" required>
          <h6><?php echo $msg; ?></h6>
          <button class="btn btn-primary form-control" type="submit"
                  name="login">ورود
          </button>
          <!--          Click here to clean <a href="logout" title="Logout">Session.-->
        </form>
      </div>
    </div>
  </div>
</div>

</body>
</html>