var RankingsTable = {

	element:null,
	rows:null,
	ths:null,
	downloadBtn:null,
	selectBox:null,
	opts:null,

	init: function( opts ) {

		var self = this;
			self.opts = opts,
			tabulkyPage = $( "#tabulkyPage" );

		self.element = tabulkyPage.find( ".rankings" );
		
		//init rows
		self.rows = self.element.find( "tr" ).not(".header");
		self.rows.on( "mouseover", function() { 
			$tr = $( this );
			$tr.addClass("active");
		}).on( "mouseout", function() {
			$tr = $( this );
			$tr.removeClass("active");
		});

		//init selectbox
		var section = tabulkyPage.find( ".crimesSelect" );
		this.selectBox = new RankingSelectBox( section.find( "select.county" ), { onChange: self.selectChangeHandler } );

		//init sort
		fdTableSort.init();

		//init download button
		self.downloadBtn = self.element.find(".downloadBtn");
		self.downloadBtn.on( "click", function( evt ) {
			evt.preventDefault();
		});

		//init buttons
		self.buttons = self.element.find(".displayTypesBtn");
		self.buttons.on( "click", function( evt ) {
			evt.preventDefault();
			self.displayCrimes( this );
		});

		//init select 
		self.select = $("#tabulkyPage").find(".crimesSelect");
	},

	selectChangeHandler: function( crimeType ) {
		RankingsTable.updateToCrimeType( crimeType );
	},

	updateToCrimeType: function( crimeType ) {
		
		function complete( data ) {
			RankingsTable.update( crimeType, data );
		}
		
		this.selectBox.setValue( crimeType );
		DataProxy.getRankingsForCrimeType( crimeType, complete );
	},

	update:function( crimeType, data ) {
		var self = this;
		self.selectBox.setValue( crimeType );

		//get rid of rows
		//this.rows.remove();

		//update all rows
		var dataLen = data.length,
			rowsLen = self.rows.length,
			index = 0;

		$.each( data, function( i, rowData ) {
			self.updateRow( self.rows.eq( i ), rowData, index );
			index++;
		});

		//check if all rows populated
		if( dataLen < rowsLen ) {
			//need to hide unnecessary rows
			for( index; index < rowsLen; index++ ) {
				self.rows.eq( index ).hide();	
			}
		}
	},

	updateRow: function( $row, data, index ) {

		//insert identifier
		$row.data( "id", data.Id );

		var $tds = $row.find( "td" );
		var percent = Math.round( data.solv/data.com * 100 );
		//check for NaN
		if( isNaN( percent ) ) percent = "-";

		$tds.eq( 0 ).text( index+1 );
		$tds.eq( 1 ).text( addSpaces( data.Name ) );
		$tds.eq( 2 ).text( addSpaces( data.com ) );
		$tds.eq( 3 ).text( addSpaces( data.i ) );
		$tds.eq( 4 ).text( addSpaces( data.solv ) );
		$tds.eq( 5 ).text( percent );

		//make sure the row is visible
		$row.show();
	},
	
	displayCrimes: function( btn ) {
		
		var $btn = $( btn );
		var $parentRow = $btn.parent().parent();
		var areaId = $parentRow.data( "id" );
		
		if( this.opts.onDisplayCrimes ) this.opts.onDisplayCrimes.apply( this, [ areaId ] );
	},

	updateZoomLevel: function() {
		this.updateToCrimeType( Application.selectedCrimeType );
   	},

	hide: function() {
		this.rows.removeClass("active");
		this.element.hide();
		this.select.hide();
	},

	show: function() {
		this.element.show();
		this.select.show();
	}
}