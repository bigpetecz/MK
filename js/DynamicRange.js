var DynamicRange = {

	ranges:null,

	classifyJenks:function( items, numClasses ){

		//go thru parameters, assing default values
		if( items === "undefined") return;
		if( typeof numClasses === 'undefined' ) numClasses = 5;
		
		//create geostats object
		var stats = new geostats();
		//set data
		stats.setSerie( items );
		
		//classify data using selected method
		var a = stats.getJenks( numClasses );

		//empty previous data
		this.ranges = [];

		//turn string ranges to arrays
		var len = stats.ranges.length;
		for( var i = 0; i < len; i++)
		{
			var range = stats.ranges[ i ];
			var arr = range.split("-");
			this.ranges.push( arr );
		}

		//store values
		this.ranges = stats.ranges;

		//return result
		return this.ranges;
	}

}