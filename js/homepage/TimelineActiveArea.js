var TimelineActiveArea = {

	element:null,
	leftSlider:null,
	leftSliderStartOffset:null,
	rightSlider:null,
	rightSliderStartOffset:null,
	gap:10,
	minLeft:0,
	maxLeft:0,
	
	init:function( gap, leftBoundWidth, rightBoundWidth ){

		var self = this;
		self.gap = gap;
		self.element = $(".activeArea");
		self.leftSlider = self.element.find(".left");
		self.leftSliderStartOffset = self.leftSlider.offset().left;
		self.rightSlider = self.element.find(".right");
		self.rightSliderStartOffset = self.rightSlider.offset().left;

		self.minLeft = leftBoundWidth;
		self.maxLeft = rightBoundWidth;

		var startX = 0;
		self.handleSlider( self.leftSlider );
		self.handleSlider( self.rightSlider );

		self.element.hide();
	},

	handleSlider:function($div, dir){
		var self = this,
			startX = 0;

		$div.bind("dragstart",function( event ){
			startX = event.offsetX
		}).bind("drag",function( event ){
           	var diff = event.offsetX - startX,
           		left = parseInt( self.element.css("left") );
           		width = parseInt( self.element.css("width") );
           		newLeft = left + diff,
           		newWidth = width + diff;
           		leftSlider = ( $div == self.leftSlider );
           	
           	//enforce bounds
			if(leftSlider) {
				if( newLeft < self.minLeft ) return;
           	}
           	else{
           		if( newWidth < 20 || ( newLeft + newWidth ) > self.maxLeft ) return; //newWidth = self.maxLeft - newLeft;// return;
           	}

           	if( leftSlider ){
           		newWidth = width - diff;
           		self.element.css( { left:newLeft, width:newWidth } );
           		Timeline.displayBoxWhileDragging(  left );
           	} else {
           		self.element.css( { width: newWidth } );
           		Timeline.displayBoxWhileDragging(  left + newWidth );
           	}
			
			startX = event.offsetX;

		}).bind( "dragend" , function( event ) {
			var dir = ( $div == self.leftSlider ) ? "left" : "right";
			Timeline.sliderMoved( self.element.position().left, self.element.width(), dir);
		});
	},

	update:function( position, width ){
		var self = this;
		self.element.css( { left:position });
		self.element.width( width );
	},
	
	hide:function(){
		TimelineActiveArea.element.hide();
	},

	show:function(){
		TimelineActiveArea.element.show();
	}

}