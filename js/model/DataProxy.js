var DataProxy = {

	NAMES_INDEXES_KEYWORD:"namesAndIndexes",

	cachedData:[],

	//load data for select box at porovnani
	getNamesAndIndexes:function( zoomLevel ){
		
		var self = this;
		
		var cachedData = this.getCachedData( this.NAMES_INDEXES_KEYWORD );
        if( cachedData ) {
        	//log("getNamesAndIndexes data already exists!!!")
        	//log( cachedData );

        	return cachedData;
        }

        Preloader.show();
		var data = getNamesAndIndexes( zoomLevel );
		
		//clone array
		var tempArr = data.slice(0);
			
		tempArr.sort( function( a, b ) {
			return b.i - a.i;
		});

		//clone everything into array
		var nameArray = [];
		var len = tempArr.length;
		
		for( var i = 0; i < len; i++ ) {
			var row = tempArr[ i ];
			nameArray[ row.Name ] = i;
		}

		//append to original array
		for( var q = 0; q < len; q++ ) {
			row = data[ q ];
			rank = nameArray[ row.Name ] + 1;

			data[ q ].rank = rank;
			
			//trim the whitespace
			data[ q ].Name = $.trim( data[ q ].Name );

			//save maximum value
			if( rank == 1 ) {
				var maxValue = data[ q ].i;
				data.maxValue = maxValue;
			}
		}
		
		//store value
		self.storeCachedData( self.NAMES_INDEXES_KEYWORD, data );
		Preloader.hide();

		return data;
	},

	getCrimesForArea:function( area, callback, selectBox ) {

		var table = countryTable;
		if( Application.zoomLevel == 1 ) table = countyTable;
		else if( Application.zoomLevel == 2 ) table = districtTable;
		
		log("getCrimesForArea");
		log( table );

        var queryUrlHead = 'http://www.google.com/fusiontables/api/query?sql=';
        var queryUrlTail = '&jsonCallback=?'; // ? could be a function name
        
        // write your SQL as normal, then encode 
        var query = "";
        if( Application.zoomLevel < 2 ) {
        	query = "SELECT Name, TotalDamage,Acreage,Population,Officers,Rank,ContactFormContent,ContactFormEmail FROM " + table + " WHERE ID = " + area;
        } else {
        	query = "SELECT Name FROM " + table + " WHERE ID = " + area;
        }
        
      	//query = "SELECT Name, TotalDamage,Acreage,Population,Officers,Rank,ContactFormContent,ContactFormEmail FROM " + table + " WHERE ID = " + area;
      

        //var query = "SELECT Name, TotalDamage,Acreage,Population,Officers,Rank,ContactFormContent,ContactFormEmail FROM " + table + " WHERE ID = " + area;
       	//log( queryUrlHead + query + queryUrlTail );

        var queryurl = encodeURI(queryUrlHead + query + queryUrlTail);
	    var jqxhr = $.get(queryurl, function( data ) {
	    		callback.apply( this, [ selectBox, data ] );
	    	}, "jsonp"); 
     	
	},

	getDataForArea: function( area, callback, filters, dataFromMap  ) {
		
		//get all crimes
        var self = this;

        //store current keystring
        var keyString = Application.currentKey();

        //check if stored data exist
        var cachedData = this.getCachedData( area );
        if( cachedData ) {
        	log("data already exists!!!")
        	log( cachedData );

        	callback.apply( this, [ cachedData ] );
        	return;
        }

        Preloader.show();

        //need to wait to allow for display preloader
        setTimeout( function() {

        	var	temp = queryCrimes( area, filters ),
        	total = queryLocal( area, undefined, filters  );
        	d = {},
        	data = {},
        	solv = 0,
        	com = 0,

        	index = total[2],
        	len = Application.filters.length;
        	
	        for (var i = 0; i < len; i++) {  
	            d[ Application.filters[ i ].name ] = temp[ Application.filters[ i ].name ];  
	            solv += temp[ Application.filters[ i ].name ].solv.val;
	            com += temp[ Application.filters[ i ].name ].com.val;
	        } 

	        var graphData = {
	                    graph: {
	                        country: temp.name, 
	                        index:{name : "index kriminality",val : index}, 
	                        name:"TRESTNÉ ČINY CELKEM",
	                        solv:{ col:"#555555", val: solv }, 
	                        com:{ col:"#444444", val: com },
	                        trend:10,
	                        data: d
	                       }
	            };
	        
	        data.id = area;
	        data.index = index;
	        data.com = com;
	        data.filterData = temp;
	       	data.graphData = graphData;
                
                var damage = getDamage(area);
                data.damage = damage;

	       	if( dataFromMap ) {
	        	data.name = dataFromMap[ "Name" ].value;
		        data.acreage = (dataFromMap[ "Acreage" ]) ? dataFromMap[ "Acreage" ].value : 0;
		        data.population = (dataFromMap[ "Population" ]) ? dataFromMap[ "Population" ].value  : 0;

                        

		        //data.damage = loadDamage();
	            if(dataFromMap["Officers"] && dataFromMap["Officers"].value == null) {
	                data.officers = "data nejsou k dispozici";
	            }
	            else {
	                data.officers = ( dataFromMap[ "Officers" ] ) ? dataFromMap[ "Officers" ].value : 0;
	            }

		        var contact = {};
		        contact.address =(dataFromMap[ "ContactFormContent" ]) ? dataFromMap[ "ContactFormContent" ].value : 0 ;
		        contact.email = (dataFromMap[ "ContactFormEmail" ])? dataFromMap[ "ContactFormEmail" ].value : 0;
		    	data.contact = contact;

		        callback.apply( this, [ data ] );

		       	self.storeCachedData( area, data, keyString );
		       	Preloader.hide();
	        } else {
				function complete( selectBox, result ) {

	        		var row = result.table.rows[0];
	        		data.name = row[ 0 ];
		        	data.officers = row[ 4 ];
		        	data.acreage = row[ 2 ];
		        	data.population = row[ 3 ];
	   	        
		        	var contact = {};
			        contact.address = row[ 6 ];
			        contact.email = row[ 7 ];
			    	data.contact = contact;

		        	callback.apply( this, [ data ] );
		        	log("storing data for area: " + area );
		        	log( data );
		        	self.storeCachedData( area, data, keyString );
		        	Preloader.hide();
	        	}

	        	log("getting crime for area: " + area );
	        	log( data );
	        	self.getCrimesForArea( area, complete );
			}
        }, 50 ); // end of timeout functin

        
    },

   getRankingsForCrimeType: function( crimeType, callback ) {
   		var crimeTypeId = getCrimeTypeIdByKeyword( crimeType );
   		var data = getRankingsForCrimeType( Application.zoomLevel, crimeTypeId );
   		callback.apply( this, [ data ]);
	},

	storeCachedData: function( key, data, currentKey ) {
		
		if( !currentKey ) currentKey = Application.currentKey();

		if( !this.cachedData[ currentKey ] ) this.cachedData[ currentKey ] = [];
		this.cachedData[ currentKey ] [ key ] = data;
	
		/*log( "storing cached data" );
		log( currentKey );
		log( key );
		log( data );*/
	},

	loadMapStyles: function( zoomLevel ) {
		var data = loadMapStyles( zoomLevel );
		
		return data;
	},	

	loadTimeline: function() {
		var data = loadTimeline();
		return data;
	},

	getCachedData: function( key ) {
		//log("retrieving cache data: " + key );

		return ( this.cachedData[ Application.currentKey() ] && this.cachedData[ Application.currentKey() ] [ key ] ) ? this.cachedData[ Application.currentKey() ] [ key ] : null;
	}
}