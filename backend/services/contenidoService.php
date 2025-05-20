<?php

namespace App\Services;

use App\Models\ContenidoModel;

header("Content-Type: application/json");

class ContenidoService
{
    private $modelo;

    public function __construct()
    {
        $this->modelo = new ContenidoModel();
    }

    public function obtenerCatalogo()
    {
        return $this->modelo->obtenerCatalogo();
    }

    public function obtenerDetalles($datos)
    {
        if (!isset($datos['isbn']) || empty($datos['isbn'])) {
            return [
                'status' => 400,
                'message' => 'El ISBN es necesario para recuperar los detalles.',
                'detalles' => null
            ];
        }

        $isbn = $datos['isbn'];
        $detalles = $this->modelo->obtenerDetalles($isbn);

        if (is_null($detalles)) {
            return [
                'status' => 404,
                'message' => 'Detalles no encontrados para el ISBN proporcionado.',
                'detalles' => null
            ];
        }

        return [
            'status' => 200,
            'message' => 'Detalles recuperados con éxito.',
            'detalles' => $detalles
        ];
    }





    public function guardarTitulo($datosTitulo)
    {
        $isbn = $datosTitulo['isbn'];
        $titulo = $datosTitulo['titulo'];
        $categoria = $datosTitulo['categoria'];

        // Verificar duplicado
        if ($this->modelo->verificarTituloExistente($isbn, $categoria)) {
            return [
                'status' => 409,
                'message' => "El título con ISBN {$isbn} ya existe en la categoría '{$categoria}'"
            ];
        }

        // Guardar en catálogo
        $resCatalogo = $this->modelo->agregarTitulo($isbn, $categoria, $titulo);

        // Preparar detalles
        $detalles = [
            'Editorial' => $datosTitulo['editorial'],
            'Año publicacion' => $datosTitulo['anio'],
            'Genero' => $datosTitulo['genero'],
            'Precio' => $datosTitulo['precio'],
            'Titulo' => $titulo,
            'Imagen' => $datosTitulo['img'],
        ];

        if ($categoria === 'Revista') {
            $detalles['Revista'] = $datosTitulo['revista'];;
        } else {
            $detalles['Autor'] = $datosTitulo['autor'];;
        }

        // Guardar detalles
        $resDetalles = $this->modelo->agregarDetalles($isbn, $detalles);

        // Verificar errores de Firebase
        $catalogoError = strpos($resCatalogo, 'error') !== false;
        $detallesError = strpos($resDetalles, 'error') !== false;

        if ($catalogoError || $detallesError) {
            return [
                'status' => 500,
                'message' => "Error al guardar en Firebase.",
                'data' => [
                    'catalogo' => $resCatalogo,
                    'detalles' => $resDetalles
                ]
            ];
        }

        //notificar al webhook
        $responseWebhook = $this->notificarNuevoTituloWebhook($isbn, $titulo, $categoria);

        // Todo bien
        return [
            'status' => 201,
            'message' => "Título agregado correctamente.",
            'data' => [
                'isbn' => $isbn,
                'categoria' => $categoria,
                'catalogo' => $resCatalogo,
                'detalles' => $resDetalles,
                'webhook' => $responseWebhook //depuración 
            ]
        ];
 

    }

    public function editarTitulo($datosTitulo)
    {
        $isbn = $datosTitulo['isbn'];
        $titulo = $datosTitulo['titulo'];
        $categoria = $datosTitulo['categoria'];

        // Verificar existencia
        if (!$this->modelo->verificarTituloExistente($isbn, $categoria)) {
            return [
                'status' => 404,
                'message' => "El título con ISBN {$isbn} no existe en la categoría '{$categoria}' y no se puede editar."
            ];
        }

        // Actualizar en catálogo
        $resCatalogo = $this->modelo->agregarTitulo($isbn, $categoria, $titulo);

        // Preparar detalles
        $detalles = [
            'Editorial' => $datosTitulo['editorial'],
            'Año publicacion' => $datosTitulo['anio'],
            'Genero' => $datosTitulo['genero'],
            'Precio' => $datosTitulo['precio'],
            'Titulo' => $titulo,
            'Imagen' => $datosTitulo['img'],
        ];

        if ($categoria === 'Revista') {
            $detalles['Revista'] = $datosTitulo['revista'];
        } else {
            $detalles['Autor'] = $datosTitulo['autor'];
        }

        // Guardar detalles actualizados
        $resDetalles = $this->modelo->agregarDetalles($isbn, $detalles);

        // Verificar errores de Firebase
        $catalogoError = strpos($resCatalogo, 'error') !== false;
        $detallesError = strpos($resDetalles, 'error') !== false;

        if ($catalogoError || $detallesError) {
            return [
                'status' => 500,
                'message' => "Error al editar en Firebase.",
                'data' => [
                    'catalogo' => $resCatalogo,
                    'detalles' => $resDetalles
                ]
            ];
        }

        // Todo bien
        return [
            'status' => 200,
            'message' => "Título editado correctamente.",
            'data' => [
                'isbn' => $isbn,
                'categoria' => $categoria,
                'catalogo' => $resCatalogo,
                'detalles' => $resDetalles
            ]
        ];
    }



    public function eliminarTitulo($isbn, $categoria)
    {
        if (!$this->modelo->verificarTituloExistente($isbn, $categoria)) {
            return [
                'status' => 404,
                'message' => "El título con ISBN {$isbn} no existe en la categoría '{$categoria}'."
            ];
        }


        $resTitulo = $this->modelo->eliminarTitulo($isbn, $categoria);
        $resDetalles = $this->modelo->eliminarDetalles($isbn);


        if ($resTitulo === false || $resDetalles === false) {
            return [
                'status' => 500,
                'message' => "Error al eliminar los datos en Firebase."
            ];
        }

        return [
            'status' => 200,
            'message' => "Título eliminado correctamente."
        ];
    }

    private function notificarNuevoTituloWebhook($isbn, $titulo, $categoria)
    {
        $webhookData = [
            'isbn' => $isbn,
            'titulo' => $titulo,
            'categoria' => $categoria
        ];

        $ch = curl_init('http://localhost:5000/webhook/titulo');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($webhookData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        return $response; 
    }
}
