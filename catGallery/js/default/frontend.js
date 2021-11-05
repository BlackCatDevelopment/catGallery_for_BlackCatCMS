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
$(document).ready(function () {
  if (typeof cG_def !== "undefined" && typeof cG_defLoaded === "undefined") {
    cG_defLoaded = true;
    $.each(cG_def, function (index, cGID) {
      var $cG = $("#slider_skitter_" + cGID.cG_id);
      $cG.skitter({
        animation: cGID.animation,
        interval: cGID.interval,
        velocity: cGID.velocity,
        stop_over: cGID.stop_over,
        auto_play: cGID.auto_play,
        navigation: cGID.navigation,
        thumbs: cGID.thumbs,
        progressbar: cGID.progressbar,
        numbers: cGID.numbers,
        controls: cGID.controls,
        dots: cGID.dots,
        focus: cGID.focus,
        label: cGID.label,
        preview: cGID.preview,
      });
    });
  }
});
