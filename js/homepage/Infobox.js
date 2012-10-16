var InfoBox = {
	
	dummyData: {title:"title",content:"content"},

	selector: ".homepageInfoBox",
	headerUnit:null,
	index:null,
	damage:null,
	damageValue:null,
	title:null,
	rank:null,
	total:null,
	officers:null,
	element: null,
	origHeight:null,

	init: function(){
		
		var self = this;
		self.element = $(self.selector);
		self.origHeight = self.element.find(".content").outerHeight();

		self.headerUnit = self.element.find(".headerWrapper").find("h1");
		self.title = self.element.find( "#county" );
                self.index = self.element.find( "#ic" );
                self.total = self.element.find( "#totalcrime" );
                self.officers = self.element.find( "#officers" );
                self.damage = self.element.find( "#damage" );
                self.rank = self.element.find( ".rank" );

		//bind events
		self.element.find(".hideBtn").on("click",function(){
			var $this = $(this);
			self.element.find(".content").slideToggle( 300 );
			$('.contact').hide();
			$this.toggleClass("hideBtnDown");
			$this.parent().toggleClass("noBorder");

			var contHeight = self.origHeight;
			var offset = $this.hasClass("hideBtnDown") ? contHeight : -contHeight;
			Homepage.updateLayout( offset, self );
		});

		self.element.find( ".contactBtn").on("click",function(){
			ContactForm.show();
			MapDetailOverlay.close();
		});
                
                
                
                /* RESTORING SELECTED AREA */
                
                if(area != null) {
              /*      query = "SELECT ID, Name, TotalDamage,Acreage,Population,Officers,Rank,ContactFormContent,ContactFormEmail FROM " + fusionTable + " WHERE ID=" + area;
                    data = queryGoogle(query);
                    
                    
                    
                    self.title.html( data.rows[0][1] );
                    self.damage.html( addSpaces(data.rows[0][2]) );
                    self.officers.html( addSpaces(data.rows[0][5]) );*/


                  Application.updateSelectedUnit( area );

                    
                }
                

		/*$countyDropBox = self.element.find(".county"); 
		$countyDropBox.on("change",function(){
			alert("Vybrane data: " + $countyDropBox.val());
		});*/
	},

	update: function( data ){
		
		var self = this;

		self.title.html( data.name );
        
        var index = data.index;
        //check for data not available
        if( isNaN( index ) ){
          //data not available
          self.index.addClass( "noData" );
        } else {
          //alright
          self.index.removeClass( "noData" );
        }
        self.index.html( addSpaces( index ) );
        
        self.total.html( addSpaces( data.com ) );
        self.officers.html( addSpaces( data.officers ) );
        
        var damage = addSpaces( data.damage ) + " mil. Kč" ;
        if( FilterBox.allChecked ) self.damage.html( damage );
        else {
        	//cannot display data
        	self.toggleNaNForDamage( true );
		}

		//store value
		self.damageValue = damage;

        //get index data 
        var rankValue = 1;
        if( Application.zoomLevel > 0 ) {
        	//different level than Cela CR, need to find actual index value
        	rankValue = self.findRankById( data.id );
	        //adjust styling if necessary
	        if( rankValue > 99) self.rank.addClass("longRank");
	        else self.rank.removeClass("longRank");
	    }
        
        self.rank.html( addSpaces( rankValue ) );
	},

	findRankById: function( id ) {

		var data = DataProxy.getCachedData( DataProxy.NAMES_INDEXES_KEYWORD );
        var rank = 0;

        $.each( data, function( i, v) {
        	if( v.area == id ) {
        		rank = v.rank;
        		return false;
        	}
        } );

        return rank;
	},

	toggleNaNForDamage: function( display ) {
		
		if( display ) {
			this.damage.html( "Data nejsou k dispozici" );
			this.damage.addClass( "noData" );
		} else {
			this.damage.html( this.damageValue );
			this.damage.removeClass( "noData" );
		}
	},

	updateZoomLevel: function( level ) {
			
		//update title
		var title = "";
		if( level == 0 ) title = "ČR";
		else if( level == 1 ) title = "KRAJ";
		else if( level == 2 ) title = "ÚZEMNÍ ODBOR";

		this.headerUnit.text( title );

		this.clearValues( level );
	},

	clearValues: function( level ) {
		var self = this,
			symbol = "-",
			titleMsg = "";

		if( level == 1 ) titleMsg = "Vyber kraj v mapě";
		else if( level == 2 ) titleMsg = "Vyber odbor v mapě"; 

		self.title.html( titleMsg );
		self.index.html( symbol );
        self.total.html( symbol );
        self.officers.html( symbol );
        
        self.damage.html( symbol );
        
		//store value
		self.damageValue = damage;

        self.rank.removeClass("longRank");
        self.rank.html( 0 );
	}

}