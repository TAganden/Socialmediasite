<?php
include('header.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>The Stickman</title>
        <link rel="stylesheet" type="text/css" href="/17SPgroup4/stickman4/View/main.css"/>
        <link rel="stylesheet" href="/17SPgroup4/stickman4/View/nav.css">
        <link href="https://fonts.googleapis.com/css?family=Palanquin+Dark" rel="stylesheet">
    </head>
    <body>
        <div id="wrapper">
            <h1>New User Registration</h1>
            <p class="error">
                <?php
                if (isset($bValidate)) {

                    foreach ($errors as &$value) {
                        echo htmlspecialchars($value) . "<br>";
                    }
                }
                ?>
            </p>


            <form action="index.php?action=registration" method="post">
                <label>First Name: </label>
                <input type="text" name="first_name" class="textboxes" value="<?php if (isset($first_name)) {
                    echo htmlspecialchars($first_name);
                } ?>"><br>
                <br>
                <label>Last Name: </label>
                <input type="text" name="last_name" class="textboxes" value="<?php if (isset($last_name)) {
                    echo htmlspecialchars($last_name);
                } ?>"><br>
                <br>
                <label>Email Address: </label>
                <input type="text" name="email_address" class="textboxes" value="<?php if (isset($email_address)) {
                    echo htmlspecialchars($email_address);
                } ?>"><br>
                <br>
                <label>User Name: </label>
                <input type="text" name="user_name" class="textboxes" value="<?php if (isset($user_name)) {
                    echo htmlspecialchars($user_name);
                } ?>"><br>
                <br>
                <label>Password: </label>
                <input type="text" name="password" class="textboxes" value="<?php if (isset($password)) {
                    echo htmlspecialchars($password);
                } ?>"><br>
                <br>
                <input type="hidden" name= "action" value="confirmation">
                <input type="submit" value="Create Account">

            </form><br>
        </div>
        <?php include 'footer.php'; ?>
    </body>
</html>
