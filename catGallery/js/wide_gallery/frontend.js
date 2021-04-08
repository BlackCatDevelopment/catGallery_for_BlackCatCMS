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
 *   @copyright			2021, Black Cat Development
 *   @link				https://blackcat-cms.org
 *   @license			http://www.gnu.org/licenses/gpl.html
 *   @category			CAT_Modules
 *   @package			catGallery
 *
 */

$(document).ready(function () {
  $(".fancybox").fancybox({
    openEffect: "elastic",
    closeEffect: "elastic",
    helpers: {
      overlay: {
        locked: false,
      },
    },
  });

  var $container = $(".wide_gallery_container").children("ul");
  ($img = $container.find("img")),
    (imgCount = $img.length),
    (imgWidth = $img.filter(":first").width()),
    ($nav = $(".wide_gallery_nav").children("ul"));

  function resizeImages($container, $img, imgCount, imgWidth) {
    var winWidth = $(".wide_gallery_container").parent().innerWidth(),
      imgTotal = Math.round(winWidth / imgWidth),
      imgNewWidth = winWidth / imgTotal,
      nav_point = Math.ceil(imgCount / imgTotal);

    $nav.html("");

    if (winWidth < imgWidth * imgCount) {
      $img.css({ width: imgNewWidth });
      $container.css({ width: imgNewWidth * imgCount });

      for (var i = 1; i <= nav_point; i++) {
        $nav.append('<li class="wide_gallery_point" />');
      }
      $nav.children("li:first").click();
    } else {
      $img.css({ width: imgWidth });
      $container.css({ width: imgWidth * imgCount });
    }
  }

  $(window).resize(function () {
    resizeImages($container, $img, imgCount, imgWidth);
  });

  $(".wide_gallery_nav").on("click", ".wide_gallery_point", function () {
    var current = $(this),
      winWidth = $(".wide_gallery_container").parent().innerWidth(),
      imgCurrW = $img.filter(":first").width(),
      imgView = winWidth / imgCurrW,
      position = current.index();

    $nav
      .children("li")
      .removeClass("active")
      .filter(current)
      .addClass("active");

    $container
      .stop()
      .animate(
        { marginLeft: -position * winWidth },
        animSpeed,
        "easeInOutCirc"
      );
  });

  resizeImages($container, $img, imgCount, imgWidth);
});
