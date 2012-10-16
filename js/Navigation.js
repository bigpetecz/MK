var Navigation = {
	
	config:"",

	currentPage:null,

	init: function(config){
		var self = this;
		self.config = config;

		//init nav links
		$("#" + config.wrapperId + " a").each(function(){
			
			var $this = $(this);

			$this.on("click",function(){
				self.changePage($this.attr("href"))
			});
		});

		//check address if there's hash, load specific page
		var hash = window.location.hash;
		if(hash)
		{
			console.log("hash in url: " + hash);
			this.changePage(hash);
		}
		else
		{
			console.log("no hash load homepage")
			//no hash, load homepage
			this.changePage();
		}

		
	},

	changePage: function(slug){
		var self = this;

		//get url base on id
		var url = "homepage.html";
		self.currentPage = Homepage;

		switch(slug)
		{
			case "#porovnani":
				url = "porovnani.html";
				break;
			case "#tabulky":
				url = "tabulky.html";
				self.currentPage = Vypis;
				break;
			case "#kontakty":
				url="kontakty.html"
				break;
			case "#oAplikaci":
				url = "oAplikaci.html";
				break;	
			
		}

		//get remote document, cannot use load, cause it replace html content straight away
		$.ajax({
			url:url,
			dataType:"html",
			success:function(results){
				self.displayPage(self,results);
			}
		});
		//$("#main").append("<div>content</div>");
		//$("#pageContent").load(url,self.displayPage);
	},

	displayPage: function(self,results){
		
		//remove previous pagecontent
		$(".insertedPageContent").remove();

		//display new
		var strippedString = $.trim(results);
		var html = $(strippedString);
		//inject class to schedule for replacement
		html.each(function()
		{
			$(this).addClass("insertedPageContent");
		});
		$("#" + self.config.mainContentId).append(html);
		
		//init class
		//self.currentPage.init();

	},

	updatePage: function(data)
	{
		var self = this;
		self.currentPage.update(data);
	}

	
}