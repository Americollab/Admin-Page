<?php
session_start(); 
if (!isset($_SESSION["fname"])){ 
?> <script>
        window.location.href = "index.php";
    </script>

<?php }

$employeeId = $fname = $lname = $email = $tokens = $error = $success = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $employeeId = $_POST['employeeId'];
        $fname = test_input($_POST["fname"]);
        $lname = test_input($_POST["lname"]);
        $email = test_input($_POST["email"]);
        $tokens = test_input($_POST["tokens"]);
        
        require_once("connect-db.php");
        
        $sql = "update employee set fname = :fname, lname = :lname, email = :email, tokens = :tokens where employeeId = :employeeId";
        
        $statement1 = $db->prepare($sql);
        
        $statement1->bindValue(':employeeId', $employeeId);
        $statement1->bindValue(':fname', $fname);
        $statement1->bindValue(':lname', $lname);
        $statement1->bindValue(':email', $email);
        $statement1->bindValue(':tokens', $tokens);

        if ($statement1->execute()){
            $statement1->closeCursor();
            
            $success= "Employee updated Successfully! You will be redireced to the home page in 3 seconds.";
            
            ?> <script>
                    setTimeout("location.href = 'index.php';", 3000);
                </script>

        <?php }else{
            $error = "Employee NOT successfully added.";
        }

}
    function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
} ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Pirate Plunder Administrative Page</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/styles.css" rel="stylesheet">

</head>

<body>

  <div class="d-flex" id="wrapper">
     <?php include("includes/nav.php");?>

    <!-- Page Content -->
    <div id="page-content-wrapper">
      <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
        <button class="btn btn-primary" id="menu-toggle">Toggle Menu</button>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
            <li class="nav-item active">
              <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
            </li>
          </ul>
        </div>
      </nav>
      <div class="container-fluid">
    <div class="container">

   
        <div class="col-sm-12 content"> 
      <?php
            if($error != null){
                echo "<h4 style='padding: 5% 0';>$error</h4>";
            }else{
                echo "<h4 style='padding: 5% 0';>$success</h4>";
            }
        ?>
        
      </div>
  </div>
      </div>
    </div>
    <!-- /#page-content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Menu Toggle Script -->
  <script>
    $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
    });
  </script>
</body>
</html>