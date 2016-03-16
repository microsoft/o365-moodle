YUI.add('moodle-filter_oembed-powerbiloader', function(Y) {
    var ModulenameNAME = 'powerbiloader';
    var token = '';
    var MODULENAME = function() {
        MODULENAME.superclass.constructor.apply(this, arguments);
    };
    Y.extend(MODULENAME, Y.Base, {
        initializer : function(config) { 
            token = config.token
            iframe = document.getElementById('powerbi_iframe');
            iframe.onload = postActionLoadReport;
        }
    }, {
        NAME : ModulenameNAME, 
        ATTRS : {
                 aparam : {}
        } 
    });
    M.filter_oembed = M.filter_oembed || {}; 
                                                 
    M.filter_oembed.init_powerbiloader = function(config) {
        return new MODULENAME(config);
    };
    
    // post the auth token to the iFrame. 
    postActionLoadReport = function() {

        var m = { action: "loadReport", accessToken: token};
        message = JSON.stringify(m);
        // push the message.
        iframe = document.getElementById('powerbi_iframe');
        iframe.contentWindow.postMessage(message, "*");;
    }
  }, '@VERSION@', {
      requires:['base']
  });