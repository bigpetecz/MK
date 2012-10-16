var Tabulky = {

	element:null,
	inited:false,

	init: function(){
		
		var self = this;

		if( !self.inited ) {
			self.inited = true;
		
			self.element = $( "#tabulkyPage" );
			var secondCol = self.element.find( ".secondCol" );
			self.documentsSections = secondCol.find( "section" );

			//init chosen select box
			self.element.find(".chzn-select").chosen(); 
			self.element.find(".chzn-select-deselect").chosen( { allow_single_deselect:true } );

			TypesTable.init( { onDisplayRank: self.handleDisplayRank, onAreaSelect: self.handleAreaSelect } );
			RankingsTable.init( { onDisplayCrimes: self.handleDisplayCrimes } );

			$.each( self.documentsSections, function( i, section ){
				var $section = $( section );
				var $content = $section.find( ".articleContent" );
				var $hideBtn = $section.find( ".hideBtn" );

				//hide by default
				$content.hide();
				$hideBtn.toggleClass( "hideBtnDown" );

				//bind events
				$hideBtn.on( "click" , function() { 
					var $this = $(this);
					$content.slideToggle();
					//rotate 
					$this.toggleClass( "hideBtnDown" );
				});
			});
		}

		self.updateZoomLevel();
		
		//set value
		if( Application.selectedUnit > 0 ) {
			
			function complete( data ) {
				Tabulky.updateArea( Application.selectedUnit, data );
	        }

        	var data = DataProxy.getDataForArea( Application.selectedUnit, complete, Application.filtersString );
		}
	},

	updateZoomLevel:function() {
		if( !this.inited ) return;
		
		var data = DataProxy.getNamesAndIndexes( Application.zoomLevel );
		TypesTable.updateZoomLevel( data );
		RankingsTable.updateZoomLevel();
	},

	updatePeriod:function( data ) {
		if( !this.inited ) return;

		//update data in both tables
		if( data ) TypesTable.updateToArea( Application.selectedUnit, data );	
		RankingsTable.updateToCrimeType( Application.selectedCrimeType );
	},

	updateArea:function( area, data ) {
		log( "updateArea: " + area + ", " + this.inited );
		if( !this.inited ) return;
		TypesTable.updateToArea( area, data );
	},

	handleDisplayRank: function( crimeType ) {
		Tabulky.displayRankings( crimeType );
	},

	handleDisplayCrimes: function( area ) {
		Tabulky.displayCrimes( area );
	},

	handleAreaSelect: function( area ) {
		Application.updateSelectedUnit( area );
	},

	displayRankings: function ( crimeType ) {
		RankingsTable.updateToCrimeType( crimeType );
		RankingsTable.show();
		TypesTable.hide();

		//store values
		Application.selectedCrimeType = crimeType;
	},

	displayCrimes: function ( area ) {
		RankingsTable.hide();
		TypesTable.show();

		Application.updateSelectedUnit( area );
	},

	switchTables: function( tableToDisplay ) {
		var tableToHide = ( tableToDisplay == TypesTable ) ? RankingsTable : TypesTable;
		tableToHide.hide();
		tableToDisplay.show();
	}

}