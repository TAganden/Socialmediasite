<?php
   include('image.php');
   if(isset($_FILES['image'])){
      $errors= array();
      $maxsize    = 2097152;
      //$file_name = 'images/'.(string)$_FILES['image']['name'];
      $file_name = 'images/'.(string)$_SESSION['Profile']['UserName'].$_FILES["image"]["name"];
      //(string)$_SESSION['Profile']['UserName'];
      $file_size =$_FILES['image']['size'];
      $file_tmp =$_FILES['image']['tmp_name'];
      $file_type=$_FILES['image']['type'];
      $image = $file_name;
//      $temp = end(explode('.',$_FILES['image']['name']));
//      $file_ext = strtolower($file_type);
      //http://stackoverflow.com/questions/16927175/php-upload-script-only-variables-should-be-passed-error
      $tmp = explode(".", $_FILES["image"]["name"]);
      $file_ext = end($tmp);
      //var_dump($_FILES);
      
      
      $extensions= array("jpeg","jpg","png", "gif","JPG","JPEG","PNG","GIF");
      
      
      if(!in_array($file_ext,$extensions)){
         $errors[]="We were unable to upload your file.  Check your file extension";
      }
      //source https://stackoverflow.com/questions/9153224/how-to-limit-file-upload-type-file-size-in-php
      if($file_size>$maxsize || $file_size===0){
         $errors[]="The file cannot be uploaded because it is too BIG!";
      }

      if(empty($errors)==true){
         move_uploaded_file($file_tmp,$file_name);
                 $userObj=new User();
        $userObj->setProfileInfo((string)$_SESSION['Profile']['UserName'],$file_name);
        $_SESSION['Profile']['Image']=$file_name;
        $theUser = new User();
        $profile=$theUser->showPublicProfile($_SESSION['Profile']['UserName']);
            $profileusername=$profile['UserName'];
            $profileemail=$profile['Email'];
            $profilefirstname=$profile['FirstName'];
            $profilelastname=$profile['LastName'];
            $profileimage=$profile['Image'];
            if(!empty(ShowWallPosts($profileusername))){
                $showPosts= ShowWallPosts($profileusername);
                $nowallmessage="";
            }
            else{
                $nowallmessage="Be the first to write on ".$profileusername." wall.";
            }
         include('profile.php');
         return;
      }else{
         echo $errors[0];
      }
   }
   

?>

<html>
   <body>
    <div id="wrapper">
       
       <img src='<?php echo $image?>' width='200' height='200'>
      <form action="index.php" method="POST" enctype="multipart/form-data">
          <input type="file" name="image" /><br>
          <input type='hidden' name ='action' value='image_upload'/>
        <input type="submit" value="Upload Picture"/>
      </form>
      <?php include 'footer.php'; ?>
    </div>
   </body>
</html>