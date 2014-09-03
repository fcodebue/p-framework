var spinner = new Spinner();
var target = document.getElementById("user-spinner");
spinner.spinStart = function() {
    spinner.spin(target);
};
spinner.spinEnd = function() {
    spinner.stop(target);
};
$(document).ready(function list() {
	var userDataTable;
	loadTable();
	
	// USER

	$('table.dataTable').css('font-size','14px');
	function get_formapp(type, data, full){
		
		return full.id;
	}

	function renderSelected(type, data, full){
		var checked = "";
        if (true === data) checked = "checked";
        return '<div class="checkbox"><input style="float:none;margin:-10px" id="checkbox-' + full.id + '" type="checkbox" class="userSelected" ' + checked + '></div>';
	}

	function displayName(type, data, full){
		return full.name;
	}

	function loadTable(){
		userDataTable =	$('#dt_utente').dataTable({
			"aoColumns":[
			{
				"mData":"selected",
				"mRender":renderSelected,
				"bSortable": false,
			},
			{
				"mData":"fist_name",
				'mRender':function(type, data, full){return full.first_name},
				"bSortable": true,
			},
			{
				"mData":"last_name",
				'mRender':function(type, data, full){return full.last_name}
			},
			{
				"mData":"email",
				'mRender':function(type, data, full){return full.email}
			},
			{
				"mData":"company",
				'mRender':function(type, data, full){return full.ragione_sociale}
			}
			// {
			// 	"mData":"formapp",
			// 	"mRender":get_formapp
			// }
			],
			"bPaginate":false,
			"bFilter":true,
			"iDisplayLength": 5,
			// "bScrollCollapse": true,
			// "sScrollY": "300px",
			"bInfo":false,
			"bDestroy":true,
			"aaSorting": [
                [0, "asc"]
            ],
			"fnServerData":function (sSource, aoData,fnCallback){
				$.ajax({
					"url": sSource,
					"type": 'POST',
					"dataType": 'json',
					"data": aoData,
					"success":fnCallback
				});
			},
			"fnInitComplete":function(){
				$(document).trigger('onDatatableInitComplete');
			},
			"sAjaxSource":"listMyUser",
			"bJQueryUI":true
		});
		$('#checkbox-selectAllUsers').prop("checked",false);
		$('#checkbox-selectAllUsers').click(function(event) {
			var checked = this.checked;	
			$('.userSelected').each(function() {
				this.checked = checked;
				userDataTable.fnGetData(this.parentNode.parentNode.parentNode).selected = this.checked;
				fireUserListChanged();
			});
		});
	}

	function fireUserListChanged(){
		var userListWrapper = {};
		userListWrapper.data = userDataTable.fnGetData();
		$(document).trigger("onUserListChanged", userListWrapper);	
	}

	$(document).bind('onDatatableInitComplete',function(event) {
		bindOnClickEvent();
		bindUserSelectedCheckox();
		selectFirstRowIfPresent();
	});

	$(document).bind('onUserSaved', function(event) {
		loadTable();
	});

	function bindUserSelectedCheckox(){
		$('.userSelected').click(function(){
			userDataTable.fnGetData(this.parentNode.parentNode.parentNode).selected = this.checked;
			fireUserListChanged();
		});
	}

	function selectRow($row){
		userDataTable.$('tr.row_selected').removeClass('row_selected');
		if(!$row.hasClass('row_selected')) $row.addClass('row_selected');
		var userObject = userDataTable.fnGetData($row.get());
		if(undefined !== userObject) $(document).trigger('onSingleUserSelected',userObject);
		else $(document).trigger('onSingleUserSelected',null);
	}

	function bindOnClickEvent(){
		$('#dt_utente tbody tr').click(function(e) {
			if($(this).hasClass('row_selected')){
				$(this).removeClass('row_selected');
			}else{
				selectRow($(this));
			}
		});
	}

	function selectFirstRowIfPresent() {
        var row = userDataTable.find('tbody tr:first');
        if (undefined !== row) selectRow($(row));
    }

    $(document).bind('showAlertUtenti',function(event,data) {
    	if(data){
    		$('#alertResponseUtenti').after(
    			'<div class="response alert alert-dismissable alert-'+data['status']+'" > '	+
    				'<button type="button" class="close" ' + 
                    	'data-dismiss="alert" aria-hidden="true">' + 
                		'&times;' + 
            			'</button>' + 
            			data['msg']	+
    			'</div>'
    		);
    		setTimeout(function(){
    			$('.response').alert('close');
    		},3000);
    	}
    });

});