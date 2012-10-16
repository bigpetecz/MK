var ContactForm = {

	element:null,
	container:null,

	init: function(){
		this.element = $(".contact");
		this.container = this.element.find(".contactInfo");
		this.container.append( this.getErrorMsg() );
	},

	update:function( data ) {
		this.container.empty();
		
		var $html = $( "<div>" + data.contact.address + "</div>");

		//remove child
		var $brs = $html.find("br");
		var $br = $brs.eq( 6 );
		$br.after( "<br><span class='mail'>email</span><br>" + data.contact.email );
		
		this.element.find("textarea").attr("rows", 13);

		this.container.append( $html );
	},

	show: function() {
		this.element.show();
	},

	hide: function() {
		this.element.hide();
	},

	updateZoomLevel: function() {
		this.container.empty();
		this.container.append( this.getErrorMsg() );
	},

	getErrorMsg:function() {
		var msg = "Pro kontaktní informace vyber kraj v mapě.";
		if( Application.zoomLevel == 2 ) msg = "Pro kontaktní informace vyber odbor v mapě."
	
		return msg;
	}

}
