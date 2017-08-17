<?php

$image = filter_input(INPUT_POST, 'image');

if(!isset($image)){
    $image = '../images/defaultProfile.png';
}
else {
    $image = User::setImageUrl($image);
}






?>

<a href="imageUpload.php"></a>