<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php"); // Redirect to the login page if the user is not logged in
    exit();
}

// Include your database connection code
require_once "database.php";

// Retrieve the full name for the logged-in user
$userEmail = $_SESSION["user"];
$sql = "SELECT full_name FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $userEmail);
$stmt->execute();
$stmt->bind_result($fullName);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authority Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        body {
            background-color: #f0f0f0;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .card {
            text-align: center;
            padding: 20px;
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
        .card-title {
            font-size: 20px;
            margin-bottom: 10px;
        }
        .btn {
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1>Welcome to Bechelor 2.0 <?php echo $fullName; ?></h1>
        <div class="row mt-4">
            <div class="col-md-6 mb-4">
                <div class="card">
                    <h5 class="card-title">Add New Member</h5>
                    <a href="new.php" class="btn btn-primary">Go to New Member</a>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <h5 class="card-title">Search Member Details</h5>
                    <a href="search.php" class="btn btn-primary">Search Member</a>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <h5 class="card-title">Authority</h5>
                    <a href="admin.php" class="btn btn-primary">View Admin</a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <h5 class="card-title">View All Members Details</h5>
                    <a href="view.php" class="btn btn-primary">View All Members</a>
                </div>
            </div>
            <div class="col-md-6 mx-auto">
    <div class="card">
        <h5 class="card-title">Delete Members</h5>
        <a href="delete_member.php" class="btn btn-primary">Delete Member</a>
    </div>
</div>
        </div>
        <div class="text-center mt-4">
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>
</body>
</html>
