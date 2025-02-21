 <?php
    include($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');

    use Automattic\WooCommerce\Client;

    class Conection
    {
        public $woocommerce;

        function __construct($version)
        {
            $this->woocommerce = new Client(
                'https://homelighting.com.ni',
                'ck_259a0e2d85c29a6730a6275e2102bbd3379fc212',
                'cs_984f7a12383837b9e36c579b2519cbc73e44c471',
                [
                    'version' => $version == 'v3'  ? 'wc/v3' : 'cocart/v2',
                ]
            );
        }
        public function getWoocommerce()
        {
            return $this->woocommerce;
        }
    }

    ?>