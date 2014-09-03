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