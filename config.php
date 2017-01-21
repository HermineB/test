<?php

define('fs_dev',$_SERVER['SERVER_NAME'] . dirname($_SERVER['PHP_SELF']));

define('fs_dev_email','baghdasaryan.test@gmail.com');
define('fs_dev_email_pass',"1q6y2w5t3e4r");


class DB{
    static  $_MasterDB;            // Database Connection Link

    private $_MasterHostName   = "localhost";
    private $_MasterUserName   = "root";
    private $_MasterPassword   = "";
    private $_MasterDataBase   = "fs_dev";
    private $_MasterPort       = "3306";

//    private $_MasterHostName   = "localhost";
//    private $_MasterUserName   = "id572656_root";
//   private $_MasterPassword   = "fs_dev";
//    private $_MasterDataBase   = "id572656_fs_dev";
//   private $_MasterPort       = "3306";


    function __construct(){
        self::$_MasterDB    = $this->GetlinkMaster();
        self::$_MasterDB->set_charset('utf8');
    }


    private  function conectDB($hostName,$userName,$password,$dataBase,$port){
        $mysqli = new mysqli($hostName,  $userName, $password,  $dataBase,$port);

        if ($mysqli->connect_errno) {
            echo "Не удалось подключиться к MySQL: " . $mysqli->connect_error;
        }

        return $mysqli;
    }

    private function GetlinkMaster(){
        return $this->conectDB($this->_MasterHostName,$this->_MasterUserName,$this->_MasterPassword,$this->_MasterDataBase,$this->_MasterPort);
    }
}

$db=new DB();




