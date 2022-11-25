<?php
/**
 * @since      0.1.0
 * @package    PluginName
 * @subpackage Controllers\Base
 * @author     Pascal Lehnert <mail@delennerd.de>
 */

namespace PluginName\Controllers\Base;

if ( !defined('ABSPATH') ) exit; // Exit if accessed directly

class FormAlertController
{
    public static function renderSuccess( string $message ): string
    {
        $message = [
            'success' => [ $message ],
        ];

        return self::_renderOutput( $message, 'success' );
    }
    public static function renderError( string $message ): string
    {
        if ( ! is_array($message) || ! isset($message['error']) ) {
            $message = [
                'error' => [ $message ],
            ];
        }

        return self::_renderOutput( $message, 'error' );
    }

    private static function _renderOutput( array $messagesArray, string $type = '' ): string
    {
        $output = '<ul class="form-alert-messages">';

        foreach ($messagesArray as $key => $message) {
            if (false !== strpos($key, 'username')) {
                unset($messagesArray[$key]);
            } else {
                $output .= sprintf(
                    '<li class="form-alert-' . $type . '">%s</li>',
                    $message[0]
                );
            }
        }

        $output .= '</ul>';

        return $output;
    }
}