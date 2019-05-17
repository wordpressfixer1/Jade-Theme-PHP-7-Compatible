/**
 * @Positioning:
 *              [B|T] First Letter Always for Bottom or Top
 *              [R|L] Second Letter Always for Right or Left
 *              [L|R|U|D] Third Letter for Entrance or Exit point. Left, Right, Up, Down
 * @Usage:
 *              entrance must be near footer
 *              exit must be near head
 *              Please see @Map link for better enlightenment
 *
 * @Map         http://d.pr/i/UxFw+
 *
 * @ExampleUsage
 *              $('.met_windmill_carousel').windmillCarousel({
 *                  textBox: 'BR',              // Text Box Position, Choose one from @Map,                     Default: BR
 *                  entrance: 'BLL',            // Entrance Point Position, Choose one from @Map,               Default: BR
 *                  exit: 'TRU',                // Exit Point Position, Choose one from @Map,                   Default: TRU
 *                  head: 'TR',                 // Head Box Position, Choose one from @Map,                     Default: TR
 *                  body: 'TL',                 // Body Box Position, Choose one from @Map,                     Default: TL
 *                  foot: 'BL',                 // Foot Box Position, Choose one from @Map,                     Default: BL
 *                  autoPlay: 2000,             // Integer Autoplay Time in Milliseconds, 1000 = 1 Second,      Default 0
 *                  autoPlayDirection: 'next'   // What Direction Does Carousel Auto Scroll, 'next' or 'prev',  Default 'next'
 *              });
 */
(function($) {
	$.fn.windmillCarousel = function(params) {
		params = $.extend({
			textBox: 'BR',
			entrance: 'BLL',
			exit: 'TRU',
			head: 'TR',
			body: 'TL',
			foot: 'BL',
			autoPlay: 0,
			autoPlayDirection: 'next'
		}, params);

		this.each(function(){
			/**
			 * Positions-----------------
			 * direction[0] => Entrance
			 * direction[1] => Exit
			 * positions[0] => Head Item
			 * positions[1] => Body Item
			 * positions[2] => Foot Item
			 * positions[5] => Article
			 * --------------------------
			 */
			var mainCube = $(this),
				cube = mainCube.find('.met_windmill_carousel_item'),
				articleCube = mainCube.find('article'),
				direction = new Array(params.entrance,params.exit),
				positions = new Array(params.head,params.body,params.foot,direction[0],direction[1],params.textBox),
				i = 0,
				interval,
				autoPlayDirection = params.autoPlayDirection == 'next' ? 1 : 0;

			cube.imagesLoaded(function(){mainCube.css('height', (cube.height()*2)+'px');});
            $(window).on('debouncedresize', function(){mainCube.css('height', (cube.height()*2)+'px');});
			cube.each(function(){
				$(this).attr('data-cube-position', positions[i]);

				if(i >= 3){i=3}else{i++}
			});
			articleCube.attr('data-cube-position', positions[positions.length-1]);

			if(params.autoPlay) interval = setInterval(function(){cubeNav(autoPlayDirection)},params.autoPlay);

			mainCube.find('.met_windmill_carousel_next').click(function(e){
				e.preventDefault();
				clearInterval(interval);
				cubeNav(1);
				if(params.autoPlay) interval = setInterval(function(){cubeNav(autoPlayDirection)},params.autoPlay);
			});
			mainCube.find('.met_windmill_carousel_prev').click(function(e){
				e.preventDefault();
				clearInterval(interval);
				cubeNav(0);
				if(params.autoPlay) interval = setInterval(function(){cubeNav(autoPlayDirection)},params.autoPlay);
			});


			function cubeNav(d){
				var roadTo = d ? new Array(0,1,2,1,3,'next') : new Array(2,1,0,1,4,'prev'),
					go     = d ? new Array(4,0,1,2) : new Array(3,2,1,0);

				if(mainCube.find('[data-cube-position="' + positions[roadTo[4]] + '"]').get(0)){
					for(var m = 0; m <= 3; m++){
						if(m!=3){
							mainCube.find('[data-cube-position="' + positions[roadTo[m]] + '"]').attr('data-cube-position', positions[go[m]]);
						}else{
							mainCube.find('[data-cube-position="' + positions[roadTo[m]] + '"]')[roadTo[5]]().attr('data-cube-position',positions[go[m]]);
						}
					}
				}else{
					clearInterval(interval);
				}
			}

		});
		return this;
	};
})(jQuery);