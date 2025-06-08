<!DOCTYPE html>
<html lang="es">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Disponibilidad de ValenBisi</title>
 <style>
  body {
    font-family: Arial, sans-serif;
    margin: 20px;
    background-color: #f9f9f9;
  }

  h1 {
    text-align: center;
    color: #333;
    margin-bottom: 30px;
  }

  .site-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 18px 24px;
    background: linear-gradient(90deg, #4CAF50 0%, #2196F3 100%);
    border-radius: 0 0 18px 18px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
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

  .map-button {
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

  .map-button:hover {
    background-color: #2196F3;
    color: #fff;
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

  .header-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    margin-bottom: 20px;
  }

  .station-container {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    padding: 15px 20px;
    margin: 15px auto;
    max-width: 700px;
    transition: all 0.3s ease;
    font-size: 16px;
  }

  .station-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    border-bottom: 1px solid #ddd;
    padding-bottom: 8px;
    margin-bottom: 10px;
  }

  .station-header div {
    margin: 4px 0;
  }

  .station-number {
    font-weight: bold;
    color: #555;
  }

  .station-name {
    flex-grow: 1;
    font-size: 1.2em;
    margin: 0 10px;
  }

  .station-open {
    font-weight: bold;
    color: green;
  }

  .station-open.closed {
    color: red;
  }

  .station-status {
    display: flex;
    justify-content: space-around;
    margin-bottom: 10px;
    flex-wrap: wrap;
    gap: 5px;
  }

  .station-status span {
    padding: 6px 12px;
    border-radius: 6px;
    color: white;
    font-weight: bold;
  }
  .black {
      BACKGROUND-COLOR: #000;
      font-weight: bold;
    }

  .red {
    BACKGROUND-COLOR: #f44336;
    font-weight: bold;
  }

  .orange {
    font-weight: bold;
    BACKGROUND-COLOR: #ff9800;
  }

  .yellow {
    BACKGROUND-COLOR:rgb(245, 230, 25);
    font-weight: bold;
  }

  .green {
    BACKGROUND-COLOR: #4caf50;
    font-weight: bold;
  }


  .updated-time {
    text-align: center;
    font-size: 0.9em;
    color: #555;
  }

  .toggle-coords {
    cursor: pointer;
    color: #007BFF;
    background: none;
    border: none;
    padding: 5px;
    font-size: 0.9em;
    margin-top: 5px;
  }

  .coords {
    display: none;
    font-size: 0.9em;
    margin-top: 5px;
    color: #333;
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

    .map-button, .lang-btn {
      font-size: 0.95em;
      padding: 8px 12px;
      width: auto;
      height: auto;
    }

    .station-header {
      flex-direction: column;
      align-items: flex-start;
    }

    .station-status {
      flex-direction: column;
      align-items: flex-start;
    }

    .station-status span {
      width: 100%;
    }
  }
 </style>
</head>
<body>
  <header class="site-header">
    <div class="brand">
      <span data-key="Tlt-Dis">Disponibilidad de ValenBisi</span>
    </div>
    <nav class="nav">
      <a href="mapearbicis.php" class="map-button" data-key="button-ShowMap">Ver en el mapa</a>
      <button class="lang-btn" id="btn-es">ES</button>
      <button class="lang-btn" id="btn-en">EN</button>
    </nav>
  </header>

<?php
$baseUrl = "https://valencia.opendatasoft.com/api/explore/v2.1/catalog/datasets/valenbisi-disponibilitat-valenbisi-dsiponibilidad/records?";
$limit = 20;
$offset = 0;
$allStations = [];
$errorOccurred = false;

do {
    $url = $baseUrl . "limit=" . $limit . "&offset=" . $offset;
    $ch = curl_init();// inicializar la sesión cURL
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Accept: application/json"]);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // solo para desarrollo

    $response = curl_exec($ch);// ejecutar la solicitud cURL

    if ($response === false) {
        echo "<p style='color: red; text-align: center;'data-key='Error-cURL'>Error en cURL: " . curl_error($ch) . "</p>";
        $errorOccurred = true;
        break;
    }

    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($httpCode != 200) {
        echo "<p style='color: red; text-align: center;'data-key='error-API'>Error en la solicitud a la API (Código HTTP: " . $httpCode . ").</p>";
        $errorOccurred = true;
        break;
    }

    curl_close($ch);// cerrar la sesión cURL

    $data = json_decode($response, true);
    if ($data === null) {
        echo "<p style='color: red; text-align: center;'>Error al decodificar la respuesta JSON.</p>";
        $errorOccurred = true;
        break;
    }

    if (isset($data["results"]) && is_array($data["results"]) && count($data["results"]) > 0) {
        foreach ($data["results"] as $station) {
            $allStations[$station['number']] = [
                'address' => $station['address'],
                'open' => ($station['open'] == "T"),
                'available' => (int)$station['available'],
                'free' => (int)$station['free'],
                'total' => (int)$station['total'],
                'updated_at' => $station['updated_at'],
                'lat' => $station['geo_point_2d']['lat'],
                'lon' => $station['geo_point_2d']['lon']
            ];
        }
        $offset += $limit;
    } else {
        break;
    }
} while (isset($data["results"]) && is_array($data["results"]) && count($data["results"]) == $limit);

if (!$errorOccurred && !empty($allStations)) {
    $filePath = getcwd() . '/data.json';
    file_put_contents($filePath, json_encode($allStations));
}

if (!empty($allStations)) {
    echo "<script>
        function toggleCoords(id) {
            const el = document.getElementById('coords-' + id);
            el.style.display = el.style.display === 'none' ? 'block' : 'none';
        }
    </script>";
    
//Filtro color Disponibles y Libres
foreach ($allStations as $number => $station) {
    // Colores por número absoluto de disponibles
    if ($station['available'] == 0) {
      $availableColor = "black";
    } elseif ($station['available'] <= 5) {
      $availableColor = "red";
    } elseif ($station['available'] <= 10) {
      $availableColor = "orange";
    } elseif ($station['available'] <= 20) {
      $availableColor = "yellow";
    } else {
      $availableColor = "green";
    }

    // Colores por número absoluto de libres
    if ($station['free'] == 0) {
      $freeColor = "black";
    } elseif ($station['free'] <= 5) {
      $freeColor = "red";
    } elseif ($station['free'] <= 10) {
      $freeColor = "orange";
    } elseif ($station['free'] <= 20) {
      $freeColor = "yellow";
    } else {
      $freeColor = "green";
    }

    echo "<div class='station-container'>";
    echo "<div class='station-header'>";
    echo "<div class='station-number'>#$number</div>";
    echo "<div class='station-name'>" . htmlspecialchars($station['address']) . "</div>";
    echo "<div class='station-open " . ($station['open'] ? "" : "closed") . "'>"
        . "<span data-key='th_open'>" . ($station['open'] ? "Abierto" : "Cerrado") . "</span>"
        . "</div>";
    echo "</div>";//cierre header

    echo "<div class='station-status'>";
    echo "<span class='status-available $availableColor'><span data-key='th-available'>Bicis disponibles</span>: <span class='available-value'>" . $station['available'] . "</span></span>";
    echo "<span class='status-available $freeColor'><span data-key='th-free'>Huecos libres</span>: <span class='free-value'>" . $station['free'] . "</span></span>";
    echo "<span style='background:#9E9E9E;'><span data-key='th_total'>Total</span>: <span class='total-value'>" . $station['total'] . "</span></span>";
    echo "</div>";//cierre status

    echo "<div class='updated-time'>🕒 " . $station['updated_at'] . "</div>";

    echo "<button class='toggle-coords' onclick='toggleCoords($number)' data-key='button-LatLong'>📍 Ver coordenadas</button>";
    echo "<div id='coords-$number' class='coords'>Lat: " . $station['lat'] . ", Lon: " . $station['lon'] . "</div>";

    echo "</div>";// cierre station-container
  }
    }
?>
<script>
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