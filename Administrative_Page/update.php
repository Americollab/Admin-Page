<?php
session_start(); 
if (!isset($_SESSION["fname"])){ 
?> <script>
        window.location.href = "index.php";
    </script>

<?php }

$employeeId = $error = "";

    $employeeId = $_POST["employeeId"]; 

    require_once("connect-db.php");

    $sql = "select * from employee where employeeId = :employeeId";

    $statement1=$db->prepare($sql);

    $statement1->bindValue(":employeeId", $employeeId); 
    $statement1->execute();
    $employee = $statement1->fetchAll(); 
    $statement1->closeCursor();
        
        
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
        <form method="POST" action="update-process-admin.php">
        
        <?php foreach ($employee as $employees) :?>

            <div class="form-group">
                <label>First Name:</label>
                    <input class="form-control" type="text" name="fname" required value="<?php echo $employees["fname"];?>">
            </div>
            
            <div class="form-group">
                <label>Last Name:</label>
                    <input class="form-control" type="text" name="lname" required value="<?php echo $employees["lname"];?>">
            </div>
            
            <div class="form-group">
                <label>Email:</label>
                    <input class="form-control" type="text" name="email" required value="<?php echo $employees["email"];?>">            </div>
            
            <div class="form-group">
                <label>Tokens:</label>
                    <input class="form-control" type="text" name="tokens" required value="<?php echo $employees["tokens"];?>">
            </div>
    <?php endforeach;?>
        <div class="form-group">
            <input type="hidden" name="employeeId" value="<?php echo $employees["employeeId"]; ?>"><button type="submit" class="btn btn-primary">Submit</button>
        </div>
        </form>

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
      </div>
    </div>
</body>
</html>