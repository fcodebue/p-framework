var tTable = $('#dt_target').dataTable({
	"aoColumns": [
		{ bVisible: false },
		{'fnRender':function(oObj){return oObj.aData[1]}},
		{'fnRender':function(oObj){return oObj.aData[3]}},
		{'fnRender':function(oObj){return oObj.aData[5]}},
		{'fnRender':function(oObj){return oObj.aData[6]}},
		{'fnRender':function(oObj){return oObj.aData[7]}},
		{'fnRender':function(oObj){return oObj.aData[8]}},
		
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
	"sAjaxSource": "target_list",
	"bJQueryUI": true
})

var tTable = $('#dt_targetAddBandi').dataTable({
	"aoColumns": [
		{ bVisible: false },
		{'fnRender':function(oObj){return oObj.aData[1]}},
		{'fnRender':function(oObj){return oObj.aData[3]}},
		{'fnRender':function(oObj){return oObj.aData[5]}},
		{'fnRender':function(oObj){return oObj.aData[6]}},
		{'fnRender':function(oObj){return oObj.aData[7]}},
		{'fnRender':function(oObj){return oObj.aData[8]}},
		
	],
	"aaSorting": [[ 1, "asc" ]],
	"bInfo": false,
	"bLengthChange": false,
	"bProcessing": true,
	"bServerSide": true,
	"bFilter":false,
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
	"sAjaxSource": "target_list",
	"bJQueryUI": true
})
// $(document).ready(function() {
// 	updateRelazioniSelect();
// 	updateTipologiavaloriSelect();	
// });

$(document).on('click', 'button.add_target', function(event) {
	$('#myModalAddTarget').modal('show');
});

//add new modalità erogazin
$(document).on('click', '#myModalAddTarget button#submit_add', function(e) {
	e.preventDefault();
	
	// $('#myModalAddTarget select.relazioni.target').val(0);
	// $('#myModalAddTarget select.tipologiavalori.target').val(0);

	var testo = '';
	testo = $('input.add_text.target').val();
	var relazione = $('select.relazioni.target').val();
	var tipologiavalore = $('select.tipologiavalori.target').val();
	var valore1 = $('input.add_text.val1').val();
	var valore2 = $('input.add_text.val2').val();
	
	if(testo != "" && relazione != 0 && relazione != "null" && tipologiavalore != 0  && tipologiavalore != "null" && valore1 != "" && valore2 != ""  ){
		$.ajax({
			url: PLAB['baseUrl']+'c_bandi/target_exist',
			type: 'POST',
			dataType: 'json',
			data: {'target': testo},
		})
		.done(function(e) {
			console.log(e);
			if(e == false){
				$.ajax({
					url: PLAB['baseUrl']+'c_bandi/add_target',
					type: 'POST',
					data: {'target' : testo,
					'id_rel':relazione,
					'id_val':tipologiavalore,
					'val1':valore1,
					'val2':valore2 },
				})
				.done(function() {
					tTable.fnDraw(false);
					console.log("success");
					$('input.add_mod_erogazioni').val('');
					$('#myModalAddTarget').modal('hide');
				})
				.fail(function() {
					console.log("error");
				})
				.always(function() {
					console.log("complete");
				});
			}else{
				alert('target: '+testo+ ' already exist!')
				$('input.add_target').val('');
				console.log('target already exist');
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
	console.log(testo + " testo " + relazione + " relazione " + tipologiavalore + " tipovalore " + valore1 + " val1 " + valore2 + " valore2");
});

//click delteItem show modale delete
$(document).on('click', 'button.delete.target', function(e) {
	e.preventDefault();
	var id = $(this).attr('rel');
	var title = $(this).attr('title');
	console.log(title +" pressed delete "+id);
	$('#myModalDeleteTarget .modal-body.delete').html('eliminare <strong>'+ title +'</strong> ?');
	$('#myModalDeleteTarget #delete').attr('rel',id);
	$('#myModalDeleteTarget').modal('show');
 });


//delete click pulsante conferma
$(document).on('click','#myModalDeleteTarget #delete',function(e){
	var id = $(this).attr('rel');
	console.log('press ' + id);
	$.ajax({
		url: PLAB['baseUrl']+'c_bandi/delete_target',
		type: 'POST',
		data: {'id': id},
	})
	 .done(function() {
	 	tTable.fnDraw(false);
	});
	$('#myModalDeleteTarget').modal('hide');
});


$(document).on('shown.bs.modal','#myModalAddTarget',function(e){
	$('#myModalAddTarget input.add_text.target').focus();
	// $('#myModalAddTarget input.add_text.target').val('');
	updateRelazioniSelect();
	updateTipologiavaloriSelect();
	$('#myModalAddTarget input.add_text.target').val('');
	$('#myModalAddTarget input.add_text.val1').val('');
	$('#myModalAddTarget input.add_text.val2').val('');

});



//click editItem show modale delete
$(document).on('click', 'button.edit.target', function(e) {
	e.preventDefault();
	var id = $(this).attr('rel');
	var target = $(this).attr('title');
	// var val2 = ;
	var id_rel = $('#myModalEditTarget select.relazioni').attr('id_rel');
	var id_valore = $('#myModalEditTarget select.tipologiavalori').attr('id_valore');
	var val1 = $(this).attr('val1');
	var val2 = $(this).attr('val2');



	updateRelazioniSelect(id_rel);
	updateTipologiavaloriSelect(id_valore);
	$('select.relazioni').attr('id_rel', $(this).attr('id_rel'));
	$('select.tipologiavalori').attr('id_valore', $(this).attr('id_valore'));
	// console.log(target +" pressed edit "+id);
	
	$('#myModalEditTarget .edit_text.target').attr('rel',id);

	// $('#myModalEditTarget .edit_text').attr('placeholder', target+"");
	// // $('#myModalEditTarget .edit_text.val1').attr('placeholder', $(this).attr('val1'));
	// // $('#myModalEditTarget .edit_text.val2').attr('placeholder', $(this).attr('val2'));

	$('#myModalEditTarget input.edit_text.target').val(target);
	$('#myModalEditTarget input.edit_text.val1').val(val1);
	$('#myModalEditTarget input.edit_text.val2').val(val2);
	$('#myModalEditTarget').modal('show');
});

//set focus when modal is shown
$(document).on('shown.bs.modal','#myModalEditTarget',function(e){
	var id_rel = $('#myModalEditTarget select.relazioni').attr('id_rel');
	var id_valore = $('#myModalEditTarget select.tipologiavalori').attr('id_valore');
	updateRelazioniSelect(id_rel);
	updateTipologiavaloriSelect(id_valore);
	
	$('#myModalEditTarget select.tipologiavalori option[seleced]').remove();
	$('#myModalEditTarget select.tipologiavalori option').val(id_valore);

	$('#myModalEditTarget .edit_text.target').focus();
});

$(document).on('click','#myModalEditTarget button#submit_edit.submit',function(e){
	var id = $('#myModalEditTarget .edit_text').attr('rel');
	var testo = $('#myModalEditTarget .edit_text').val();
	var id_rel = $('#myModalEditTarget select.relazioni').val();
	var id_val = $('#myModalEditTarget select.tipologiavalori').val();
	var val1 = $('#myModalEditTarget input.edit_text.val1').val();
	var val2 = $('#myModalEditTarget input.edit_text.val2').val();
	console.log('id '+ id + ' target ' +testo+ ' id_rel '+ id_rel + ' id_val '+ id_val + ' val1' + val1 + ' val2 '+ val2);
	if(!testo == ""){
		$.ajax({
			url: PLAB['baseUrl']+'c_bandi/target_exist_edit',
			type: 'POST',
			dataType: 'json',
			data: {'target': testo, 'id':id},
		})
		.done(function(e) {
			console.log(e);
			if(e == false){
				$.ajax({
					url: PLAB['baseUrl']+'c_bandi/update_target',
					type: 'POST',
					data: { 'id' : id, 
					'target' : testo,
					'id_rel':id_rel,
					'id_val':id_val,
					'val1':val1,
					'val2':val2 },
				})
				.done(function() {
					tTable.fnDraw(false);
					console.log("success");
					$('#myModalEditTarget .edit_text').val('');
					$('#myModalEditTarget').modal('hide');
				})
				.fail(function() {
					console.log("error");
				})
				.always(function() {
					console.log("complete");
				});
			}else{
				alert('target: ' + testo + ' already exist!')
				$('#myModalEditTarget .edit_text').val('');
				console.log('target already exist');
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



// function fillRelazioni(){
// 	$.ajax({
// 		url: PLAB['baseUrl']+'c_bandi/read_relazioni',
// 		type: 'POST',
// 		dataType: 'json',
// 		data: {param1: 'value1'},
// 	})
// 	.done(function(e) {
// 		$.each(e, function(index, element) {
// 			console.log(element.id + " "+ element.relazione);
// 		});
		
		
// 	})
// 	.fail(function(e) {
// 		console.log("error " +e);
// 	})
// 	.always(function(e) {
// 		console.log("complete "+e);
// 	});
	
// }


$('.nota').on('click', function(e) {
	e.preventDefault();

	$("#dialog-message").attr('rel', $(this).attr('rel'));
	$("#dialog-message").dialog("open");
});
$(document).on('click', '#ncre', function() { location.href = CI.base_url + 'c_note/insert/ricavo/credito/' + $("#dialog-message").attr('rel'); });
$(document).on('click', '#ndeb', function() { location.href = CI.base_url + 'c_note/insert/ricavo/debito/' + $("#dialog-message").attr('rel'); });
