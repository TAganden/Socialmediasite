<?php ?>
<html>
    <head>
        <link rel="stylesheet" href="/17SPgroup4/stickman4/View/nav.css">    
    </head>
    <nav>
        <ul>
            <li><a href="index.php?action=initiallogin">Login</a>
            </li>
                
            <li><a href="index.php?action=profile"><?php if(isset($_SESSION['Profile']['UserName'])&&!empty($_SESSION['Profile']['UserName'])){echo htmlspecialchars('Profile');} ?></a></li>
            <li><a href="index.php?action=registration">Registration</a></li>
            <li id=welcome><?php if(isset($_SESSION['Profile']['UserName'])&&!empty($_SESSION['Profile']['UserName'])){echo htmlspecialchars('Welcome  '.$_SESSION['Profile']['UserName']);} ?></li>
            <li><a href="index.php?action=logout">Logout</a> </li>
        </ul>
    </nav>
</html>
