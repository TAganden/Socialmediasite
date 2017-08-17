<?php
session_start();

//Require the database files and classes.
require('Model/database.php');
require('Model/UserDb.php');
require('Model/User.php');
require('Model/database_error.php');
$showUsers=ShowPublicUsers();

//Start with the login page, unless an action variable is set.
$action = filter_input(INPUT_POST, 'action');
if ($action === NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action === NULL) {
        $action = 'initiallogin';
    }
}

//Determines which page/action is called.
switch ($action) {
    case 'initiallogin':
        include 'View/login.php';
        break;
    case 'initialedit':
        include 'View/changeinfo.php';
        break;
    case 'logout':
        $_SESSION['Profile']['UserName']="";
            $_SESSION['Profile']['FirstName']="";
            $_SESSION['Profile']['LastName']="";
            $_SESSION['Profile']['Email']="";
            $_SESSION['Profile']['Image']="";
        include('View/login.php');
        break;
    case 'image_upload':
        $image = filter_input(INPUT_POST, 'image');
        if ($image === null || $image === "") {
            include('View/imageUpload.php');
            break;
        } else {
            include('View/profile.php');
        }

    case 'edit':
            //grabbing values from page
            $first_name = filter_input(INPUT_POST, 'first_name');
            $last_name = filter_input(INPUT_POST, 'last_name');
            $email_address = filter_input(INPUT_POST, 'email_address', FILTER_VALIDATE_EMAIL);
            $password = filter_input(INPUT_POST, 'password');
            $bValidate = true;
            if(!preg_match('/^[A-Za-z]/',$first_name) || !preg_match('/^[A-Za-z]/',$last_name) || $first_name === null || $last_name === null || ($email_address === null || filter_input(INPUT_POST, 'email_address') === "") || strlen($password) === 0 || (!preg_match('/^[A-Z][A-Z]*$/',$password) || !preg_match('/^[a-z][a-z]*$/',$password) || !preg_match('/^[0-9]/',$password) || !preg_match('/[^\w]/',$password) || !preg_match('/^.{10,25}$/',$password))){
                $errors = array();
            }
            //validate values
            $bPregCheck = true;
            if (strlen($first_name) === 0) {
            $errors[] = 'First Name is Required';
            $bValidate = False;
            $bPregCheck = False;
        }
        if (strlen($last_name) === 0) {
            $errors[] = 'Last Name is Required';
            $bValidate = False;
            $bPregCheck = False;
        }
        if (strlen($password) === 0) {
            $errors[] = 'Password is required';
            $bValidate = False;
            $bPregCheck = False;
        }
        else{
            $bPregCheck = true;
            //this needs to be reviewed.  Where it says it needs a number for the password.
            if(!preg_match('/[A-Z]/',$password))
            {
                
                $errors[] = 'The Password requires an uppercase letter';
                $bPregCheck = false;
                
            }
            if(!preg_match('/[a-z]/',$password))
            {
                $errors[] = 'The Password requires a lowercase letter';
                $bPregCheck = false;                
            }
            if(!preg_match('/[0-9]/',$password))
            {
                $errors[] = 'The password requires a number';
                $bPregCheck = false;                
            }
            if(!preg_match('/[^\w]/',$password))
            {
                $errors[] = 'The password requires a symbol';
                $bPregCheck = false;                
            }
            if(!preg_match('/^.{10,25}$/',$password))
            {
                $errors[] = 'The password length must be between 10-25 characters';
                $bPregCheck = false;                
            }
            //TOPOLOGIES SECTION
            if(preg_match('/^[A-Z][a-z]{5}[0-9]{4}[\W]{1}$/',$password))
            {
                $errors[] = 'Your password is not complex enough. It matched format (Sssss1111!) which is a common password';
                $bPregCheck = false;                
            }
            if(preg_match('/^[A-Z][a-z]{7}[0-9]{2}[\W]{1}$/',$password))
            {
                $errors[] = 'Your password is not complex enough. It matched format (Ssssssss11!) which is a common password';
                $bPregCheck = false;                
            }
            if(preg_match('/^[A-Z][a-z]{6}[0-9]{4}[\W]{1}$/',$password))
            {
                $errors[] = 'Your password is not complex enough. It matched format (Sssssss1111!) which is a common password';
                $bPregCheck = false;                
            }
            if(preg_match('/^[\W][A-Z]{1}[a-z]{5}[0-9]{4}[\W]{1}$/',$password))
            {
                $errors[] = 'Your password is not complex enough. It matched format (!Ssssss1111) which is a common password';
                $bPregCheck = false;                
            }
            if(preg_match('/^[0-9][A-Z]{1}[a-z]{5}[0-9]{4}[\W]{1}$/',$password))
            {
                 $errors[] = 'Your password is not complex enough. It matched format (1Ssssss1111!) which is a common password';
                $bPregCheck = false;                
            }
            //END TOPOLOGIES SECTION
        }
        
            if(!preg_match('/^[A-Za-z]/',$first_name)){
            $errors[] = 'Your first name has to start with a letter';
                $bPregCheck = false; 
            }
            if(!preg_match('/^[A-Za-z]/',$last_name)){
            $errors[] = 'Your last name has to start with a letter';
                $bPregCheck = false; 
            }
            
            if ($email_address === null || filter_input(INPUT_POST, 'email_address') === "") {
            $errors[] = 'Email is Required';
            $bValidate = False;
            $bPregCheck = False;
        } else if (!$email_address) {
            $errors[] = 'Email is in incorrect format';
            $bValidate = False;
            $bPregCheck = False;
        }
        
        
            if(!$bPregCheck)
            {
                $bValidate = False;
                include('View/changeinfo.php');
                break;
            }
            else{
                //validated so db call for update
                $theUser = new User();
                if($theUser->updateTheUser( $_SESSION['Profile']['UserName'], $first_name, $last_name, $email_address, $password))
                {
                    $_SESSION['Profile']['FirstName']=$first_name;
                    $_SESSION['Profile']['LastName']=$last_name;
                    $_SESSION['Profile']['Email']=$email_address;
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

                include('View/profile.php');
                break;
                }
                else{
                    $errors = array();
                    $errors[] = 'Update was unsuccessful';
                    include('View/profile.php');
                    break;
                }
                
            }

            
        include 'View/profile.php';
        break;
	case 'initialedit':
        include 'View/changeinfo.php';
        break;
    case 'login':
        $user_name = filter_input(INPUT_POST, 'user_name');
        $password = filter_input(INPUT_POST, 'password');
        if ($user_name === null || $user_name === "") {
            $errors = array();
            $errors[] = 'User Name is Required';
            $bValidate = False;
            include('View/login.php');
            break;
        }
        if ($password === null || $password === "") {
            $errors = array();
            $errors[] = 'Password is Required';
            $bValidate = False;
            include('View/login.php');
            break;
        }
        //if input validated

        $userObj = new User();
        if ($userObj->hash_check($user_name, $password)) {
            foreach (getProfileInformation($user_name) as $profile) :
            $_SESSION['Profile']['UserName']=$profile['UserName'];
            $_SESSION['Profile']['FirstName']=$profile['FirstName'];
            $_SESSION['Profile']['LastName']=$profile['LastName'];
            $_SESSION['Profile']['Email']=$profile['Email'];
            $_SESSION['Profile']['Image']=$profile['Image'];
            $profileusername=$_SESSION['Profile']['UserName'];
            $profileemail=$_SESSION['Profile']['Email'];
            $profilefirstname=$_SESSION['Profile']['FirstName'];
            $profilelastname=$_SESSION['Profile']['LastName'];
            $profileimage=$_SESSION['Profile']['Image'];
            $publicprofile=$_SESSION['Profile']['UserName'];
            endforeach;
            include('View/profile.php');
            break;
        } else {
            $loginError="Incorrect username or password";
            include('View/login.php');


            break;
        }
        
    case 'profile':
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
            
        include('View/profile.php');
        break;
    case 'publicrequest':
        $publicprofile = filter_input(INPUT_GET, 'publicprofile');
        $theUser = new User();
            $thepublicprofile=$theUser->showPublicProfile($publicprofile);
            $profileusername=$thepublicprofile['UserName'];
            $profileemail=$thepublicprofile['Email'];
            $profilefirstname=$thepublicprofile['FirstName'];
            $profilelastname=$thepublicprofile['LastName'];
            $profileimage=$thepublicprofile['Image'];
            if(!empty(ShowWallPosts($profileusername))){
                $showPosts= ShowWallPosts($profileusername);
                $nowallmessage="";
            }
            else{
                $nowallmessage="Be the first to write on ".$profileusername."'s wall.";
            }
        include('View/profile.php');
        break;
    case 'writewall':
        date_default_timezone_set('America/Chicago');  //may want to get rid of this?  Not sure what the server time zone will be.
        $theUser = new User();
        $wallusername = filter_input(INPUT_POST, 'currentprofile');
        $wallsender = $_SESSION['Profile']['UserName'];
        //https://stackoverflow.com/questions/470617/how-to-get-the-current-date-and-time-in-php
        $walldate = date('Y-m-d H:i:s');
        $wallmessage= filter_input(INPUT_POST, 'message');
        if($wallusername!==""&&$wallsender!==""&&$walldate!==""&&$wallmessage!==""){
            $theUser->writeWallPost($wallusername,$wallsender,$walldate,$wallmessage);
        }
        else{
            $errorwallmessage="We couldn't write your message.";
        }
            $thepublicprofile=$theUser->showPublicProfile($wallusername);
            $profileusername=$thepublicprofile['UserName'];
            $profileemail=$thepublicprofile['Email'];
            $profilefirstname=$thepublicprofile['FirstName'];
            $profilelastname=$thepublicprofile['LastName'];
            $profileimage=$thepublicprofile['Image'];
            if(count(ShowWallPosts($profileusername))>0){
                $showPosts= ShowWallPosts($profileusername);
                $nowallmessage="";
            }
            else{
                $nowallmessage="Be the first to write on ".$profileusername." wall.";
            }
        include('View/profile.php');
        break;
    case 'registration':
        include('View/registration.php');
        break;
    case 'validate_values':
        include('View/validate_values.php');
        break;
    case 'confirmation':
        $first_name = filter_input(INPUT_POST, 'first_name');
        $last_name = filter_input(INPUT_POST, 'last_name');
        $email_address = filter_input(INPUT_POST, 'email_address', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');
        $user_name = filter_input(INPUT_POST, 'user_name');
        $bValidate = true;
        if ($first_name === null) {
            $errors = array();
            $errors[] = 'First Name is Required';
            $bValidate = False;
            include('View/registration.php');
            break;
        }
        if ($last_name === null) {
            $errors = array();
            $errors[] = 'Last Name is Required';
            $bValidate = False;
            include('View/registration.php');
            break;
        }
        if ($email_address === null || filter_input(INPUT_POST, 'email_address') === "") {
            $errors = array();
            $errors[] = 'Email is Required';
            $bValidate = False;
            include('View/registration.php');
            break;
        } else if (!$email_address) {
            $errors[] = 'Email is in incorrect format';
            $bValidate = False;
        }
        if ($password === null || $password === "") {
            $errors = array();
            $errors[] = 'Password is Required';
            $bValidate = False;
            include('View/registration.php');
            break;
        }
        else{
            $bPregCheck = true;
            if(!preg_match('/^[A-Z][A-Z]*$/',$password) || !preg_match('/^[a-z][a-z]*$/',$password) || !preg_match('/^[0-9]/',$password) || !preg_match('/[^\w]/',$password) || !preg_match('/^.{10,25}$/',$password)){
                $errors = array();
            }
            if(!preg_match('/[A-Z]/',$password))
            {
                
                $errors[] = 'The Password requires an uppercase letter';
                $bPregCheck = false;
                
            }
            if(!preg_match('/[a-z]/',$password))
            {
                $errors[] = 'The Password requires a lowercase letter';
                $bPregCheck = false;                
            }
            if(!preg_match('/[0-9]/',$password))
            {
                $errors[] = 'The password requires a number';
                $bPregCheck = false;                
            }
            if(!preg_match('/[^\w]/',$password))
            {
                $errors[] = 'The password requires a symbol';
                $bPregCheck = false;                
            }
            if(!preg_match('/^.{10,25}$/',$password))
            {
                $errors[] = 'The password length must be between 10-25 characters';
                $bPregCheck = false;                
            }
            //TOPOLOGIES SECTION
            if(preg_match('/^[A-Z][a-z]{5}[0-9]{4}[\W]{1}$/',$password))
            {
                $errors[] = 'Your password is not complex enough. It matched format (Ssssss1111!) which is a common password';
                $bPregCheck = false;                
            }
            if(preg_match('/^[A-Z][a-z]{7}[0-9]{2}[\W]{1}$/',$password))
            {
                $errors[] = 'Your password is not complex enough. It matched format (Ssssssss11!) which is a common password';
                $bPregCheck = false;                
            }
            if(preg_match('/^[A-Z][a-z]{6}[0-9]{4}[\W]{1}$/',$password))
            {
                $errors[] = 'Your password is not complex enough. It matched format (Sssssss1111!) which is a common password';
                $bPregCheck = false;                
            }
            if(preg_match('/^[\W][A-Z]{1}[a-z]{5}[0-9]{4}[\W]{1}$/',$password))
            {
                $errors[] = 'Your password is not complex enough. It matched format (!Ssssss1111!) which is a common password';
                $bPregCheck = false;                
            }
            if(preg_match('/^[0-9][A-Z]{1}[a-z]{5}[0-9]{4}[\W]{1}$/',$password))
            {
                 $errors[] = 'Your password is not complex enough. It matched format (1Ssssss1111!) which is a common password';
                $bPregCheck = false;                
            }
            //END TOPOLOGIES SECTION

            
        }
        if ($user_name === null || $user_name === "") {
            $errors = array();
            $errors[] = 'User Name is Required';
            $bValidate = False;
            include('View/registration.php');
            break;
        }
        else{
            //logic to validate username
            if(!preg_match('/^[A-Za-z]/',$user_name)){
                $errors[] = 'The username has to start with a letter';
                $bPregCheck = false;   
            }
            if(!preg_match('/^.{4,20}$/',$user_name)){
                $errors[] = 'The username must be between 4-20 characters long';
                $bPregCheck = false; 
            }
        }
        
        if(!preg_match('/^[A-Za-z]/',$first_name)){
        $errors[] = 'Your first name has to start with a letter';
                $bPregCheck = false; 
        }
        if(!preg_match('/^[A-Za-z]/',$last_name)){
        $errors[] = 'Your last name has to start with a letter';
                $bPregCheck = false; 
        }
        
        
        if(!$bPregCheck)
            {
                $bValidate = False;
                include('View/registration.php');
                break;
            }
        if($bValidate && $bPregCheck){
            //this gets hit if it passes all validation
            $theUser = new User();
            $theUser->_construct($user_name, $password, $email_address, $first_name, $last_name, "");
            if (!$theUser->CheckUserName()) {
                if ($theUser->createUser()) {
                    include('View/confirmation.php');                    
                } else {
                    $message = 'error has occured adding user.';
                }
            } else {
                $message = 'User already exists.  Please pick another user';
                include('View/database_error_view.php');

            }
        }
        

}

function ShowWallPosts($username)
        {
            $showPosts=array();
            $theUser = new User();
            $showPosts=$theUser->showWallPosts($username);
            return $showPosts;
        }

function ShowPublicUsers()
        {
            $showUsers=array();
            $theUser = new User();
            $showUsers=$theUser->showMembers();
            return $showUsers;
        }
?>
