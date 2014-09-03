<div class="container">
  <div class="row">        
    <div class="col-xs-4 col-xs-offset-3 col-md-4 col-md-offset-3" >
      <div class="page-header">
        <h1>login</h1>
      </div>
      <?php echo form_open('login/log_in', 'id="form_login"', 'role="form"'); ?>
        <div class="form-group">
          <?php 
          echo form_label('Nome utente (email)', 'utente_codice');
          echo form_input('utente_codice', '', 'id="utente_codice type="email" class="form-control" placeholder="inserire la vostra email"');
          ?>
        </div>
        <div class="form-group">
          <?php 
          echo form_label('Password', 'utente_password');
          echo form_password('utente_password', '', 'id="utente_password" class="form-control" placeholder="Password" ') ?>
        </div>
        <?php
          echo anchor('login/iscrizione', 'Nuovo Profilo');
          echo '&nbsp;';
          echo form_submit('submit', 'Login', 'class="btn btn-primary"');
          // password dimenticata
          // echo anchor('login/forgetPwd', '');
          if(isset($extra_datas)){
            echo "Username o password errati";
            }            
        ?>
        <?php echo form_close() ?>
        <?php echo validation_errors('<p class="error">') ?>

    </div>
  </div><!-- /.row -->
  <script type="text/javascript">
  <!--
  $(document).ready(function() {
    $('#utente_codice').select();
    
    $('form input').keydown(function(e) {
      if (e.keyCode == 13) {
        $('form').submit();
      }
    });
    
    $('#submit').click(function() {
      $('form').submit();
    });
  });
  //-->
  </script>
</div>

