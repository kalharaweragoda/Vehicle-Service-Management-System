<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
error_reporting(0);
if (strlen($_SESSION['odmsaid']==0)) {
  header('location:logout.php');
  } else{
if(isset($_POST['submit']))
{
$adminid=$_SESSION['odmsaid'];
$cpassword=md5($_POST['currentpassword']);
$newpassword=md5($_POST['newpassword']);
$sql ="SELECT ID FROM tbladmin WHERE ID=:adminid and Password=:cpassword";
$query= $dbh -> prepare($sql);
$query-> bindParam(':adminid', $adminid, PDO::PARAM_STR);
$query-> bindParam(':cpassword', $cpassword, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);

if($query -> rowCount() > 0)
{
$con="update tbladmin set Password=:newpassword where ID=:adminid";
$chngpwd1 = $dbh->prepare($con);
$chngpwd1-> bindParam(':adminid', $adminid, PDO::PARAM_STR);
$chngpwd1-> bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
$chngpwd1->execute();

echo '<script>alert("Your password successully changed")</script>';
} else {
echo '<script>alert("Your current password is wrong")</script>';

}
}
 ?>
<!doctype html>
 <html lang="en" class="no-focus">
    <head>
 <title>PVSC Admin | Change Password</title>
 
<link rel="stylesheet" id="css-main" href="assets/css/codebase.min.css">
<script type="text/javascript">
function checkpass()
{
if(document.changepassword.newpassword.value!=document.changepassword.confirmpassword.value)
{
alert('New Password and Confirm Password field does not match');
document.changepassword.confirmpassword.focus();
return false;
}
return true;
}   

</script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
    <body>
    <?php include_once('includes/header.php'); ?>

            <main id="main-container">
                <div class="content">
                    <h2 class="content-heading">Change Password</h2>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="block block-themed">
                                <div class="block-content">
                                    <form method="post" onsubmit="return checkpass();" name="changepassword">
                                        <div class="form-group row">
                                            <label class="col-12" for="register1-username">Current Password:</label>
                                            <div class="col-12">
                                                <input type="password" class="form-control" name="currentpassword" id="currentpassword"required='true'>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12" for="register1-email">New Password:</label>
                                            <div class="col-12">
                                                 <input type="password" class="form-control" name="newpassword"  class="form-control" required="true">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12" for="register1-password">Confirm Password:</label>
                                            <div class="col-12">
                                                <input type="password" class="form-control"  name="confirmpassword" id="confirmpassword"  required='true'>
                                            </div>
                                        </div>
                                      
                                        <div class="form-group row">
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-alt-success" name="submit">
                                                    <i class="fa fa-plus mr-5"></i> Change
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

        <?php include_once('includes/footer.php');?>
        </div>
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