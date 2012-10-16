var DateModel = {

	firstDate:null,
	secondDate:null,

	init:function(){

		var self = this;
		//self.firstDate = { month:dateFrom.month, year: dateFrom.year} ;
		//self.secondDate = { month:dateTo.month, year:dateTo.year };

		//display init data
        self.firstDate = { month: getMonthFromIndex(dateFrom.month), year: dateFrom.year };
        self.secondDate = { month: getMonthFromIndex(dateTo.month), year: dateTo.year };
                
		Timeline.setDates( self.firstDate, self.secondDate );
		DateRange.update( self.firstDate, self.secondDate );
	},

	setDate:function( firstDate, secondDate ){
		var self = this;
		if( firstDate != null ) {
            self.firstDate = { year:firstDate.year, month:firstDate.month };
            storeDate(firstDate.year,getMonthFromName(firstDate.month),"NULL","NULL");
        }
		if( secondDate != null ) {
            self.secondDate = { year:secondDate.year, month:secondDate.month };
            storeDate("NULL","NULL",secondDate.year,getMonthFromName(secondDate.month));
        }

		Timeline.setDates( self.firstDate, self.secondDate );
		DateRange.update( self.firstDate, self.secondDate, true );
	},

	/*setDate:function( type, value ){

		var self = this;

		switch( type )
		{
			case "firstMonth":
				self.firstDate.month = value;
				break;
			case "firstYear":
				self.firstDate.year = value;
				break;
			case "secondMonth":
				self.secondDate.month = value;
				break;
			case "secondYear":
				self.secondDate.year = value;
				break;
		}

		Timeline.setDates( self.firstDate, self.secondDate );
		DateRange.update( self.firstDate, self.secondDate );
	},*/

	getDates:function(){
		var self = this;
		return { first: self.firstDate, second: self.secondDate };
	}

}