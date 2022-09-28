jQuery(document).ready(function ($) {

        //Insert Recod
        $('#forms').validate({
            rules: {
            user_role: {
               required: true
               },
            price: {
               required: true,
               number: true
               }  
             },
            submitHandler: function(form) {
                
               var user_role = $('.user_role').val();
               var price    = $('.price').val();
               var data = {
                    nonce: ajax.nonce,
                    action: 'price_management_save',
                    user_role: user_role,
                    price: price,
                };
                
                jQuery.ajax({
                type: "POST",
                url: ajax.url,
                data: data,
                beforeSend: function() {
                    
                },
                success: function(response){
                    //Success
                    //console.log(response);
                    jQuery('.save_price_management').after('<p class="msg">Data Save</p>');
                    setTimeout(function(){
                        jQuery(".msg").hide();
                    }, 2000);
                    location.reload();                 
                },
                error: function(XMLHttpRequest, textStatus, errorThrown){
                    //Error
                },
                timeout: 60000
            });
                return false;
            },
            // other options
        });


    // Display Data
	$( ".user_role" ).change(function() {

	    var user_role = $('.user_role').val();
	    var data = {
                    nonce: ajax.nonce,
                    action: 'price_management',
                    user_role: user_role,
            };
        jQuery.ajax({
            type: "POST",
            url: ajax.url,
            data: data,
            beforeSend: function() {
                jQuery("#user_role").attr("disabled", true);
                jQuery("#price").attr("disabled", true);
                jQuery("#btn").attr("disabled", true);  
            },
            success: function(response){
                //Success
                $('#price').val(response);
                jQuery("#user_role").attr("disabled", false);
                jQuery("#price").attr("disabled", false);
                jQuery("#btn").attr("disabled", false);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown){
                    //Error
            },
            timeout: 60000
        });
            return false;
	});

});