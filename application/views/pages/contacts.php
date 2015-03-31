<div class="contacts">
    <div class="wrapper">
        <h3 class="main_title">Контакты</h3>

        <?= Modules::run('contacts/view', true, 'contacts') ?>

        <div class="contacts_col_3 contacts_col">
            <p>Написать нам</p>
            <?= Modules::run('feedback/view', true) ?>
        </div>

        <div class="clear"></div>

        <div class="google_maps">
            <p>Посмотреть на карте</p>
            <style type="text/css">
                #map-contacts{
                    width: 953px;
                    height: 633px;
                }
            </style>
            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB83YhiUJ6TXml08s-fBd1oMof0nNboIhg"></script>
            <script type="text/javascript">
                function initialize() {
                    var myLatlng = new google.maps.LatLng(<?= $contacts['coords'] ?>);
                    var mapOptions = {
                        zoom: 13,
                        center: myLatlng
                    }
                    var map = new google.maps.Map(document.getElementById('map-contacts'), mapOptions);

                    var marker = new google.maps.Marker({
                        position: myLatlng,
                        map: map,
                        title: 'TravelShop'
                    });
                }
                google.maps.event.addDomListener(window, 'load', initialize);
            </script>
            <div class="map">
                <div id="map-contacts"></div>
            </div>
        </div>

    </div><!-- /wrapper -->
</div><!-- /contacts -->