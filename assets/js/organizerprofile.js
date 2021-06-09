// js

import 'marker-clusterer/marker-clusterer.js';
import Handlebars from 'handlebars/dist/handlebars.min.js';

// snazzy-info-window must be loader after Google Maps is completely loader
function initMap() {
    if ($('#venues-map').length > 0) {
        $.getScript('https://cdn.jsdelivr.net/npm/snazzy-info-window@1.1.1/dist/snazzy-info-window.min.js', function () {
            drawMap($('#venues-map').data('venues'));
        });
    }
}
global.initMap = initMap;

// Initializes Google Maps

function drawMap(venues) {

    var map = new google.maps.Map(document.getElementById('venues-map'), {
        zoom: 7,
        center: {
            lat: parseFloat(venues[0].lat),
            lng: parseFloat(venues[0].lng)
        }
    });

    var markers = venues.map(function (venue, i) {
        var marker = new google.maps.Marker({
            position: {
                lat: parseFloat(venue.lat),
                lng: parseFloat(venue.lng)
            },
            icon: $('#venues-map').data('pin-path')
        });

        var template = Handlebars.compile($('#organizer-info-box').html());

        var info = null;
        var closeDelayed = false;
        var closeDelayHandler = function () {
            $(info.getWrapper()).removeClass('active');
            setTimeout(function () {
                closeDelayed = true;
                info.close();
            }, 300);
        };
        // Add a Snazzy Info Window to the marker
        info = new SnazzyInfoWindow({
            marker: marker,
            wrapperClass: 'custom-window',
            offset: {
                top: '-72px'
            },
            edgeOffset: {
                top: 50,
                right: 60,
                bottom: 50
            },
            border: false,
            closeButtonMarkup: '<button type="button" class="custom-close">&#215;</button>',
            content: template({
                title: venue.name,
                link: venue.link,
                bgImg: venue.image,
                body:
                        '<p class="text-muted"><small>' + venue.address + '</small></p>'
            }),
            callbacks: {
                open: function () {
                    $(this.getWrapper()).addClass('open');
                },
                afterOpen: function () {
                    var wrapper = $(this.getWrapper());
                    wrapper.addClass('active');
                    wrapper.find('.custom-close').on('click', closeDelayHandler);
                },
                beforeClose: function () {
                    if (!closeDelayed) {
                        closeDelayHandler();
                        return false;
                    }
                    return true;
                },
                afterClose: function () {
                    var wrapper = $(this.getWrapper());
                    wrapper.find('.custom-close').off();
                    wrapper.removeClass('open');
                    closeDelayed = false;
                }
            }
        });

        return marker;
    });
    new MarkerClusterer(map, markers,
            {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
}