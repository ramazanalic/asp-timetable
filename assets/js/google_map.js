$(function() {

    var langs = new Object;
    console.log(langs);
    switch (lang){
        
        case 'en':
            langs.m_departures = 'Departures';
            langs.m_arivals = 'Arivals';
            langs.m_services = 'Services';
            break;
        case 'me':
            langs.m_departures = 'Polasci';
            langs.m_arivals = 'Dolasci';
            langs.m_services = 'Usluge';
            break;
    }


    function initialize() {
        var map = new GMap2(document.getElementById("map_canvas"));
        x = 42.432983 ;
        y = 19.265900;
        map.setCenter(new GLatLng(x,y), 15);

        // Select a map type which supports aerial imagery
        map.setMapType(G_NORMAL_MAP);

        //map.setUIToDefault();
        // Create a base icon for all of our markers that specifies the
        // shadow, icon dimensions, etc.
        var baseIcon = new GIcon(G_DEFAULT_ICON);
        baseIcon.shadow = "http://www.google.com/mapfiles/shadow50.png";
        baseIcon.iconSize = new GSize(20, 34);
        baseIcon.shadowSize = new GSize(37, 34);
        baseIcon.iconAnchor = new GPoint(9, 34);
        baseIcon.infoWindowAnchor = new GPoint(9, 2);
        var marker;

        var inner_html = "<div class='map_info'><h3>AUTOBUSKA STANICA PODORICA</h3><br><div class='img'><img src='assets/img/parking/map-pic.jpg' /></div> <div class='m_content'><p>Trg Golootočkih žrtava 1<br />MNE 81000 Podgorica<br />busterminal@t-com.me<br />www.busterminal.me</p></div><div style='clear: both;'></div><div class='map_links'><a href='"+base_url+"departures'>"+langs.m_departures+"</a><a href='"+base_url+"arivals'>"+langs.m_arivals+"</a><a href='"+base_url+"services'>"+langs.m_services+"</a></div></div>";

        // Creates a marker whose info window displays the letter corresponding
        // to the given index.
        function createMarker(point, index) {
            // Create a lettered icon for this point using our icon class
            var letteredIcon = new GIcon(baseIcon);
            letteredIcon.image = "http://www.google.com/mapfiles/markerP.png";

            // Set up our GMarkerOptions object
            markerOptions = { icon:letteredIcon };
            marker = new GMarker(point, markerOptions);

            GEvent.addListener(marker, "click", function() {
                marker.openInfoWindowHtml(inner_html);

            });
            return marker;
        }

        var point = new GLatLng(x,y); 
        map.addOverlay(createMarker(point, 1));

        marker.openInfoWindowHtml(inner_html);

    } 


    initialize();

});