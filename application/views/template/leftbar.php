<?php if(!empty($moduli)){  ?>
<div class="panel-group" id="accordion" style="padding-top:100px;">
  <?php 
      for ($i= 0; $i < count($moduli) ; $i++) { 
  ?>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#<?php echo $moduli[$i]['moduloHtml']; ?>">
          <?php echo $moduli[$i]['modulo']; ?>
        </a>
      </h4>
    </div>
    <div id="<?php echo $moduli[$i]['moduloHtml']; ?>" class="panel-collapse collapse <?php if($i == 0){echo 'in';} ?>">
      <div class="panel-body">
        <?php
          $currentHtmlmodulo = $moduli[$i]['moduloHtml'];
          if(!empty($sub[$currentHtmlmodulo])){ 
        ?>
        <ul class="nav nav-sidebar">

            <?php  $limite = count($sub[$currentHtmlmodulo]);
              for ($c=0; $c < $limite; $c++) {  ?>

              <li>
                <a href="<?php echo base_url().$sub[$currentHtmlmodulo][$c]['indirizzo']; ?>">
                 <i class="<?php echo $sub[$currentHtmlmodulo][$c]['icon']; ?>"> </i> 
                 <?php echo $sub[$currentHtmlmodulo][$c]['submodulo']; ?>
                </a>
              </li>

              <?php } ?>
        </ul>
        <?php } ?>

      </div>
    </div>
  </div>
  <?php } //chiude il for ?>
</div>
<?php  
} //chiude if ?>
<?php 

  // var_dump($sub['bandi'][3]['submodulo']);
  // echo count($sub['bandi']);
?>