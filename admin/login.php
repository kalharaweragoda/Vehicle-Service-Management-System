<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if(isset($_POST['login'])) 
{
    $username = $_POST['username'];
    $password = $_POST['password'];  // No encryption applied here
    $sql = "SELECT ID FROM tbladmin WHERE UserName=:username AND Password=:password";
    $query = $dbh->prepare($sql);
    $query->bindParam(':username', $username, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);

    if($query->rowCount() > 0)
    {
        foreach ($results as $result) {
            $_SESSION['odmsaid'] = $result->ID;
        }

        if(!empty($_POST["remember"])) {
            setcookie("user_login", $_POST["username"], time() + (10 * 365 * 24 * 60 * 60));
            setcookie("userpassword", $_POST["password"], time() + (10 * 365 * 24 * 60 * 60));
        } else {
            if(isset($_COOKIE["user_login"])) {
                setcookie("user_login", "", time() - 3600);
            }
            if(isset($_COOKIE["userpassword"])) {
                setcookie("userpassword", "", time() - 3600);
            }
        }
        $_SESSION['login'] = $_POST['username'];
        echo "<script type='text/javascript'> document.location ='dashboard.php'; </script>";
    } else {
        echo "<script>alert('Invalid Details');</script>";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <title>Admin Login</title>
    <style>
        /* Styling goes here */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            width: 300px;
            background-color: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input[type="text"], .form-group input[type="password"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        .form-group input[type="checkbox"] {
            margin-right: 5px;
        }
        .btn {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .auth-links {
            text-align: center;
            margin-top: 20px;
        }
        .auth-links a {
            color: #007BFF;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Admin Login</h2>
    <form method="post">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" required="true" value="<?php if(isset($_COOKIE["user_login"])) { echo $_COOKIE["user_login"]; } ?>">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" required="true" value="<?php if(isset($_COOKIE["userpassword"])) { echo $_COOKIE["userpassword"]; } ?>">
        </div>
        <div class="form-group">
            <input type="checkbox" id="remember" name="remember" <?php if(isset($_COOKIE["user_login"])) { ?> checked <?php } ?> />
            <label for="remember">Keep me signed in</label>
        </div>
        <div class="form-group">
            <button type="submit" class="btn" name="login">Sign In</button>
        </div>
    </form>

    <div class="auth-links">
        <a href="forgot-password.php">Forgot Password?</a> | 
        <a href="../index.php">Back Home</a>
    </div>
</div>

</body>
</html>
