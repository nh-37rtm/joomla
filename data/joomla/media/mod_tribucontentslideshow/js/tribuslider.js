/**
 * @package mod_tribucontentslideshow for Joomla! 3
 * @author Tribu And Co
 * @copyright (C) 2014 - Tribu And Co. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
(function($){
    $.fn.tribuSlider= function(options) {

        var defaults = {
            contentsWrap : 'sliderContentsWrap',
			content : '.content',
			theClass : '.tcslider_wrapper',
			controls : '.tc_controls',
            width : '600',
            height : 300,
            autoplay : false,
			delay : 5,
			delaySlide : '',
			speedTransition : 5,
			/*nbInSlides : 1,*/
            buttonsClass : 'buttons',
			prevClass : 'prev',
			nextClass : 'next',
            activeClass : 'active',
			controlBt : '.control',
			playText : ' Play',
			pauseText : 'Pause',
			direction : 'horizontal',
			mouseoverButtons : 0,
			type : 'actu'
        };
        
        var options = $.extend(defaults, options);

        var slideNo = 1;
        var timer = 0;
        var playStatus = options.autoplay;
        var count = 0;
        var slides;
		var currentSlide = 1;
		var delay = parseInt(options.delay)*1000;
		
		var divParent = $(this);
		
        $(this).find(options.content).each(function(){
            slides = ++count;
        });
		
		function wrapContent(ele){
			ele.wrap('<div class="' + options.contentsWrap + '" />');
			if(options.autoplay  && slides > 1 && options.direction != 'fade'){
				var sliceFirst = ele.children(options.content + ':first-child').addClass('clone')
				var sliceAppend = sliceFirst.clone().addClass('clone').removeAttr( "id" );
				ele.append(sliceAppend).append(ele.children(options.content + ':last-child'));
				slides = slides + 1;
			}
		}
		
		function applyCss(ele){	
			divParent.css({
                width : options.width
            });
			divParent.find('.' + options.contentsWrap).css({
                padding : 0,
                margin : 0,
                width : options.width,
                height : options.height,
                overflow : 'hidden',
                position : 'relative'
            });
			
			divParent.find(options.controls + ' > div').css({
                display : 'block'
            });
            
			if(options.direction != 'fade') {
				ele.children(options.content).css({
					float : 'left',
					overflow : 'hidden',
					width : options.width,
					height : options.height
				});
				
				eleWidth = options.direction == 'horizontal' ? divParent.find(options.content).outerWidth(true) * slides : divParent.find(options.content).outerWidth(true);
				eleHeight = options.direction == 'horizontal' ? divParent.find(options.content).outerHeight(true) : divParent.find(options.content).outerHeight(true) * slides;
				
				ele.css({
					padding : 0,
					margin : 0,
					width : eleWidth,
					height : eleHeight,
					position : 'relative'
				});
			} else {
				ele.children(options.content).css({
					position : 'absolute',
					left : 0,
					top : 0,
					opacity : 0,
					overflow : 'hidden',
					width : options.width,
					height : options.height,
					zIndex : 1
				});
				ele.children(options.content + '1').css({
					zIndex : 20,
					opacity : 1
				});
			}
			
			if(options.mouseoverButtons == 1){
				var mover = 0;
				var movercurrent = 0;
				divParent.find('.arrows').css({ opacity: 0 });
				divParent.find('.buttonsWrap').css({ opacity: 0 });
				var n = 0;
				divParent.on('mouseover', function() {
					if(mover == 0) {
						mover = 1;
						divParent.find('.arrows').fadeTo("slow", 1);
						divParent.find('.buttonsWrap').fadeTo("slow", 1);
					}
				});
				divParent.on('mouseleave', function() {
					movercurrent = 0;
					if(mover == 1) {
						divParent.find('.arrows').fadeTo("slow", 0, function() { mover = 0; });
						divParent.find('.buttonsWrap').fadeTo("slow", 0, function() { mover = 0; });
					}
				});
			}
		}
		
        function resetButtons(){
            i = 0;
            divParent.find('.' + options.buttonsClass).each(function(){
                i++;
                $(this).addClass('bt' + i);
                $(this).attr('rel', i);
            });
        }
		
		function updateAfterSlideTransition(theSlide){
			// if infinte loop is true	
			if(options.autoplay && options.direction != 'fade'){
				if(theSlide == slides){
					if(options.direction == 'horizontal') {
						divParent.find(options.theClass).css({left : 0});
					} else {
						divParent.find(options.theClass).css({top : 0});
					}
					theSlide = 1;
				}
			}
			currentSlide = theSlide;
			
            divParent.find('.' + options.buttonsClass).each(function(){
                $(this).removeClass(options.activeClass);
                    if($(this).hasClass('bt' + theSlide)){
                        $(this).addClass(options.activeClass)}
            });
		}
		        
        function goToSlide(theSlide){
            var animateLeft = -(divParent.find(options.content).outerWidth(true)) * (parseInt(theSlide)-1);
			var animateTop = -(divParent.find(options.content).outerHeight(true)) * (parseInt(theSlide)-1);
			
			if(options.direction == 'fade') {
				if(theSlide != currentSlide) {
					divParent.find('.' + options.contentsWrap + ' ' + options.theClass + ' ' + options.content + theSlide).animate({ opacity: 1, zIndex : 20 }, options.speedTransition*100);
					divParent.find('.' + options.contentsWrap + ' ' + options.theClass + ' ' + options.content + currentSlide).animate({ opacity: 0, zIndex : 1 }, options.speedTransition*100, null, function() {
						updateAfterSlideTransition(theSlide);
					});
				}
			} else if(options.direction == 'horizontal') {
				divParent.find('.' + options.contentsWrap + ' ' + options.theClass).animate({ left: animateLeft }, options.speedTransition*100, null, function() {
					updateAfterSlideTransition(theSlide);
				});
			} else {
				divParent.find('.' + options.contentsWrap + ' ' + options.theClass).animate({ top: animateTop }, options.speedTransition*100, null, function() {
					updateAfterSlideTransition(theSlide);
				});
			}
        }
		
		function timerSlide() {
			currentSlideTime = currentSlide;
			if(currentSlide == slides){
				currentSlideTime = 1;
			}
			
			if(options.delaySlide.length > 0 && options.delaySlide[currentSlideTime-1] != '') {
				delayTemp = parseInt(options.delaySlide[currentSlideTime-1])*1000;
			} else {
				delayTemp = parseInt(options.delay)*1000;
			}
			
			timer = setTimeout(function(){
				autoplay();
			}, delayTemp);
		}
		
		function autoplay(){
			if(options.direction == 'fade' && currentSlide == slides)
				goToSlide(1);
			else
				goToSlide(parseInt(currentSlide) + 1);
			
			timerSlide();
		}
		
		function playSlide(){
			//clearInterval(timer);
			clearTimeout(timer);
			timerSlide();
			
			divParent.find(options.controlBt).text(options.pauseText);
			playStatus = true;
			divParent.find(options.controlBt).addClass('pause').removeClass('play');
		}
		
		function pauseSlide(){
			//clearInterval(timer);
			clearTimeout(timer);
			divParent.find(options.controlBt).text(options.playText);
			playStatus = false;
			divParent.find(options.controlBt).addClass('play').removeClass('pause');
		}

		function init(ele){
			wrapContent(ele);
			applyCss(ele);
			
			if(slides > 1) {
				resetButtons();
				if(options.autoplay == true){
					playSlide();
				}else{
					pauseSlide();
				}
			}
		}
		
        return this.each(function(){
			init($(this).children(options.theClass));
			
			divParent.find('.'+options.buttonsClass).click(function(e){
				e.preventDefault();
				playStatusTmp = playStatus;
				clearTimeout(timer);
				goToSlide($(this).attr('rel'));
				if(playStatusTmp == true){
					playSlide();
				}
            });
			
			divParent.find('.'+options.prevClass).click(function(e){
				e.preventDefault();
				playStatusTmp = playStatus;
				clearTimeout(timer);
				if(currentSlide != 1) {
					prevSlide = parseInt(currentSlide) - 1;
				} else {
					if(options.autoplay  && slides > 1 && options.direction != 'fade'){
						prevSlide = slides-1;
					} else {
						prevSlide = slides;
					}
				}
				goToSlide(prevSlide);
				if(playStatusTmp == true){
					playSlide();
				}
			});
			
			divParent.find('.'+options.nextClass).click(function(e){
				e.preventDefault();
				playStatusTmp = playStatus;
				clearTimeout(timer);
				if(currentSlide != slides) {
					nextSlide = parseInt(currentSlide) + 1;
				} else {
					nextSlide = 1;
				}
				goToSlide(nextSlide);
				if(playStatusTmp == true){
					playSlide();
				}
			});
			
			divParent.find(options.controlBt).click(function(e){
				e.preventDefault();
				if(playStatus == true){
					pauseSlide();
				}else{
					playSlide();
				} 
            });
			
        });
        
    };
})(jQuery);