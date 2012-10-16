var MapOverviewPopUp = {

	element:null,
	title:null,
        value:null,
        index:null,
        lis:null,
        selectedValue:0,
        ranges:null,

	init:function(){
		var self = this;
		self.element = $(".mapOverviewPopup");
		self.element.hide();

		self.title = self.element.find("h1");
                self.value = self.element.find(".value dd");
                self.index = self.element.find(".index dd");

		self.elWidth = self.element.width(),
		self.elHeight = self.element.height();
                
                //populate ranges array
                self.lis = self.element.find( "li" );
		self.ranges = [];
		$.each( self.lis, function(i,v){
			self.ranges.push( $(v).text() );
		});
	},

	show:function(){
		var self = this;
		if( self.element ) self.element.show();
	},

	hide:function(){
		var self = this;
		if( !self.element ) return;
		
		self.element.hide();
	},

	update:function( data, position ){
		var self = this;

		//check for data not available
		if( isNaN( data.value ) ){
			//data not available
			self.element.addClass( "noData" );
		} else {
			//alright
			self.element.removeClass( "noData" );
		}

		//update displayed data
		self.title.text( data.Name );
        self.value.text( addSpaces( data.value ));
        self.index.text( addSpaces( data.index ));
        
        self.lis.removeClass("selected");
        
        var index = self.getStepFromIndexValue( data.index );

        self.selectedValue = self.lis.eq(index).addClass("selected").text();

		//offset marker
		position.top -= self.elHeight;
		position.left -= self.elWidth/2;
		self.element.css( { top:position.top, left:position.left } );
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
	}
}