/**
 * app.js
 *
 * Archivo principal de JavaScript para la aplicación de Gestión de Restaurantes.
 * Se encarga de agregar interactividad en el frontend:
 *  - Manejo de enlaces de navegación para marcar el enlace activo.
 *  - Funcionalidad para mostrar/ocultar contraseñas en formularios.
 *  - Función simple de validación de formularios para resaltar campos requeridos vacíos.
 */

document.addEventListener("DOMContentLoaded", function() {
    console.log("App.js cargado. ¡Bienvenido a Gestión de Restaurantes!");

    // --- Activación de Enlaces de Navegación ---
    // Se encarga de marcar visualmente el enlace activo en el menú de navegación.
    var navLinks = document.querySelectorAll("nav a");
    if (navLinks.length) {
        navLinks.forEach(function(link) {
            link.addEventListener("click", function() {
                // Remueve la clase "active" de todos los enlaces
                navLinks.forEach(function(item) {
                    item.classList.remove("active");
                });
                // Agrega la clase "active" al enlace clicado
                this.classList.add("active");
            });
        });
    }

    // --- Mostrar/Ocultar Contraseña ---
    // Se asume que existe un botón con la clase "toggle-password" junto a un campo de contraseña.
    var togglePasswordButtons = document.querySelectorAll(".toggle-password");
    togglePasswordButtons.forEach(function(button) {
        button.addEventListener("click", function() {
            // Se asume que el botón está inmediatamente después del campo de contraseña
            var passwordField = this.previousElementSibling;
            if (passwordField && passwordField.type === "password") {
                passwordField.type = "text";
                this.textContent = "Ocultar";
            } else if (passwordField) {
                passwordField.type = "password";
                this.textContent = "Mostrar";
            }
        });
    });

    // Puedes agregar más funcionalidades que se ejecuten cuando el DOM esté listo.
});

/**
 * validateForm
 *
 * Función simple para validar formularios, marcando de rojo aquellos campos obligatorios vacíos.
 *
 * @param {string} formId - El ID del formulario que se va a validar.
 * @returns {boolean} Retorna true si el formulario es válido; false en caso contrario.
 *
 * Se puede usar en un formulario de la siguiente manera:
 * <form id="miFormulario" onsubmit="return validateForm('miFormulario');">
 */
function validateForm(formId) {
    var form = document.getElementById(formId);
    if (!form) return true; // Si no se encuentra el formulario, se considera válido
    var isValid = true;
    // Selecciona todos los elementos con atributo "required"
    var requiredFields = form.querySelectorAll("[required]");
    requiredFields.forEach(function(field) {
        if (field.value.trim() === "") {
            isValid = false;
            // Resalta el campo vacío
            field.style.borderColor = "red";
        } else {
            // Reinicia el estilo del campo si se completa
            field.style.borderColor = "";
        }
    });
    return isValid;
}