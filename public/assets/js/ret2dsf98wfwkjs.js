$("#depSelected").hide();
$("#retSelected").hide();
$("#wrap").hide();
$("#departure").show();
$("#return").show();

var myDay=["Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu"];
var myMonth=["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
function addCommas(nStr)
{
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}
function addZero(i) {
    if (i < 10) {
        i = "0" + i;
    }
    return i;
}
function getDeparture(img,result,index,flightNumber,ac,etd,eta,totalFare,time,stop,origin,destination) {



    var etd= new Date(etd);
    var eta= new Date(eta);

    var etdDate= etd.getDate();
    var etdMonth = myMonth[etd.getMonth()];
    var etdDay = myDay[etd.getDay()];
    var etdHour = etd.getHours();
    var etdMinute = addZero(etd.getMinutes());
    var etdDep = etdHour+":"+etdMinute+" "+etdDay.substring(0,3)+", "+etdDate+" "+etdMonth.substring(0,3);
    var dateDep= etdDay.substring(0,3)+", "+etdDate+" "+etdMonth.substring(0,3);

    var etaDate= eta.getDate();
    var etaMonth = myMonth[eta.getMonth()];
    var etaDay = myDay[eta.getDay()];
    var etaHour = eta.getHours();
    var etaMinute = addZero(eta.getMinutes());
    var etaDep = etaHour+":"+etaMinute+" "+etaDay.substring(0,3)+", "+etaDate+" "+etaMonth.substring(0,3);


    //console.log(img);

    $("#imgDep").attr("src", img);
    $("#imgDepFinal").attr("src", img);
    $('#lblFlightNumberDep').html(flightNumber);
    $('#lblDepartureDep').html(etdDep);
    $('#lblArriveDep').html(etaDep);
    $('#lblDateDep').html(dateDep);
    $('#fareDep').html(addCommas(totalFare));
    $('#timeDep').html(time);
    $('#stopDep').html(stop);
    $('#orgDep').html(origin);
    $('#desDep').html(destination);

    $('#lblFlightNumberDepFinal').html(flightNumber);
    $('#lblDepartureDepFinal').html(etdDep);
    $('#lblArriveDepFinal').html(etaDep);
    $('#lblDateDepFinal').html(dateDep);
    $('#lblorgDepFinal').html(origin);
    $('#desDepFinal').html(destination);


    var totalFareDep=parseInt(totalFare);
    var totalFareRet=parseInt($('#totalFareRet').val());
    $('#totalFareDep').val(totalFare);
    $('#selectedIDdep').val(index);

    var refreshFare=totalFareDep+totalFareRet;

    $('#totalFareDepRet').html(addCommas(refreshFare));
    $('#acDep').val(ac);
    $('#resultDep').val(result);
    $('#departure').fadeOut("slow");
    $('#depSelectedValue').val('1');
    $('#resultDep').val(result)
    if($('#retSelectedValue').val()=='0'){
        $('#depSelected').fadeIn("slow");
    }else{
        $('#retSelected').hide();
        $("#wrap").fadeIn("show");
    }
}
function getReturn(img,result,index,flightNumber,ac,etd,eta,totalFare,time,stop,origin,destination) {

    var etd= new Date(etd);
    var eta= new Date(eta);

    var etdDate= etd.getDate();
    var etdMonth = myMonth[etd.getMonth()];
    var etdDay = myDay[etd.getDay()];
    var etdHour = etd.getHours();
    var etdMinute = addZero(etd.getMinutes());
    var etdDep = etdHour+":"+etdMinute+" "+etdDay.substring(0,3)+", "+etdDate+" "+etdMonth.substring(0,3);
    var dateDep= etdDay.substring(0,3)+", "+etdDate+" "+etdMonth.substring(0,3);

    var etaDate= eta.getDate();
    var etaMonth = myMonth[eta.getMonth()];
    var etaDay = myDay[eta.getDay()];
    var etaHour = eta.getHours();
    var etaMinute = addZero(eta.getMinutes());
    var etaDep = etaHour+":"+etaMinute+" "+etaDay.substring(0,3)+", "+etaDate+" "+etaMonth.substring(0,3);


    //console.log(img);

    $("#imgRet").attr("src", img);
    $("#imgRetFinal").attr("src", img);
    $('#lblFlightNumberRet').html(flightNumber);
    $('#lblDepartureRet').html(etdDep);
    $('#lblArriveRet').html(etaDep);
    $('#lblDateRet').html(dateDep);
    $('#fareRet').html(addCommas(totalFare));
    $('#timeRet').html(time);
    $('#stopRet').html(stop);
    $('#orgRet').html(origin);
    $('#desRet').html(destination);

    $('#lblFlightNumberRetFinal').html(flightNumber);
    $('#lblDepartureRetFinal').html(etdDep);
    $('#lblArriveRetFinal').html(etaDep);
    $('#lblDateRetFinal').html(dateDep);
    $('#lblorgRetFinal').html(origin);
    $('#desRetFinal').html(destination);


    var totalFareDep=parseInt($('#totalFareDep').val());
    var totalFareRet=parseInt(totalFare);
    $('#totalFareRet').val(totalFare);
    $('#selectedIDret').val(index);

    var refreshFare=totalFareDep+totalFareRet;

    $('#totalFareDepRet').html(addCommas(refreshFare));
    $('#acRet').val(ac);
    $('#return').fadeOut("slow");
    $('#retSelectedValue').val('1');
    $('#resultRet').val(result)
    if($('#depSelectedValue').val()=='0'){
        $('#retSelected').fadeIn("slow");
    }else{
        $('#depSelected').hide();
        $("#wrap").fadeIn("show");
    }

    // if($('#depSelectedValue').val()=='0'){
    //     $('#retSelected').fadeIn("slow");
    // }

}
function showDep(){
    $('#departure').fadeIn("slow");
}
function showRet(){
    $('#return').fadeIn("slow");
}