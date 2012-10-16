/* Author:
	zdenek.hynek@gmail.com
*/

var Map = {
	
	CUSTOM_MAP_TYPE_NAME: "Mapa kriminality",
	MAX_ZOOM:13,
	MIN_ZOOM:7,

	map:null,
    infoWindow:null,
    fussionTablesLayer:null,
      
	init:function( config ){
	
		var self = this;

		var styles = [{
                    featureType: "all",
                    elementType: null,
                    stylers: [
                        {lightness: 30},
                        {saturation:-100}
                    ]
                }];

		var styledMapOptions = {
		                 name: self.CUSTOM_MAP_TYPE_NAME,
		                 alt: self.CUSTOM_MAP_TYPE_NAME
		              }

		var grayMapType = new google.maps.StyledMapType(styles, styledMapOptions);
			
		var myOptions = {
                    center: new google.maps.LatLng(49.467718,15.250269),
                    zoom: 7,
                    panControl: false,
                    zoomControl: false,
                    mapTypeControl: false,
                    scaleControl: false,
                    streetViewControl: false,
                    overviewMapControl: false,
                    minZoom:6,
                   // scrollwheel: false,
                    mapTypeControlOptions: {
                        mapTypeIds: []
                    }
        };
        
        self.map = new google.maps.Map(document.getElementById(config.wrapperId),myOptions);
        self.map.mapTypes.set(self.CUSTOM_MAP_TYPE_NAME, grayMapType);
        self.map.setMapTypeId(self.CUSTOM_MAP_TYPE_NAME);

        self.infoWindow = new google.maps.InfoWindow();
        
        /*var styleValues = DataProxy.loadMapStyles( Application.zoomLevel );
        var styles = self.writeStyle( styleValues );

        self.fussionTablesLayer = new google.maps.FusionTablesLayer({
			map: self.map,
			heatmap: { enabled: false },
			query: {
				from: fusionTable
			},
            styles: styles,
                    
			suppressInfoWindows:true
		}); 

        self.fussionTablesLayer.enableMapTips({
            select: "'Name','ID'", // list of columns to query, typially need only one column.
            from: fusionTable, // fusion table name
            geometryColumn: 'Geometry', // geometry column name
            suppressMapTips: true, // optional, whether to show map tips. default false
            delay: 20, // milliseconds mouse pause before send a server query. default 300.
            tolerance: 8 // tolerance in pixel around mouse. default is 6.
        });

		google.maps.event.addListener(layer, 'click', function( event ) {
   			self.handleClick( event );
        });
                
        var overlay = new google.maps.OverlayView(); 
        overlay.draw = function() {}; 
        overlay.setMap( self.map );

        google.maps.event.addListener(layer, "mouseover",function( evt ){
            var point = overlay.getProjection().fromLatLngToContainerPixel( evt.latLng );
            
            var id = evt.row.ID.value;
            var temp = queryLocal(id);
            
            var data = { Name: evt.row.Name.value, value: temp[0], index: temp[2]};
            MapOverviewPopUp.show();
            MapOverviewPopUp.update( data, { top: point.y, left: point.x } );
        });

        google.maps.event.addListener( layer, "mouseout",function( evt ){
            MapOverviewPopUp.hide();
        });*/

        google.maps.event.addListener( self.map, "mouseout", function( evt){
            MapOverviewPopUp.hide();
        });

        google.maps.event.addListener( self.map, "dragstart", function( evt){
            MapOverviewPopUp.hide();
        });

        google.maps.event.addListener( self.map, "zoom_changed", function( evt){
            MapOverviewPopUp.hide();
        });

        //init MapOverviewPopup
        MapOverviewPopUp.init();
        
        self.updateFussionTableLayer();
	},
    
    updateFussionTableLayer:function() {

        var self = this;
        
        if( self.fussionTablesLayer ) {

            self.fussionTablesLayer.setMap( null );
            self.fussionTablesLayer = null;
        }

        var styleValues = DataProxy.loadMapStyles( Application.zoomLevel );
        var styles = self.writeStyle( styleValues );

        self.fussionTablesLayer = new google.maps.FusionTablesLayer({
            map: self.map,
            heatmap: { enabled: false },
            query: {
                from: fusionTable
            },
            styles: styles,
                    
            suppressInfoWindows:true
        }); 

        self.fussionTablesLayer.enableMapTips({
            select: "'Name','ID'", // list of columns to query, typially need only one column.
            from: fusionTable, // fusion table name
            geometryColumn: 'Geometry', // geometry column name
            suppressMapTips: true, // optional, whether to show map tips. default false
            delay: 20, // milliseconds mouse pause before send a server query. default 300.
            tolerance: 8 // tolerance in pixel around mouse. default is 6.
        });

        google.maps.event.addListener( self.fussionTablesLayer, 'click', function( event ) {
            self.handleClick( event );
        });
                
        var overlay = new google.maps.OverlayView(); 
        overlay.draw = function() {}; 
        overlay.setMap( self.map );

        google.maps.event.addListener( self.fussionTablesLayer, "mouseover",function( evt ){
            var point = overlay.getProjection().fromLatLngToContainerPixel( evt.latLng );
            
            var id = evt.row.ID.value;
            var temp = queryLocal(id);
            log(temp);
            var data = { Name: evt.row.Name.value, value: temp[0], index: temp[2]};
            MapOverviewPopUp.show();
            MapOverviewPopUp.update( data, { top: point.y, left: point.x } );
            var ranges = DynamicRange.classifyJenks( values, 5 );
            MapOverviewPopUp.updateRanges( ranges );
        });

        google.maps.event.addListener( self.fussionTablesLayer, "mouseout",function( evt ){
            MapOverviewPopUp.hide();
        });

    },

    handleClick:function( event ) {

        //prevent default
        Map.infoWindow.close();
        
        //update app model
        Application.updateSelectedUnit( event.row[ "ID" ].value, event.row );
        
        //store Area
        storeArea( event.row[ "ID" ].value );
    },

    writeStyle: function( data ) {
        
        //loop through everything to scope data
        var values = [];
        $.each( data, function( i, v ){
            values.push( v.i );
        });

        var ranges = DynamicRange.classifyJenks( values, 5 );
        Legend.updateRanges( ranges );
        MapOverviewPopUp.updateRanges( ranges );

        //loop to sort unit ids to ranges
        var colors = [];
        $.each( data, function( i, v ){
            var color = Legend.getColorFromIndexValue( v.i );
            //put ids into array 
            if( !colors[ color ] ) colors[ color ] = [ v.area ];
            else colors[ color ].push( v.area );
        } );

        //finally create style declaration
        var styles = [],
            len = colors.length;
        
        var z = 0;    

       for( color in colors ) {
            var whereClause =  "'ID' IN (" + colors[ color ].join(",") + ")";       
            styles.push( {
                    where: whereClause,
                    polygonOptions: { 
                        fillColor: color, 
                        fillOpacity:.5, 
                        strokeColor: "#333333",
                        strokeOpacity:.5
                    }
                } );
        }

        return styles;
    },

    zoomIn:function(){
		var self = this,	
			zoom = self.map.getZoom();
		
                if(zoom < self.MAX_ZOOM) {
                    zoom++;
                    self.map.setZoom(zoom);
                    return true;
                }
                else {
                    return false;
                }
	},

	zoomOut:function(){
		var self = this,	
			zoom = self.map.getZoom();


		if(zoom > self.MIN_ZOOM)
                {
                    zoom--;
                    self.map.setZoom(zoom);
                    return true;
                }
                else
                {
                    return false;
                }
	}
}
