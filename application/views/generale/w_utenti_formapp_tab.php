<!-- <div class="checkbox" id="">
  <label>
    <input type="checkbox" ng-change="onCbChange(0)" ng-model="userModal.categories.formapp.apprendista" ng-true-value="1" ng-false-value="0">
    	Apprendista
  </label>
</div>
<div class="checkbox" id="">
  <label>
    <input type="checkbox" ng-change="onCbChange(1)" ng-model="userModal.categories.formapp.docente" ng-true-value="2" ng-false-value="0">
    	Docente
  </label>
</div>
<div class="checkbox" id="">
  <label>
    <input type="checkbox" ng-change="onCbChange(1)" ng-model="userModal.categories.formapp.tutor" ng-true-value="3" ng-false-value="0">
    	Tutor
  </label>
</div> -->
<div ng-repeat="formapp_item in formapp_items">
  <div class="checkbox">
    <label>
      <input type="checkbox" 
      ng-change="onCbprova()"
      id="item{{$index}}"
      name="{{formapp_item.name}}" 
      ng-model="formapp_item.checked" >
      {{formapp_item.name}}
    </label>
  </div>
</div>
