<br>
<nav class="navbar " role="navigation">
	<div class="container-fluid">
		<div class="navbar-left navbar-nav">
			<div id="alertResponseClienti">

			</div>
		</div>
		<div class="navbar-right navbar-nav">
			<button class="btn btn-success btn-sm" ng-click="newCustomer()"><span class="fa fa-user"></span>&nbsp; Aggiungi Cliente</button>
			<button class="btn btn-warning btn-sm" ng-click="editCustomer()"><span class="fa fa-pencil"></span>&nbsp; Modifica Cliente</button>
			<button class="btn btn-danger btn-sm" ng-click="deleteCustomer()"><span class="fa fa-times-circle-o"></span>&nbsp; Elimina Cliente</button>
		</div>
	</div>
</nav>
	<table cellpadding="8" cellspacing="0" border="0" class="display table table-striped table-bordered" id="dt_customer"> 
		<thead>
			<td><input type="checkbox" id="checkbox-selectAllCustomers" style="float:none;margin:10px"/></td>
			<td>Ragione Sociale</td>
			<td>Nome</td>
			<td>Cognome</td>
			<td>Email</td>
		</thead>
	</table>

<?php include('w_clienti_modal.php'); ?>

