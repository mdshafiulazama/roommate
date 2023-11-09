<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Member Add</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-btn {
            text-align: center;
        }
    </style>
</head>
<body>

<?php
require_once "database.php";
$successMessage = "";
$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $nid = $_POST["nid"];
    $hometown = $_POST["hometown"];

    // Handle image upload
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/'; // Directory to store uploaded images
        $uploadFile = $uploadDir . basename($_FILES['profile_picture']['name']);
        
        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $uploadFile)) {
            // Image upload successful, set the image URL
            $imageURL = $uploadFile;
        } else {
            $errorMessage = "Error uploading the image.";
        }
    } else {
        $errorMessage = "Please select an image for the member's profile picture.";
    }

    // Check if the NID already exists in the "new" table
    $checkNidSql = "SELECT nid FROM new WHERE nid = ?";
    $checkNidStmt = $conn->prepare($checkNidSql);
    $checkNidStmt->bind_param("s", $nid);
    $checkNidStmt->execute();
    $checkNidStmt->store_result();

    if ($checkNidStmt->num_rows > 0) {
        $errorMessage = "This NID has already been added.";
    } else {
        // Insert the data into the database if the NID is not in use
        $insertSql = "INSERT INTO new (Name, Phone, nid, home_town, image_ulr) VALUES (?, ?, ?, ?, ?)";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param("sssss", $name, $phone, $nid, $hometown, $imageURL);

        if ($insertStmt->execute()) {
            // Registration successful
            $successMessage = "Member added successfully!";
        } else {
            $errorMessage = "Error adding the member. Please try again.";
        }
        $insertStmt->close();
    }

    $checkNidStmt->close();
}
?>




    <div class="container">
        <h1>Welcome to Home Bachelor 2.0</h1>
               <h1>Add New Member</h1>
        <?php
        if (!empty($successMessage)) {
            echo '<div class="alert alert-success">' . $successMessage . '</div>';
        }
        if (!empty($errorMessage)) {
            echo '<div class="alert alert-danger">' . $errorMessage . '</div>';
        }
        ?>
        <form action="new.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" required>
            </div>
            <div class= "form-group">
                <label for="phone">Phone:</label>
                <input type="text" name="phone" id="phone" required>
            </div>
            <div class="form-group">
                <label for="nid">NID:</label>
                <input type="text" name="nid" id="nid" required>
            </div>
            <div class="form-group">
                <label for="hometown">Home Town:</label>
                <input type="text" name="hometown" id="hometown" required>
            </div>
            <div class="form-group">
                <label for="profile_picture">Profile Picture:</label>
                <input type="file" name="profile_picture" id="image_url" accept="image/*">
            </div>
            <div class="form-btn">
                <input type="submit" value="Add" class="btn btn-primary">
                <a href="index.php" class="btn btn-warning">Back</a>
            </div>
        </form>
    </div>
</body>
</html>
