$(document).ready(init);
$(document).unload(destroy);

/**
 * Load everything
 */
function init() {
    initDefault();
} 

function destroy() {
    $.jCache.clear();
}

/**
 * Initialize default stuff
 */
function initDefault() {

    $.jCache.setItem('application', {debug: true});

    /*
     * Add new file type validation
     */ 
    $.validator.addMethod("fileType", function(value) {
		    return value.match(/\.csv$/);
	    }, 'Tipo de archivo incorrecto, solo soportamos carga de archivos csv por ahora');
    $.validator.defaults.wrapper = 'p';

    /*
     * inits work area adding menu, session info clean divs etc
     */
    utils.initWorkarea();

    /*
     * Configure progress bar
     */
    utils.initProcessbar();

    /*
     * Configure base tablesorting
     */
    $.tablesorter.defaults.widgets = ['zebra']; 
    $.tablesorter.defaults.widthFixed = true; 
    $.tablesorter.defaults.sortList = [[0,1]];

    $.tooltip.defaults.showURL = false;
    $.tooltip.defaults.showBody = '-';

//    alerts.init();

}
