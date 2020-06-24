<?php
session_start();
if(isset($_COOKIE['loggedin']) && isset($_COOKIE['username'])) {
    $_SESSION['loggedin'] = $_COOKIE['loggedin'];
    $_SESSION['username'] =$_COOKIE['username'];
}
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    header("Location:index.php");
}
include "navbar.php";
?>
<style>
    .registerContainer {
        width: 50%;
        margin: 6em auto;
        padding: 1em;
    }

    input {
        border-top-width: 0;
        border-right-width: 0;
        border-left-width: 0;
        border-bottom: 1px solid gray;
        outline: none;
        padding: 1em;
        margin: 1em 0.5em;
        width: 80%;
    }

    select {
        border-left-width: 0;
        border-right-width: 0;
        border-top-width: 0;
        border-bottom: 1px solid gray;
        width: 21%;
        padding: 0.5em;
        margin-bottom: 1em;
    }

    .trial {
        width: 70%;
        margin: 3em auto;
    }

    .date {
        margin-top: 1em
    }

    .blood select {
        width: 65%;
    }

    .required {
        color: red;
    }
</style>
<?php
$username = $fname = $lname = $ssn = $number = $dob = $blood = $password = "";
$usernameErr = $fnameErr = $lnameErr = $ssnErr = $numberErr = $dobErr = $bloodErr = $passwordErr = "";
$errors = 0;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (strlen($_POST['username']) == 0) {
        $usernameErr = "Username field cannot be empty";
        $errors++;
    } else {
        $username = testInput($_POST['username']);
    }
    if (strlen($username) > 30) {
        $usernameErr = "Field too long";
        $errors++;
    }
    if ($_POST['password'] == "") {
        $passwordErr = "Password required";
        $errors++;
    } else if (strlen($_POST['password']) >= 8 && preg_match('/[a-z]/', $_POST['password']) && preg_match('/[A-Z]/', $_POST['password'])) {
        $password = testInput($_POST['password']);
    } else {
        $passwordErr = "Password should be atleast 8 characters long & contain a lower case 
    and an uppercase letter";
        $errors++;
    }

    if ($_POST['fname'] == "") {
        $fnameErr = "First name required";
        $password = "";
        $errors++;
    } else {
        $fname = testInput($_POST['fname']);
    }
    if (strlen($fname) > 50) {
        $usernameErr = "Field too long";
        $password = "";
        $errors++;
    }
    if (!preg_match("/^[a-zA-Z ]*$/", $fname)) {
        $fnameErr = "Only letters and white spaces are allowed";
        $password = "";
        $errors++;
    }
    if ($_POST['lname'] == "") {
        $lnameErr = "Last name required";
        $password = "";
        $errors++;
    } else {
        $lname = testInput($_POST['lname']);
    }
    if (strlen($lname) > 50) {
        $lnameErr = "Field too long";
        $password = "";
        $errors++;
    }
    if (!preg_match("/^[a-zA-Z ]*$/", $lname)) {
        $lnameErr = "Only letters and white spaces are allowed";
        $password = "";
        $errors++;
    }

    if ($_POST['ssn'] == "") {
        $ssnErr = "SSN required";
        $password = "";
        $errors++;
    } else {
        $ssn = testInput($_POST['ssn']);
    }
    
    if (!preg_match("/^[1-9][0-9]{0,8}$/", $ssn) || strlen($ssn) < 9) {
        $ssnErr = "SSN not valid";
        $password = "";
        $errors++;
    }

    if ($_POST['number'] == "") {
        $numberErr = "Phone number required";
        $password = "";
        $errors++;
    } else {
        $number = testInput($_POST['number']);
    }
    if (!preg_match("/^[1-9][0-9]{0,14}$/", $number)) {
        $numberErr = "Phone number not valid";
        $password = "";
        $errors++;
    }

    if ($_POST['bloodgroup'] == "A+" || $_POST['bloodgroup'] == "A-" || $_POST['bloodgroup'] == "AB+" || $_POST['bloodgroup'] == "AB-" || $_POST['bloodgroup'] == "O+" || $_POST['bloodgroup'] == "O-") {
        $blood = testInput($_POST['bloodgroup']);
    } else {
        $bloodErr = "Invalid Blood Type";
        $password = "";
        $errors++;
    }

    $year = $_POST['year'];
    $month = $_POST['month'];
    $day = $_POST['day'];
    $dob = $year . "-" . $month . "-" . "$day";



    include "connect.php";
    $query = "select * from patientlogin where patientUser='$username'";
    if ($result = $link->query($query)) {
        if ($result->num_rows > 0) {
            $usernameErr = "The username is taken";
            $errors++;
        }
    }
    if ($errors == 0) {
        $query = "insert into patientlogin values('$username' , '$password')";
        $link->query($query);
        $query = "insert into patientinfo values('$username' , '$fname' , '$lname' , '$dob' , '$ssn' , '$number' , '$blood')";
        if ($link->query($query)) {
            $defaultProfilePicture = "default/default.png";
            mkdir("uploads/$username");
            copy($defaultProfilePicture , "uploads/$username/$username.png");
            include "loginFunction.php";
        } 
    }
}

function testInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
<form action="register.php" method="post">
    <div class="registerContainer">
        <h1>Register</h1>
        <p>Fill out the form to register your account.</p>
        <hr>
        <div class="trial">
            <input type="text" name="username" placeholder="Username" <?php echo "value=" . $username ?>>
            <span class="required"><?php if ($usernameErr != "") echo "<br>" . "*" . $usernameErr; ?> </span>
            <br>
            <input type="password" name="password" placeholder="Password">
            <span class="required"> <?php if ($passwordErr != "") echo "<br>" . "*" . $passwordErr; ?> </span>
            <br>
            <input type="text" name="fname" placeholder="First name" <?php echo "value=" . $fname ?>>
            <span class="required"> <?php if ($fnameErr != "") echo "<br>" . "*" . $fnameErr; ?> </span>
            <br>
            <input type="text" name="lname" placeholder="Last name" <?php echo "value=" . $lname ?>>
            <span class="required"> <?php if ($lnameErr != "") echo "<br>" . "*" . $lnameErr; ?> </span>
            <br>
            <input type="text" name="ssn" placeholder="SSN" <?php echo "value=" . $ssn ?>>
            <span class="required"><?php if ($ssnErr != "") echo "<br>" . "*" . $ssnErr; ?> </span>
            <br>
            <input type="text" name="number" placeholder="Phone number" <?php echo "value=" . $number ?>>
            <span class="required"><?php if ($numberErr != "") echo "<br>" . "*" . $numberErr; ?> </span>
            <br>
            <div class="date">
                <label for="day">Date of birth: </label>
                <select name="day">
                    <option selected="selected" value="">Day</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                    <option value="13">13</option>
                    <option value="14">14</option>
                    <option value="15">15</option>
                    <option value="16">16</option>
                    <option value="17">17</option>
                    <option value="18">18</option>
                    <option value="19">19</option>
                    <option value="20">20</option>
                    <option value="21">21</option>
                    <option value="22">22</option>
                    <option value="23">23</option>
                    <option value="24">24</option>
                    <option value="25">25</option>
                    <option value="26">26</option>
                    <option value="27">27</option>
                    <option value="28">28</option>
                    <option value="29">29</option>
                    <option value="30">30</option>
                    <option value="31">31</option>
                </select>
                <select name="month">
                    <option selected="selected" value="">Month</option>
                    <option value="1">January</option>
                    <option value="2">February</option>
                    <option value="3">March</option>
                    <option value="4">April</option>
                    <option value="5">May</option>
                    <option value="6">June</option>
                    <option value="7">July</option>
                    <option value="8">August</option>
                    <option value="9">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                </select>
                <select name="year">
                    <option selected="selected" value="">Year</option>
                    <option value="2019">2019</option>
                    <option value="2018">2018</option>
                    <option value="2017">2017</option>
                    <option value="2016">2016</option>
                    <option value="2015">2015</option>
                    <option value="2014">2014</option>
                    <option value="2013">2013</option>
                    <option value="2012">2012</option>
                    <option value="2011">2011</option>
                    <option value="2010">2010</option>
                    <option value="2009">2009</option>
                    <option value="2008">2008</option>
                    <option value="2007">2007</option>
                    <option value="2006">2006</option>
                    <option value="2005">2005</option>
                    <option value="2004">2004</option>
                    <option value="2003">2003</option>
                    <option value="2002">2002</option>
                    <option value="2001">2001</option>
                    <option value="2000">2000</option>
                    <option value="1999">1999</option>
                    <option value="1998">1998</option>
                    <option value="1997">1997</option>
                    <option value="1996">1996</option>
                    <option value="1995">1995</option>
                    <option value="1994">1994</option>
                    <option value="1993">1993</option>
                    <option value="1992">1992</option>
                    <option value="1991">1991</option>
                    <option value="1990">1990</option>
                    <option value="1989">1989</option>
                    <option value="1988">1988</option>
                    <option value="1987">1987</option>
                    <option value="1986">1986</option>
                    <option value="1985">1985</option>
                    <option value="1984">1984</option>
                    <option value="1983">1983</option>
                    <option value="1982">1982</option>
                    <option value="1981">1981</option>
                    <option value="1980">1980</option>
                    <option value="1979">1979</option>
                    <option value="1978">1978</option>
                    <option value="1977">1977</option>
                    <option value="1976">1976</option>
                    <option value="1975">1975</option>
                    <option value="1974">1974</option>
                    <option value="1973">1973</option>
                    <option value="1972">1972</option>
                    <option value="1971">1971</option>
                    <option value="1970">1970</option>
                    <option value="1969">1969</option>
                    <option value="1968">1968</option>
                    <option value="1967">1967</option>
                    <option value="1966">1966</option>
                    <option value="1965">1965</option>
                    <option value="1964">1964</option>
                    <option value="1963">1963</option>
                    <option value="1962">1962</option>
                    <option value="1961">1961</option>
                    <option value="1960">1960</option>
                    <option value="1959">1959</option>
                    <option value="1958">1958</option>
                    <option value="1957">1957</option>
                    <option value="1956">1956</option>
                    <option value="1955">1955</option>
                    <option value="1954">1954</option>
                    <option value="1953">1953</option>
                    <option value="1952">1952</option>
                    <option value="1951">1951</option>
                    <option value="1950">1950</option>
                    <option value="1949">1949</option>
                    <option value="1948">1948</option>
                    <option value="1947">1947</option>
                    <option value="1946">1946</option>
                    <option value="1945">1945</option>
                    <option value="1944">1944</option>
                    <option value="1943">1943</option>
                    <option value="1942">1942</option>
                    <option value="1941">1941</option>
                    <option value="1940">1940</option>
                    <option value="1939">1939</option>
                    <option value="1938">1938</option>
                    <option value="1937">1937</option>
                    <option value="1936">1936</option>
                    <option value="1935">1935</option>
                    <option value="1934">1934</option>
                    <option value="1933">1933</option>
                    <option value="1932">1932</option>
                    <option value="1931">1931</option>
                    <option value="1930">1930</option>
                </select>
            </div>
            <br>
            <div class="blood">
                <label for="bloodgroup">Blood group: </label>
                <select name="bloodgroup">
                    <option selected value="A+">A+</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B-">B-</option>
                    <option value="AB+">AB+</option>
                    <option value="AB-">AB-</option>
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                </select>
                <span class="required"><?php if ($bloodErr != "") echo "<br>" . "*" . $bloodErr; ?> </span>
            </div>
            <br>
        </div>

        <input type="submit" value="Register">
    </div>
</form>
<?php include "footer.php" ?>