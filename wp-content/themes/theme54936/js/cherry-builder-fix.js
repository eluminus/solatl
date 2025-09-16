// Cherry Framework Visual Builder Compatibility Fix
jQuery(document).ready(function($) {
    // Ensure jQuery is properly loaded
    if (typeof $ === "undefined") {
        $ = jQuery;
    }
    
    // Fix MotoPress editor loading
    if (typeof window.motopress !== "undefined") {
        // Delay initialization to avoid conflicts
        setTimeout(function() {
            if (window.motopress.initEditor) {
                window.motopress.initEditor();
            }
        }, 1000);
    }
    
    // Fix Cherry Framework conflicts
    if (typeof window.Cherry !== "undefined") {
        window.Cherry.compatibility = true;
    }
    
    // Console debugging
    console.log("Cherry visual builder compatibility fix loaded");
});

// Prevent script conflicts
(function() {
    var originalConsoleError = console.error;
    console.error = function(message) {
        // Suppress known MotoPress warnings that dont break functionality
        if (typeof message === "string" && (
            message.indexOf("motopress") !== -1 ||
            message.indexOf("cherry") !== -1
        )) {
            return; // Ignore these errors
        }
        originalConsoleError.apply(console, arguments);
    };
})();