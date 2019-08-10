if (!$.fn.cardSlider) {
    (function($) {
        $.fn.cardSlider = function(options) {
            var defaults = {
                duration: 6000
            };
            var options = $.extend(defaults, options);
            return this.each(function() {
                $cur	= $(this),
                $imgs	= $cur.find('img');

				setInterval(function(){
					$cur.children('img:last').addClass('up');
					setTimeout(function(){
						$cur.prepend($cur.children('img:last'));
						setTimeout(function(){$cur.children('img:first').removeClass('up cG_r1 cG_r2 cG_r3 cG_r4 cG_r5 cG_r6').addClass('cG_r' + (Math.round(Math.random() * 6)));},5);
					}, 650);
				},options.duration);
            });
        }
    })(jQuery);
}
$(document).ready(function()
{
	if(typeof cardSlider!=='undefined'&&typeof cardSliderLoad==='undefined')
	{
		cardSliderLoad=true;
		$.each(cardSlider,function(index,cS_ID)
		{
			$("#cG_cardS_"+cS_ID.section_id).cardSlider({duration:cS_ID.pauseTime});
		});
	}
});