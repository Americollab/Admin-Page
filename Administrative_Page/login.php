<?php
session_start(); 
if (isset($_SESSION["fname"])){ 
?> <script>
        window.location.href = "index.php";
    </script>

<?php }

$dusername = $dpassword = $success = $fname ="";
$error = "no error";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dusername = $_POST['dusername'];
    $dpassword = $_POST['dpassword'];
    
    require_once("connect-db.php");

    $sql="select * from account where accountUsername = :dusername and accountPassword = :dpassword";
    
    $statement1=$db->prepare($sql);
    $statement1->bindValue(":dusername", $dusername);
    $statement1->bindValue(":dpassword", $dpassword);
    
        $statement1->execute();
        $result = $statement1->fetchAll();
        $statement1->closeCursor();
    
        foreach($result as $theresult){
            $sessionfname = $theresult["fname"];
            $sessionid = $theresult["accountId"];
        }
    
        if (isset($sessionfname)) {
            $_SESSION["fname"] = $sessionfname;
            $_SESSION["accountId"] = $sessionid;
?>

    <script type="text/javascript">
        window.location = "index.php";
    </script>
<?php
        }else{
            $error = "Incorrect username and password";
        }
}
?>


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
        <h1 class="mt-4">Login Page</h1>
       <?php
            if($error != "no error"){
                echo "<h4 style='color: red;'>$error</h4>";
            }else{
                echo $success;
        } ?>
          
          <h4>Don't have an account? <a href="register.php">Register now!</a></h4>
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <div class="form-group">
                        
                        <label>Username:</label>
                            <input class="form-control" type="text" name="dusername" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Password:</label>
                        <input class="form-control" type="password" name="dpassword" required>
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
