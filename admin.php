<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bachelor 2.0 Authority Panel</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            text-align: center;
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
            width: 50px;
            height: 50px;
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
        <h1>Bachelor 2.0 Authority Panel</h1>
        <?php
        require_once "database.php";

        $sql = "SELECT full_name, email, phone, image_url FROM users";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table class='table'>";
            echo "<tr>";
            echo "<th>Name</th>";
            echo "<th>Email</th>";
            echo "<th>Phone</th>";
            echo "<th>Picture</th>";
            echo "</tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["full_name"] . "</td>";
                echo "<td>" . $row["email"] . "</td>";
                echo "<td>" . $row["phone"] . "</td>";
                echo "<td><img src='" . $row["image_url"] . "' alt='Picture' class='passport-size'></td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "No registered users found.";
        }

        $conn->close();
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


