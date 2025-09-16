// MotoPress jQuery Loading Fix
(function() {
    // Ensure jQuery loads first
    if (typeof jQuery === "undefined") {
        console.log("jQuery not loaded, waiting...");
        
        // Create a script tag to load jQuery if missing
        var jqueryScript = document.createElement("script");
        jqueryScript.src = "//ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js";
        jqueryScript.onload = function() {
            console.log("jQuery loaded successfully");
            initializeMotoPress();
        };
        document.head.appendChild(jqueryScript);
    } else {
        console.log("jQuery already loaded");
        initializeMotoPress();
    }
    
    function initializeMotoPress() {
        // Wait for DOM to be ready
        jQuery(document).ready(function($) {
            console.log("DOM ready, jQuery version:", $.fn.jquery);
            
            // Fix missing functions
            if (typeof deleteCookie === "undefined") {
                window.deleteCookie = function(name) {
                    document.cookie = name + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                };
            }
            
            // Fix mobile jQuery loading
            if (typeof $.mobile === "undefined" && window.define) {
                // Disable conflicting AMD loaders temporarily
                var oldDefine = window.define;
                window.define = undefined;
                
                setTimeout(function() {
                    window.define = oldDefine;
                }, 2000);
            }
            
            // Initialize MotoPress when ready
            var checkMotoPress = setInterval(function() {
                if (window.motopress || window.motopressCE) {
                    console.log("MotoPress detected, initializing...");
                    clearInterval(checkMotoPress);
                    
                    // Additional delay to ensure everything is ready
                    setTimeout(function() {
                        if (window.motopress && window.motopress.init) {
                            window.motopress.init();
                        }
                        if (window.motopressCE && window.motopressCE.init) {
                            window.motopressCE.init();
                        }
                    }, 1000);
                    
                    return;
                }
            }, 100);
            
            // Stop checking after 30 seconds
            setTimeout(function() {
                clearInterval(checkMotoPress);
            }, 30000);
        });
    }
})();