$(document).ready(function() {
	$('.datepicker').datepicker();
});

$(document).ready(function() {
  $('.numericField').keyup(function(event){
		if (isNaN( $(this).val() )) {
			alert("Please Enter Only Number");
			$(this).val("");
		}
	});
});

