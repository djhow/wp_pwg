
        
            <h3 id="club-heading">
                Golf Club Details
            </h3>
            <div id="newclub-success">Something went wrong</div>
        <div class="">
            <?php

                    $clubs = get_posts( array(
                        'post_type' => 'golfclub',
                        'numberposts' => -1
                    ) );
                    echo '<div class="form-inputs"><h4>Check to see if we already have your club</h4>';
                    echo '<select name="golfclub_select" id="golfclub_select">';
                    echo '<option value="0">Please Select</option>';
                    $userID = get_current_user_id();
                    foreach ( $clubs as $club ) {
                        //$selected = get_the_author_meta( 'golfclub', $userID) == $club->ID ? 'selected' : '';
                        $selected = 0;
                        echo '<option value="' . esc_attr( $club->ID ) . '" ' . $selected . '>' . esc_html( $club->post_title ) . '</option>';
                    }

                    echo '</select></div>';

            ?>
            <form id="add-new-club" name="add-new-club" method="post">
                <div class="form-inputs">
                    <label for="club_name">Club Name</label>
                    <input type="text" name="club_name" id="club_name" placeholder="Enter the club name" required>
                    <label for="homeclub">This is my Home Club</label>
                    <input type="checkbox" name="homeclub" id="homeclub">
                </div>
                <div class="form-inputs">
                    <label for="about_club">About the Club</label>
                    <textarea name="about_club" id="about_club" cols="30" rows="3" placeholder="Enter a description of the club"></textarea>
                </div>
                <div class="form-inputs">
                    <label for="address_1">Address</label>
                    <input type="text" name="address_1" id="address_1" placeholder="Enter first line of address" required>
                </div>
                <div class="form-inputs">
                    <label for="address_2">Address</label>
                    <input type="text" name="address_2" id="address_2" placeholder="Enter second line of address">
                </div>
                <div class="form-inputs">
                    <label for="town_city">Town/City</label>
                    <input type="text" name="town_city" id="town_city" placeholder="Enter town or city" required>
                </div>
                <div class="form-inputs">
                    <label for="postcode">Postcode/Zip</label>
                    <input type="text" name="postcode" id="postcode" placeholder="Enter the postcode/zip" required>
                </div>
                <div class="form-inputs">
                    <label for="county">County</label>
                    <select name="county">
                        <option value="aberdeenshire">Aberdeenshire</option>
                        <option value="angus">Angus</option>  
                        <option value="argyll-and-bute">Argyll and Bute</option>
                        <option value="clackmannanshire">Clackmannanshire</option>  
                        <option value="dumfries-and-galloway">Dumfries and Galloway</option>
                        <option value="dundee-city">Dundee City</option>
                        <option value="east-ayrshire">East Ayrshire</option>
                        <option value="east-dunbartonshire">East Dunbartonshire</option>
                        <option value="east-lothian">East Lothian</option>
                        <option value="east-renfrewshire">East Renfrewshire</option>
                        <option value="edinburgh-city">Edinburgh City</option>
                        <option value="na-h-eileanan-siar">Na h-Eileanan Siar</option>
                        <option value="falkirk">Falkirk</option>
                        <option value="fife">Fife</option>
                        <option value="glasgow-city">Glasgow City</option>
                        <option value="highland">Highland</option>
                        <option value="inverclyde">Inverclyde</option>
                        <option value="midlothian">Midlothian</option>
                        <option value="moray">Moray</option>
                        <option value="north-ayrshire">North Ayrshire</option>
                        <option value="north-lanarkshire">North Lanarkshire</option>
                        <option value="orkney-islands">Orkney Islands</option>
                        <option value="perth-and-kinross">Perth and Kinross</option>
                        <option value="renfrewshire">Renfrewshire</option>
                        <option value="scottish-borders">Scottish Borders</option>
                        <option value="shetland-islands">Shetland Islands</option>
                        <option value="south-ayrshire">South Ayrshire</option>
                        <option value="south-lanarkshire">South Lanarkshire</option>
                        <option value="stirling">Stirling</option>
                        <option value="west-dunbartonshire">West Dunbartonshire</option>
                        <option value="west-lothian">West Lothian</option>
                        </select>

                </div>
                <div class="form-inputs">
                    <label for="country">Country</label>       
                    <select id="country" name="country" class="form-control">
                        <option value="">Please Select</option>
                        <option value="Afghanistan">Afghanistan</option>
                        <option value="Åland Islands">Åland Islands</option>
                        <option value="Albania">Albania</option>
                        <option value="Algeria">Algeria</option>
                        <option value="American Samoa">American Samoa</option>
                        <option value="Andorra">Andorra</option>
                        <option value="Angola">Angola</option>
                        <option value="Anguilla">Anguilla</option>
                        <option value="Antarctica">Antarctica</option>
                        <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                        <option value="Argentina">Argentina</option>
                        <option value="Armenia">Armenia</option>
                        <option value="Aruba">Aruba</option>
                        <option value="Australia">Australia</option>
                        <option value="Austria">Austria</option>
                        <option value="Azerbaijan">Azerbaijan</option>
                        <option value="Bahamas">Bahamas</option>
                        <option value="Bahrain">Bahrain</option>
                        <option value="Bangladesh">Bangladesh</option>
                        <option value="Barbados">Barbados</option>
                        <option value="Belarus">Belarus</option>
                        <option value="Belgium">Belgium</option>
                        <option value="Belize">Belize</option>
                        <option value="Benin">Benin</option>
                        <option value="Bermuda">Bermuda</option>
                        <option value="Bhutan">Bhutan</option>
                        <option value="Bolivia">Bolivia</option>
                        <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                        <option value="Botswana">Botswana</option>
                        <option value="Bouvet Island">Bouvet Island</option>
                        <option value="Brazil">Brazil</option>
                        <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                        <option value="Brunei Darussalam">Brunei Darussalam</option>
                        <option value="Bulgaria">Bulgaria</option>
                        <option value="Burkina Faso">Burkina Faso</option>
                        <option value="Burundi">Burundi</option>
                        <option value="Cambodia">Cambodia</option>
                        <option value="Cameroon">Cameroon</option>
                        <option value="Canada">Canada</option>
                        <option value="Cape Verde">Cape Verde</option>
                        <option value="Cayman Islands">Cayman Islands</option>
                        <option value="Central African Republic">Central African Republic</option>
                        <option value="Chad">Chad</option>
                        <option value="Chile">Chile</option>
                        <option value="China">China</option>
                        <option value="Christmas Island">Christmas Island</option>
                        <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
                        <option value="Colombia">Colombia</option>
                        <option value="Comoros">Comoros</option>
                        <option value="Congo">Congo</option>
                        <option value="Congo, The Democratic Republic of The">Congo, The Democratic Republic of The</option>
                        <option value="Cook Islands">Cook Islands</option>
                        <option value="Costa Rica">Costa Rica</option>
                        <option value="Cote D'ivoire">Cote D'ivoire</option>
                        <option value="Croatia">Croatia</option>
                        <option value="Cuba">Cuba</option>
                        <option value="Cyprus">Cyprus</option>
                        <option value="Czech Republic">Czech Republic</option>
                        <option value="Denmark">Denmark</option>
                        <option value="Djibouti">Djibouti</option>
                        <option value="Dominica">Dominica</option>
                        <option value="Dominican Republic">Dominican Republic</option>
                        <option value="Ecuador">Ecuador</option>
                        <option value="Egypt">Egypt</option>
                        <option value="El Salvador">El Salvador</option>
                        <option value="Equatorial Guinea">Equatorial Guinea</option>
                        <option value="Eritrea">Eritrea</option>
                        <option value="Estonia">Estonia</option>
                        <option value="Ethiopia">Ethiopia</option>
                        <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
                        <option value="Faroe Islands">Faroe Islands</option>
                        <option value="Fiji">Fiji</option>
                        <option value="Finland">Finland</option>
                        <option value="France">France</option>
                        <option value="French Guiana">French Guiana</option>
                        <option value="French Polynesia">French Polynesia</option>
                        <option value="French Southern Territories">French Southern Territories</option>
                        <option value="Gabon">Gabon</option>
                        <option value="Gambia">Gambia</option>
                        <option value="Georgia">Georgia</option>
                        <option value="Germany">Germany</option>
                        <option value="Ghana">Ghana</option>
                        <option value="Gibraltar">Gibraltar</option>
                        <option value="Greece">Greece</option>
                        <option value="Greenland">Greenland</option>
                        <option value="Grenada">Grenada</option>
                        <option value="Guadeloupe">Guadeloupe</option>
                        <option value="Guam">Guam</option>
                        <option value="Guatemala">Guatemala</option>
                        <option value="Guernsey">Guernsey</option>
                        <option value="Guinea">Guinea</option>
                        <option value="Guinea-bissau">Guinea-bissau</option>
                        <option value="Guyana">Guyana</option>
                        <option value="Haiti">Haiti</option>
                        <option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option>
                        <option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
                        <option value="Honduras">Honduras</option>
                        <option value="Hong Kong">Hong Kong</option>
                        <option value="Hungary">Hungary</option>
                        <option value="Iceland">Iceland</option>
                        <option value="India">India</option>
                        <option value="Indonesia">Indonesia</option>
                        <option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
                        <option value="Iraq">Iraq</option>
                        <option value="Ireland">Ireland</option>
                        <option value="Isle of Man">Isle of Man</option>
                        <option value="Israel">Israel</option>
                        <option value="Italy">Italy</option>
                        <option value="Jamaica">Jamaica</option>
                        <option value="Japan">Japan</option>
                        <option value="Jersey">Jersey</option>
                        <option value="Jordan">Jordan</option>
                        <option value="Kazakhstan">Kazakhstan</option>
                        <option value="Kenya">Kenya</option>
                        <option value="Kiribati">Kiribati</option>
                        <option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option>
                        <option value="Korea, Republic of">Korea, Republic of</option>
                        <option value="Kuwait">Kuwait</option>
                        <option value="Kyrgyzstan">Kyrgyzstan</option>
                        <option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
                        <option value="Latvia">Latvia</option>
                        <option value="Lebanon">Lebanon</option>
                        <option value="Lesotho">Lesotho</option>
                        <option value="Liberia">Liberia</option>
                        <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
                        <option value="Liechtenstein">Liechtenstein</option>
                        <option value="Lithuania">Lithuania</option>
                        <option value="Luxembourg">Luxembourg</option>
                        <option value="Macao">Macao</option>
                        <option value="Macedonia, The Former Yugoslav Republic of">Macedonia, The Former Yugoslav Republic of</option>
                        <option value="Madagascar">Madagascar</option>
                        <option value="Malawi">Malawi</option>
                        <option value="Malaysia">Malaysia</option>
                        <option value="Maldives">Maldives</option>
                        <option value="Mali">Mali</option>
                        <option value="Malta">Malta</option>
                        <option value="Marshall Islands">Marshall Islands</option>
                        <option value="Martinique">Martinique</option>
                        <option value="Mauritania">Mauritania</option>
                        <option value="Mauritius">Mauritius</option>
                        <option value="Mayotte">Mayotte</option>
                        <option value="Mexico">Mexico</option>
                        <option value="Micronesia, Federated States of">Micronesia, Federated States of</option>
                        <option value="Moldova, Republic of">Moldova, Republic of</option>
                        <option value="Monaco">Monaco</option>
                        <option value="Mongolia">Mongolia</option>
                        <option value="Montenegro">Montenegro</option>
                        <option value="Montserrat">Montserrat</option>
                        <option value="Morocco">Morocco</option>
                        <option value="Mozambique">Mozambique</option>
                        <option value="Myanmar">Myanmar</option>
                        <option value="Namibia">Namibia</option>
                        <option value="Nauru">Nauru</option>
                        <option value="Nepal">Nepal</option>
                        <option value="Netherlands">Netherlands</option>
                        <option value="Netherlands Antilles">Netherlands Antilles</option>
                        <option value="New Caledonia">New Caledonia</option>
                        <option value="New Zealand">New Zealand</option>
                        <option value="Nicaragua">Nicaragua</option>
                        <option value="Niger">Niger</option>
                        <option value="Nigeria">Nigeria</option>
                        <option value="Niue">Niue</option>
                        <option value="Norfolk Island">Norfolk Island</option>
                        <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                        <option value="Norway">Norway</option>
                        <option value="Oman">Oman</option>
                        <option value="Pakistan">Pakistan</option>
                        <option value="Palau">Palau</option>
                        <option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>
                        <option value="Panama">Panama</option>
                        <option value="Papua New Guinea">Papua New Guinea</option>
                        <option value="Paraguay">Paraguay</option>
                        <option value="Peru">Peru</option>
                        <option value="Philippines">Philippines</option>
                        <option value="Pitcairn">Pitcairn</option>
                        <option value="Poland">Poland</option>
                        <option value="Portugal">Portugal</option>
                        <option value="Puerto Rico">Puerto Rico</option>
                        <option value="Qatar">Qatar</option>
                        <option value="Reunion">Reunion</option>
                        <option value="Romania">Romania</option>
                        <option value="Russian Federation">Russian Federation</option>
                        <option value="Rwanda">Rwanda</option>
                        <option value="Saint Helena">Saint Helena</option>
                        <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                        <option value="Saint Lucia">Saint Lucia</option>
                        <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
                        <option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option>
                        <option value="Samoa">Samoa</option>
                        <option value="San Marino">San Marino</option>
                        <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                        <option value="Saudi Arabia">Saudi Arabia</option>
                        <option value="Senegal">Senegal</option>
                        <option value="Serbia">Serbia</option>
                        <option value="Seychelles">Seychelles</option>
                        <option value="Sierra Leone">Sierra Leone</option>
                        <option value="Singapore">Singapore</option>
                        <option value="Slovakia">Slovakia</option>
                        <option value="Slovenia">Slovenia</option>
                        <option value="Solomon Islands">Solomon Islands</option>
                        <option value="Somalia">Somalia</option>
                        <option value="South Africa">South Africa</option>
                        <option value="South Georgia and The South Sandwich Islands">South Georgia and The South Sandwich Islands</option>
                        <option value="Spain">Spain</option>
                        <option value="Sri Lanka">Sri Lanka</option>
                        <option value="Sudan">Sudan</option>
                        <option value="Suriname">Suriname</option>
                        <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
                        <option value="Swaziland">Swaziland</option>
                        <option value="Sweden">Sweden</option>
                        <option value="Switzerland">Switzerland</option>
                        <option value="Syrian Arab Republic">Syrian Arab Republic</option>
                        <option value="Taiwan">Taiwan</option>
                        <option value="Tajikistan">Tajikistan</option>
                        <option value="Tanzania, United Republic of">Tanzania, United Republic of</option>
                        <option value="Thailand">Thailand</option>
                        <option value="Timor-leste">Timor-leste</option>
                        <option value="Togo">Togo</option>
                        <option value="Tokelau">Tokelau</option>
                        <option value="Tonga">Tonga</option>
                        <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                        <option value="Tunisia">Tunisia</option>
                        <option value="Turkey">Turkey</option>
                        <option value="Turkmenistan">Turkmenistan</option>
                        <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                        <option value="Tuvalu">Tuvalu</option>
                        <option value="Uganda">Uganda</option>
                        <option value="Ukraine">Ukraine</option>
                        <option value="United Arab Emirates">United Arab Emirates</option>
                        <option value="United Kingdom">United Kingdom</option>
                        <option value="United States">United States</option>
                        <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
                        <option value="Uruguay">Uruguay</option>
                        <option value="Uzbekistan">Uzbekistan</option>
                        <option value="Vanuatu">Vanuatu</option>
                        <option value="Venezuela">Venezuela</option>
                        <option value="Viet Nam">Viet Nam</option>
                        <option value="Virgin Islands, British">Virgin Islands, British</option>
                        <option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
                        <option value="Wallis and Futuna">Wallis and Futuna</option>
                        <option value="Western Sahara">Western Sahara</option>
                        <option value="Yemen">Yemen</option>
                        <option value="Zambia">Zambia</option>
                        <option value="Zimbabwe">Zimbabwe</option>
                    </select>
                </div>
                <div class="form-inputs">
                    <label for="gps">GPS</label>
                    <input type="text" name="gps" id="gps" placeholder="Enter the gps co-ordinates">
                </div>
                <div class="form-inputs">
                    <label for="phone">Telephone</label>
                    <input type="text" name="phone" id="phone" placeholder="Enter the phone number" required>
                </div>
                <div class="form-inputs">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="Enter the club email" required>
                </div>
                <div class="form-inputs">
                    <label for="facebook">Facebook Page</label>
                    <input type="url" name="facebook" id="facebook" placeholder="Enter the club's Facebook page">
                </div>
                <div class="form-inputs">
                    <label for="twitter">Twitter</label>
                    <input type="url" name="twitter" id="twitter" placeholder="Enter the club's Twitter">
                </div>
                <div class="form-inputs">
                    <input type="submit" value="Submit Form">
                </div>
            </form>
        </div>
        <form id="add-new-course" name="add-new-course">
            <h3>
                Golf Course Details
            </h3>

            <div class="form-inputs">
                <label for="name">Course Name</label>
                <input type="text" name="name" id="name" placeholder="Name" value="">
            </div>
            <div class="form-inputs">
                <label for="course_overview">Course Overview</label>
                <textarea name="course_overview" id="course_overview" cols="30" rows="3" placeholder="Course Overview"></textarea>
            </div>
            <div class="form-inputs">
                <label for="red_yards_total">Red Yards Total</label>
                <input type="number" name="red_yards_total" id="red_yards_total" placeholder="Red Yards Total" value="">
            </div>
            <div class="form-inputs">
                <label for="yellow_yards_total">Yellow Yards Total</label>
                <input type="number" name="yellow_yards_total" id="yellow_yards_total" placeholder="Yellow Yards Total" value="">
            </div>
            <div class="form-inputs">
                <label for="white_yards_total">White Yards Total</label>
                <input type="number" name="white_yards_total" id="white_yards_total" placeholder="White Yards Total" value="">
            </div>
            <div class="form-inputs">
                <label for="blue_yards_total">Blue Yards Total</label>
                <input type="number" name="blue_yards_total" id="blue_yards_total" placeholder="Blue Yards Total" value="">
            </div>
            <div class="form-inputs">
                <label for="red_par_total">Red Par Total</label>
                <input type="number" name="red_par_total" id="red_par_total" placeholder="Red Par Total" value="">
            </div>
            <div class="form-inputs">
                <label for="yellow_par_total">Yellow Par Total</label>
                <input type="number" name="yellow_par_total" id="yellow_par_total" placeholder="Yellow Par Total" value="">
            </div>
            <div class="form-inputs">
                <label for="white_par_total">White Par Total</label>
                <input type="number" name="white_par_total" id="white_par_total" placeholder="White Par Total" value="">
            </div>
            <div class="form-inputs">
                <label for="blue_par_total">Blue Par Total</label>
                <input type="number" name="blue_par_total" id="blue_par_total" placeholder="Blue Par Total" value="">
            </div>
            <div class="form-inputs">
                <label for="cr_blue">Course Rating Blue</label>
                <input type="number" name="cr_blue" id="cr_blue" placeholder="CR Blue" value="">
            </div>
            <div class="form-inputs">
                <label for="sr_blue">Slope Rating Blue</label>
                <input type="number" name="sr_blue" id="sr_blue" placeholder="SR Blue" value="">
            </div>
            <div class="form-inputs">
                <label for="cr_white">Course Rating White</label>
                <input type="number" name="cr_white" id="cr_white" placeholder="CR White" value="">
            </div>
            <div class="form-inputs">
                <label for="sr_white">Slope Rating White</label>
                <input type="number" name="sr_white" id="sr_white" placeholder="SR White" value="">
            </div>
            <div class="form-inputs">
                <label for="cr_yellow">Course Rating Yellow</label>
                <input type="number" name="cr_yellow" id="cr_yellow" placeholder="CR Yellow" value="">
            </div>
            <div class="form-inputs">
                <label for="sr_yellow">Slope Rating Yellow</label>
                <input type="number" name="sr_yellow" id="sr_yellow" placeholder="SR Yellow" value="">
            </div>
            <div class="form-inputs">
                <label for="cr_red">Course Rating Red</label>
                <input type="number" name="cr_red" id="cr_red" placeholder="CR Red" value="">
            </div>
            <div class="form-inputs">
                <label for="sr_red">Slope Rating Red</label>
                <input type="number" name="sr_red" id="sr_red" placeholder="SR Red" value="">
            </div>
            <div class="form-inputs">
                <input type="submit" value="Submit Form">
            </div>
        </form>