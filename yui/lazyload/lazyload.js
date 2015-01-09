YUI.add('moodle-filter_oembed-lazyload', function(Y) {

    var AUTOLINKER = function() {
        AUTOLINKER.superclass.constructor.apply(this, arguments);
    };
    Y.extend(AUTOLINKER, Y.Base, {
        overlay : null,
        initializer : function(config) {
            Y.delegate('click', function(e){
                e.preventDefault();
                var title = '';
                var videonode = this.getData('embed');
                var videowidth = this.getData('width');
                var videoheight = this.getData('height');
                var content = Y.Node.create(videonode);
                content.set('width', videowidth);
                content.set('height', videoheight);
                if (content.get('src').indexOf("?") > -1){
                    var modifier = '&';
                } else {
                    var modifier = '?';
                }
                content.set('src', content.get('src') + modifier + 'autoplay=1');
                this.replace(content);
            }, Y.one(document.body), 'a.lvvideo');
        }
    });

    M.filter_oembed = M.filter_oembed || {};
    M.filter_oembed.init_filter_lazyload = function(config) {
        return new AUTOLINKER(config);
    }

}, '@VERSION@', {requires:['base','node','io-base','json-parse','event-delegate','overlay','moodle-enrol-notification']});
