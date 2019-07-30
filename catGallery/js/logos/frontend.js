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

function scroller($imgs,$wrap)
{
	var $img	= $imgs.filter(':first');
	$img.animate(
	{
		marginLeft:	'-' + ($img.outerWidth()+1.5*parseInt($wrap.css('font-size'))) + 'px',		
	}, 8000, 'linear', function()
	{
		$(this).appendTo($wrap).css({ marginLeft: '0px' });
		scroller($wrap.children('img'),$wrap);
	});
}

$(document).ready(function()
{
	if (typeof cG_logo !== 'undefined' && typeof cG_logoLoaded === 'undefined')
	{
		cG_logoLoaded	= true;
		$.each( cG_logo, function( index, cGID )
		{
			var	$cG		= $('#cG_logo_' + cGID.cG_id );
				$cG.children('.cG_logo_wrap').children('img').clone().appendTo($cG.children('.cG_logo_wrap'));
			var $wrap	= $cG.children('.cG_logo_wrap'),
				$imgs	= $wrap.children('img');
				scroller($imgs,$wrap);
		});
	}
});