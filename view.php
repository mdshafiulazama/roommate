<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View New Members</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
        h1 {
            text-align: center;
        }
        table {
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
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        img {
            max-width: 50px;
            max-height: 50px;
        }
        .form-btn {
            text-align: center;
            margin-top: 20px;
        }
        .btn {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn.btn-warning {
            background-color: #ffc107;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bachelor 2.0 Members</h1>
        <table class="table">
            <tr>
                <th>Name</th>
                <th>Phone</th>
                <th>NID</th>
                <th>Home Town</th>
                <th>Picture</th>
            </tr>
           
            <?php
            require_once "database.php";

            $sql = "SELECT Name, Phone, nid, home_town, image_ulr FROM new"; // Include the image_url field
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["Name"] . "</td>";
                    echo "<td>" . $row["Phone"] . "</td>";
                    echo "<td>" . $row["nid"] . "</td>";
                    echo "<td>" . $row["home_town"] . "</td>";

                    // Display the profile picture
                    echo "<td><img src='" . $row["image_ulr"] . "' alt='Picture' width='100'></td>";
                    
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No new members found</td></tr>";
            }
            $conn->close();
            ?>
        </table>
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
</body>
</html>
