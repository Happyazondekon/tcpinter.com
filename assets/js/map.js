/* ============================================================
   TCP Inter – Leaflet Map (Île-de-France)
   ============================================================ */

(function () {
  'use strict';

  if (!document.getElementById('tcp-map')) return;

  // Cities with coordinates
  const cities = [
    { name: 'Paris (75)',       lat: 48.8566, lng: 2.3522  },
    { name: 'Bobigny (93)',     lat: 48.9108, lng: 2.4400  },
    { name: 'Nanterre (92)',    lat: 48.8924, lng: 2.2070  },
    { name: 'Versailles (78)', lat: 48.8014, lng: 2.1301  },
    { name: 'Créteil (94)',     lat: 48.7755, lng: 2.4560  },
    { name: 'Évry (91)',        lat: 48.6316, lng: 2.4478  },
    { name: 'Cergy (95)',       lat: 49.0354, lng: 2.0741  },
    { name: 'Aulnay-sous-Bois', lat: 48.9394, lng: 2.4978 },
    { name: 'Saint-Denis (93)', lat: 48.9362, lng: 2.3574  },
    { name: 'Montreuil (93)',   lat: 48.8638, lng: 2.4484  },
    { name: 'Vincennes (94)',   lat: 48.8472, lng: 2.4393  },
    { name: 'Massy (91)',       lat: 48.7254, lng: 2.2721  },
  ];

  // IDF bounding box
  const bounds = L.latLngBounds([48.10, 1.40], [49.24, 3.56]);

  const map = L.map('tcp-map', {
    center: [48.8566, 2.3522],
    zoom: 10,
    minZoom: 8,
    maxZoom: 14,
    maxBounds: bounds,
    maxBoundsViscosity: 0.8,
    zoomControl: true,
    scrollWheelZoom: false,
    attributionControl: true,
  });

  // Tiles
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
    maxZoom: 19,
  }).addTo(map);

  // Custom icon
  const tcpIcon = L.divIcon({
    html: `<div style="
      width:32px; height:32px;
      background: #1360a7;
      border-radius: 50% 50% 50% 0;
      transform: rotate(-45deg);
      border: 3px solid #fff;
      box-shadow: 0 2px 8px rgba(0,54,95,0.4);
    "></div>`,
    className: '',
    iconSize: [32, 32],
    iconAnchor: [16, 32],
    popupAnchor: [0, -36],
  });

  // Add markers
  cities.forEach(city => {
    L.marker([city.lat, city.lng], { icon: tcpIcon })
      .addTo(map)
      .bindPopup(`
        <strong style="font-family: Manrope, sans-serif; color: #00365f;">${city.name}</strong><br>
        <span style="font-size:0.8rem; color:#42474f;">Zone d'intervention TCP Inter</span>
      `, { maxWidth: 180 });
  });

  // Disable scroll zoom on mobile
  if (window.innerWidth <= 768) {
    map.scrollWheelZoom.disable();
  }

  // Re-invalidate map size if in a tab/hidden container
  setTimeout(() => map.invalidateSize(), 200);

})();
