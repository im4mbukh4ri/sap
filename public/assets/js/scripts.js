$(window).load(function(){
	$('.content').css('padding-top',($(window).height()-$('.content').height())/2+'px')
	$('.form-input>input').width($('.form-input').width()-$('.form-input>input').css('padding-left').split('px')[0]-$('.form-input>input').css('padding-right').split('px')[0])
})