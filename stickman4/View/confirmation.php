<?php

?>

<!DOCTYPE html>
<html>
    <head>
        <title>New Account Confirmation</title>
        <link rel="stylesheet" type="text/css" href="/17SPgroup4/stickman4/View/main.css"/>
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

                <label>User Name:</label>
                <span><?php echo htmlspecialchars($user_name); ?></span><br>

                <a href="index.php?action=login">Login</a>
            </main>
        </div>
        <?php include 'footer.php'; ?>
    </body>
</html>

