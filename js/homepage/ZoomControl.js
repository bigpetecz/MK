var ZoomControl = {

	SLIDER_POSITION_HEIGHT:5,
	SLIDER_MIN_OFFSET:-95,
	SLIDER_MAX_OFFSET:-5,

	wrapper:null,
	element:null,
	slider:null,
	layerBtns:null,
	step:null,
	activeLayerBtn:null,

	init:function(){

		var self = this;
                
		self.element = $( ".zoomControl" );
                
                if(fusionTable == countryTable) {
                    self.element.find("li.country div").addClass("selected");
                }
                if(fusionTable == countyTable) {
                    self.element.find("li.county div").addClass("selected");
                }
                if(fusionTable == districtTable) {
                    self.element.find("li.district div").addClass("selected");
                }
                
		self.layerBtns = self.element.find("li");
		self.layerBtns.on("mouseover",function(){
			$(this).find("div").addClass("active");
		}).on("mouseout",function(){
			$(this).find("div").removeClass("active");
		});
	},

	switchToTabulky:function() {
		this.element.addClass( "tabulky" );
	},

	switchToNormal:function() {
		this.element.removeClass( "tabulky" );
	}
}