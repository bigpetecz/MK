function RankingSelectBox( element, opts ) {
	
	this.element = element;
	this.options = this.element.find("option");
	this.selectedType = null;
	this.opts = opts;
	
	var self = this;
	
	this.element.on("change", function() {
		self.changeHandler( this );
	});
}

RankingSelectBox.prototype.changeHandler = function( btn ) {
	var name = $( btn ).val();
    var selectedOption = this.options.filter("[value='" + name + "']" );
    this.selectedType = selectedOption.data( "type" );
    
    if( this.opts.onChange ) this.opts.onChange.apply( this, [ this.selectedType ] );
}

RankingSelectBox.prototype.setValue = function( type ){
	//set rankStepper value
	var selectedOption = this.options.filter("[data-type='" +type + "']" );
	selectedOption.attr('selected','selected');
	selectedOption.trigger("liszt:updated");

    this.selectedType = type;//selectedOption.data( "area" );
}

/*
RankingSelectBox.prototype.updateValues = function( values ){
	
	//log( values );
	var self = this;
	self.element.empty();

	self.element.append( "<option data-rank='0' data-area='0'></option>" );

	$.each( values, function( i, value ) {
		var rank = i + 1;
		self.element.append( "<option data-rank='" + value.rank + "' data-area='" + value.area + "'>" + $.trim( value.Name ) + "</option>" );
	});

	self.element.trigger( "liszt:updated" );
	//update values
	self.options = this.element.find("option");
	this.selectedId = -1;
}*/
