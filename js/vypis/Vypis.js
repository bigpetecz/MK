var Vypis = {
	
	init: function(){
		console.log("init");

		var $vypisPage = $("#vypisPage");
		var padding = $vypisPage.css("padding");
		var listWidth = $vypisPage.width() - padding;
		
		//init list
		$("#list").jqGrid({
		   	url:'data/test.json',
			datatype: "json",
		   	colNames:['description','geometry'],
		   	colModel:[
		   		{name:'description', width:255},
		   		{name:'geometry', width:290}		
		   	],
		   	rowNum:10,
		   	rowList:[10,20,30],
		   	pager: '#pagerList',
		   	sortname: 'desc',
		    viewrecords: true,
		    sortorder: "desc",
		    caption:"Vypis dat",
		    width:listWidth,
		    //height:listHeight,
		    loadError:function(){
		    	console.log("loadError");
		    },
		    loadComplete:function(){
		    	console.log("loadComplete");
		    }
		});
		$("#pagerList").jqGrid('navGrid','#pager2',{edit:false,add:false,del:false});

		//bind events
		$countyDropBox = $vypisPage.find(".dropBoxes .county"); 
		$countyDropBox.on("change",function(){
			alert("Vybrane data: " + $countyDropBox.val() + ", " + $periodDropBox.val());
		});
	
		$periodDropBox = $vypisPage.find(".dropBoxes .period"); 
		$periodDropBox.on("change",function(){
			alert("Vybrane data: " + $countyDropBox.val() + ", " + $periodDropBox.val());
		});

	}

}