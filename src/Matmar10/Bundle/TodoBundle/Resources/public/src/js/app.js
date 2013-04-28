(function($) {

        // options
    var o = {};


    $.todo = {};
    $.todo.defaults = {
        elements: {
            messagesContainer: "ul.messages",
            usersContainer: "ul.users"
        }
    };

    /**
     * Initializes the spreecast chat module
     *
     * @param options Optional parameters to override default options
     */
    $.todo.init = function(options) {

        // set up page options
        o = $.extend({}, $.todo.defaults, options);

        // cache commonly used elements
        $.each(o.elements, function(cacheId, selector) {
            $elementCache[cacheId] = $(selector);
        });
    };

})(jQuery);