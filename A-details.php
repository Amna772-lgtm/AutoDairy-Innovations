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
        $name = $_POST['name'];
        $age = $_POST['age'];
        $color = $_POST['color'];
        $height = $_POST['height'];
        $weight = $_POST['weight'];
        $breed = $_POST['breed'];
        $gender = $_POST['flexRadioDefault'];
        // Check if the animal is female
        if ($gender == 'female') {
            $pregnant = isset($_POST['pregnant']) ? 1 : 0; // Checkbox is checked: 1, not checked: 0
            $pDate = isset($_POST['p-date']) ? $_POST['p-date'] : '0';
        } else {
            $pregnant = 0; // Not pregnant for male animals
            $pDate = '0'; // Set P-date as '0' for male animals
        }

        //insert query
        $sql = "INSERT INTO `cow`(`tag`, `name`, `age`, `colour`, `height`, `weight`, `breed`, `gender`, `pregnant`, `p-date`) VALUES ('$earTag','$name','$age','$color','$height','$weight','$breed','$gender','$pregnant','$pDate')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Record inserted successfully')</script>";
            header("Location: A-details.php");
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="A-details.css">
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
                <input type="text" name="tag" id="tag" required>
                <br>
                <label for="login">Name:</label>
                <input type="text" name="name" id="name" required>
                <br>
                <label for="name">Age:</label>
                <input type="text" name="age" id="age" required>
                <br>
                <label for="color">Color:</label>
                <input type="text" name="color" id="color" required>
                <br>
                <label for="height">Height:</label>
                <input type="text" name="height" id="height" required>
                <br>
                <label for="weight">Weight:</label>
                <input type="text" name="weight" id="weight" required>
                <br>
                <label for="breed">Breed:</label>
                <select class="breed" id="breed" name="breed" required>
                    <option value="" disabled selected>Select Breed</option>
                    <option value="sahiwal">Sahiwal</option>
                    <option value="red-sindhi">Red Sindhi</option>
                    <option value="tharparker">Tharparker</option>
                    <option value="rojhan">Rojhan</option>
                </select><br>
                <br>
                <label for="gender">Gender:</label>
                <div class="form-check1">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" value="male"
                        id="flexRadioDefault1">
                    <label class="form-check-label" name="male" for="flexRadioDefault2">
                        Male
                    </label>
                    <br>
                </div>
                <div class="form-check2">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" value="female"
                        id="flexRadioDefault2">
                    <label class="form-check-label" name="female" for="flexRadioDefault2">
                        Female
                    </label>
                    <br>
                </div>
                <br>
                <label for="pregnant">Pregnant:</label>
                <input type="checkbox" name="pregnant" id="pregnant">
                <br>
                <label for="pregnancy">Pregnancy Date:</label>
                <input type="date" name="p-date" id="p-date">
                <br>
                <div class="footer">
                    <div class="form">
                        <button class="btn" type="button" id="btn1" onclick="clearForm()">Clear</button>
                        <button class="btn" type="submit" value="submit" id="btn2" name="save">Save</button>
                    </div>
                </div>
                <br><br>
            </div>
        </form>
    </div>

    <script>
        function togglePregnancyDate() {
            var maleRadio = document.getElementById("flexRadioDefault1");
            var femaleRadio = document.getElementById("flexRadioDefault2");
            var pregnantCheckbox = document.getElementById("pregnant");
            var pregnancyDateField = document.getElementById("p-date");

            if (femaleRadio.checked) {
                if (pregnantCheckbox.checked) {
                    pregnancyDateField.removeAttribute("disabled", "disabled");
                }
                pregnantCheckbox.removeAttribute("disabled");
            } else {
                pregnantCheckbox.setAttribute("disabled", "disabled");
                pregnancyDateField.setAttribute("disabled", "disabled");
            }
        }

        var checkBOX = document.getElementById("pregnant");
        checkBOX.addEventListener('change', (event) => {
            var pregnancyDateField = document.getElementById("p-date");
            if (event.currentTarget.checked) {
                pregnancyDateField.removeAttribute("disabled", "disabled");
            } else {
                pregnancyDateField.setAttribute("disabled", "disabled");
            }
        });

        var maleRadio = document.getElementById("flexRadioDefault1");
        maleRadio.addEventListener("change", togglePregnancyDate);
        var femaleRadio = document.getElementById("flexRadioDefault2");
        femaleRadio.addEventListener("change", togglePregnancyDate);
        togglePregnancyDate();
    </script>
    <script>
        function clearForm() {
            document.getElementById("cow-form").reset();
        }
    </script>
</body>