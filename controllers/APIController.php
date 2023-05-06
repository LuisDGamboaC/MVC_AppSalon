<?php

namespace Controllers;

use Model\Cita;
use Model\Servicio;
use Model\CitaServicio;

class APIController {

    public static function index() { ///api/servicios

        $servicios = Servicio::all();

        echo json_encode($servicios);

    }

    public static function guardar() { // /api/citas

        // Almacena la cita y devuelve el Id FECHA, HORA Y NOMBRE
        $cita = new Cita($_POST);
        $resultado = $cita->guardar();
        $id = $resultado['id'];

        // Almacena la cita y el Servicio
        // Almacena los servicios con el ID de la cita 
        $idServicios = explode(",", $_POST['servicios']); // explode separa cada string en comas string("1","2")converitr en un arreglo
        foreach($idServicios as $idServicio) {
            $args = [
                'citasId' => $id,
                'serviciosId' => $idServicio
            ];
            $citaServicio = new CitaServicio($args);
            $citaServicio->guardar();
        }

        echo json_encode(['resultado' => $resultado]);
    }

    public static function eliminar() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            debuguear($_SESSION);
            $cita = Cita::find($id);
            $cita->eliminar();
            header('Location:'. $_SERVER['HTTP_REFERER']);
        }
    }
}