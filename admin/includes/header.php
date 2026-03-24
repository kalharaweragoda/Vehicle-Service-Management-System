<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['odmsaid']) == 0) {
    header('location:logout.php');
    exit();
} else {
?>

<header id="page-header" style="background-color: #fff; border-bottom: 1px solid #ddd;">
    <div class="content-header d-flex justify-content-between align-items-center">
        
        <div class="content-header-section">
            <ul class="adminNavBar">
                <li><a href="dashboard.php">Dashboard</a></li>
                <?php createDropdown("Service", [
                    "add-services.php" => "Add Services",
                    "manage-services.php" => "Manage Services"
                ]); ?>
                <li><a href="aboutus.php">About Us</a></li>
                <li><a href="contactus.php">Contact Us</a></li>
                <?php createDropdown("Booking", [
                    "new-booking.php" => "New Bookings",
                    "approved-booking.php" => "Approved Bookings",
                    "cancelled-booking.php" => "Cancelled Bookings",
                    "all-booking.php" => "All Bookings"
                ]); ?>
                <?php createDropdown("Messages", [
                    "unread-queries.php" => "Unread Messages",
                    "read-queries.php" => "Read Messages"
                ]); ?>
            </ul>
        </div>

        <div class="content-header-section">
            <div class="btn-group" role="group">
                <?php displayUserMenu($dbh); ?>
            </div>
        </div>

    </div>
</header>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $('.dropdown-toggle').on('click', function(e) {
            e.preventDefault();
            $(this).next('.dropdown-menu').toggle();
        });

        $(document).click(function(e) {
            if (!$(e.target).closest('.btn-group').length) {
                $('.dropdown-menu').hide();
            }
        });
    });
</script>

<style>
    .btn-group { margin-right: 30px; }
    .adminNavBar { list-style-type: none; padding: 0; margin: 0; display: flex; background-color: #fff; }
    .adminNavBar > li { position: relative; margin-right: 20px; }
    .adminNavBar > li > a { color: #000; padding: 15px 20px; text-decoration: none; display: block; }
    .adminNavBar > li > a:hover { background-color: #f0f0f0; }
    .dropdown { list-style-type: none; padding: 0; margin: 0; display: none; position: absolute; top: 100%; left: 0; background-color: #fff; border: 1px solid #ddd; min-width: 150px; z-index: 1000; }
    .adminNavBar > li:hover .dropdown { display: block; }
    .dropdown li { padding: 0; }
    .dropdown a { color: #000; padding: 10px 15px; display: block; }
    .dropdown a:hover { background-color: #f0f0f0; }
</style>

<?php
} 

function createDropdown($title, $links) {
    echo '<li>';
    echo '<a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-expanded="false">';
    echo $title . ' <span class="caret"></span>';
    echo '</a>';
    echo '<ul class="dropdown">';
    foreach ($links as $url => $text) {
        echo "<li><a href=\"$url\">$text</a></li>";
    }
    echo '</ul>';
    echo '</li>';
}

function displayUserMenu($dbh) {
    $aid = $_SESSION['odmsaid'];
    $sql = "SELECT AdminName FROM tbladmin WHERE ID=:aid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':aid', $aid, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_OBJ);

    if ($result) {
        echo '<button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
        echo htmlentities($result->AdminName);
        echo '</button>';
        echo '<div class="dropdown-menu dropdown-menu-right">';
        echo '<a class="dropdown-item" href="admin-profile.php"><i class="fas fa-user-circle mr-2"></i> Profile</a>';
        echo '<a class="dropdown-item" href="change-password.php"><i class="fas fa-cog mr-2"></i> Settings</a>';
        echo '<div class="dropdown-divider"></div>';
        echo '<a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt mr-2"></i> Sign Out</a>';
        echo '</div>';
    }
}
?>
