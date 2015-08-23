/*
 * Image preview script 
 * powered by jQuery (http://www.jquery.com)
 * 
 * written by Alen Grakalic (http://cssglobe.com)
 * 
 * for more info visit http://cssglobe.com/post/1695/easiest-tooltip-and-image-preview-using-jquery
 *
 */
 
this.imagePreview = function(){
	/* CONFIG */
		
		xOffset = 10;
		yOffset = 30;
		
		// these 2 variable determine popup's distance from the cursor
		// you might want to adjust to get the right result
		
	/* END CONFIG */
	$(document).on({
		mouseenter: function(e) {
			console.log(this);
			this.t = this.title;
			this.title = "";
			var c = (this.t != "") ? "<br/>" + this.t : "";
			$("body").append("<p id='preview'><img src='"+ this.href +"' alt='Image preview' />"+ c +"</p>");
			$("#preview")
				.css("top",(e.pageY) + "px")
				.css("left",(e.pageX) + "px")
				.addClass('tooltip-image')
				.fadeIn("fast");

			console.log('tooltip : '+this.title);
		},
		mouseleave: function(e) {
			this.title = this.t;
			$("#preview").remove();
		}
	}, 'a.preview');


	$("a.preview").mousemove(function(e){
		e.preventDefault();
		$("#preview")
			.css("top",(e.pageY - xOffset) + "px")
			.css("left",(e.pageX + yOffset) + "px")
			.removeClass('tooltip-image');
	});

	$(document).on('click', "a.preview", function(e){
		e.preventDefault();
	});
};