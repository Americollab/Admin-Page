<?php
session_start(); 
if (!isset($_SESSION["fname"])){ 
?> <script>
        window.location.href = "login.php";
    </script>

<?php }


$employee = $error = "";

    require_once("connect-db.php");
    
    $sql = "select * from employee";

    $statement1=$db->prepare($sql);
    if($statement1->execute()){
        $employee = $statement1->fetchAll();
        if($employee == null){
            $error = "No employees found";
        }
        $statement1->closeCursor();

    }else{
        $error = "Error finding employees.";
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
        
         <br> <p><a href="addemployee.php">Add a New Employee</a></p>


        <table class="table">
            <tr>
                <th>Employee Name</th><th>Email</th><th>Tokens</th>
            </tr>
            
            <?php foreach($employee as $employees) {
            ?>
                <tr>
                    <td><?php echo $employees["fname"]?> <?php echo $employees["lname"]?></td>
                    <td><?php echo $employees["email"]?></td>
                    <td><?php echo $employees["tokens"]?></td>
                    <td>
                        <form action="update.php" method="post">   <input type="hidden" name="employeeId" value="<?php echo $employees["employeeId"]; ?>"><button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </td>
            </tr>

        <?php }; ?> 
         </table>
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
