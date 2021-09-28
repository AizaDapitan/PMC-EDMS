function changefilters() {

    var loc     = $('#s_location').val();
    var type    = $('#s_type').val();
    var name    = $('#s_name').val() ; 

    $("#s_name option").remove();
    var option = "<option value='' disabled selected> - Unit - </option>";

    var result = $.map(unitss , function(val, key){
        
        if( loc != null && type != null ) {
            if( val.location == loc && val.type == type ) {
                return val;
            } 
        } else if( loc != null && type == null ) {
            if( val.location == loc ) {
                return val;
            }
        } else if( loc == null && type != null ) {
            if( val.type == type ) {
                return val;
            }
        } else {
            return val;
        }

    });

    $.map(result, function(val) {
        option += "<option val='"+val.name+"'>"+val.name+"</option>";
    });

    $("#s_name").append(option);

}

function checkinput(){

	var StartDate= $("#startd").val();
	var EndDate= $("#endd").val();
	var eDate = new Date(EndDate);
	var sDate = new Date(StartDate);

	if(sDate> eDate) {

		alert("Please ensure that the End Date is greater than the Start Date.");
		$("#endd").val('');
		return false;

	}

}


function refresh_all(){

	var datetype=$('input[name=datetype]:checked').val();
	var start=$('#hiddenstart').val();
	var end=$('#hiddenend').val();
	var s_location=$('#s_location').val();
	var s_type=$('#s_type').val();
	var s_name=$('#s_name').val();
	var append_url = "";

	console.log(s_location);

	if( s_location != null && typeof s_location !== 'undifined') {
		console.log('wew');
		append_url += "&s_location="+s_location;
	}

	if( s_name != null && typeof s_name !== 'undifined') {
		append_url += "&s_name="+s_name;
	}

	if( s_type != null && typeof s_type !== 'undifined') {
		append_url += "&s_type="+s_type;
	}

   	window.location.href = encodeURI(document.URL +"/?startDate="+start+"&endDate="+end+"&type="+datetype+append_url);

}

