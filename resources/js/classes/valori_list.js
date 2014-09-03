var vTable = $('#dt_valori').dataTable({
	"aoColumns": [
		{ bVisible: false },
		null,
		null,
	],
	"aaSorting": [[ 1, "asc" ]],
	"bInfo": false,
	"bLengthChange": false,
	"bProcessing": true,
	"bServerSide": true,
	"fnServerData": function ( sSource, aoData, fnCallback ) {
		$.ajax( {
			"dataType": 'json',
			"type": "POST",
			"url": sSource,
			"data": aoData,
			"success": fnCallback
		} );
	},
	"fnInitComplete": function(){
		$('.dataTables_wrapper, table.display').css('visibility', 'visible');
	},
	"sAjaxSource": "valori_list",
	"bJQueryUI": true
})

//show add_tipologiavalori modal
$(document).on('click', 'button.add_valori', function() {
	addSimple('Aggiungi Valore','valori','valore');
	
});

//add new tipologiavalori
$(document).on('click', 'button#add.valori', function(e) {
	e.preventDefault();
	var testo = '';
	testo = $('#myModalAdd input.valori').val();
	if(!testo == ""){
		$.ajax({
			url: PLAB['baseUrl']+'c_bandi/valori_exist',
			type: 'POST',
			dataType: 'json',
			data: {'valore': testo},
		})
		.done(function(e) {
			console.log(e);
			if(e == false){
				$.ajax({
					url: PLAB['baseUrl']+'c_bandi/add_valori',
					type: 'POST',
					data: {'valore' : testo },
				})
				.done(function() {
					vTable.fnDraw(false);
					console.log("success");
					$('input.add_valori').val('');
					$('#myModalAdd').modal('hide');
				})
				.fail(function() {
					console.log("error");
				})
				.always(function() {
					console.log("complete");
				});
			}else{
				alert('valore: '+testo+ ' already exist!')
				$('#myModalAdd input.edit_text.valori').val('');
				console.log('tipologiafondo already exist');
			}
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
	}else{
		console.log('nullo');
	}
	console.log(testo + " testo");
});

//click delteItem show modale delete
$(document).on('click', 'button.delete.valori', function(e) {
	var id = $(this).attr('rel');
	var title = $(this).attr('title');
	deleteSimple(id,title,'valori');
 });



//delete click pulsante conferma
$(document).on('click','#myModalDelete #delete.valori',function(e){
	var id = $(this).attr('rel');
	console.log('press ' + id);
	$.ajax({
		url: PLAB['baseUrl']+'c_bandi/delete_valori',
		type: 'POST',
		data: {'id': id},
	})
	 .done(function() {
	 	vTable.fnDraw(false);
	});
	$('#myModalDelete').modal('hide');
});


//click editItem show modale delete
$(document).on('click', 'button.edit.valori', function(e) {
	e.preventDefault();
	var id = $(this).attr('rel');
	var title = $(this).attr('title');
	updateSimple(id,title,'valori');
});

//set focus when modal is shown
$(document).on('shown.bs.modal','#myModalEdit',function(e){
	$('#myModalEdit .edit_text').focus();
	$('#myModalEdit .edit_text').val('');	
});

$(document).on('click','#myModalEdit #edit',function(e){
	var id = $('#myModalEdit .edit_text').attr('rel');
	var testo = $('#myModalEdit .edit_text').val();
	console.log(id + ' ' +testo);
	if(!testo == ""){
		$.ajax({
			url: PLAB['baseUrl']+'c_bandi/valori_exist',
			type: 'POST',
			dataType: 'json',
			data: {'valore': testo},
		})
		.done(function(e) {
			console.log(e);
			if(e == false){
				$.ajax({
					url: PLAB['baseUrl']+'c_bandi/update_valori',
					type: 'POST',
					data: {'id' : id , 'valore' : testo },
				})
				.done(function() {
					vTable.fnDraw(false);
					console.log("success");
					$('#myModalEditValori .edit_text').val('');
					$('#myModalEditValori').modal('hide');
				})
				.fail(function() {
					console.log("error");
				})
				.always(function() {
					console.log("complete");
				});
			}else{
				alert('valore: ' + testo + ' already exist!')
				$('#myModalEditValori .edit_text').val('');
			}
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
	}else{
		console.log('nullo');
	}
});

$(document).on('hidden.bs.modal','#myModalAdd,#myModalEdit,#myModalDelete',function(e){
	$('div.modal .modal-header,div.modal .modal-body,div.modal .modal-footer').removeClass('valori');
});

// $(document).on('click', '.cancel', function(e) {
// 	$('#myModalEdit').modal('hide');
// }
/*
$( "#dialog-confirm" ).dialog({
	autoOpen: false,
	resizable: false,
	height:200,
	modal: true,
	buttons: {
		"Cancella": function() {
			$.post(CI.base_url + 'c_vendite/delete', { id: $(this).attr('rel') });
			eTable.fnDraw(false);
			$( this ).dialog( "close" );
		},
		"Chiudi": function() {
			$( this ).dialog( "close" );
		}
	}
});

$("#dialog-message").modal({
	autoOpen: false,
	modal: true,
	width: 'auto',
	buttons: {
		"Chiudi": function() {
			$( this ).dialog( "close" );
		}
	},
	open: function(){
		$("#dialog-message input").blur();
	}
});
*/
$('.nota').on('click', function(e) {
	e.preventDefault();

	$("#dialog-message").attr('rel', $(this).attr('rel'));
	$("#dialog-message").dialog("open");
});
$(document).on('click', '#ncre', function() { location.href = CI.base_url + 'c_note/insert/ricavo/credito/' + $("#dialog-message").attr('rel'); });
$(document).on('click', '#ndeb', function() { location.href = CI.base_url + 'c_note/insert/ricavo/debito/' + $("#dialog-message").attr('rel'); });
