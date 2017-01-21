<?php
ini_set("display_errors", 1);

require_once("./config.php");  // conect to db
require_once ("./index_class.php");
$obj = new Index();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>

    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/pnotify.custom.min.css" />
    <link rel="stylesheet" href="css/style.css" />

    <script type="text/javascript">
        var baseUrl   = '<?= $_SERVER['SERVER_NAME'] . dirname($_SERVER['PHP_SELF'])?>';
    </script>

</head>
<body>


<header>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="index.php">WebSiteName</a>
            </div>
            <ul class="nav">
                <?php
                if(isset($_SESSION['user'])){?>
                    <li>
                        <a href="<?= 'profile.php'?>">Welcome <?=$_SESSION['user'][0]['first_name']?></a>
                    </li>
                    <li>
                        <a href="logout.php">Log Out</a>
                    </li>
                <?php } else {?>
                    <li>
                        <a href="#" data-toggle="modal" data-target="#LogInModal">Login</a>
                    </li>
                    <li>
                        <a href="#" data-toggle="modal" data-target="#SignInModal">Sign In</a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </nav>

</header>