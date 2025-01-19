<?php
class ApiClient
{
    private $baseUrl;
    private $username;
    private $password;
    private $cookieFile;
    private $authorization;

    public function __construct($baseUrl, $username, $password)
    {
        $this->baseUrl = $baseUrl;
        $this->username = $username;
        $this->password = $password;
        $this->cookieFile = __DIR__ . '/cookies.txt';
    }

    public function login()
    {
        $data = array(
            'username' => $this->username,
            'password' => $this->password,
        );

        $curl = curl_init($this->baseUrl . '/api/authenticate');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_COOKIEJAR, $this->cookieFile);
        curl_setopt($curl, CURLOPT_COOKIEFILE, $this->cookieFile);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_VERBOSE, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($curl);

        if ($result === false) {
            echo 'Error: ' . curl_error($curl);
            curl_close($curl);
            return false;
        } else {
            $response = json_decode($result, true);
            $this->authorization = 'Authorization: Bearer ' . $response['token'];
            curl_close($curl);
            return true;
        }
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
            echo "Resultado de la consulta de productos:\n";
            var_dump($result);
        }

        curl_close($curl);
    }
}

// Crear una instancia de ApiClient y realizar las operaciones
$apiClient = new ApiClient('http://apidev.grupocubas.com:9001', 'home.lighting', 'pJNh9n5Deo1');

if ($apiClient->login()) {
    $apiClient->listProducts();
}
