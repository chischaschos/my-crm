var service = {

    /**
     * Calls services and handles theirs responses
     */
    call: function(serviceId, expectedDataType) {

        utils.startProcessbar();

        $.logger.info('Calling service id: ' + serviceId + ' ' + expectedDataType);
        var urlToCall = $('#' + serviceId).attr('href');
        
        /* 
         * Make calls only for items whose href attribute isn't empty
         */
        if (urlToCall.length > 0) {

            $.ajax({
                cache: false,
                dataType: expectedDataType,
                type: 'get',
                url: urlToCall,
                error: function() {
                    $.createWindow({
                        title: 'Error',
                        body: 'Ocurrio un error interno, mismo que ya ha sido reportado al administrador. Por favor intenta mas tarde.'
                    });
                    utils.stopProcessbar();
                },
                success: ('json' == expectedDataType)? service.receiveJSON: service.receiveHTML
            });

        }

    },

    receiveHTML: function(html) {

        $.logger.info('Receiving html');
        $.logger.info(html);

        /* TODO delete this temporal element once it doesn't work */
        var tmpElement = document.createElement('tmp');
        tmpElement.innerHTML = html;

        /* Get this new trigger id which by convention is the parent caller id plus 
         * 'Child' string, so caller id would be the new trigger id minus 'Child' string
         */
        $.logger.info($('.trigger', tmpElement));
        $.logger.info($('.trigger', tmpElement)[0].id);
        var callerId = $('.trigger', tmpElement)[0].id;
        callerId = callerId.replace(/Child/,'');
        $.logger.info('Caller id: ' + callerId);

        /* 
         * Replace content
         */
        $('#container').html(html);
        $('#container .subcontainer').show();

        /*
         * Call handler
         */
        if ($.isFunction(eval(callerId + 'Handler'))) {

            eval(callerId + 'Handler()');

        } else {

            $.logger.info('You do not have defined a javascript handler ' +
                'function for this just loaded menu, perhaps you would like ' +
                'to define a javascript file called ' + callerId + 'Handler.js ' +
                'and add a function called ' + callerId + 'Handler()'
                );

        }

        utils.stopProcessbar();

    },

    receiveJSON: function(json) {
       
        $.logger.info('Receiving json');
        $.logger.info(json);
        eval(json.caller + 'Handler(json)');
        utils.stopProcessbar();
        
    }

};

