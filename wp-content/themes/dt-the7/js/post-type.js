jQuery(document).ready(function($){$.fn.exists=function(){if($(this).length>0){return true;}else{return false;}}
$.fn.loaded=function(callback,jointCallback,ensureCallback){var len=this.length;if(len>0){return this.each(function(){var el=this,$el=$(el),blank="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==";$el.on("load.dt",function(event){$(this).off("load.dt");if(typeof callback=="function"){callback.call(this);}
if(--len<=0&&(typeof jointCallback=="function")){jointCallback.call(this);}});if(!el.complete||el.complete===undefined){el.src=el.src;}else{$el.trigger("load.dt")}});}else if(ensureCallback){if(typeof jointCallback=="function"){jointCallback.call(this);}
return this;}};var $body=$("body"),$window=$(window),$mainSlider=$('#main-slideshow'),$3DSlider=$('.three-d-slider'),adminH=$('#wpadminbar').height(),header=$('.masthead:not(.side-header):not(.side-header-v-stroke)').height();if($body.hasClass("transparent")){var headerH=0;}else if($body.hasClass("overlap")){var headerH=($('.masthead:not(.side-header):not(.side-header-v-stroke)').height()+(parseInt($mainSlider.css("marginTop"))+parseInt($mainSlider.css("marginBottom"))));}else{var headerH=$('.masthead:not(.side-header):not(.side-header-v-stroke)').height();}
'use strict';$.HoverDir=function(options,element){this.$el=$(element);this._init(options);};$.HoverDir.defaults={speed:300,easing:'ease',hoverDelay:0,inverse:false};$.HoverDir.prototype={_init:function(options){this.options=$.extend(true,{},$.HoverDir.defaults,options);this.transitionProp='all '+this.options.speed+'ms '+this.options.easing;this.support=Modernizr.csstransitions;this._loadEvents();},_loadEvents:function(){var self=this;this.$el.on('mouseenter.hoverdir, mouseleave.hoverdir',function(event){var $el=$(this),$hoverElem=$el.find('.rollover-content'),direction=self._getDir($el,{x:event.pageX,y:event.pageY}),styleCSS=self._getStyle(direction);if(event.type==='mouseenter'){$hoverElem.hide().css(styleCSS.from);clearTimeout(self.tmhover);self.tmhover=setTimeout(function(){$hoverElem.show(0,function(){var $el=$(this);if(self.support){$el.css('transition',self.transitionProp);}
self._applyAnimation($el,styleCSS.to,self.options.speed);});},self.options.hoverDelay);}
else{if(self.support){$hoverElem.css('transition',self.transitionProp);}
clearTimeout(self.tmhover);self._applyAnimation($hoverElem,styleCSS.from,self.options.speed);}});},_getDir:function($el,coordinates){var w=$el.width(),h=$el.height(),x=(coordinates.x-$el.offset().left-(w/2))*(w>h?(h/w):1),y=(coordinates.y-$el.offset().top-(h/2))*(h>w?(w/h):1),direction=Math.round((((Math.atan2(y,x)*(180/Math.PI))+180)/90)+3)%4;return direction;},_getStyle:function(direction){var fromStyle,toStyle,slideFromTop={left:'0px',top:'-100%'},slideFromBottom={left:'0px',top:'100%'},slideFromLeft={left:'-100%',top:'0px'},slideFromRight={left:'100%',top:'0px'},slideTop={top:'0px'},slideLeft={left:'0px'};switch(direction){case 0:fromStyle=!this.options.inverse?slideFromTop:slideFromBottom;toStyle=slideTop;break;case 1:fromStyle=!this.options.inverse?slideFromRight:slideFromLeft;toStyle=slideLeft;break;case 2:fromStyle=!this.options.inverse?slideFromBottom:slideFromTop;toStyle=slideTop;break;case 3:fromStyle=!this.options.inverse?slideFromLeft:slideFromRight;toStyle=slideLeft;break;};return{from:fromStyle,to:toStyle};},_applyAnimation:function(el,styleCSS,speed){$.fn.applyStyle=this.support?$.fn.css:$.fn.animate;el.stop().applyStyle(styleCSS,$.extend(true,[],{duration:speed+'ms'}));},};var logError=function(message){if(window.console){window.console.error(message);}};$.fn.hoverdir=function(options){var instance=$.data(this,'hoverdir');if(typeof options==='string'){var args=Array.prototype.slice.call(arguments,1);this.each(function(){if(!instance){logError("cannot call methods on hoverdir prior to initialization; "+"attempted to call method '"+options+"'");return;}
if(!$.isFunction(instance[options])||options.charAt(0)==="_"){logError("no such method '"+options+"' for hoverdir instance");return;}
instance[options].apply(instance,args);});}
else{this.each(function(){if(instance){instance._init();}
else{instance=$.data(this,'hoverdir',new $.HoverDir(options,this));}});}
return instance;};$('.mobile-false .hover-grid .rollover-project').each(function(){$(this).hoverdir();});$('.mobile-false .hover-grid-reverse .rollover-project ').each(function(){$(this).hoverdir({inverse:true});});$.fn.hoverLinks=function(){if($(".semitransparent-portfolio-icons").length>0||$(".accent-portfolio-icons").length>0){return this.each(function(){var $img=$(this);if($img.hasClass("height-ready")){return;}
$("<span/>").appendTo($(this));$img.on({mouseenter:function(){if(0===$(this).children("span").length){var a=$("<span/>").appendTo($(this));setTimeout(function(){a.addClass("icon-hover")},20)}else $(this).children("span").addClass("icon-hover")},mouseleave:function(){$(this).children("span").removeClass("icon-hover")}});$img.addClass("height-ready");});}};$(".links-container a").hoverLinks();$.fn.forwardToPost=function(){return this.each(function(){var $this=$(this);if($this.hasClass("this-ready")){return;};$this.on("click",function(){if($this.parents(".ts-wrap").hasClass("ts-interceptClicks"))return;window.location.href=$this.find("a").first().attr("href");return false;});$this.addClass("this-ready");});};$(".mobile-false .rollover-project.forward-post").forwardToPost();$.fn.touchforwardToPost=function(){return this.each(function(){var $this=$(this);if($this.hasClass("touch-hover-ready")){return;}
$body.on("touchend",function(e){$(".mobile-true .rollover-content").removeClass("is-clicked");$(".mobile-true .rollover-project").removeClass("is-clicked");});var $this=$(this).find(".rollover-content");$this.on("touchstart",function(e){origY=e.originalEvent.touches[0].pageY;origX=e.originalEvent.touches[0].pageX;});$this.on("touchend",function(e){var touchEX=e.originalEvent.changedTouches[0].pageX,touchEY=e.originalEvent.changedTouches[0].pageY;if(origY==touchEY||origX==touchEX){if($this.hasClass("is-clicked")){window.location.href=$this.prev("a").first().attr("href");}else{e.preventDefault();$(".mobile-ture .rollover-content").removeClass("is-clicked");$(".mobile-true .rollover-project").removeClass("is-clicked");$this.addClass("is-clicked");$this.parent(".rollover-project").addClass("is-clicked");return false;};};});$this.addClass("touch-hover-ready");});};$(".mobile-true .rollover-project.forward-post").touchforwardToPost();$.fn.followCurentLink=function(){return this.each(function(){var $this=$(this);if($this.hasClass("this-ready")){return;}
var $thisSingleLink=$this.find(".links-container > a"),$thisCategory=$this.find(".portfolio-categories a");$this.on("click",function(){if($this.parents(".ts-wrap").hasClass("ts-interceptClicks"))return;$thisSingleLink.each(function(){$thisTarget=$(this).attr("target")?$(this).attr("target"):"_self";});if($thisSingleLink.hasClass("project-details")||$thisSingleLink.hasClass("link")||$thisSingleLink.hasClass("project-link")){window.open($thisSingleLink.attr("href"),$thisTarget);return false;}else{$thisSingleLink.trigger("click");return false;}});$this.find($thisCategory).click(function(e){e.stopPropagation();window.location.href=$thisCategory.attr('href');});$this.addClass("this-ready");});};$(".mobile-false .rollover-project.rollover-active, .mobile-false .buttons-on-img.rollover-active").followCurentLink();$.fn.touchHoverImage=function(){return this.each(function(){var $img=$(this);if($img.hasClass("hover-ready")){return;}
$body.on("touchend",function(e){$(".mobile-true .rollover-content").removeClass("is-clicked");});var $this=$(this).find(".rollover-content"),thisPar=$this.parents(".wf-cell");$this.on("touchstart",function(e){origY=e.originalEvent.touches[0].pageY;origX=e.originalEvent.touches[0].pageX;});$this.on("touchend",function(e){var touchEX=e.originalEvent.changedTouches[0].pageX,touchEY=e.originalEvent.changedTouches[0].pageY;if(origY==touchEY||origX==touchEX){if($this.hasClass("is-clicked")){}else{$('.links-container > a',$this).on('touchend',function(e){e.stopPropagation();$this.addClass("is-clicked");});e.preventDefault();$(".mobile-true .buttons-on-img .rollover-content").removeClass("is-clicked");$this.addClass("is-clicked");return false;};};});$img.addClass("hover-ready");});};$(".mobile-true .buttons-on-img").touchHoverImage();$.fn.touchScrollerImage=function(){return this.each(function(){var $img=$(this);if($img.hasClass("hover-ready")){return;}
$body.on("touchend",function(e){$(".mobile-true .project-list-media").removeClass("is-clicked");});var $this=$(this),$thisSingleLink=$this.find("a.rollover-click-target").first(),$thisButtonLink=$this.find(".links-container");$this.on("touchstart",function(e){origY=e.originalEvent.touches[0].pageY;origX=e.originalEvent.touches[0].pageX;});$this.on("touchend",function(e){var touchEX=e.originalEvent.changedTouches[0].pageX,touchEY=e.originalEvent.changedTouches[0].pageY;if($this.parents(".ts-wrap").hasClass("ts-interceptClicks"))return;if(origY==touchEY||origX==touchEX){if($this.hasClass("is-clicked")){}else{if($thisSingleLink.length>0){$thisSingleLink.on("click",function(event){event.stopPropagation();if($(this).hasClass('go-to')){window.location.href=$(this).attr('href');}});$thisSingleLink.trigger("click");};if($thisButtonLink.length>0){$thisButtonLink.find(" > a ").each(function(){$(this).on("touchend",function(event){event.stopPropagation();$(this).trigger("click");});});}
e.preventDefault();$(".mobile-true .fs-entry").removeClass("is-clicked");$this.addClass("is-clicked");return false;};};});$img.addClass("hover-ready");});};$(".mobile-true .project-list-media").touchScrollerImage();$.fn.touchHoverLinks=function(){return this.each(function(){var $img=$(this);if($img.hasClass("hover-ready")){return;}
var $this=$(this);$this.on("touchend",function(e){if($this.parents(".ts-wrap").hasClass("ts-interceptClicks"))return;if($this.hasClass("is-clicked")){return;}else{if($this.hasClass("project-zoom")){$this.trigger("click");}else{window.location.href=$this.attr("href");return false;};$(".mobile-true .links-container > a").removeClass("is-clicked");$this.addClass("is-clicked");return false;};});$img.addClass("hover-ready");});};$(".mobile-true .fs-entry .links-container > a").touchHoverLinks();$.fn.triggerAlbumsClick=function(){return this.each(function(){var $this=$(this);if($this.hasClass("this-ready")){return;}
var $thisSingleLink=$this.find("a.rollover-click-target, .dt-mfp-item").first(),$thisCategory=$this.find(".portfolio-categories a");if($thisSingleLink.length>0){$thisSingleLink.on("click",function(event){event.preventDefault();event.stopPropagation();if($thisSingleLink.parents(".ts-wrap").hasClass("ts-interceptClicks"))return;if($(this).hasClass('go-to')){window.location.href=$(this).attr('href');}});var alreadyTriggered=false;$this.on("click",function(){if($this.parents(".ts-wrap").hasClass("ts-interceptClicks"))return;if(!alreadyTriggered){alreadyTriggered=true;$thisSingleLink.trigger("click");alreadyTriggered=false;}
return false;})
$this.find($thisCategory).click(function(e){e.stopPropagation();window.location.href=$thisCategory.attr('href');});}
$this.addClass("this-ready");});};$(".dt-albums-template .rollover-project, .dt-albums-shortcode .rollover-project, .dt-albums-template .buttons-on-img, .dt-albums-shortcode .buttons-on-img, .archive .type-dt_gallery .buttons-on-img").triggerAlbumsClick();$.fn.triggerHoverClick=function(){return this.each(function(){var $this=$(this);if($this.hasClass("click-ready")){return;}
var $thisSingleLink=$this.prev("a:not(.dt-single-mfp-popup):not(.dt-mfp-item)").first(),$thisCategory=$this.find(".portfolio-categories a"),$thisLink=$this.find(".project-link"),$thisTarget=$thisLink.attr("target")?$thisLink.attr("target"):"_self",$targetClick;if($thisSingleLink.length>0){var alreadyTriggered=false;$this.on("click",function(e){if($this.parents(".ts-wrap").hasClass("ts-interceptClicks"))return;if($(".semitransparent-portfolio-icons").length>0||$(".accent-portfolio-icons").length>0){$targetClick=$(e.target).parent();}else{$targetClick=$(e.target);}
if($targetClick.hasClass("project-zoom")){$(this).find("a.dt-gallery-mfp-popup, .dt-trigger-first-mfp, .dt-single-mfp-popup, .dt-mfp-item").first().trigger('click');}else{if(!alreadyTriggered){alreadyTriggered=true;$thisSingleLink.trigger("click");window.location.href=$thisSingleLink.attr('href');alreadyTriggered=false;}}
return false;})
$this.find($thisLink).click(function(e){e.stopPropagation();e.preventDefault();window.open($thisLink.attr("href"),$thisTarget);});$this.find($thisCategory).click(function(e){e.stopPropagation();window.location.href=$thisCategory.attr('href');});}
$this.addClass("click-ready");});};$(".mobile-false .rollover-project:not(.rollover-active) .rollover-content, .buttons-on-img:not(.rollover-active) .rollover-content").triggerHoverClick();$.fn.smartGrid=function(){return this.each(function(){var $this=$(this),colNum=parseInt($this.attr("data-columns")),colMinWidth=parseInt($this.attr("data-width")),contWidth=$this.width();for(;Math.floor(contWidth/colNum)<colMinWidth;){colNum--;if(colNum<=1)break;}
$("> .wf-cell",$this).css({width:(100/colNum).toFixed(6)+"%",display:"inline-block"});});};var $benLogColl=$(".benefits-grid, .logos-grid");$benLogColl.smartGrid();$window.on("debouncedresize",function(){$benLogColl.smartGrid();});var $photoScroller=$(".photo-scroller");if($photoScroller.length>0){$.fn.photoSlider=function(){var $el=$(this),slides={},thumbs="";$elParent=$el.parents(".photo-scroller");slides.$items=$el.children("figure");slides.count=slides.$items.length;slides.$items.each(function(i){var $this=$(this),$slide=$this.children().first().remove(),src=$slide.attr("href"),$thumbImg=$slide.children("img"),thumbSrc=$thumbImg.attr("src"),thumbDataSrc=$thumbImg.attr("data-src"),thumbDataSrcset=$thumbImg.attr("data-srcset"),thumbClass=$thumbImg.attr("class");if($thumbImg.hasClass("lazy-load kk")){var $layzrBg="layzr-bg";}else{var $layzrBg="";}
$this.find("figcaption").addClass("caption-"+(i+1)+"");var $thisCaptionClone=$(this).find("figcaption").clone(true);$(".slide-caption").append($thisCaptionClone);if(parseInt($elParent.attr("data-thumb-width"))>0){var thisWidth=parseInt($elParent.attr("data-thumb-width")),thisHeight=parseInt($elParent.attr("data-thumb-height"));$elParent.removeClass("proportional-thumbs");}
else{var thisWidth=parseInt($thumbImg.attr("width")),thisHeight=parseInt($thumbImg.attr("height"));$elParent.addClass("proportional-thumbs");};thumbs=thumbs+'<div class="ts-cell" data-width="'+(thisWidth+5)+'" data-height="'+(thisHeight+10)+'"><div class="ts-thumb-img '+$layzrBg+'"><img class=" '+thumbClass+'" src="'+thumbSrc+'" data-src="'+thumbDataSrc+'" data-srcset="'+thumbDataSrc+'" width="'+thisWidth+'" height="'+thisHeight+'"></div></div>';$this.prepend('<div class="ts-slide-img"><img src="'+src+'" width="'+$this.attr("data-width")+'" height="'+$this.attr("data-height")+'"></div>');});$elParent.append('<div class="scroller-arrow prev"><i></i><i></i></div><div class="scroller-arrow next"><i></i><i></i></div>')
$el.addClass("ts-cont");$el.wrap('<div class="ts-wrap"><div class="ts-viewport"></div></div>');var $slider=$el.parents(".ts-wrap"),windowW=$window.width(),$sliderPar=$elParent,$sliderAutoslide=($sliderPar.attr("data-autoslide")=="true")?true:false,$sliderAutoslideDelay=($sliderPar.attr("data-delay")&&parseInt($sliderPar.attr("data-delay"))>999)?parseInt($sliderPar.attr("data-delay")):5000,$sliderLoop=($sliderPar.attr("data-loop")==="true")?true:false,$thumbHeight=$sliderPar.attr("data-thumb-height")?parseInt($sliderPar.attr("data-thumb-height"))+10:80+10,$slideOpacity=$sliderPar.attr("data-transparency")?$sliderPar.attr("data-transparency"):0.5,$adminBarH=$("#wpadminbar").length>0?$("#wpadminbar").height():0;var dataLsMin=$sliderPar.attr("data-ls-min")?parseInt($sliderPar.attr("data-ls-min")):0,dataLsMax=$sliderPar.attr("data-ls-max")?parseInt($sliderPar.attr("data-ls-max")):100,dataLsFillDt=$sliderPar.attr("data-ls-fill-dt")?$sliderPar.attr("data-ls-fill-dt"):"fill",dataLsFillMob=$sliderPar.attr("data-ls-fill-mob")?$sliderPar.attr("data-ls-fill-mob"):"fit",dataPtMin=$sliderPar.attr("data-pt-min")?parseInt($sliderPar.attr("data-pt-min")):0,dataPtMax=$sliderPar.attr("data-pt-max")?parseInt($sliderPar.attr("data-pt-max")):100,dataPtFillDt=$sliderPar.attr("data-pt-fill-dt")?$sliderPar.attr("data-pt-fill-dt"):"fill",dataPtFillMob=$sliderPar.attr("data-pt-fill-mob")?$sliderPar.attr("data-pt-fill-mob"):"fit",dataSidePaddings=$sliderPar.attr("data-padding-side")?parseInt($sliderPar.attr("data-padding-side")):0;if(dataLsMax<=0)dataLsMax=100;if(dataPtMax<=0)dataPtMax=100;if(dataLsMax<dataLsMax)dataLsMax=dataLsMax;if(dataPtMax<dataPtMax)dataPtMax=dataPtMax;$slider.addClass("ts-ls-"+dataLsFillDt).addClass("ts-ls-mob-"+dataLsFillMob);$slider.addClass("ts-pt-"+dataPtFillDt).addClass("ts-pt-mob-"+dataPtFillMob);$slider.find(".ts-slide-img").css({"opacity":$slideOpacity});$slider.find(".video-icon").css({"opacity":$slideOpacity});var $slideTopPadding=($sliderPar.attr("data-padding-top")&&windowW>760)?$sliderPar.attr("data-padding-top"):0,$slideBottomPadding=($sliderPar.attr("data-padding-bottom")&&windowW>760)?$sliderPar.attr("data-padding-bottom"):0;var $sliderVP=$slider.find(".ts-viewport");$sliderVP.css({"margin-top":$slideTopPadding+"px","margin-bottom":$slideBottomPadding+"px"});$window.on("debouncedresize",function(){if($sliderPar.attr("data-padding-top")&&$window.width()>760){$slideTopPadding=$sliderPar.attr("data-padding-top");}
else{$slideTopPadding=0;};if($sliderPar.attr("data-padding-bottom")&&$window.width()>760){$slideBottomPadding=$sliderPar.attr("data-padding-bottom");}
else{$slideBottomPadding=0;};if($window.width()>760){$sliderVP.css({"margin-top":$slideTopPadding+"px","margin-bottom":$slideBottomPadding+"px"});}
else{$sliderVP.css({"margin-top":0+"px","margin-bottom":0+"px"});};});var $sliderData=$slider.thePhotoSlider({mode:{type:"centered",lsMinW:dataLsMin,lsMaxW:dataLsMax,ptMinW:dataPtMin,ptMaxW:dataPtMax,},height:function(){var $windowH=$window.height(),$adminBarH=$("#wpadminbar").height();if($(".mixed-header").length>0){var $headerH=$(".mixed-header").height();}else{var $headerH=$(".masthead").height();}
if($body.hasClass("transparent")||$slider.parents(".photo-scroller").hasClass("full-screen")){if(window.innerWidth<dtLocal.themeSettings.mobileHeader.secondSwitchPoint){return($windowH-$slideTopPadding-$slideBottomPadding-$headerH-$adminBarH);}else{return($windowH-$slideTopPadding-$slideBottomPadding-$adminBarH);};}else if($(".mixed-header").length>0||$slider.parents(".photo-scroller").hasClass("full-screen")){if(window.innerWidth<dtLocal.themeSettings.mobileHeader.firstSwitchPoint){return($windowH-$slideTopPadding-$slideBottomPadding-$headerH-$adminBarH);}else{if($(".side-header-h-stroke").length>0){return($windowH-$slideTopPadding-$slideBottomPadding-$headerH-$adminBarH);}else{return($windowH-$slideTopPadding-$slideBottomPadding-$adminBarH);}};}else if($(".side-header").length>0||$slider.parents(".photo-scroller").hasClass("full-screen")){if(window.innerWidth<dtLocal.themeSettings.mobileHeader.firstSwitchPoint){return($windowH-$slideTopPadding-$slideBottomPadding-$headerH-$adminBarH);}else{return($windowH-$slideTopPadding-$slideBottomPadding-$adminBarH);};}else{if(window.innerWidth<dtLocal.themeSettings.mobileHeader.firstSwitchPoint){return($windowH-$slideTopPadding-$slideBottomPadding-$headerH-$adminBarH);}else{return($windowH-$slideTopPadding-$slideBottomPadding-$headerH-$adminBarH);};};},sidePaddings:dataSidePaddings,autoPlay:{enabled:$sliderAutoslide,delay:$sliderAutoslideDelay,loop:$sliderLoop}}).data("thePhotoSlider");var $thumbsScroller=$('<div class="ts-wrap"><div class="ts-viewport"><div class="ts-cont ts-thumbs">'+thumbs+'</div></div></div>');$slider.after($thumbsScroller);var $thumbsScrollerData=$thumbsScroller.thePhotoSlider({mode:{type:"scroller"},height:$thumbHeight}).data("thePhotoSlider");$(".prev",$this_par).click(function(){if(!$sliderData.noSlide)$sliderData.slidePrev();});$(".next",$this_par).click(function(){if(!$sliderData.noSlide)$sliderData.slideNext();});$sliderData.ev.on("updateNav sliderReady",function(){if($sliderData.lockRight){$(".next",$elParent).addClass("disabled");}else{$(".next",$elParent).removeClass("disabled");};if($sliderData.lockLeft){$(".prev",$elParent).addClass("disabled");}else{$(".prev",$elParent).removeClass("disabled");};});window.addEventListener("keydown",checkKeyPressed,false);function checkKeyPressed(e){if(e.keyCode=="37"){if(!$sliderData.noSlide)$sliderData.slidePrev();}else if(e.keyCode=="39"){if(!$sliderData.noSlide)$sliderData.slideNext();}}
$sliderData.ev.on("sliderReady beforeTransition",function(){$sliderData.slides.$items.removeClass("act");$sliderData.slides.$items.eq($sliderData.currSlide).addClass("act");$thumbsScrollerData.slides.$items.removeClass("act");$thumbsScrollerData.slides.$items.eq($sliderData.currSlide).addClass("act");if($sliderData.slides.$items.eq($sliderData.currSlide).hasClass("ts-video")){$sliderData.slides.$items.parents(".ts-wrap ").addClass("hide-slider-overlay");}else if($sliderData.slides.$items.eq($sliderData.currSlide).find(".ps-link").length>0){$sliderData.slides.$items.parents(".ts-wrap ").addClass("hide-slider-overlay");}else{$sliderData.slides.$items.parents(".ts-wrap ").removeClass("hide-slider-overlay");};var actCaption=$sliderData.slides.$items.eq($sliderData.currSlide).find("figcaption").attr("class");$('.slide-caption > figcaption').removeClass("actCaption");$('.slide-caption > .'+actCaption).addClass("actCaption");});$sliderData.ev.on("afterTransition",function(){var viewportLeft=-($thumbsScrollerData._unifiedX()),viewportRight=viewportLeft+$thumbsScrollerData.wrap.width,targetLeft=-$thumbsScrollerData.slides.position[$sliderData.currSlide],targetRight=targetLeft+$thumbsScrollerData.slides.width[$sliderData.currSlide];targetLeft=targetLeft-50;targetRight=targetRight+50;if(targetLeft<viewportLeft){for(i=$thumbsScrollerData.currSlide;i>=0;i--){targetLeft=targetLeft+50;targetRight=targetRight-50;var tempViewportLeft=-$thumbsScrollerData.slides.position[i],tempViewportRight=tempViewportLeft+$thumbsScrollerData.wrap.width;if(targetRight>tempViewportRight){$thumbsScrollerData.slideTo(i+1);break;}
else if(i===0){$thumbsScrollerData.slideTo(0);}}}
else if(targetRight>viewportRight){$thumbsScrollerData.slideTo($sliderData.currSlide);};});$thumbsScroller.addClass("scroller-thumbnails");$thumbsScrollerData.slides.$items.each(function(i){$(this).on("click",function(event){var $this=$(this);if($this.parents(".ts-wrap").hasClass("ts-interceptClicks"))return;$sliderData.slideTo(i);});});$(".scroller-thumbnails").layzrInitialisation();$sliderData.slides.$items.each(function(i){$(this).on("click",function(event){var $this=$(this);if($this.parents(".ts-wrap").hasClass("ts-interceptClicks"))return;$sliderData.slideTo(i);});});var $this_par=$slider.parents(".photo-scroller");if($sliderData.st.autoPlay.enabled){$(".auto-play-btn",$this_par).addClass("paused");}
$(".auto-play-btn",$this_par).on("click",function(e){e.preventDefault();var $this=$(this);if($this.hasClass("paused")){$this.removeClass("paused");if(!$sliderData.noSlide)$sliderData.pause();$sliderData.st.autoPlay.enabled=false;}else{$this.addClass("paused");if(!$sliderData.noSlide)$sliderData.play();$sliderData.st.autoPlay.enabled=true;}});};$(".photoSlider").photoSlider();$(".photoSlider").parents(".photo-scroller").css("visibility","visible");function launchFullscreen(element){if(element.requestFullscreen){element.requestFullscreen();}else if(element.mozRequestFullScreen){element.mozRequestFullScreen();}else if(element.webkitRequestFullscreen){element.webkitRequestFullscreen();}else if(element.msRequestFullscreen){element.msRequestFullscreen();}}
function exitFullscreen(){if(document.exitFullscreen){document.exitFullscreen();}else if(document.mozCancelFullScreen){document.mozCancelFullScreen();}else if(document.webkitExitFullscreen){document.webkitExitFullscreen();}};if(!dtGlobals.isWindowsPhone){$(".full-screen-btn").each(function(){var $this=$(this),$thisParent=$this.parents(".photo-scroller");document.addEventListener("fullscreenchange",function(){if(!document.fullscreen){$this.removeClass("act");$thisParent.removeClass("full-screen");$("body, html").css("overflow","");}},false);document.addEventListener("mozfullscreenchange",function(){if(!document.mozFullScreen){$this.removeClass("act");$thisParent.removeClass("full-screen");$("body, html").css("overflow","");}},false);document.addEventListener("webkitfullscreenchange",function(){if(!document.webkitIsFullScreen){$this.removeClass("act");$thisParent.removeClass("full-screen");$("body, html").css("overflow","");var scroller=$frame.data("thePhotoSlider");if(typeof scroller!="undefined"){scroller.update();};}},false);})
$(".full-screen-btn").on("click",function(e){e.preventDefault();var $this=$(this),$thisParent=$this.parents(".photo-scroller"),$frame=$thisParent.find(".ts-wrap"),$thumbs=$thisParent.find(".scroller-thumbnails").data("thePhotoSlider"),$scroller=$frame.data("thePhotoSlider");$this.parents(".photo-scroller").find("figure").animate({"opacity":0},150);if($this.hasClass("act")){$this.removeClass("act");exitFullscreen();$thisParent.removeClass("full-screen");setTimeout(function(){$this.parents(".photo-scroller").find("figure").delay(600).animate({"opacity":1},300)},300);}else{$this.addClass("act");$thisParent.addClass("full-screen");launchFullscreen(document.documentElement);$("body, html").css("overflow","hidden");setTimeout(function(){$this.parents(".photo-scroller").find("figure").delay(600).animate({"opacity":1},300)},300)}
var scroller=$frame.data("thePhotoSlider");if(typeof scroller!="undefined"){scroller.update();};});}
$photoScroller.each(function(){var $this=$(this);$(".btn-cntr, .slide-caption",$this).css({"bottom":parseInt($this.attr("data-thumb-height"))+15});if($this.hasClass("hide-thumbs")){$this.find(".hide-thumb-btn").addClass("act");$(".scroller-thumbnails",$this).css({"bottom":-(parseInt($this.attr("data-thumb-height"))+20)});$(".btn-cntr, .slide-caption",$this).css({"bottom":5+"px"});}});$(".hide-thumb-btn").on("click",function(e){e.preventDefault();var $this=$(this),$thisParent=$this.parents(".photo-scroller");if($this.hasClass("act")){$this.removeClass("act");$thisParent.removeClass("hide-thumbs");$(".scroller-thumbnails",$thisParent).css({"bottom":0});$(".btn-cntr, .slide-caption",$thisParent).css({"bottom":parseInt($thisParent.attr("data-thumb-height"))+15});}else{$this.addClass("act");$thisParent.addClass("hide-thumbs");$(".scroller-thumbnails",$thisParent).css({"bottom":-(parseInt($thisParent.attr("data-thumb-height"))+20)});$(".btn-cntr, .slide-caption",$thisParent).css({"bottom":5+"px"});}});};if($(".rsHomePorthole").exists()){var portholeSlider={};portholeSlider.container=$("#main-slideshow");portholeSlider.hendheld=$window.width()<740&&dtGlobals.isMobile?true:false;$("#main-slideshow-content").appendTo(portholeSlider.container);$.fn.portholeScroller=function(){var $el=$(this),slides={},thumbs="";slides.$items=$el.children("li"),slides.count=slides.$items.length;slides.$items.each(function(i){var $this=$(this),$slide=$this,$thumbImg=$slide.children("img"),thumbSrc=$thumbImg.attr("data-rstmb"),thumbDataSrc=$thumbImg.attr("data-src"),thumbDataSrcset=$thumbImg.attr("data-srcset"),thumbClass=$thumbImg.attr("class");if($thumbImg.hasClass("lazy-load ll")){var $layzrBg="layzr-bg";}else{var $layzrBg="";}
thumbs=thumbs+'<div class="ps-thumb-img '+$layzrBg+'"><img class=" '+thumbClass+'" src="'+thumbSrc+'"  width="150" height="150"></div>';});$el.addClass("ts-cont");$el.wrap('<div class="ts-wrap"><div class="ts-viewport portholeSlider-wrap"></div></div>');var $slider=$el.parents(".ts-wrap"),$this_par=$el.parents("#main-slideshow"),windowW=$window.width(),paddings=$this_par.attr("data-padding-side")?parseInt($this_par.attr("data-padding-side")):0,$sliderAutoslideEnable=('true'!=$this_par.attr("data-paused")&&typeof $this_par.attr("data-autoslide")!="undefined"&&!($window.width()<740&&dtGlobals.isMobile))?true:false,$sliderAutoslideDelay=$this_par.attr("data-autoslide")&&parseInt($this_par.attr("data-autoslide"))>999?parseInt($this_par.attr("data-autoslide")):5000,$sliderLoop=(typeof $this_par.attr("data-autoslide")!="undefined")?true:false,$sliderWidth=$this_par.attr("data-width")?parseInt($this_par.attr("data-width")):800,$sliderHight=$this_par.attr("data-height")?parseInt($this_par.attr("data-height")):400,imgMode=$this_par.attr("data-scale")?$this_par.attr("data-scale"):"none";var $sliderData=$slider.thePhotoSlider({mode:{type:"slider"},height:$sliderHight,width:$sliderWidth,resizeImg:true,imageScaleMode:imgMode,imageAlignCenter:true,autoPlay:{enabled:$sliderAutoslideEnable,delay:$sliderAutoslideDelay,loop:$sliderLoop}}).data("thePhotoSlider");var $thumbsScroller=$('<div class="psThumbs"><div class="psThumbsContainer">'+thumbs+'</div></div>');$slider.append($thumbsScroller);var $psThumb=$(".ps-thumb-img ");$psThumb.each(function(i){$(this).on("click",function(event){var $this=$(this);$sliderData.slideTo(i);});});$(".psThumbsContainer").after('<div class="progress-wrapper"><div class="progress-controls"></div></div>');$progressWrap=$(".psThumbsContainer").next();$progressHtml='<div class="progress-mask"><div class="progress-spinner-left" style="animation-duration: '+$sliderAutoslideDelay+'ms;"></div></div><div class="progress-mask"><div class="progress-spinner-right" style="animation-duration: '+$sliderAutoslideDelay+'ms;"></div></div>';if($sliderData.st.autoPlay.enabled){if($progressWrap.find(".progress-mask").length<1){$progressWrap.prepend($progressHtml);}}
$sliderData.ev.on("autoPlayPlay",function(){if($progressWrap.find(".progress-mask").length<1){$progressWrap.prepend($progressHtml);}
$progressWrap.removeClass("paused");});$sliderData.ev.on("autoPlayPause",function(){$progressWrap.find(".progress-mask").remove();if(!$sliderAutoslideEnable){$progressWrap.addClass("paused");}});$sliderData.ev.on("sliderReady beforeTransition",function(){var newPos=-$sliderData.currSlide*40;if(newPos==0){newPos=20;}
$psThumb.removeClass("psNavSelected psNavPrev psNavNext psNavVis");$psThumb.eq($sliderData.currSlide).addClass("psNavSelected");$psThumb.eq($sliderData.currSlide).prev().addClass("psNavPrev");$psThumb.eq($sliderData.currSlide).next().addClass("psNavNext");$psThumb.eq($sliderData.currSlide).prev().prev().addClass("psNavVis");$psThumb.eq($sliderData.currSlide).next().next().addClass("psNavVis");$(".psThumbsContainer").css({transform:'translateY('+newPos+'px)'});})
$sliderData.ev.on("sliderReady beforeTransition",function(){$progressWrap.addClass("blurred");});$sliderData.ev.on("sliderReady afterTransition",function(){$progressWrap.removeClass("blurred");});var dtResizeTimeout;$window.on("resize",function(){clearTimeout(dtResizeTimeout);dtResizeTimeout=setTimeout(function(){$progressWrap.removeClass("blurred");},200);});$('<div class="leftArrow"></div><div class="rightArrow"></div>').insertAfter($el);$(".leftArrow",$slider).click(function(){if(!$sliderData.noSlide)$sliderData.slidePrev();});$(".rightArrow",$slider).click(function(){if(!$sliderData.noSlide)$sliderData.slideNext();});$sliderData.ev.on("updateNav sliderReady",function(){if($sliderData.lockRight){$(".rightArrow",$slider).addClass("disabled");}else{$(".rightArrow",$slider).removeClass("disabled");};if($sliderData.lockLeft){$(".leftArrow",$slider).addClass("disabled");}else{$(".leftArrow",$slider).removeClass("disabled");};if($sliderData.lockRight&&$sliderData.lockLeft){$this_par.addClass("hide-arrows");};});if('true'===$this_par.attr("data-paused")){$progressWrap.addClass("paused");};$progressWrap.on("click",function(e){e.preventDefault();var $this=$(this);if($this.hasClass("paused")){$this.removeClass("paused");if($progressWrap.find(".progress-mask").length<1){$progressWrap.prepend($progressHtml);}
if(!$sliderData.noSlide)$sliderData.play();$sliderData.st.autoPlay.enabled=true;}else{$this.addClass("paused");if(!$sliderData.noSlide)$sliderData.pause();$sliderData.st.autoPlay.enabled=false;$progressWrap.find(".progress-mask").remove();}});};$(".rsHomePorthole").each(function(){$(this).portholeScroller();});};});(function($){$.fn.collagePlus=function(options){var defaults={'targetHeight':400,'albumWidth':this.width(),'padding':parseFloat(this.css('padding-left')),'images':this.children(),'fadeSpeed':"fast",'display':"inline-block",'effect':'default','direction':'vertical','allowPartialLastRow':false};var settings=$.extend({},defaults,options);return this.each(function(){var row=0,elements=[],rownum=1;settings.images.each(function(index){var $this=$(this),$img=($this.is("img"))?$this:$(this).find("img").not(".blur-effect").first();if($img.attr("width")!='undefined'&&$img.attr("height")!='undefined'){var w=(typeof $img.data("width")!='undefined')?$img.data("width"):$img.attr("width"),h=(typeof $img.data("height")!='undefined')?$img.data("height"):$img.attr("height");}
else{var w=(typeof $img.data("width")!='undefined')?$img.data("width"):$img.width(),h=(typeof $img.data("height")!='undefined')?$img.data("height"):$img.height();}
var imgParams=getImgProperty($img);$img.data("width",w);$img.data("height",h);var nw=Math.ceil(w/h*settings.targetHeight),nh=Math.ceil(settings.targetHeight);elements.push([this,nw,nh,imgParams['w'],imgParams['h']]);row+=nw+imgParams['w']+settings.padding;if(row>settings.albumWidth&&elements.length!=0){resizeRow(elements,row,settings,rownum);delete row;delete elements;row=0;elements=[];rownum+=1;}
if(settings.images.length-1==index&&elements.length!=0){resizeRow(elements,row,settings,rownum);delete row;delete elements;row=0;elements=[];rownum+=1;}});$(this).trigger("jgDone");});function resizeRow(obj,row,settings,rownum){var imageExtras=(settings.padding*obj.length)+(obj.length*obj[0][3]),albumWidthAdjusted=settings.albumWidth-imageExtras,overPercent=albumWidthAdjusted/(row-imageExtras),trackWidth=imageExtras,lastRow=(row<settings.albumWidth?true:false);for(var i=0;i<obj.length;i++){var $obj=$(obj[i][0]),fw=Math.floor(obj[i][1]*overPercent),fh=Math.floor(obj[i][2]*overPercent),isNotLast=!!((i<obj.length-1));if(settings.allowPartialLastRow===true&&lastRow===true){fw=obj[i][1];fh=obj[i][2];}
trackWidth+=fw;var $img=($obj.is("img"))?$obj:$obj.find("img").not(".blur-effect").first();$img.width(fw);if(!$obj.is("img")){$obj.width(fw+obj[i][3]);}
$img.height(fh);if(!$obj.is("img")){$obj.height(fh+obj[i][4]);}
if(settings.allowPartialLastRow===false&&lastRow===true){applyModifications($obj,isNotLast,"none");}
else{applyModifications($obj,isNotLast,settings.display);};}}
function applyModifications($obj,isNotLast,settingsDisplay){var css={'display':settingsDisplay,'vertical-align':"bottom",'overflow':"hidden"};return $obj.css(css);}
function getImgProperty(img){$img=$(img);var params=new Array();params["w"]=(parseFloat($img.css("border-left-width"))+parseFloat($img.css("border-right-width")));params["h"]=(parseFloat($img.css("border-top-width"))+parseFloat($img.css("border-bottom-width")));return params;}};var jgCounter=0;$(".jg-container").each(function(){jgCounter++;var $jgContainer=$(this),$jgItemsPadding=$jgContainer.attr("data-padding"),$jgItems=$jgContainer.find(".wf-cell");$jgContainer.attr("id","jg-container-"+jgCounter+"");$("<style type='text/css'>"+' .content #jg-container-'+jgCounter+' .wf-cell'+'{padding:'+$jgItemsPadding+';}'+' .content #jg-container-'+jgCounter+'.wf-container'+'{'+'margin:'+'-'+$jgItemsPadding+';}'+' .content .full-width-wrap #jg-container-'+jgCounter+'.wf-container'+'{'+'margin-left:'+$jgItemsPadding+'; '+'margin-right:'+$jgItemsPadding+'; '+'margin-top:'+'-'+$jgItemsPadding+'; '+'margin-bottom:'+'-'+$jgItemsPadding+';}'+"</style>").insertAfter($jgContainer);$jgContainer.on("jgDone",function(){var layzrJGrid=new Layzr({selector:'.jgrid-lazy-load',attr:'data-src',attrSrcSet:'data-srcset',retinaAttr:'data-src-retina',threshold:0,before:function(){this.setAttribute("sizes",this.width+"px");},callback:function(){this.classList.add("jgrid-layzr-loaded");var $this=$(this);$this.one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend',function(e){setTimeout(function(){$this.parent().removeClass("layzr-bg");},200)});}});});});$.fn.collage=function(args){return this.each(function(){var $this=$(this);var $jgContainer=$(this),$jgItemsPadding=$jgContainer.attr("data-padding"),$jgItems=$jgContainer.find(".wf-cell");var jgPadding=parseFloat($jgItems.first().css('padding-left'))+parseFloat($jgItems.first().css('padding-right')),jgTargetHeight=parseInt($jgContainer.attr("data-target-height")),jdPartRow=true;if($jgContainer.attr("data-part-row")=="false"){jdPartRow=false;};if($jgContainer.parent(".full-width-wrap").length){var jgAlbumWidth=$jgContainer.parents(".full-width-wrap").width()-parseInt($jgItemsPadding)*2;}else{var jgAlbumWidth=$jgContainer.parent().width()+parseInt($jgItemsPadding)*2;}
var $jgCont={'albumWidth':jgAlbumWidth,'targetHeight':jgTargetHeight,'padding':jgPadding,'allowPartialLastRow':jdPartRow,'fadeSpeed':2000,'effect':'effect-1','direction':'vertical'};$.extend($jgCont,args);dtGlobals.jGrid=$jgCont;$jgContainer.collagePlus($jgCont);$jgContainer.css({'width':jgAlbumWidth});});};$(window).on("debouncedresize",function(){$(".jg-container").not('.jgrid-shortcode').collage();$(".jgrid-shortcode").each(function(){var $this=$(this);var $visibleItems=$this.data('visibleItems');if($visibleItems){$this.collage({'images':$visibleItems});}else{$this.collage();}});}).trigger("debouncedresize");})(jQuery);