<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    	<div class="modal-content">
			<form  role="form" autocomplete="off">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>	
					<h3>Aggiungi Utente</h3>
				</div>
				<div class="modal-body">

					<ul class="nav nav-tabs" id="">
						<li class="defaultActiveUserModalTab active"><a href="#uno" data-toggle="tab" data-target="#userAccount">Account</a></li>
						<li class="userModalTab"><a href="#apprendista" data-toggle="tab" data-target="#userApprendista">Apprendista</a></li>
					</ul>

					<div class="tab-content" id="">
						<br>
						<div class="tab-pane defaultActiveUserModalTab active" id="userAccount"><!-- apre userAccount -->
							<?php include('w_utenti_account_tab.php'); ?>
						</div><!-- chiude Account  -->
						<div class="tab-pane userModalTab" id="userApprendista"><!-- inizio apprendista -->
							<div id="apprendistaContainer">
								<?php include('w_utenti_formapp_tab.php'); ?>
							</div>							
						</div><!-- fine apprendista -->
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-danger btn-sm" data-dismiss="modal">Annulla</button>
					<button type="submit" class="btn btn-success btn-sm" ng-click="saveOrUpdateUser()">Salva</button>
				</div>
			</form>    		
    	</div>
    </div>
  </div>
</div>