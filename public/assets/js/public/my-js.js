$(document).ready(function () {
    /*
    My Datepicker setting
     */
     var MyDate=new Date();
     var tomorrow = MyDate.getDate()+1;
     MyDate.setDate(tomorrow);

    if(typeof oldDepartureDate != 'undefined'){
        $("#departure_date").datepicker({
            // todayHighlight:1,
            // todayBtn:  1,
            // autoclose: true,
            // startDate:'0d',
            onSelect: function(date) {
                $( "#return_date" ).datepicker( "option","minDate",date);
                $( "#return_date" ).datepicker( "setDate",date);
            },
            minDate: new Date(),
            dateFormat:'dd-mm-yy'

        });
        $("#departure_date").datepicker("setDate",oldDepartureDate);
        $( "#return_date" ).datepicker({
            minDate: oldDepartureDate,
            dateFormat:'dd-mm-yy'
        });
        $( "#return_date" ).datepicker( "setDate", oldDepartureDate );
        if(window.request.flight=='R'){
            $("#return_date").datepicker("setDate",oldReturnDate);
        }
    }else{
        $("#departure_date").datepicker({
            // todayHighlight:1,
            // todayBtn:  1,
            // autoclose: true,
            // startDate:'0d',
            onSelect: function(date) {
                $( "#return_date" ).datepicker( "option","minDate",date);
                $( "#return_date" ).datepicker( "setDate",date);
            },
            minDate: new Date(),
            dateFormat:'dd-mm-yy'

        });
        $( "#departure_date" ).datepicker( "setDate", new Date() );
        $( "#return_date" ).datepicker({
            minDate: new Date(),
            dateFormat:'dd-mm-yy'
        });
        $( "#return_date" ).datepicker( "setDate", new Date() );

    }
    if(typeof oldTrainDepartureDate != 'undefined'){
        $("#train_departure_date").datepicker({
            // todayHighlight:1,
            // todayBtn:  1,
            // autoclose: true,
            // startDate:'0d',
            onSelect: function(date) {
                $( "#train_return_date" ).datepicker( "option","minDate",date);
                $( "#train_return_date" ).datepicker( "setDate",date);
            },
            minDate: new Date(),
            dateFormat:'dd-mm-yy'

        });
        $("#train_departure_date").datepicker("setDate",oldTrainDepartureDate);
        $("#train_return_date" ).datepicker({
            minDate: oldTrainDepartureDate,
            dateFormat:'dd-mm-yy'
        });
        $( "#train_return_date" ).datepicker( "setDate", oldTrainDepartureDate );
        if(window.request.trip=='R'){
            $("#train_return_date").datepicker("setDate",oldTrainReturnDate);
        }
    }else{
        $("#train_departure_date").datepicker({
            // todayHighlight:1,
            // todayBtn:  1,
            // autoclose: true,
            // startDate:'0d',
            onSelect: function(date) {
                $( "#train_return_date" ).datepicker( "option","minDate",date);
                $( "#train_return_date" ).datepicker( "setDate",date);
            },
            minDate: new Date(),
            dateFormat:'dd-mm-yy'

        });
        $( "#train_departure_date" ).datepicker( "setDate", new Date() );
        $( "#train_return_date" ).datepicker({
            minDate: new Date(),
            dateFormat:'dd-mm-yy'
        });
        $( "#train_return_date" ).datepicker( "setDate", new Date() );

    }
    if(typeof oldCheckinDate != 'undefined'){
        $("#checkin_date").datepicker({
            // todayHighlight:1,
            // todayBtn:  1,
            // autoclose: true,
            // startDate:'0d',
            onSelect: function(date) {
                $( "#checkout_date" ).datepicker( "option","minDate",date);
                $( "#checkout_date" ).datepicker( "setDate",date);
            },
            minDate: new Date(),
            dateFormat:'yy-mm-dd'

        });
        $("#checkin_date").datepicker("setDate",oldCheckinDate);
        $( "#checkout_date" ).datepicker({
            minDate: oldCheckOutDate,
            dateFormat:'yy-mm-dd'
        });
        $( "#checkout_date" ).datepicker( "setDate", oldCheckOutDate );
    }else{
        $("#checkin_date").datepicker({
            // todayHighlight:1,
            // todayBtn:  1,
            // autoclose: true,
            // startDate:'0d',
            onSelect: function(date) {
                console.log(date);
                var newDate = new Date(date);
                var tomorrow = newDate.getDate()+1;
                newDate.setDate(tomorrow);
                $( "#checkout_date" ).datepicker( "option","minDate",newDate);
                $( "#checkout_date" ).datepicker( "setDate",newDate);
            },
            minDate: new Date(),
            dateFormat:'yy-mm-dd'

        });
        $( "#checkin_date" ).datepicker( "setDate", new Date() );
        $( "#checkout_date" ).datepicker({
            minDate:MyDate,
            dateFormat:'yy-mm-dd'
        });
        $( "#checkout_date" ).datepicker( "setDate", MyDate );

    }
    /*
    Radio Button Flight
     */
    if ($('input[name="flight"]').length > 0) {
        var selected = $('input[name="flight"]:checked').val();
        if (selected === 'undefined' || selected !== 'R') {
            $('#js-flight').slideUp("slow");
        }
        $('input[name="flight"]').change(function () {
            var selected = $('input[name="flight"]:checked').val();
            if (selected === 'R') {
                $('#js-flight').slideDown("slow");
            } else {
                $('#js-flight').slideUp("slow");
            }
        })
    }
    if(typeof oldRailinkDepartureDate != 'undefined'){
        $("#railink_departure_date").datepicker({
            // todayHighlight:1,
            // todayBtn:  1,
            // autoclose: true,
            // startDate:'0d',
            onSelect: function(date) {
                $( "#railink_return_date" ).datepicker( "option","minDate",date);
                $( "#railink_return_date" ).datepicker( "setDate",date);
            },
            minDate: new Date(),
            dateFormat:'dd-mm-yy'

        });
        $("#railink_departure_date").datepicker("setDate",oldRailinkDepartureDate);
        $("#railink_return_date" ).datepicker({
            minDate: oldRailinkDepartureDate,
            dateFormat:'dd-mm-yy'
        });
        $( "#railink_return_date" ).datepicker( "setDate", oldRailinkDepartureDate );
        if(window.request.trip=='R'){
            $("#train_return_date").datepicker("setDate",oldRailinkReturnDate);
        }
    }else{
        $("#railink_departure_date").datepicker({
            // todayHighlight:1,
            // todayBtn:  1,
            // autoclose: true,
            // startDate:'0d',
            onSelect: function(date) {
                $( "#railink_return_date" ).datepicker( "option","minDate",date);
                $( "#railink_return_date" ).datepicker( "setDate",date);
            },
            minDate: new Date(),
            dateFormat:'dd-mm-yy'

        });
        $( "#railink_departure_date" ).datepicker( "setDate", new Date() );
        $( "#railink_return_date" ).datepicker({
            minDate: new Date(),
            dateFormat:'dd-mm-yy'
        });
        $( "#railink_return_date" ).datepicker( "setDate", new Date() );
    }
    if ($('input[name="trip"]').length > 0) {
        var selected = $('input[name="trip"]:checked').val();
        if (selected === 'undefined' || selected !== 'R') {
            $('.js-trip').slideUp("slow");
        }
        $('input[name="trip"]').change(function () {
            var selected = $('input[name="trip"]:checked').val();
            if (selected === 'R') {
                $('.js-trip').slideDown("slow");
            } else {
                $('.js-trip').slideUp("slow");
            }
        })
    }
    if ($('input[name="trip_railink"]').length > 0) {
        var selected = $('input[name="trip_railink"]:checked').val();
        if (selected === 'undefined' || selected !== 'R') {
            $('#js-railink').slideUp("slow");
        }
        $('input[name="trip_railink"]').change(function () {
            var selected = $('input[name="trip_railink"]:checked').val();
            if (selected === 'R') {
                $('#js-railink').slideDown("slow");
            } else {
                $('#js-railink').slideUp("slow");
            }
        })
    }
    if ($('input[name="hotel_type"]').length > 0) {
        var selected = $('input[name="hotel_type"]:checked').val();
        if (selected === 'undefined' || selected !== 'international') {
            $('#intDes').hide();
        }
        $('input[name="hotel_type"]').change(function () {
            var selected = $('input[name="hotel_type"]:checked').val();
            if (selected === 'international') {
                $('#intDes').show();
                $('#domesticDes').hide();
            } else {
                $('#domesticDes').show();
                $('#intDes').hide();
            }
        })
    }
    /*
    Add Comma for price
     */
    function addCommas(nStr)
    {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        //x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 ;//+ x2;
    }
    }
);
