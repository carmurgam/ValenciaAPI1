<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mapa de Estaciones Valenbisi JDG</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  <style>
    body {
      margin: 0;
      font-family: 'Arial', sans-serif;
      background-color: #f4f4f9;
      text-align: center;
      color: #333;
    }

    h1 {
      color: #2c3e50;
      font-size: 28px;
      margin: 20px 0;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .site-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 18px 24px;
      background: linear-gradient(90deg, #4CAF50 0%, #2196F3 100%);
      border-radius: 0 0 18px 18px;
      box-shadow: 0 2px 10px rgba(33,150,243,0.08);
      margin-bottom: 30px;
      flex-wrap: wrap;
    }

    .brand {
      display: flex;
      align-items: center;
      font-size: 1.7em;
      font-weight: bold;
      color: #fff;
      gap: 12px;
      letter-spacing: 1px;
    }

    .nav {
      display: flex;
      align-items: center;
      gap: 10px;
      flex-wrap: wrap;
    }

    .map-button, .filter-button {
      background-color: #fff;
      color: #2196F3;
      border: none;
      padding: 10px 18px;
      border-radius: 8px;
      font-size: 16px;
      font-weight: bold;
      margin-right: 8px;
      transition: background 0.3s, color 0.3s;
      box-shadow: 0 2px 6px rgba(33,150,243,0.08);
    }

    .map-button:hover, .filter-button:hover {
      background-color: #2196F3;
      color: #fff;
      transform: scale(1.05);
    }

    .lang-btn {
      background: #fff;
      color: #4CAF50;
      border: none;
      border-radius: 50%;
      width: 38px;
      height: 38px;
      font-size: 1em;
      font-weight: bold;
      margin-left: 4px;
      cursor: pointer;
      transition: background 0.2s, color 0.2s, transform 0.2s;
      box-shadow: 0 1px 4px rgba(76,175,80,0.08);
    }

    .lang-btn:hover {
      background: #4CAF50;
      color: #fff;
      transform: scale(1.08);
    }

    #map {
      height: 700px;
      width: 100%;
      margin-top: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      transition: width 0.3s ease;
    }

    #display-main-container {
      display: flex;
      flex-wrap: nowrap;
      justify-content: space-between;
      align-items: flex-start;
      margin: 0 5%;
      gap: 20px;
    }

    #filters {
      height: 700px; 
      max-width: 600px;
      width: 40%;
      padding: 20px;
      background-color: #ffffff;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      overflow-y: auto; /* Add vertical scroll when content overflows */
      transition: opacity 0.3s ease;
    }

    #filters h3 {
      font-size: 20px;
      color: #2c3e50;
      margin-bottom: 15px;
      text-align: left;
    }

    #filters h4 {
      font-size: 16px;
      color: #34495e;
      margin-bottom: 10px;
      text-align: left;
    }

    .filter-item {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 15px;
      padding: 10px;
      background-color: #ecf0f1;
      border-radius: 8px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .filter-item button {
      background-color: #27ae60;
      color: white;
      padding: 8px 12px;
      border: none;
      border-radius: 5px;
      font-size: 14px;
      cursor: pointer;
      transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .filter-item button:hover {
      background-color: #1e8449;
      transform: scale(1.05);
    }

    .filter-item span {
      font-size: 14px;
      color: #2c3e50;
      margin-left: 10px;
      flex-grow: 1;
      text-align: left;
    }

    .hidden {
      display: none;
    }

    /* Hide spans and adjust layout for smaller screens */
    @media (max-width: 768px) {
      #filters {
        height: 100%; /* Allow full height for scrolling */
      }

      .filter-item {
        justify-content: center; /* Center the buttons */
      }

      .filter-item span {
        display: none; /* Hide the span text */
      }
    }

    @media (max-width: 700px) {
      .site-header {
        flex-direction: column;
        align-items: flex-start;
        padding: 12px 8px;
        gap: 10px;
      }
      .brand {
        font-size: 1.2em;
        margin-bottom: 8px;
      }
      .nav {
        gap: 6px;
      }
      .map-button, .filter-button, .lang-btn {
        font-size: 0.95em;
        padding: 8px 12px;
        width: auto;
        height: auto;
      }
    }
  </style>
</head>
<body>
  <header class="site-header">
    <div class="brand">
      <span data-key="title">ValenBisi Map</span>
    </div>
    <nav class="nav">
      <a href="index.php" class="map-button" data-key="a-list">Ver listado</a>
      <button onclick="toggleFilters()" class="filter-button" data-key="bt-flt">Filtros</button>
      <button class="lang-btn" id="btn-es">ES</button>
      <button class="lang-btn" id="btn-en">EN</button>
    </nav>
  </header>
<div id="display-main-container">
    <div id="map"></div>

    <div id="filters" class="hidden">
        <h3 data-key="bt-flt">Filtros</h3>
        <!-- Filtro para bicicletas disponibles -->
        <div id="filter-available">
        <h4 data-key='Title-fl-Available'>Filtrar por Bicis Disponibles</h4>
       <div class="filter-item">
          <button data-type="available" data-value="5" data-key='bt-A5'>Menos de 5</button>
          <span data-key='sp-A5'>Más de 5 bicis disponibles</span>
        </div>
        <div class="filter-item">
          <button data-type="available" data-value="10" data-key='bt-A10'>Menos de 10</button>
          <span data-key='sp-A10'>Más de 10 bicis disponibles</span>
        </div>
        <div class="filter-item">
          <button data-type="available" data-value="20" data-key='bt-A20'>Menos de 20</button>
          <span data-key='sp-A20'>Menos de 20 bicis disponibles</span>
        </div>
        <div class="filter-item">
          <button data-type="available" data-value="11" data-key='bt-A10mas'>Más de 10</button>
          <span data-key='sp-A10mas'>Más de 10 bicis disponibles</span>
        </div>
        </div>

        <!-- Filtro para huecos libres -->
        <div id="filter-free">
        <h4 data-key='title-fl-free'>Filtrar por Huecos Libres</h4>
        <div class="filter-item">
          <button data-type="free" data-value="5" data-key='bt-5'>Menos de 5</button>
          <span data-key='sp-5'>Más de 5 huecos disponibles</span>
        </div>
        <div class="filter-item">
          <button data-type="free" data-value="10" data-key='bt-10'>Menos de 10</button>
          <span data-key='sp-10'>Más de 10 huecos disponibles</span>
        </div>
        <div class="filter-item">
          <button data-type="free" data-value="20" data-key='bt-20'>Menos de 20</button>
          <span data-key='sp-20'>Menos de 20 huecos disponibles</span>
        </div>
        <div class="filter-item">
          <button data-type="free" data-value="11" data-key='bt-10mas'>Más de 10</button>
          <span data-key='sp-10mas'>Más de 10 huecos disponibles</span>
        </div>
        </div>
</div>

  <script>
    // Inicializa el mapa centrado en Valencia
    var map = L.map('map').setView([39.47, -0.37], 13);

    // Añadir capa base de OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Función para definir el color del marcador según las bicicletas disponibles
    function getMarkerColor(available) {
      if (available == 0) return 'black';
      else if (available < 5) return 'red';
      else if (available < 10) return 'orange';
      else if (available < 20) return 'yellow';
      else return 'green';
    }

    let allData = []; // Aquí se almacenarán todas las estaciones cargadas
    let activeFilter = { type: null, value: null }; // Estado actual del filtro (tipo: 'available' o 'free')

    // Función para aplicar filtros y renderizar los marcadores
    function renderFilteredMarkers() {
      // Elimina los marcadores anteriores
      map.eachLayer(layer => {
        if (layer instanceof L.CircleMarker) {
          map.removeLayer(layer);
        }
      });

      // Itera sobre todas las estaciones y las muestra en el mapa si cumplen con el filtro
      allData.forEach(station => {
        const { lat, lon, address, available, free, total } = station;
        if (!lat || !lon) return; // Evita errores si no hay coordenadas

        // Aplicar el filtro si está activo
        if (activeFilter.type && activeFilter.value !== null) {
          const value = activeFilter.type === 'available' ? available : free;

          // Si seleccionó "Alta" (>10), y el valor es 10 o menos → descartar
          if (activeFilter.value == 11 && value <= 10) return;

          // Si seleccionó "≤ x", y el valor supera ese x → descartar
          if (activeFilter.value != 11 && value > activeFilter.value) return;
        }

        // Crear marcador circular con color según disponibilidad
        L.circleMarker([lat, lon], {
          color: getMarkerColor(available),
          radius: 8,
          fillOpacity: 0.8
        })
        .addTo(map)
        .bindPopup(`
          <strong>${address}</strong><br>
          <b>Disponibles:</b> ${available}<br>
          <b>Libres:</b> ${free}<br>
          <b>Total:</b> ${total}
        `);
      });
    }

    // Cargar el archivo data.json
    fetch('data.json')
      .then(response => {
        if (!response.ok) throw new Error(`Error al cargar data.json: ${response.statusText}`);
        return response.json();
      })
      .then(data => {
        allData = Object.values(data); // Guardamos los datos para reutilizar
        renderFilteredMarkers(); // Renderizamos todos los marcadores inicialmente
      })
      .catch(error => {
        console.error('Error cargando los datos:', error);
      });

    // Asignar eventos a los botones de filtro
    document.querySelectorAll('#filter-available button, #filter-free button').forEach(button => {
      button.addEventListener('click', () => {
        const type = button.getAttribute('data-type'); // 'available' o 'free'
        const value = parseInt(button.getAttribute('data-value')); // valor del filtro
        activeFilter = { type, value };
        renderFilteredMarkers(); // Vuelve a renderizar el mapa con el nuevo filtro
      });
    });

    // Toggle para ocultar o mostrar el aside con los filtros
    function toggleFilters() {
      const filters = document.getElementById('filters');
      const map = document.getElementById('map');
      filters.classList.toggle('hidden'); // Toggle visibility of filters

      // Adjust map width based on filters visibility
      if (filters.classList.contains('hidden')) {
        map.style.width = '100%';
      } else {
        map.style.width = '70%'; // Occupy 70% when filters are visible
      }
    }

    // Ensure the map starts with the correct width
    document.addEventListener('DOMContentLoaded', () => {
      const filters = document.getElementById('filters');
      const map = document.getElementById('map');
      if (filters.classList.contains('hidden')) {
        map.style.width = '100%';
      } else {
        map.style.width = '70%';
      }
    });
    // Cargar el archivo de idioma correctamente cuando el DOM esté listo
    document.addEventListener('DOMContentLoaded', function() {
      const langScript = document.createElement('script');
      langScript.src = 'js/language.js';
      langScript.onload = function() {
        if (typeof loadLanguage === 'function') {
          loadLanguage();
        }
      };
      document.body.appendChild(langScript);
    });
  </script>
</body>
</html>
