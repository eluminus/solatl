    var
        _window = jQuery(window);
    ;

jQuery(document).ready(function(){

	var
		_window = jQuery(window);
		not_resizes = false;
	;

	_window.on("resize", function(){
		resizeFunction();
	})
	resizeFunction();

	function resizeFunction(){
		if(!not_resizes){
			var
				newWidth = _window.width()
			,	marginHalf = _window.width()/-2;
			;
			if (jQuery('body').hasClass('cherry-fixed-layout')) {
				var
					newWidth = jQuery('.main-holder').width()
				,	marginHalf =jQuery('.main-holder').width()/-2;
				;
			}

			jQuery('.wide, .title-section').css({width: newWidth, "margin-left": marginHalf, left: '50%'});
		}
	}


jQuery('.sf-menu>li>a, a.btn').each(function(){
    $(this).attr("data-hover", $(this).text());
});

$('.portfolio_wrapper .portfolio-item').magnificPopup({
    delegate: '.thumbnail > a',
    type: 'image',
    removalDelay: 500,
    mainClass: 'mfp-zoom-in',
    callbacks: {
        beforeOpen: function() {
            // just a hack that adds mfp-anim class to markup
            this.st.image.markup = this.st.image.markup.replace('mfp-figure', 'mfp-figure mfp-with-anim');
        },
        open: function() {
          not_resizes = true;
        },
        close: function() {
          not_resizes = false;
        }
    },
    gallery: {enabled:true}
});

$( ".title-section" ).wrapInner( "<div class='container' />");


        // var setVisible = function() {
        //      $(this).addClass('abs_visible');

        // };


  // if (jQuery('html').hasClass('desktop')) {
  //     $('.abs_element').waypoint(setVisible, { offset: '100%', triggerOnce: true});
  // }
});
