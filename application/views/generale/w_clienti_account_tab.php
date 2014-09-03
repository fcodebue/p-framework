<div class="row">
	<div class="form-group col-sm-6">
		<label for="inputRs" class="control-label">Ragione Sociale</label>
		<input type="text" ng-model="customerModal.ragione_sociale" class="form-control input-sm" id="inputRs" placeholder="Ragione Sociale" >
	</div>
	<div class="form-group col-sm-6">
		<label for="inputEmail" class="control-label">Email</label>
		<input type="email" ng-model="customerModal.email" class="form-control input-sm" id="inputEmail" placeholder="Email" >
	</div>
	<div class="form-group col-sm-6">
		<label for="inputName" class="control-label">Nome</label>
		<input type="text" ng-model="customerModal.first_name" class="form-control input-sm" id="inputName" placeholder="Nome" >
	</div>
	<div class="form-group col-sm-6">
		<label for="inputCognome" class="control-label">Cognome</label>
		<input type="text" ng-model="customerModal.last_name" class="form-control input-sm" id="inputCognome" placeholder="Cognome" >
	</div>
	<div class="form-group col-sm-6">
		<label for="inputPiva" class="control-label">Partita Iva</label>
		<input type="text" class="form-control input-sm" ng-model="customerModal.partita_iva" id="inputPiva" placeholder="P.Iva" >
	</div>
	<div class="form-group col-sm-6">
		<label for="inputCf" class="control-label">Codice Fiscale</label>
		<input type="text" class="form-control input-sm" id="inputCf" ng-model="customerModal.codice_fiscale"  placeholder="Codicefiscale" >
	</div>
	 
	<!--
	<div class="form-group col-sm-4">
		<label for="inputMob" class="control-label">Cellulare</label>
		<input type="text" class="form-control input-sm" id="inputTelefono" placeholder="Cellulare">
	</div>
	<div class="form-group col-sm-4">
		<label for="inputFax" class="control-label">Fax</label>
		<input type="text" class="form-control input-sm" id="inputFax" placeholder="Cellulare">
	</div>	 -->

	<div class="form-group col-sm-12">
		<label for="inputPassword" class="control-label">Password</label>	
		<div class="row">
			<div class="col-sm-6">
				<input type="password" data-toggle="validator" data-minlength="8" ng-model="customerModal.password" class="form-control input-sm" id="inputPassword" placeholder="Password" >
				<span class="help-block">Minimo 8 Caratteri</span>
			</div>
			<div class="col-sm-6">
				<input type="password" class="form-control input-sm" id="inputPasswordConfirm" data-match="#inputPassword" data-match-error="Le password non corrispondono" placeholder="Conferma" >
			</div>
		</div>
	</div>
</div>