$(function(){
		$(".hide,.hideshow").hide();
		$(".hideshow").fadeIn(600);
		
		
		$(".softbutton a").stop().fadeTo("fast", .65);
		$(".softbutton a").hover(
			function(){
				$(this).stop().fadeTo("fast", 1);
			},
			function(){
				$(this).stop().fadeTo("fast", .65);
			}
		);
		
		
		// Dropdown menu
		$('ul.sf-menu')
			.supersubs({ 
				minWidth:    5,   
				maxWidth:    25,
				extraWidth:  1
			})
			.superfish({ 
				delay:       500,
				animation:   {opacity:'show',height:'show'},
				speed:       350,
				autoArrows:  false,
				dropShadows: false
			}); 
			
			
	});
