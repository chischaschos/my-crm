var events = {

    initMain: function() {

        $('a').click(function() {
                return false;
        });

        events.initButtons();

        /*
         * Attaches click event to all elements with class trigger
         */
        $('.trigger').click(function() {
                var $this = $(this);
                var dataType = ($this.hasClass('json'))? 'json' : 'html';
                service.call(this.id, dataType);
        });

    },

    initButtons: function(scope) {

        $('.button', scope).mouseover(function() {
            $(this).addClass('buttonOver');        
        }).mouseout(function() {
            $(this).removeClass('buttonOver');        
        });

    }

};
