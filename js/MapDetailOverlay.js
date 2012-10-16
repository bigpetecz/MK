var MapDetailOverlay = {
	
	CIRCLE_RADIUS: 113,
	CIRCLE_GAP: 7,
	ARC_WIDTH: 54,
	ARC_GAP: 2,
	X_ORIENTATION: -90,
	MARGIN_LEFT: 100,
	MARGIN_TOP: 100,

	paper:null,
	detailBox:null,
	graph:null,
	graphArc:null,
	$centerText:null,
	data:null,
	animated:null,
	$svg:null,
	darkOverlay:null,

	display:function(data, animated){
		
		//debug
		$('.contact').hide();

		var self = this,
			width = $(window).width(),
			height = $(window).height(),
			cx = width/2 + self.MARGIN_LEFT,
			cy = height/2,// - self.MARGIN_TOP,
            pathObject = null, 
			totalCount = 0, 
			totalPieces = 0, 
			startAngle = 0;

		if( !self.darkOverlay ) {
			self.darkOverlay = $( ".mapDetailOverlayBack" );
		}

		self.darkOverlay.show();

		self.data = data;
		self.animated = animated;	

		if(!self.paper){
			//init raphael
			self.paper = Raphael( 0, 0, width, height );
		
			//dislaying for the first time, init things once
			//bind resize handler
			
			self.$svg = $("svg");
			$(window).resize( function(){ self.resize(); } );
		}
		else{
			if( self.$centerText ) self.$centerText.remove();
			if( self.paper ) self.paper.clear();
		}

		self.$svg.show();
		
		var callback = function(evt){
				self.close.apply(self);
			};

		self.$svg.click( callback );

		//draw circle

		//adjust size of overlay to for markers width
		self.graph = self.paper.set();
		var circleRadius = ( animated ) ? 0 : self.CIRCLE_RADIUS;
		var circle = self.paper.set();
		
		//bug in raphael.js, need to overaly bit the arcs to avoid gap
		var graphicsOverlay = .3; 

		var fullCircle = 360,
			solved = data.graph.solv.val,
			unsolved = data.graph.com.val - data.graph.solv.val,
			solvedArc = ( solved/data.graph.com.val ) * fullCircle,
			unsolvedArc = ( unsolved/data.graph.com.val ) * fullCircle;

		//check data for sanity
		if( unsolved < 0 ) {
			//wrong data
			var errorText = self.paper.text(cx, cy, "Chyba v datech,\n více objasněných než spáchaných.").attr('font-size', '30px'); ;
			return;
		}
		
		//if fullCircle, don't use graphics overlay
		if( fullCircle == 360 ) graphicsOverlay = 0;
		else graphicsOverlay = .3;

		//check for full 360
		solvedArc = Math.min( solvedArc, 359.99);
		unsolvedArc = Math.min( unsolvedArc, 359.99);

		var circleRadiusArc1 = self.drawPieChartArc( cx, cy, self.CIRCLE_RADIUS, 0, solvedArc, {"fill":"#555555","stroke-width":0});//self.paper.circle( cx, cy, circleRadius);
		var circleRadiusArc2 = self.drawPieChartArc( cx, cy, self.CIRCLE_RADIUS, solvedArc - graphicsOverlay , solvedArc+unsolvedArc,{"fill":"#333333","stroke-width":0});
		
		circle.push( circleRadiusArc1 );
		circle.push( circleRadiusArc2 );
		circle.rotate( -90, cx, cy );
		circle.scale( 1, -1, cx, cy );

		circle.click(callback);
		self.graph.push(circle);
		
		callback = function(evt){
				self.handleArc.apply(self,[evt, data.graph]);
		};

		circle.mouseover( callback )
			  .mouseout( callback )
			  .mousemove( callback );
		//display values
		$.each(data.graph.data,function(i,v){
			totalCount += v.com.val;
			totalPieces++;
		});

		self.graphArcs = self.paper.set();

		//flag if graph has children
		var hasChildren = false,
			hasData = false;

		$.each(data.graph.data,function(i,v){

			//it's okay, graph gonna be displayed
			hasChildren = true;

			//calculate angle to divide between pieces, need to substract gaps
			var fullCircle = ( totalPieces > 1 ) ? 360 - ( ( self.ARC_GAP - graphicsOverlay ) * totalPieces) : 360,
				solved = v.solv.val,
				unsolved = v.com.val - v.solv.val,
				solvedArc = (solved/totalCount) * fullCircle,
				unsolvedArc = (unsolved/totalCount) * fullCircle;

			//check if comitted crimes are not zero
			if( v.com.val > 0) hasData = true;

			//if fullCircle, don't use graphics overlay
			if( fullCircle == 360 ) graphicsOverlay = 0;
			else graphicsOverlay = .3;

			//enforce minimun angles on arcs
			var minimum = .75;
			if( solvedArc < minimum && unsolvedArc < 360 ) {
				solvedArc = minimum;
				startAngle -= minimum;
			}
			if ( unsolvedArc < minimum && solvedArc < 360) {
				unsolvedArc = minimum;
				endAngle += minimum;
			}	

			var groupArc = self.paper.set();
			
			//draw unsolved arc
			if( unsolvedArc == 360 ) unsolvedArc = 359.99; 
			var endAngle = startAngle + unsolvedArc;
			var arc2 = self.drawArc( cx, cy, startAngle, endAngle);
			arc2.attr( {"stroke-width":self.ARC_WIDTH, "stroke":v.com.col} )

			//draw solved arc, push overlay
			if( solvedArc == 360 ) solvedArc = 359.99; 
			startAngle = endAngle - graphicsOverlay;
			endAngle = startAngle + solvedArc;
			var arc1 = self.drawArc( cx, cy, startAngle, endAngle);
			arc1.attr( {"stroke-width":self.ARC_WIDTH, "stroke":v.solv.col} )

			callback = function(evt){
				self.handleArc.apply(self,[evt,v]);
			};

			groupArc.push( arc1, arc2);
			groupArc.mouseover( callback )
				   .mouseout( callback )
				   .mousemove( callback );

			startAngle = endAngle + self.ARC_GAP;

			//self._graph.push(groupArc);
			self.graphArcs.push(groupArc);
		});

		self.graph.push( self._graphArcs );

		//is graph to be displayed
		if( !hasChildren || !hasData ){
			//nothing to display, hide graph
			self.paper.clear();
			return;
		}
		
		//append center html text
		self.$centerText = $("<div class='graphText'><span class='indexName'> </span><span class='indexValue'> </span><span class='country'> </span></div>");
		self.$svg.after(self.$centerText);
		self.$centerText.find("span").css({display:"block"});
		self.$centerText.find("span.country").text(data.graph.country);
		self.$centerText.find("span.indexValue").text( addSpaces( data.graph.index.val ));
		self.$centerText.find("span.indexName").text(data.graph.index.name);

		//center text
		self.$centerText.css({position:"absolute"});
		var elWidth = self.$centerText.width(),
			elHeight = self.$centerText.height();
		self.$centerText.css({left:width/2 + self.MARGIN_LEFT - elWidth/2,top:height/2 - elHeight/2 - 25});

		//load box
		//create wrapper
		if( !self.detailBox ) {
			self.detailBox = $("<div></div>");
			self.detailBox.load(templateDir + "/mapDetailOverlayBox.html");
			self.detailBox.css({position:"absolute"});
			self.detailBox.css("pointer-events", "none");
			self.$centerText.after(self.detailBox);
			self.detailBox.hide();
		}

		self.$centerText.find("a").on("click", function(){
			self.close();
		});

		//appear everything
		if( animated ) {
			circle.animate( {scale:5 },1000);
			//groupArc.hide();
			self.$centerText.hide();
			self.graphArcs.hide();
			self.graph.attr( {opacity:0} );
			self.graph.animate({opacity: 1}, 300);
			setTimeout( self.appear, 300 );

			MapOverviewPopUp.hide();
		}
		else 
		{
			//no animation
			self.appear();
		}
	},

	appear:function(){
		var self = MapDetailOverlay;
		self.$centerText.show();
		self.graphArcs.show();
	},

	drawArc:function( cx, cy, startAngle, endAngle){
		
		var self = this;
			arcRadius = self.CIRCLE_RADIUS + self.CIRCLE_GAP + self.ARC_WIDTH/2;

		var callback = function(evt){
			self.handleArc.apply(self,[evt]);
		};

		return self.paper.path( Arc.draw( cx, cy, startAngle, endAngle, arcRadius, self.X_ORIENTATION ) );
	},

	handleArc:function(evt, data){
		
		var self = this;
		var offsetY = 0;
		var offsetX = -4;
		
		switch(evt.type){
			case "mouseover":
				self.displayDetailBox( data );
				self.moveBoxToPosition( evt.clientX - offsetX, evt.clientY - offsetY );
				break;
			case "mouseout":
				self.detailBox.hide();
				break;
			case "mousemove":
				self.moveBoxToPosition( evt.clientX - offsetX, evt.clientY - offsetY );
				break;		
		}
		
	},

	drawPieChartArc: function(cx, cy, r, startAngle, endAngle, params) {
        var self= this,
        	rad = Math.PI / 180,
			x1 = cx + r * Math.cos(-startAngle * rad),
            x2 = cx + r * Math.cos(-endAngle * rad),
            y1 = cy + r * Math.sin(-startAngle * rad),
            y2 = cy + r * Math.sin(-endAngle * rad);
        return self.paper.path(["M", cx, cy, "L", x1, y1, "A", r, r, 0, +(endAngle - startAngle > 180), 0, x2, y2, "z"]).attr(params);
    },

	displayDetailBox:function(data){
		
		var self = this;
		//make it visible
		self.detailBox.show();
		
		//update data	
		self.detailBox.find("h2").text(data.name);
		self.detailBox.find(".first td").eq(2).text( addSpaces( data.com.val ) );
		self.detailBox.find(".second td").eq(2).text( addSpaces( data.solv.val ));
		
		self.detailBox.find(".first .legend").css( "backgroundColor", data.com.col );
		self.detailBox.find(".second .legend").css( "backgroundColor",  data.solv.col );

		var percentage = Math.round( ( data.solv.val / data.com.val) * 100 );
		//check for NaN
		if( isNaN( percentage ) ) percentage = "0";
		self.detailBox.find(".percentage .value").text( percentage + " %" );

		
	},

	moveBoxToPosition:function(x,y){
		this.detailBox.css( { left:x - this.detailBox.width()/2 , top:y - this.detailBox.height()} );
	},

	resize:function(width, height){

		var self = this;

		if( !self.$centerText ) return;
		
		self.display( self.data, false );
	},

	close:function(){
		
		var self = this;

		if( !self.graphArcs ) return;

		self.graphArcs.hide();
		self.graph.attr( {opacity:1} );
		self.graph.animate({opacity: 0}, 300);
		if( self.$centerText ) self.$centerText.remove();

		if( self.detailBox ) self.detailBox.hide();

		setTimeout( function(){
			self.doClose(); }, 300 );
	},

	doClose:function(){
		var self = this;
		self.$svg.hide();
		self.darkOverlay.fadeOut();
	},

	isDisplayed:function(){
		return ( this.$svg && this.$svg.css("display") == "block" ) ? true : false;
	}


}