function salesmanAddHomeHandler() {

    utils.startProcessbar();
    salesmanAdd.form = $('#salesmanAddForm');
    events.initButtons(salesmanAdd.form);

    salesmanAdd.form.validate({
        rules: {
            'salesman[first_name]': {
                required: true,
                letterswithbasicpunc: true,
                maxlength: 30
            },
            'salesman[last_name]': {
                required: true,
                letterswithbasicpunc: true,
                maxlength: 30
            },
            'salesman[email]': {
                email: true,
                maxlength: 50
            },
            'salesman[telephone]': {
                digits: true,
                maxlength: 30
            },
            'address[entre_calles]': {
                letterswithbasicpunc: true,
                maxlength: 50
            },
            'address[colonia]': {
                letterswithbasicpunc: true,
                maxlength: 30
            },
            'address[delegacion_municipio]': {
                letterswithbasicpunc: true,
                maxlength: 30
            },
            'address[estado]': {
                letterswithbasicpunc: true,
                maxlength: 30
            },
            'address[country]': {
                letterswithbasicpunc: true,
                maxlength: 30
            },
            'address[codigo_postal]': {
                number: true,
                maxlength: 30
            }    
        },
        submitHandler: function(form) {

            utils.startProcessbar();
            $.logger.info('Ready for submission');

            salesmanAdd.form.ajaxSubmit(function(response) {

                var jsonResponse = $.evalJSON(response);
                    console.log(jsonResponse)
                    console.log(jsonResponse.status)
                $.logger.info('Form submission response' + jsonResponse);

                if ('ok' == jsonResponse.status) {

                    $.createWindow({body: 'El vendedor ha sido agregado'});
                    salesmanAdd.form.resetForm();

                } else {

                    $.createWindow({body: 'Oops! ha ocurrido un error inesperado. Por favor intenta mas tarde.'});

                }

                utils.stopProcessbar();

            });               
        }
    });    

}

var salesmanAdd = {

    form: null

}
