<?php
$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "animals";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch animal data from the database
$sql = "SELECT * FROM cow";
$result = $conn->query($sql);


if (!$result) {
    die("Error executing the query: " . $conn->error);
}

// Handle delete request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['delete-btn'])) {
        $deleteTag = $_POST['delete-tag'];

        // Delete record from the database
        $deleteSql = "DELETE FROM cow WHERE tag = '$deleteTag'";
        if ($conn->query($deleteSql) === TRUE) {
            echo "<script>alert('Record deleted successfully')</script>";
            //echo "<script>window.location.reload()</script>";
            header("Location: manage.php");
            exit;
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="manage.css">
    <script src="https://kit.fontawesome.com/353589d1de.js" crossorigin="anonymous"></script>
    <title>Manage Animals</title>
</head>

<body>

    <nav class="logo">

        <div class="upper-bar" id="ubar">
            <h2>AutoDairy Innovations</h2>
            <ul>
                <li><a href="notification.php" class="btn">Notifications</a></li>
            </ul>
            <h7>Admin</h7>
            <i class="fa-solid fa-user"></i>
            <div class="logo">
                <img src="logo3.png">
            </div>
        </div>
    </nav>
    <div id="unique"><br></div>
    <nav>
        <span>
            <div class="container" id="drawer">
                <nav class="navbar">
                    <ul>
                        <li><a href="dashboard.php" class="btn">Dashboard</a></li><br><br>
                        <li><a href="A-details.php" class="btn">Animal Details</a></li><br><br>
                        <li><a href="H-record.php" class="btn">Health Record</a></li><br><br>
                        <li><a href="D-plan.php" class="btn">Diet Plan</a></li><br><br>
                        <li><a href="M-prod.php" class="btn">Milk Production</a></li><br><br>
                        <li><a href="report.php" class="btn">Reports</a></li>

                        <ul style="list-style-type:circle">
                            <li><a href="daily.php" class="btn">Daily</a></li><br>
                            <li><a href="weekly.php" class="btn">Weekly</a></li><br>
                            <li><a href="monthly.php" class="btn">Monthly</a></li><br>
                            <li><a href="annual.php" class="btn">Annual</a></li>
                        </ul>
                        <li><a href="login.php" class="btn">Logout</a></li>
                    </ul>
                </nav>
            </div>
        </span>
    </nav>
    <div class="cows" style="margin-top: -630px;margin-left:10px;">
        <h1 style="font-family: Arial, Helvetica, sans-serif; color:#663d0d; margin-left:330px; margin-top:10px">All
            Animals in Farm</h1>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $name = $row["name"];
                $earTag = $row["tag"];
                $age = $row["age"];
                //echo "<script>console.log($row)</script>";
                ?>

                <div class="manage" style="background-color: white; height: 140px; width: 650px; margin-top: 20px; margin-left: 330px;
                border: 2px solid #663D0D; position:relative;">
                    <div class="logo1">
                        <img src="logo3.png">
                    </div>
                    <div class="form">
                        <form method="POST" action="update.php">
                            <input type="hidden" name="tag" value="<?php echo $earTag; ?>">
                            <button style="background-color: white; border: 1px solid #663D0D; height: 35px; width: 70px; color: #663D0D; font-size: large; margin-top: 5px; margin-left: 440px; padding: 5px; border-radius: 5px; display: flex; flex-direction: right;"  class="btn" type="submit" name="update-btn" id="btn1">Update</button>
                        </form>
                        <form method="POST" action="">
                            <input type="hidden" name="delete-tag" value="<?php echo $earTag; ?>">
                            <button style="background-color: #663D0D;
                            border: 0px;
                            height: 35px;
                            width: 70px;
                            display: flex;
                            color: white;
                            margin-top: -35px;
                            margin-left: 519px;
                            font-size: large;
                            padding: 5px;
                            border-radius: 5px;" class="btn" type="submit" name="delete-btn" id="btn2"
                                onclick="return confirmDelete()">Delete</button>
                        </form>
                    </div>


                    <div class="content">
                        <input type="text" placeholder="ABC" name="cow-name" id="name" value="<?php echo $name; ?>" required>
                        <br>
                        <label for="pwd">Ear Tag:</label>
                        <input  type="text" name="tag" id="tag" value="<?php echo $earTag; ?>" required>
                        <label for="name">Age:</label>
                        <input type="text" name="age" id="age" value="<?php echo $age; ?>" required>
                    </div>
                </div>
                <?php
            }
        }
        $conn->close();
?>
        <script>
            function confirmDelete() {
                return confirm("Are you sure you want to delete this record?");
            }
        </script>
        <script>
            function redirectToUpdate() {
                window.location.href = 'update.php';
                return false; // Prevent form submission
            }
        </script>
        <script>
            // Reload the page after deleting a record
            window.onload = function () {
                if (window.performance && window.performance.navigation.type === 1) {
                    // The page was reloaded, clear the POST data
                    window.location.href = window.location.href;
                }
            }
        </script>
    </div>
</body>

</html>