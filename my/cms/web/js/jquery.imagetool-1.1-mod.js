;(function($) {
	var defaultSettings = {
		allowZoom: true,
		allowPan: true,
		viewportWidth: 400,
		viewportHeight: 300,
		maxWidth: 768,
		topX: -1,
		topY: -1,
		bottomX: -1,
		bottomY: -1,
		callback: function(topX,topY,bottomX,bottomY) {}
	};
		
	function pan(e) {
		e.preventDefault();
		var image=$(this);
		var dim=image.data("dim");
		var deltaX=dim.origoX-e.clientX;
		var deltaY=dim.origoY-e.clientY;
		dim.origoX=e.clientX;
		dim.origoY=e.clientY;
		var targetX=dim.x-deltaX;
		var targetY=dim.y-deltaY;
		var minX=-dim.width+dim.viewportWidth;
		var minY=-dim.height+dim.viewportHeight;
		dim.x=targetX;
		dim.y=targetY;
		image.move();
	}
	
	function zoom(e) {
		e.preventDefault();
		var image=$(this);
		var dim=image.data("dim");
		var factor=(dim.origoY-e.clientY);
		dim.oldWidth=dim.width;
		dim.oldHeight=dim.height;
		dim.width=((factor/100)*dim.width)+dim.width;
		dim.height=((factor/100)*dim.height)+dim.height;
		if(image.resize()) {
			dim.origoY=e.clientY;
		}
	}
	
	function handleMouseDown(mousedownEvent) {
		mousedownEvent.preventDefault();
		var image=$(this);
		var dim=image.data("dim");
		dim.origoX=mousedownEvent.clientX;
		dim.origoY=mousedownEvent.clientY;
		var clickX=(mousedownEvent.pageX-$(this).offset({scroll:false}).left);
		var clickY=(mousedownEvent.pageY-$(this).offset({scroll:false}).top);
		
		if(dim.allowZoom && (mousedownEvent.shiftKey || mousedownEvent.ctrlKey) ) {
			image.mousemove(zoom);
		}
		else if(dim.allowPan) {
			image.mousemove(pan);
		}
		return false;
	}
		
	function disableAndStore() {
		$(this).unbind("mousemove").store();
	}	
	
	$.fn.extend({
		store:function() {
			var image = $(this);
			var dim = image.data("dim");
			var scale = dim.width/dim.actualWidth;
			dim.topX=(-dim.x)/scale;
			dim.topY=(-dim.y)/scale;
			dim.bottomX=dim.topX+(dim.viewportWidth/scale);
			dim.bottomY=dim.topY+(dim.viewportHeight/scale);
			if(typeof dim.callback=='function') {
				dim.callback(parseInt(dim.topX),parseInt(dim.topY),parseInt(dim.bottomX),parseInt(dim.bottomY));
			}
			return image;
		},
		
		move:function() {
			var image=$(this);
			var dim=image.data("dim");
			var minX=-dim.width+dim.viewportWidth;
			var minY=-dim.height+dim.viewportHeight;
			if(dim.x>0){
				dim.x=0;
			}
			else if(dim.x<minX) {
				dim.x=minX;
			}
			if(dim.y>0){
				dim.y=0;
			}
			else if(dim.y<minY) {
				dim.y=minY;
			}
		
			$(this).css({left:dim.x+"px",top:dim.y+"px"});
			return image;
		},
		
		resize:function() {
			var image=$(this);
			var dim=image.data("dim");
			var wasResized=true;
			if(dim.height<dim.viewportHeight) {
				dim.width=parseInt(dim.actualWidth*(dim.viewportHeight/dim.actualHeight));
				dim.height=dim.viewportHeight;
				wasResized=false;
			}
			if(dim.width<dim.viewportWidth) {
				dim.height=parseInt(dim.actualHeight*(dim.viewportWidth/dim.actualWidth));
				dim.width=dim.viewportWidth;
				wasResized=false;
			}
			if(dim.width>dim.maxWidth) {
				dim.height=parseInt(dim.height*(dim.maxWidth/dim.width));
				dim.width=dim.maxWidth;
				wasResized=false;
			}
			$(this).css({width:dim.width+"px",height:dim.height+"px"});
			var cx=dim.width/(-dim.x+(dim.viewportWidth/2));
			var cy=dim.height/(-dim.y+(dim.viewportHeight/2));
			dim.x=dim.x-((dim.width-dim.oldWidth)/cx);
			dim.y=dim.y-((dim.height-dim.oldHeight)/cy);
			$(this).move();
			return wasResized;
		},

		zoomin:function() {
			var image=$(this);
			var dim=image.data("dim");
			var factor=10;
			dim.oldWidth=dim.width;
			dim.oldHeight=dim.height;
			dim.width=((factor/100)*dim.width)+dim.width;
			dim.height=((factor/100)*dim.height)+dim.height;
			if(image.resize()) {
			}
			image.store();
		},

		zoomout:function() {
			var image=$(this);
			var dim=image.data("dim");
			var factor=-10;
			dim.oldWidth=dim.width;
			dim.oldHeight=dim.height;
			dim.width=((factor/100)*dim.width)+dim.width;
			dim.height=((factor/100)*dim.height)+dim.height;
			if(image.resize()) {
			}
			image.store();
		},
				
		setup:function() {
			var image=$(this);
			var dim=image.data("dim");
			dim.actualWidth=image.width();
			dim.actualHeight=image.height();
			dim.width=dim.actualWidth;
			dim.height=dim.actualHeight;
			if(dim.topX<0 || true) {
				dim.topX=0;
				dim.topY=0;
				if((dim.actualWidth/dim.viewportWidth)>(dim.actualHeight/dim.viewportHeight)){
					dim.bottomY=dim.actualHeight;
					dim.bottomX=dim.viewportWidth*(dim.actualHeight/dim.viewportHeight);
				}
				else{
					dim.bottomX=dim.actualWidth;
					dim.bottomY=dim.viewportHeight*(dim.actualWidth/dim.viewportWidth);
				}
			}
			var scaleX=dim.viewportWidth/(dim.bottomX-dim.topX);
			var scaleY=dim.viewportHeight/(dim.bottomY-dim.topY);
			dim.width=dim.width*scaleX;
			dim.height=dim.height*scaleY;
			dim.oldWidth=dim.width;
			dim.oldHeight=dim.height;
			dim.x=-(dim.topX*scaleX);
			dim.y=-(dim.topY*scaleY);
			image.resize();
			image.store();
			image.css({position:"relative",cursor:"move",display:"block"});
			image.mousedown(handleMouseDown);
			image.mouseup(disableAndStore);
			image.mouseout(disableAndStore);
		},
		
		reload:function(settings) {
			return this.each(function() {
				var image=$(this).css({display:"none"});
				var dim=$.extend( {}, defaultSettings,settings);
				image.data("dim",dim);
				if(dim.loading) {
					var loadingCss={"margin-top":(dim.viewportHeight/2)-8,"margin-left":(dim.viewportWidth/2)-8};
					$("<img class=\"loading\" src=\""+dim.loading+"\" />").css(loadingCss).insertAfter(image);
				}
				image.load(function() {
					$(this).next("img").remove();
					$(this).setup();
				});
				if($.browser.msie) {
					image.attr("src",image.attr("src")+'?'+(Math.round(2048*Math.random())));
				}
			});
		},
		
		imagetool:function(settings) {
			return this.each(function() {
				var image=$(this).css({display:"none"});
				var dim=$.extend( {}, defaultSettings,settings);
				image.data("dim",dim);
				var viewportCss={backgroundColor:"#fff",position:"relative",overflow:"hidden",width:dim.viewportWidth+"px",height:dim.viewportHeight+"px"};
				var viewportElement=$("<div class=\"viewport\"><\/div>");
				viewportElement.css(viewportCss);
				image.wrap(viewportElement);
				if(dim.loading) {
					var loadingCss={"margin-top":(dim.viewportHeight/2)-8,"margin-left":(dim.viewportWidth/2)-8};
					$("<img class=\"loading\" src=\""+dim.loading+"\" />").css(loadingCss).insertAfter(image);
				}
				image.load(function() {
					$(this).next("img").remove();
					$(this).setup();
				});
				if($.browser.msie) {
					image.attr("src",image.attr("src")+'?'+(Math.round(2048*Math.random())));
				}
			});
		}
	});
})(jQuery);