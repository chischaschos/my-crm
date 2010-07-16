function clientSearchHomeHandler() {

    utils.startProcessbar();
    clientSearch.filterWindow = $('#clientSearchMenu').jqm();
    clientSearch.filterForm = clientSearch.filterWindow.find('form');

    clientSearch.filterForm.validate({
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
            },
            'contact[telephone]': {
                digits: true,
                maxlength: 30,
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
            clientSearch.search();

        }
    });

    clientSearch.search();

}

var clientSearch = {

    filterWindow: null,

    filterForm: null,

    search: function() {
    
        $.ajax({
            url: SERVICE['clientSearch']['url'],
            data: clientSearch.filterForm.serialize(),
            type: 'post',
            cache: false,
            success: function(result) {

                $.logger.info('success');
                $.logger.info(result);

                if ($(result).find('row').length > 0) {

                    clientSearch.transformResult(result);
                
                } else {
                
                    $.createWindow({ body: 'No se encontraron datos'});
                    utils.stopProcessbar();
                
                }

            },
            error: function(result) {

                $.logger.info('errors');
                $.logger.info(result);
                $.createWindow({ title: 'Error', 
                    body: 'Ocurrio un error interno, mismo que ya ha sido reportado al administrador. Por favor intenta mas tarde.'});

            }
        });
    
    },

    transformResult: function(searchXML) {

         $.xslt({
            //xmlUrl: SERVICE['clientSearch']['url'], 
            xml: searchXML, 
            xslUrl: BASE_URL + '/xslt/table.xsl',
            xmlCache: false,
            xslCache: false,
            callback: function(text) {

                $('#clientSearchResult').html(text);
                $('#clientSearchResult table .encoded').each(function(index) {
                    $(this).html($(this).text());
                });    
                $('#clientSearchResult table')
                    .tablesorter()
                    .tablesorterPager({container: $("#clientSearchResult #pager"), 
                        size: 12});
                clientSearch.initResult();

            }
        });
    
    },

    initResult: function() {
                
        $('#openSearchFilter').toggle(
            function() {clientSearch.filterWindow.jqmShow()},
            function() {clientSearch.filterWindow.jqmHide()}
        ).tooltip();

        massUpload.initResultHandlers();
   
    }

};
