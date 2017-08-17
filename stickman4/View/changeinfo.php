<?php
include('header.php');
?>

<!DOCTYPE html>

<html>
<head>
        <meta charset="UTF-8">
        <title>Change Info Page</title>
        <link rel="stylesheet" type="text/css" href="/17SPgroup4/stickman4/View/main.css"/>
        <link href="https://fonts.googleapis.com/css?family=Palanquin+Dark" rel="stylesheet">
    </head>
    <body>
        
        <p style="text-align:center;" class="error">
                <?php
                if (isset($bValidate)) {

                    foreach ($errors as &$value) {
                        echo $value . "<br>";
                    }
                }
                ?>
            </p>

        <div id="wrapper">
            <form action="index.php?action=changeinfo" method="post">
                <label>First Name: </label>
                <input type="text" name="first_name" class="textboxes" value="<?php if (isset($_SESSION['Profile']['FirstName'])) {
                     echo htmlspecialchars($_SESSION['Profile']['FirstName']);
                } ?>"><br>
                <br>
                <label>Last Name: </label>
                <input type="text" name="last_name" class="textboxes" value="<?php if (isset($_SESSION['Profile']['LastName'])) {
                    echo htmlspecialchars($_SESSION['Profile']['LastName']);
                } ?>"><br>
                <br>
                <label>Email Address: </label>
                <input type="text" name="email_address" class="textboxes" value="<?php if (isset($_SESSION['Profile']['Email'])) {
                    echo htmlspecialchars($_SESSION['Profile']['Email']);
                } ?>"><br>
                <br>
                <label>Password: </label>
                <input type="text" name="password" class="textboxes" value="<?php if (isset($password)) {
                    echo htmlspecialchars($password);
                } ?>"><br>
                <input type="hidden" name= "action" value="edit">
                <input type="submit" value="Update Info">
            </form>
        </div>

        <?php include 'footer.php'; ?>
    </body>
</html>

