<?php
/**
 * A Pagination class
 *
 * @since      0.0.1
 * @package    PluginName
 * @subpackage Controllers
 * @author     Pascal Lehnert <mail@delennerd.de>
 */

namespace PluginName\Controllers;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use PluginName\Controllers\ProductController;
use PluginName\Controllers\HttpRequestController;

class PaginationController extends HttpRequestController {

    public $currentUrl;
    protected $currentPageNumber;
    protected $productsCount;
    protected $productsPerPage;
    protected $pagesCount;
    protected $queryParams;

    public function __construct( $postsPerPage = 4, $queryParams = [] )
    {
        $postsController = new PostController();
        $posts = $postsController->getArticles([
            'limit' => 'limit=1000',
        ], $queryParams);

        $this->productsCount = count($posts);

        $this->productsPerPage = $postsPerPage;

        $this->queryParams = $queryParams;

        $pagesCount = $this->productsCount / $this->productsPerPage;
        $this->pagesCount = ceil($pagesCount);

        $this->setCurrentPage();
    }

    public function setCurrentUrl( $url ) : void
    {
        $this->currentUrl = $url;
    }

    public function setCurrentPage() : void
    {
        $this->currentPageNumber = self::getCurrentPageNumber();
    }

    public function getNewUrl( $params = [] )
    {
        $new_url = $this->currentUrl;

        foreach( $params as $key => $val ) {
            $new_url = add_query_arg( $key, $val, $new_url);
        }

        return $new_url;
    }

    public function createProductPagination(): array
    {
        if ($this->pagesCount == 1) {
            return [
                'html' => '',
                'productsCount' => $this->productsCount,
            ];
        }

        $page_numbers = [];

        $show_pages_left = 2;
        $show_pages_right = 2;

        $start_page_number = ($this->currentPageNumber - $show_pages_left) < $this->pagesCount ? $this->currentPageNumber - $show_pages_left : 1;
        $max_page_numbers = ($this->currentPageNumber + $show_pages_right) < $this->pagesCount-1 ? $this->currentPageNumber + $show_pages_right : $this->pagesCount-1;

        if ($start_page_number <= 1) {
            $start_page_number = 2;
        }

        if ( $this->pagesCount > 0 ) {
            $page_numbers[] = sprintf(
                '<li class="%3$s"><a href="%1$s" class="item-link" data-page="%2$s">%2$s</a></li>',
                $this->getNewUrl( ['page' => 1] ), 
                1,
                $this->currentPageNumber == 1 ? "active" : "",
            );
        }

        if ($this->currentPageNumber - 2 > 2) {
            $page_numbers[] = sprintf(
                '<li><span>%1$s</span></li>',
                '...',
            );
        }

        if ( $max_page_numbers > 0 ) {

            for( $number = $start_page_number; $number <= $max_page_numbers; $number++ ) {
                $page_numbers[] = sprintf(
                    '<li class="%3$s"><a href="%1$s" class="item-link" data-page="%2$s">%2$s</a></li>',
                    $this->getNewUrl( ['page' => $number] ),
                    $number,
                    $this->currentPageNumber == $number ? "active" : "",
                );
            }
        }

        if ($max_page_numbers < $this->pagesCount && $this->currentPageNumber + 2 < $this->pagesCount) {
            $page_numbers[] = sprintf(
                '<li><span>%1$s</span></li>',
                '...',
            );
        }

        if ( $this->pagesCount > 0 ) {
            $page_numbers[] = sprintf(
                '<li class="%3$s"><a href="%1$s" class="item-link" data-page="%2$s">%2$s</a></li>',
                $this->getNewUrl( ['page' => $this->pagesCount] ),
                $this->pagesCount,
                $this->currentPageNumber == $this->pagesCount ? "active" : "",
            );
        }

        $html = '<div class="product-pagination"><ul>';

        // if ( $this->currentPageNumber > 1 ) {
        //     $html .= sprintf(
        //         '<li class="item-prev"><a href="%2$s" data-page="%1$s"><i class="fas fa-chevron-left"></i></a></li>',
        //         ($this->currentPageNumber - 1),
        //         $this->getNewUrl( ['page' => ($this->currentPageNumber - 1)] ),
        //         // __( 'Previous page', 'riedl-product-catalog' )
        //     );
        // }

        $html .= implode("\n", $page_numbers);

        // if ( $this->currentPageNumber < $this->pagesCount ) {
        //     $html .= sprintf(
        //         '<li class="item-next"><a href="%2$s" data-page="%1$s"><i class="fas fa-chevron-right"></i></a></li>',
        //         ($this->currentPageNumber + 1),
        //         $this->getNewUrl( ['page' => ($this->currentPageNumber + 1)] ),
        //         // __( 'Next page', 'riedl-product-catalog' )
        //     );
        // }

        $html .= '</ul></div>';

        return [
            'html' => $html,
            'productsCount' => $this->productsCount,
        ];

    }
}