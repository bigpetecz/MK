var FilterBox = {
	selector: ".homepageFilterBox",
	firstClick:true,
	inputs:null,
	element: null,
	data:null,
	origHeight:null,
	allChecked:true,
	oneChecked:false,

	init: function(){                
                
		var self = this;
		self.element = $(self.selector);

		self.data = DummyData;
		self.origHeight = self.element.find(".content").outerHeight();

		//bind events
		self.element.find(".hideBtn").on("click",function(){
			var $this = $(this);
			self.element.find(".content").slideToggle( 300 );
			$this.toggleClass("hideBtnDown");
			$this.parent().toggleClass("noBorder");
			
			var contHeight = self.origHeight;
			var offset = $this.hasClass("hideBtnDown") ? contHeight : -contHeight;
			Homepage.updateLayout( offset, self );
		});

		self.inputs = self.element.find("input");
		self.inputs.checkbox( {empty: 'images/empty.png' } );

		self.inputs.on("change", self.handleInput );
	},

	handleInput: function() {

		var self = FilterBox;
		var clickedInput = $( this );
		
		//disable all inputs if every type turned on
		if( self.allChecked ) {

			//turn off all checkboxes
			$.each( self.inputs, function(i,v){
				var input = $(v);
				
				if( clickedInput.attr("name") != input.attr("name") ) {
					input.attr("checked",false);
					//Porovnani.toggleTableRowVisibility( input.attr("name"), false);
				}
				else {
					input.attr("checked",true);
					//Porovnani.toggleTableRowVisibility( input.attr("name"), true);
				}
			});
		} else if( self.oneChecked && !clickedInput.attr("checked") ) {
			//user turned off last filter, turn on all checkboxes
			$.each( self.inputs, function(i,v){
				var input = $(v);
				input.attr( "checked", true );
				//Porovnani.toggleTableRowVisibility( input.attr("name"), true);
			});
		}
		
		//update filters
		Application.filters = new Array();
		var numChecked = 0;
			
		$.each( self.inputs, function( i,v ) {
			var input = $(v);
			var inputName = input.attr( "name" );
			var inputIndex = input.data( "index" );

			if( input.attr('checked') ){
                Application.filters.push( { name:inputName, index:inputIndex } );
				input.parent().removeClass("inactive");
				
				//Porovnani.toggleTableRowVisibility( inputName, true);
				numChecked++;
			}
			else {
				input.parent().addClass("inactive");
				
				//Porovnani.toggleTableRowVisibility( inputName, false);
			}
		});

		self.allChecked = ( numChecked == self.inputs.length ) ? true : false;
		self.oneChecked = ( numChecked == 1 ) ? true : false;

		if( !self.allChecked ) {
			InfoBox.toggleNaNForDamage( true );
		} else {
			InfoBox.toggleNaNForDamage( false );
		}

		Application.updateFilters();
	},

	update: function( data ){
		var self = this,
			branchData = data.filterData;
		
		//morph data to apply filters and display only selected data
		data.graph = {
            country: data.name, 
			index:{name : "index kriminality",val : index}, 
            name:"TRESTNÉ ČINY CELKEM",
            solv:{ col:"#555555", val: solv }, 
			com:{ col:"#444444", val: com },
			trend:10,
			data: {}
        };

		$.each( self.inputs, function( i, v){
			var $input = $(v),
				$span = $(v).parent().find("span.val"),
				attrName = $input.attr("name");
			
			if( $input.attr('checked') )
			{
				data.graph.data[ attrName ] = data.filterData[ attrName ];
			} 
			$span.text( addSpaces( branchData[ attrName ].com.val ) );
		});

        if( MapDetailOverlay.isDisplayed() ) MapDetailOverlay.display( data );
	},

	slideUp:function( height ){
		var self = this;
		self.element.css("top","-=" + height);
	},

	getUncheckedFilters: function(){

		var self = this,
			filters = [];

		$.each( self.inputs, function( i, v) {
			var input = $(v);
			if( !input.attr('checked') ) filters.push( input.attr('name') );
		});

		return filters;
	},

	switchToPorovnani: function() {
		this.element.show();
		this.element.addClass('porovnaniFilterBox');
	},

	switchToMapa: function() {
		this.element.show();
		this.element.removeClass('porovnaniFilterBox');
	},

	switchToTabulky: function() {
		this.element.hide();
	},

	updateZoomLevel: function( level ) {
		this.clearValues();
	},

	clearValues: function() {
		//insert hypnes instead of crime values
		var symbol = "-";
		this.element.find( "span.val" ).text( symbol );
	}
}