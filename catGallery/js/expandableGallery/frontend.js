/**
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 3 of the License, or (at
 *   your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful, but
 *   WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 *   General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with this program; if not, see <http://www.gnu.org/licenses/>.
 *
 *   @author			Matthias Glienke
 *   @copyright			2019, Black Cat Development
 *   @link				https://blackcat-cms.org
 *   @license			http://www.gnu.org/licenses/gpl.html
 *   @category			CAT_Modules
 *   @package			catGallery
 *
 */

$(document).ready(function()
{
	if (typeof cG_eG !== 'undefined' && typeof cG_eGLoaded === 'undefined')
	{
		cG_eGLoaded	= true;
		$.each( cG_eG, function( index, cGID )
		{
			var	$cG		= $('#cG_eG_' + cGID.cG_id ),
				$fig	= $cG.children('figure'),
				$prev	= $fig.children('button.cG_eG-prev'),
				$next	= $fig.children('button.cG_eG-next'),
				$exp	= $fig.children('button.cG_eG-zoom-in'),
				$close	= $fig.children('button.cG_eG-cancel'),
				$imgs	= $fig.children('div').children('img'),
				$img	= $imgs.filter(':first'),
				iCount	= $imgs.size(),
				imgC	= 0;

			$fig.append('<nav />')
			$cG.addClass('gec');

			var	$nav	= $fig.children('nav');

			for ( i=0;i<iCount;i++)
			{
				$nav.append('<a href="" />')
			}
			var	$nLink	= $nav.children('a');
			
			$nLink.filter(':first').addClass('active');

			$imgs.click(function(){$cG.addClass('active');});
			$exp.click(function(){$cG.addClass('active');});
			$close.click(function(){$cG.removeClass('active');});
			$next.click(function()
			{
				$prev.removeClass('inactive');
				if ( imgC < iCount-1 )
				{
					$('body').scroll();
					$nLink.eq(imgC).removeClass('active');
					$img.css({marginLeft: '-' + (100*(++imgC)) + '%'});
					$nLink.eq(imgC).addClass('active');
				}
				if ( imgC == iCount-1 )
					$next.addClass('inactive');
			});
			$prev.click(function()
			{
				$('body').scroll();
				$next.removeClass('inactive');
				if ( imgC > 0 )
				{
					$nLink.eq(imgC).removeClass('active');
					$img.css({marginLeft: '-' + (100*(--imgC)) + '%'});
					$nLink.eq(imgC).addClass('active');
				}
				if ( imgC == 0 )
					$prev.addClass('inactive');
			});
			$nLink.click(function(e)
			{
				$('body').scroll();
				e.preventDefault();
				var $cur	= $(this);
				$nLink.eq(imgC).removeClass('active');
				imgC	= $cur.index();
				$nLink.eq(imgC).addClass('active');
				$img.css({marginLeft: '-' + (100*(imgC)) + '%'});
				
				$prev.removeClass('inactive');
				$next.removeClass('inactive');
				if ( imgC == 0 )
					$prev.addClass('inactive');
				if ( imgC == iCount-1 )
					$next.addClass('inactive');
			});
			
			var ts;
			$imgs.bind('touchstart', function (e)
			{
				ts = e.originalEvent.touches[0].clientX;
			});
			
			$imgs.bind('touchend', function (e){
				var te = e.originalEvent.changedTouches[0].clientX;
				if(ts > te+100)
				{
					$next.click();
				}else if(ts < te-100)
				{
					$prev.click();
				}
			});
			
		});

	}
});