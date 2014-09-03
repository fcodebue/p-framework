var gApp = angular.module('generalApp',['ui.bootstrap','mgcrea.ngStrap']);

gApp.controller('gUser',['$scope','$http','$alert',function($scope,$http,$alert){
	$scope.user = {};
	$scope.companyList = [];
	$scope.userSelected = null;
	$scope.userList = [];
	$scope.newUserModal = {
		"id":"",
		"first_name":"",
		"last_name":"",
		"telephone":"",
		"email":"",
		"company":"",
		"password":"",
		"id_cliente":"",
		"categories":[],
		"ragione_sociale":"",
	};
	angular.element(document).ready(function(){		

		spinner.spin(target);
		$http({
				method:'POST',
				url:'get_company'
			}).success(function(data){
				$scope.companyList = data;
			}).error(function(){
				console.log('error');
			});	
		spinner.spinEnd();	
		
	});

	$scope.fillFormapp = function(){
		$http({
			method:'POST',
			url:'formapp_cb'
		}).success(function(data){
			$scope.formapp_items = data;
			// console.log(data);
		}).error(function(){
			console.log('error');
		});
	}

	$scope.onCbprova = function(){
		// var item0 = document.getElementById('item0');
		// var item1 = document.getElementById('item1');
		// var item2 = document.getElementById('item2');
		

		// // if(item0.checked == true){
		// // 	item1.checked = false;
		// // 	item2.checked = false;
		// // }

		// if(item1.checked == true || item2.checked == true){
		// 	if(item0.checked == true){
		// 		item0.checked = false;
		// 	}
		// }
	}

	$scope.reloadCustomer = function(){
		$scope.customers = '';
		
		$http({
			method:'POST',
			url:'get_company'
		}).success(function(data){
			$scope.customers = data;
		}).error(function(){
		});
	}

	$scope.onCustomerSelect = function($item,$model,$label){
		console.log('selected ' + $model.ragione_sociale + ' con id ' + $model.id );
	}

	$scope.invia = function(){

		console.log($scope.user);

		$http({
			method:'POST',
			url:'register_user',
			data:$scope.user,
			headers:{
				'Content-Type':'application/json'
			}
		}).success(function(){
			console.log('success');
			$('#addUserModal').modal('hide');
		}).error(function(){
			console.log('error');
		});	
	}

	function showUserModal(){
		$('.userModalTab').removeClass('active');
		$('.defaultActiveUserModalTab').addClass('active');
		$('#userModal').modal('show');
	}

	function hideUserModal(){
		$('#userModal').modal('hide');	
	}

	$scope.newUser = function(){
		$scope.userModal = JSON.parse(JSON.stringify($scope.newUserModal));
		$scope.fillFormapp();
		showUserModal();
	}

	$scope.getIndexByValue = function(obj, valToFind, destination){
		var id = parseInt(valToFind);
		angular.forEach(obj,function(value, key){
			var value = parseInt(value.id);
			if(value == id){
				switch(destination){
					case'company':
						$scope.userModal.company = $scope.companyList[key];
					break;
				}
			}
		});
	}

	$scope.editUser = function(){
		if($scope.userSelected === null) return;
		$scope.userModal = $scope.userSelected;
		$scope.getIndexByValue($scope.companyList,$scope.userModal.id_cliente, 'company');
		$scope.load_formapp();
		showUserModal();
	}

	$scope.deleteUser = function(){
		var userToDelete = $.grep($scope.userList, function(e){return e.selected;});
		if(userToDelete === 0 && ($scope.userToDelete === null)) return;
		if(userToDelete === 0){
			userToDelete.push($scope.userSelected);
		}
		if(userToDelete.length === 1 && !confirm("Delete user '" + $scope.userSelected.first_name + ' ' + $scope.userSelected.last_name + "' ?" )){
			return;
		} else if(userToDelete.length > 1 && !confirm("Delete " + userToDelete.length + " users ? ")){
			return;
		}
		$http({
			method:'POST',
			url:'delete_user',
			data:userToDelete,
			headers: {
                'Content-Type': 'application/json'
            }
		}).success(function(data){
			$(document).trigger('onUserSaved');
			hideUserModal();
			$(document).trigger('showAlertUtenti',data);
		});
	}

	$scope.saveOrUpdateUser = function(){
		
		spinner.spinStart();
		if($scope.userModal.created_on == "" || !$scope.userModal.created_on ){
			$http({
				method:'POST',
				url:'register_user',
				data:$scope.userModal
			}).success(function(data){
				$scope.saveFormapp(data);
				$(document).trigger('onUserSaved');
				$(document).trigger('showAlertUtenti',data);
				hideUserModal();
			})
		}else{
			if(!$scope.userModal.company){
				$('.company').addClass('has-error');
			}else{
				$('.company').removeClass('has-error');
			}
			$http({
				method:'POST',
				url:'update_user',
				data:$scope.userModal
			}).success(function(data){
				console.log(data);
				$(document).trigger('onUserSaved');
				$scope.saveFormapp();
				$(document).trigger('showAlertUtenti',data);
				hideUserModal();
			})
		}

		spinner.spinEnd();	
	}

	$scope.load_formapp = function(){
		$http({
			method:'POST',
			url:'load_formapp',
			data:$scope.userModal.id,
			headers:{
				'Content-Type':'application/json'
			}
		}).success(function(data){
			if(data){
				$scope.formapp_items = data;	
			}else{
				$scope.fillFormapp();
			}
			
		});
	}

	$scope.saveFormapp = function(id = null){
		if(id){
			angular.forEach($scope.formapp_items, function(value,key){
				value.user_id = id;
			});
		}

		$http({
			method:'POST',
			url:'save_formapp',
			data:$scope.formapp_items,
		}).success(function(data){
		});
	}

	$(document).bind('onSingleUserSelected',function(event, userObject) {
		if(userObject){
			$scope.userSelected = userObject
		}else{
			$scope.userSelected = null;
		}
	});

	$(document).bind('onUserListChanged', function(event, userListWrapper) {
		$scope.userList = userListWrapper.data;
	});
}]);

gApp.controller('cUser',['$scope','$http','$alert',function($scope,$http,$alert){
	$scope.regioniList = [];
	$scope.provinceList = [];
	$scope.nationsList = [];
	$scope.comuniList = [];
	$scope.id_regione = '';
	$scope.customerList = [];
	$scope.customerSelected = null;
	
	$scope.newCustomerModal = {
		"id":"",
		"id_cliente":"",
		"password":"",
		"ragione_sociale":"",
		"email":"",
		"first_name":"",
		"last_name":"",
		"partita_iva":"",
		"codice_fiscale":"",
		"telefono":"",
		"indirizzo":"",
		"id_nazione":"",
		"id_localita":"",
		"id_provincia":"",
		"website":"",
		"pec":"",
		"mobile":"",
		"fax":"",
		"ruolo":""
	};

	angular.element(document).ready(function(){
		$scope.get_province();
		
		$http({
			method:'POST',
			url:'get_nation'
		}).success(function(data){
			$scope.nationsList = data;
			$scope.nationSelected = $scope.nationsList[107];
		}).error(function(){
			console.log('error');
		});
	});

	$scope.onProvChange = function(){
		var id_prov = $scope.provinceSelected.id_provincia;
		$scope.customerModal.id_provincia = id_prov;
		$http({
			method:'POST',
			url:'get_comuni',
			data:id_prov
		}).success(function(data){
			$scope.comuniList = data;
		}).error(function(){
			console.log('error');
		});	
	} 

	$scope.onComuneChange = function(){
		$scope.customerModal.id_localita = $scope.comuneSelected.id_comune;
	}

	$scope.onNationChange = function(){
		$scope.customerModal.id_nazione = $scope.nationSelected.id;
		console.log($scope.nationSelected);
		if($scope.nationSelected.id != 110){
			$scope.comuneDisabled = true;
			$scope.provinciaDisabled = true;
			$scope.provinceList = [];
			$scope.comuniList = [];
			$scope.customerModal.id_provincia = "";
			$scope.customerModal.id_localita = "";
		}else{
			$scope.comuneDisabled = false;
			$scope.provinciaDisabled = false;
			$http({
				method:'POST',
				url:'get_province'
			}).success(function(data){
				$scope.provinceList = data;
			}).error(function(){
				console.log('error');
			});
		}
	}

	$scope.newCustomer = function(){
		$scope.customerModal = JSON.parse(JSON.stringify($scope.newCustomerModal));
		showCustomerModal();
		$scope.nationSelected = $scope.nationsList[107];
		$scope.provinceSelected = $scope.provinceList[-1];
		$scope.comuneSelected = [];
	}

	$scope.editCustomer = function(){
		if($scope.userSelected === null) return;
		$scope.customerModal = $scope.customerSelected;
		console.log($scope.customerModal);
		if($scope.customerModal.id_nazione != 110){
			$scope.provinciaDisabled = true;
			$scope.comuneDisabled = true;
		}
		if($scope.provinceList < 1) $scope.get_province();
		$scope.get_comuni($scope.customerModal.id_provincia);
		$scope.getIndexByValue($scope.comuniList,$scope.customerModal.id_localita,'comune');
		$scope.getIndexByValue($scope.provinceList,$scope.customerModal.id_provincia,'prov');
		$scope.getIndexByValue($scope.nationsList,$scope.customerModal.id_nazione,'nazione');
		


		showCustomerModal();
	}

	$scope.get_province = function(){
		$http({
			method:'POST',
			url:'get_province'
		}).success(function(data){
			$scope.provinceList = data;
		}).error(function(){
			console.log('error');
		});
	}

	$scope.get_comuni = function(id_provincia){
		var id_prov = parseInt(id_provincia);
		$http({
			method:'POST',
			url:'get_comuni',
			data:id_prov
		}).success(function(data){
			$scope.comuniList = data;
		}).error(function(){
			console.log('error');
		});	
	}

	function showCustomerModal(){
		$('.customerModalTab').removeClass('active');
		$('.defaultActiveCustomerModalTab').addClass('active');
		$('#customerModal').modal('show');
	}
	
	function hideCustomerModal(){
		$('#customerModal').modal('hide');	
	}

	$(document).bind('onSingleCustomerSelected', function(event, customerObject) {
		if(customerObject){
			$scope.customerSelected = customerObject;
		}else{
			$scope.customerSelected = null;
		}
	});

	$(document).bind('onCustomerListChanged', function(event,  customerListWrapper) {
		$scope.customerList = customerListWrapper.data;
	});

	$scope.saveOrUpdateCustomer = function(){
		$scope.customerModal.id_nazione = $scope.nationSelected.id;
		if($scope.customerModal.created_on == "" || !$scope.customerModal.created_on ){
			$http({
				method : 'POST',
				url : 'registerCustomer',
				data : $scope.customerModal
			}).success(function(data){
				console.log(data);
				$(document).trigger('refreshCustomerTable');
				$(document).trigger('showAlertClienti',data);
				hideCustomerModal();
			})
		}else{
			$http({
				method : 'POST',
				url : 'updateCustomer',
				data : $scope.customerModal
			}).success(function(data){
				console.log(data);
				$(document).trigger('refreshCustomerTable');
				$(document).trigger('showAlertClienti',data);
				hideCustomerModal();
			})
		}
	}

	$scope.deleteCustomer = function(){
		var customerToDelete = $.grep($scope.customerList, function(e){return e.selected;});
		if(customerToDelete === 0 && ($scope.customerToDelete === null)) return;
		if(customerToDelete === 0){
			customerToDelete.push($scope.customerSelected);
		}
		if(customerToDelete.length === 1 && !confirm("Delete user '" + $scope.customerSelected.ragione_sociale + "' ?" )){
			return;
		} else if(customerToDelete.length > 1 && !confirm("Delete " + customerToDelete.length + " customers ? ")){
			return;
		}


		$http({
			method:'POST',
			url:'deleteCustomer',
			data:customerToDelete,
			headers: {
                'Content-Type': 'application/json'
            }
		}).success(function(data){
			$(document).trigger('refreshCustomerTable');
			$(document).trigger('showAlertClienti',data);
		});
	}

	$scope.getIndexByValue = function(obj, valToFind, destination){
		var id = parseInt(valToFind);
		angular.forEach(obj,function(value, key){			
				switch(destination){
					case'nazione':
						var value = parseInt(value.id);
						if(value == id){
						$scope.nationSelected = $scope.nationsList[key];
						}
					break;
					case'prov':
						var value = parseInt(value.id_provincia);
						if( value == id){
							$scope.provinceSelected = $scope.provinceList[key];
						}
					break;
					case'comune':
						var value = parseInt(value.id_comune);
						if( value == id){
							$scope.comuneSelected = $scope.comuniList[key];
						}
					break
				}
			
		});
	}
}]);


gApp.controller('profilo',['$scope','$http','$alert', function($scope,$http,$alert){
	$scope.newUser = {
		"id":"",
		"first_name":"",
		"last_name":"",
		"phone":"",
		"username":"",
		"ragione_sociale":"",
		"password":""
	};

	angular.element(document).ready(function(){

		$scope.user = JSON.parse(JSON.stringify($scope.newUser));
		$scope.loadUserInfo();
	});

	$scope.loadUserInfo = function(){
		$http({
			method:'POST',
			url:'getUserInfo',
			headers:{
				'Content-Type':'application/json'
			}
		}).success(function(data){
			$scope.user = data[0];
		});
	}

	$scope.editProfile = function(){
		// $scope.userEdit = $scope.user;
		$scope.userEdit = JSON.parse(JSON.stringify($scope.user));
		showModal();
	}

	function showModal(){
		$('#userEditModal').modal('show');
	}

	function hideModal(){
		$('#userEditModal').modal('hide');
	}

	$scope.saveProfile = function(){
		console.log($scope.userEdit);
		$http({
			method:'POST',
			url:'saveProfile',
			data:$scope.userEdit,
		}).success(function(data){
			$scope.loadUserInfo();
			$scope.alertProfilo(data);
			hideModal();
		});
	}

	$scope.alertProfilo = function(data){
		if(data){
		var  obj = {
			title: data.title, 
			content: data.content + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' , 
			type: data.type,
			placement: 'bottom', 
			show: true,
			duration: 2,
			container:'#alertProfilo',
		};
		
		var pippo = $alert(obj);
		}
	}
}]);


// gApp.directive('ngUnique', ['$http', function (async) {
//   return {
//     require: 'ngModel',
//     link: function (scope, elem, attrs, ctrl) {
//       elem.on('blur', function (evt) {
//         scope.$apply(function () {
//           var val = elem.val();
//           var req = { "email":val, "dbField":attrs.ngUnique }
//           var ajaxConfiguration = { method: 'POST', url: 'email_check', data: req };
//           async(ajaxConfiguration)
//             .success(function(data, status, headers, config) {
//               ctrl.$setValidity('unique', data.status);
//             });
//           });
//         });
//       }
//     }
//   }
// ]);