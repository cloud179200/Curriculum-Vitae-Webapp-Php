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
   <title>Login</title>
   <!-- Favicon -->
   <link href="../img/favicon.ico" rel="icon">

   <!-- Google Web Fonts -->
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Roboto:wght@500;700;900&display=swap" rel="stylesheet">

   <!-- Icon Font Stylesheet -->
   <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

   <!-- Libraries Stylesheet -->
   <link href="../lib/animate/animate.min.css" rel="stylesheet">
   <link href="../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
   <link href="../lib/lightbox/css/lightbox.min.css" rel="stylesheet">

   <!-- Customized Bootstrap Stylesheet -->
   <link href="../css/bootstrap.min.css" rel="stylesheet">

   <!-- Template Stylesheet -->
   <link href="../css/style.css" rel="stylesheet">
   <link href="../css/custom.css" rel="stylesheet">

 </head>

 <body class="overflow-hidden">
   <!-- Spinner Start -->
   <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
     <div class="spinner-border text-success" style="width: 3rem; height: 3rem;" role="status">
       <span class="sr-only">Loading...</span>
     </div>
   </div>
   <div class="row vh-100 overflow-hidden">
     <div class="col-1 p-0 vh-100">
       <a href="../index.php" class="btn btn-success pr-4 pl-4 d-flex align-items-center justify-content-center w-100 h-100">
         <i class="d-inline fa fa-2x fa-arrow-left"></i>
       </a>
     </div>
     <div class="col-lg-5 col-md-11 p-0">
       <?php
        $errors = array();
        if (isset($_POST['btnLogin'])) {
          if (empty($_POST['txtUser'])) {
            $errors["txtUser"] = $errorsMessage["empty"];
          }

          if (empty($_POST['txtPass'])) {
            $errors["txtPass"] = $errorsMessage["empty"];
          }
          $isValid = count($errors) == 0;
          if ($isValid) {
            $user = $_POST['txtUser'];
            $pass = $_POST['txtPass'];
            if (checkLogin($user, $pass)) {
              header("location:" . $route["user"]);
            } else {
              header("location:" . $_SERVER['REQUEST_URI'] . '?error=Login failed');
            }
          }
        }
        ?>
       <section class="vh-100 " style="background-color: #eee;overflow-x: hidden;overflow-y: auto;">
         <form novalidate  method="POST" action="./login.php" data-wow-delay="1s" class="container py-5 h-100 wow zoomInUp needs-validation <?php if (isset($_POST['btnLogin'])) echo "was-validated" ?>">
           <div class="row d-flex justify-content-center align-items-center h-100">
             <div class="col-12 col-md-9 col-lg-9 col-xl-9">
               <div class="card shadow-2-strong" style="border-radius: 1rem;">
                 <div class="card-body p-5 text-center">
                   <h3 class="mb-5">Login</h3>
                   <div class="form-outline mb-4 ">
                     <label class="form-label float-start" for="typeEmailX-2">Username</label>
                     <input autocomplete type="text" id="txtUser" name="txtUser" class="form-control form-control-lg" required />
                     <?php
                      if (isset($errors["txtUser"])) echo '<div class="invalid-feedback text-start">' . $errors["txtUser"] . '</div>';
                      ?>
                   </div>

                   <div class="form-outline mb-4">
                     <label class="form-label float-start" for="typePasswordX-2">Password</label>
                     <input autocomplete type="password" id="txtPass" name="txtPass" class="form-control form-control-lg" required />
                     <?php
                      if (isset($errors["txtPass"])) echo '<div class="invalid-feedback text-start">' . $errors["txtPass"] . '</div>';
                      ?>
                   </div>
                   <div class="text-end pb-4 fw-bold"><a href="./register.php" class="link-success">Don't have account?</a></div>
                   <button class="w-100 btn btn-success btn-lg btn-block" id="btnLogin" name="btnLogin" type="submit">Login</button>
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
     <div class="col-lg-6 col-md-0 p-0">
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