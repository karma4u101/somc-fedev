jQuery(function(){
	
	var Menu = function(data) {
		this.data = data;
	};		
		
	Menu.prototype.render = function(root,key,depth,udt) {
		var dataHasMenu=false;
		var topLevelElement=false;
		var li,ul,a,dt,dtId,addNode;
		
		if(this.data.menu && this.data.menu.length>0){
			dataHasMenu=true;
		}		
		if(depth==1){topLevelElement=true;}
		
		if (depth < 10){
			dt='#kwnav-'+udt+'-0'+depth;
			dtId='kwnav-'+udt+'-0'+depth;
		}else{ 
			dt='#kwnav-'+udt+'-'+depth; 
			dtId='kwnav-'+udt+'-'+depth;
		}
		if (key < 10){ 
			dt+='-0'+key; 
			dtId+='-0'+key;
	    }else{ 
	    	dt+='-'+key;
	    	dtId+='-'+key;
	    }		
		
		if(topLevelElement){
			li = jQuery("<li class=\"top-decor\"></li>");
		}else{
			li = jQuery("<li></li>");
		}
		
		var stitle = this.data.post_title;
		if(stitle.length>20){
			stitle=stitle.substring(0,20)+"...";
		}		
		
		if(dataHasMenu){
		    a = jQuery("<a></a>", {
			    href : '#'/*this.data.guid*/,
			    text : stitle,
			    title : this.data.post_title,
				"data-target" : dt,
				"data-toggle" : "collapse",
				"data-parent" : "#kwnav-navigation"				    
		    });		
		    var span = jQuery("<span class=\"pull-right glyphicon glyphicon-chevron-right\"></span>");
		    span.appendTo(a)
		}else{
		    a = jQuery("<a></a>", {
			    href : '#'/*this.data.guid*/,
			    text : stitle,
			    title : this.data.post_title,
		    });
	    }
		addNode = li.append(a);
		addNode.appendTo(root);						
	    
		if (this.data.menu ) {	
			var sul = jQuery("<ul></ul>",{
				"class" : "collapse",
				id : dtId
			})
			Menu.renderMenus(this.data.menu,sul.appendTo(addNode),depth,udt );
		}
	};
	
	Menu.renderMenus = function(menus,root,depth,udt) {
	    if (typeof depth == 'number')
	        depth++;
	    else
	        depth = 1;			
		
		jQuery.each(menus, function(key,val) {				
			var m = new Menu(val);
			m.render(root,key+1,depth,udt);
		});
	}
		
	Menu.renderMenus(kwmenu, jQuery("#kwnav-container-asc"),0,"asc");
	Menu.renderMenus(kwmenu2, jQuery("#kwnav-container-desc"),0,"desc");

	/*Bootstrap collapse triggers */
	jQuery(".nav-kwnav li").on("show.bs.collapse", function () {
		jQuery(this).addClass("kwnav-active-background");
		jQuery(this).find(".glyphicon").first().removeClass("glyphicon-chevron-right").addClass("glyphicon-chevron-down");
	});
	jQuery(".nav-kwnav li").on("hide.bs.collapse", function (e) {
		e.stopPropagation();
		jQuery(this).removeClass("kwnav-active-background");
		jQuery(this).find(".glyphicon").first().removeClass("glyphicon-chevron-down").addClass("glyphicon-chevron-right");
	});		
	/*End - Bootstrap collapse triggers */	
	
	//toggle show the list in asc/desc sort order. 
	jQuery( "#togglekwlist" ).click(function() {
		jQuery('#kwnav-container-asc').toggle();
		jQuery('#kwnav-container-desc').toggle();
	});	
}); 


//function togglekwlist() {
//	jQuery('#kwnav-container-asc').toggle();
//	jQuery('#kwnav-container-desc').toggle();
//}	
	
