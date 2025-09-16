console.log("Starting MotoPress nuclear fix...");

// Wait for jQuery to be absolutely ready
var waitForJQuery = setInterval(function() {
    if (typeof jQuery !== "undefined" && jQuery.fn) {
        clearInterval(waitForJQuery);
        console.log("jQuery confirmed loaded:", jQuery.fn.jquery);
        
        // Create all missing global functions
        window.$ = jQuery;
        window.deleteCookie = function(name) {
            document.cookie = name + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        };
        
        // Override document.ready to ensure timing
        jQuery(function($) {
            console.log("DOM ready with jQuery");
            
            // Give MotoPress extra time to initialize
            setTimeout(function() {
                console.log("Attempting MotoPress initialization...");
                
                // Try multiple MotoPress init methods
                if (window.motopress) {
                    if (typeof window.motopress.init === "function") {
                        window.motopress.init();
                        console.log("MotoPress init() called");
                    }
                    if (typeof window.motopress.start === "function") {
                        window.motopress.start();
                        console.log("MotoPress start() called");
                    }
                }
                
                if (window.motopressCE) {
                    if (typeof window.motopressCE.init === "function") {
                        window.motopressCE.init();
                        console.log("MotopressCE init() called");
                    }
                }
                
                // Force editor to show
                if ($(".motopress-content-editor").length > 0) {
                    $(".motopress-content-editor").show();
                    console.log("MotoPress editor shown");
                }
                
            }, 3000); // Wait 3 full seconds
        });
    }
}, 50); // Check every 50ms

// Stop trying after 30 seconds
setTimeout(function() {
    clearInterval(waitForJQuery);
    console.log("Stopped waiting for jQuery");
}, 30000);