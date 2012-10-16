/* Author:
	zdenek.hynek@gmail.com
*/

var Application = {
	
	screenWidth:0,
	screenHeight:0,
	zoomLevel:1,
	selectedUnit:-1,
	secondSelectedUnit:"",
	selectedPeriod:"",
	newestAvailableDate:{ year:dateTo.year, month:dateTo.month },
	firstDate:null,
	secondDate:null,
	filters:null,
	selectedCrimeType:"violent",
	
	init: function(config){
		//default selected unit
		//Application.selectedUnit = area;

		Application.selectedPeriod = dateFrom.month + dateFrom.year + dateTo.month +  dateTo.year;
		
		//default filters
		this.filters = new Array( { name:"violent", index:1 } , { name:"moral", index:2 } , { name:"burglary", index:3 }, { name:"theft", index:4 }, { name:"property", index:5 }, {name:"other", index:6 }, { name:"rest", index: 7} , {name:"economic", index:8} , { name:"military", index:9 } );

		//init pages
		Homepage.init();

		//init map
		Map.init(Config.map);
		//init zoom Control
		ZoomControl.init();
		
		//initial call for data
		DataProxy.getNamesAndIndexes( Application.zoomLevel );

        var allFilters = new Array( { name:"violent", index:1 } , { name:"moral", index:2 } , { name:"burglary", index:3 }, { name:"theft", index:4 }, { name:"property", index:5 }, {name:"other", index:6 }, { name:"rest", index: 7} , {name:"economic", index:8} , { name:"military", index:9 } );
		var self = this;
		
		//central resize handler
		$( window ).on( "resize", function(){

			var $this = $( this );
			self.screenWidth = $this.width();
			self.screenHeight = $this.height();

			Porovnani.resize();
		});

		$( window ).trigger( "resize" );
              
        /* RESTRORING CACHED FILTERS */
        if(filters != null) {
           	//load filters
            var temp = filters.split(',');
            
            if( filters.length == 0 ) {
				return;
            }

            this.filters = new Array();
            
            for(var i=0; i < temp.length; i++) {
                var name;
                for(var j=0; j < allFilters.length; j++) {
                    if(allFilters[j].index == temp[ i ] ) {
                        name = allFilters[j].name;
                    }
                }
                
                var f = { name: name,index: temp[i] };
                this.filters.push(f);
            }
        } else {
            //default filters
            this.filters = allFilters;
        }
                                
	},

	updateSelectedUnit: function( id, dataFromMap ) {
		Application.selectedUnit = id;

      	function complete( data ) {
      	   	
      	   	Homepage.update( data );
      	   	if( Homepage.isDisplayed() && dataFromMap ) MapDetailOverlay.display( data.graphData, true );

	       	Porovnani.updateArea( Application.selectedUnit, data );
	       	Tabulky.updateArea( Application.selectedUnit, data );
	    }

        var data = DataProxy.getDataForArea( id, complete, Application.filtersString, dataFromMap );
   	},

   	updateSecondSelectedUnit: function( id ) {
   		Application.secondSelectedUnit = id;

   		function complete( data ) {
      	   	//second selected unit applies only to Porovnani
      	   	Porovnani.updateSecondArea( Application.secondSelectedUnit, data );
	    }

        var data = DataProxy.getDataForArea( id, complete, Application.filtersString );
   	}, 

	updateZoomLevel: function( zoomLevel ) {
		this.zoomLevel = zoomLevel;
		
		//clear selected unit
		Application.selectedUnit = ( this.zoomLevel != 0 ) ? -1 : 1 ;
		
		//need to update indexes
		var namesAndIndexes = DataProxy.getNamesAndIndexes( Application.zoomLevel );

		Homepage.updateZoomLevel( this.zoomLevel );
		Porovnani.updateZoomLevel( this.zoomLevel );
		Tabulky.updateZoomLevel( this.zoomLevel );

		if( this.zoomLevel == 0 ) {
			
			function complete( data ) {
				Homepage.update( data );
				if( Porovnani.isDisplayed() ) Porovnani.updateArea( 1, data );
				Tabulky.updateArea( data );
			}

			//automatically select entire country
			DataProxy.getDataForArea( Application.selectedUnit, complete, Application.filtersString );
		}
	},

	updatePeriod: function( firstDate, secondDate ) {
		
		this.firstDate = firstDate;
		this.secondDate = secondDate;

		Application.selectedPeriod = this.firstDate.month + this.firstDate.year + this.secondDate.month + this.secondDate.year;
		
		//need to update indexes
		var namesAndIndexes = DataProxy.getNamesAndIndexes( Application.zoomLevel );

		function complete( data ) {
			Homepage.update( data );
			if( Porovnani.isDisplayed() ) Porovnani.updatePeriodAndFilters( data, namesAndIndexes );
			Tabulky.updatePeriod( data );
		}

		if( Application.selectedUnit > -1 ) DataProxy.getDataForArea( Application.selectedUnit, complete, Application.filtersString );
		else {
			//need to update rankings tabulky regardless of not selected unit
			Tabulky.updatePeriod( null );
			//update rankings in selectbox
			Porovnani.updatePeriodAndFilters( null, namesAndIndexes );
		}
	},

	updateFilters: function() {
		function complete( data ) {
			//Map.init( Config.map );
			Map.updateFussionTableLayer();
			Homepage.update( data );

			if( Porovnani.isDisplayed() ) Porovnani.updatePeriodAndFilters( data, namesAndIndexes );
		}
                
       storeFilters(Application.filtersString);
       var namesAndIndexes = DataProxy.getNamesAndIndexes( Application.zoomLevel );

       //update timeline data
       var timelineData = DataProxy.loadTimeline();
       Timeline.update( timelineData );
       DateModel.init();

       if( Application.selectedUnit > -1 ) DataProxy.getDataForArea( Application.selectedUnit, complete, Application.filtersString );
       else {
		   //Map.init( Config.map );
		   Map.updateFussionTableLayer();
		   //update rankings in selectbox
		   Porovnani.updatePeriodAndFilters( null, namesAndIndexes );
	   }
	},

	currentKey:function() {
		return Application.zoomLevel + "," + Application.selectedPeriod + "," + Application.filtersString();
	},

	filtersString:function() {
		var string = "";
			len = Application.filters.length,
			i = 0;

		for( i = 0; i < len; i++ ) {
			if( i < len - 1 ) string += Application.filters[ i ].index + ",";
			else string += Application.filters[ i ].index;
		}

		return string;
	},

};