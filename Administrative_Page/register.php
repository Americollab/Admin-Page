<?php
session_start(); 
if (isset($_SESSION["fname"])){ 
?> <script>
        window.location.href = "index.php";
    </script>

<?php }

$fname = $lname = $email = $accountUsername = $accountPassword = $error = $success = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $accountUsername = test_input($_POST["accountUsername"]);
        $accountPassword = ($_POST["accountPassword"]);
        $fname = test_input($_POST["fname"]);
        $lname = test_input($_POST["lname"]);
        $email = test_input($_POST["email"]);
        
        require_once("connect-db.php");
        
        $sql = "INSERT INTO account (accountUsername, accountPassword, fname, lname, email) VALUES (:accountUsername, :accountPassword, :fname, :lname, :email)";
        
        $statement1 = $db->prepare($sql);
        
        $statement1->bindValue(':accountUsername', $accountUsername);
        $statement1->bindValue(':accountPassword', $accountPassword);
        $statement1->bindValue(':fname', $fname);
        $statement1->bindValue(':lname', $lname);
        $statement1->bindValue(':email', $email);

        if ($statement1->execute()){
            $statement1->closeCursor();
            
            $success= "<h4>User created successfully!<br>You will be redirected to the login page in 3 seconds.</h4>";
            
            ?> <script>
                    setTimeout("location.href = 'login.php';",4000);
                </script>

        <?php }else{
            $error = "User NOT successfully created.";
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
        <h1 class="mt-4">Admin Registration Page</h1>
       <?php
            if($error != null){
                echo "<h4 style='color: red;'>$error</h4>";
            }else{
                echo $success;
            }
        ?>
        
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class="form-group">
                <label>First Name:</label>
                <input class="form-control" type="text" name="fname" required>
            </div>
            
            <div class="form-group">
                <label>Last Name:</label>
                <input class="form-control" type="text" name="lname" required>
            </div>
            
            <div class="form-group">
                <label>Email:</label>
                <input class="form-control" type="text" name="email" required>
            </div>
            
            <div class="form-group">
                <label>Username:</label>
                <input class="form-control" type="text" name="accountUsername" required>
            </div>
            
            <div class="form-group">
                <label>Password:</label>
                <input class="form-control" type="password" name="accountPassword" required>
            </div>
            
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
</form>
    </div>
      </div>
    </div>

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
