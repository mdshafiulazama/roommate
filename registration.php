<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Match Authority</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<style>
    .container {
        max-width: 400px; /* Adjust the maximum width as needed */
        margin: 0 auto; /* Center the form horizontally */
    }

    .form-group {
        margin: 10px 0;
    }

    .form-control {
        width: 100%;
        padding: 10px;
        font-size: 14px; /* Reduce the font size for a smaller form */
    }

    .btn {
        padding: 5px 15px; /* Reduce the padding to make the button smaller */
        font-size: 14px; /* Reduce the font size for the button */
    }
</style>

<body>
<div class="container">
    <h1>Match Authority</h1>
    <form action="registration.php" method="post" enctype="multipart/form-data">
            <?php
            require_once "database.php";

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $fullName = $_POST["fullname"];
                $email = $_POST["email"];
                $password = $_POST["password"];
                $passwordRepeat = $_POST["repeat_password"];
                $phone = isset($_POST["phone"]) ? $_POST["phone"] : "";

                if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] === UPLOAD_ERR_OK) {
                    $fileTmpName = $_FILES['image_url']['tmp_name'];
                    $fileName = $_FILES['image_url']['name'];
                    $uploadDirectory = 'uploads/'; // Create this directory on your server

                    if (move_uploaded_file($fileTmpName, $uploadDirectory . $fileName)) {
                        $imageURL = $uploadDirectory . $fileName;
                    } else {
                        echo "<div class='alert alert-danger'>Error uploading the profile picture.</div>";
                        $imageURL = ''; // Set a default or empty URL
                    }
                } else {
                    $imageURL = ''; // Set a default or empty URL if no image was uploaded
                }

                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                $errors = array();

                if (empty($fullName) || empty($email) || empty($password) || empty($passwordRepeat)) {
                    array_push($errors, "All fields must be filled");
                }
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    array_push($errors, "Email is not valid");
                }
                if (strlen($password) < 8) {
                    array_push($errors, "Password must be at least 8 characters");
                }
                if ($password != $passwordRepeat) {
                    array_push($errors, "Password does not match");
                }

                // Check if the email already exists in the database
                $sql = "SELECT * FROM users WHERE email = ?";
                $stmt = mysqli_stmt_init($conn);
                if (mysqli_stmt_prepare($stmt, $sql)) {
                    mysqli_stmt_bind_param($stmt, "s", $email);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    $rowCount = mysqli_num_rows($result);
                    if ($rowCount > 0) {
                        array_push($errors, "Email has already been registered");
                    }
                } else {
                    die("Something went wrong");
                }

                if (count($errors) > 0) {
                    foreach ($errors as $error) {
                        echo "<div class='alert alert-danger'>$error</div>";
                    }
                } else {
                    // Insert data into the database
                    $sql = "INSERT INTO users (full_name, email, password, phone, image_url) VALUES (?, ?, ?, ?, ?)";
                    $stmt = mysqli_stmt_init($conn);
                    $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
                    if ($prepareStmt) {
                        mysqli_stmt_bind_param($stmt, "sssss", $fullName, $email, $passwordHash, $phone, $imageURL);
                        mysqli_stmt_execute($stmt);
                        echo "<div class='alert alert-success'>Registration successful.</div>";
                    } else {
                        die("Something went wrong");
                    }
                }
            }
            ?>

<div class="form-group">
            <input type="text" class="form-control" name="fullname" placeholder="Full Name" required>
        </div>
        <div class="form-group">
            <input type="email" class="form-control" name="email" placeholder="Email" required>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="phone" placeholder="Phone Number">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" name="password" placeholder="Password" required>
        </div>
        <div class="form-group">
            <input type="password" class="form-control" name="repeat_password" placeholder="Repeat Password" required>
        </div>
        <div class="form-group">
            <label for="image_url">Profile Picture:</label>
            <input type="file" class="form-control" name="image_url" id="image_url" accept="image/*">
        </div>
        <div class="form-btn">
            <input type="submit" class="btn btn-primary" name="Submit" value="Register">
        </div>
        <div class="form-btn">
            <a href="login.php" class="btn btn-warning">Back</a>
        </div>
    </form>
</div>

</body>
</html>
