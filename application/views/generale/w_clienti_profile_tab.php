<div class="row">
	<div class="form-group col-md-6" >
		<label for="inputAddress" class="control-label">Indirizzo</label>
		<input type="text" class="form-control input-sm" id="inputAddress" ng-model="customerModal.indirizzo" placeholder="Esempio: Via Rossi 42">
	</div>
		
	<div class="form-group col-md-6 ">
		<label for="inputNat" class="control-label">Nazione</label>
		<select 
		class="input-sm form-control"
		ng-options="item.nazione for item in nationsList"
		ng-model="nationSelected"
		ng-change="onNationChange()">
		</select>
	</div>

		<div class="form-group col-md-6">
			<label for="inputProv" class="control-label">Provincia</label>
			<select 
				id="provincia"
				class="input-sm form-control"
				ng-options="item.nomeprovincia for item in provinceList"
				ng-change="onProvChange()"
				ng-model="provinceSelected"
				ng-disabled="provinciaDisabled">
			<option value="">Seleziona una Provincia</option>
			</select>
		</div>
	
		<div class="form-group col-md-6">
			<label for="inputComune" class="control-label">Comune</label>
			<select
			id="comune"
			class="form-control input-sm disabled"
			ng-model="comuneSelected"
			ng-change="onComuneChange()"
			ng-options="item.nomecomune for item in comuniList"
			ng-disabled="comuneDisabled">
				<option value="">Seleziona un Comune</option>
			</select>
		</div>
		
	<div class="form-group col-md-6">
		<label for="inputWebsite" class="control-label">Website</label>
		<input type="text" class="form-control input-sm" id="inputPec" ng-model="customerModal.website" placeholder="Website">
	</div>

	<div class="form-group col-md-6">
		<label for="inputPec" class="control-label">Pec</label>
		<input type="text" class="form-control input-sm" id="inputPec" ng-model="customerModal.pec" placeholder="Pec">
	</div>
	
	<div class="form-group col-sm-6">
		<label for="inputTelefono" class="control-label">Telefono</label>
		<input type="text" class="form-control input-sm" id="inputTelefono" ng-model="customerModal.telefono" placeholder="Telefono">
	</div>

	<div class="form-group col-md-6">
		<label for="inputMob" class="control-label">Mobile</label>
		<input type="text" class="form-control input-sm" id="inputMob" ng-model="customerModal.mobile" placeholder="Mobile">
	</div>

	<div class="form-group col-md-6">
		<label for="inputFax" class="control-label">Fax</label>
		<input type="text" class="form-control input-sm" id="inputFax" ng-model="customerModal.fax" placeholder="Fax">
	</div>

</div>