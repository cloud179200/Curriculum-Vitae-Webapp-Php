 <?php
  include('../functions.php');
  include('../constant.php');
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
 </head>

 <body>
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
   <section class="vh-100" style="background-color: #508bfc;">
     <form novalidate method="POST" action="./login.php" class="container py-5 h-100 needs-validation <?php if (isset($_POST['btnLogin'])) echo "was-validated" ?>">
       <div class="row d-flex justify-content-center align-items-center h-100">
         <div class="col-12 col-md-8 col-lg-6 col-xl-5">
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
               <div class="text-end pb-4 fw-bold"><a href="./register.php" class="link-primary">Don't have account?</a></div>
               <button class="w-100 btn btn-primary btn-lg btn-block" id="btnLogin" name="btnLogin" type="submit">Login</button>
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
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
 </body>

 </html>