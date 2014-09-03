<br>
<nav class="navbar " role="navigation">
	<div class="container-fluid">
		<div class="navbar-left navbar-nav">
			<div id="alertResponseUtenti">

			</div>
			<!-- <div class="response alert alert-dismissable fade">
				<span id="msg"></span>
			</div> -->
		</div>
		<div class="navbar-right navbar-nav">
			<!-- <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#addUserModal" ng-click="reloadCustomer()"><span class="fa fa-user"></span>&nbsp;Aggiungi Utente</button> -->
			<button class="btn btn-success btn-sm" data-toggle="modal" data-target="#addUserModal" ng-click="newUser()"><span class="fa fa-user"></span>&nbsp; Aggiungi Utente</button>
			<button class="btn btn-warning btn-sm" data-toggle="modal" data-target="" ng-click="editUser()"><span class="fa fa-pencil"></span>&nbsp; Modifica Utente</button>
			<button class="btn btn-danger btn-sm" data-toggle="modal" data-target="" ng-click="deleteUser()"><span class="fa fa-times-circle-o"></span>&nbsp; Elimina Utente</button>
		</div>
	</div>
</nav>
<div>
	<table cellpadding="8" cellspacing="0" border="0" class="display table table-striped table-bordered" id="dt_utente"> 
		<thead>
			<td><input type="checkbox" id="checkbox-selectAllUsers" style="float:none;margin:10px"/></td>
			<td>Nome</td>
			<td>Cognome</td>
			<td>Email</td>
			<td>Azienda</td>
		</thead>
	</table>
</div>

<?php include('w_utenti_modal.php');?>


