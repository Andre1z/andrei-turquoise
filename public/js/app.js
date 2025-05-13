/**
 * app.js
 *
 * Archivo principal de JavaScript de la aplicación.
 * Proporciona funcionalidades para:
 * - Manejar el estado activo de los enlaces de navegación.
 * - Alternar la visibilidad de campos de contraseña.
 * - Validar formularios (opcional y de ejemplo).
 */

document.addEventListener("DOMContentLoaded", function() {
    console.log("App.js cargado.");

    // --- Activación de Enlaces de Navegación ---
    // Se agregan listeners a los enlaces dentro de <nav> para actualizar su estado "active".
    const navLinks = document.querySelectorAll("nav ul li a");
    if (navLinks.length) {
        navLinks.forEach(link => {
            link.addEventListener("click", function() {
                // Se quita la clase "active" de todos los enlaces.
                navLinks.forEach(item => item.classList.remove("active"));
                // Se asigna "active" al enlace clicado.
                this.classList.add("active");
            });
        });
    }

    // --- Funcionalidad para Alternar Visibilidad de Contraseña ---
    // Se asume que, junto a algún input type "password", hay un botón o enlace con la clase "toggle-password"
    // Por ejemplo, puede estar inmediatamente después del campo a modificar.
    const toggleButtons = document.querySelectorAll(".toggle-password");
    toggleButtons.forEach(button => {
        button.addEventListener("click", function() {
            // Se asume que el input es el hermano anterior del botón
            const passwordField = this.previousElementSibling;
            if (passwordField && passwordField.type === "password") {
                passwordField.type = "text";
                this.textContent = "Ocultar";
            } else if (passwordField) {
                passwordField.type = "password";
                this.textContent = "Mostrar";
            }
        });
    });

    // --- Función Global de Validación de Formularios ---
    // Esta función recorre los campos "required" dentro de un formulario y resalta en rojo aquellos vacíos.
    window.validateForm = function(formId) {
        const form = document.getElementById(formId);
        if (!form) return true; // Si no existe el formulario, se considera que es válido.

        let isValid = true;
        const requiredFields = form.querySelectorAll("[required]");

        requiredFields.forEach(field => {
            if (field.value.trim() === "") {
                field.style.borderColor = "red";
                isValid = false;
            } else {
                field.style.borderColor = "";
            }
        });

        return isValid;
    };

    // Puedes agregar más funcionalidades globales aquí.
});