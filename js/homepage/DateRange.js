var DateRange = {

	HIDE_BOTTOM_VALUE:"-296px",

	element:null,
	list:null,
	firstDateItems:null,
	secondDateItems:null,
	spans:null,
	appeared:null,
	currentFirstDate:null,
	currentSecondDate:null,

	init:function(){
		var self = this;
		self.element = $(".dateRange");
		
		//parse first date items
		self.firstDateItems = [];

		var lis = self.element.find(".firstDate li");
		var len = lis.length;
		var checkSequence = false;

		for(var i = 0; i < len; i++)
		{
			var $li = lis.eq(i); 
			self.firstDateItems[$li.text()] = $li;
			$li.on("mouseover",function(){
				$(this).addClass("active");
			}).on("mouseout",function(){
				$(this).removeClass("active");
			}).on("click",function(){
				var $this = $(this),
					type = ( $this.parent().hasClass("month") ) ? "firstMonth" : "firstYear";
					value = $this.text();
				
				//dont' do anything if date not available
				if( $this.hasClass( "unavailable" ) ) return;

				if( type == "firstMonth") { 
					checkSequence = self.checkDateSequence( { year: self.currentFirstDate.year, month: value }, self.currentSecondDate );
					if( !checkSequence ) {
						self.displayErrorSequence();
						return;
					}
					self.currentFirstDate.month = value;
				} else if( type == "firstYear") {
					checkSequence = self.checkDateSequence( { month: self.currentFirstDate.month, year: value }, self.currentSecondDate );
					if( !checkSequence ) {
						self.displayErrorSequence();
						return;
					}
					self.currentFirstDate.year = value;
				}
				self.update( self.currentFirstDate, self.currentSecondDate );

				//DateModel.setDate( type, value );
			});
		}

		//parse first date items
		self.secondDateItems = [];

		lis = self.element.find(".secondDate li");
		len = lis.length;
		
		for(var i = 0; i < len; i++)
		{
			var $li = lis.eq(i); 
			self.secondDateItems[$li.text()] = $li;

			$li.on("mouseover",function(){
				$(this).addClass("active");
			}).on("mouseout",function(){
				$(this).removeClass("active");
			}).on( "click" ,function(){
				
				var $this = $(this),
					type = ( $this.parent().hasClass("month") ) ? "secondMonth" : "secondYear";
					value = $this.text();
				
				//dont' do anything if date not available
				if( $this.hasClass( "unavailable" ) ) return;

				if( type == "secondMonth") {
					//check for data sequence
					checkSequence = self.checkDateSequence( self.currentFirstDate, { year: self.currentSecondDate.year, month: value } );
					if( !checkSequence ) {
						self.displayErrorSequence();
						return;
					}

					self.currentSecondDate.month = value;
				} else if( type == "secondYear") {
					//check for data sequence
					checkSequence = self.checkDateSequence( self.currentFirstDate, { year: value, month: self.currentSecondDate.month } );
					if( !checkSequence ) {
						self.displayErrorSequence();
						return;
					}

					self.currentSecondDate.year = value;
				}

				self.update( self.currentFirstDate, self.currentSecondDate );
				//DateModel.setDate( type, value );
			})
		}

		self.lis = self.element.find("li");
		self.spans = self.element.find("span");

		self.element.find("header").click("on",function(){
			self.appear();
		})

		self.element.find(".ok").click("on",function(){
			self.saveNewDate();
		});

		self.element.find(".cancel").click("on",function(){
			self.cancelNewDate();
		});

		DateModel.init();
		
		//populate vars from model
		self.updateToModel();
		
		//debug
		//self.appeared = true;
	},

	update:function( firstDate, secondDate, permanent ){

		//check if dates are not

		var self = this;
		self.lis.removeClass("selected");
		self.firstDateItems[ firstDate.month ].addClass("selected");
		self.firstDateItems[ firstDate.year ].addClass("selected");
		self.secondDateItems[ secondDate.month ].addClass("selected");
		self.secondDateItems[ secondDate.year ].addClass("selected");

		self.spans.eq(0).text( firstDate.month );
		self.spans.eq(1).text( firstDate.year );

		self.spans.eq(3).text( secondDate.month );
		self.spans.eq(4).text( secondDate.year );

		//inactiveate unavailable dates
		var monthItems = self.element.find( ".firstDate .month li" );
		var lastAvailableMonth = Application.newestAvailableDate.month;
			
		if( firstDate.year == Application.newestAvailableDate.year ) {
			$.each( monthItems, function( i, item ) {
				var $item = $( item );
				var monthIndex = $item.data( "month-index" );
				if(  monthIndex > lastAvailableMonth ) {
					$item.addClass( "unavailable" );
				} else {
					$item.removeClass( "unavailable" );
				}
			});
		} else {
			$.each( monthItems, function( i, item ) {
				var $item = $( item );
				$item.removeClass( "unavailable" );
			});
		}

		monthItems = self.element.find( ".secondDate .month li" );

		if( secondDate.year == Application.newestAvailableDate.year ) {
			$.each( monthItems, function( i, item ) {
				var $item = $( item );
				var monthIndex = $item.data( "month-index" );
				if(  monthIndex > lastAvailableMonth ) {
					$item.addClass( "unavailable" );

					if( $item.hasClass( "selected" ) ) {
						log( "selected date too late!!!" );
						log( Application.newestAvailableDate );
						self.update( firstDate, { year:Application.newestAvailableDate.year, month: getMonthFromIndex( Application.newestAvailableDate.month ) } );
					}
				} else {
					$item.removeClass( "unavailable" );
				}
			});
		} else {
			$.each( monthItems, function( i, item ) {
				var $item = $( item );
				$item.removeClass( "unavailable" );
			});
		}

		if( permanent ) {
                    self.updateToModel();
                    dateFrom.year = firstDate.year;
                    dateFrom.month = getMonthFromName(firstDate.month);
                    dateTo.year = secondDate.year;
                    dateTo.month = getMonthFromName(secondDate.month);
                    
                    storeDate(dateFrom.year,dateFrom.month,dateTo.year,dateTo.month);
                    MapDetailOverlay.close();
                    Map.init( Config.map );
                    //Porovnani.init();

                    Application.updatePeriod( dateFrom, dateTo );
                } 
	},

	checkDateSequence: function( firstDate, secondDate ) {
		var correct = true;
		
		if( firstDate.year > secondDate.year ) {
			correct = false;
		} else if( firstDate.year == secondDate.year ) {
			if( getMonthFromName( firstDate.month ) > getMonthFromName( secondDate.month ) ) {
				correct = false;
			}
		}

		return correct;
	},

	displayErrorSequence: function() {
		alert( "Datum od musí být dřivější než datum do." );
	},

	saveNewDate:function(){
		var self = this;

		DateModel.setDate( self.currentFirstDate, self.currentSecondDate );
		self.hide();
	}, 

	cancelNewDate:function(){
		var self = this,
			dates = DateModel.getDates();

		self.update( dates.first, dates.second );
		self.updateToModel();

		self.hide();
	},

	appear:function(){
		var self = this;
		if( !self.appeared ){
			self.appeared = true;
			self.element.animate( { bottom: 0 });
		}
	},

	hide:function(){
		var self = this;
		if( self.appeared ){
			self.appeared = false;
			self.element.animate( { bottom: self.HIDE_BOTTOM_VALUE });
		}
	},

	updateToModel:function(){
		var self = this,
			dates = DateModel.getDates();
		self.currentFirstDate = { year:dates.first.year, month:dates.first.month };
		self.currentSecondDate = { year:dates.second.year, month:dates.second.month };
	}
}