<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['odmsaid']==0)) {
  header('location:logout.php');
  } else{
    if(isset($_POST['submit']))
  {


$sername=$_POST['sername'];
$serdes=$_POST['serdes'];
$serprice=$_POST['serprice'];

$sql="insert into tblservice(ServiceName,SerDes,ServicePrice)values(:sername,:serdes,:serprice)";
$query=$dbh->prepare($sql);
$query->bindParam(':sername',$sername,PDO::PARAM_STR);
$query->bindParam(':serdes',$serdes,PDO::PARAM_STR);
$query->bindParam(':serprice',$serprice,PDO::PARAM_STR);

 $query->execute();

   $LastInsertId=$dbh->lastInsertId();
   if ($LastInsertId>0) {
    echo '<script>alert("Services has been added.")</script>';
echo "<script>window.location.href ='add-services.php'</script>";
  }
  else
    {
         echo '<script>alert("Something Went Wrong. Please try again")</script>';
    }
}
?>


<!doctype html>
<html lang="en" class="no-focus">

<head>
    <title>PVSC Admin | Add Services</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" id="css-main" href="assets/css/codebase.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <?php include_once('includes/header.php'); ?>

    <main id="main-container">
        <div class="content">
            <h2 class="content-heading">Add Services</h2>
            <div class="row">
                <div class="col-md-12">
                    <div class="block block-themed">
                        <div class="block-content">
                            <form method="post">
                                <div class="form-group row">
                                    <label class="col-12" for="register1-email">Service Name:</label>
                                    <div class="col-12">
                                        <input type="text" class="form-control" name="sername" value="" required='true'>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-12" for="register1-email">Service Description:</label>
                                    <div class="col-12">
                                        <textarea type="text" class="form-control" name="serdes" value="" required='true'></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-12" for="register1-password">Service Price:</label>
                                    <div class="col-12">
                                        <input type="text" class="form-control" name="serprice" value="" required='true'>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-alt-success" name="submit">
                                            <i class="fa fa-plus mr-5"></i> Add
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="assets/js/core/jquery.min.js"></script>
    <script src="assets/js/core/popper.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>
    <script src="assets/js/core/jquery.slimscroll.min.js"></script>
    <script src="assets/js/core/jquery.scrollLock.min.js"></script>
    <script src="assets/js/core/jquery.appear.min.js"></script>
    <script src="assets/js/core/jquery.countTo.min.js"></script>
    <script src="assets/js/core/js.cookie.min.js"></script>
    <script src="assets/js/codebase.js"></script>

</body>

</html>
<?php }  ?>