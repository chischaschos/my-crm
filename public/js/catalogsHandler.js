function catalogsHandler() {

    catalogs.body = $('#catalogsChild .body');
    catalogs.init('pricelistCategory');

}

var catalogs = {

    body: null,

    /**
     * This function required a SERVICE with catalogId id previously defined and
     * a div or other element ready to hold the xslt result
     */
    init: function(catalog) {

        utils.startProcessbar();

        $.xslt({
            xmlUrl: SERVICE['catalogs']['view']['url'] + '/catalog/' + catalog,
            xslUrl: BASE_URL + '/xslt/table.xsl',
            xmlCache: false,
            xslCache: false,
            callback: function(text) {

                $.logger.info('Data transformed');
                $('#' + catalog).append(text);
                $('#' + catalog + ' table .encoded').each(function(index) {
                    $(this).html($(this).text());
                });
                $('#' + catalog + ' table').tablesorter();
                $('#pager').remove();
                eval('false||catalogs.' + catalog + 'Init()');

            }
        });

    },

    pricelistCategoryInit: function() {

        catalogs.body.find('#pricelistCategory').find('img').tooltip().end()
        .find('.actions').each(function (index) {

            var element = $(this);
            var elementId = element.find('#plcId');

            element.find('#delete').click(function() {

                $.createWindow({
                    id: 'deleteConfirm',
                    type:'confirm',
                    body: '¿En verdad deseas borrar la categoria?'
                });

                var deleteConfirm = $('#deleteConfirm');
                deleteConfirm.find('.accept').click(function(){

                    utils.startProcessbar();
                    deleteConfirm.jqmHide();

                    $.post(SERVICE['catalogs']['delete']['url'],{
                        id:elementId.val(),
                        catalog: 'pricelistCategory'
                    },function(response){

                        $.logger.info('Delete response: ', response);
                        element.parent().remove();
                        $("#pricelistCategoryTable").trigger("update");
                        utils.stopProcessbar();

                    }, 'json');

                });

            });

            element.find('#edit').click(function() {

                utils.startProcessbar();

            });

        });
        
        /*
         * Following click function handles adding new pricelist categories
         */
        $('#showAddPricelistCategory').click(function() {

            /*
             * Following window has form cloned to avoid having two references to same form
             */
            var plcAddWindow = $.createWindow({
                title: 'Agregar categoria de lista de precios',
                body: $('#pricelistCategoryForm').clone(),
                controls: true
            });

            var pricelistCategoryForm = plcAddWindow.find('.body form');
            pricelistCategoryForm.attr('action', SERVICE['catalogs']['add']['url'] + '/catalog/pricelistCategory');
            pricelistCategoryForm.validate({
                rules: {
                    category_name: {
                        letterswithbasicpunc: true,
                        maxlength: 30,
                        required:true
                    },
                    description: {
                        letterswithbasicpunc: true,
                        maxlength: 100,
                        required: true
                    }
                },
                submitHandler: function() {
                
                    utils.startProcessbar();
                    pricelistCategoryForm.ajaxSubmit({
                        dataType: 'json',
                        success: function(response) {

                            $.logger.info('Form submission response' + response);

                            if ('ok' == response.status) {

                                plcAddWindow.jqmHide();
                                var newTR = $("#pricelistCategoryTable tr.hidden").clone();
                                newTR.find('.actions #id').val(response.message);
                                newTR.find('.categoryName').html(pricelistCategoryForm.find('#category_name').val());
                                newTR.find('.description').html(pricelistCategoryForm.find('#description').val());
                                newTR.removeClass('hidden');
                                
                                $("#pricelistCategoryTable tbody").append(newTR);
                                $("#pricelistCategoryTable").trigger("update");

                            } else {

                                plcAddWindow.find('.body').html(response.message);

                            }

                            utils.stopProcessbar();

                        }
                    });

                }
            }
            );

        });

    
    }


}
