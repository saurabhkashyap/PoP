"use strict";
(function($){
window.popEmbeddable = {

	//-------------------------------------------------
	// PUBLIC FUNCTIONS
	//-------------------------------------------------

	fullscreen : function(args) {

		var that = this;
		var targets = args.targets;

		$(document).bind("fullscreenchange", function() {
			
			var glyphicon = targets.find('.glyphicon');
			if ($(document).fullScreen()) {

				glyphicon
					.removeClass('glyphicon-fullscreen')
					.addClass('glyphicon-resize-small');
			}
			else {

				glyphicon
					.addClass('glyphicon-fullscreen')
					.removeClass('glyphicon-resize-small');	
			}
		});

		targets.click(function(e) {

			e.preventDefault();

			var button = $(this);
			var fullScreen = button.closest('.pop-fullscreen');
			
			fullScreen.toggleFullScreen();
		});
	},

	newWindow : function(args) {

		var that = this;
		var targets = args.targets;

		targets.click(function(e) {

			e.preventDefault();
			window.open(popManager.getUnembedUrl(window.location.href), '_blank');
		});
	},
};
})(jQuery);

//-------------------------------------------------
// Initialize
//-------------------------------------------------
popJSLibraryManager.register(popEmbeddable, ['newWindow', 'fullscreen']);
