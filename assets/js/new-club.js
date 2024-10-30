jQuery(document).ready(function ($) {

    // default fields for testing
    $("#club_name").val( "Glenrothes Golf Club" );
    $("#about_club").val("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean tempus eros eu urna consectetur volutpat. Duis vel diam sapien. In egestas nunc a ante euismod, a tincidunt risus aliquet. Praesent sed augue tempus tortor congue porttitor et id mauris. Praesent ut efficitur nisi, eget tincidunt velit. Fusce interdum ipsum vel ipsum imperdiet, at tempus lectus cursus. Duis eu metus vel velit tincidunt tempus. In eu orci sagittis, placerat leo sit amet, fermentum libero. Vestibulum cursus, dolor ac luctus egestas, dolor tellus viverra magna, a gravida turpis elit vitae urna. Curabitur bibendum metus nec purus congue, et suscipit leo scelerisque. Cras vel justo in enim fringilla rhoncus. Praesent molestie tellus purus, quis euismod diam vestibulum vel. Nullam vehicula odio sit amet leo placerat, ut sodales enim suscipit.");
    $("#address_1").val("20 Leather Mashies");
    $("#address_2").val("Over the Hill");
    $("#town_city").val("Edinburgh");
    $("#postcode").val("EH1 1PQ");
    $("#county").val("Midlothian");
    $("#country").val("United Kingdom");
    $("#gps").val("1.0098979 2.0987766");
    $("#phone").val("078956148645");
    $("#email").val("email@somewhere.com");
    $("#facebook").val("https://facebook.com");
    $("#twitter").val("https://twitter.com");
    $("#course-name").val("Glenrothes Course");
    $("#course_overview").val("Pretty good course with some good challenges");;
    $("#white-yards-total").val("4567");
    $("#white-par-total").val("72");
    $("#cr-white").val("122");
    $("#sr-white").val("134");

    $("#yellow-yards-total").val("4567");
    $("#yellow-par-total").val("72");
    $("#cr-yellow").val("122");
    $("#sr-yellow").val("134");

    $("#red-yards-total").val("4567");
    $("#red-par-total").val("72");
    $("#cr-red").val("122");
    $("#sr-red").val("134");

    $("#blue-yards-total").val("4567");
    $("#blue-par-total").val("72");
    $("#cr-blue").val("122");
    $("#sr-blue").val("134");

    $("#white-holename_1").val("The Caddies Bet");
    $("#white-yards_1").val("456");
    $("#white-par_1").val("4");
    $("#white-si_1").val("7");

    $("#white-holename_2").val("The Caddies Bet");
    $("#white-yards_2").val("456");
    $("#white-par_2").val("4");
    $("#white-si_2").val("7");

    $("#white-holename_3").val("The Caddies Bet");
    $("#white-yards_3").val("456");
    $("#white-par_3").val("4");
    $("#white-si_3").val("7");

    $("#white-holename_4").val("The Caddies Bet");
    $("#white-yards_4").val("456");
    $("#white-par_4").val("4");
    $("#white-si_4").val("7");

    $("#white-holename_5").val("The Caddies Bet");
    $("#white-yards_5").val("456");
    $("#white-par_5").val("4");
    $("#white-si_5").val("7");

    $("#white-holename_6").val("The Caddies Bet");
    $("#white-yards_6").val("456");
    $("#white-par_6").val("4");
    $("#white-si_6").val("7");

    $("#white-holename_7").val("The Caddies Bet");
    $("#white-yards_7").val("456");
    $("#white-par_7").val("4");
    $("#white-si_7").val("7");

    $("#white-holename_8").val("The Caddies Bet");
    $("#white-yards_8").val("456");
    $("#white-par_8").val("4");
    $("#white-si_8").val("7");

    $("#white-holename_9").val("The Caddies Bet");
    $("#white-yards_9").val("456");
    $("#white-par_9").val("4");
    $("#white-si_9").val("7");

    $("#white-holename_10").val("The Caddies Bet");
    $("#white-yards_10").val("456");
    $("#white-par_10").val("4");
    $("#white-si_10").val("7");

    $("#white-holename_11").val("The Caddies Bet");
    $("#white-yards_11").val("456");
    $("#white-par_11").val("4");
    $("#white-si_11").val("7");

    $("#white-holename_12").val("The Caddies Bet");
    $("#white-yards_12").val("456");
    $("#white-par_12").val("4");
    $("#white-si_12").val("7");

    $("#white-holename_13").val("The Caddies Bet");
    $("#white-yards_13").val("456");
    $("#white-par_13").val("4");
    $("#white-si_13").val("7");

    $("#white-holename_14").val("The Caddies Bet");
    $("#white-yards_14").val("456");
    $("#white-par_14").val("4");
    $("#white-si_14").val("7");

    $("#white-holename_15").val("The Caddies Bet");
    $("#white-yards_15").val("456");
    $("#white-par_15").val("4");
    $("#white-si_15").val("7");

    $("#white-holename_16").val("The Caddies Bet");
    $("#white-yards_16").val("456");
    $("#white-par_16").val("4");
    $("#white-si_16").val("7");

    $("#white-holename_17").val("The Caddies Bet");
    $("#white-yards_17").val("456");
    $("#white-par_17").val("4");
    $("#white-si_17").val("7");

    $("#white-holename_18").val("The Caddies Bet");
    $("#white-yards_18").val("456");
    $("#white-par_18").val("4");
    $("#white-si_18").val("7");

    $("#yellow-holename_1").val("The Caddies Bet");
    $("#yellow-yards_1").val("456");
    $("#yellow-par_1").val("4");
    $("#yellow-si_1").val("7");

    $("#yellow-holename_2").val("The Caddies Bet");
    $("#yellow-yards_2").val("456");
    $("#yellow-par_2").val("4");
    $("#yellow-si_2").val("7");

    $("#yellow-holename_3").val("The Caddies Bet");
    $("#yellow-yards_3").val("456");
    $("#yellow-par_3").val("4");
    $("#yellow-si_3").val("7");

    $("#yellow-holename_4").val("The Caddies Bet");
    $("#yellow-yards_4").val("456");
    $("#yellow-par_4").val("4");
    $("#yellow-si_4").val("7");

    $("#yellow-holename_5").val("The Caddies Bet");
    $("#yellow-yards_5").val("456");
    $("#yellow-par_5").val("4");
    $("#yellow-si_5").val("7");

    $("#yellow-holename_6").val("The Caddies Bet");
    $("#yellow-yards_6").val("456");
    $("#yellow-par_6").val("4");
    $("#yellow-si_6").val("7");

    $("#yellow-holename_7").val("The Caddies Bet");
    $("#yellow-yards_7").val("456");
    $("#yellow-par_7").val("4");
    $("#yellow-si_7").val("7");

    $("#yellow-holename_8").val("The Caddies Bet");
    $("#yellow-yards_8").val("456");
    $("#yellow-par_8").val("4");
    $("#yellow-si_8").val("7");

    $("#yellow-holename_9").val("The Caddies Bet");
    $("#yellow-yards_9").val("456");
    $("#yellow-par_9").val("4");
    $("#yellow-si_9").val("7");

    $("#yellow-holename_10").val("The Caddies Bet");
    $("#yellow-yards_10").val("456");
    $("#yellow-par_10").val("4");
    $("#yellow-si_10").val("7");

    $("#yellow-holename_11").val("The Caddies Bet");
    $("#yellow-yards_11").val("456");
    $("#yellow-par_11").val("4");
    $("#yellow-si_11").val("7");


    $("#yellow-holename_12").val("The Caddies Bet");
    $("#yellow-yards_12").val("456");
    $("#yellow-par_12").val("4");
    $("#yellow-si_12").val("7");

    $("#yellow-holename_13").val("The Caddies Bet");
    $("#yellow-yards_13").val("456");
    $("#yellow-par_13").val("4");
    $("#yellow-si_13").val("7");

    $("#yellow-holename_14").val("The Caddies Bet");
    $("#yellow-yards_14").val("456");
    $("#yellow-par_14").val("4");
    $("#yellow-si_14").val("7");

    $("#yellow-holename_15").val("The Caddies Bet");
    $("#yellow-yards_15").val("456");
    $("#yellow-par_15").val("4");
    $("#yellow-si_15").val("7");

    $("#yellow-holename_16").val("The Caddies Bet");
    $("#yellow-yards_16").val("456");
    $("#yellow-par_16").val("4");
    $("#yellow-si_16").val("7");

    $("#yellow-holename_17").val("The Caddies Bet");
    $("#yellow-yards_17").val("456");
    $("#yellow-par_17").val("4");
    $("#yellow-si_17").val("7");

    $("#yellow-holename_18").val("The Caddies Bet");
    $("#yellow-yards_18").val("456");
    $("#yellow-par_18").val("4");
    $("#yellow-si_18").val("7");

    $("#red-holename_1").val("The Caddies Bet");
    $("#red-yards_1").val("456");
    $("#red-par_1").val("4");
    $("#red-si_1").val("7");

    $("#red-holename_2").val("The Caddies Bet");
    $("#red-yards_2").val("456");
    $("#red-par_2").val("4");
    $("#red-si_2").val("7");

    $("#red-holename_3").val("The Caddies Bet");
    $("#red-yards_3").val("456");
    $("#red-par_3").val("4");
    $("#red-si_3").val("7");

    $("#red-holename_4").val("The Caddies Bet");
    $("#red-yards_4").val("456");
    $("#red-par_4").val("4");
    $("#red-si_4").val("7");

    $("#red-holename_5").val("The Caddies Bet");
    $("#red-yards_5").val("456");
    $("#red-par_5").val("4");
    $("#red-si_5").val("7");

    $("#red-holename_6").val("The Caddies Bet");
    $("#red-yards_6").val("456");
    $("#red-par_6").val("4");
    $("#red-si_6").val("7");

    $("#red-holename_7").val("The Caddies Bet");
    $("#red-yards_7").val("456");
    $("#red-par_7").val("4");
    $("#red-si_7").val("7");

    $("#red-holename_8").val("The Caddies Bet");
    $("#red-yards_8").val("456");
    $("#red-par_8").val("4");
    $("#red-si_8").val("7");

    $("#red-holename_9").val("The Caddies Bet");
    $("#red-yards_9").val("456");
    $("#red-par_9").val("4");
    $("#red-si_9").val("7");

    $("#red-holename_10").val("The Caddies Bet");
    $("#red-yards_10").val("456");
    $("#red-par_10").val("4");
    $("#red-si_10").val("7");

    $("#red-holename_11").val("The Caddies Bet");
    $("#red-yards_11").val("456");
    $("#red-par_11").val("4");
    $("#red-si_11").val("7");

    $("#red-holename_12").val("The Caddies Bet");
    $("#red-yards_12").val("456");
    $("#red-par_12").val("4");
    $("#red-si_12").val("7");

    $("#red-holename_13").val("The Caddies Bet");
    $("#red-yards_13").val("456");
    $("#red-par_13").val("4");
    $("#red-si_13").val("7");

    $("#red-holename_14").val("The Caddies Bet");
    $("#red-yards_14").val("456");
    $("#red-par_14").val("4");
    $("#red-si_14").val("7");

    $("#red-holename_15").val("The Caddies Bet");
    $("#red-yards_15").val("456");
    $("#red-par_15").val("4");
    $("#red-si_15").val("7");

    $("#red-holename_16").val("The Caddies Bet");
    $("#red-yards_16").val("456");
    $("#red-par_16").val("4");
    $("#red-si_16").val("7");

    $("#red-holename_17").val("The Caddies Bet");
    $("#red-yards_17").val("456");
    $("#red-par_17").val("4");
    $("#red-si_17").val("7");

    $("#red-holename_18").val("The Caddies Bet");
    $("#red-yards_18").val("456");
    $("#red-par_18").val("4");
    $("#red-si_18").val("7");

    $("#blue-holename_1").val("The Caddies Bet");
    $("#blue-yards_1").val("456");
    $("#blue-par_1").val("4");
    $("#blue-si_1").val("7");

    $("#blue-holename_2").val("The Caddies Bet");
    $("#blue-yards_2").val("456");
    $("#blue-par_2").val("4");
    $("#blue-si_2").val("7");

    $("#blue-holename_3").val("The Caddies Bet");
    $("#blue-yards_3").val("456");
    $("#blue-par_3").val("4");
    $("#blue-si_3").val("7");

    $("#blue-holename_4").val("The Caddies Bet");
    $("#blue-yards_4").val("456");
    $("#blue-par_4").val("4");
    $("#blue-si_4").val("7");

    $("#blue-holename_5").val("The Caddies Bet");
    $("#blue-yards_5").val("456");
    $("#blue-par_5").val("4");
    $("#blue-si_5").val("7");

    $("#blue-holename_6").val("The Caddies Bet");
    $("#blue-yards_6").val("456");
    $("#blue-par_6").val("4");
    $("#blue-si_6").val("7");

    $("#blue-holename_7").val("The Caddies Bet");
    $("#blue-yards_7").val("456");
    $("#blue-par_7").val("4");
    $("#blue-si_7").val("7");

    $("#blue-holename_8").val("The Caddies Bet");
    $("#blue-yards_8").val("456");
    $("#blue-par_8").val("4");
    $("#blue-si_8").val("7");

    $("#blue-holename_9").val("The Caddies Bet");
    $("#blue-yards_9").val("456");
    $("#blue-par_9").val("4");
    $("#blue-si_9").val("7");

    $("#blue-holename_10").val("The Caddies Bet");
    $("#blue-yards_10").val("456");
    $("#blue-par_10").val("4");
    $("#blue-si_10").val("7");

    $("#blue-holename_11").val("The Caddies Bet");
    $("#blue-yards_11").val("456");
    $("#blue-par_11").val("4");
    $("#blue-si_11").val("7");

    $("#blue-holename_12").val("The Caddies Bet");
    $("#blue-yards_12").val("456");
    $("#blue-par_12").val("4");
    $("#blue-si_12").val("7");

    $("#blue-holename_13").val("The Caddies Bet");
    $("#blue-yards_13").val("456");
    $("#blue-par_13").val("4");
    $("#blue-si_13").val("7");

    $("#blue-holename_14").val("The Caddies Bet");
    $("#blue-yards_14").val("456");
    $("#blue-par_14").val("4");
    $("#blue-si_14").val("7");

    $("#blue-holename_15").val("The Caddies Bet");
    $("#blue-yards_15").val("456");
    $("#blue-par_15").val("4");
    $("#blue-si_15").val("7");

    $("#blue-holename_16").val("The Caddies Bet");
    $("#blue-yards_16").val("456");
    $("#blue-par_16").val("4");
    $("#blue-si_16").val("7");

    $("#blue-holename_17").val("The Caddies Bet");
    $("#blue-yards_17").val("456");
    $("#blue-par_17").val("4");
    $("#blue-si_17").val("7");

    $("#blue-holename_18").val("The Caddies Bet");
    $("#blue-yards_18").val("456");
    $("#blue-par_18").val("4");
    $("#blue-si_18").val("7");

    
    // end default fields for testing

    $("#newclub-success").hide();
    $("#add-new-course").hide();

    $(".hole-wrap-white").hide();
    $(".hole-wrap-yellow").hide();
    $(".hole-wrap-red").hide();
    $(".hole-wrap-blue").hide();

    $("#more-details").change(function(){
        $(".hole-wrap-white").toggle();
        $(".hole-wrap-yellow").toggle();
        $(".hole-wrap-red").toggle();
        $(".hole-wrap-blue").toggle();
    });

    $("#number-holes").change(function(){

        ( $(".hide_row").toggle() );
        //$('input[id^="white_holename_"][id$="_10"], input[id^="white_holename_"][id$="_11"], input[id^="white_holename_"][id$="_12"], input[id^="white_holename_"][id$="_13"], input[id^="white_holename_"][id$="_14"], input[id^="white_holename_"][id$="_15"], input[id^="white_holename_"][id$="_16"], input[id^="white_holename_"][id$="_17"], input[id^="white_holename_"][id$="_18"]').toggle();

        // for (let i = 10; i <= 18; i++) {
        //     $(`input[id^="white_holename_"][id$="_{i}"]`).toggle(); 
        //   }

    });



    $('#golfclub_select').change(function() {
        if ($(this).find('option:selected').text() === 'Please Select') {
            // show add new club
            $("#add-new-club").show(); 
          } else {
            // hide add new club
            $("#add-new-club").hide(); 
          }
      });

      

      // Get reference to elements
        const $white_checkbox = $('#white-tees');
        const $white_div = $('.tee-container.white');

        // Toggle div on checkbox change
        $white_checkbox.change(function() {
        if(this.checked) {
            $white_div.show();
        } else {
            $white_div.hide();
        }
        });

        // On page load
        if($white_checkbox.prop('checked')) {
            $white_div.show();
        } else {
            $white_div.hide();  
        }
        
        
        const $yellow_checkbox = $('#yellow-tees');
        const $yellow_div = $('.tee-container.yellow');

        // Toggle div on checkbox change
        $yellow_checkbox.change(function() {
        if(this.checked) {
            $yellow_div.show();
        } else {
            $yellow_div.hide();
        }
        });

        // On page load
        if($yellow_checkbox.prop('checked')) {
            $yellow_div.show();
        } else {
            $yellow_div.hide();  
        }   

        const $red_checkbox = $('#red-tees');
        const $red_div = $('.tee-container.red');

        // Toggle div on checkbox change
        $red_checkbox.change(function() {
        if(this.checked) {
            $red_div.show();
        } else {
            $red_div.hide();
        }
        });

        // On page load
        if($red_checkbox.prop('checked')) {
            $red_div.show();
        } else {
            $red_div.hide();  
        } 
        
        const $blue_checkbox = $('#blue-tees');
        const $blue_div = $('.tee-container.blue');

        // Toggle div on checkbox change
        $blue_checkbox.change(function() {
        if(this.checked) {
            $blue_div.show();
        } else {
            $blue_div.hide();
        }
        });

        // On page load
        if($blue_checkbox.prop('checked')) {
            $blue_div.show();
        } else {
            $blue_div.hide();  
        }  
        
    
    $("#add-new-club").submit(function(e) {

        e.preventDefault();
        
        // const data = {};

        // $("#add-new-club").serializeArray().forEach(item => {
        // data[item.name] = item.value;
        // });
        //var formData = new FormData($("#add-new-club")[0]);
        var formData = $("#add-new-club").serialize();

        //console.log(formData);
        //console.log(my_ajax_obj);
        $.post(
            my_ajax_obj.ajax_url,{
            _ajax_nonce: my_ajax_obj.nonce,    
            action: "pwg_add_new_golfclub",
            formData: formData,   
            contentType: false,
            processData: false,
            dataType: 'json'
            },
            function(response) {
             if (response) {
                console.log(response);
                $("#newclub-success").html("<h1>Success</h1>").show();
                $("#add-new-club").hide();
                $("#club-heading").hide();
                
             }
            
            }
        );
        //console.log("ajaxurl" . my_ajax_obj.ajax_url);
        //console.log(my_ajax_obj);
        
    });


    var country = [
        "Afghanistan",
        "Aland Islands",
        "Albania",
        "Algeria",
        "American Samoa",
        "Andorra",
        "Angola",
        "Anguilla",
        "Antarctica",
        "Antigua and Barbuda",
        "Argentina",
        "Armenia",
        "Aruba",
        "Australia",
        "Austria",
        "Azerbaijan",
        "Bahamas",
        "Bahrain",
        "Bangladesh",
        "Barbados",
        "Belarus",
        "Belgium",
        "Belize",
        "Benin",
        "Bermuda",
        "Bhutan",
        "Bolivia",
        "Bonaire, Sint Eustatius and Saba",
        "Bosnia and Herzegovina",
        "Botswana",
        "Bouvet Island",
        "Brazil",
        "British Indian Ocean Territory",
        "Brunei Darussalam",
        "Bulgaria",
        "Burkina Faso",
        "Burundi",
        "Cambodia",
        "Cameroon",
        "Canada",
        "Cape Verde",
        "Cayman Islands",
        "Central African Republic",
        "Chad",
        "Chile",
        "China",
        "Christmas Island",
        "Cocos (Keeling) Islands",
        "Colombia",
        "Comoros",
        "Congo",
        "Congo, Democratic Republic of the Congo",
        "Cook Islands",
        "Costa Rica",
        "Cote D'Ivoire",
        "Croatia",
        "Cuba",
        "Curacao",
        "Cyprus",
        "Czech Republic",
        "Denmark",
        "Djibouti",
        "Dominica",
        "Dominican Republic",
        "Ecuador",
        "Egypt",
        "El Salvador",
        "Equatorial Guinea",
        "Eritrea",
        "Estonia",
        "Ethiopia",
        "Falkland Islands (Malvinas)",
        "Faroe Islands",
        "Fiji",
        "Finland",
        "France",
        "French Guiana",
        "French Polynesia",
        "French Southern Territories",
        "Gabon",
        "Gambia",
        "Georgia",
        "Germany",
        "Ghana",
        "Gibraltar",
        "Greenland",
        "Grenada",
        "Guadeloupe",
        "Guam",
        "Guatemala",
        "Guernsey",
        "Guinea",
        "Guinea-Bissau",
        "Guyana",
        "Haiti",
        "Heard Island and Mcdonald Islands",
        "Holy See (Vatican City State)",
        "Honduras",
        "Hong Kong",
        "Hungary",
        "Iceland",
        "India",
        "Indonesia",
        "Iran, Islamic Republic of",
        "Iraq",
        "Ireland",
        "Isle of Man",
        "Israel",
        "Italy",
        "Jamaica",
        "Japan",
        "Jersey",
        "Jordan",
        "Kazakhstan",
        "Kenya",
        "Kiribati",
        "Korea, Democratic People's Republic of",
        "Korea, Republic of",
        "Kosovo",
        "Kuwait",
        "Kyrgyzstan",
        "Lao People's Democratic Republic",
        "Latvia",
        "Lebanon",
        "Lesotho",
        "Liberia",
        "Libyan Arab Jamahiriya",
        "Liechtenstein",
        "Lithuania",
        "Luxembourg",
        "Macao",
        "Macedonia, the Former Yugoslav Republic of",
        "Madagascar",
        "Malawi",
        "Malaysia",
        "Maldives",
        "Mali",
        "Malta",
        "Marshall Islands",
        "Martinique",
        "Mauritania",
        "Mauritius",
        "Mayotte",
        "Mexico",
        "Micronesia, Federated States of",
        "Moldova, Republic of",
        "Monaco",
        "Mongolia",
        "Montenegro",
        "Montserrat",
        "Morocco",
        "Mozambique",
        "Myanmar",
        "Namibia",
        "Nauru",
        "Nepal",
        "Netherlands",
        "New Caledonia",
        "New Zealand",
        "Nicaragua",
        "Niger",
        "Nigeria",
        "Niue",
        "Norfolk Island",
        "Northern Mariana Islands",
        "Norway",
        "Oman",
        "Pakistan",
        "Palau",
        "Palestinian Territory, Occupied",
        "Panama",
        "Papua New Guinea",
        "Paraguay",
        "Peru",
        "Philippines",
        "Pitcairn",
        "Poland",
        "Portugal",
        "Puerto Rico",
        "Qatar",
        "Reunion",
        "Romania",
        "Russian Federation",
        "Rwanda",
        "Saint Barthelemy",
        "Saint Helena",
        "Saint Kitts and Nevis",
        "Saint Lucia",
        "Saint Martin",
        "Saint Pierre and Miquelon",
        "Saint Vincent and the Grenadines",
        "Samoa",
        "San Marino",
        "Sao Tome and Principe",
        "Saudi Arabia",
        "Senegal",
        "Serbia",
        "Serbia and Montenegro",
        "Seychelles",
        "Sierra Leone",
        "Singapore",
        "Sint Maarten",
        "Slovakia",
        "Slovenia",
        "Solomon Islands",
        "Somalia",
        "South Africa",
        "South Georgia and the South Sandwich Islands",
        "South Sudan",
        "Spain",
        "Sri Lanka",
        "Sudan",
        "Suriname",
        "Svalbard and Jan Mayen",
        "Swaziland",
        "Sweden",
        "Switzerland",
        "Syrian Arab Republic",
        "Taiwan, Province of China",
        "Tajikistan",
        "Tanzania, United Republic of",
        "Thailand",
        "Timor-Leste",
        "Togo",
        "Tokelau",
        "Tonga",
        "Trinidad and Tobago",
        "Tunisia",
        "Turkey",
        "Turkmenistan",
        "Turks and Caicos Islands",
        "Tuvalu",
        "Uganda",
        "Ukraine",
        "United Arab Emirates",
        "United Kingdom",
        "United States",
        "United States Minor Outlying Islands",
        "Uruguay",
        "Uzbekistan",
        "Vanuatu",
        "Venezuela",
        "Viet Nam",
        "Virgin Islands, British",
        "Virgin Islands, U.s.",
        "Wallis and Futuna",
        "Western Sahara",
        "Yemen",
        "Zambia",
        "Zimbabwe"
    ]
    $("#country").autocomplete({
        source:country
    });
});




// jQuery(document).ready(function ($) {

//     $("#newclub-success").hide();
//     $("#add-new-course").hide();
    
//     $("#add-new-club").submit(function(e) {

//         e.preventDefault();
        
//         // const data = {};

//         // $("#add-new-club").serializeArray().forEach(item => {
//         // data[item.name] = item.value;
//         // });
//         var formData = $("#add-new-club").serialize();

//         //console.log(formData);
//         //console.log(my_ajax_obj);
//         $.post(
//             my_ajax_obj.ajax_url,{
//             _ajax_nonce: my_ajax_obj.nonce,    
//             action: "pwg_add_new_golfclub",
//             formData: formData   
//             },
//             function(response) {
//              if (response) {
//                 console.log(response);
//                 $("#newclub-success").show();
//                 $("#add-new-club").hide();
//                 $("#add-new-course").show();
//              }
            
//             }
//         );
//         //console.log("ajaxurl" . my_ajax_obj.ajax_url);
//         //console.log(my_ajax_obj);
        
//     });
// });

