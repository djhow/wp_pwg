jQuery(document).ready(function ($) {

    $("#toggle").on("click", function(){
      $(".toggle").toggle();
      if($(".toggle").is(":visible")) {
        $(this).text("Show Less Options"); 
      } else {    
        $(this).text("Show More Options");
      }
    })
    //$(".toggle").hide();
    



    // Autocomplete functionality
    $("#golfclub-search").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: ajaxurl,
                dataType: "json",
                data: {
                    action: "golfclub_search",
                    term: request.term,
                    security: $("#golfclub_search_nonce").val(),
                },
                success: function (data) {
                    response(data);
                },
            });
        },
        minLength: 2, // Minimum characters before making a search
    });



    

    // $("input").on("blur", function(){
    //   var this2 = this;
    //   $.post(ajaxurl, {      //POST request
    //     //_ajax_nonce: my_ajax_obj.nonce, //nonce
    //     action: "update_club",         //action
    //     title: this.value               //data
    //     }, function(data) {            //callback
    //       this2.nextSibling.remove(); //remove current title
    //       $(this2).after(data);       //insert server response
    //     }
    //   );
    // });

    // $(".pref").change(function() {          //event
    //   var this2 = this;                  //use in callback
    //   $.post(ajaxurl, {      //POST request
    //     _ajax_nonce: my_ajax_obj.nonce, //nonce
    //     action: "my_tag_count",         //action
    //     title: this.value               //data
    //     }, function(data) {            //callback
    //       this2.nextSibling.remove(); //remove current title
    //       $(this2).after(data);       //insert server response
    //     }
    //   );
    // } );

    // handling the insert/update golfclub
    // Select all input fields except submit button 
    // var $inputs = $("#edit_club :input").not(":submit");

    // // On blur of any input, update value via AJAX
    // $inputs.blur(function() {
      
    //   // Get field name and value
    //   var field = $(this).attr("name");
    //   var value = $(this).val();

    //   // If clubID is blank, this is an insert
    //   if($.trim($("#clubID").val() )=== "") {
        
    //     // Insert clubname to get ID
    //     if(field === "club_name") {
    //       $.post(
    //         ajaxurl, 
    //         {
    //           action: "insert_club",
    //           clubname: value
    //         },
    //         function(data) {
    //           $("#clubID").val(data);
    //         }
    //       );
    //     } 

    //   } else {
    //     //alert("update");
    //     // This is an update
    //     $.post(
    //       ajaxurl,
    //       {
    //         action: "update_club",
    //         id: $("#clubID").val(),
    //         field: field,
    //         value: value
    //       }
    //     );

    //   }

    // });




});

