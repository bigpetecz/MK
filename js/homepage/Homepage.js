var Homepage = {

	infoBox:InfoBox,

	timeline:Timeline,
	
	filterBox:FilterBox,

	init: function() {
		var self = this;

		//init componets
		InfoBox.init();
		Timeline.init();
		DateRange.init();
		FilterBox.init();
		ContactForm.init();
		Legend.init();
	},

	update: function( data ) {
		InfoBox.update( data );
		FilterBox.update( data );
		Legend.update( data );
		ContactForm.update( data );
	},

	updateLayout: function( height, target ) {
		if( target == InfoBox ){
			FilterBox.slideUp( height );
			Legend.slideUp( height );
		}
		else if( target == FilterBox ){
			Legend.slideUp( height );
		}
	},

	updateZoomLevel: function( level ) {
		InfoBox.updateZoomLevel( level );
		FilterBox.updateZoomLevel( level );
		Legend.updateZoomLevel( level );
		ContactForm.updateZoomLevel( level );
	},

	isDisplayed: function() {
		return InfoBox.element.is( ":visible" );
	}
}