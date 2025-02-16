<?php
require_once("conection_gc.php");
class ProductsGC extends ApiClient
{
    public function __construct()
    {
        parent::__construct();
    }
    public function listProducts()
    {
        $curl = curl_init($this->baseUrl . '/api/product/hl');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', $this->authorization));
        curl_setopt($curl, CURLOPT_COOKIEFILE, $this->cookieFile);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_VERBOSE, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($curl);

        if ($result === false) {
            echo 'Error: ' . curl_error($curl);
        } else {

            return $result;
        }

        curl_close($curl);
    }
    public function getProduct($id)
    {
        $curl = curl_init($this->baseUrl . '/api/product/' . $id);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', $this->authorization));
        curl_setopt($curl, CURLOPT_COOKIEFILE, $this->cookieFile);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_VERBOSE, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($curl);

        if ($result === false) {
            echo 'Error: ' . curl_error($curl);
        } else {

            return $result;
        }

        curl_close($curl);
    }

    private function createProduct($data)
    {
        $curl = curl_init($this->baseUrl . '/api/product');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', $this->authorization));
        curl_setopt($curl, CURLOPT_COOKIEFILE, $this->cookieFile);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_VERBOSE, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));

        $result = curl_exec($curl);

        if ($result === false) {
            echo 'Error: ' . curl_error($curl);
        } else {

            return $result;
        }

        curl_close($curl);
    }
    public function createRequest()
    {
        $data = array(
            'id' => 0,
            'noRequisa' => '070279',
            'idEmpleadoRegistro' => 896,
            'idEmpleadoResponsable' => 763,
            'idProyectoCliente' => 2375,
            'observacion' => 'Registro de prueba (MOD)...',
            'idAlmacen' => 5,
            'lstDetalle' => array(
                array(
                    'id' => 0,
                    'cantSolicitada' => 2,
                    'idInventarioEstandar' => 10030,
                    'precioUnitario' => 9.05,
                    'deducible' => true
                )
            )
        );

        $curl = curl_init($this->baseUrl . '/api/material/requirement/');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', $this->authorization));
        curl_setopt($curl, CURLOPT_COOKIEFILE, $this->cookieFile);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_VERBOSE, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));

        $result = curl_exec($curl);

        if ($result === false) {
            echo 'Error: ' . curl_error($curl);
        } else {

            return $result;
        }

        curl_close($curl);
    }
}

/*Crear una instancia de ApiClient y realizar las operaciones
$apiClient = new ProductsGC();

if ($apiClient->login()) {
    //$apiClient->listProducts();
    var_dump($apiClient->listProducts());
}
*/