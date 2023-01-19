<h5>Request</h5>
<div class="tabs-wrapper">
    <ul class="nav classic-tabs tabs-cyan" role="tablist">
        <li class="nav-item">
            <a class="nav-link waves-light active" data-toggle="tab" href="#reqAirFare1" role="tab">URL</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#reqAirFare2" role="tab">Parameter</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="reqAirFare1" role="tabpanel">
        <table class="table table-striped">
            <tbody>
            <tr>
                <th>Method</th>
                <td>POST</td>
            </tr>
            <tr>
                <th>URL</th>
                <td>{{ route('api.airlines_get_fare') }}</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="reqAirFare2" role="tabpanel">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Parameter</th>
                <th>Wajib</th>
                <th>Keterangan</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <th>access_token</th>
                <td>YA/TIDAK</td>
                <td>Gunakan akses token yang didapat ketika GET TOKEN. Jika tidak menggunakan parameter ini, maka
                    gunakan "Authorization : Bearer < access_token >" pada header request
                </td>
            </tr>
            <tr>
                <th>client_id</th>
                <td>YA</td>
                <td>Client id yang didapat ketika login</td>
            </tr>
            <tr>
                <th>acDep</th>
                <td>YA <strong>(Domestik)</strong></td>
                <td>Kode maskapai keberangkatan</td>
            </tr>
            <tr>
                <th>acRet</th>
                <td>TIDAK <strong>(Domestik)</strong></td>
                <td>Kode maskapai kembali.  <strong>Wajib jika flight=R</strong></td>
            </tr>
            <tr>
                <th>org</th>
                <td>YA</td>
                <td>Kode bandara keberangkatan</td>
            </tr>
            <tr>
                <th>des</th>
                <td>YA</td>
                <td>Kode bandara tujuan</td>
            </tr>
            <tr>
                <th>flight</th>
                <td>YA</td>
                <td>R = untuk pulang pergi, O = untuk sekali jalan.</td>
            </tr>
            <tr>
                <th>tgl_dep</th>
                <td>YA</td>
                <td>Tanggal keberangkatan. Format = yyyy-mm-dd</td>
            </tr>
            <tr>
                <th>tgl_ret</th>
                <td>YA</td>
                <td>Tanggal keberangkatan. Format = yyyy-mm-dd. <strong>Wajib jika flight=R</strong></td>
            </tr>
            <tr>
                <th>adt</th>
                <td>YA</td>
                <td>Jumlah penumpang dewasa (numeric). <strong>minimal 1</strong></td>
            </tr>
            <tr>
                <th>chd</th>
                <td>YA</td>
                <td>Jumlah penumpang anak (numeric).<strong>minimal 0</strong></td>
            </tr>
            <tr>
                <th>inf</th>
                <td>YA</td>
                <td>Jumlah penumpang bayi (numeric).<strong>minimal 0</strong></td>
            </tr>
            <tr>
                <th>selectedIDdep</th>
                <td>YA</td>
                <td>selected ID departure</td>
            </tr>
            <tr>
                <th>selectedIDret</th>
                <td>YA</td>
                <td>selected ID return</td>
            </tr>
            <tr>
              <th>cabin</th>
              <td>YA <strong>(international)</strong></td>
              <td>Hanya untuk international, value : economy / business</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="tabs-wrapper">
    <ul class="nav classic-tabs tabs-cyan" role="tablist">
        <li class="nav-item">
            <a class="nav-link waves-light active" data-toggle="tab" href="#resAirFare1" role="tab">RESPONSE BERHASIL</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resAirFareInt" role="tab">RESPONSE INTERNATIONAL</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resAirFare2" role="tab">RESPONSE GAGAL</a>
        </li>
        <li class="nav-item">
            <a class="nav-link waves-light" data-toggle="tab" href="#resAirFare3" role="tab">PENJELASAN</a>
        </li>
    </ul>
</div>
<div class="tab-content card">
    <div class="tab-pane fade in active" id="resAirFare1" role="tabpanel">
            <pre class="code-toolbar" style="height: 500px">
                <code class="language-markup">
{
  "status": {
      "code": 200,
      "confirm": "success",
      "message": [
          "Success get fare."
      ]
  },
  "details": {
      "acDep": "GA",
      "org": "CGK",
      "des": "DPS",
      "flight": "O",
      "tgl_dep": "2018-08-30",
      "tgl_ret": "",
      "adt": "1",
      "chd": "0",
      "inf": "0",
      "bookStat": "booking",
      "bookNote": "",
      "TotalAmount": "1829000",
      "NTA": "1829000",
      "schedule": {
          "departure": [
              {
                  "Flights": [
                      {
                          "FlightNo": "GA400",
                          "Transit": "0",
                          "STD": "CGK",
                          "STA": "DPS",
                          "ETD": "2018-08-30 05:40",
                          "ETA": "2018-08-30 08:40",
                          "Durasi": "120"
                      }
                  ],
                  "Fares": [
                      {
                          "SubClass": "M",
                          "SeatAvb": "9",
                          "selectedIDdep": "FARE940358"
                      }
                  ]
              }
          ]
      },
      "SmartPrice": 0
  }
}

                </code>
            </pre>
    </div>
    <div class="tab-pane fade in active" id="resAirFareInt" role="tabpanel">
            <pre class="code-toolbar" style="height: 500px">
                <code class="language-markup">
{
  "status": {
    "code": 200,
    "confirm": "success",
    "message": [
      "Success get fare."
    ]
  },
  "details": {
    "error_code": "000",
    "error_msg": "",
    "mmid": "mastersip",
    "org": "CGK",
    "des": "LHR",
    "flight": "O",
    "tgl_dep": "2017-05-23",
    "tgl_ret": "",
    "adt": "1",
    "chd": "0",
    "inf": "0",
    "cabin": "economy",
    "totalAmount": "12559516",
    "NTA": "12559516",
    "saldo": "37579280",
    "trxId": "FARE4947",
    "rules": [
      "<h3>50 RULE APPLICATION AND OTHER CONDITIONS</h3>NOTE - THE FOLLOWING TEXT IS INFORMATIONAL AND NOT\nVALIDATED FOR AUTOPRICING.\nKLM - SEMI FLEXIBLE - RESTRICTED FARES\nFROM INDONESIA TO EUROPE.\nAPPLICATION\nAREA\nTHESE FARES APPLY\nFROM INDONESIA\nTO EUROPE.\nCLASS OF SERVICE\nTHESE FARES APPLY FOR ECONOMY CLASS SERVICE.\nTYPES OF TRANSPORTATION\nTHIS RULE GOVERNS ROUND-TRIP FARES.\nFARES GOVERNED BY THIS RULE CAN BE USED TO CREATE\nROUND-TRIP/CIRCLE-TRIP/OPEN-JAW JOURNEYS.\nCAPACITY LIMITATIONS\nTHE CARRIER SHALL LIMIT THE NUMBER OF PASSENGERS\nCARRIED ON ANY ONE FLIGHT AT FARES GOVERNED BY\nTHIS RULE AND SUCH FARES WILL NOT NECESSARILY BE\nAVAILABLE ON ALL FLIGHTS. THE NUMBER OF SEATS,\nWHICH THE CARRIER SHALL MAKE AVAILABLE ON A GIVEN\nFLIGHT, WILL BE DETERMINED BY THE CARRIER'S BEST\nJUDGEMENT.\nOTHER CONDITIONS\nTHE FARE THAT APPLIES ON THE DATE OF PURCHASE\nIS ONLY VALID FOR THE ENTIRE ITINERARY AND THE\nSPECIFIC TRAVEL DATES MENTIONED ON THE TICKET.\nANY MODIFICATION MAY REQUIRE THE PAYMENT OF AN\nADDITIONAL AMOUNT.\n----FULL AND SEQUENTIAL USE OF FLIGHT COUPONS-----\nTHIS FARE IS ONLY VALID WHEN FLIGHTS ARE TAKEN\nIN SEQUENCE IDENTICALLY AS BOOKED ON THE TICKET\n- IF ANY OF THE COUPON IS NOT USED IN THE\nSEQUENCE PROVIDED IN THE TICKET\nA FARE READJUSTMENT WILL BE APPLIED AND THE PRICE\nWILL BE RECALCULATED BASED ON THE NEW JOURNEY\nREQUESTED\n--------------------------------------------------\n..... ONLY AF/KL AIRPORT TICKET OFFICE ARE ALLOWED\nTO PROCESS FARE RECALCULATION AND REISSUE ........\nAS DESCRIBED IN ..\nGGAIRAF OUT OF SEQUENCE REISSUE\n--------------------------------------------------<br/><br/><h3>01 ELIGIBILITY</h3>NO ELIGIBILITY REQUIREMENTS APPLY.<br/><br/><h3>02 DAY/TIME</h3>PERMITTED SUN THROUGH THU.<br/><br/><h3>03 SEASONALITY</h3>PERMITTED 01JUL THROUGH 15DEC OR 01JAN THROUGH 15JUN\nON THE FIRST INTERNATIONAL SECTOR. SEASON IS BASED ON\nDATE OF ORIGIN.<br/><br/><h3>04 FLIGHT APPLICATION</h3>NO FLIGHT RESTRICTIONS APPLY.<br/><br/><h3>05 ADVANCE RESERVATIONS/TICKETING</h3>CONFIRMED RESERVATIONS ARE REQUIRED FOR ALL SECTORS.\nNOTE - TEXT BELOW NOT VALIDATED FOR AUTOPRICING.\nRESERVATIONS ARE REQUIRED FOR ALL SECTORS.\nWHEN RESERVATIONS ARE MADE AT LEAST 101 DAYS\nBEFORE DEPARTURE TICKETING MUST BE COMPLETED\nWITHIN 7 DAYS AFTER RESERVATIONS ARE MADE OR AT\nLEAST 98 DAYS BEFORE DEPARTURE WHICHEVER IS\nEARLIER.\nOR - RESERVATIONS ARE REQUIRED FOR ALL SECTORS.\nWHEN RESERVATIONS ARE MADE AT LEAST 11 DAYS\nBEFORE DEPARTURE TICKETING MUST BE COMPLETED\nWITHIN 3 DAYS AFTER RESERVATIONS ARE MADE OR\nAT LEAST 10 DAYS BEFORE DEPARTURE WHICHEVER\nIS EARLIER.\nOR - TICKETING MUST BE COMPLETED WITHIN 24 HOURS\nAFTER RESERVATIONS ARE MADE.\n-\nDIFFERENCE COULD EXIST BETWEEN THE CRS LAST\nTICKETING DATE AND TTL ROBOT REMARK.\n--THE MOST RESTRICTIVE DATE PREVAILS.--<br/><br/><h3>06 MINIMUM STAY</h3>NO MINIMUM STAY REQUIREMENTS APPLY.<br/><br/><h3>07 MAXIMUM STAY</h3>TRAVEL FROM LAST STOPOVER MUST COMMENCE NO LATER THAN\n12 MONTHS AFTER DEPARTURE FROM FARE ORIGIN.<br/><br/><h3>08 STOPOVERS</h3>1 STOPOVER PERMITTED IN EACH DIRECTION\nLIMITED TO 1 FREE AND 1 AT IDR 1400000.<br/><br/><h3>09 TRANSFERS</h3>UNLIMITED TRANSFERS PERMITTED ON THE PRICING UNIT.\nFARE BREAK SURFACE SECTORS NOT PERMITTED AND EMBEDDED\nSURFACE SECTORS PERMITTED ON THE FARE COMPONENT.\nNOTE - TEXT BELOW NOT VALIDATED FOR AUTOPRICING.\nAS PER ROUTING REQUIREMENTS\nSTANDARD RULE<br/><br/><h3>10 COMBINATIONS</h3>END-ON-END NOT PERMITTED. SIDE TRIPS NOT PERMITTED.\nOPEN JAWS/ROUND TRIPS/CIRCLE TRIPS\nFARES MAY BE COMBINED ON A HALF ROUND TRIP BASIS\n-TO FORM SINGLE OR DOUBLE OPEN JAWS WHICH CONSISTS\nOF NO MORE THAN 2 INTERNATIONAL FARE COMPONENTS AND\nTHE OPEN SEGMENT AT ORIGIN MUST BE IN ONE COUNTRY.\nTHE OPEN SEGMENT AT DESTINATION HAS NO RESTRICTIONS\nA MAXIMUM OF TWO INTERNATIONAL FARE COMPONENTS\nPERMITTED. MILEAGE OF THE OPEN SEGMENT MUST BE EQUAL/\nLESS THAN MILEAGE OF THE LONGEST FLOWN FARE\nCOMPONENT.\n-TO FORM ROUND TRIPS\n-TO FORM CIRCLE TRIPS\nA MAXIMUM OF TWO INTERNATIONAL FARE COMPONENTS\nPERMITTED.\nPROVIDED -\nCOMBINATIONS ARE NOT WITH ANY FIRST CLASS\nUNRESTRICTED/FIRST CLASS RESTRICTED-TYPE FARES FOR\nANY CARRIER IN ANY RULE AND TARIFF.\nCOMBINATIONS ARE WITH ANY FARE FOR CARRIER AF/KL/\nAZ/KQ IN ANY RULE AND TARIFF.<br/><br/><h3>11 BLACKOUT DATES</h3>NO BLACKOUT DATES APPLY.<br/><br/><h3>12 SURCHARGES</h3>IF INFANT WITHOUT A SEAT PSGR UNDER 2.\nOR - CONTRACT BULK INFANT PSGR UNDER 2.\nOR - INCLUSIVE TOUR INFANT WITHOUT A SEAT PSGR UNDER 2.\nTHERE IS NO MISCELLANEOUS/OTHER SURCHARGE PER ANY\nPASSENGER.\nTHE PROVISIONS BELOW APPLY ONLY AS FOLLOWS -\nWHEN TICKETS ARE SOLD IN IRAN.\nMISCELLANEOUS/OTHER SURCHARGE OF EUR 216.00 PER\nDIRECTION WILL BE ADDED TO THE APPLICABLE FARE PER\nADULT/CHILD/INFANT.\nNOTE - TEXT BELOW NOT VALIDATED FOR AUTOPRICING.\nSALES MAY BE PERMITTED WORLDWIDE - SEE CAT.15 -\nBUT TICKETS SOLD IN ISLAMIC REPUBLIC OF IRAN WILL\nQUOTE THE Q-SURCHARGE INSTEAD OF YQ/YR FOR KL.<br/><br/><h3>13 ACCOMPANIED TRAVEL</h3>ACCOMPANIED TRAVEL NOT REQUIRED.<br/><br/><h3>14 TRAVEL RESTRICTIONS</h3>NO TRAVEL DATE RESTRICTIONS APPLY.<br/><br/><h3>15 SALES RESTRICTIONS</h3>FARE RULE\nNOTE - TEXT BELOW NOT VALIDATED FOR AUTOPRICING.\nEXTENSION OF VALIDITY NOT PERMITTED FOR\nMEDICAL REASONS.\nGENERAL RULE - APPLY UNLESS OTHERWISE SPECIFIED\nIF THE FARE COMPONENT INCLUDES TRAVEL BETWEEN AREA 3\nAND EUROPE\nTHEN THAT TRAVEL MUST BE ON\nONE OR MORE OF THE FOLLOWING\nANY 9W FLIGHT OPERATED BY 9W\nANY KL FLIGHT OPERATED BY 9W.\nTICKETS MUST BE ISSUED ON THE STOCK OF KL OR 9W AND\nMAY NOT BE SOLD IN VENEZUELA/ANGOLA/EGYPT/NIGERIA.\nOR - TICKETS MUST BE ISSUED ON THE STOCK OF KL OR DL\nAND MAY NOT BE SOLD IN VENEZUELA/ANGOLA/EGYPT/\nNIGERIA.\nOR - TICKETS MUST BE ISSUED ON THE STOCK OF KL OR AF\nAND MAY NOT BE SOLD IN VENEZUELA/ANGOLA/EGYPT/\nNIGERIA.\nTICKETS MUST BE ISSUED ON THE STOCK OF KL OR AF AND\nMAY NOT BE SOLD IN VENEZUELA/ANGOLA/EGYPT/NIGERIA.\nOR - TICKETS MUST BE ISSUED ON THE STOCK OF KL OR A5\nAND MAY NOT BE SOLD IN VENEZUELA/ANGOLA/EGYPT/\nNIGERIA.\nOR - TICKETS MUST BE ISSUED ON THE STOCK OF KL OR 9W\nAND MAY NOT BE SOLD IN VENEZUELA/ANGOLA/EGYPT/\nNIGERIA.\nOR - TICKETS MUST BE ISSUED ON THE STOCK OF KL OR AM\nAND MAY NOT BE SOLD IN VENEZUELA/ANGOLA/EGYPT/\nNIGERIA.\nOR - TICKETS MUST BE ISSUED ON THE STOCK OF KL OR AR\nAND MAY NOT BE SOLD IN VENEZUELA/ANGOLA/EGYPT/\nNIGERIA.\nOR - TICKETS MUST BE ISSUED ON THE STOCK OF KL OR CM\nAND MAY NOT BE SOLD IN VENEZUELA/ANGOLA/EGYPT/\nNIGERIA.\nOR - TICKETS MUST BE ISSUED ON THE STOCK OF KL OR CZ\nAND MAY NOT BE SOLD IN VENEZUELA/ANGOLA/EGYPT/\nNIGERIA.\nOR - TICKETS MUST BE ISSUED ON THE STOCK OF KL OR DL\nAND MAY NOT BE SOLD IN VENEZUELA/ANGOLA/EGYPT/\nNIGERIA.\nOR - TICKETS MUST BE ISSUED ON THE STOCK OF KL OR FB\nAND MAY NOT BE SOLD IN VENEZUELA/ANGOLA/EGYPT/\nNIGERIA.\nOR - TICKETS MUST BE ISSUED ON THE STOCK OF KL OR JU\nAND MAY NOT BE SOLD IN VENEZUELA/ANGOLA/EGYPT/\nNIGERIA.\nOR - TICKETS MUST BE ISSUED ON THE STOCK OF KL OR KE\nAND MAY NOT BE SOLD IN VENEZUELA/ANGOLA/EGYPT/\nNIGERIA.\nOR - TICKETS MUST BE ISSUED ON THE STOCK OF KL OR KQ\nAND MAY NOT BE SOLD IN VENEZUELA/ANGOLA/EGYPT/\nNIGERIA.\nOR - TICKETS MUST BE ISSUED ON THE STOCK OF KL OR LG\nAND MAY NOT BE SOLD IN VENEZUELA/ANGOLA/EGYPT/\nNIGERIA.\nOR - TICKETS MUST BE ISSUED ON THE STOCK OF KL OR MF\nAND MAY NOT BE SOLD IN VENEZUELA/ANGOLA/EGYPT/\nNIGERIA.\nOR - TICKETS MUST BE ISSUED ON THE STOCK OF KL OR MH\nAND MAY NOT BE SOLD IN VENEZUELA/ANGOLA/EGYPT/\nNIGERIA.\nOR - TICKETS MUST BE ISSUED ON THE STOCK OF KL OR MK\nAND MAY NOT BE SOLD IN VENEZUELA/ANGOLA/EGYPT/\nNIGERIA.\nOR - TICKETS MUST BE ISSUED ON THE STOCK OF KL OR MU\nAND MAY NOT BE SOLD IN VENEZUELA/ANGOLA/EGYPT/\nNIGERIA.\nOR - TICKETS MUST BE ISSUED ON THE STOCK OF KL OR OK\nAND MAY NOT BE SOLD IN VENEZUELA/ANGOLA/EGYPT/\nNIGERIA.\nOR - TICKETS MUST BE ISSUED ON THE STOCK OF KL OR PS\nAND MAY NOT BE SOLD IN VENEZUELA/ANGOLA/EGYPT/\nNIGERIA.\nOR - TICKETS MUST BE ISSUED ON THE STOCK OF KL OR PX\nAND MAY NOT BE SOLD IN VENEZUELA/ANGOLA/EGYPT/\nNIGERIA.\nOR - TICKETS MUST BE ISSUED ON THE STOCK OF KL OR QF\nAND MAY NOT BE SOLD IN VENEZUELA/ANGOLA/EGYPT/\nNIGERIA.\nOR - TICKETS MUST BE ISSUED ON THE STOCK OF KL OR QV\nAND MAY NOT BE SOLD IN VENEZUELA/ANGOLA/EGYPT/\nNIGERIA.\nOR - TICKETS MUST BE ISSUED ON THE STOCK OF KL OR SB\nAND MAY NOT BE SOLD IN VENEZUELA/ANGOLA/EGYPT/\nNIGERIA.\nOR - TICKETS MUST BE ISSUED ON THE STOCK OF KL OR SV\nAND MAY NOT BE SOLD IN VENEZUELA/ANGOLA/EGYPT/\nNIGERIA.\nNOTE - TEXT BELOW NOT VALIDATED FOR AUTOPRICING.\nTHE FARE THAT APPLIES ON THE DATE OF PURCHASE\nIS ONLY VALID FOR THE ENTIRE ITINERARY AND THE\nSPECIFIC TRAVEL DATES MENTIONED ON THE TICKET.\nANY MODIFICATION MAY REQUIRE THE PAYMENT OF AN\nADDITIONAL AMOUNT.\n----------------------------------------------\n--FULL AND SEQUENTIAL USE OF COUPONS--\nTHIS FARE IS ONLY VALID WHEN FLIGHT COUPONS ARE\nUSED IN THE SAME ORDER AS SHOWN ON THE TICKET\n- IF ANY OF THE COUPONS IS NOT USED IN THE\nSEQUENCE SHOWN ON THE TICKET A FARE READJUSMENT\nWILL BE APPLIED AND THE FARE WILL BE RECALCULATED\nBASED ON THE NEW JOURNEY REQUESTED\n---------------------------------------------\nONLY KL/AF/DL AIRPORT TICKET OFFICES ARE ALLOWED\nTO PROCESS FARE RECALCULATION AND REISSUE AS\nDESCRIBED IN GGAIRKL OUT OF SEQUENCE\nOR - TICKETS MUST BE ISSUED ON THE STOCK OF KL OR WF\nAND MAY NOT BE SOLD IN VENEZUELA/ANGOLA/EGYPT/\nNIGERIA.\nNOTE - TEXT BELOW NOT VALIDATED FOR AUTOPRICING.\nTHE FARE THAT APPLIES ON THE DATE OF PURCHASE\nIS ONLY VALID FOR THE ENTIRE ITINERARY AND THE\nSPECIFIC TRAVEL DATES MENTIONED ON THE TICKET.\nANY MODIFICATION MAY REQUIRE THE PAYMENT OF AN\nADDITIONAL AMOUNT.\n----------------------------------------------\n--FULL AND SEQUENTIAL USE OF COUPONS--\nTHIS FARE IS ONLY VALID WHEN FLIGHT COUPONS ARE\nUSED IN THE SAME ORDER AS SHOWN ON THE TICKET\n- IF ANY OF THE COUPONS IS NOT USED IN THE\nSEQUENCE SHOWN ON THE TICKET A FARE READJUSMENT\nWILL BE APPLIED AND THE FARE WILL BE RECALCULATED\nBASED ON THE NEW JOURNEY REQUESTED\n---------------------------------------------\nONLY KL/AF/DL AIRPORT TICKET OFFICES ARE ALLOWED\nTO PROCESS FARE RECALCULATION AND REISSUE AS\nDESCRIBED IN GGAIRKL OUT OF SEQUENCE<br/><br/><h3>16 PENALTIES</h3>CHANGES\nBEFORE DEPARTURE\nCHARGE IDR 850000.\nCHILD/INFANT DISCOUNTS APPLY.\nNOTE - TEXT BELOW NOT VALIDATED FOR AUTOPRICING.\nA CHANGE IS A ROUTING / DATE / FLIGHT MODIFICATION\nWHEN MORE THAN ONE FARE COMPONENT IS BEING CHANGED\nTHE HIGHEST PENALTY OF ALL CHANGED FARE COMPONENTS\nWILL APPLY\n////\n// BEFORE OUTBOUND DEPARTURE //\n////\nNEW RESERVATION AND REISSUANCE MUST BE MADE AT THE\nSAME TIME PRIOR TO DEPARTURE OF THE ORIGINALLY\nSCHEDULED FLIGHT. IF CHANGE DOES NOT OCCUR ON THE\nFIRST FARE COMPONENT OF THE JOURNEY NEW FARE\nWILL BE RECALCULATED USING FARES IN EFFECT ON THE\nPREVIOUS TICKETING DATE AND UNDER FOLLOWING\nCONDITIONS\n- IF SAME BOOKING CLASS IS USED NEW FARE MAY BE\nLOWER OR EQUAL OR HIGHER THAN PREVIOUS AND\nA / MUST COMPLY WITH ALL PROVISIONS OF THE\nORIGINALLY TICKETED FARE\nB / OR MUST COMPLY WITH ALL PROVISIONS OF THE\nNEW FARE BEING APPLIED\n- IF A DIFFERENT BOOKING CLASS IS USED NEW FARE\nMAY BE EQUAL OR HIGHER THAN PREVIOUS AND\nA / MUST COMPY WITH ALL PROVISIONS OF THE\nNEW FARE BEING APPLIED\n-----------------------\nNEW RESERVATION AND REISSUANCE MUST BE MADE AT THE\nSAME TIME PRIOR TO DEPARTURE OF THE ORIGINALLY\nSCHEDULED FLIGHT. WHEN CHANGE OCCURS ON THE FIRST\nFARE COMPONENT OF THE JOURNEY ONLY OR ON THE\nFIRST FARE COMPONENT AND OTHER FARE COMPONENT OF\nTHE JOURNEY NEW FARE WILL BE RECALCULATED USING\nFARES IN EFFECT ON DATE OF REISSUE AND UNDER\nFOLLOWING CONDITIONS\n- IF SAME BOOKING CLASS IS USED NEW FARE MAY BE\nLOWER OR EQUAL OR HIGHER THAN PREVIOUS AND\nA / MUST COMPLY WITH ALL PROVISIONS OF THE\nORIGINALLY TICKETED FARE\nB / OR MUST COMPLY WITH ALL PROVISIONS OF THE\nNEW FARE BEING APPLIED\n- IF A DIFFERENT BOOKING CLASS IS USED NEW FARE\nMAY BE EQUAL OR HIGHER THAN PREVIOUS AND\nA / MUST COMPLY WITH ALL PROVISIONS OF THE\nNEW FARE BEING APPLIED\nCHANGES NOT PERMITTED IN CASE OF NO-SHOW.\nNOTE - TEXT BELOW NOT VALIDATED FOR AUTOPRICING.\n//  BEFORE OUTBOUND DEPARTURE  //\n//  NO SHOW  //\nIN THE EVENT OF NO SHOW - WHEN CHANGES ARE\nREQUESTED AFTER DEPARTURE OF THE ORIGINALLY\nSCHEDULED FLIGHT -  CHANGES ARE NOT PERMITTED AND\nCANCELLATION RULES SHALL APPLY\nAFTER DEPARTURE\nCHARGE IDR 850000.\nCHILD/INFANT DISCOUNTS APPLY.\nNOTE - TEXT BELOW NOT VALIDATED FOR AUTOPRICING.\n/////\n// AFTER OUTBOUND DEPARTURE //\n////\nNEW RESERVATION AND REISSUANCE MUST BE MADE AT THE\nSAME TIME. NEW FARE WILL BE RECALCULATED USING\nFARES IN EFFECT ON THE PREVIOUS TICKETING DATE\nAND UNDER FOLLOWING CONDITIONS\n- IF SAME BOOKING CLASS IS USED NEW FARE MAY BE\nLOWER OR EQUAL OR HIGHER THAN PREVIOUS AND\nA / MUST COMPLY WITH ALL PROVISIONS OF THE\nORIGINALLY TICKETED FARE\nB / OR MUST COMPLY WITH ALL PROVISIONS OF THE\nNEW FARE BEING APPLIED\n- IF A DIFFERENT BOOKING CLASS IS USED NEW FARE\nMAY BE EQUAL OR HIGHER THAN PREVIOUS AND\nA / MUST COMPLY WITH ALL PROVISIONS OF THE NEW\nFARE BEING APPLIED\nCANCELLATIONS\nBEFORE DEPARTURE\nCHARGE IDR 1400000 FOR CANCEL.\nCHILD/INFANT DISCOUNTS APPLY.\nNOTE - TEXT BELOW NOT VALIDATED FOR AUTOPRICING.\n/////\n// BEFORE OUTBOUND DEPARTURE //\n/////\nTHE WHOLLY UNUSED TICKET IS REFUNDABLE UPON\nPAYMENT OF THE PENALTY AMOUNT CONTAINED IN\nTHIS RULE\nTICKET IS NON-REFUNDABLE IN CASE OF NO-SHOW.\nNOTE - TEXT BELOW NOT VALIDATED FOR AUTOPRICING.\n// BEFORE OUTBOUND DEPATURE //\n// NO SHOW //\nTICKET IS NON REFUNDABLE WHEN PASSENGER CANCELS\nAFTER DEPARTURE OF THE ORIGINALLY SCHEDULED FLIGHT\nAFTER DEPARTURE\nTICKET IS NON-REFUNDABLE IN CASE OF CANCEL.\nNOTE - TEXT BELOW NOT VALIDATED FOR AUTOPRICING.\n////\n// AFTER OUTBOUND DEPARTURE //\n////\nTICKET IS NON REFUNDABLE WHEN PASSENGER CANCELS\nAFTER OUTBOUND DEPARTURE MEANING THAT NO REFUNDS\nARE ALLOWED ONCE THE FIRST COUPON OF THE PRICING\nUNIT IS USED.\nNOTE - TEXT BELOW NOT VALIDATED FOR AUTOPRICING.\nANY TIME\nCANCELLATIONS RULES APPLY BY FARE COMPONENT\nWHEN COMBINING A REFUNDABLE TICKET WITH A\nNON REFUNDABLE TICKET PROVISIONS WILL APPLY\nAS FOLLOWS\n- THE AMOUNT PAID ON THE REFUNDABLE FARE\nCOMPONENT WILL BE REFUNDED UPON PAYMENT\nOF THE PENALTY AMOUNT IF APPLICABLE\n- THE AMOUNT PAID ON THE NON REFUNDABLE\nFARE COMPONENT WILL NOT BE REFUNDED\n-----------------------------\nFOR DEATH/ILLNESS WAIVERS SEE GGAIRKLDEATH/\nGGAIRKLHOSPITAL OR KLAF.BIZ/AFKL.BIZ<br/><br/><h3>17 HIP/MILEAGE EXCEPTIONS</h3>NO HIP OR MILEAGE EXCEPTIONS APPLY.<br/><br/><h3>18 TICKET ENDORSEMENTS</h3>THE ORIGINAL AND THE REISSUED TICKET MUST BE ANNOTATED\n- NON ENDO/ - AND - FARE RSTR COULD APPLY - IN THE\nENDORSEMENT BOX.<br/><br/><h3>19 CHILDREN DISCOUNTS</h3>CNN/ACCOMPANIED CHILD PSGR 2-11. ID REQUIRED - CHARGE\n75 PERCENT OF THE FARE.\nTICKET DESIGNATOR - CH AND PERCENT APPLIED.\nMUST BE ACCOMPANIED ON ALL FLIGHTS IN THE SAME\nCOMPARTMENT BY ADULT PSGR 18 OR OLDER.\nOR - INS/INFANT WITH A SEAT PSGR UNDER 2. ID REQUIRED -\nCHARGE 75 PERCENT OF THE FARE.\nTICKET DESIGNATOR - CH AND PERCENT APPLIED.\nMUST BE ACCOMPANIED ON ALL FLIGHTS IN THE SAME\nCOMPARTMENT BY ADULT PSGR 18 OR OLDER.\nOR - INF/INFANT WITHOUT A SEAT PSGR UNDER 2 - CHARGE 10\nPERCENT OF THE FARE.\nTICKET DESIGNATOR - IN AND PERCENT APPLIED.\nMUST BE ACCOMPANIED ON ALL FLIGHTS IN THE SAME\nCOMPARTMENT BY ADULT PSGR 18 OR OLDER.\nNOTE - TEXT BELOW NOT VALIDATED FOR AUTOPRICING.\n1 ADULT PASSENGER AGED AT LEAST 18 YEARS\nMAY BE ACCOMPANIED BY A MAXIMUM OF 2 INFANTS OF\nWHO 1 HAVE TO BE BOOKED AS INFANT OCCUPYING A SEAT\n-------------------------------------------------\nTHE AGE LIMITS REFERRED TO IN THIS RULE SHALL BE\nTHOSE IN EFFECT ON THE DATE OF COMMENCEMENT\nOF TRAVEL.\nEXCEPTION - INFANTS WHO REACH THEIR 2ND\nBIRTHDAY DURING THEIR TRAVEL WILL BE REQUIRED\nTO OCCUPY A SEAT ON THE OUTBOUND AND INBOUND\nFLIGHT.\nTHE CHILD FARE NEEDS TO BE APPLIED FOR THE WHOLE\nJOURNEY\nIF THE FARE COMPONENT MUST BE\nON DIRECT FLIGHTS.\nUNN/UNACCOMPANIED CHILD PSGR 5-14. ID REQUIRED -\nCHARGE 100 PERCENT OF THE FARE PLUS EUR 80.00.\nTICKET DESIGNATOR - UM0.\nNOTE - TEXT BELOW NOT VALIDATED FOR AUTOPRICING.\nSERVICE CHARGE FOR UNACCOMPANIED CHILD ON DIRECT\nFLIGHTS\nOTHERWISE\nUNN/UNACCOMPANIED CHILD PSGR 5-14 - CHARGE 100\nPERCENT OF THE FARE PLUS EUR 100.00.\nTICKET DESIGNATOR - UM0.\nNOTE - TEXT BELOW NOT VALIDATED FOR AUTOPRICING.\nSERVICE CHARGE FOR UNACCOMPANIED CHILD ON\nINDIRECT FLIGHTS<br/><br/><h3>20 TOUR CONDUCTOR DISCOUNTS</h3>NO DISCOUNTS FOR TOUR CONDUCTORS.<br/><br/><h3>21 AGENT DISCOUNTS</h3>NO DISCOUNTS FOR SALE AGENTS.<br/><br/><h3>22 ALL OTHER DISCOUNTS</h3>NO DISCOUNTS FOR OTHERS.<br/><br/><h3>23 MISCELLANEOUS PROVISIONS</h3>THIS FARE MAY BE USED TO CONSTRUCT UNPUBLISHED FARES.\nTHIS FARE MUST NOT BE USED AS THROUGH FARE WITH A\nDIFFERENTIAL AND/OR TO CALCULATE DIFFERENTIAL.\nNOTE - TEXT BELOW NOT VALIDATED FOR AUTOPRICING.\nTHE FARE THAT APPLIES ON THE DATE OF PURCHASE\nIS ONLY VALID FOR THE ENTIRE ITINERARY AND THE\nSPECIFIC TRAVEL DATES MENTIONED ON THE TICKET.\nANY MODIFICATION MAY REQUIRE THE PAYMENT OF AN\nADDITIONAL AMOUNT.\nFULL AND SEQUENTIAL USE OF FLIGHT COUPONS-\nTHE TICKET/ OR ELECTRONIC TICKET / IS NOT VALID IF\nTHE FIRST COUPON HAS NOT BEEN USED AND WILL NOT\nBE HONORED IF ALL THE COUPONS ARE NOT USED IN THE\nSEQUENCE PROVIDED IN THE TICKET / OR ELECTRONIC\nTICKET /\nIN THIS CASE THE FARE MUST BE RECALCULATED BASED\nON THE FARE THAT WAS VALID ON THE DAY OF ORIGINAL\nTICKET ISSUE AND IN THE ORIGINAL BOOKING CLASS.\nREISSUING FEES MAY BE COLLECTED DEPENDING ON THE\nCONDITIONS OF THE FARE.<br/><br/><h3>25 FARE BY RULE</h3>NOT APPLICABLE.<br/><br/><h3>26 GROUPS</h3>NO GROUP PROVISIONS APPLY.<br/><br/><h3>27 TOURS</h3>NO TOUR PROVISIONS APPLY.<br/><br/><h3>28 VISIT ANOTHER COUNTRY</h3>NO VISIT ANOTHER COUNTRY PROVISIONS APPLY.<br/><br/><h3>29 DEPOSITS</h3>NO DEPOSIT PROVISIONS APPLY.<br/><br/><h3>31 VOLUNTARY CHANGES</h3>ENTER RD*31 OR RD\u0087LINE NUM\u0087*31 FOR VOLUNTARY CHGS.<br/><br/><h3>33 VOLUNTARY REFUNDS</h3>NO VOLUNTARY REFUNDS DATA FOUND.<br/><br/><h3>35 NEGOTIATED FARES</h3>NOT APPLICABLE.<br/><br/><h3>IC INTERNATIONAL CONSTRUCTION</h3>NOT A CONSTRUCTED FARE<br/><br/>"
    ],
    "schedules": {
      "departure": [
        {
          "ac": "KL",
          "food": true,
          "tax": false,
          "baggage": "1 Piece",
          "durasi": "1260",
          "Flights": [
            {
              "ac": "GA",
              "FlightNo": "GA818",
              "STD": "CGK",
              "STA": "KUL",
              "ETD": "2017-05-23 16:40",
              "ETA": "2017-05-23 19:45"
            },
            {
              "ac": "KL",
              "FlightNo": "KL810",
              "STD": "KUL",
              "STA": "AMS",
              "ETD": "2017-05-23 23:20",
              "ETA": "2017-05-24 06:00"
            },
            {
              "ac": "KL",
              "FlightNo": "KL1001",
              "STD": "AMS",
              "STA": "LHR",
              "ETD": "2017-05-24 07:20",
              "ETA": "2017-05-24 07:40"
            }
          ],
          "Fares": [
            {
              "seatAvl": "9",
              "price": "14600376",
              "selectedIDdep": "4831464"
            }
          ]
        }
      ]
    }
  }
}
                </code>
            </pre>
    </div>
    <div class="tab-pane fade" id="resAirFare2" role="tabpanel">
            <pre class="code-toolbar" style="height: 500px">
                <code class="language-markup">
---------------------------------------- ERROR PARAMETER ------------------------------------------
{
    "status": {
        "code": 400,
        "confirm": "failed",
        "message": [
            "Unknown airline code."
        ]
    },
    "details": {
        "error_code": "001",
        "error_msg": "Unknown airline code."
    }
}
------------------------------------------ ERROR TOKEN --------------------------------------------
{
    "status": {
        "code": 400,
        "confirm": "failed",
        "message": [
            "access_denied",
            "The resource owner or authorization server denied the request."
        ]
    }
}
                </code>
            </pre>
    </div>
    <div class="tab-pane fade" id="resAirFare3" role="tabpanel">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Parameter</th>
                <th>Keterangan</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
