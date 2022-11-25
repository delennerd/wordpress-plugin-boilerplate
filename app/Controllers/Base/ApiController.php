<?php
/**
 * The nice Api controller
 *
 * @since      0.0.1
 * @package    PluginName
 * @subpackage Controllers
 * @author     Pascal Lehnert <mail@delennerd.de>
 */

namespace PluginName\Controllers\Base;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class ApiController 
{
    protected $apiBaseUrl = "URL_TO_EXTERNAL_API";

    protected $requestHeader = [];

    protected function __construct()
    {
        $this->requestHeader = [
            'headers' => [
                'Authorization' => 'Basic API_KEY',
            ],
            'sslverify' => false,
        ];
    }

    public function getRemoteResponse( $response )
    {
        $responseCode = wp_remote_retrieve_response_code( $response );
        $responseMessage = wp_remote_retrieve_response_message( $response );

        if ( $responseCode !== 200 || is_wp_error($response ) ) {
            return rest_ensure_response( [
                'status' => $responseCode,
                'message' => $responseMessage,
            ] );
        }

        return new \WP_REST_Response( [
            'status' => $responseCode,
            'message' => $responseMessage,
            'data' => json_decode( $response['body'], false ),
        ], 200 );
    }
}