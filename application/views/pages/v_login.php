<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?php echo $title; ?></title>
    <link href="<?php echo base_url(); ?>asset/css/login.css" rel="stylesheet"> 
    <link href="<?php echo base_url(); ?>asset/css/font-awesome.min.css" rel="stylesheet" />
    <link href="<?php echo base_url('asset/img/favicon.ico')?>" rel="shortcut icon" >    
  </head> 
  <body>    
  <div class="container">
    <div class="row text-center pad-top ">
        <div class="col-md-12">
            <h1>CIJUAL Login Page</h1>
        </div>
    </div>
   <div class="row pad-top">
      <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading">
            <strong>Aplikasi pengeluaran dan Inventori</strong>  
          </div>
          <div class="panel-body">
            <?php echo form_open('login/cek_login','class="form"'); ?>
              <div class="form-group input-group">
                <span class="input-group-addon"><i class="fa fa-tag"  ></i></span>
                <input type="text" class="form-control" name="username" value="<?php echo set_value('username'); ?>" placeholder="Your Username " />
              </div>
              <div class="form-group input-group">
                <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                <input type="password" class="form-control" name="password" placeholder="Your Password" />
              </div>
              <button type="submit" class="btn btn-primary ">Login</button>
            <?php echo form_close(); ?>
          </div>                       
        </div>
      </div>
    </div>
    <div class="alert_container">
      <?php if(validation_errors()) { ?>
      <div class="alertx alert-danger">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <h4>Oops! We have a problem here</h4>
        <?php echo validation_errors(); ?>
      </div>
      <?php } ?>
      
      <?php if($this->session->flashdata('warning')) { ?>
      <div class="alert alert-error">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <h4>Oops! We have a problem here..</h4>
        <?php echo $this->session->flashdata('warning'); ?>
      </div>
      <?php } ?>
    </div>
    <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY  -->
    <script src="<?php echo base_url(); ?>asset/js/jquery.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="<?php echo base_url(); ?>asset/js/bootstrap.js"></script>
  </body>
</html>
