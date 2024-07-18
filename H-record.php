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
        $tag = $_POST['tags'];
        $symptom = $_POST['symptom'];
        $treatment = $_POST['treatment'];
        $vet = $_POST['vet'];
        $cost = $_POST['cost'];
        $hdate = $_POST['hdate'];

        // Prepare the INSERT statement with placeholders
        $sql = "INSERT INTO `health` (`tag`, `symptoms`, `treatment`, `vet`, `cost`, `date`) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            // Bind the values to the prepared statement
            $stmt->bind_param("ssssss", $tag, $symptom, $treatment, $vet, $cost, $hdate);

            // Execute the prepared statement
            if ($stmt->execute()) {
                echo "<script>alert('Record inserted successfully')</script>";
                header("Location: H-record.php");
                exit;
            } else {
                echo "Error executing statement: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        } else {
            echo "Error preparing statement: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="H-record.css">
    <script src="https://kit.fontawesome.com/353589d1de.js" crossorigin="anonymous"></script>
    <title>Health</title>
    <style>
        .disabled {
            opacity: 0.5;
            pointer-events: none;
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
                        <li><a href="A-details.php" class="btn">Animal Details</a></li><br><br>
                        <li><a href="H-record.php" class="btn active">Health Record</a></li><br><br>
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


    <div class="health">
        <ul>
            <h1>Health Report</h1>
        </ul>
    </div>

    <div class="details" id="form">

        <form id="cow-form" method="POST" action="">
            <div class="content" id="form">
                <label for="login">Date:</label>
                <input type="date" name="hdate" id="h-date" required>
                <br>
                <label for="tag" >Ear-Tag:</label>
                <select class="tag" name="tag" id="tag" required>
                    <option value="" disabled selected>Select Ear-Tag</option>
                    <!--<?php
                    $earTags = array();

                    // Fetch existing ear tags from the database
                    $sql = "SELECT DISTINCT tag FROM cow";
                    $result = $conn->query($sql);
                    
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $earTags[] = $row['tag'];
                        }
                    }

                    foreach ($earTags as $existingTag) {
                        echo "<option value='$existingTag'>$existingTag</option>";
                    }                    
                    ?>-->
                </select>
                <br>
                <label for="temperature">Temperature:</label>
                <input type="text" name="temp" id="temp" required>
                <br>
                <label for="diet">Diet-Intake:</label>
                <input type="text" name="diet" id="diet" required>
                <br>
                <label for="sick">Sick:</label>
                <input type="checkbox" name="sick" id="sick" >
                <br>
                <label for="symptom">Symptoms:</label>
                <input type="text" name="symptom" id="symp">
                <br>
                <label for="treatment">Treatment:</label>
                <input type="text" name="treatment" id="treat">
                <br>
                <label for="vet">Vet Name:</label>
                <input type="text" name="vet" id="vet">
                <br>
                <label for="cost">Cost:</label>
                <input type="text" name="cost" id="Cost">
                <br>
            </div>


            <div class="footer">
                <div class="form">
                    <button class="btn" type="button" name="edit" id="btn1">Edit</button>
                    <button class="btn" type="submit" name="save" id="btn2">Save</button>
                    <button class="btn" type="submit" name="delete" id="btn3">Delete</button>
                </div>
            </div>
            <br><br>
        </form>
    </div>
    
    <!--<script>
        function toggleFields() {
            var sickCheckbox = document.getElementById('sick');
            var symptomInput = document.getElementById('symp');
            var treatmentInput = document.getElementById('treat');
            var vetInput = document.getElementById('vet');
            var costInput = document.getElementById('Cost');

            if (sickCheckbox.checked) {
                symptomInput.removeAttribute("disabled", "disabled");
                treatmentInput.removeAttribute("disabled", "disabled");
                vetInput.removeAttribute("disabled", "disabled");
                costInput.removeAttribute("disabled", "disabled");
            } else {
                symptomInput.setAttribute("disabled", "disabled");
                treatmentInput.setAttribute("disabled", "disabled");
                vetInput.setAttribute("disabled", "disabled");
                costInput.setAttribute("disabled", "disabled");
            }
        }

       
    </script>-->
</body>

</html>