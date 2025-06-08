// Este script se encarga de gestionar la carga de traducciones desde un archivo JSON
// y de aplicar las traducciones a los elementos de la página según el idioma seleccionado por el usuario.
// Se utiliza localStorage para recordar el idioma seleccionado por el usuario
// y cargarlo automáticamente en futuras visitas.
// Se utiliza el atributo data-key en los elementos HTML para identificar qué texto traducir.
// Se cargan las traducciones desde un archivo JSON y se aplican a los elementos de la página
// según el idioma seleccionado por el usuario.

let translations = {}; // Almacenará los datos de translation.json
const defaultLang = 'es'; // Idioma por defecto si no hay nada guardado
let currentLang = 'es';

// Función para cargar el fichero de las traducciones
function loadTranslations(lang) {
    // Añade un parámetro único para evitar caché
    const url = 'translation.json?v=' + new Date().getTime();
    fetch(url)
        .then(response => response.json())
        .then(data => {
            translations = data;
            applyTranslations(lang);
        })
        .catch(error => {
            console.error('Error al cargar las traducciones:', error);
        });
}

// al pulsar en un boton de idioma guarda el idioma en localStorage
function setLanguage(lang) {
    localStorage.setItem('language', lang);
    currentLang = lang;
    loadTranslations(lang);
}

// Función para aplicar las traducciones a la página
function applyTranslations(lang) {
  console.log("Aplicando traducciones para el idioma: " + lang);
    document.querySelectorAll('[data-key]').forEach(element => {
        const key = element.dataset.key;
        if (translations[lang] && translations[lang][key]) {
            // Cambia solo el texto directo del nodo, no el HTML interno
            for (let node of element.childNodes) {
                if (node.nodeType === Node.TEXT_NODE) {
                    node.nodeValue = translations[lang][key];
                    return;
                }
            }
            // Si no hay nodo de texto, lo asigna como textContent (caso simple)
            element.textContent = translations[lang][key];
        }
    });
    document.documentElement.lang = lang;
}

// Función para cargar el idioma almacenado o el por defecto 
function loadLanguage() {
    const savedLang = localStorage.getItem('language');
    currentLang = savedLang || defaultLang;
    loadTranslations(currentLang);
}

// init
// botones de idioma
let btnEs=document.getElementById('btn-es');
let btnEn=document.getElementById('btn-en');
// Cambiar el idioma al hacer clic en los botones
btnEs.addEventListener('click', () => {
    setLanguage('es');
});
btnEn.addEventListener('click', () => {
  setLanguage('en');
});



// Al cargar la página
window.onload = loadLanguage;
