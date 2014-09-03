<div class="modal fade" id="customerModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    	<div class="modal-content">
			<form role="form" autocomplete="off">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>	
					<h3>Aggiungi Cliente</h3>
				</div>
				<div class="modal-body">
					<ul class="nav nav-tabs" id="">
					  <li class="active defaultActiveCustomerModalTab "><a hrref="#home" data-toggle="tab" data-target="#costumerAccount">Account</a></li>
					  <li class="customerModalTab"><a href="#anagrafica " data-toggle="tab" data-target="#costumerProfile">Anagrafica</a></li>
					</ul>

					<div class="tab-content">
						<br>
					  <div class="tab-pane active defaultActiveCustomerModalTab" id="costumerAccount">
						  	<?php include('w_clienti_account_tab.php'); ?>
					  </div>
					  <div class="tab-pane customerModalTab " id="costumerProfile">
					  		<?php include('w_clienti_profile_tab.php');?>
					  </div>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-danger btn-sm" data-dismiss="modal">annulla</button>
					<button type="submit" class="btn btn-success btn-sm" ng-click="saveOrUpdateCustomer()" >salva</button>
				</div>
			</form>    		
    	</div>
    </div>
  </div>
</div>