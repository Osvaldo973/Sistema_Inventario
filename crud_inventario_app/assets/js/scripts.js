// scripts.js

// Espera a que el DOM esté completamente cargado
document.addEventListener('DOMContentLoaded', function() {
    console.log("El archivo scripts.js se ha cargado correctamente.");

    // Función para confirmar la eliminación de un usuario
    // (Aunque ya usamos confirm en el HTML inline, este bloque sirve para reforzar la funcionalidad)
    const deleteLinks = document.querySelectorAll("a[href*='delete.php']");
    deleteLinks.forEach(function(link) {
        link.addEventListener("click", function(event) {
            // Muestra un mensaje de confirmación al dar clic en eliminar
            if (!confirm("¿Estás seguro de eliminar este usuario?")) {
                event.preventDefault(); // Si el usuario decide cancelar, evitamos la acción por defecto
            }
        });
    });

    // Funcionalidad para validar formularios de forma simple en el lado del cliente
    // Esto es opcional, ya que las validaciones principales se realizan en el servidor
    const forms = document.querySelectorAll(".formulario");
    forms.forEach(function(form) {
        form.addEventListener("submit", function(event) {
            // Variables para los campos del formulario
            var nombreField = form.querySelector("input[name='nombre']");
            var emailField = form.querySelector("input[name='email']");
            var telefonoField = form.querySelector("input[name='telefono']");

            let valid = true;  // Bandera que indica si el formulario es válido

            // Validación del campo "nombre"
            if (nombreField && nombreField.value.trim() === "") {
                alert("El nombre es obligatorio.");
                valid = false;
            }

            // Validación del campo "email"
            if (emailField && emailField.value.trim() === "") {
                alert("El correo electrónico es obligatorio.");
                valid = false;
            } else if (emailField && !validateEmail(emailField.value.trim())) {
                alert("El correo electrónico no es válido.");
                valid = false;
            }

            // Validación del campo "telefono"
            if (telefonoField && telefonoField.value.trim() === "") {
                alert("El teléfono es obligatorio.");
                valid = false;
            }

            // Si alguna validación falla, prevenimos el envío del formulario
            if (!valid) {
                event.preventDefault();
            }
        });
    });
});

/**
 * Función para validar el formato de un correo electrónico.
 * Se utiliza una expresión regular para comprobar que el email tiene una estructura válida.
 *
 * @param {string} email - El correo electrónico a validar
 * @return {boolean} - Devuelve true si el formato es válido, false en caso contrario.
 */
function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}