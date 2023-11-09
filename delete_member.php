<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php"); // Redirect to the login page if the user is not logged in
    exit();
}

require_once "database.php"; // Include your database connection code

$successMessage = $errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["phone"]) && !empty($_POST["phone"])) {
        $phone = $_POST["phone"];

        // Check if the phone number exists in the database
        $checkPhoneSql = "SELECT id FROM new WHERE Phone = ?";
        $checkPhoneStmt = $conn->prepare($checkPhoneSql);
        $checkPhoneStmt->bind_param("s", $phone);
        $checkPhoneStmt->execute();
        $checkPhoneStmt->store_result();

        if ($checkPhoneStmt->num_rows > 0) {
            // Phone number found, proceed with the delete
            $deleteSql = "DELETE FROM new WHERE Phone = ?";
            $deleteStmt = $conn->prepare($deleteSql);
            $deleteStmt->bind_param("s", $phone);
            
            if ($deleteStmt->execute()) {
                $successMessage = "Member with phone number $phone has been successfully deleted.";
            } else {
                $errorMessage = "Error deleting the member. Please try again.";
            }
            
            $deleteStmt->close();
        } else {
            $errorMessage = "Member with phone number $phone not found.";
        }

        $checkPhoneStmt->close();
    } else {
        $errorMessage = "Please enter a phone number for member deletion.";
    }
}

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
    <title>Delete Member</title>
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
        .form-group {
            margin-bottom: 20px;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .btn {
            width: 100%;
            padding: 10px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1>Welcome to Bechelor 2.0 <?php echo $fullName; ?></h1>
        
        <?php
        if (!empty($successMessage)) {
            echo '<div class="alert alert-success">' . $successMessage . '</div>';
        }

        if (!empty($errorMessage)) {
            echo '<div class="alert alert-danger">' . $errorMessage . '</div>';
        }
        ?>
        
        <form action="delete_member.php" method="post">
            <div class="form-group">
                <label for="phone">Enter Phone Number to Delete:</label>
                <input type="text" name="phone" id="phone" required>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-danger" value="Delete Member">
            </div>
        </form>
        
        <div class="text-center mt-4">
            <a href="view.php" class="btn btn-primary">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
