<div class="container-fluid">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a id="base_url" class="navbar-brand" href="<?php echo base_url(); ?>"  >
      <img src="<?php echo base_url().'resources/img/logo-mini.png'?>" alt="ora si lavora assieme" style="position:relative;top:-15px;">
    </a>
  </div>
  <div class="navbar-collapse collapse">

    <?php
      if(!$this->ion_auth->logged_in()){
    ?>
    <?php 
      $form_attr = array('class'=>'navbar-form navbar-right','role' => 'form');
      echo form_open('auth/login',$form_attr);

     ?>
    <!-- <form class="navbar-form navbar-right" role="form"> -->
      <div class="form-group">
        <?php 
        $input_email_params = array('class' => 'form-control','placeholder' => 'Email','name' => 'identity','type' => 'text');
        echo form_input($input_email_params);
        ?>
        <!-- <input type="text" placeholder="Email" class="form-control"> -->
      </div>
      <div class="form-group">
        <?php
        $input_pwd_params = array('class' => 'form-control','placeholder' => 'password','name' => 'password','type' => 'password');
        echo form_input($input_pwd_params);
        ?>
      </div>

      <?php
        $value = lang('login_submit_btn');

        $submit_params = array('class' =>'btn btn-success','type'=>'submit');

        echo form_submit($submit_params , 'Login');
      ?>

      <!-- <button type="submit" class="btn btn-success">Sign in</button> -->
    
    <!-- </form> -->
    <?php echo form_close();?>
    
    <?php  }else{?>


    <ul class="nav navbar-nav navbar-right">
      <!-- <li><a href="#">Dashboard</a></li> -->
      <!-- <li><a href="#">Settings</a></li> -->
      
      <li class="dropdown messages-dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i> Contatti <b class="caret"></b></a>
        <ul class="dropdown-menu">
          <li><a href="#"><i class="fa fa-gear"></i> FAQ</a></li>
          <li><a href="#"><i class="fa fa-skype"></i> Skype</a></li>
          <li><a href="#"><i class="fa fa-envelope"></i> Email</a></li>
          <li class="divider"></li>
          <li><a href="#"><i class="fa fa-facebook"></i> Facebook</a></li>
          <li><a href="#"><i class="fa fa-twitter"></i> Twitter</a></li>
        </ul>
      </li>
      
      <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $this->ion_auth->user()->row()->username; ?><b class="caret"></b></a>
          <ul class="dropdown-menu">            
            <li><a href="<?php echo base_url(); ?>c_generale/profilo"><i class="fa fa-user"></i> Profilo</a></li>
            <li><a href="#"><i class="fa fa-gear"></i> Impostazioni</a></li>
            <li class="divider"></li>
            <li><a href="<?php echo base_url('login/log_out'); ?>"><i class="fa fa-power-off"></i> Esci</a></li>
          </ul>
        </li><!-- chiude il dropdown -->
    </ul>

    <?php  } ?>
    <!-- <form class="navbar-form navbar-right">
      <input type="text" class="form-control" placeholder="Search...">
    </form> -->
  </div>
</div>




   