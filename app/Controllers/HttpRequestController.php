<?php
/**
 * @since      0.0.1
 * @package    PluginName
 * @subpackage Controllers
 * @author     Pascal Lehnert <mail@delennerd.de>
 */

namespace PluginName\Controllers;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class HttpRequestController {

    private $currentUrl;

    public function __construct()
    {
        add_filter( 'query_vars', [ $this, 'addQueryVarsFilter' ] );
    }

    public function addQueryVarsFilter( $vars ): array
    {
        $vars[] = "page";
        $vars[] = "search";
        $vars[] = "category";
        return $vars;
    }

    protected function getCurrentUrl(): string
    {
        return $this->currentUrl;
    }

    public static function getCurrentPageNumber(): int
    {
        $current_page = isset($_GET['page']) ? sanitize_text_field( $_GET['page'] ) : '';

        return isset($current_page) && !empty($current_page) ? (int) esc_attr( $current_page ) : 1;
    }

    public static function combineFilterParams(array $filters)
    {
        $filters_string = "";

        for( $i = 0; $i < count($filters); $i++ ) {

            $temp = "";
            $tempIterator = 0;
            
            foreach($filters[$i] as $filter) {
                $temp .= "filter[{$i}]{$filter}";

                if ($tempIterator < count($filters[$i])) {
                    $temp .= "&";
                }

                $tempIterator++;
            }

            $filters_string .= $temp;
        }

        return $filters_string;
    }
}