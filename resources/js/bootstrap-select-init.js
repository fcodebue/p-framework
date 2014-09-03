$(document).ready(function() {
	$('.selectpicker').selectpicker();	

	$('#myDatepicker').datepicker('getDate', { unix: true });
});
