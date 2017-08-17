<?php
$first_name = filter_input(INPUT_POST, 'first_name');
$last_name = filter_input(INPUT_POST, 'last_name');
$email_address = filter_input(INPUT_POST, 'email_address', FILTER_VALIDATE_EMAIL);
$password = filter_input(INPUT_POST, 'password');
$user_name = filter_input(INPUT_POST, 'user_name');
$error_message = '';




//initialize error messages array
$errors = array();

if ($first_name === NULL || $first_name === "") {
    $errors[] = 'First Name is Required';
    //$error_message='First Name is Required';  //just added these for testing purposes.  You can delete this.
    $bValidate = False;
}

if ($last_name === NULL || $last_name === "") {
    $errors[] = 'Last Name is Required';
    // $error_message='Last Name is Required';  //just added these for testing purposes.  You can delete this.
    $bValidate = False;
}

if ($email_address === NULL || filter_input(INPUT_POST, 'email_address') === "") {
    $errors[] = 'Email is Required';
    // $error_message='Email is Required';  //just added these for testing purposes.  You can delete this.
    $bValidate = False;
} else if (!$email_address) {
    $errors[] = 'Email is in incorrect format';
    $bValidate = False;
}

if ($password === NULL || $password === "") {
    $errors[] = 'Password is Required';
    // $error_message='Password is Required';  //just added these for testing purposes.  You can delete this.
    $bValidate = False;
}

if ($user_name === NULL || $user_name === "") {
    $errors[] = 'UserName is Required';
    // $error_message='UserName is Required';  //just added these for testing purposes.  You can delete this.
    $bValidate = False;
}

//if user name unique
require_once('database.php');
$selectquery = 'select * from users where username= :username;';
$statement2 = $db->prepare($selectquery);
$statement2->bindValue(':username', $user_name);
$statement2->execute();
$users = $statement2->fetch();
$statement2->closeCursor();
$selectquery2 = 'select * from users where email= :email;';
$statement3 = $db->prepare($selectquery2);
$statement3->bindValue(':email', $email_address);
$statement3->execute();
$emails = $statement3->fetch();
$statement3->closeCursor();

if ($users != null) {
    $errors[] = 'Username must be unique';
    $bValidate = false;
}

if ($emails != null) {
    $errors[] = 'Email must be unique';
    $bValidate = false;
}

if (!empty($errors)) {
    include('index.php');
    exit();
}
?>

<?php
require_once('database.php');



$query = 'INSERT INTO users
                 (UserName,FirstName,LastName,Email,Password)
              VALUES
                 (:username, :firstname, :lastname, :email, :password)';
$statement = $db->prepare($query);
$statement->bindValue(':username', $user_name);
$statement->bindValue(':firstname', $first_name);
$statement->bindValue(':lastname', $last_name);
$statement->bindValue(':email', $email_address);
$statement->bindValue(':password', $password);
$statement->execute();
$statement->closeCursor();
?>

<?
    $to=$email_address;
    $subject='Stickman Account Creation';
    $message='The account is created.  Thank you.  Have fun.';
    mail($to, $subject, $message);
?> 

<!DOCTYPE html>
<html>
    <head>
        <title>New Account Confirmation</title>
        <link rel="stylesheet" type="text/css" href="main.css"/>
        <link href="https://fonts.googleapis.com/css?family=Palanquin+Dark" rel="stylesheet">
    </head>
    <body>
        <div id="wrapper">
            <main>
                <h1>New Account Confirmation</h1>

                <label>First Name:</label>
                <span><?php echo htmlspecialchars($first_name); ?></span><br>

                <label>Last Name:</label>
                <span><?php echo htmlspecialchars($last_name); ?></span><br>

                <label>Email Address:</label>
                <span><?php echo htmlspecialchars($email_address); ?></span><br>

                <label>Password:</label>
                <span><?php echo htmlspecialchars($password); ?></span><br>

                <label>User Name:</label>
                <span><?php echo htmlspecialchars($user_name); ?></span><br>

            </main>
        </div>
    </body>
</html>
