jQuery(document).ready(function ($) {

    $("#newclub-success").hide();
    $("#add-new-course").hide();

    $('#golfclub_select').change(function() {
        if ($(this).find('option:selected').text() === 'Please Select') {
            // show add new club
            $("#add-new-club").show(); 
          } else {
            // hide add new club
            $("#add-new-club").hide(); 
          }
      });
    
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
                $("#newclub-success").html(response).show();
                $("#add-new-club").hide();
                $("#club-heading").hide();
                $("#add-new-course").show();
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

