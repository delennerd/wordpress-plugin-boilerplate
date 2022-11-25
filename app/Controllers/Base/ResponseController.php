<?php
/**
 * @since      0.1.0
 * @package    PluginName
 * @subpackage Controllers\Base
 * @author     Pascal Lehnert <mail@delennerd.de>
 */

namespace PluginName\Controllers\Base;

if ( !defined('ABSPATH') ) exit; // Exit if accessed directly

class ResponseController
{
    private $success, 
            $error,
            $errorClass,
            $integrity,
            $statusMessage,
            $control,
            $uiText,
            $html;

    public function getResponseData(): array
    {
        $outputData['success'] = $this->success ?? false;
        
        if ( !empty( $this->html ) )
            $outputData['html'] = $this->html;
        
        if ( !empty( $this->integrity ) )
            $outputData['integrityStatus'] = $this->integrity->status;

        if ( !empty( $this->error ) ) 
            $outputData['error'] = $this->error;

        if ( !empty( $this->errorClass ) ) 
            $outputData['errorClass'] = $this->errorClass;

        if ( !empty( $this->statusMessage ) ) 
            $outputData['statusMsg'] = $this->statusMessage;

        if ( !empty( $this->control ) ) 
            $outputData['control'] = $this->control;

        if ( !empty( $this->uiText ) ) 
            $outputData['uiText'] = $this->uiText;

        return $outputData;
    }

    public function setSuccess( $value )
    {
        $this->success = $value;
    }

    public function setSuccessMessage( $value )
    {
        $this->statusMessage = $value;
    }

    public function setErrorMessage( $value )
    {
        $this->error = $value;
    }

    public function setErrorClass( $value )
    {
        $this->errorClass = $value;
    }

    public function setIntegrity( $value )
    {
        $this->integrity = $value;
    }

    public function setControl( $value )
    {
        $this->control = $value;
    }

    public function setUiText( $value )
    {
        $this->uiText = $value;
    }

    public function setHtml( $value )
    {
        $this->html = $value;
    }
}