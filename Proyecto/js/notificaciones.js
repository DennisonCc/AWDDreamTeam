document.addEventListener('DOMContentLoaded', function() {
    const contenedor = document.querySelector('.notificaciones-container');

    // Aquí deberías hacer un fetch/AJAX real al backend para obtener notificaciones
    // Por ahora, usamos listaEjemplo como simulación
    function renderNotificaciones(lista) {
        let html = '<h1>Notificaciones</h1>';
        if (lista.length === 0) {
            html += '<div class="sin-notificaciones">No tienes notificaciones nuevas.</div>';
        } else {
            lista.forEach(n => {
                html += `<div class="notificacion">
                    <span class="icono">${n.icono}</span>
                    <span class="mensaje">${n.mensaje}</span>
                    <span class="fecha">${n.fecha}</span>
                </div>`;
            });
        }
        contenedor.innerHTML = html;
    }

    // Fetch real notificaciones del backend
    fetch('../php/notificaciones.php')
        .then(res => res.json())
        .then(renderNotificaciones)
        .catch(() => renderNotificaciones([]));
});
