<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if (!function_exists('chld_thm_cfg_locale_css')):
    function chld_thm_cfg_locale_css($uri)
    {
        if (empty($uri) && is_rtl() && file_exists(get_template_directory() . '/rtl.css'))
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter('locale_stylesheet_uri', 'chld_thm_cfg_locale_css');

/*Actions para el Woocomerce*/


add_action('woocommerce_add_to_cart', 'hl_add_to_cart_webhook', 10, 6);

function hl_add_to_cart_webhook($cart_item_key, $product_id, $quantity, $variation_id, $variation, $cart_item_data)
{
    // Forzar la inicialización de la sesión si aún no existe
    if (!WC()->session->has_session()) {
        WC()->session->set_customer_session_cookie(true);
    }

    $user_id = get_current_user_id() ?: 'Invitado'; // Obtiene el ID del usuario
    $session_key = WC()->session->get_customer_id(); // Obtiene el identificador de sesión del carrito

    if (!$session_key) {
        $session_key = WC()->session->get('woocommerce_cart_hash'); // Alternativa si no hay customer_id
    }

    $data = array(
        'message'   => 'Un usuario ha agregado un producto al carrito',
        'cart_key'  => $session_key ?: 'No disponible',
        'product_id' => $product_id,
        'quantity'  => $quantity,
        'user_id'   => $user_id,
        'timestamp' => time(),
    );

    wp_remote_post('https://connect.pabbly.com/workflow/sendwebhookdata/IjU3NjYwNTZlMDYzMTA0MzQ1MjZkNTUzMzUxM2Ii_pc', array(
        'body'    => json_encode($data),
        'headers' => array('Content-Type' => 'application/json'),
    ));
}
// Detectar cambios en la cantidad de productos
add_action('woocommerce_after_cart_item_quantity_update', 'hl_cart_quantity_update_webhook', 10, 2);
function hl_cart_quantity_update_webhook($cart_item_key, $quantity)
{
    hl_send_cart_webhook('update_quantity');
}

// Detectar eliminación de productos
add_action('woocommerce_remove_cart_item', 'hl_cart_item_removed_webhook', 10, 1);
function hl_cart_item_removed_webhook($cart_item_key)
{
    hl_send_cart_webhook('remove_item');
}

// Función para enviar el webhook al reak=lizar cambio en el articulo
function hl_send_cart_webhook($action)
{
    // Forzar la inicialización de la sesión si aún no existe
    if (!WC()->session->has_session()) {
        WC()->session->set_customer_session_cookie(true);
    }

    $session_key = WC()->session->get_customer_id();
    if (!$session_key) {
        $session_key = WC()->session->get('woocommerce_cart_hash'); // Alternativa si no hay customer_id
    }

    $data = array(
        'message'   => 'Cambio en el carrito',
        'cart_key'  => $session_key ?: 'No disponible',
        'action'    => $action, // update_quantity o remove_item
        'timestamp' => time(),
    );

    wp_remote_post('https://connect.pabbly.com/workflow/sendwebhookdata/IjU3NjYwNTZlMDYzMTA0MzQ1MjZkNTUzMzUxM2Ii_pc', array(
        'body'    => json_encode($data),
        'headers' => array('Content-Type' => 'application/json'),
    ));
}

// Anteces de hacer el checkhout
add_action('wp_footer', 'hl_detect_checkout_click_script');
function hl_detect_checkout_click_script()
{
    $session_key = WC()->session->get_customer_id();
    if (!$session_key) {
        $session_key = WC()->session->get('woocommerce_cart_hash'); // Alternativa si no hay customer_id
    }

    if (is_cart()) { // Solo en la página del carrito
?>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                function attachClickListener() {
                    let checkoutButton = document.querySelector(".wc-block-cart__submit-button");

                    if (checkoutButton && !checkoutButton.hasAttribute("data-listener")) {
                        checkoutButton.setAttribute("data-listener", "true"); // Evitar múltiples eventos

                        checkoutButton.addEventListener("click", function(event) {
                            event.preventDefault(); // Evitar la redirección inmediata

                            let cartKey = "<?php echo ($session_key); ?>"; // Obtener cart_key de WooCommerce
                            let checkoutUrl = checkoutButton.href; // Guardar la URL del checkout

                            // Crear la URL con parámetros GET
                            let webhookUrl =
                                `https://connect.pabbly.com/workflow/sendwebhookdata/IjU3NjYwNTZlMDYzMTA0MzQ1MjZkNTUzMzUxM2Ii_pc?message=checkout_started&cart_key=${encodeURIComponent(cartKey)}&timestamp=${Math.floor(Date.now() / 1000)}`;

                            fetch(webhookUrl, {
                                    method: "GET"
                                })
                                .then(() => {
                                    window.location.href =
                                        checkoutUrl; // Redirigir al checkout después del webhook
                                })
                                .catch(error => {
                                    console.error("Error al enviar webhook:", error);
                                    window.location.href = checkoutUrl; // Redirigir incluso si hay error
                                });
                        });

                        // console.log("✅ Listener agregado al botón de Finalizar Compra");
                    }
                }

                // Ejecutar inmediatamente si el botón ya está en el DOM
                attachClickListener();

                // Observar cambios en el DOM para detectar cuando WooCommerce lo cargue dinámicamente
                const observer = new MutationObserver(attachClickListener);
                observer.observe(document.body, {
                    childList: true,
                    subtree: true
                });
            });
        </script>
<?php
    }
}
//Hace la actualizacion al cargar el carrito

add_action('wp', 'hl_send_cart_webhook_on_load');
function hl_send_cart_webhook_on_load()
{
    if (is_cart()) { // Solo ejecuta en la página del carrito
        $session_key = WC()->session->get_customer_id();
        if (!$session_key) {
            $session_key = WC()->session->get('woocommerce_cart_hash'); // Alternativa para invitados
        }

        // URL del webhook
        $webhook_url = "https://connect.pabbly.com/workflow/sendwebhookdata/IjU3NjYwNTZlMDYzMTA0MzQ1MjZkNTUzMzUxM2Ii_pc";

        // Parámetros del webhook
        $params = [
            'message'   => 'cart_loaded',
            'cart_key'  => $session_key ? $session_key : 'No disponible',
            'timestamp' => time()
        ];

        // Construir la URL con los parámetros
        $webhook_url = add_query_arg($params, $webhook_url);

        // Enviar la solicitud GET al webhook
        wp_remote_get($webhook_url, [
            'timeout' => 5, // Límite de espera de 5 segundos
            'blocking' => false // No bloquear la carga de la página
        ]);
    }
}
