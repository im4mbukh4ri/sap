
function accordionFlight(){
	$(".row-rincian-berangkat").click(function (e) {
			if (!$(this).is('.actived')) {
				$(".row-rincian-berangkatn").removeClass('actived');
				$(".row-rincian-berangkat").removeClass('selected');
				$(".row-rincian-berangkat").find('.items-detail:visible').slideUp("slow");
				$(this).addClass('actived');
				$(this).addClass('selected');
				$(this).find('.items-detail ').slideDown("slow");
				$(this).find('.items-detail ').addClass("actived");
			} else {
				$(this).removeClass('actived');
				$(this).find('.items-detail').slideUp("slow");
			}
		});

	$(".row-rincian-pulang").click(function (e) {
			if (!$(this).is('.actived')) {
				$(".row-rincian-pulang").removeClass('actived');
				$(".row-rincian-pulang").removeClass('selected');
				$(".row-rincian-pulang").find('.items-detail:visible').slideUp("slow");
				$(this).addClass('actived');
				$(this).addClass('selected');
				$(this).find('.items-detail ').slideDown("slow");
				$(this).find('.items-detail ').addClass("actived");
			} else {
				$(this).removeClass('actived');
				$(this).find('.items-detail').slideUp("slow");
			}
		});
};

function selectFlight(){
	$(".label-circle").click(function (e) {
		if (!$(this).is('.activated')) {
				$(".label-circle").removeClass('activated');
				$(this).addClass('activated');
			} else {
				$(this).removeClass('activated');
			}
	});
};

function dataFlight(){
	$('.row-rincian-berangkat').click(function(e){
		console.log('test');

		var timeFrom = $(this).find( ".timeFrom" ).text();
		var timeFin = $(this).find( ".timeFin" ).text();
		var codeFrom = $(this).find( ".codeFrom" ).text();
		var logoFlight = $(this).find(".logoFlight-from").attr('src');

		$( ".result-berangkat .timeFrom-top" ).html( timeFrom );
		$( ".result-berangkat .timeFin-top" ).html( timeFin );
		$( ".result-berangkat .codeFrom-top" ).html( codeFrom );
		$(".result-berangkat .logoFlightFrom-top").attr("src", logoFlight);
	});

	$('.row-rincian-pulang').click(function(e){
		console.log('test');

		var timeFrom = $(this).find( ".timeFrom" ).text();
		var timeFin = $(this).find( ".timeFin" ).text();
		var codeFrom = $(this).find( ".codeFrom" ).text();
		var logoFlight = $(this).find(".logoFlight-from").attr('src');

		$( ".result-pulang .timeFrom-top" ).html( timeFrom );
		$( ".result-pulang .timeFin-top" ).html( timeFin );
		$( ".result-pulang .codeFrom-top" ).html( codeFrom );
		$(".result-pulang .logoFlightFrom-top").attr("src", logoFlight);
	});
};

$.fn.generate_height = function () {
  var maxHeight = -1;
  $(this).each(function () {
    $(this).children().each(function () {
      maxHeight = maxHeight > $(this).height() ? maxHeight : $(this).height();
    });

    $(this).children().each(function () {
      $(this).height(maxHeight);
    });
  })

}
function tabsSeat(){
	$('.tabs-a').click(function(event){
		 event.preventDefault()
		var tabsID = $(this).attr('href');
		console.log(tabsID);
		$('.tabs-a').removeClass('active');
		$(this).addClass('active');
		$('.seat-pergi').addClass('hide');
		$(tabsID).removeClass('hide');
	});

	$('.tabs-b').click(function(event){
		 event.preventDefault()
		var tabsID = $(this).attr('href');
		console.log(tabsID);
		$('.tabs-b').removeClass('active');
		$(this).addClass('active');
		$('.seat-kembali').addClass('hide');
		$(tabsID).removeClass('hide');
	});
}


function galleryDetail() {
    var b = $(".slidegal").bxSlider({
        mode: "horizontal",
        auto: false,
        controls: false,
        pager: true,
        pagerCustom: ".pager-album",
        speed: 1100,
        infiniteLoop: false
    });
    var a = $(".pager-album").bxSlider({
        minSlides: 1,
        maxSlides: 10,
        slideWidth: 60,
        slideMargin: 10,
        moveSlides: 1,
        auto: false,
        pager: false,
        infiniteLoop: false
    });
    $(".pager-album li").on("click", "a", function(c) {
        c.preventDefault();
        b.stopAuto();
        b.goToSlide($(this).attr("data-slideIndex"))
    })
}
function dropdownMenu(){
	$('.navbar a.dropdown-toggle').on('click', function(e) {
        var $el = $(this);
        var $parent = $(this).offsetParent(".dropdown-menu");
        $(this).parent("li").toggleClass('open');

        if(!$parent.parent().hasClass('nav')) {
            $el.next().css({"top": $el[0].offsetTop, "left": $parent.outerWidth() - 4});
        }

        $('.nav li.open').not($(this).parents("li")).removeClass("open");

        return false;
    });
}
function tabsHome(){
	$('.tabs-home-a').click(function(event){
		event.preventDefault();
		var tabsRef = $(this).attr('href');
        if(tabsRef=='#boxPesawat'){
            $('#mitraMaskapai').show();
						$('#mitraKai').hide();
						$('#mitraRailink').hide();
            $('#mitraPulsa').hide();
            $('#mitraPpob').hide();
        }else if(tabsRef=='#boxKereta'){
					$('#mitraMaskapai').hide();
					$('#mitraKai').show();
					$('#mitraRailink').hide();
					$('#mitraPulsa').hide();
					$('#mitraPpob').hide();
				}else if(tabsRef=='#boxRailink'){
					$('#mitraMaskapai').hide();
					$('#mitraKai').hide();
					$('#mitraRailink').show();
					$('#mitraPulsa').hide();
					$('#mitraPpob').hide();
				}else if(tabsRef=='#boxPulsa'){
            $('#mitraMaskapai').hide();
						$('#mitraKai').hide();
						$('#mitraRailink').hide();
            $('#mitraPulsa').show();
            $('#mitraPpob').hide();
        }else{
            $('#mitraMaskapai').hide();
						$('#mitraKai').hide();
						$('#mitraRailink').hide();
            $('#mitraPulsa').hide();
            $('#mitraPpob').show();
        }
		$('.tabs-home-a').removeClass('active');
		$(this).addClass('active');
		$('.box-content-tabs-home').addClass('hide');
		$(tabsRef).removeClass('hide');

    });
    $('.next-tab').click(function(){
        var str = $( ".tabs-home-a.active" ).parent('li').next('li').find('a').text();
        var strLast = $( ".tabs-home-a.active" ).parent('li').find('a').text();
        $('#menu-tabs-desktop li .active').parent('li').next('li').find('a').trigger('click');
        if($('#menu-tabs-desktop li .active').parent('li').next('li').length > 0){
            $('.next-tab').removeClass('disabled');
            $('.prev-tab').removeClass('disabled');
            $( ".title-tabs" ).html( str );
            console.log('di next if str : strnya = '+str+' strLastnya='+strLast);
        }else{
            $('.next-tab').addClass('disabled');
            $( ".title-tabs" ).html( str );
            console.log('di next else str : strnya = '+str+' strLastnya='+strLast);
            //console.log('ga ada');
        }
    });
    $('.prev-tab').click(function(){
        var str2 = $( ".tabs-home-a.active" ).parent('li').prev('li').find('a').text();
        var strLast2 = $( ".tabs-home-a.active" ).parent('li').find('a').text();
        $('#menu-tabs-desktop li .active').parent('li').prev('li').find('a').trigger('click');
        if($('#menu-tabs-desktop li .active').parent('li').prev('li').length > 0){
            $('.prev-tab').removeClass('disabled');
            $('.next-tab').removeClass('disabled');
            console.log('di prev if str : strnya = '+str2+' strLastnya='+strLast2);
            $( ".title-tabs" ).html( str2 );
        }else{
            $('.prev-tab').addClass('disabled');
            $( ".title-tabs" ).html( str2 );
            console.log('di prev else str : strnya = '+str2+' strLastnya='+strLast2);
            //console.log('ga ada');
        }
    });

}
