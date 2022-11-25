<?php
/**
 * ExampleApiController
 *
 * @since      0.0.1
 * @package    PluginName
 * @subpackage Controllers\Api
 * @author     Pascal Lehnert <mail@delennerd.de>
 */

// Register routes function in Config/routes.php

namespace PluginName\Controllers\Api;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use PluginName\Controllers\Base\ApiController;

class ExampleApiController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function register_routes()
    {
        register_rest_route( 'my-endpoint/v1', 'posts', [
            [
                'methods' => 'GET',
                'callback' => [ $this, 'getPosts' ],
                'permission_callback' => '__return_true',
                'args' => array(
                    'page' => array(
                        'required' => false,
                        'validate_callback' => function( $param, $request, $key ) {
                            return is_string( $param );
                        }
                    ),
                    'pageId' => array(
                        'required' => true,
                    ),
                )
            ],
        ] );
    }

    private function getFilterValues( $request, string $paramName, string $queryProperty )
    {
        $filterValues = (array) json_decode($request[ $paramName ]);
        $filterValues = array_map(function ($item) {
            return $item;
        }, $filterValues);

        if (count($filterValues) == 0) {
            return [];
        }

        $tempFilterValues = [
            '[property]=' . $queryProperty,
        ];

        for ($i=0; $i < count($filterValues); $i++) {
            $tempFilterValues[] = '[value]['. $i .']='. $filterValues[$i]->value;
        }

        return $tempFilterValues;
    }

    public function getPosts( \WP_REST_Request $request )
    {
        $outputArray = [];

        $products = (new ProductController)->getArticles($apiQueryParams, [
            'productsPerPage' => $productsPerPage,
            'page' => $page_number,
            'filters' => $filter,
        ]);
        
        ob_start();

        if ( count($products) > 0 ) {
            foreach($products as $product) {
                require RBC_DIR . '/loop-templates/products-loop.php';
            }

            $outputArray['productsFound'] = true;
        }
        else {
            esc_html_e( 'No products found', 'riedl-product-catalog' );
            $outputArray['productsFound'] = false;
        }

        $outputArray['html'] = ob_get_contents();

        ob_get_clean();

        $pagination = new \RiedlProductCatalog\Controllers\PaginationController( $productsPerPage, array_merge($apiQueryParams, ['filters' => $filter]) );

        $paginationReturn = $pagination->createProductPagination();
        $outputArray['pagination'] = $paginationReturn['html'] ?? "";
        $outputArray['xxx'] = $paginationReturn['productsCount'] ?? "";

        echo json_encode( $outputArray );
        exit;
    }
}