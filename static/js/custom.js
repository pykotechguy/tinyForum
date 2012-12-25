jQuery(document).ready(function(){
	initCat();
	initTop();
	initTabs("div.tabs-obj");
	initMenu();
});
function initMenu(){
	$("div.topmenu ul.menu").children().hover(
		function(){
			$(this).addClass("shover");
		},
		function(){
			$(this).removeClass("shover");
		}
	);
	$("div.topmenu2-obj ul.menu").children().hover(
		function(){
			$(this).addClass("shover");
		},
		function(){
			$(this).removeClass("shover");
		}
	);
}
function initTabs(block){
	var tabs_block=block;
	$(tabs_block).find("ul.tabs").children().click(function(){
		if(!$(this).find("a:first").is(".active")){
			$(tabs_block).find("ul.tabs").children().find("a.active").removeClass("active");
			$(this).find("a:first").addClass("active");
			var temp=0;
			$(tabs_block).find("ul.tabs").children().each(function(i){
				if($(this).find("a:first").is(".active")){temp=i;}
			});
			$(tabs_block).find("div.tabcontent").each(function(i){
				if(i==temp){$(this).removeClass("hidden");}
				else if(!$(this).is(".hidden")){$(this).addClass("hidden");}
			});
		}
	});
}
function initTop(){
	if($('div.totop-obj').length>0){
		var w1=$('body').width();
		var w2=944;
		var w3=(w1-944)/2-32;
		$('div.totop-obj').css('right',w3);
	}
}
function initCat(){
	//console.log('init cat is called.');
	if($('div.cats-obj').length>0){
		$('div.cats-obj').each(function(){
			var cat=$(this);
			$(this).find('a.collapse').click(function(){
				//console.log('a.collapse is clicked.');
				$(cat).find('a.collapse').hide();
				$(cat).find('a.expand').show();
				$(cat).find('div.posts').hide();
			});
			$(this).find('a.expand').click(function(){
				$(cat).find('a.collapse').show();
				$(cat).find('a.expand').hide();
				$(cat).find('div.posts').show();
			});
		});
	}
}
jQuery(window).bind('scroll', function(){
if(jQuery(this).scrollTop() > 200) 
 jQuery("div.totop-obj").fadeIn(200);
else
 jQuery("div.totop-obj").fadeOut(200);
 


});
