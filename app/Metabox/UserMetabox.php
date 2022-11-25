<?php
/**
 * @since      0.1.0
 * @package    PluginName
 * @subpackage Metabox
 * @author     Pascal Lehnert <mail@delennerd.de>
 */

namespace PluginName\Metabox;

use Carbon_Fields\Container;
use Carbon_Fields\Field;
use PluginName\Helpers\CarbonFieldsHelper;

if (!defined('ABSPATH' )) exit; // Exit if accessed directly

class UserMetabox
{
    function __construct()
    {
        add_action( 'carbon_fields_register_fields', function() {

            Container::make( 'user_meta', 'Presse Informationen' )
                ->where( 'user_role', '=', 'subscriber' )
                ->add_tab( __( 'Unternehmen / Verlag' ), array(

                    Field::make( 'text', CarbonFieldsHelper::setFieldName( 'company' ), __( 'Unternehmen' ) ),

                    Field::make( 'text', CarbonFieldsHelper::setFieldName( 'street' ), __( 'Strasse' ) ),

                    Field::make( 'text', CarbonFieldsHelper::setFieldName( 'zip' ), __( 'PLZ' ) ),

                    Field::make( 'text', CarbonFieldsHelper::setFieldName( 'city' ), __( 'Ort' ) ),

                    Field::make( 'text', CarbonFieldsHelper::setFieldName( 'country' ), __( 'Land' ) ),

                    Field::make( 'text', CarbonFieldsHelper::setFieldName( 'homepage' ), __( 'Homepage' ) ),
                ))

                ->add_tab( __( 'Ansprechpartner' ), array(

                    Field::make( 'select', CarbonFieldsHelper::setFieldName( 'asp_gender' ), __( 'Anrede' ) )
                        ->add_options( array(
                            '' => __( 'Bitte wählen', 'plugin-name' ),
                            'f' => __( 'Frau' ),
                            'm' => __( 'Herr' )
                        ) ),

                    Field::make( 'text', 
                    CarbonFieldsHelper::setFieldName( 'asp_firstname' ), __( 'Vorname & Name' ) )
                        ->set_width( 50 )
                        ->set_attribute( 'placeholder', __( 'Vorname' ) ),

                    Field::make( 'text', CarbonFieldsHelper::setFieldName( 'asp_name' ), '' )
                        ->set_width( 50 )
                        ->set_attribute( 'placeholder', __( 'Name' ) ),
                ) );
        } );
    }
}