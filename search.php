<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View New Member Details</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            text-align: center;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            font-weight: bold;
        }
        input[type="text"] {
            width: 100%; /* Adjust the width as needed */
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .passport-size {
            width: 100px;
            height: 100px;
        }
        .btn {
            text-align: center;
            margin-top: 20px;
        }
        .btn.btn-warning {
            background-color: #ffc107;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Member Details</h1>
        <form action="search.php" method="post">
            <div class="form-group">
                <label for="search-phone">Search by Phone Number:</label>
                <input type="text" name="search-phone" id="search-phone" style="width: 80%;"> <!-- Adjust the width as needed -->
                <input type="submit" value="Search">
            </div>
        </form>
        <?php
        require_once "database.php";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $searchPhone = $_POST["search-phone"];
            $sql = "SELECT Name, Phone, nid, home_town, image_ulr FROM new WHERE Phone = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $searchPhone);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($name, $phone, $nid, $hometown, $image_ulr);
                $stmt->fetch();

                echo "<table class='table'>";
                echo "<tr>";
                echo "<th>Name</th>";
                echo "<th>Phone</th>";
                echo "<th>NID</th>";
                echo "<th>Home Town</th>";
                echo "<th>Picture</th>";
                echo "</tr>";
                echo "<tr>";
                echo "<td>$name</td>";
                echo "<td>$phone</td>";
                echo "<td>$nid</td>";
                echo "<td>$hometown</td>";
                echo "<td><img src='$image_ulr' alt='Picture' class='passport-size'></td>";
                echo "</tr>";
                echo "</table>";
            } else {
                echo "No new member found with the phone number: $searchPhone.";
            }

            $stmt->close();
        }
        ?>

<div class="form-btn">
            <a href="index.php" class="btn btn-warning">Back</a>
            <button onclick="printPage()" class="btn btn-primary">Print</button>
        </div>
    </div>

    <script>
        function printPage() {
            window.print();
        }
    </script>
    </div>
</body>
</html>


















