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

function refresh_all(){

	var datetype=$('input[name=datetype]:checked').val();
	var start=$('#hiddenstart').val();
	var end=$('#hiddenend').val();
	var s_location=$('#s_location').val();
	var s_type=$('#s_type').val();
	var s_name=$('#s_name').val();
    window.location.href = encodeURI(document.URL + "?startDate="+start+"&endDate="+end+"&type="+datetype+"&s_location="+s_location+"&s_type="+s_type+"&s_name="+s_name);

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

function hasValue(elem) {

	return $(elem).filter(function() { return $(this).val(); }).length > 0;

}

jQuery('#downtimeform').submit(function(e){

    e.preventDefault();

    var StartDate= $("#startd").val();
    var EndDate= $("#endd").val();

    if( StartDate.trim() == '' ) {
        alert('Start date is required');
        return false;
    }

    if( EndDate.trim() == '' ) {
        alert('End date is required');
        return false;
    }

    this.submit();

});

var ComponentsNoUiSliders = function () {

    return {

        init: function () {
          
            // slider 2
            $('#slider_2').noUiSlider({
                direction: (Metronic.isRTL() ? "rtl" : "ltr"),
                range: {
                    min: 0,
                    max: 100
                },
                start: [0, 100],
                handles: 2,
                connect: true,
                step: 1,
                serialization: {
                    lower: [
                        $.Link({
                            target: $("#slider_2_input_start"),
                            method: "val"
                        })
                    ],
                    upper: [
                        $.Link({
                            target: $("#slider_2_input_end"),
                            method: "val"
                        })
                    ]
                }

            });

            $('#slider_2').on('slide', function(){

                $("#slider_2_input_startxx").val(parseInt($("#slider_2_input_start").val())+' %');
                $("#slider_2_input_endxx").val(parseInt($("#slider_2_input_end").val())+' %');
                var st=parseInt($("#slider_2_input_start").val());
                var en=parseInt($("#slider_2_input_end").val());                                
                $( ".tdtab" ).each(function() {
                  var x= $('span', this).text();

                  if(x<=st){
                    $(this).css("background-color", "#D91E18");
                  }
                  if(x>=en){
                    $(this).css("background-color", "#008000");
                  }
                  if(x>=st && x<=en && x != 100){
                    $(this).css("background-color", "#FF4500");
                  }
                  
                });
            });

        }

    };

}();