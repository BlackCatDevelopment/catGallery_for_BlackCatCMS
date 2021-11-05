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
 *   @author			Matthias Glienke, letima development
 *   @copyright			2021, Black Cat Development
 *   @link				https://blackcat-cms.org
 *   @license			http://www.gnu.org/licenses/gpl.html
 *   @category			CAT_Modules
 *   @package			catGallery
 *
 */

if (!$.fn.cardSlider) {
  (function ($) {
    $.fn.cardSlider = function (options) {
      var defaults = {
        duration: 6000,
      };
      var options = $.extend(defaults, options);
      return this.each(function () {
        ($cur = $(this)), ($imgs = $cur.find("img"));

        setInterval(function () {
          $cur.children("img:last").addClass("up");
          setTimeout(function () {
            $cur.prepend($cur.children("img:last"));
            setTimeout(function () {
              $cur
                .children("img:first")
                .removeClass("up cG_r1 cG_r2 cG_r3 cG_r4 cG_r5 cG_r6")
                .addClass("cG_r" + Math.round(Math.random() * 6));
            }, 5);
          }, 650);
        }, options.duration);
      });
    };
  })(jQuery);
}
$(document).ready(function () {
  if (
    typeof cardSlider !== "undefined" &&
    typeof cardSliderLoad === "undefined"
  ) {
    cardSliderLoad = true;
    $.each(cardSlider, function (index, cS_ID) {
      $("#cG_cardS_" + cS_ID.section_id).cardSlider({
        duration: cS_ID.pauseTime,
      });
    });
  }
});
