(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	// $(function(){
	  	$("#create-duplicate-field").on('click', function(){
	    	var ele = $(this).closest('.question-type-radio').clone(true);
	    	$(this).closest('.question-type-radio').after(ele);
	  	});
	// });


	// $("#create-duplicate-field").click(function() {
	// 	alert("hi");
	// });


})( jQuery );


// Dynamically 'add' and 'remove' functionality
// var x = 0;
// var array = Array();

// function add_element_to_array() {
// 	array[x] = document.getElementById("options_as_answer").value;
// 	alert("Option: " + array[x] + " Added at index " + x);
// 	x++;
// 	document.getElementById("options_as_answer").value = "";

// 	display_array();

// 	inset_option_as_answer();
// }

// function display_array() {
//    var e = "<hr/>";

//    for (var y=0; y<array.length; y++)
//    {
//      e += "Option " + y + " = " + array[y] + "<br/>";
//    }
//    document.getElementById("Result").innerHTML = e;
// }


function insert_option_as_answer(id) {
		var ajaxUrl = ajax_object.url;
        var postId = id;
        var newOption = $("#options_as_answer").val();

		// alert(updatedOptions);
		// exit;

		jQuery.ajax({
        	type: 'post',
        	dataType: 'json',
            url: ajaxUrl,
            data: {
            	action : 'add_metadata_in_question',
            	postId : postId,
            	newOption : newOption
            },
            beforeSend : function() {
            	console.log("sending");
            	jQuery("#user-action-response").show();
            	jQuery("#user-action-response").html("Please wait...");
            },
            success : function(response) {
            	console.log(response);
            	jQuery("#user-action-response").show();
            	jQuery("#user-action-response").removeClass("alert-warning").addClass("alert-success");
            	jQuery("#user-action-response").html(response.msg);
            	setTimeout(function(){// wait for 5 secs(2)
				   location.reload(); // then reload the page.(3)
				}, 100);

            },
            error: function(xhr) { // if error occured
		        alert("Error occured.please try again");
		        jQuery("#user-action-response").append(xhr.statusText + xhr.responseText);
		    },
		    // complete: function() {
		    //     console.log("completed");
		    // },
        });


}


function delete_option_as_answer(object) {
		var ajaxUrl = ajax_object.url;
        var postId = $(object).attr("data-post-id");
        var metaValue = $(object).attr("data-meta-val");

		jQuery.ajax({
        	type: 'post',
        	dataType: 'json',
            url: ajaxUrl,
            data: {
            	action : 'remove_metadata_in_question',
            	postId : postId,
            	metaValue : metaValue
            },
            beforeSend : function() {
            	console.log("sending");
            	jQuery("#user-action-response").show();
            	jQuery("#user-action-response").html("Please wait...");
            },
            success : function(response) {
            	console.log(response);
            	jQuery("#user-action-response").show();
            	jQuery("#user-action-response").removeClass("alert-warning").addClass("alert-success");
            	jQuery("#user-action-response").html(response.msg);
            	setTimeout(function(){// wait for 5 secs(2)
				   location.reload(); // then reload the page.(3)
				}, 100);

            },
            error: function(xhr) { // if error occured
		        alert("Error occured.please try again");
		        jQuery("#user-action-response").append(xhr.statusText + xhr.responseText);
		    }
        });


}




