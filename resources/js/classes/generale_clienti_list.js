$(document).ready(function listClienti() {
	var customerDataTable;
	loadCustormerTable();

	$('table.dataTable').css('font-size','14px');
	function renderSelectedCustomer(type, data, full){
		var checked = "";
        if (true === data) checked = "checked";
        return '<div class="checkbox"><input style="float:none;margin:-10px" id="checkbox-' + full.id + '" type="checkbox" class="customerSelected" ' + checked + '></div>';
	}

    function loadCustormerTable(){
		customerDataTable =	$('#dt_customer').dataTable({
			"aoColumns":[
			{
				"mData":"selected",
				"mRender":renderSelectedCustomer,
				"bSortable": false,
			},
			{
				"mData":"fist_name",
				'mRender':function(type, data, full){return full.ragione_sociale},
				"bSortable": true,
			},
			{
				"mData":"last_name",
				'mRender':function(type, data, full){return full.first_name}
			},
			{
				"mData":"email",
				'mRender':function(type, data, full){return full.last_name}
			},
			{
				"mData":"email",
				'mRender':function(type, data, full){return full.email}
			},
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
				$(document).trigger('onDatatableCustomerInitComplete');
			},
			"sAjaxSource":"listMyCustomer",
			"bJQueryUI":true
		});
		$('#checkbox-selectAllCustomers').prop("checked",false);
		$('#checkbox-selectAllCustomers').click(function(event) {
			var checked = this.checked;
			$('.customerSelected').each(function() {
				this.checked = checked;
				customerDataTable.fnGetData(this.parentNode.parentNode.parentNode).selected = this.checked;
				fireCustomerListChanged();
			});
		});
	}
	
	$(document).bind('onDatatableCustomerInitComplete', function(event) {
		bindOnClickCustomerEvent();
		bindCustomerSelectedCheckox();
		selectCustomerFirstRowIfPresent();
		fireCustomerListChanged();
	});

	$(document).bind('refreshCustomerTable',function(event){
		loadCustormerTable();
	});

	function selectCustomerRow($row){
		customerDataTable.$('tr.row_selected').removeClass('row_selected');
		if(!$row.hasClass('row_selected')) $row.addClass('row_selected');
		var customerObject = customerDataTable.fnGetData($row.get());
		if(undefined !== customerObject) $(document).trigger('onSingleCustomerSelected',customerObject);
		else $(document).trigger('onSinglecustomerSelected',null);
	}

	function bindCustomerSelectedCheckox(){
		$('.customerSelected').click(function(){
			customerDataTable.fnGetData(this.parentNode.parentNode.parentNode).selected = this.checked;
			fireCustomerListChanged();
			selectCustomerFirstRowIfPresent();
		});
	}

	function bindOnClickCustomerEvent(){
		$('#dt_customer tbody tr').click(function(e) {
			if($(this).hasClass('row_selected')){
				$(this).removeClass('row_selected');
			}else{
				selectCustomerRow($(this));
			}
		});
	}

	function fireCustomerListChanged(){
		var customerListWrapper = {};
		customerListWrapper.data = customerDataTable.fnGetData();
		$(document).trigger("onCustomerListChanged", customerListWrapper);
	}

	function selectCustomerFirstRowIfPresent() {
        var row = customerDataTable.find('tbody tr:first');
        if (undefined !== row) selectCustomerRow($(row));
    }

    function disableComuniProvince(){
    	$('#comune,#provincia').attr('disabled');
    }

    function enableComuniProvince(){
    	$('#comune,#provincia').removeAttr('disabled');
    }

    $(document).bind('showAlertClienti',function(event,data) {
    	if(data){
    		$('#alertResponseClienti').after(
    			'<div class="response alert alert-dismissable alert-'+data['status']+'" > '	+
    				'<button type="button" class="close" ' + 
                    	'data-dismiss="alert" aria-hidden="true">' + 
                		'&times;' + 
            			'</button>' + 
            			data['msg']	+
    			'</div>'
    		);
    		setTimeout(function(){
    			console.log('chiudi');
    			$('.response').alert('close');
    		},3000);
    	}
    });

});