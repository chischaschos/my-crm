(function (jQuery) {

    this.info = function (msg) {
        if (true == $.jCache.getItem('application').debug && 
            'undefined' != typeof(console)) {
            console.log("%o from %o", msg, this);
        }
        return this;
    };

    jQuery.logger = this;
    return jQuery;

})(jQuery);

(function (jQuery) {

    $.fn.menu = function(params) {

        var defaults = {
            action: 'init',
            callbacks: []
        };
        var options = $.extend(defaults, params);

        if ('init' == options.action) {

            return this.each(function() {

                var $this = $(this);
                $.get(SERVICE['menu']['url'], function(data) {
                    $this.html(data);
                    addBehavior();
            
                    for (index in options.callbacks) {
                        if ($.isFunction(options.callbacks[index])) {
                            eval('false ||' + options.callbacks[index] + '();');
                        }
                    }

                }, 'html');

            });
            
        }

    }

    var addBehavior = function() {
        
        $("ul.subnav").parent().append("<span></span>"); //Only shows drop down trigger when js is enabled (Adds empty span tag after ul.subnav*)

        $("ul.topnav li span").click(function() { //When trigger is clicked...

            //Following events are applied to the subnav itself (moving subnav up and down)
            $(this).parent().find("ul.subnav").slideDown('fast').show(); //Drop down the subnav on click

            $(this).parent().hover(function() {
                }, function(){
                    $(this).parent().find("ul.subnav").slideUp('slow'); //When the mouse hovers out of the subnav, move it back up
                });

        //Following events are applied to the trigger (Hover events for the trigger)
        }).hover(function() {
            $(this).addClass("subhover"); //On hover over, add class "subhover"
        }, function(){	//On Hover Out
            $(this).removeClass("subhover"); //On hover out, remove class "subhover"
        });

        var mainWidth = $('html').outerWidth(true);
        var menuWidth = $('ul.topnav').outerWidth(true);
        var leftMargin = (mainWidth - menuWidth)/2;
        $('ul.topnav').css('marginLeft', leftMargin);
    }
})(jQuery);

(function (jQuery) { 

    /**
     * Creates a jqm window
     *
     * @params id The id te created window will have by default window won't
     * have one
     * @params title
     */
    this.createWindow = function(params) {

        var defaults = {
            id: null,
            title: 'Confirmación',
            body: '',
            closeTitle: null,
            controls: null,
            type: 'alert',
            instanceType: 'new',
            startHidden: false,
            modal: true

        };
        var options = $.extend(defaults, params);
        var newJQM = $('#jqmContainer #defaultJQMWindow').clone();

        newJQM.attr('id', options.id).find('.title .name').html(options.title).end()
        .find('.body').append(options.body);

        $('#jqmContainer').append(newJQM);

        var myClose = function(hash) { 
            hash.o.remove(); 
            if ('new' == options.instanceType) {
                hash.w.remove(); 
            }
        };
        newJQM.jqm({
            onHide:myClose,
            modal: options.modal
        });
        
        if (options.closeTitle) {
            
            newJQM.find('.title .close').html(options.closeTitle);
            
        }


        if (options.controls) {

            newJQM.find('.controls').html(options.controls);
            
        }

        switch (options.type) {
            case 'alert': 
                newJQM.find('.controls').find(':not(.alert)').hide();
                break;
            case 'confirm':
                newJQM.find('.controls').find('.alert').hide();
                break;
        }

        newJQM.jqmAddClose('.close');
        if (false == options.startHidden) {
            newJQM.jqmShow();
        }
        events.initButtons(newJQM);

        return newJQM;
    
    }

    jQuery.createWindow = this.createWindow;
    return jQuery;
 
})(jQuery);
