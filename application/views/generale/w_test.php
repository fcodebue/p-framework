<div ng-app="myApp">
	<div ng-controller="formCtrl">
        <br><br>
    <form  novalidate name="userForm" ng-submit="submitForm(userForm.$valid);">
        
        <!-- NOME -->
        <div class="form-group" ng-class="{ 'has-error' : userForm.name.$invalid && !userForm.name.$pristine }">
            <label>Nome</label>
            <input type="text" name="name" class="form-control" ng-model="name" required>
            <p ng-show="userForm.name.$invalid && !userForm.name.$pristine" class="help-block">campo obbligatorio</p>
        </div>

        <!-- EMAIL -->
        <div class="form-group" ng-class="{ 'has-error' : userForm.email.$invalid && !userForm.name.$pristine }">
            <label>Email</label>
            <input type="email" name="email" class="form-control" ng-model="e_mail" name-unique="email" required>
            <span class="help-inline" ng-show="form.$error.unique">Username taken!</span>
        </div>



        <button type="submit" class="btn btn-primary" ng-disabled="userForm.$invalid">Invia</button>
    </form>
	</div>
</div>

