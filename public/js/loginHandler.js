function loginHandler() {

    events.initButtons('#loginChild');

    $('#loginForm').validate({
        rules:{
            username: {
                required: true,
                alphanumeric: true,
                maxlength: 10
            },
            password: {
                required: true,
                alphanumeric: true,
                maxlength: 20
            }
        },
        submitHandler: function(form) {

            $(form).ajaxSubmit(function(response) {

                $.logger.info('Form submission response' + response);
                utils.initWorkarea();
                $.createWindow({
                    body: $.evalJSON(response).message
                });
                $(form).resetForm();
                
            });

        }
    });

    $('#loginForm #username').focus();

}
