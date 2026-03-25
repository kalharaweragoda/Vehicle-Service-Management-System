<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('includes/dbconnection.php');

if (strlen($_SESSION['odmsaid']) == 0) {
    header('location:login.php');
    exit();
} else {
    $sql = "SELECT 
                tblbooking.BookingID,
                tbluser.FullName,
                tblbooking.BookDate,
                tblbooking.BookTime,
                tblservice.ServiceName,
                tblbooking.vehicleNumber,
                tblbooking.NumberOfWheels,
                tblbooking.additional,
                tblbooking.Message,
                tblbooking.Status
            FROM 
                tblbooking 
            JOIN 
                tbluser ON tbluser.ID = tblbooking.UserID 
            JOIN 
                tblservice ON tblservice.ID = tblbooking.ServiceID";

        $query = $dbh->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        $cnt = 1;
    ?>

<!doctype html>
<html lang="en">
<head>
    <title>PVSC Admin | All Booking</title>
    <link rel="stylesheet" href="assets/css/codebase.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <main id="main-container">
        <div class="content">
            <h2 class="content-heading">All Bookings</h2>

            <div class="mb-3">
                <a href="dashboard.php" class="btn btn-primary">Back to Dashboard</a>
            </div>

            <div class="block">
                <div class="block-content block-content-full">
                    <table class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Booking ID</th>
                                <th>Full Name</th>
                                <th>Booked Date</th>
                                <th>Booked Time</th>
                                <th>Service</th>
                                <th>Vehicle Number</th>
                                <th>Number of Wheels</th>
                                <th>Additional</th>
                                <th>Message</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($query->rowCount() > 0) {
                                foreach ($results as $index => $row) {
                                    ?>
                                    <tr>
                                        <td class="text-center"><?php echo htmlentities($index + 1); ?></td>
                                        <td><?php echo htmlentities($row->BookingID); ?></td>
                                        <td><?php echo htmlentities($row->FullName); ?></td>
                                        <td><?php echo htmlentities($row->BookDate); ?></td>
                                        <td><?php echo htmlentities($row->BookTime); ?></td>
                                        <td><?php echo htmlentities($row->ServiceName); ?></td>
                                        <td><?php echo htmlentities($row->vehicleNumber); ?></td>
                                        <td><?php echo htmlentities($row->NumberOfWheels); ?></td>
                                        <td><?php echo !empty($row->additional) ? htmlentities($row->additional) : '-'; ?></td>
                                        <td><?php echo !empty($row->Message) ? htmlentities($row->Message) : '-'; ?></td>
                                        <td><?php echo htmlentities($row->Status); ?></td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo '<tr><td colspan="12" class="text-center">No new bookings found.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    <script src="assets/js/core/jquery.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>
</body>
</html>

<?php
}
