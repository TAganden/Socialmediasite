<!DOCTYPE html>
<html>

<head>
    <title>Stickman</title>
    <link rel="stylesheet" type="text/css" href="main.css" />
</head>

<body>
    <header><h1>Stickman</h1></header>

    <main>
        <p><?php 
        if(isset($database_error_message)){
        echo "Database Error";
        echo $database_error_message;}
        ?></p>
    </main>
</body>
</html>