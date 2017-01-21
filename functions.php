<?php
require 'config.php';
require 'index_class.php';
require_once "lib/class.phpmailer.php";

$obj  =  new Index();


if(isset($_SESSION['user'])){

    $obj->user_id = $_SESSION['user'][0]['id'];
}

if(isset($_POST['email'] , $_POST['password'] , $_POST['first_name'], $_POST['last_name'])){

    $user = [];
    $user['first_name'] = trim(DB::$_MasterDB->real_escape_string($_POST['first_name']));
    $user['last_name']  = trim(DB::$_MasterDB->real_escape_string($_POST['last_name']));
    $user['email']      = trim(DB::$_MasterDB->real_escape_string($_POST['email']));
    $user['password']   = trim(DB::$_MasterDB->real_escape_string($_POST['password']));

    $arrResp = [];


    if($obj->user_exists($user['email'])){

        $arrResp['error'] = 'You have already registered an account';

    }else{
        $user['confirmation_id'] = $obj->generateRandomString();

        if($obj->registration_link_send($user) && $obj->user_registration( $user )){

            $arrResp['success'] = 'Please check your email';

        }else{
            $arrResp['error'] = 'Can not send a mail';
        }

    }

    echo json_encode($arrResp);
}
if(isset($_POST['token'])){

    $token    = $_POST['token'];
    $s        = file_get_contents('http://ulogin.ru/token.php?token=' . $token . '&host=' . $_SERVER['HTTP_HOST']);
    $user     = json_decode($s, true);
    $user['password'] = $obj->generateRandomString(12);


    if($obj->user_exists($user["email"])){
        ($obj->setSession_login($user));
        echo '<META HTTP-EQUIV="refresh" content="0;URL=' . fs_dev . '">';
        echo "<script type='text/javascript'>document.location.href='".fs_dev."';</script>";
    }else{

        if($obj->mail_social_user($user ) && $obj->user_registration( $user , $token )){
            $obj->setSession_login($user);
        }
    }

}

if(isset($_POST['email'] , $_POST['password'] , $_POST['login'])){

    $email     = trim(DB::$_MasterDB->real_escape_string($_POST['email']));
    $password  = trim(DB::$_MasterDB->real_escape_string($_POST['password']));

    echo $obj->user_login($email, $password);

}


if(isset($_POST['poll_title'] , $_POST['poll_option'])){

    $poll_title  = trim(DB::$_MasterDB->real_escape_string($_POST['poll_title']));
    $poll_option = $_POST['poll_option'];

    $arr = [];

    if(isset($_SESSION['user'])){


        foreach ($poll_option as $key => $val){
            $poll_option[$key] = trim(DB::$_MasterDB->real_escape_string($val));
        }

        if($obj->polls_adding($poll_title, $poll_option)){
            $arr['success'] = 'Successfully inserted';
        }else{
            $arr['error'] = 'Something went wrong';
        }
    }

    echo json_encode($arr);

}

if(isset($_POST['get_poll_items'] , $_POST['for_shows'] )){
    echo $obj->get_poll_items();
}

if(isset($_POST['get_poll_items'] , $_POST['for_edit'] )){
    echo $obj->get_poll_for_edit();
}
if(isset($_POST['data_poll_id'] , $_POST['for_edit'] )){

    $data_poll_id  = trim(DB::$_MasterDB->real_escape_string($_POST['data_poll_id']));
    echo $obj->get_poll_items_for_edit($data_poll_id);
}
if(isset($_POST['option_id'] , $_POST['vote'])){

    $arr = [];
    $option_id  = trim(DB::$_MasterDB->real_escape_string($_POST['option_id']));

    $vote = $obj->vote($option_id);

    if($vote){
        if($vote === '2' ){
            $arr['error'] = 'Not logged in';
        }else{
            $arr['success'] = 'Successfully vote';
        }
    }else{
        $arr['error'] = 'Something went wrong';
    }
    echo json_encode($arr);

}

if(isset($_POST['get_counts_of_votes'] , $_POST['poll_id'])){

    $arr                  = [];
    $get_counts_of_votes  = trim(DB::$_MasterDB->real_escape_string($_POST['get_counts_of_votes']));
    $poll_id              = trim(DB::$_MasterDB->real_escape_string($_POST['poll_id']));

    $votes = $obj->get_counts_of_votes($poll_id);

    echo $votes;

}
if(isset($_POST['deleted_poll_id'] , $_POST['for_delete'])){

    $arr              = [];
    $deleted_poll_id  = trim(DB::$_MasterDB->real_escape_string($_POST['deleted_poll_id']));


    $vote = $obj->delete_poll($deleted_poll_id);

    if($vote){
        $arr['success'] = 'Successfully delete';
    }else{
        $arr['error'] = 'Something went wrong';
    }

    echo json_encode($arr);

}

if (isset($_POST['edited_data'])){

    $arrrr         = [];
    $edited_data = $_POST['edited_data'];

    if($obj->edit_polls($edited_data)){

        $arrrr['success'] = 'Successfully edited';

    }else{
        $arrrr['error'] = 'Something went wrong';
    }

    echo json_encode($arrrr);
}