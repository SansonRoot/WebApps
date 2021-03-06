<?php
require_once 'core/init.php';
$user=new User();
$validate=new Validate();

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Knust Philla Real Time Chart</title>
      <link rel="stylesheet" href="bootstrap/css/bootstrap.css" charset="utf-8">
      <link rel="stylesheet" href="bootstrap/css/advanced/advanced.css" charset="utf-8">
      <link rel="stylesheet" href="bootstrap/css/style.css" charset="utf-8">
      <link rel="stylesheet" href="bootstrap/css/advanced/knust-filla.min.css">
  </head>
  <body>
    <div class="container">
      <header class="nav">
        <div class="row">
            <div class="col-md-6 col-md-offset-3 col-lg-offset-4 col-sm-offset-3 col-xs-offset-2">
                <a href="index.php" class="btn-lg btn-success">WELCOME TO KNUST FILLA CHATROOM</a>
            </div>
        </div>
      </header>
      <div class="clearfix">
      </div><br>
        <!--End of navbar-->

      <div class="well">
        <div class="row">
          <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-success">
                <div class="panel-heading">
                  <p class="text-muted col-sm-6 col-sm-offset-3">
                    <h3><strong>REGISTER TO JOIN THE CHATROOM</strong></h3>
                  </ p>
                </div>
                <div class="panel-body">
                  <form class="form-horizontal" role="form" action="register.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                      <label for="username" class="control-label col-md-3">Username :</label>
                      <div class="col-md-6">
                        <input type="text" name="username" placeholder="Username" autofocus="autofocus" value="<?php echo Input::get('username')?>" id="username" class="form-control">
                      </div>
                    </div>
                    <div class="form-group ">
                      <label for="password" class="control-label col-md-3">Password :</label>
                      <div class="col-md-6">
                        <input type="password" name="password" value="" placeholder="Password" id="password" class="form-control">
                      </div>
                    </div>
                    <div class="form-group ">
                      <label for="password-confirm" class="control-label col-md-3">Confirm Password :</label>
                      <div class="col-md-6">
                        <input type="password" placeholder="Confirm Password" name="password-confirm" id="password-confirm" class="form-control">
                      </div>
                    </div>
                    <input type="submit" class="btn btn-lg btn-block btn-success" value="Join">
                  </form>
                </div>
                <div class="panel-footer">
                    <?php

                    if(Input::exists()){
                        $validation=$validate->check($_POST,array(
                            'username'=>array(
                                'required'=>true,
                                'unique'=>'users',
                                'min'=>2,
                                'max'=>30
                            ),
                            'password'=>array(
                                'required'=>true,
                                'min'=>5
                            ),
                            'password-confirm'=>array(
                                'required'=>true,
                                'matches'=>'password'
                            )
                        ));
                        if($validation->passed()){
                            try{
                                $salt=Hash::salt(32);
                                $user->create('users',array(
                                    'username'=>Input::get('username'),
                                    'password'=>Hash::make(Input::get('password'),$salt),
                                    'salt'=>$salt,
                                    'ipaddress'=>Input::getIp()
                                ));

                            }catch (Exception $e){
                                die($e->getMessage());
                            }
                            if ($user->login(Input::get('username'), Input::get('password'), 'users')) {
                                Redirect::to('chat.php');
                            }
                        }else{ ?>
                            <div class="alert alert-danger alert-dismissable">
                                <button class="close" data-dismiss="alert" data-toggle="dismiss" aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></button>
                                <h4>Registration Failed</h4> <?php
                                foreach ($validation->errors() as $error) {
                                    echo $error . '<br/>';
                                }
                                echo '</div>';
                        }
                    }

                    ?>
                </div>
            </div>
          </div>
        </div>
      </div>
    </ div>
  </ body>
</ html>
