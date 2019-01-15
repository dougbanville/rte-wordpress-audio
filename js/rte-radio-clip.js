(function( $ ) {
	'use strict';
	
	window.onload = function () {

	
	//fp.style.backgroundColor = "red";
	//console.log(fp);
		
	flowplayer("#rte", {
		ratio: 9/16,
		splash: true,
		coverImage: rte_vars["picture"],

	 
		playlist: [{
		  audio: true,
		  sources: [
			{ type: "audio/mpeg", src: rte_vars["audio"] }
		  ]
		}]
	 
	  });

	}

	flowplayer(function(api, root){
		api.on("load",function(){
			//alert("ready")
		})
	})

	$("#rte").css("background-image","url('" + rte_vars["picture"] + "')");

})( jQuery );
