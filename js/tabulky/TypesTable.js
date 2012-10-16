var TypesTable = {

	element:null,
	rows:null,
	downloadBtn:null,
	buttons:null,
	rankStepper:null,
	selectBox:null,
	totalTds:null,
	generalTds:null,
	opts:null,

	init: function( opts ) {

		var self = this;
		self.opts = opts;

		var tabulkyPage = $( "#tabulkyPage" );
		self.element = $("#tabulkyPage").find(".crimes");
		self.rows = self.element.find(".types").find( "tr" );

		//init rows
		self.rows.on( "mouseover", function() { 
			$tr = $( this );
			$tr.addClass("active");
		}).on( "mouseout", function() {
			$tr = $( this );
			$tr.removeClass("active");
		});

		var section = tabulkyPage.find( ".unitsSelect" );
		var firstRank =  section.find( ".rank" );
		self.selectBox = new PorovnaniSelectBox( section.find( "select.county" ), { onChange: self.handleSelectChange } );
		self.rankStepper = new RankStepper( firstRank, self.selectBox, { onChange: self.handleRankChange } );
		
		//populate selectboxes rankstepper property
		self.selectBox.rankStepper = self.rankStepper;
			
		//init download button
		self.downloadBtn = self.element.find(".downloadBtn");
		self.downloadBtn.on( "click", function( evt ) {
			evt.preventDefault();
		});

		//init buttons
		self.buttons = self.element.find(".displayRankBtn");
		self.buttons.on( "click", function( evt ) {
			evt.preventDefault();
			self.displayRanking( this );
		});

		self.generalTds = self.element.find( ".general" ).find( "tr td.left" );
		self.totalTds = self.element.find( ".total" ).find( "tr" ).eq( 1 ).find( "td" );

		//init select 
		self.select = tabulkyPage.find(".unitsSelect");
	},

	handleSelectChange:function( selectedId ) {
		if( TypesTable.opts.onAreaSelect ) TypesTable.opts.onAreaSelect.apply( this, [ selectedId ] );
	},

	handleRankChange:function( selectedId ) {
		//update app-wise data
		Application.updateSelectedUnit( selectedId );
	},

	displayRanking: function( btn ) {
		
		var $btn = $( btn );
		var $parentRow = $btn.parent().parent();
		var className = $parentRow.attr( "class" );
		className = className.split( " " )[ 0 ];
		
		if( this.opts.onDisplayRank ) this.opts.onDisplayRank.apply( this, [ className ] );
		//Tabulky.displayRankings();
	},

	updateToArea: function( area, data ) {
		this.selectBox.setValue( area );
		TypesTable.update( data );

		//call for data 
        //DataProxy.getDataForArea( area, complete, Application.filtersString );
	},

	setValue: function( selectedUnit ) {
		this.selectBox.setValue( selectedUnit );
		this.updateSelectedUnit( selectedUnit );
	},

	updateZoomLevel: function( data ) {
		this.selectBox.updateValues( data );
		this.rankStepper.updateRange( 1, this.selectBox.element.find("option").length - 1 );
		this.clearValues();
   	},

   	update: function( data ) {
   		if( !data ) return;

		var self = this;
	    this.index = data.index;
	    this.data = data.filterData;
	  	
	    //update totals 
	    var graphData = data.graphData.graph,
	    	portion = Math.round( graphData.solv.val / graphData.com.val * 100 );
	  
	    self.totalTds.eq( 1 ).text( addSpaces( graphData.com.val ) );
	    self.totalTds.eq( 2 ).text( addSpaces( graphData.index.val ) );
	    self.totalTds.eq( 3 ).text( addSpaces( graphData.solv.val ) );
	    self.totalTds.eq( 4 ).text( portion );

		//update data in all rows
		$.each( this.rows, function(i,v){
			var $row = $(v),
				className = $row.attr("class");
			
			//treat className for singularity
			var arr = className.split(" ");
			if( arr.length > 1 ) className = arr[ 0 ];
	        
	        var	rowData = self.data[ className ],
				comValue = rowData.com.val,
				solvValue = rowData.solv.val,
				percent = Math.round( ( solvValue / comValue ) * 100 );
			
			//check for NaN
			if( isNaN( percent ) ) percent = "-";

			var $tds = $row.find( "td" );
			//$tds.eq( 1 ).text( rowData.name ); 
			$tds.eq( 1 ).text( addSpaces( comValue ) ); 
			$tds.eq( 2 ).text( addSpaces( rowData.index ) );
			$tds.eq( 3 ).text( addSpaces( solvValue ) ); 
			$tds.eq( 4 ).text( percent );
		} );

		//update general
		self.generalTds.eq( 0 ).text( addSpaces( data.population ) );
		self.generalTds.eq( 1 ).text( addSpaces( data.officers ) );
		self.generalTds.eq( 2 ).text( addSpaces( Math.round( data.acreage ) ) );
		self.generalTds.eq( 3 ).text( addSpaces( data.index ) );
   	},

   	clearValues:function() {
   		var symbol = "-";
		this.element.find( "td.left" ).text( symbol );
		this.element.find( "td.right" ).text( symbol );
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