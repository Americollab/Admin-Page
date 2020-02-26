<?php
session_start(); 
if (!isset($_SESSION["fname"])){ 
?> <script>
        window.location.href = "login.php";
    </script>

<?php }



$employee = $fname = $lname = $email = $tokens = $success = "";
$error = "no error";

    if($_SERVER["REQUEST_METHOD"] === "POST") {
        $fname = test_input($_POST["fname"]);
        $lname = test_input($_POST["lname"]);
        $email = test_input($_POST["email"]);
        $tokens = test_input($_POST["tokens"]);
        $success == true;
    
    require_once("connect-db.php"); 
        
    $sql = "INSERT INTO employee (fname, lname, email, tokens) VALUES (:fname, :lname, :email, :tokens)"; 
        
    $statement1 = $db->prepare($sql); 
    
    $statement1->bindValue(':fname', $fname);
    $statement1->bindValue(':lname', $lname);
    $statement1->bindValue(':email', $email);
    $statement1->bindValue(':tokens', $tokens);

    if ($statement1->execute()){ 
        $result = $statement1->fetchAll();
        $statement1->closeCursor(); 
        $success = "Employee successfully added. You will be redirected to the home page in 3 seconds";
        
  ?>      
    <script>
        setTimeout("location.href = 'index.php';", 3000);
    </script>
<?php
    }else{
        $error = "Employee not added";
    }
    }
      function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
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
        <h1 class="mt-4">Admin Page: Add Employee</h1>
         <?php
        if($error != "no error"){
            echo "<h4>$error</h4>";
            exit();
        }
        if($success != ""){
            echo "<h3 style=color: red;>$success</h3>";
        
        }?>
        
        <div class="col-sm-12 content"> 
            
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <h2>Add New Employee</h2>

            <div class="form-group">
                <label>Employee First Name:</label>
                    <input class="form-control" type="text" name="fname" required value="<?php if(isset($_POST['fname'])) echo $_POST['fname']; ?>">
            </div>
            
            <div class="form-group">
                <label>Employee Last Name:</label>
                    <input class="form-control" type="text" name="lname" required value="<?php if(isset($_POST['lname'])) echo $_POST['lname']; ?>">
            
            <div class="form-group">
                <label>Employee Email:</label>
                    <input class="form-control" type="text" name="email" required value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>">
          </div>
            <div class="form-group">
                <label>Number of Tokens:</label>
              <input class="form-control" type="text" name="tokens" required value="<?php if(isset($_POST['tokens'])) echo $_POST['tokens']; ?>">
            
            </div>
                
        <div class="form-group">
            <form action="update-process-admin.php" method="post">   <input type="hidden" name="cigarId" value="<?php echo $cigars["cigarId"]; ?>"><button type="submit" class="btn btn-primary">submit</button></form>        </div>
          </div>
</form>
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
    </div>
</body>
</html>
