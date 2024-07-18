<?php
$servername = "localhost:3307";
$username = "root";
$password = "";
$database = "animals";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Sorry failed to connect: " . $conn->connect_error);
}

$earTag = $_POST['tag'];

// Fetch animal data from the database
$sql = "SELECT * FROM cow WHERE tag='$earTag'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $name = $row['name'];
    $age = $row['age'];
    $color = $row['colour'];
    $height = $row['height'];
    $weight = $row['weight'];
    $breed = $row['breed'];
    $gender = $row['gender'];
    $pregnant = $row['pregnant'];
    $pDate = $row['p-date'];
} else {
    echo "<script>alert('Record not found')</script>";
}

// Handle update request
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update'])) {
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $age = isset($_POST['age']) ? $_POST['age'] : '';
    $color = isset($_POST['color']) ? $_POST['color'] : '';
    $height = isset($_POST['height']) ? $_POST['height'] : '';
    $weight = isset($_POST['weight']) ? $_POST['weight'] : '';
    $breed = isset($_POST['breed']) ? $_POST['breed'] : '';
    $gender = isset($_POST['flexRadioDefault']) ? $_POST['flexRadioDefault'] : '';
    $pregnant = isset($_POST['pregnant']) ? 1 : 0; // Checkbox is checked: 1, not checked: 0
    $pDate = isset($_POST['p-date']) ? $_POST['p-date'] : '0';

    // Update record in the database
    $updateSql = "UPDATE `cow` SET `name`='$name', `age`='$age', `colour`='$color', `height`='$height', `weight`='$weight', `breed`='$breed', `gender`='$gender', `pregnant`='$pregnant', `p-date`='$pDate' WHERE `tag`='$earTag'";
    if ($conn->query($updateSql) === TRUE) {
        echo "<script>alert('Record updated successfully')</script>";
        header("Location: manage.php");
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="update.css">
    <script src="https://kit.fontawesome.com/353589d1de.js" crossorigin="anonymous"></script>
    <title>Animal Details</title>

    <style>
        .disabled {
            opacity: 0.5;
        }
    </style>
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
                        <li><a href="A-details.php" class="btn active">Animal Details</a></li><br><br>
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

    <div class="manage">
        <ul>
            <h1>Animal Details</h1>
            <li><a href="manage.php" class="btn">Show all</a></li>
        </ul>
    </div>


    <div class="details" id="form">
        <form id="cow-form" method="POST" action="">
            <div class="content" id="form">
                <label for="pwd">Ear Tag:</label>
                <input type="text" name="tag" id="tag" required value="<?php echo $earTag; ?>" readonly>
                <br>
                <label for="login">Name:</label>
                <input type="text" name="name" id="name" required value="<?php echo $name; ?>">
                <br>
                <label for="name">Age:</label>
                <input type="text" name="age" id="age" required value="<?php echo $age; ?>">
                <br>
                <label for="color">Color:</label>
                <input type="text" name="color" id="color" required value="<?php echo $color; ?>">
                <br>
                <label for="height">Height:</label>
                <input type="text" name="height" id="height" required value="<?php echo $height; ?>">
                <br>
                <label for="weight">Weight:</label>
                <input type="text" name="weight" id="weight" required value="<?php echo $weight; ?>">
                <br>
                <label for="breed">Breed:</label>
                <select class="breed" name="breed" id="breed" required>
                    <option value="" disabled>Select Breed</option>
                    <option value="sahiwal" <?php if ($breed == 'sahiwal')
                        echo 'selected'; ?>>Sahiwal</option>
                    <option value="red-sindhi" <?php if ($breed == 'red-sindhi')
                        echo 'selected'; ?>>Red Sindhi</option>
                    <option value="tharparker" <?php if ($breed == 'tharparker')
                        echo 'selected'; ?>>Tharparker</option>
                    <option value="rojhan" <?php if ($breed == 'rojhan')
                        echo 'selected'; ?>>Rojhan</option>
                </select>
                <br>
                <label for="gender">Gender:</label>
                <div class="form-check1">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" value="male"
                        id="flexRadioDefault1" <?php if ($gender == 'male')
                            echo 'checked'; ?>>
                    <label class="form-check-label" for="flexRadioDefault2">
                        Male
                    </label>
                    <br>
                </div>
                <div class="form-check2">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" value="female"
                        id="flexRadioDefault2" <?php if ($gender == 'female')
                            echo 'checked'; ?>>
                    <label class="form-check-label" for="flexRadioDefault2">
                        Female
                    </label>
                    <br>
                </div>
                <br>
                <label for="pregnant">Pregnant:</label>
                <input type="checkbox" name="pregnant" id="pregnant" <?php if ($pregnant == 1)
                    echo 'checked'; ?>>
                <br>
                <label for="pregnancy">Pregnancy Date:</label>
                <input type="date" name="p-date" id="p-date" <?php if ($pregnant == 1)
                    echo 'value="' . $pDate . '"'; ?>>
                <br>
                <div class="footer">
                    <div class="form">
                        <button style="margin-left:550" class="btn" type="submit" value="submit" id="btn2" name="update">Update</button>
                    </div>
                </div>
                <br><br>
            </div>
        </form>
    </div>
    
</body>

</html>