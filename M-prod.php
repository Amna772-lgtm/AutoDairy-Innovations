<?php
$servername = "localhost:3307";
$username = "root";
$password = "";
$database = "animals";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Sorry failed to connect: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['save'])) {
        $earTag = $_POST['tag'];
        $date = $_POST['mdate'];   
        $morning = $_POST['morning'];
        $evening = $_POST['evening'];
        
        //insert query
        $sql = "INSERT INTO `milk`(`tag`, `date`, `morning`, `evening`) VALUES ('$earTag','$date','$morning','$evening')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Record inserted successfully')</script>";
            header("Location: M-prod.php");
            exit;
        } else {
            echo "Error inserting record: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="M-prod.css">
    <script src="https://kit.fontawesome.com/353589d1de.js" crossorigin="anonymous"></script>
    <title>Milk</title>
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
                        <li><a href="M-prod.php" class="btn active">Milk Production</a></li><br><br>
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

    
    <div class="manage">
        <ul>
            <h1>Add Milk Details</h1>
        </ul>
    </div>
    
    <div class="details" id="form">

        <form id="cow-form" method="POST" action="">
            <div class="content" id="form">
                <label for="login">Milking Date:</label>
                <input type="date" name="mdate" id="m-date" required>
                <br>
                <label for="tag" >Ear-Tag:</label>
                <select class="tag" name="tag" id="tag" required>
                    <option value="" disabled selected>Select Ear-Tag</option>
                    <?php
                    $earTags = array();

                    // Fetch existing ear tags from the database
                    $sql = "SELECT DISTINCT tag FROM cow WHERE gender='female' AND pregnant='0'" ;
                    $result = $conn->query($sql);
                    
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $earTags[] = $row['tag'];
                        }
                    }

                    foreach ($earTags as $existingTag) {
                        echo "<option value='$existingTag'>$existingTag</option>"; 
                    }  
                                         
                    ?>
                </select>
                <br>
                <label for="morning">Morning Milk Quantity:</label>
                <input type="text" name="morning" id="morning" required>
                <br>
                <label for="evening">Evening Milk Quantity:</label>
                <input type="text" name="evening" id="evening" required>
                <br>
            </div>

            
            <div class="footer">
                <div class="form">
                    <button class="btn" name="edit" type="button" id="btn1">Edit</button>
                    <button class="btn" name="save" type="submit" id="btn2">Save</button>
                    <button class="btn" name="delete" type="submit" id="btn3">Delete</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>