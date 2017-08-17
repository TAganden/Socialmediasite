<?php
include('header.php');
?>

<!DOCTYPE html>

<html>
<head>
        <meta charset="UTF-8">
        <title>Profile Page</title>
        <link rel="stylesheet" type="text/css" href="/17SPgroup4/stickman4/View/main.css"/>
        <link href="https://fonts.googleapis.com/css?family=Palanquin+Dark" rel="stylesheet">
    </head>
    <body>

        <div id="wrapper">
            <header>
                <div id="profile_pic">
                    <h1><?php if(isset($profileusername))
                        {echo htmlspecialchars($profilefirstname." ".$profilelastname)."'s";}
                        ?> Page</h1>
                    <img  src="<?php echo ("/17SPgroup4/stickman4/".$profileimage); ?>" width="150px" height="150px"><br>
                    <p id="image">
                        <?php 
                        if(isset($_SESSION['Profile']['UserName'])&&$_SESSION['Profile']['UserName'] ===  $profileusername): ?>
                        <a href='index.php?action=image_upload' >Upload a Profile Pic</a>
                        
                        <?php endif ?>
                    </p>
                    <?php 
                        if(isset($_SESSION['Profile']['UserName'])&&$_SESSION['Profile']['UserName'] ===  $profileusername): ?>
                    <p>
                        <a href="index.php?action=initialedit"><?php if(isset($profileusername)&&!empty($profileusername)){echo htmlspecialchars('Edit Information');} ?></a>
                    </p>
                    
                        <?php endif ?>
                
                <table>
                    <tr>
                        <th>Email Address: </th>
                        <td><?php echo htmlspecialchars($profileemail)?></td>
                    </tr>
                    <tr> 
                        <th>User Name: </th>
                        <td><?php echo htmlspecialchars($profileusername)?></td>
                    </tr>
                    <tr>
                        <th>First Name: </th>
                        <td><?php echo htmlspecialchars($profilefirstname)?></td>
                    </tr>
                    <tr>
                        <th>Last Name: </th>
                        <td><?php echo htmlspecialchars($profilelastname)?></td>
                    </tr>
                </table>
            <?php if(isset($_SESSION['Profile']['UserName'])&&strlen($_SESSION['Profile']['UserName'])>0): ?>
                    <form action="index.php?action=writewall" method="post">
                        <h2>Write on wall:</h2>
                        <textarea name="message"></textarea>
                        <input type="hidden" name= "currentprofile" value="<?php echo $profileusername ?>">
                        <input type="hidden" name= "action" value="writewall">
                        <input type="submit" value="Write Message">
                    </form>
            <?php endif ?>
                    
                    <h2>Wall Posts</h2>
             <?php if(isset($nowallmessage)&&strlen($nowallmessage)>0){echo $nowallmessage;} ?>
             <?php if(isset($errorwallmessage)&&strlen($errorwallmessage)>0){echo $errorwallmessage;} ?>
                    
            
               <table>
            <?php if(isset($_SESSION['Profile']['UserName'])&&strlen($_SESSION['Profile']['UserName'])>0&&!empty($showPosts)): ?>
            <?php foreach ($showPosts as $posts): ?>
               <tr>
                   <!--date formatting issues https://www.youtube.com/watch?v=ZomK0WiIArs-->
                <?php   $posts['Date']=htmlspecialchars(strtotime($posts['Date']));
                   $posts['Date']= htmlspecialchars(date('M-d-Y h:i:sa',$posts['Date'])); ?>
                   <td><?php echo htmlspecialchars('Post from '.$posts['Sender'].' on '.($posts['Date'])); ?></td>
               </tr>
            <tr>
                <td><?php echo htmlspecialchars($posts['Message']); ?></td>
            </tr>
            
            <?php            endforeach; ?>
            <?php endif ?>
            </table>
            
                
                
                    

                </div>
            </header>
            <main>

            </main>
        </div>

        <?php include 'footer.php'; ?>
    </body>
</html>

