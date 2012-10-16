var Preloader = {

	DEFAULT_TEXT: "Nahrávání dat...",

	element:null,
	darkOverlay:null,

	init: function() {
		this.element = $('<div id="ajax-spinner">Nahrávání dat...</div>').appendTo("body").css({
                position: "absolute",
                left: "50%",
                top: "50%"
        	});

        this.darkOverlay = $('<div class="preloaderBack"></div>').appendTo("body");
    },

	show: function( text ) {
		if( !this.element ) this.init(); 

		this.element.show();
		
		if( text ) this.element.text( text );
		else this.element.text( this.DEFAULT_TEXT );

		this.darkOverlay.show();
	},

	hide: function() {
		if( this.element && this.darkOverlay ) {
			this.element.hide();
			this.darkOverlay.hide();
		}
	}

}