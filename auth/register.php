<?php
include('../functions.php');
handleRoute();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Register</title>
  <link href="../img/favicon.ico" rel="icon">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Roboto:wght@500;700;900&display=swap" rel="stylesheet">

  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

  <link href="../lib/animate/animate.min.css" rel="stylesheet">
  <link href="../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="../lib/lightbox/css/lightbox.min.css" rel="stylesheet">

  <link href="../css/bootstrap.min.css" rel="stylesheet">

  <link href="../css/style.css" rel="stylesheet">
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Navbar</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Link</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Dropdown
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
          </li>
        </ul>
        <form class="d-flex">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
    </div>
  </nav>

  <section id="register" class="container">
    <h2 class="text-center">Register</h2>
    <?php
    $errors = new stdClass;
    $successMessage = "";
    $errorMessage = "";

    if (isset($_POST['btnRegister'])) {
      require_once('../constant.php');
      if (empty($_POST['txtFirstName'])) {
        $errors["txtFirstName"] = $errorsMessage["empty"];
      }

      if (empty($_POST['txtLastName'])) {
        $errors["txtLastName"] = $errorsMessage["empty"];
      }
      if (empty($_POST['txtUser'])) {
        $errors["txtUser"] = $errorsMessage["empty"];
      }
      if (empty($_POST['txtEmail'])) {
        $errors["txtEmail"] = $errorsMessage["empty"];
      }
      if (empty($_POST['txtPass1'])) {
        $errors["txtPass1"] = $errorsMessage["empty"];
      }
      if ($_POST['txtPass2'] != $_POST['txtPass1']) {
        $errors["txtPass2"] = $errorsMessage["invalid"];
      }
      $isValid = count(get_object_vars($errors)) === 0;
      if ($isValid) {
        // Thực hiện Xử lý lưu bản ghi
        // 1. Lấy thông tin từ FORM
        $firstName  = $_POST['txtFirstName'];
        $lastName   = $_POST['txtLastName'];
        $userName   = $_POST['txtUser'];
        $email      = $_POST['txtEmail'];
        $pass       = $_POST['txtPass1'];

        // 2. Ra lệnh kiểm tra
        require_once("functions.php");
        if (checkUserExist($userName, $email)) {
          $errorMessage .= "Username or Email existed";
        } else {
          if (addNewUser($firstName, $lastName, $userName, $email, $avatar, $pass)) {
            // Xử lý chức năng GỬI EMAIL
            $successMessage .= "Bạn đã đăng kí thành công tài khoản. Chúng tôi sẽ gửi thông báo tới Email của Bạn";
          }
        }
      }
    }

    ?>
    <form method="POST" action="./register.php">
      <div class="mb-3">
        <input type="text" class="form-control" id="txtFirstName" name="txtFirstName" placeholder="First Name">
        <?php
        if (!isset($errors["txtFirstName"])) echo `<div class="invalid-feedback">
          ${$errors["txtFirstName"]}
        </div>`;
        ?>
      </div>
      <div class="mb-3">
        <input type="text" class="form-control" id="txtLastName" name="txtLastName" placeholder="Last Name">
        <?php
        if (!isset($errors["txtLastName"])) echo `<div class="invalid-feedback">
          ${$errors["txtLastName"]}
        </div>`;
        ?>
      </div>
      <div class="mb-3">
        <input type="text" class="form-control" id="txtUser" name="txtUser" placeholder="Username">
        <?php
        if (!isset($errors["txtUser"])) echo `<div class="invalid-feedback">
          ${$errors["txtUser"]}
        </div>`;
        ?>
      </div>
      <div class="mb-3">
        <input type="email" class="form-control" id="txtEmail" name="txtEmail" placeholder="Email">
        <?php
        if (!isset($errors["txtEmail"])) echo `<div class="invalid-feedback">
          ${$errors["txtEmail"]}
        </div>`;
        ?>
      </div>
      <div class="mb-3">
        <input type="password" class="form-control" id="txtPass1" name="txtPass1" placeholder="Password">
        <?php
        if (!isset($errors["txtPass1"])) echo `<div class="invalid-feedback">
          ${$errors["txtPass1"]}
        </div>`;
        ?>
      </div>
      <div class="mb-3">
        <input type="password" class="form-control" id="txtPass2" name="txtPass2" placeholder="Retype Password">
        <?php
        if (!isset($errors["txtPass2"])) echo `<div class="invalid-feedback">
          ${$errors["txtPass2"]}
        </div>`;
        ?>
      </div>
      <button type="submit" class="btn btn-primary" name="btnRegister">Register</button>
    </form>
    <?php
    if (!empty($successMessage)) {
      echo `<div class="alert alert-danger" role="alert">
       ${successMessage}
      </div>`;
    }
    if (!empty($errorMessage)) {
      echo `<div class="alert alert-danger" role="alert">
       ${errorMessage}
      </div>`;
    }
    ?>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>