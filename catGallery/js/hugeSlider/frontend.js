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

/**
 * Copyright (c) 2007 Ariel Flesler - aflesler ○ gmail • com | https://github.com/flesler
 * Licensed under MIT
 * @author Ariel Flesler
 * @version 2.1.2
 */
(function (f) {
  "use strict";
  "function" === typeof define && define.amd
    ? define(["jquery"], f)
    : "undefined" !== typeof module && module.exports
    ? (module.exports = f(require("jquery")))
    : f(jQuery);
})(function ($) {
  "use strict";
  function n(a) {
    return (
      !a.nodeName ||
      -1 !==
        $.inArray(a.nodeName.toLowerCase(), [
          "iframe",
          "#document",
          "html",
          "body",
        ])
    );
  }
  function h(a) {
    return $.isFunction(a) || $.isPlainObject(a) ? a : { top: a, left: a };
  }
  var p = ($.scrollTo = function (a, d, b) {
    return $(window).scrollTo(a, d, b);
  });
  p.defaults = { axis: "xy", duration: 0, limit: !0 };
  $.fn.scrollTo = function (a, d, b) {
    "object" === typeof d && ((b = d), (d = 0));
    "function" === typeof b && (b = { onAfter: b });
    "max" === a && (a = 9e9);
    b = $.extend({}, p.defaults, b);
    d = d || b.duration;
    var u = b.queue && 1 < b.axis.length;
    u && (d /= 2);
    b.offset = h(b.offset);
    b.over = h(b.over);
    return this.each(function () {
      function k(a) {
        var k = $.extend({}, b, {
          queue: !0,
          duration: d,
          complete:
            a &&
            function () {
              a.call(q, e, b);
            },
        });
        r.animate(f, k);
      }
      if (null !== a) {
        var l = n(this),
          q = l ? this.contentWindow || window : this,
          r = $(q),
          e = a,
          f = {},
          t;
        switch (typeof e) {
          case "number":
          case "string":
            if (/^([+-]=?)?\d+(\.\d+)?(px|%)?$/.test(e)) {
              e = h(e);
              break;
            }
            e = l ? $(e) : $(e, q);
          case "object":
            if (e.length === 0) return;
            if (e.is || e.style) t = (e = $(e)).offset();
        }
        var v = ($.isFunction(b.offset) && b.offset(q, e)) || b.offset;
        $.each(b.axis.split(""), function (a, c) {
          var d = "x" === c ? "Left" : "Top",
            m = d.toLowerCase(),
            g = "scroll" + d,
            h = r[g](),
            n = p.max(q, c);
          t
            ? ((f[g] = t[m] + (l ? 0 : h - r.offset()[m])),
              b.margin &&
                ((f[g] -= parseInt(e.css("margin" + d), 10) || 0),
                (f[g] -= parseInt(e.css("border" + d + "Width"), 10) || 0)),
              (f[g] += v[m] || 0),
              b.over[m] &&
                (f[g] += e["x" === c ? "width" : "height"]() * b.over[m]))
            : ((d = e[m]),
              (f[g] =
                d.slice && "%" === d.slice(-1)
                  ? (parseFloat(d) / 100) * n
                  : d));
          b.limit &&
            /^\d+$/.test(f[g]) &&
            (f[g] = 0 >= f[g] ? 0 : Math.min(f[g], n));
          !a &&
            1 < b.axis.length &&
            (h === f[g] ? (f = {}) : u && (k(b.onAfterFirst), (f = {})));
        });
        k(b.onAfter);
      }
    });
  };
  p.max = function (a, d) {
    var b = "x" === d ? "Width" : "Height",
      h = "scroll" + b;
    if (!n(a)) return a[h] - $(a)[b.toLowerCase()]();
    var b = "client" + b,
      k = a.ownerDocument || a.document,
      l = k.documentElement,
      k = k.body;
    return Math.max(l[h], k[h]) - Math.min(l[b], k[b]);
  };
  $.Tween.propHooks.scrollLeft = $.Tween.propHooks.scrollTop = {
    get: function (a) {
      return $(a.elem)[a.prop]();
    },
    set: function (a) {
      var d = this.get(a);
      if (a.options.interrupt && a._last && a._last !== d)
        return $(a.elem).stop();
      var b = Math.round(a.now);
      d !== b && ($(a.elem)[a.prop](b), (a._last = this.get(a)));
    },
  };
  return p;
});

$(document).ready(function () {
  if (typeof cG_hS !== "undefined" && typeof cG_hSLoaded === "undefined") {
    cG_hSLoaded = true;
    $.each(cG_hS, function (index, cGID) {
      var $cG = $("#cG_hS_" + cGID.cG_id),
        $fig = $cG.children("figure"),
        $first = $fig.filter(":first"),
        $last = $fig.filter(":last");
      $fig.filter(":first").addClass("active");
      if ($fig.length > 1) {
        setInterval(function () {
          if ($last.hasClass("active")) {
            $last.removeClass("active");
            $first.addClass("active");
            $fig.filter(".hide").removeClass("hide");
          } else {
            $fig.filter(".hide").removeClass("hide");
            $fig
              .filter(".active")
              .removeClass("active")
              .addClass("hide")
              .next()
              .addClass("active");
            if ($last.hasClass("active")) {
              $first.addClass("hide");
            }
          }
        }, cGID.interval);
      }
      $cG.children("span").click(function () {
        $(window).scrollTo($cG.height(), 1000);
      });
    });
  }
});
