function pricelistHandler() {

    pricelist.form = $('#fileUploadForm');
    events.initButtons(pricelist.form);
    pricelist.form.tooltip({
        bodyHandler: function() {
            return 'Utiliza browse para buscar una lista de precios una vez seleccionada haz click en subir para agregarla';
        }
    });

    pricelist.form.validate({
        rules: {
            file: {
                required: true
            //                ,
            //                fileType: true
            }
        },
        messages: {
            file: {
                required: 'Por favor selecciona un archivo'
            }
        }
    });

    pricelist.loadExistingPricelists();

}

var pricelist = {

    form: null,

    progressUpdateHandler: function(data) {

        $.logger.info(data);

        if (parseInt(data.percent) == 0) {

            utils.startProcessbar();

        }
        
    },

    progressFinishHandler: function() {

        $.logger.info('Finished');
        utils.stopProcessbar();
        pricelist.loadExistingPricelists();

    },

    loadExistingPricelists: function() {

        utils.startProcessbar();
        $.get(SERVICE['pricelist']['viewall']['url'], function(data) {

            $('#pricelistShow').html(data);
            pricelist.initControls();
            utils.stopProcessbar();
            
        });

    },

    initControls: function() {

        $('#pricelistShow .pricelist').each(function (index) {

            var pricelistElement = $(this);

            pricelistElement.find('#delete').click(function() {

                utils.startProcessbar();
                var pricelistId = pricelistElement.find('#pricelistId').val();

                $.post(SERVICE['pricelist']['delete']['url'], {
                    id: pricelistId
                },function(json) {

                    /*
                     * message contains the number of deleted rows
                     */
                    if (json.message > 0) {

                        pricelistElement.remove();

                    } else {

                    /*
                         * TODO and error has occured show an error message
                         */

                    }

                    utils.stopProcessbar();

                }, 'json');

            }).tooltip();

            pricelistElement.find('#edit').click(function(){

                var editWindow = $.createWindow({
                    title:'Editar detalle de lista de precios',
                    body: $('#pricelistForm').clone(),
                    type: 'confirm'
                });

                editWindow.css('width', '410px');

                var editWindowForm = editWindow.find('form');

                editWindow.find('.accept').val('Guardar').click(function() {
                    editWindowForm.trigger('submit');
                });

                /*
                 *Initialize edit window form with last div container values
                 */
                editWindowForm.find('#id').val(pricelistElement.find('#pricelistId').val());
                editWindowForm.find('#name').val(pricelistElement.find('.name').text());
                editWindowForm.find('#description').val(pricelistElement.find('.description').text());
                editWindowForm.find('#category')
                    .find('option:contains(\'' + pricelistElement.find('.category').text() + '\')')
                    .attr('selected', 'selected');

                editWindowForm.validate({
                    rules:{
                        name: {
                            /*
                             * TODO Change validation to support numbers - . ,
                             */
                            letterswithbasicpunc: true,
                            maxlength: 30
                        },
                        description:{
                            letterswithbasicpunc: true,
                            maxlength: 30
                        }
                    },
                    submitHandler: function() {

                        utils.startProcessbar();
                        editWindowForm.ajaxSubmit({
                            dataType: 'json',
                            success: function(response) {

                                $.logger.info('Form submission response' + response);

                                if ('ok' == response.status) {

                                    /*
                                     * Since the value was correctly edited we now update pricelist div
                                     * element with new values
                                     */
                                    pricelistElement.find('.name').html( response.message.name);
                                    pricelistElement.find('.description').html(response.message.description);
                                    pricelistElement.find('.category').html(editWindowForm.find('option:selected').text());
                                    pricelistElement.find('#categorytId').val(response.message.categoryId);
                                    editWindow.jqmHide();

                                } else {

                                    editWindow.find('.accept').hide();
                                    editWindow.find('.body').html(response.message);

                                }

                                utils.stopProcessbar();

                            }
                        });

                    }
                });

            }).tooltip();

            pricelistElement.find('#download').click(function() {

                var pricelistId = pricelistElement.find('#pricelistId').val();
                window.open(SERVICE['pricelist']['view']['url'] + '/id/' + pricelistId);

            }).tooltip();

        });

        events.initButtons('#pricelistShow');

    }

}
