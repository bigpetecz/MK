function PorovnaniTable( element ){

	this.element = element;
	this.rows = this.element.find("section.table table tr");
	this.data = null;
	this.index = 0;
	this.maxIndexValue = 0;
}

PorovnaniTable.prototype.update = function( data ){

	if( !data ) return;

	var self = this;
    this.index = data.index;
    this.data = data.filterData;
  	var maxWidth = self.maxBarWidth();
	var logBase = .1;
	
	//update static values
	self.updateStaticValues( data.damage, data.officers );

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

		$row.find("td.title").text( rowData.name ); 
		$row.find("td.first").text( addSpaces( comValue ) ); 
		$row.find("td.second").text( addSpaces( solvValue ) ); 
		$row.find("td.third").text( percent );
		$row.find("td.bar .value").text( addSpaces( rowData.index ) );
		
		var width = ( Math.sqrt( rowData.index, logBase ) / Math.sqrt( self.maxIndexValue, logBase )  ) * maxWidth;
		$row.find("td.bar div.graph").width( width );
	});
        
    self.element.find("h2").html( self.index );

   // var maxIndexValue = ( index > index2 ) ? index : index2;
    var width = ( Math.sqrt( self.index, logBase ) / Math.sqrt( self.maxIndexValue, logBase ) ) * maxWidth;
    log( "max width" );
    log( width, self.index, self.maxIndexValue, maxWidth );
    self.element.find( ".index div.graph" ).width( width );
	self.computeVisibleValues();
}

PorovnaniTable.prototype.updateTotalValues = function( totalCom, totalSolv ){
	//update total values
   	var $totalTableValues = this.element.find(".total").find(".values");
  	$totalTableValues.find(".first").html( addSpaces( totalCom ) );
  	$totalTableValues.find(".second").html( addSpaces( totalSolv ) );
  	var totalPercentage = Math.round( ( totalSolv / totalCom ) * 100 );
  	//check for NaN
	if( isNaN( totalPercentage ) ) totalPercentage = "-";
  	$totalTableValues.find(".third").html( totalPercentage );
}

PorovnaniTable.prototype.updateStaticValues = function( damage, officers ){
	//update static values
   	var $staticTableValues = this.element.find(".staticData").find(".total");
   	var $tds = $staticTableValues.find( "td" );
   	$tds.eq(0).html( damage + " Kč" );
  	$tds.eq(1).html( officers );
}

PorovnaniTable.prototype.computeVisibleValues = function(){

	var self = this,
		visibleRows = this.rows.filter(":visible"),
		totalCom = 0,
		totalSolv = 0;

	if( !self.data ) return;

	$.each( visibleRows, function(i,v){
		var $row = $(v),
			className = $row.attr("class");

		//treat className for singularity
		var arr = className.split(" ");
		if( arr.length > 1 ) className = arr[ 0 ];
                   	 
		var	rowData = self.data[ className ],
			comValue = rowData.com.val,
			solvValue = rowData.solv.val;

		totalCom += comValue;
		totalSolv += solvValue;
	});

	this.updateTotalValues( totalCom, totalSolv );

}

PorovnaniTable.prototype.maxBarWidth = function() {
	var offset = ( Application.screenWidth > 1200 ) ? 440 : 360;

	return Application.screenWidth / 2 - offset;
}

PorovnaniTable.prototype.resize = function() {

	this.update( { index: this.index, data: this.data } );
}

PorovnaniTable.prototype.clearValues = function() {

	var symbol = "-";
	this.element.find( "td.first" ).text( symbol );
	this.element.find( "td.second" ).text( symbol );
	this.element.find( "td.third" ).text( symbol );

	//clear static data 
	var $staticTableValues = this.element.find(".staticData").find(".total");
   	var $tds = $staticTableValues.find( "td" );
   	$tds.text( symbol );

   	//clear index value
   	this.element.find("h2").text( symbol );

   	//clear bars
   	this.rows.find("td.bar div.graph").width( 0 );
   	this.rows.find("td.bar div.value").text( "" );
   	this.element.find( ".index div.graph" ).width( 0 );

}


/**
* @function Math.logx
* @purpose: To provide the logarithm for any base desired. Default base is 10.
* @returns a number.
*/
Math.logx = function(x,base) {
    return (Math.log(x)) / (Math.log(base | 10 ));
}