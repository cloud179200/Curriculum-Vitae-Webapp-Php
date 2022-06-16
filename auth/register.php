<?php
include('../functions.php');
include('../constant.php');
session_start();
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
  <link href="../css/custom.css" rel="stylesheet">
</head>

<body class="overflow-hidden">
  <div class="row vh-100">
    <div class="col-1 p-0 vh-100">
      <a href="../index.php" class="btn btn-success pr-4 pl-4 d-flex align-items-center justify-content-center w-100 h-100">
        <i class="d-inline fa fa-2x fa-arrow-left"></i>
      </a>
    </div>
    <div class="col-5 p-0">
      <section class="vh-100" style="background-color: #eee;">
        <form novalidate method="POST" action="./register.php" class="container-xs py-5 h-100 needs-validation wow zoomInUp <?php if (isset($_POST['btnRegister'])) {
                                                                                                                              echo "was-validated";
                                                                                                                            }
                                                                                                                            ?>">
          <?php
          $errors = array();
          if (isset($_POST['btnRegister'])) {
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
            if (empty($_POST['txtGender'])) {
              $errors["txtGender"] = $errorsMessage["empty"];
            }
            if (empty($_POST['txtPass1'])) {
              $errors["txtPass1"] = $errorsMessage["empty"];
            }
            if (empty($_POST['txtPass2'])) {
              $errors["txtPass2"] = $errorsMessage["empty"];
            }
            if ($_POST['txtPass2'] != $_POST['txtPass1']) {
              $errors["txtPass2"] = $errorsMessage["invalid"];
            }
            $isValid = count($errors) == 0;
            if ($isValid) {
              // Thực hiện Xử lý lưu bản ghi
              // 1. Lấy thông tin từ FORM
              $firstName = $_POST['txtFirstName'];
              $lastName = $_POST['txtLastName'];
              $userName = $_POST['txtUser'];
              $email = $_POST['txtEmail'];
              $pass = $_POST['txtPass1'];
              $gender = $_POST['txtGender'];
              // 2. Ra lệnh kiểm tra
              if (checkUserExist($userName, $email)) {
                header("location:" . $_SERVER['REQUEST_URI'] . '?error=Username or Email existed.');
              } else {
                if (addNewUser($firstName, $lastName, $userName, $email, $gender, $pass)) {
                  // Xử lý chức năng GỬI EMAIL
                  $token = generateAuthToken($userName);
                  if (empty($token)) {
                    removeUser($userName);
                    return false;
                  }
                  addCVInfo($token, "null", "null", "null", "null", "null", "0", "null", $gender);
                  if (!sendEmailForActivation($email, $token)) {
                    removeUser($userName);
                    header("location:" . $_SERVER['REQUEST_URI'] . '?error=Server error');
                    return;
                  }
                  header("location:" . $_SERVER['REQUEST_URI'] . '?success=Sign up success. Please check email for verify account.');
                  return;
                }
                header("location:" . $_SERVER['REQUEST_URI'] . '?error=Server error');
              }
            }
          }
          ?>
          <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-9 col-lg-9 col-xl-9">
              <div class="card shadow-2-strong" style="border-radius: 1rem;">
                <div class="card-body p-5 text-center">
                  <h3 class="mb-5">Login</h3>
                  <div class="form-outline mb-4 ">
                    <label class="form-label float-start" for="typeEmailX-2">First name</label>
                    <input autocomplete type="text" class="form-control" value="<?php if (!empty($_POST['txtFirstName'])) echo $_POST['txtFirstName'] ?>" id="txtFirstName" name="txtFirstName" placeholder="First Name" required>
                    <?php
                    if (isset($errors["txtFirstName"])) echo '<div class="invalid-feedback text-start">' . $errors["txtFirstName"] . '</div>';
                    ?>
                  </div>
                  <div class="form-outline mb-4">
                    <label class="form-label float-start">Last name</label>
                    <input autocomplete type="text" class="form-control" value="<?php if (!empty($_POST['txtLastName'])) echo $_POST['txtLastName'] ?>" id="txtLastName" name="txtLastName" placeholder="Last Name" required>
                    <?php
                    if (isset($errors["txtLastName"])) echo '<div class="invalid-feedback text-start">' . $errors["txtLastName"] . '</div>';
                    ?>
                  </div>
                  <div class="form-outline mb-4">
                    <label class="form-label float-start">Username</label>
                    <input autocomplete type="text" class="form-control" value="<?php if (!empty($_POST['txtUser'])) echo $_POST['txtUser'] ?>" id="txtUser" name="txtUser" placeholder="Username" required>
                    <?php
                    if (isset($errors["txtUser"])) echo '<div class="invalid-feedback text-start">' . $errors["txtUser"] . '</div>';
                    ?>
                  </div>
                  <div class="form-outline mb-4">
                    <label class="form-label float-start">Email</label>
                    <input autocomplete type="email" class="form-control" value="<?php if (!empty($_POST['txtEmail'])) echo $_POST['txtEmail'] ?>" id="txtEmail" name="txtEmail" placeholder="Email" required>
                    <?php
                    if (isset($errors["txtEmail"])) echo '<div class="invalid-feedback text-start">' . $errors["txtEmail"] . '</div>';
                    ?>
                  </div>
                  <div class="form-outline mb-4">
                    <label class="form-label float-start">Password</label>
                    <input autocomplete type="password" class="form-control" value="<?php if (!empty($_POST['txtPass1'])) echo $_POST['txtPass1'] ?>" id="txtPass1" name="txtPass1" placeholder="Password" required>
                    <?php
                    if (isset($errors["txtPass1"])) echo '<div class="invalid-feedback text-start">' . $errors["txtPass1"] . '</div>';
                    ?>
                  </div>
                  <div class="form-outline mb-4">
                    <label class="form-label float-start">Retype Password</label>
                    <input autocomplete type="password" class="form-control" value="<?php if (!empty($_POST['txtPass2']) && !isset($errors["txtPass2"])) echo $_POST['txtPass2'] ?>" id="txtPass2" name="txtPass2" placeholder="Retype Password" required>
                    <?php
                    if (isset($errors["txtPass2"])) echo '<div class="invalid-feedback text-start">' . $errors["txtPass2"] . '</div>';
                    ?>
                  </div>
                  <div class="form-outline mb-4">
                    <label class="form-label float-start">Gender</label>
                    <select id="txtGender" name="txtGender" class="form-select" aria-label="Gender select" required>
                      <option <?php if (!isset($_POST['txtGender'])) echo "selected"; ?>>Select gender...</option>
                      <option value="0" <?php if (isset($_POST['txtGender']) && $_POST['txtGender'] == "0") echo "selected"; ?>>Female</option>
                      <option value="1" <?php if (isset($_POST['txtGender']) && $_POST['txtGender'] == "1") echo "selected"; ?>>Male</option>
                    </select>
                    <?php
                    if (isset($errors["txtGender"])) echo '<div class="invalid-feedback text-start">' . $errors["txtGender"] . '</div>';
                    ?>
                  </div>
                  <div class="text-end pb-4 fw-bold"><a href="./login.php" class="link-success">Already have an account?</a></div>
                  <button class="w-100 btn btn-success btn-lg btn-block" id="btnRegister" name="btnRegister" type="submit">Register</button>
                </div>
                <div class="p-2 pb-0 pt-0">
                  <?php
                  if (isset($_GET['error'])) {
                    echo '<div class="alert alert-danger" role="alert">' . $_GET['error'] . '</div>';
                  }
                  if (isset($_GET['success'])) {
                    echo '<div class="alert alert-success" role="alert">' . $_GET['success'] . '</div>';
                  }
                  ?>
                </div>
              </div>
            </div>
          </div>
        </form>
      </section>
    </div>
    <div class="col-6 p-0">
      <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="https://i.pinimg.com/564x/a2/fb/88/a2fb885e01b718dae990fbd1e0c4a951.jpg" class="d-block w-100" alt="...">
          </div>
          <div class="carousel-item">
            <img src="https://i.pinimg.com/564x/35/87/76/358776636bf497df41e51245cfc56598.jpg" class="d-block w-100" alt="...">
          </div>
          <div class="carousel-item">
            <img src="https://i.pinimg.com/564x/08/39/5f/08395f1413bf28ccc7e1c81f282b9187.jpg" class="d-block w-100" alt="...">
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
    </div>
  </div>
  <!-- JavaScript Libraries -->
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../lib/wow/wow.min.js"></script>
  <script src="../lib/easing/easing.min.js"></script>
  <script src="../lib/waypoints/waypoints.min.js"></script>
  <script src="../lib/counterup/counterup.min.js"></script>
  <script src="../lib/owlcarousel/owl.carousel.min.js"></script>
  <script src="../lib/isotope/isotope.pkgd.min.js"></script>
  <script src="../lib/lightbox/js/lightbox.min.js"></script>
  <!-- Toast -->
  <script src="../js/toast.js"></script>
  <!-- Template Javascript -->
  <script src="../js/main.js"></script>
  <script src="../js/index.js"></script>
</body>

</html>