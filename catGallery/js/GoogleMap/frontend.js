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
    /*******************************
    	 * 
    	 * Activate "GoogleMaps"
    	 * 
    	 *******************************/
    if (typeof catGalMapIDs !== 'undefined'
    && typeof catGalMapLoaded === 'undefined'
    && !$('body').hasClass('is_mobile')
    ) {
        catGalMapLoaded = true;
        $.each( catGalMapIDs, function( index, cGID )
        {
            var map;
            function init() {
                var mapOptions = {
                    center: new google.maps.LatLng(cGID.options.lat, cGID.options.lon),
                    draggable: false,
                    zoom: cGID.options.zoom,
                    zoomControl: true,
                    zoomControlOptions: {
                        style: google.maps.ZoomControlStyle.LARGE,
                        position: google.maps.ControlPosition.LEFT_CENTER
                    },
                    disableDoubleClickZoom: true,
                    mapTypeControl: false,
                    mapTypeControlOptions: {
                        style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                        position: google.maps.ControlPosition.RIGHT_TOP
                    },
                    panControl: false,
                    scaleControl: true,
                    scrollwheel: false,
                    streetViewControl: false,
                    overviewMapControl: false,
                    mapTypeId: google.maps.MapTypeId.TERRAIN,
                    styles: [
                    {
                        "stylers": [ {
                            "saturation": - 100 
                        }
                        ] 
                    },
                    {
                        "featureType": "water",
                        "elementType": "geometry.fill",
                        "stylers": [ {
                            "color": cGID.options.water 
                        }
                        ] 
                    },
                    {
                        "elementType": "labels",
                        "stylers": [ {
                            "visibility": "off" 
                        }
                        ] 
                    },
                    {
                        "featureType": "poi.park",
                        "elementType": "geometry.fill",
                        "stylers": [ {
                            "color": cGID.options.park 
                        }
                        ] 
                    },
                    {
                        "featureType": "landscape.natural",
                        "elementType": "geometry.fill",
                        "stylers": [ {
                            "color": cGID.options.la_natural 
                        }
                        ] 
                    },
                    {
                        "featureType": "landscape.man_made",
                        "elementType": "geometry.fill",
                        "stylers": [ {
                            "color": cGID.options.man_made 
                        }
                        ] 
                    },
                    {
                        "featureType": "road.highway",
                        "elementType": "labels",
                        "stylers": [ {
                            "visibility": "on" 
                        }
                        ] 
                    },
                    {
                        "featureType": "road.highway",
                        "elementType": "geometry.fill",
                        "stylers": [ {
                            "color": cGID.options.r_hway_fill 
                        }
                        ] 
                    },
                    {
                        "featureType": "road.highway",
                        "elementType": "geometry.stroke",
                        "stylers": [ {
                            "color": cGID.options.r_hway_stroke 
                        }
                        ] 
                    },
                    {
                        "featureType": "road.arterial",
                        "elementType": "labels.text",
                        "stylers": [ {
                            "visibility": "on" 
                        }
                        ] 
                    },
                    {
                        "featureType": "road.arterial",
                        "elementType": "geometry.fill",
                        "stylers": [ {
                            "color": cGID.options.r_a_fill 
                        }
                        ] 
                    },
                    {
                        "featureType": "road.arterial",
                        "elementType": "geometry.stroke",
                        "stylers": [ {
                            "color": cGID.options.r_a_stroke 
                        }
                        ] 
                    },
                    {
                        "featureType": "road.local",
                        "elementType": "labels.text",
                        "stylers": [ {
                            "visibility": "on" 
                        }
                        ] 
                    },
                    {
                        "featureType": "road.local",
                        "elementType": "geometry.fill",
                        "stylers": [ {
                            "color": cGID.options.r_l 
                        }
                        ] 
                    },
                    {
                        "featureType": "transit",
                        "elementType": "all",
                        "stylers": [{
                            "color": cGID.options.rail
                        }
                        ]
                    }
                    ],

                }
                var mapElement = document.getElementById('map_' + cGID.section_id),
                map = new google.maps.Map(mapElement, mapOptions),
                locations = new Array();

                locations[0] = {
                    1: cGID.options.lat,
                    2: cGID.options.lon,
                    'icon': '/templates/eps/css/default/images/maps-icon.png',
                    'title': 'Ernst Penzoldt Mittelschule'
                };

                for (i = 0; i < locations.length; i++)
                {
                    marker = new google.maps.Marker({
                        icon: CAT_URL + locations[i].icon,
                        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                        title: locations[i].title,
                        map: map
                    });
                }
            }
            google.maps.event.addDomListener(window, 'load', init);
        });
    }

});