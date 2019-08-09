$(document).ready(function ()
{
	if (typeof cGrec !== 'undefined' && typeof cGrecLoaded === 'undefined')
	{
		cGrecLoaded = true;
		$.each(cGrec, function (index, cGID)
		{
			var $cG = $('#cG_rec_' + cGID.cG_id),
				$prev = $cG.children('.prev'),
				$next = $cG.children('.next'),
				$figs = $cG.children('figure'),
				cF = $figs.length,
				i = 0;
			$figs.filter(':first').addClass('active');
			$next.click(function (e)
			{
				if (cF > i + 1 )
				{
					$figs.eq(i++).removeClass('active');
					$figs.eq(i).addClass('active');
					if (i == 1) $prev.addClass('active');
					if (cF == i + 1) $next.removeClass('active');
				}
			});
			$prev.click(function (e)
			{
				if (i > 0)
				{
					$figs.eq(i--).removeClass('active');
					$figs.eq(i).addClass('active');
					if (i + 2 == cF) $next.addClass('active');
					if (i === 0) $prev.removeClass('active');
				}
			});
			var ts;
			$cG.bind('touchstart', function (e)
			{
				ts = e.originalEvent.touches[0].clientX;
			});
			$cG.bind('touchend', function (e)
			{
				var te = e.originalEvent.changedTouches[0].clientX;
				if (ts > te + 100)
				{
					$next.click();
				}
				else if (ts < te - 100)
				{
					$prev.click();
				}
			});
		});
	}
});