/*
 * SmartTab plugin v0.99
 *
 * jQuery Tab Control Plugin
 * 
 * Dips  
 * 
 * http://tech-laboratory.blogspot.com
 * http://techlaboratory.wordpress.com
 */
 
(function($){
    $.fn.smartTab = function(options) {
        var options = $.extend({}, $.fn.smartTab.defaults, options);


        return this.each(function() {
                obj = $(this);

								// variante Marcos
								var paused = false;
								var played = true;
								var timePause = 60000;
								var timePaused = 0;
								var idPauseInterval = null;
								var anchoPorcientoProgressBarTable = 50;
								var segundosRecargarPagina = 3;
								$("#play").hide("slow");
								$('#pause').click(pause);
								$('#play').click(play);
								
								function pause(){
										$("#progressPause").show("slow");
										$("#pause").hide("slow");
										$("#play").show("slow");
										stopAutoProgress();
										paused = true;
										played = false;
										timePaused = timePause;
										idPauseInterval = setInterval(viewCounterPause,50);
								}
								
								function play(){
										$("#progressPause").removeClass("ultimosSegundos");
										$("#progressPause").hide("slow");
										$("#play").hide("slow");
										$("#pause").show("slow");
										stopAutoProgress();
										startAutoProgress();
										paused = false;
										played = true;
										clearInterval(idPauseInterval);
								}
								
								function viewCounterPause() {
										timePaused = timePaused - 50;
										$("#timePaused").text(Math.round(timePaused/1000)+" seg");
										porcentajeProgreso = Math.round(timePaused * anchoPorcientoProgressBarTable / timePause);
										$("#progressPause").css("width", porcentajeProgreso+"%");
										if (timePaused/1000 < 5) {
											$("#progressPause").addClass("ultimosSegundos");
										}
										if (timePaused == 0) {
											play();
										}
								}
								
								// fin variante

                var curTabIdx = options.selected; // Set the current tab index to default tab
                var tabs = $("ul > li > a", obj); // Get all anchors in this array
			          var autoProgressId = null;
                // adjust effect string
                options.transitionEffect = (typeof(options.transitionEffect)=='string' && options.transitionEffect!='') ? options.transitionEffect : 'none';

                $(obj).addClass(options.tabContainerClass); // Set the CSS on top element		       

                hideAllSteps(); // Hide all content on the first load
                
      		      showTab();
      		      
                $(tabs).bind("click", function(e){
                    if(tabs.index(this)==curTabIdx)
                      return false;
                    var prevTabIdx = curTabIdx;
                    curTabIdx = tabs.index(this);
                    hideTab(prevTabIdx);
                    if(options.autoProgress){
                      restartAutoProgress();
                    }
                    return false;
                });
                
                if(options.keyNavigation){
                    $(document).keyup(function(e){
                        if(e.which==39){ // Right Arrow
                          doForwardProgress();
                          if(options.autoProgress){
                            restartAutoProgress();
                          }
                        }else if(e.which==37){ // Left Arrow
                          doBackwardProgress();
                          if(options.autoProgress){
                            restartAutoProgress();
                          }
                        }
                    });
                }
                if(options.autoProgress){
                    startAutoProgress();
                }
                if(options.autoProgress && options.stopOnFocus){
                  $(obj).bind("mouseenter mousemove mouseover", function(e){
                      stopAutoProgress();
                      return true;
                  });
                  $(obj).bind("mouseleave", function(e){
                      startAutoProgress();
                      return true;
                  });
                }
                function hideAllSteps(){
            	    $(tabs, obj).each(function(){
                        $($(this, obj).attr("href"), obj).hide();//slideUp("fast");.fadeOut()
                  });
                }
                function showTab(){
                    var selTab = tabs.eq(curTabIdx); 
                    $(tabs, obj).removeClass("sel");
                    $($(selTab, obj), obj).addClass("sel");
                    if(options.transitionEffect == 'slide'){
                      $($(selTab, obj).attr("href"), obj).slideDown("slow");//slideDown("slow");.fadeIn()
                    } else if(options.transitionEffect == 'fade'){
                      $($(selTab, obj).attr("href"), obj).fadeIn("slow");//slideDown("slow");.fadeIn()
                    } else{
                      $($(selTab, obj).attr("href"), obj).show();
                    }
                    return true;
                }
                function hideTab(idx){
                    var selTab = tabs.eq(idx);
                    if(options.transitionEffect == 'slide'){
                      $($(selTab, obj).attr("href"), obj).slideUp("slow",showTab);//slideDown("slow");.fadeIn()
                    } else if(options.transitionEffect == 'fade'){
                      $($(selTab, obj).attr("href"), obj).fadeOut("slow",showTab);
                    } else{
                      $($(selTab, obj).attr("href"), obj).hide();
                      showTab();
                    }
                    return true;
                }
                // Auto progress
                function startAutoProgress(){
                  if(!autoProgressId){
                    autoProgressId = setInterval(doForwardProgress, options.progressInterval);
                  }
                }
                function restartAutoProgress(){
					if (!paused) {
						stopAutoProgress();
						startAutoProgress();
					}
                }
                function stopAutoProgress(){
                  if (autoProgressId) {
                    clearInterval(autoProgressId);
                    autoProgressId = null;
                  }
                }
                function doForwardProgress(){
                  var nextTabIdx = curTabIdx+1;
                  var prevTabIdx = curTabIdx;
                  if(tabs.length <= nextTabIdx){
					// Variante Marcos
					if (paginaVencida) {
						// muestra el cuadro "actualizando información"
						$('#reload').fadeIn(1000, function() {window.location.reload()});
					}else{
						nextTabIdx = 0;
					}
                  }
                  curTabIdx = nextTabIdx;
                  hideTab(prevTabIdx);
                }
                function doBackwardProgress(){
                  var nextTabIdx = curTabIdx-1;
                  var prevTabIdx = curTabIdx;
                  if(0 > nextTabIdx){
                    nextTabIdx = tabs.length-1;
                  }
                  curTabIdx = nextTabIdx;
                  hideTab(prevTabIdx);
                }
        });  
    };  
 
    // Defaults jQuery(this).animate({width: 'show'}); jQuery(this).animate({width: 'hide'});
    $.fn.smartTab.defaults = {
          selected: 0,  // Selected Tab, 0 = first step   
          keyNavigation: true, // Enable/Disable key navigation(left and right keys are used if enabled)
          autoProgress: false, // Auto navigate tabs on interval
          progressInterval: 3500, // Auto navigate Interval (used only if "autoProgress" is set to true)
          stopOnFocus: false,
          transitionEffect: 'none', // Effect on navigation, none/fade/slide
          tabContainerClass: 'stContainer' // tab container css class name
    };

})(jQuery);
