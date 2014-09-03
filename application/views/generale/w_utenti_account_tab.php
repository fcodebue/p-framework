<div class="row">
	<div class="form-group col-sm-6">
		<label for="inputName" class="control-label">Nome</label>
		<input type="text" class="form-control input-sm" id="inputName" placeholder="Nome" ng-model="userModal.first_name">
	</div>
	<div class="form-group col-sm-6">
		<label for="inputLastname" class="control-label">Cognome</label>
		<input type="text" class="form-control input-sm" id="inputLastname" placeholder="Cognome" ng-model="userModal.last_name" >
	</div>
	<div class="form-group col-sm-6">
		<label for="inputEmail" class="control-label">Email</label>
		<input type="email" class="form-control input-sm" ng-unique="users.email" id="inputEmail" placeholder="Email" ng-model="userModal.email">
	</div>
	<div class="form-group col-sm-6">
		<label for="inputTelephone" class="control-label">Telefono</label>
		<input type="text" class="form-control input-sm" id="inputTelephone" placeholder="Telefono" ng-model="userModal.phone">
	</div>
	<div class="form-group col-sm-12 company">
		<label for="inputCompany" class="control-label">Azienda</label>
		<input type="text"
			ng-model="userModal.company"
			placeholder="Azienda"
			typeahead-editable="false"
			typeahead="azienda as azienda.ragione_sociale for azienda in companyList | limitTo:8 | filter:$viewValue"
			class="form-control input-sm"
			typeahead-on-select="onCustomerSelect($item, $model, $label)"
			id="inputCompany"
		 /> 
	</div>
	<div class="form-group col-sm-12">
		<label for="inputPassword" class="control-label">Password</label>	
		<div class="row">
			<div class="col-sm-6">
				<input type="password" data-minlength="8" class="form-control input-sm" id="inputPassword" ng-model="userModal.password" >
				<span class="help-block">Minimo 8 Caratteri</span>
			</div>
			<div class="col-sm-6">
				<input type="password" class="form-control input-sm" id="inputPasswordConfirm" placeholder="Conferma" >
			</div>
		</div>
	</div>
</div>
