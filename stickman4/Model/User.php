<?php

class User {
//all user properties
private $user_name;
private $password;
private $email_address;
private $first_name;
private $last_name;
private $imageURL;


public function _construct($user_name, $password, $email_address, $first_name, $last_name, $imageURL){
  $this->user_name = $user_name;
  $this->password = $password;
  $this->email_address = $email_address;
  $this->first_name = $first_name;
  $this->last_name = $last_name;
  $this->imageURL = "";

//$this->imageURL = $imageURL;
  
  
}
function getUser_name() {
    return $this->user_name;
}

function getPassword() {
    $this->password=$this->createHash($this->password);
    return $this->password;
}

function getEmail_address() {
    return $this->email_address;
}

function getFirst_name() {
    return $this->first_name;
}

function getLast_name() {
    return $this->last_name;
}
function getImageURL() {
    return $this->imageURL;
}

function setUser_name($user_name) {
    $this->user_name = $user_name;
}

function setPassword($password) {
    $this->password = $password;
}

function setEmail_address($email_address) {
    $this->email_address = $email_address;
}

function setFirst_name($first_name) {
    $this->first_name = $first_name;
}

function setLast_name($last_name) {
    $this->last_name = $last_name;
}

function setImageURL($imageURL) {
    $this->imageURL = $imageURL;
}

public function hash_check($user,$pass){
    //todo:call database, get password value which would be hash, hashed value to this
    //check if password matches hash   
        $hash=array();
        $hash= checkLoginInfoTest($user);
        foreach ($hash as $hashItem):
        $hashGiven=(string)$hashItem['password'];
            endforeach;
        if (isset($hashGiven)){
            if (password_verify($pass,(string)$hashGiven))
        {              
            return true;
        } 
        else
        {
            return false;
        }
        }
        
    
}

public function CheckUserName(){
    if(checkValidUsername($this->getUser_name()))
    {
        //username exists
        return true;
    }
    else{
        //username doesn't already exist
        return false;
    }
}

public function createUser(){
    if(registerUser($this->getUser_name(), $this->getPassword(), $this->getEmail_address(), $this->getFirst_name(), $this->getLast_name())){
        return true;
    }
    else{
        return false;
    }
    }

public function updateTheUser($username, $first_name, $last_name, $emailaddress, $password){
    $bCheckUpdate = true;
    $bCheckUpdate = updateUser($username, $first_name, $last_name, $emailaddress, $this->createHash($password));
    
    if($bCheckUpdate)
    {
        return true;
    }
    else{
       return false;
    }
    
}


public function createHash($password){
        //Creates a new hashed password
    $options = [
            'cost' => 10,
    ];
    $hash =  password_hash($password, PASSWORD_DEFAULT, $options);
    return $hash;
}

public function getProfileInfo($user){
    getProfileInformation($user);
    return $profileInformation;
}

public function setProfileInfo($username,$imageDirectory){
    if(updateProfilePicture($username,$imageDirectory)){
    return true;
    }
    else{
        return false;
    }
}

public function showMembers(){
    if(showUserInformation()){
        $showUsers=array();
        $showUsers= showUserInformation();
        return $showUsers;
    }
    else{
        return false;
    }
}

public function showWallPosts($username){
    if(showWallPostsDB($username)){
        $showPosts=array();
        $showPosts= showWallPostsDB($username);
        return $showPosts;
    }
    else{
        return false;
    }
}

public function writeWallPost($username, $sender, $date, $message){
    if(writePost($username,$sender, $date, $message)){
    return true;
    }
    else{
        return false;
    }
}

public function showPublicProfile($username){
    if(showSpecificProfile($username)){
        $showProfile= showSpecificProfile($username);
        return $showProfile;
    }
    else{
        return false;
    }
}

}
?>
