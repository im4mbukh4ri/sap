$(document).ready(function () {
	accordionFlight();
	dataFlight();
	// chooseSeat();
	tabsSeat();
	galleryDetail();
	dropdownMenu();
	tabsHome();

	$('#triggerSearch').click(function(){
		$('#box-search').slideToggle();
	});
    // $('.datepicker').datepicker({
    //     format: "dd-mm-yyyy",
    //     autoclose:true
    // });
    // $('.datepickerYear').datepicker({
    //     format: "dd-mm-yyyy",
    //     autoclose:true,
    //     changeMonth: true,
    //     changeYear: true,
    //     yearRange: "-100:+0"
    // });
     $('.selectSearch1').select2({
     	placeholder: "Pilih kota asal"
     });
    $('.selectSearch2').select2({
        placeholder: "Pilih kota tujuan"
    });
		$('.selectHotel').select2({
		 placeholder: "Pilih kota tujuan"
		});
     $(".hideSearch").select2({
	  minimumResultsForSearch: Infinity
	});

});

$(window).scroll(function(){
	//console.log($(window).scrollTop());

	if($(window).scrollTop()>=125){

		$('#chooseFlight').addClass('fixed');
        $('#testerHeight').css('display','block');

	}else{

		$('#chooseFlight').removeClass('fixed');
        $('#testerHeight').css('display','none');

	}

});
