<div ng-app="generalApp">
	<div id="userId" ng-controller="profilo">
		<div class="page-header">
	  		<h2><i class="fa fa-user"></i>&nbsp; Profilo <?php echo $nome. ' ' . $cognome ?></h2>
		</div>
		
		<nav class="navbar " role="navigation">
		  <div class="container-fluid">
		    <div class="navbar-left navbar-nav">
		      <div id="alertProfilo">

		      </div>
		    </div>
		    <div class="navbar-right navbar-nav">
		      <button class="btn btn-sm btn-warning" ng-click="editProfile()"><i class="fa fa-pencil"></i>&nbsp; Modifica profilo</button>
		    </div>
		  </div>
		</nav>

		<div class="row">
			<div class="col-md-3">
				<table class="table-condensed table">
					<tbody>
						<tr>
							<td>Nome</td>
							<td>{{user.first_name}}</td>
						</tr>
						<tr>
							<td>Cognome</td>
							<td>{{user.last_name}}</td>
						</tr>
						<tr>
							<td>Email</td>
							<td>{{user.email}}</td>
						</tr>
						<tr>
							<td>Ragione Sociale</td>
							<td>{{user.ragione_sociale}}</td>
						</tr>
						<tr>
							<td>Phone</td>
							<td>{{user.phone}}</td>
						</tr>

					</tbody>
				</table>
			</div>
		</div>

		<div>

		</div>
		<?php include('w_profilo_edit_modal.php'); ?>
	</div>
</div>