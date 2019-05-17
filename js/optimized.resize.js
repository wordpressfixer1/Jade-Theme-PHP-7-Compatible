var optimizedResize = (function($) {

    var callbacks = new Array(),
        running = false;

    // fired on resize event
    function resize() {

        if (!running) {
            running = true;

            if (window.requestAnimationFrame) {
                window.requestAnimationFrame(runCallbacks);
            } else {
                setTimeout(runCallbacks, 66);
            }
        }

    }

    // run the actual callbacks
    function runCallbacks() {
	    $.each(callbacks, function(k,callback){
		    callback();
	    });

        running = false;
    }

    // adds callback to loop
    function addCallback(callback) {

        if (callback) {
            callbacks.push(callback);
        }

    }

    return {
        // initalize resize event listener
        init: function(callback) {
	        $(window).on('resize', resize);
            addCallback(callback);
        },

        // public method to add additional callback
        add: function(callback) {
            addCallback(callback);
        }
    }
}(jQuery));

optimizedResize.init(function(){});