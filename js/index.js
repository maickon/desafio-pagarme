$('#submit_btn').prop("disabled", true);
// checkboxs_status();
function checkboxs_status(){
	var checked = 0;
	var checkbox_id = 0;

	for (var i = 0; i <= 3; i++) {
		if ($('#checkbox_' + i).is(":checked")) {
			checked += 1;
			checkbox_id = i;
		}
	}
	if (checked >= 3) {
		$('#checkbox_' + checkbox_id).prop("checked", false);
	} 
	if (checked == 2){
		$('#submit_btn').prop("disabled", false);
	}
	if (checked == 1 || checked == 0){
		$('#submit_btn').prop("disabled", true);
	}
}