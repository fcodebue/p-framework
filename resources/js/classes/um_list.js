var uTable = $('#dt_um').dataTable({
	"aoColumns": [
		{ bVisible: false },
		null,
		null,
		{"bSortable":false},
		{'fnRender': function (oObj){
			var input = oObj.aData[4];
			if(input == "si"){
				input = "ON"
			}else if(input == "no"){
				input = "OFF";
			}
			return input;
		}},
		{"bAutoWidth":false},
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
	"sAjaxSource": "um_list",
	"bJQueryUI": true
})

//show add um modal
$(document).on('click', 'button.add_um', function(event) {
	$('#myModalAddUM').modal('show');
	$('#myModalAddUM input.add_um.descrizione').val('');
	$('#myModalAddUM input.add_um.sigla').val('');
	$('#myModalAddUM input.add_um.decimali').val('');
	$('#myModalAddUM input.add_um.minuti').val('');
});

//aggiungi unità di misura
$(document).on('click', '#myModalAddUM button#submit_add', function(e) {
	e.preventDefault();
	console.log('press');
	var testo = $('#myModalAddUM input.add_um.descrizione').val();
	var sigla = $('#myModalAddUM input.add_um.sigla').val();
	var decimali = $('select.decimali').val();
	var minuti = $('select.minuti').val();
	console.log(testo + " sigla_-->" + sigla + 'value '+ decimali + ' '+minuti );
	if(!testo == "" && !sigla == ""){
		$.ajax({
			url: PLAB['baseUrl']+'c_bandi/um_exist',
			type: 'POST',
			dataType: 'json',
			data: {'descrizione': testo},
		})
		.done(function(e) {
			console.log(e);
			if(e == false){
				$.ajax({
					url: PLAB['baseUrl']+'c_bandi/add_um',
					type: 'POST',
					data: {'descrizione' : testo, 'sigla':sigla,'minuti' : minuti, 'decimali':decimali },
				})
				.done(function() {
					uTable.fnDraw(false);
					$('input.add_um.descrizione').val('');
					$('input.add_um.sigla').val('');
					$('select.decimali option.def').attr('selected', 'selected');;
					$('select.minuti option.def').attr('selected', 'selected');;
					console.log("success");
					$('input.add_interventibandi').val('');
					$('#myModalAddUM').modal('hide');
				})
				.fail(function() {
					console.log("error");
				})
				.always(function() {
					console.log("complete");
				});
			}else{
				alert('intervento: '+testo+ ' already exist!')
				$('input.add_interventibandi').val('');
				console.log('intervento already exist');

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

//delete click show modal delete
$(document).on('click', 'button.delete.um', function(e) {
	e.preventDefault();
	var id = $(this).attr('rel');
	var title = $(this).attr('title');
	console.log(title +" pressed delete "+id);
	$('#myModalDeleteUM .modal-body.delete').html('eliminare <strong>'+ title +'</strong> ?');
	$('#myModalDeleteUM #delete').attr('rel',id);
	$('#myModalDeleteUM').modal('show');
 });

//delete click pulsante conferma delete
$(document).on('click','#myModalDeleteUM #delete',function(e){
	var id = $(this).attr('rel');
	console.log('press ' + id);
	$.ajax({
		url: PLAB['baseUrl']+'c_bandi/delete_um',
		type: 'POST',
		data: {'id': id},
	})
	 .done(function() {
	 	uTable.fnDraw(false);
	});
	$('#myModalDeleteUM').modal('hide');
});

$(document).on('shown.bs.modal','#myModalAddUM',function(e){
	$('#myModalAddUM input.add_um.descrizione').focus();
});

$(document).on('shown.bs.modal','#myModalEditUM',function(e){
	$('#myModalEditUM .input.descrizione').val('');	
});

$(document).on('hidden.bs.modal','#myModalAdd,#myModalEdit,#myModalDelete',function(e){
	$('div.modal .modal-header,div.modal .modal-body,div.modal .modal-footer').removeClass('um');
});



// edit
$(document).on('click', 'button.edit.um', function(e) {
	e.preventDefault();
	var id = $(this).attr('rel');
	var title = $(this).attr('title');
	var sigla = $(this).attr('sigla');
	var decimali = $(this).attr('decimali');
	var minuti = $(this).attr('minuti');
	
	$('#myModalEditUM input.descrizione').attr('rel',id);
	$('#myModalEditUM input.descrizione').val(title+"");
	$('#myModalEditUM input.sigla').attr('placeholder',sigla+"");
	$('#myModalEditUM #decimali').val(decimali);
	$('#myModalEditUM #minuti').val(minuti);

	$('#myModalEditUM').modal('show');
});



// $(document).on('click','#myModalEditInterventibandi .cancel',function(e){
// 	e.preventDefault()
// 	$('#myModalEditInterventibandi').modal('hide');
// });

//submit
$(document).on('click','#myModalEditUM #submit_edit',function(e){
	var id = $('#myModalEditUM input.descrizione').attr('rel');
	var testo = $('#myModalEditUM input.descrizione').val();
	var sigla = $('#myModalEditUM input.sigla').val();
	var decimali = $('#decimali').val();
	var minuti = $('#minuti').val();	

	console.log('id => '+id);
	console.log('descrizione => '+testo);
	console.log('sigla => '+sigla);
	console.log('decimali => '+decimali);
	console.log('minuti => '+minuti);

	if(!testo == ""){
		$.ajax({
			url: PLAB['baseUrl']+'c_bandi/um_exist',
			type: 'POST',
			dataType: 'json',
			data: {'descrizione': testo, 'id':id},
		})
		.done(function(e) {
			console.log(e);
			if(e == false){
				$.ajax({
					url: PLAB['baseUrl']+'c_bandi/update_um',
					type: 'POST',
					data: {'id': id, 'descrizione' : testo,'sigla':sigla,'decimali':decimali, 'minuti':minuti },
				})
				.done(function() {
					uTable.fnDraw(false);
					$('#myModalEditUM').modal('hide');
					console.log("success");
				})
				.fail(function() {
					console.log("error");
				})
				.always(function() {
					console.log("complete");
				});
			}else{
				alert('intervento: '+ testo + ' already exist!')
				// $('#myModalEditInterventibandi .edit_text').val('');
				console.log('unit&agrave di misura already exist');
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
			iTable.fnDraw(false);
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
