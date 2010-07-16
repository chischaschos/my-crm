var REGISTRY = {
    cache: {},
    service: {
        current: {},
        registered: {}           
    }    
};

var utils = {

    initProcessbar: function() {
        var docHeight = $('body').outerHeight();
        var pbHeight = $('#processStatusContainer').outerHeight();
        var docWidth = $('body').outerWidth();
        var pbWidth = $('#processStatusContainer').outerWidth();
        $('#processStatusContainer').css({'top': (docHeight - pbHeight) / 2, 
                'left': (docWidth - pbWidth) / 2});
        REGISTRY.cache.progress = {max: 9, current: 0};
    },

    toogleProcessbar: function() {
        $('#processStatusContainer').toggle();
        utils.updateProcessbar();
    },

    startProcessbar: function() {
        $('#processStatusContainer').show();
        utils.updateProcessbar();
    },

    stopProcessbar: function() {
        $('#processStatusContainer').hide();
        utils.updateProcessbar();
    },

    updateProcessbar: function() {

        if ($('#processStatusContainer').is(':visible')) {

            setTimeout('utils.updateProcessbar()', 150);
            if (REGISTRY.cache.progress.current <= REGISTRY.cache.progress.max) {
                $('#processStatusContainer .process-status').append('.');
                REGISTRY.cache.progress.current++;
            } else {
                REGISTRY.cache.progress.current = 0;
                $('#processStatusContainer .process-status').html('.');
            }

        }

    },

    initWorkarea: function() {

        $('.menu-container').menu({callbacks: [events.initMain]});
        $('.workarea-container').html('');

    }

};

