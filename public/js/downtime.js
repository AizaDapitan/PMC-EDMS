function refresh_all(){

	var start=$('#hiddenstart').val();
	var end=$('#hiddenend').val();
	var s_location=$('#s_location').val();
	var s_type=$('#s_type').val();
	var s_name=$('#s_name').val();

	var append_url = "";

	if( typeof s_location !== 'undefined' ) {
		append_url += "&s_location="+s_location;
	}

	if( typeof s_name !== 'undefined' ) {
		append_url += "&s_name="+s_name;
	}

	if( typeof s_type !== 'undefined' ) {
		append_url += "&s_type="+s_type;
	}

    window.location.href = encodeURI("/downtime-list?startDate="+start+"&endDate="+end+append_url);

}