<?php
/**
 * @since      0.0.1
 * @package    PluginName
 * @subpackage Bootstrap
 * @author     Pascal Lehnert <mail@delennerd.de>
 */
 
namespace PluginName\Bootstrap;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Route
{
    protected static $routes = [];

    protected static $params = [];

    protected static $templateFunctions = [];

    private function __construct()
    {
    }

    public static function initRoutes()
    {
        foreach (self::$routes as $route) {
            $params_array = $route['params'];
            $paramsMap = [];

            foreach( $params_array as $key => $val ) {
                $paramsMap[] = "$key=$val";
            }
            $paramsString = implode('&', $paramsMap );

            add_rewrite_rule(
                $route['endpoint'] . '/?$',
                'index.php?' . $paramsString,
                'top'
            );
        }

        add_filter( 'query_vars', [ static::class, 'initQueryVars' ] );

        self::initRewriteTemplates();

        flush_rewrite_rules( true );
    }

    public function get_routes(): array
    {
        return self::$routes;
    }

    public static function addRoute(string $endpoint_regex, array $params = [])
    {
        self::$routes[] = [
            'endpoint' => $endpoint_regex,
            'params' => $params,
        ];

        foreach ($params as $key => $value) {
            self::$params[] = $key;
        }
    }

    public static function initQueryVars( $queryVars )
    {
        self::$params = array_unique(self::$params);

        foreach (self::$params as $param) {
            $queryVars[] = $param;
        }

        return $queryVars;
    }

    public static function initRewriteTemplates()
    {
        foreach( self::$templateFunctions as $params ) {
            
            add_action( 'template_redirect', function() use ($params) {

                $routes = $params['routeParams'];
                $allRouteKeys = array_keys($routes);

                $callbackFunction = $params['callback'];

                if ( $routes[$allRouteKeys[0]] === get_query_var( $allRouteKeys[0] ) ) {
                    return $callbackFunction();
                }
            } );
        }
    }

    public static function addTemplate( $function, $routes )
    {
        self::$templateFunctions[] = [
            'routeParams' => $routes,
            'callback' => $function,
        ];
    }
}