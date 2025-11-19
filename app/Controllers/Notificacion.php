<?php 
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\NotificacionModel;

class Notificacion extends BaseController
{
    public function leer($id_notificacion)
    {
        $model = new NotificacionModel();
        
        // 1. Buscar la notificación
        $notificacion = $model->find($id_notificacion);

        if ($notificacion) {
            // 2. Marcar como leída (leido = 1)
            $model->update($id_notificacion, ['leido' => 1]);

            // 3. Redirigir al enlace real del ticket
            return redirect()->to($notificacion['enlace']);
        }

        // Si falla algo, regresar al inicio
        return redirect()->back();
    }
}
?>