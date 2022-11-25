<?php
/**
 * @since      0.1.0
 * @package    PluginName
 * @subpackage Service\Ajax
 * @author     Pascal Lehnert <mail@delennerd.de>
 */

namespace PluginName\Services\Ajax;

use PluginName\Helpers\LanguageHelper;
use RiedlBaMoHaendler\Models\UserModel;

if ( !defined('ABSPATH') ) exit; // Exit if accessed directly

class DownloadService
{
    private $downloads;

    function __construct()
    {
        // $this->downloads = new Downloads();
    }

    function getArticleData( int $seasonId )
    {
        $html = '';
        $error = [];
	
    	$template = PLUGIN_NAME_COMPONENTS_DIR . 'downloads/download-item.tpl';
        $downloadFileList = [];

    	foreach ($downloadFileList as $key => $downloadData) {	
            $fp = fopen($template, 'r');
    		$file = fread($fp, filesize($template));
    		fclose($fp);
    		
    		$subcontent = trim($file);
    		$subcontent = preg_replace('/{{title}}/', $downloadData->filename, $subcontent);
    		$subcontent = preg_replace('/{{description}}/', $downloadData->date, $subcontent); 
    		
    		$subcontent = preg_replace('/{{download-link}}/', 'Link URL', $subcontent);
    		$subcontent = preg_replace('/{{download-filename}}/', $downloadData->filename, $subcontent);
    		
    		$subcontent = preg_replace('/{{img-tag}}/', '<img src="xxx" />', $subcontent);
    		$subcontent = preg_replace('/{{call-to-action}}/', _('Herunterladen'), $subcontent);		
    		
    		$html .= $subcontent;
    	}
    	#$html = 'display artikeldaten content';
    	
    	if ( !empty($html) ) {
    		$success = true;
    	}
    	else {
    		$success = false;
    		$error['msg'] = __( 'Es sind aktuell keine Artikeldaten vorhanden.', 'plugin-name' );
    	}

    	$control['section'] = 'artikeldaten';
    	$control['content'] = $downloadFileList;
        
        return [
            'success' => $success,
            'error' => $error,
            'control' => $control,
            'html' => $html,
        ];
    }
}