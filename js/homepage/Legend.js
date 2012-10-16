var Legend = {

	element:null,
	lis:null,
	val:null,
	selectedValue:0,
	ranges:null,

	init:function(){

		var self = this;

		self.element = $( ".homepageLegendMain" );
		self.lis = self.element.find( "li" );
		self.val = self.element.find( ".value" );

		self.lis.on("mouseover",function(){
			var $li = $(this);
			$li.addClass("active");
			self.updateValueText( $li.text() );

		}).on("mouseout",function(){
			var $li = $(this);
			$li.removeClass("active");
			self.updateValueText( self.selectedValue );
		});

		//populate ranges array
		if( !self.ranges ){
			self.ranges = [];
			$.each( self.lis, function(i,v){
				self.ranges.push( $(v).text() );
			});
		}
		
		self.updateRanges( self.ranges );
	},

	update:function( data ){
		var self = this,
			index = self.getStepFromIndexValue( data.index );
	
		//remove previous highlight
		self.lis.removeClass("selected");

		//update new value
		self.selectedValue = self.lis.eq( index ).addClass( "selected" ).text();
		self.updateValueText( self.selectedValue );
	},

	updateValueText:function(value){

		//check for the same numbers
		if( value != 0 ) {
			var arr = value.split(" - ");
			if( arr[0] == arr[1] ) value = Math.round( arr[ 0 ] );
			else {
				//decrease first interval
				value = Math.round( arr[0] ) + " - " + Math.round( parseInt( arr[ 1 ] - 1 ) );
			}
		}

		this.val.text( value );
	},

	updateRanges:function( ranges ){

		var self = this,
			i = 0;

		self.ranges = ranges;

		if( !self.lis ) return;

		//loop through all lis
		$.each( ranges, function( i, range ){
			//update value of li
			self.lis.eq( i ).text( range );
		});
	},

	getStepFromIndexValue:function( value ){
		var self = this,
			i = 0,
			foundIndex = -1,
			len = self.lis.length;

		
		for( i = 0; i < len; i++){

			var range = self.ranges[i],
				arr = range.split("-"),
				down = arr[0],
				up = arr[1];

			if( value >= down && value < up)
			{
				foundIndex = i;
				break;
			} 
		}

		return foundIndex;
	},

	getColorFromIndexValue:function( value ){
		var self = this,
			i = 0,
			foundIndex = -1,
			len = self.lis.length;

		
		for( i = 0; i < len; i++){

			var range = self.ranges[i],
				arr = range.split("-"),
				down = arr[0],
				up = arr[1];

			if( value >= down && value < up)
			{
				foundIndex = i;
				break;
			} 
		}

		return self.lis.eq( foundIndex ).data( "color" );
	},

	slideUp:function( height ){
		var self = this;
		self.element.css("top","-=" + height);
	},

	updateZoomLevel: function( level ) {
		this.clearValues();
	},

	clearValues: function() {
		this.val.text( 0 );
	}
}
