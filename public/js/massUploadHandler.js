function massUploadHandler() {

    massUpload.form = $('#fileUploadForm');
    events.initButtons(massUpload.form);
    massUpload.form.tooltip({
        bodyHandler: function() {
            return 'Utiliza browse para buscar una lista contactos una vez seleccionada haz click en subir para buscar posibles contactos en ella';
        }
    });

    massUpload.form.validate({
        rules: {
            file: {
                required: true,
                fileType: true
            }
        },
        messages: {
            file: {
                required: 'Por favor selecciona un archivo'
            }
        }
    }); 

}

var massUpload = {

    form: null,

    progressUpdateHandler: function(data) {

        $.logger.info(data);

        if (parseInt(data.percent) == 0) {

            utils.startProcessbar();
            $.createWindow({
                id:'massuploadStatus',
                title: 'Carga en masa status',
                modal: false
            });
            $('#massuploadStatus .alert').hide();
            $('#massuploadStatus .body').html('<p class="success">Iniciando</p>');

        } else if (parseInt(data.percent) == 100) {

            massUpload.uploadResultHandler(data.text);

        } else {

            var newHTML = '<p class="success">' + data.text + '</p>';
            $('#massuploadStatus .body').append(newHTML);

        }

    },

    progressFinishHandler: function() {

        utils.stopProcessbar();
        $('#massuploadStatus').find('.alert').show();

    },

    uploadResultHandler: function(resultText) {

        utils.startProcessbar();
        massUpload.form.hide();
        $('#massuploadResult').show();

        $.xslt({
            xmlUrl: SERVICE['massUploadResult']['url'], 
            xslUrl: BASE_URL + '/xslt/table.xsl',
            xmlCache: false,
            xslCache: false,
            callback: function(text) {
                $.logger.info('Data transformed');
                $('#massuploadResult').html(text);
                $('#massuploadResult #updateResultTable .encoded').each(function(index) {
                    $(this).html($(this).text());
                });    
                $('#massuploadResult #updateResultTable')
                .tablesorter()
                .tablesorterPager({
                    container: $("#massuploadResult #pager"),
                    size: 10
                });

                massUpload.initResultHandlers();
            }
        });

    },

    initResultHandlers: function() {

        $.logger.info('initResultHandlers');
        $('.viewContact').tooltip().click(massUpload.showContactDetails);
        $('.viewSalesman').tooltip().click(massUpload.showSalesmanDetails);
        utils.stopProcessbar();
    },

    showContactDetails: function() {

        utils.startProcessbar();
        $.ajax({
            url: SERVICE['client']['view']['url'],
            data: {
                'clientId': this.id.replace(/client/,'')
            },
            cache: false,
            dataType: 'html',
            error: function() {
                utils.stopProcessbar();
            },
            success: function(data) {
                $.createWindow({
                    title: 'Detalle del contacto',
                    body: data
                });
                clientAdd.showControls();
                utils.stopProcessbar();
            }
        });
                        
    },

    showSalesmanDetails: function() {

        $.logger.info('Salesman id: ' + this.id);
        utils.startProcessbar();
        $.ajax({
            url: SERVICE['salesman']['view']['url'],
            data: {
                'salesmanId': this.id.replace(/salesman/,'')
            },
            cache: false,
            dataType: 'html',
            error: function() {
                utils.stopProcessbar();
            },
            success: function(data) {
                $.createWindow({
                    title: 'Detalle del cliente',
                    body: data
                });
                utils.stopProcessbar();
            }
        });
                         
    }

};
