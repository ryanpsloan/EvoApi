<!DOCTYPE html>
    <html>
<head>
    <title>Evo API Access</title>
    <style>
        body{
            background-color: lightblue;
        }

    </style>
</head>
<body>
<form name="logInForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
<table>
    <thead>
        <th>LOG IN</th>
    </thead>
    <tbody>
        <tr><td><input type="text" name="username"></td></tr>
        <tr><td><input type="text" name="password"></td></tr>
        <tr><td><input type="submit"></td></tr>
    </tbody>
</table>
</form>


</body>
</html>
<?php
session_start();
include_once("evoapi.php");
include_once("connect.php");

if(isset($_POST) && !empty($_POST)) {
    $mysqli = MysqliConfiguration::getMysqli();

    //create query
    $query = "SELECT username, password FROM user WHERE userId = ?";
    $statement = $mysqli->prepare($query);
    if($statement === false) {
        throw(new mysqli_sql_exception("Unable to prepare statement"));
    }
    // bind the email to the place holder in the template
    $num = 1;
    $wasClean = $statement->bind_param("i", $num);
    if($wasClean === false) {
        throw(new mysqli_sql_exception("Unable to bind parameters"));
    }
    // execute the statement
    if($statement->execute() === false) {
        throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
    }
    // get result from the SELECT query *pounds fists*
    $result = $statement->get_result();
    if($result === false) {
        throw(new mysqli_sql_exception("Unable to get result set"));
    }
    // since this is a unique field, this will only return 0 or 1 results. So...
    // 1) if there's a result, we can make it into a User object normally
    // 2) if there's no result, we can just return null
    $row = $result->fetch_assoc();
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);

    if($username == $row['username'] && $password = $row['password']) {
        header("Location: viewapi.php");
    }else{
        echo "<p>Username/Password Combination Incorrect</p>";
    }
}



?>