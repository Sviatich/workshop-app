(async () => {
    await ymaps3.ready;
    const { YMap, YMapDefaultSchemeLayer, YMapDefaultFeaturesLayer, YMapMarker } = ymaps3;

    const coords = [38.374602, 55.989067];

    const map = new YMap(document.getElementById('map'), {
        location: { center: coords, zoom: 15 }
    });

    map.addChild(new YMapDefaultSchemeLayer());
    map.addChild(new YMapDefaultFeaturesLayer());

    const markerEl = document.createElement('div');
    markerEl.className = 'custom-marker';
    markerEl.title = 'Мастерская Упаковки';

    map.addChild(new YMapMarker({ coordinates: coords }, markerEl));
})();