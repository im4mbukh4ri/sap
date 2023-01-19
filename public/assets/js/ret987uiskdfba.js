$("#dep").show();
$("#ret").show();

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
function getDeparture(index,flightNumber,ac,etd,eta,totalFare) {



    var etd= new Date(etd);
    var eta= new Date(eta);

    var etdDate= etd.getDate();
    var etdMonth = myMonth[etd.getMonth()];
    var etdDay = myDay[etd.getDay()];
    var etdHour = etd.getHours();
    var etdMinute = etd.getMinutes();
    var etdDep = etdHour+":"+etdMinute+" "+etdDay.substring(0,3)+", "+etdDate+" "+etdMonth.substring(0,3);

    var etaDate= eta.getDate();
    var etaMonth = myMonth[eta.getMonth()];
    var etaDay = myDay[eta.getDay()];
    var etaHour = eta.getHours();
    var etaMinute = eta.getMinutes();
    var etaDep = etaHour+":"+etaMinute+" "+etaDay.substring(0,3)+", "+etaDate+" "+etaMonth.substring(0,3);


    $('#lblFlightNumberDep').html(flightNumber);
    $('#lblDepartureDep').html(etdDep);
    $('#lblArriveDep').html(etaDep);

    var totalFareDep=parseInt(totalFare);
    var totalFareRet=parseInt($('#totalFareRet').val());
    $('#totalFareDep').val(totalFare);
    $('#selectedIDdep').val(index);

    var refreshFare=totalFareDep+totalFareRet;

    $('#totalFareDepRet').html(addCommas(refreshFare));
    $('#acDep').val(ac);
    $('#dep').fadeOut("slow");

}
function getReturn(index,flightNumber,ac,etd,eta,totalFare) {

    var etd= new Date(etd);
    var eta= new Date(eta);

    var etdDate= etd.getDate();
    var etdMonth = myMonth[etd.getMonth()];
    var etdDay = myDay[etd.getDay()];
    var etdHour = etd.getHours();
    var etdMinute = etd.getMinutes();
    var etdDep = etdHour+":"+etdMinute+" "+etdDay.substring(0,3)+", "+etdDate+" "+etdMonth.substring(0,3);

    var etaDate= eta.getDate();
    var etaMonth = myMonth[eta.getMonth()];
    var etaDay = myDay[eta.getDay()];
    var etaHour = eta.getHours();
    var etaMinute = eta.getMinutes();
    var etaDep = etaHour+":"+etaMinute+" "+etaDay.substring(0,3)+", "+etaDate+" "+etaMonth.substring(0,3);


    $('#lblFlightNumberRet').html(flightNumber);
    $('#lblDepartureRet').html(etdDep);
    $('#lblArriveRet').html(etaDep);

    var totalFareDep=parseInt($('#totalFareDep').val());
    var totalFareRet=parseInt(totalFare);
    $('#totalFareRet').val(totalFare);
    $('#selectedIDRet').val(index);

    var refreshFare=totalFareDep+totalFareRet;

    $('#totalFareDepRet').html(addCommas(refreshFare));
    $('#acRep').val(ac);
    $('#ret').fadeOut("slow");

}
function showDep(){
    $('#dep').fadeIn("slow");
}
function showRet(){
    $('#ret').fadeIn("slow");
}
