jQuery('document').ready(function()
{
    /* validation */
    jQuery("#user-register-form").validate({
        rules:
        {
          "mail": {
            required: true,
            email: true,
            validate_email : true
          },
          "name": {
            required: true,
            minlength: 5,
            maxlength: 30
          },
          "pass[pass1]": {
            required: true,
            minlength: 5,
            maxlength: 10
          },
        },
        messages:
        {
          mail: "Enter a Valid Email",
        },
    });
    /* validation */

    jQuery.validator.addMethod("validate_email", function(value, element) { if (/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/ .test(value)) { return true; } else { return false; } }, "Please enter a valid Email.");
});
