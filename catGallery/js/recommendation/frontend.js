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
 *   @author			Matthias Glienke, letima
 *   @copyright			2021, Black Cat Development
 *   @link				https://blackcat-cms.org
 *   @license			http://www.gnu.org/licenses/gpl.html
 *   @category			CAT_Modules
 *   @package			catGallery
 *
 */
$(document).ready(function () {
  if (typeof cGrec !== "undefined" && typeof cGrecLoaded === "undefined") {
    cGrecLoaded = true;
    $.each(cGrec, function (index, cGID) {
      var $cG = $("#cG_rec_" + cGID.cG_id),
        $prev = $cG.children(".prev"),
        $next = $cG.children(".next"),
        $figs = $cG.children("figure"),
        cF = $figs.length,
        i = 0;
      $figs.filter(":first").addClass("active");
      $next.click(function (e) {
        if (cF > i + 1) {
          $figs.eq(i++).removeClass("active");
          $figs.eq(i).addClass("active");
          if (i == 1) $prev.addClass("active");
          if (cF == i + 1) $next.removeClass("active");
        }
      });
      $prev.click(function (e) {
        if (i > 0) {
          $figs.eq(i--).removeClass("active");
          $figs.eq(i).addClass("active");
          if (i + 2 == cF) $next.addClass("active");
          if (i === 0) $prev.removeClass("active");
        }
      });
      var ts;
      $cG.bind("touchstart", function (e) {
        ts = e.originalEvent.touches[0].clientX;
      });
      $cG.bind("touchend", function (e) {
        var te = e.originalEvent.changedTouches[0].clientX;
        if (ts > te + 100) {
          $next.click();
        } else if (ts < te - 100) {
          $prev.click();
        }
      });
    });
  }
});
