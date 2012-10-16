var Timeline = {
	
	dummyData: {title:"title",content:"content"},
	
	element: null,
	lis:null,
	dataView: null,
	data: null,
	range: null,
	leftArrow: null,
	rightArrow: null,
	detailBox:null,

	init: function(){
		
		var self = this;
		self.element = $( ".homepageTimeline" );
		self.dataView = self.element.find( ".dataView" );
		self.leftArrow = self.element.find( ".leftArrow" );
		self.rightArrow = self.element.find( ".rightArrow" );
		
		//bind events
		self.leftArrow.on( "click", function(){ self.handleArrows( "forward") } );
		self.rightArrow.on( "click", function(){ self.handleArrows( "backward" ) } );
                
        data = DataProxy.loadTimeline();
       	self.update( data );
       
		self.detailBox = $("<div class='detailBox'><div class='content'><h2>jmeno</h2><p>test</p></div><div class='bottom'></div></div>");
		self.element.append( self.detailBox );

		var rightBound = self.dataView.find(".data").width() - self.leftArrow.width() - self.rightArrow.width() + 5;
		TimelineActiveArea.init( 20, self.leftArrow.width(), rightBound );

		$(window).on( "resize", self.resize );

		self.element.on( "mouseover", TimelineActiveArea.show ).on( "mouseout", TimelineActiveArea.hide );
	},

	update: function( data ){
		var self = this; 
		self.data = data;

		//remove all previous children
		var olContainer = self.dataView.find("ol").empty();

		//get data range
		var range = self.getRange( self.data.data, "abs" ),
			rangeDiff = range[1] - range[0];
			minHeight = 12,
			maxHeight = 35,
			heightDiff = maxHeight - minHeight,
			len = data.data.length;
                        
		var widthAvailable = self.getAvailableWidth();
		
		$.each( data.data, function( i, v){
			var $bar = $( "<li><div class='fill'></div><div class='value'></div></li>" );
			var $valueBar = $bar.find( ".value" );
			var $fillBar = $bar.find( ".fill" );

			self.dataView.find("ol").append( $bar );
			
			var height = minHeight,
				data = v.abs,
				dataAboveMin = data - range[0],
				portionAboveMin = dataAboveMin/rangeDiff;
			
			height += portionAboveMin * heightDiff;
			var valueBarHeight = maxHeight - height;
			$valueBar.css( { height:height } );
			$fillBar.css( { height:valueBarHeight } );

			$bar.css( { marginTop: 0 } );

			$bar.data( "values", v );
			$bar.on("mouseover", self.displayBox ).on("mouseout", self.hideBox ).on( "click", self.chooseSingleMonth );
		});

		self.lis = self.dataView.find("li");
		self.sizeBarsToWidth( widthAvailable );
	},

	setDates: function( firstDate, secondDate ){

		var self = this,
			startLeft = 100*100*100,
			endRight = 0,
			position;

		self.lis.removeClass("active");
		//log( firstDate, secondDate );
		//normalize
		firstDate = { year:firstDate.year, month:self.getIndexForMonth( firstDate.month ) };
		secondDate = { year:secondDate.year, month:self.getIndexForMonth( secondDate.month ) };

		//update all values
		$.each( self.lis, function(i,v){
			var $li = $(v),
				values = $li.data("values");
			
			position = $li.position().left;

			if( !values ) return;
			
			var	date = values.date,
				arr = date.split(" "),
				dateToCompare = { year:arr[1], month:self.getIndexForMonth( arr[0] ) };
			
			//compare first data
			var result1 = self.compareDates( dateToCompare, firstDate);
			if( result1 > -1){
				//date bigger than lower limit
				var result2 = self.compareDates( dateToCompare, secondDate );
				if( result2 < 1){
					//and lower than upper limit, set active
					$li.addClass("active");

					//store begin of active area
					startLeft = Math.min( position, startLeft);
					endRight = Math.max( position + $li.width(), endRight );
				}
			}
		});

		//need to add width of left arrow
		startLeft += self.leftArrow.width();
		endRight += self.leftArrow.width();
		TimelineActiveArea.update( startLeft, endRight - startLeft );
	},
	
	chooseSingleMonth: function( ) { 
		var $li = $( this ),
			values = $li.data("values"),
			date = values.date,
			arr = date.split(" "),
			date = { month:arr[0], year:arr[1] };
		
		DateModel.setDate( date, date );
	},

	handleArrows: function( dir ){
		
		var self = this;
		if( dir == "forward" )
		{
		
		}
		else if( dir == "backward" )
		{
		
		}
	},

	displayBox:function( evt, dragging){
		
		var self = Timeline,
			$li = $( evt.target ).parent();

		//check if have proper target
		if( $li.prop( "tagName" ) != "LI" ) $li = $( evt.target ).parent();
		
		var	data = $li.data( "values" );
		if( data == null ) return;

		self.detailBox.show();
		self.detailBox.find("h2").text( data.date );
		self.detailBox.find("p").text( addSpaces(data.abs) + " trestných činů" );

		if( !dragging )
		{
			//highlight
			$li.addClass( "highlight" );

			if(!$li.hasClass("active")) self.detailBox.find(".content").addClass("inactive");
			else self.detailBox.find(".content").removeClass("inactive");
		}
		else
		{
			self.detailBox.find(".content").removeClass("inactive");
		}

		//position correctly
		var liOffset = $li.offset();
		var elOffset = self.element.offset();
		self.detailBox.css( { top: elOffset.top - 146, left:liOffset.left - 45 } );
	},

	displayBoxWhileDragging:function( x ){
		var self = this,
			len = self.lis.length,
			offset = self.dataView.offset();

		for( var i = 0; i < len; i++) {
			var $li = $( self.lis[i] ),
				left = $li.offset().left - offset.left + $li.width();

			if( left > x ){
				self.displayBox( { target: $li }, true );
				break;
			} 
		}
	},

	hideBox:function( evt ){

		var self = Timeline,
			$li = $( evt.target ).parent();
		
		$li.removeClass("highlight");
		self.detailBox.hide();
	},

	getRange:function( array, sortOn ){
		var min = 100*100*100,
			max = 0;

		$.each( array, function(i,v){
			var value = v[sortOn];
			
			min = Math.min( min, value);
			max = Math.max( max, value);
		});

		return [min,max];
	},

	sliderMoved:function( leftValue, width, dir ){
		log( leftValue, width );

		var self = this,
			len = self.lis.length,
			firstDate, secondDate;
		
		//hide dragging box
		self.detailBox.hide();

		for( var i = 0; i < len; i++)
		{
			var $li = self.lis.eq(i),
				values = $li.data("values"),
				date = values.date,
				arr = date.split(" ");
			
			position = $li.position().left + self.leftArrow.width();
			
			if( dir == "left"){
				if( position >= leftValue && !firstDate){
					firstDate = { month:arr[0], year:arr[1] };
					DateModel.setDate( firstDate);
					return;
				} 
			}
			else if( dir == "right" ) {
				if( position >= ( leftValue + width - $li.width() ) || i == len  - 1) {
					var date = values.date,
						arr = date.split(" ");
					secondDate = { month:arr[0], year:arr[1] };
					DateModel.setDate( null, secondDate );
					return;
				}
			}
		}	
	},

	compareDates:function( firstDate, secondDate ){

		var result = 0;

		//compare years
		if( firstDate.year > secondDate.year ) result = 1;
		else if( firstDate.year < secondDate.year)  result = -1;
		else{
			//same year, need to compare months
			if( firstDate.month > secondDate.month ) result = 1;
			else if( firstDate.month < secondDate.month )  result = -1;
		}

		//log( "compareDates: " + firstDate.month + "." + firstDate.year + ", " + secondDate.month + "." + secondDate.year + "," + result );

		return result;
	},

	getIndexForMonth:function( month ){
		var index = -1;

		switch( month ){
			case "Leden":
				index = 0;
				break;
			case "Únor":
				index = 1;
				break;
			case "Březen":
				index = 2;
				break;
			case "Duben":
				index = 3;
				break;
			case "Květen":
				index = 4;
				break;
			case "Červen":
				index = 5;
				break;
			case "Červenec":
				index = 6;
				break;
			case "Srpen":
				index = 7;
				break;
			case "Září":
				index = 8;
				break;
			case "Říjen":
				index = 9;
				break;
			case "Listopad":
				index = 10;
				break;
	       	case "Prosinec":
	       		index = 11;
	       		break;
		}

		return index;
	},

	getAvailableWidth:function(){
		//compute width available for dataview
		var self = this,
			screenWidth = parseInt( $( document ).width() ),
			left = parseInt( self.dataView.css( "left" ) ),
			right = parseInt( self.dataView.css( "right" ) );

		return screenWidth - left - right - self.leftArrow.width() - self.rightArrow.width();
	},

	sizeBarsToWidth:function( widthAvailable ){
		var self = this,
			barMargin = 2,
			len = self.lis.length,
			widthForBar = Math.floor( ( widthAvailable/len ) - 2 ); 
		
		$.each( self.lis, function( i, v){
			$(v).css( { width: widthForBar } );
		})
	},

	resize:function(){
		var self = Timeline;
		self.sizeBarsToWidth( self.getAvailableWidth() );
	}



}