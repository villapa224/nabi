<?php
    session_start();
    if (isset($_SESSION["user"])) {
        header("Location: login.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registration Form</title>
<meta content="" name="description">
<meta content="" name="keywords">
<script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>

 <!-- Favicons -->
 <link href="assets/img/logo.png" rel="icon">
 <link href="assets/img/logo.png" rel="apple-touch-icon">



 <!-- Google Fonts -->
 <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

 <!-- Vendor CSS Files -->

 <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
 <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
 <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
 <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
 <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
 <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

<link rel="stylesheet" href="assets/css/registration.css">
</head>
<body>

  <div class="feedbacks-container">

  <?php
            if(isset($_POST["Register"])){
                $LastName = $_POST["lastName"];
                $FirstName = $_POST["firstName"];
                $country = $_POST["country"];
                $state = $_POST["state"];
                $city = $_POST["city"];
                $barangay = $_POST["barangay"];
                $email = $_POST["email"];
                $password = $_POST["password"];
                $repeatPassword = $_POST["repeatPassword"];

                $contactnumber = $_POST["contactNumber"];
                
                $blklot = $_POST["lotBlk"];
                $street = $_POST["street"];
                $subd = $_POST["phaseSubdivision"];

                $passwordHash = password_hash($password, PASSWORD_DEFAULT); // NEW
                $errors = array();

                if (empty($LastName) OR empty($FirstName) OR empty($email) OR empty($password) OR empty($repeatPassword) OR empty($country) OR empty($state) OR empty($city) OR empty($barangay) OR empty($contactnumber) OR empty($blklot) OR empty($street) OR empty($subd)) {
                    array_push($errors, "All fields are required");
                }
                
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    array_push($errors, "Email is not valid");
                }

                if (strlen($password)<8) {
                    array_push($errors, "Password must be at least 8 characters long");
                }

                if ($password!= $repeatPassword) {
                    array_push($errors, "Password does not match");
                }

                require_once "database.php";
                $sql  = "SELECT * FROM re WHERE email = '$email'";
                $result = mysqli_query($conn, $sql);
                $rowCount = mysqli_num_rows($result);
                if ($rowCount>0) {
                    array_push($errors, "Email Already Exist!");
                }

                if (count($errors)>0) {
                    foreach($errors as $error) {
                        echo"<div class='alert alert-danger'>$error</div>";
                        }
                } else {
                    require_once "database.php";
                    $sql  = "INSERT INTO re (lastName, firstName, Email, Password, lotBlk, street, phaseSubdivision, barangay, city, state, country, contactNumber) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    $stmt = mysqli_stmt_init($conn);
                    $preparestmt = mysqli_stmt_prepare($stmt, $sql);
                    if ($preparestmt) {
                        mysqli_stmt_bind_param($stmt, "ssssssssssss", $LastName, $FirstName, $email, $passwordHash, $blklot, $street, $subd, $barangay, $city, $state, $country, $contactnumber);
                        mysqli_stmt_execute($stmt);
                        echo "<div class = 'alert alert-success'>You are registered successfully! </div>";
                    } else {
                        die("Something went wrong.");
                    }
                }
            }   
            ?>

    <div class="transparent-box">
        <div class="container">
            <form method="post">
                <h2>REGISTRATION</h2>
                <h3>FULL NAME</h3>
                <div class="form-group">
                    <label for="lastName">Last Name</label>
                    <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Enter Last Name" required>
                </div>
                <div class="form-group">
                    <label for="firstName">First Name</label>
                    <input type="text" class="form-control" id="firstName" name="firstName" placeholder="Enter First Name" required>
                </div>

                <h3>ADDRESS</h3>
                <div class="form-group">
                    <label for="country">Country</label>
                    <select class="form-control" id="country" name="country" required>
                        <option selected>Select Country</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="state">State/Province</label>
                    <select class="form-control" id="state" name="state" required>
                        <option selected>Select State/Province</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="city">City/Municipality</label>
                    <select class="form-control" id="city" name="city" required>
                        <option selected>Select City/Municipality</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="lotBlk">Lot/Block</label>
                    <input type="text" class="form-control" id="lotBlk" name="lotBlk" placeholder="Enter Lot/Block" required>
                </div>
                <div class="form-group">
                    <label for="street">Street</label>
                    <input type="text" class="form-control" id="street" name="street" placeholder="Enter Street" required>
                </div>
                <div class="form-group">
                    <label for="phaseSubdivision">Phase/Subdivision</label>
                    <input type="text" class="form-control" id="phaseSubdivision" name="phaseSubdivision" placeholder="Enter Phase/Subdivision" required>
                </div>
                <div class="form-group">
                    <label for="barangay">Barangay</label>
                    <input type="text" class="form-control" id="barangay" name="barangay" placeholder="Enter Barangay" required>
                </div>
                <div class="form-group">
                    <label for="contactNumber">Contact Number</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="phoneCode" readonly>
                        <input type="text" class="form-control" id="contactNumber" name="contactNumber" placeholder="Enter Contact Number">
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                </div>
                <div class="form-group">
                    <label for="repeatPassword">Repeat Password</label>
                    <input type="password" class="form-control" id="repeatPassword" name="repeatPassword" placeholder="Repeat Password">
                </div>
                
                <button type="submit" class="btn btn-primary" name="Register">Submit</button>
                
            </form>
            <div><p>Already have an Account <a href="login.php"> Login Here</a></div>

            <?php

if (isset($_SESSION['error'])) {
    echo '<div class="alert alert-danger" role="alert">' . $_SESSION['error'] . '</div>';
    unset($_SESSION['error']);
}

?>


                </div>
            </div>
        </div>


<script>

let data = [];

document.addEventListener('DOMContentLoaded', function() {
    fetch('https://raw.githubusercontent.com/dr5hn/countries-states-cities-database/master/countries%2Bstates%2Bcities.json')
        .then(response => response.json())
        .then(jsonData => {
            data = jsonData;
            const countries = data.map(country => country.name);
            populateDropdown('country', countries);
        })
        .catch(error => console.error('Error fetching countries:', error));
});

function populateDropdown(dropdownId, data) {
    const dropdown = document.getElementById(dropdownId);
    dropdown.innerHTML = '';
    data.forEach(item => {
        const option = document.createElement('option');
        option.value = item;
        option.text = item;
        dropdown.add(option);
    });
}

document.getElementById('country').addEventListener('change', function() {
    const selectedCountry = this.value;
    const countryData = data.find(country => country.name === selectedCountry);
    if (countryData && countryData.states) {
        const states = countryData.states.map(state => state.name);
        populateDropdown('state', states);
    }
    const phoneCode = countryData ? countryData.phone_code : '';
    document.getElementById('phoneCode').value = phoneCode;
});

document.getElementById('state').addEventListener('change', function() {
    const selectedState = this.value;
    const countryData = data.find(country => country.name === document.getElementById('country').value);
    if (countryData) {
        const stateData = countryData.states.find(state => state.name === selectedState);
        if (stateData && stateData.cities) {
            const cities = stateData.cities.map(city => city.name);
            populateDropdown('city', cities);
        } else {
            console.log('No cities found for state:', selectedState);
        }
    } else {
        console.log('Country data not found for state:', selectedState);
    }
});

</script>
<script src="assets/js/registration.js"></script>
</body>
</html>
