<?php

use App\Models\NotificacionModel;

// Verificamos si la función ya existe para evitar conflictos
if (!function_exists('obtener_notificaciones_usuario')) {
    
    function obtener_notificaciones_usuario()
    {
        // 1. Obtener la sesión global
        $session = session();

        // 2. Verificar si hay un usuario logueado
        // (Asegúrate de usar el nombre de variable de sesión correcto, ej: 'id_usuario')
        if (!$session->has('id_usuario')) {
            return []; // Si no hay usuario, devolvemos array vacío
        }

        $id_usuario = $session->get('id_usuario');

        // 3. Instanciar el modelo de notificaciones
        // Importante: Como estamos dentro de una función, instanciamos directamente
        $notificacionModel = new NotificacionModel();

        // 4. Obtener las notificaciones NO leídas
        // Usamos el método 'getNoLeidas' que definiste en tu modelo
        $notificaciones = $notificacionModel->obtenerNoLeidas($id_usuario);

        return $notificaciones;
    }
}
?>