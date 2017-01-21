<?php
require 'config.php';
require 'index_class.php';


$obj = new Index();



if(isset($_SESSION['user'])){


    header("location:index.php");
    exit;

}else{

    if(isset($_GET['hash'])){

        $confirmation_id = DB::$_MasterDB->real_escape_string($_GET['hash']);

        if(empty($obj->activate_profile($confirmation_id))){
            ?>
                <h1>Page not found</h1>
            <?php
        }else{

            header("location:index.php");
            exit;
        };
    }
    else{ ?>
            <h1>Oops</h1>
        <?php
    }
}

