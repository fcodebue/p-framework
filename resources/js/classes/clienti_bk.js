$(document).ready(function() {
	var oTable = $('#dt').dataTable({
		"aoColumns": [
			{ bVisible: false },
			null,
			null,
			null,
			null,
			null,
			null,
			{ "bSortable": false, "sWidth": "0", "sClass": "right" }
		],
		"aaSorting": [[ 4, "asc" ]],
		"bInfo": false,
		"bLengthChange": true,
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
		"sAjaxSource": "elenco_fatture_vendita_list",
		"bJQueryUI": true,
		"sPaginationType": "full_numbers",
		"oLanguage": {
			"sUrl": "../public/it_IT.txt"
		}
	})

	$('#add').live("click", function() {
		location.href = 'ricavi_livello1';
		return false;
	});

	$('a[title]').live('mouseover', function(event) {
		$(this).qtip({
			overwrite: false,
			position: {
				my: "bottom center",
				at: "top center",
				viewport: $('#dt'),
				adjust: {
					method: 'shift none'
				}
			},
			style: {
				classes: 'ui-tooltip-dark ui-tooltip-rounded ui-tooltip-shadow'
			},
			show: {
				event: event.type,
				ready: true
			}
		}, event);
	}).each(function(i) {
		$.attr(this, 'oldtitle', $.attr(this, 'title'));
		this.removeAttribute('title');
	});

	$('a.delete').live("click", function(e) {
		e.preventDefault();

		$("#dialog-confirm").attr('rel', $(this).attr('rel')).dialog('open');
	});

	$( "#dialog-confirm" ).dialog({
		autoOpen: false,
		resizable: false,
		height:200,
		modal: true,
		buttons: {
			"Cancella": function() {
				$.post(CI.base_url + 'c_vendite/delete', { id: $(this).attr('rel') });
				oTable.fnDraw(false);
				$( this ).dialog( "close" );
			},
			"Chiudi": function() {
				$( this ).dialog( "close" );
			}
		}
	});

	$("#dialog-message").dialog({
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

	$('.nota').live('click', function(e) {
		e.preventDefault();

		$("#dialog-message").attr('rel', $(this).attr('rel'));
		$("#dialog-message").dialog("open");
	});
	$('#ncre').live("click", function() { location.href = CI.base_url + 'c_note/insert/ricavo/credito/' + $("#dialog-message").attr('rel'); });
	$('#ndeb').live("click", function() { location.href = CI.base_url + 'c_note/insert/ricavo/debito/' + $("#dialog-message").attr('rel'); });
});