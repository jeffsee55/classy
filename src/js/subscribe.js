export default function() {
   $(document).ready(function() {

      // process the form
      $('#classy_subscribe').submit(function(event) {
         event.preventDefault();
         $('#classy_subscribe_button').attr('disabled', 'disabled');
         $('#classy_subscribe_button').val('sending');
         // get the form data
         // there are many ways to get this data using jQuery (you can use the class or id also)
         var formData = {
            'subscriber_email' : $('input[name=subscriber_email]').val(),
            'action' : $('input[name=action]').val(),
         };

         // process the form
         $.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url         : classy.ajaxUrl, // the url where we want to POST
            data        : formData, // our data object
            dataType    : 'json', // what type of data do we expect back from the server
            encode          : true
         })
         // using the done promise callback
         .done(function(response) {

            console.log(response.data);
            if(response.data.success == true) {
               $('.callout-error').remove();
               $('#classy_subscribe').replaceWith('<p>' + response.data.message + '</p>');
               return;
            }

            $('.callout-error').remove();
            $('.callout-text').append('<p class="callout-error" style="text-align: center;">' + response.data.message + '</p>');
            $('#classy_subscribe_email').val('');
            $('#classy_subscribe_button').attr('disabled', false);
            $('#classy_subscribe_button').val('try again');
         });

      });

   });
}
