<div class="modal fade" id="userEditModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    	<div class="modal-content">
			<form  role="form" autocomplete="off" data-toggle="validator" novalidate>
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>	
					<h3>Modifica Profilo</h3>
				</div>
				<div class="modal-body">
					
						
					<div class="row">
						<div class="form-group col-sm-6">
							<label for="inputName" class="control-label">Nome</label>
							<input type="text" class="form-control input-sm" id="inputName" placeholder="Nome" ng-model="userEdit.first_name">
						</div>
						<div class="form-group col-sm-6">
							<label for="inputLastname" class="control-label">Cognome</label>
							<input type="text" class="form-control input-sm" id="inputLastname" placeholder="Cognome" ng-model="userEdit.last_name" >
						</div>
						<!-- <div class="form-group col-sm-6">
							<label for="inputEmail" class="control-label">Email</label>
							<input type="email" class="form-control input-sm" ng-unique="users.email" id="inputEmail" placeholder="Email" ng-model="userEdit.email">
						</div> -->
						<div class="form-group col-sm-6">
							<label for="inputTelephone" class="control-label">Telefono</label>
							<input type="text" class="form-control input-sm" id="inputTelephone" placeholder="Telefono" ng-model="userEdit.phone">
						</div>
						<div class="form-group col-sm-12">
							<label for="inputPassword" class="control-label">Password</label>	
							<div class="row">
								<div class="col-sm-6">
									<input type="password" data-minlength="8" class="form-control input-sm" id="inputPassword" ng-model="userEdit.password" >
									<span class="help-block"> Inserire una nuova password <br>lasciano il campo vuoto si manterr&agrave; la precendete</span>
								</div>
								<div class="col-sm-6">
									<input type="password" class="form-control input-sm" id="inputPasswordConfirm" placeholder="Conferma" data-match="#inputPassword"
									data-error="Min 8 caratteri" data-match-error="Attenzione, le password non corrispondono">
									<div class="help-block with-errors"></div>
								</div>
							</div>
						</div>
					</div>
						
					
				</div>
				<div class="modal-footer">
					<button class="btn btn-danger btn-sm" data-dismiss="modal">Annulla</button>
					<button type="submit" class="btn btn-success btn-sm" ng-click="saveProfile()">Salva</button>
				</div>
			</form>    		
    	</div>
    </div>
  </div>
</div>