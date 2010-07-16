function salesmanSearchHomeHandler() {

    utils.startProcessbar();
    salesmanSearch.filterWindow = $('#salesmanSearchMenu').jqm();
    salesmanSearch.filterForm = salesmanSearch.filterWindow.find('form');

    salesmanSearch.filterForm.validate({
        rules: {
            'salesman[first_name]': {
                letterswithbasicpunc: true,
                maxlength: 30
            },
            'salesman[last_name]': {
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
            salesmanSearch.search();

        }
    });

    salesmanSearch.search();

}

var salesmanSearch = {

    filterWindow: null,

    filterForm: null,

    search: function() {
    
        $.ajax({
            url: SERVICE['salesmanSearch']['url'],
            data: salesmanSearch.filterForm.serialize(),
            type: 'post',
            cache: false,
            success: function(result) {

                $.logger.info('success');
                $.logger.info(result);

                if ($(result).find('row').length > 0) {

                    salesmanSearch.transformResult(result);
                
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
            //xmlUrl: SERVICE['salesmanSearch']['url'], 
            xml: searchXML, 
            xslUrl: BASE_URL + '/xslt/table.xsl',
            xmlCache: false,
            xslCache: false,
            callback: function(text) {

                $('#salesmanSearchResult').html(text);
                $('#salesmanSearchResult table .encoded').each(function(index) {
                    $(this).html($(this).text());
                });    
                $('#salesmanSearchResult table')
                    .tablesorter()
                    .tablesorterPager({container: $("#salesmanSearchResult #pager"), 
                        size: 12});
                salesmanSearch.initResult();

            }
        });
    
    },

    initResult: function() {
                
        $('#openSearchFilter').toggle(
            function() {salesmanSearch.filterWindow.jqmShow()},
            function() {salesmanSearch.filterWindow.jqmHide()}
        ).tooltip();

        massUpload.initResultHandlers();
   
    }

};
