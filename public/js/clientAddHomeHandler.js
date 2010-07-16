function clientAddHomeHandler() {

    utils.startProcessbar();
    events.initButtons('#clientAddHomeChild #messageArea');
    clientAdd.form = $('#clientAddForm');
    clientAdd.showControls(clientAdd.form);
    clientAdd.addManualSalesmanHandler();
    
    clientAdd.form.validate({
        rules: {
            'client[razon_social]': {
                letterswithbasicpunc: true,
                maxlength: 30
            },
            'client[representante_legal]': {
                letterswithbasicpunc: true,
                maxlength: 30
            },
            'client[nombre_comercial]': {
                letterswithbasicpunc: true,
                maxlength: 30
            },
            'client[rfc]': {
                letterswithbasicpunc: true,
                maxlength: 13
            },
            'client[giro_comercial]': {
                letterswithbasicpunc: true,
                maxlength: 30
            },
            'contact[first_name]': {
                letterswithbasicpunc: true,
                maxlength: 30
            },
            'contact[last_name]': {
                letterswithbasicpunc: true,
                maxlength: 30
            },
            'contact[email]': {
                email: true,
                maxlength: 50,
                required: '#contact-telephone:blank'
            },
            'contact[telephone]': {
                digits: true,
                maxlength: 30,
                required: '#contact-email:blank'
            },
            'contact[sal_assign_type]': {
                required: true
            }, 
            'contact[sales_group]': {
                required: true
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
        messages: {
            'contact[email]': 'Debes insertar al menos un email o telefono',
            'contact[telephone]': 'Debes insertar al menos un telefono o email'
        },
        submitHandler: function(form) {
        
            utils.startProcessbar();
            $.logger.info('Ready for submission');

            /*
             * We disable the salesman_select since it would conflict on the server side
             * because of it doesn't contain options and the way we validate the form
             */
            var salesmanSelect = clientAdd.form.find('#contact-salesman_select');
            salesmanSelect.attr('disabled', 'disabled');
            clientAdd.form.find('#contact-salesman').val(salesmanSelect.val());

            clientAdd.form.ajaxSubmit(function(response) {

                var jsonResponse = $.evalJSON(response);
                    console.log(jsonResponse)
                    console.log(jsonResponse.status)
                $.logger.info('Form submission response' + jsonResponse);

                if ('ok' == jsonResponse.status) {

                    $.createWindow({body: 'El cliente ha sido agregado'});
                    clientAdd.resetForm();
                    clientAdd.form.find('#contact-salesman_select').removeAttr('disabled');

                } else {

                    $.createWindow({body: 'Oops! ha ocurrido un error inesperado. Por favor intenta mas tarde.'});

                }

                utils.stopProcessbar();

            });

        }
    });

    $('#addClient').click(function() {
        clientAdd.form.submit();
    });

    utils.stopProcessbar();

}

var clientAdd = {

    form: null,

    showControls: function(displayForm) {

        if (!displayForm) {
            displayForm = $('#clientViewForm');
        }

        var displayFormControls = $('#displayFormControls');
        displayFormControls.append('<span>Ver datos de: </span>');

        displayForm.find('fieldset').each(function (index) {

            var currFieldset = $(this);
            var spanClass = "";

            if (index == 0) {
                spanClass = 'current';
                currFieldset.show();
            } else {
                currFieldset.hide();
            }   

            /* We only add controls */
            displayFormControls.append('<input type="button" fieldsetid="' 
                + currFieldset.attr('id') 
                + '" class="button buttonSizeMedium' 
                + spanClass + '" value="' 
                + currFieldset.find('legend').html() + '" />');

        });

        displayFormControls.find('input').click(function() {

            var currentObject = $(this);

            $('#displayFormControls input').each(function (index) {
            
                var eachObject = $(this);

                if (eachObject.attr('fieldsetid') == currentObject.attr('fieldsetid')) {
                    currentObject.addClass('current');
                    displayForm.find('#' + eachObject.attr('fieldsetid')).show();
                } else {
                    currentObject.removeClass('current');
                    displayForm.find('#' + eachObject.attr('fieldsetid')).hide();
                }

            });

        });    

        events.initButtons(displayFormControls);

    },

    addManualSalesmanHandler: function() {
    
        var salesmanSelect = $('#contact-salesman_select');
        var salesmanLabel = $('#salesman_select-label');
        salesmanSelect.hide();
        salesmanLabel.hide();

        var autoOption = $('#contact-sal_assign_type-auto');
        autoOption.click(function() {

            salesmanSelect.hide();
            salesmanLabel.hide();

        }).attr('checked', 'checked');

        var manuOption = $('#contact-sal_assign_type-manu');
        manuOption.click(function() {

            utils.startProcessbar();
            salesmanSelect.show();
            salesmanLabel.show();

            if (salesmanSelect.find('option').length == 0) {

                $.getJSON(SERVICE['salesman']['names']['url'], function(json) {

                    for (index in json) {

                        salesmanSelect.append('<option value="' + json[index].id + '">' + 
                            json[index].last_name + ', ' + json[index].first_name +
                            '</option>');

                    }

                    utils.stopProcessbar();

                });

            } else {
            
                utils.stopProcessbar();

            }

        });

    },

    resetForm: function() {
    
                   return;
        clientAdd.form.resetForm();
        $('#contact-salesman_select').hide();
        $('#salesman_select-label').hide();
        $('#contact-sal_assign_type-auto').attr('checked', 'checked');


    }

}
