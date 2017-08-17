<?php

function registerUser($username,$password, $email, $firstname, $lastname) {
    global $db;
    $query = 'insert into users
                   (username, firstname, lastname, email, password, image)
                   VALUES
                   (:username, :firstname, :lastname, :email, :password, :image)';

    $statement = $db->prepare($query);
    $statement->bindValue(':username', $username);
    $statement->bindValue(':firstname', $firstname);
    $statement->bindValue(':lastname', $lastname);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':password', $password);
    $statement->bindValue(':image', 'images/defaultProfile.png');
    $success = $statement->execute();
    $statement->closeCursor();
    return $success;
}

function checkValidUsername($user_name){
    global $db;
    //this checks if the username is valid and in the db
    $userNameQuery = 'select username from users where username= :username;';
    $userNameStatement = $db->prepare($userNameQuery);
    $userNameStatement->bindValue(':username', $user_name);
    $userNameStatement->execute();
    $username = $userNameStatement->fetch();
    $userNameStatement->closeCursor();
    if ($username != null) {
        return true;
    } else {
        return false;
    }
    
}

function checkLoginInfoTest($user) {
    global $db;
    $query = 'select password from users where username=:username;';
    $statement = $db->prepare($query);
    $statement->bindValue(':username', $user);
    $statement->execute();
    $getPassword = $statement->fetchAll();
    $statement->closeCursor();
    return $getPassword;
}

function getProfileInformation($user) {
    global $db;
    $query = 'select * from users where username=:username;';
    $statement = $db->prepare($query);
    $statement->bindValue(':username', $user);
    $statement->execute();
    $getProfileInformation= $statement->fetchAll();
    $statement->closeCursor();
    return $getProfileInformation;
}

function updateProfilePicture($username,$imageDirectory) {
    global $db;
    $query = 'update users
              set Image=:Image
              where UserName=:UserName';
    $statement = $db->prepare($query);
    $statement->bindValue(':UserName', $username);
    $statement->bindValue(':Image', $imageDirectory);
    $success = $statement->execute();
    $statement->closeCursor();
    return $success;
}

function updateUser($username, $first_name,$last_name,$emailaddress, $password) {
    global $db;
    $query = 'update users
              set FirstName=:FirstName, LastName=:LastName, Email=:Email, Password=:Password
              where UserName=:UserName';
    $statement = $db->prepare($query);
    
    $statement->bindValue(':FirstName', $first_name);
    $statement->bindValue(':LastName', $last_name);
    $statement->bindValue(':Email', $emailaddress);
    $statement->bindValue(':UserName', $username);
    $statement->bindValue(':Password', $password);
    $success = $statement->execute();
    $statement->closeCursor();
    return $success;
}

function showUserInformation() {
    global $db;
    $query = 'select * from users order by username limit 10;';
    $statement = $db->prepare($query);
    $statement->execute();
    $getUsers= $statement->fetchAll();
    $statement->closeCursor();
    return $getUsers;
}

function showSpecificProfile($username) {
    global $db;
    $query = 'select * from users where username=:username ;';
    $statement = $db->prepare($query);
    $statement->bindValue(':username', $username);
    $statement->execute();
    $getUserInfo= $statement->fetch();
    $statement->closeCursor();
    return $getUserInfo;
}

function showWallPostsDB($username) {
    global $db;
    $query = 'select * from wall where Username=:username order by Date desc;';
    $statement = $db->prepare($query);
    $statement->bindValue(':username', $username);
    $statement->execute();
    $getUsers= $statement->fetchAll();
    $statement->closeCursor();
    return $getUsers;
}

function writePost($username,$sender, $date, $message) {
    global $db;
    $query = 'insert into wall
                   (username, sender, date, message)
                   VALUES
                   (:username, :sender, :date, :message)';

    $statement = $db->prepare($query);
    $statement->bindValue(':username', $username);
    $statement->bindValue(':sender', $sender);
    $statement->bindValue(':date', $date);
    $statement->bindValue(':message', $message);
    $success = $statement->execute();
    $statement->closeCursor();
    return $success;
}
?>