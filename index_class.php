<?php

session_start();
ini_set("display_errors", 1);

require_once "lib/class.phpmailer.php";


class Index {


    public $user_id = '';



    public function mail_config(){

        $mail = new PHPMailer;
        $mail->IsSMTP(); // enable SMTP
        $mail->SMTPDebug = 1; //$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
        $mail->SMTPAuth = true;
        $mail->Debugoutput = 'html';
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 465;// 587

        $mail->IsHTML(true);
        $mail->SMTPSecure = "ssl"; //tls
        $mail->Subject = "Fs Dev registration";
        $mail->SetFrom(fs_dev_email,'Fs Dev');
        $mail->Username = fs_dev_email;
        $mail->Password = fs_dev_email_pass;

        return $mail;

    }

    public function user_registration( $user, $token = false  ){

        $result = false;
        $now    = date('Y-m-d H:i:s');

        if(!$token){

            $first_name       = $user['first_name'];
            $last_name        = $user['last_name'];
            $email            = $user['email'];
            $password         = hash('sha256', $user['password']);
            $confirmation_id  = $user['confirmation_id'];

            $result   = DB::$_MasterDB->query("INSERT INTO `users` 
                                         (`first_name`,`last_name`,`email`,`password`,`status`,`created_at`,`confirmation_id`)
                                         VALUES ('$first_name','$last_name','$email','$password','inactive', '$now','$confirmation_id') ");
        }else{

            $first_name = $user['first_name'];
            $last_name  = $user['last_name'];
            $profile    = $user['profile'];
            $uid        = $user['uid'];
            $identity   = $user['identity'];
            $email      = $user['email'];
            $network    = $user['network'];
            $password   = hash('sha256', $user['password']);

            $result = DB::$_MasterDB->query("INSERT INTO `users` 
                     (`first_name`,`last_name`,`email`,`uid`,`password`,`status`,`created_at`,`profile`,`identity`,`network`)
                     VALUES ('$first_name','$last_name','$email','$uid','$password','active', '$now','$profile',$identity,$network) ");
        }


        return $result;

    }

    public function generateRandomString($length = 20) {
        $characters       = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString     = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function activate_profile($confirmation_id){

        $result = DB::$_MasterDB->query("SELECT * FROM `users` where `confirmation_id` = '$confirmation_id' and `status` = 'inactive' ");

        $user = [];
        while($r = mysqli_fetch_assoc($result)) {
            $user[] = $r;
        }

        if(!empty($user)){

            $activate = DB::$_MasterDB->query("UPDATE `users` SET `status` = 'active' WHERE `confirmation_id` = '$confirmation_id' ");

            $this->setSession_login($user);

        }


        return $user;
    }

    public function setSession_login($user){

        $_SESSION['user'] = $user;

        return $_SESSION;
    }

    public function registration_link_send( $user  ){

        $email           = $user['email'];
        $first_name      = $user['first_name'];
        $last_name       = $user['last_name'];
        $confirmation_id = $user['confirmation_id'];
        $password        = $user['password'];

        $mail = $this->mail_config();

        $message = '<h4> Thank you '.$first_name.' to registration in FS dev.com </h4>
                    <p>To complete account creation please follow the link: </p>
                    <a href="'.fs_dev.'registration.php?hash='.$confirmation_id.'" 
                    style="
                    display:block; 
                    width:350px;  
                    background-color:#3498db; 
                    padding:10px; 
                    margin-bottom:10px; 
                    color:#fff; 
                    border-radius: 10px;  
                    text-align: center;">
                                          Confirm </a>
                    <p>Password: '.$password.'</p>                  
                    ';

        $mail->AddAddress("$email", "Confirm registration");
        $mail->MsgHTML($message);

        if( $mail->Send() ){

            return true;
        }else{
            return false;
        }

    }

    public function mail_social_user($user ){

        $email           = $user['email'];
        $first_name      = $user['first_name'];
        $last_name       = $user['last_name'];
        $password        = $user['password'];

        $mail    = $this->mail_config();
        $message = '<h4> Thank you '.$first_name.' to registration in FS dev </h4>
                    
                    <p>Email: '.$email.'</p>                  
                    <p>Password: '.$password.'</p> ';

        $mail->AddAddress("$email", "Confirm registration");
        $mail->MsgHTML($message);

        if( $mail->Send() ){
            return true;
        }else{
            return false;
        }
    }

    public function user_exists($identity){

        $result = DB::$_MasterDB->query(" SELECT * FROM `users` where `email` = '$identity' or `uid` = '$identity'");

        $user = [];
        while($r = mysqli_fetch_assoc($result)) {
            $user[] = $r;
        }

        if(!empty($user)){
            return $user;
        }else{
            return false;
        }

    }

    public function user_login($email, $password){

        $arr  = [];
        $user = $this->user_exists($email);

        if($user){
            $password = hash('sha256', $password);

            $result = DB::$_MasterDB->query(" SELECT * FROM `users` where `email` = '$email' AND `password` = '$password'");

            $user = [];
            while($r = mysqli_fetch_assoc($result)) {
                $user[] = $r;
            }
            if(!empty($user)){
                $this->setSession_login($user);
                $arr['success']  =  'true';
            }else{
                $arr['error'] = 'Password not correct';
            }


        }else{
            $arr['error'] = 'Not registered yet';
        }
        return json_encode($arr);
    }

    public function polls_adding($poll_title, $poll_options){

        $result = DB::$_MasterDB->query("INSERT INTO `polls` (`user_id`,`poll_title`) VALUES ('$this->user_id','$poll_title') ");

        if($result){

            $LAST_INSERT_ID = DB::$_MasterDB->query("SELECT LAST_INSERT_ID()");
            $option_insert  = false;

            while($res = $LAST_INSERT_ID->fetch_assoc()){
                $lastId = $res['LAST_INSERT_ID()'];
            }

            foreach ($poll_options as $key => $val){
                $option_insert = DB::$_MasterDB->query("INSERT INTO `poll_options` (`poll_id`,`options`) VALUES ('$lastId','$val')");
            }

            if($option_insert && $result){
                return true;
            }else{
                return false;
            }

        }
        return false;

    }
    public function get_poll_items(){

        $poll_items_arr = [];
        $k = 0;
        $poll_items = DB::$_MasterDB->query( "SELECT  `T1`.id as `poll_id`,`T2`.id as `options_id`, `options`, poll_title
                                            FROM `polls` AS `T1`
                                            LEFT JOIN `poll_options` AS `T2`
                                            ON `T1`.`id` = `T2`.`poll_id`");



        while($res = $poll_items->fetch_assoc()){

            $v = 0;
            foreach ($poll_items_arr as $key => $val){

                if($poll_items_arr[$key]['poll_id'] == $res['poll_id'] ){
                    $poll_items_arr[$key]['options'][] =  $res['options'];
                    $poll_items_arr[$key]['options_id'][] =  $res['options_id'];
                    $v++;
                }
            }
            if($v == 0){
                $poll_items_arr[$k]['poll_id']     = $res['poll_id'];
                $poll_items_arr[$k]['options'][]   = $res['options'];
                $poll_items_arr[$k]['poll_title']  = $res['poll_title'];
                $poll_items_arr[$k]['options_id'][]  = $res['options_id'];
                $k++;
            }

        }

        return json_encode($poll_items_arr);

    }

    public function vote($option_id){


        $option_insert  = DB::$_MasterDB->query("UPDATE poll_options SET vote_count = vote_count + 1 WHERE id = '$option_id'");
        $option_insert1 = DB::$_MasterDB->query("INSERT INTO `poll_voltes` (`user_id`,`poll_options_id`) VALUES ('$this->user_id','$option_id')");

        if ($option_insert && $option_insert1){
            return true;
        }else{

            if(!$option_insert1){
                return '2'; //not logged in
            }
            return false;
        }
    }


    public function get_counts_of_votes($poll_id){

        $poll_items_arr = [];
        $k = 0;
        $poll_items = DB::$_MasterDB->query("SELECT  `T1`.id as `poll_id`,`T2`.id as `options_id`,`vote_count`, `options`, poll_title
                                            FROM `polls` AS `T1`
                                            LEFT JOIN `poll_options` AS `T2`
                                            ON `T1`.`id` = `T2`.`poll_id`
                                            WHERE `poll_id` = '$poll_id'");



        while($res = $poll_items->fetch_assoc()){

            $v = 0;
            foreach ($poll_items_arr as $key => $val){

                if($poll_items_arr[$key]['poll_id'] == $res['poll_id'] ){
                    $poll_items_arr[$key]['options'][] =  $res['options'];
                    $poll_items_arr[$key]['options_id'][] =  $res['options_id'];
                    $poll_items_arr[$key]['vote_count'][] =  $res['vote_count'];
                    $v++;
                }
            }
            if($v == 0){
                $poll_items_arr[$k]['poll_id']       = $res['poll_id'];
                $poll_items_arr[$k]['options'][]     = $res['options'];
                $poll_items_arr[$k]['poll_title']    = $res['poll_title'];
                $poll_items_arr[$k]['options_id'][]  = $res['options_id'];
                $poll_items_arr[$k]['vote_count'][]  = $res['vote_count'];
                $k++;
            }

        }
        return json_encode($poll_items_arr);

    }

    public function get_poll_for_edit(){

        $poll_items_arr = [];
        $k = 0;
        $poll_items = DB::$_MasterDB->query( "SELECT  `T1`.id as `poll_id`,`T2`.id as `options_id`, `options`, poll_title
                                            FROM `polls` AS `T1`
                                            LEFT JOIN `poll_options` AS `T2`
                                            ON `T1`.`id` = `T2`.`poll_id`
                                            WHERE  `T1`.user_id = '$this->user_id' ");



        while($res = $poll_items->fetch_assoc()){

            $v = 0;
            foreach ($poll_items_arr as $key => $val){

                if($poll_items_arr[$key]['poll_id'] == $res['poll_id'] ){
                    $poll_items_arr[$key]['options'][] =  $res['options'];
                    $poll_items_arr[$key]['options_id'][] =  $res['options_id'];
                    $v++;
                }
            }
            if($v == 0){
                $poll_items_arr[$k]['poll_id']     = $res['poll_id'];
                $poll_items_arr[$k]['options'][]   = $res['options'];
                $poll_items_arr[$k]['poll_title']  = $res['poll_title'];
                $poll_items_arr[$k]['options_id'][]  = $res['options_id'];
                $k++;
            }

        }

        return json_encode($poll_items_arr);
    }
    public function get_poll_items_for_edit($data_poll_id){

        $poll_items_arr = [];
        $k = 0;
        $poll_items = DB::$_MasterDB->query( "SELECT  `T1`.id as `poll_id`,`T2`.id as `options_id`, `options`, poll_title
                                            FROM `polls` AS `T1`
                                            LEFT JOIN `poll_options` AS `T2`
                                            ON `T1`.`id` = `T2`.`poll_id`
                                            WHERE  `T1`.user_id = '$this->user_id' and `T2`.poll_id = '$data_poll_id'");



        while($res = $poll_items->fetch_assoc()){

            $v = 0;
            foreach ($poll_items_arr as $key => $val){

                if($poll_items_arr[$key]['poll_id'] == $res['poll_id'] ){
                    $poll_items_arr[$key]['options'][] =  $res['options'];
                    $poll_items_arr[$key]['options_id'][] =  $res['options_id'];
                    $v++;
                }
            }
            if($v == 0){
                $poll_items_arr[$k]['poll_id']     = $res['poll_id'];
                $poll_items_arr[$k]['options'][]   = $res['options'];
                $poll_items_arr[$k]['poll_title']  = $res['poll_title'];
                $poll_items_arr[$k]['options_id'][]  = $res['options_id'];
                $k++;
            }

        }

        return json_encode($poll_items_arr);
    }

    public function delete_poll($deleted_poll_id){

        $del = DB::$_MasterDB->query( " DELETE FROM polls WHERE id = '$deleted_poll_id'");

        if($del){
            return true;
        }else{
            return false;
        }
    }

    public function edit_polls($edited_data){

        $title   = trim(DB::$_MasterDB->real_escape_string($edited_data["title"]));
        $data_id = trim(DB::$_MasterDB->real_escape_string($edited_data["data_id"]));
        $arr     = [];
        $arr_id  = [];

        $result =  DB::$_MasterDB->query( "SELECT * FROM poll_options  WHERE poll_id = '$data_id'");

        $update_title = DB::$_MasterDB->query( "UPDATE polls
                                                SET poll_title = '$title'
                                                WHERE id='$data_id'");


        if($update_title){
            foreach ($edited_data['options'] as $key => $value){
                $op = $value["value"];

                if(isset($value["data_id"])){

                    $id       = $value["data_id"];
                    $arr_id[] = $id;

                    $res = DB::$_MasterDB->query( "UPDATE poll_options
                                                SET `options` = '$op'
                                                WHERE id='$id'");

                }else{
                    $res = DB::$_MasterDB->query( "INSERT INTO poll_options (`poll_id`,`options`)
                                            VALUES ('$data_id','$op')");
                }

                if (!$res){
                    return false;
                }
            }
        }


        while($res = $result->fetch_assoc()){

           $idd = $res['id'];

           if(!in_array($res['id'] , $arr_id)){
               DB::$_MasterDB->query( " DELETE FROM poll_options WHERE id = '$idd'");
           }

        }

        return true;

    }

}
