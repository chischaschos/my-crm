var alerts = {

    props: {
        timeout: null,
        interval: 3600,
        show: {
            onprocess: false,
            interval: 900,
            flashNum: 3,
            currentFlash: 0
        }
    },

    init: function() {

        alerts.props.timeout = setInterval('alerts.check()', alerts.props.interval);

    },

    check: function() {

        $.getJSON(SERVICE['alert']['news']['url'], function(json) {
            $.logger.info('Receiving alerts');
            alerts.handleAlerts(json);
        });

    },

    stop: function() {
          
        clearInterval(alerts.props.timeout);
    
    },

    handleAlerts: function(json) {
                  
        $.logger.info(json); 

        if (json.length > 0) {
        
            alerts.show();

        }
    
    },

    show: function() {
          
        if (!alerts.props.show.onprocess) {

            alerts.blink();
            alerts.props.show.onprocess = true;

        }
          
    },

    blink: function() {
           
        var currentFlash = alerts.props.show.currentFlash;

        if (currentFlash < 3) {

            $("#alertsMenu").css("background-color", currentFlash / 2 == 0 ? 'red' : '' );
            alerts.props.show.currentFlash++;
            setTimeout('alerts.blink()', alerts.props.show.interval);

       } else {

            $("#alertsMenu").css("background-color", '' );
            alerts.props.show.currentFlash = 0;
            alerts.props.show.onprocess = false;
       
       }

    }

};
