<?php
/**
 * @since      0.1.0
 * @package    PluginName
 * @subpackage Controllers
 * @author     Pascal Lehnert <mail@delennerd.de>
 */

namespace PluginName\Controllers;

use PluginName\Helpers\LanguageHelper;

if ( !defined('ABSPATH') ) exit; // Exit if accessed directly

class MailController
{
    private $templateName;
    private $mailTemplatePath;
    private $headers;
    private $subject;
    private $mailData = [];

    function __construct( $languageCode = '' )
    {
        if ( empty($languageCode) ) {
            $languageCode = LanguageHelper::getLanguage();
        }
        
        $this->mailTemplatePath = PLUGIN_NAME_TEMPLATES_DIR . 'mails/' . $languageCode . '/';
    }

    /**
     * @param mailData[email]
     */
    public function send()
    {
        // Will use in the mail template
        $mailData = $this->mailData;

        if ( ! is_array($mailData) || ! isset( $mailData['email'] ) ) {
            return new \ErrorException( 'Set a email address in setMailData()' );
        }

        $title = $this->subject;
        $template = $this->mailTemplatePath . $this->templateName;
        $headers = [
            'Content-Type: text/html; charset=UTF-8',
        ];

        if ( array_key_exists( 'replyTo' , $this->headers ) ) {
            $headers[] = 'Reply-To: '. $this->headers['replyTo'];
        }

        if ( array_key_exists( 'from' , $this->headers ) ) {
            $headers[] = 'From: '. $this->headers['from'];
        }

        ob_start();
        include $template;
        $content = ob_get_clean();

        return wp_mail( $mailData['email'], $title, $content, $headers );
    }

    public function setTemplate( $templateName )
    {
        $this->templateName = $templateName;
    }

    public function getTemplate()
    {
        return $this->templateName;
    }

    public function setHeaders( $headers )
    {
        $this->headers = $headers;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function setSubject( $subject )
    {
        $this->subject = $subject;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function setMailData( $mailData )
    {
        $this->mailData = $mailData;
    }

    public function getMailData()
    {
        return $this->mailData;
    }
}

?>