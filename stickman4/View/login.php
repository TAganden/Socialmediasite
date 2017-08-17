<?php 
include('header.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
        <link rel="stylesheet" type="text/css" href="/17SPgroup4/stickman4/View/main.css"/>
        <link href="https://fonts.googleapis.com/css?family=Palanquin+Dark" rel="stylesheet">
    </head>
    <body>
        <div id="sidebar">
            <h2>Site users</h2>
            <?php foreach ($showUsers as $users) : ?>
            <table>
            <tr>
                <td><a href="index.php?action=publicrequest&publicprofile=<?php echo htmlspecialchars($users['UserName']); ?>"><?php echo htmlspecialchars($users['UserName']); ?></a></td>
            </tr>
            </table>
            <?php            endforeach; ?>
        </div>
            
        
        <div id="wrapper">
        <h1>Login</h1>
        <form action=index.php?action=login" method="post">
            <label>User Name: </label>
            <input type="text" name="user_name" class="textboxes" value="<?php if (isset($user_name)) { echo $user_name; } ?>"><br>
            <br>
            <label>Password: </label>
            <input type="password" name="password" class="textboxes" value="<?php if (isset($password)) { echo $password; } ?>"><br>
            <br>
            <label><?php if (isset($loginError)) { echo $loginError; } ?></label>
            <br>
            <input type="hidden" name= "action" value="login">
            <input type="submit" value="login">
            </form><br>
        </div>
        <?php include 'footer.php'; ?>
    </body>
</html>
