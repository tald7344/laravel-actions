<?php
namespace App\Actions\Sitemap;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Lorisleiva\Actions\Concerns\AsAction;
use Lorisleiva\Actions\ActionRequest;
use Illuminate\Validation\Validator;
use App\Traits\Response;

class GenerateSitemapAction
{
    use AsAction;
    use Response;

    function __construct() {}

    public function handle()
    {
        $sitemapIndexLinks = [];
        $data = GetSitemapLinksAction::run();
        foreach($data as $key => $item ) {
            switch ($item['path']) {
                case '/products':
                    unset($data[$key]);
                    array_push($sitemapIndexLinks, env('APP_URL') . '/products/sitemap.xml');
                    $options = [ 'perPage' => 24, 'period' => 'weekly', 'priority' => '1' ];
                    ProductsSitemapAction::run($options);
                    break;
                case '/products/{id}':
                    unset($data[$key]);
                    array_push($sitemapIndexLinks, env('APP_URL') . '/products/details/sitemap.xml');
                    $options = [ 'period' => 'weekly', 'priority' => '1' ];
                    ProductsDetailsSitemapAction::run($options);
                    break;
                case '/vendors':
                    unset($data[$key]);
                    array_push($sitemapIndexLinks, env('APP_URL') . '/vendors/sitemap.xml');
                    $options = [ 'perPage' => 24, 'period' => 'weekly', 'priority' => '0.8' ];
                    VendorsSitemapAction::run($options);
                    break;
                case '/vendor/{name}/{id}':
                    unset($data[$key]);
                    array_push($sitemapIndexLinks, env('APP_URL') . '/vendors/details/sitemap.xml');
                    $options = [ 'period' => 'weekly', 'priority' => '0.8' ];
                    VendorsDetailsSitemapAction::run($options);
                    break;
                case '/blog':
                    unset($data[$key]);
                    array_push($sitemapIndexLinks, env('APP_URL') . '/blogs/sitemap.xml');
                    $options = [ 'perPage' => 24, 'period' => 'weekly', 'priority' => '0.3' ];
                    BlogsSitemapAction::run($options);
                    break;
                case '/blog/{id}':
                    unset($data[$key]);
                    array_push($sitemapIndexLinks, env('APP_URL') . '/blogs/details/sitemap.xml');
                    $options = [ 'period' => 'weekly', 'priority' => '0.3' ];
                    BlogsDetailsSitemapAction::run($options);
                    break;
            }
        }
        array_push($sitemapIndexLinks, env('APP_URL') . '/general/sitemap.xml');
        GeneralLinksSitemapAction::run($data);
        $output = View::make('sitemap.index')->with(compact('sitemapIndexLinks'))->render();
        Storage::disk('local')->put('sitemaps/sitemap.xml', $output);
        return 'done';
    }
    public function rules()
    {
        return [];
    }
    public function withValidator(Validator $validator, ActionRequest $request){}

    public function asController()
    {
        $record = $this->handle();
        return $this->sendResponse($record,'');
    }

    private function xmlTemplate() {
        $xw = xmlwriter_open_memory();
        xmlwriter_set_indent($xw, 1);
        $res = xmlwriter_set_indent_string($xw, ' ');

// Start the XML document
        xmlwriter_start_document($xw, '1.0', 'UTF-8');

        // Create a first element
        xmlwriter_start_element($xw, 'urlset');

        // Add an attribute 'att1' to the element 'urlset'
        xmlwriter_start_attribute($xw, 'xmlns');
        xmlwriter_text($xw, 'http://www.sitemaps.org/schemas/sitemap/0.9');
        xmlwriter_end_attribute($xw);

        // Write a comment
        xmlwriter_write_comment($xw, 'This is a comment.');

        // Start a child element 'url'
        xmlwriter_start_element($xw, 'url');


        // Start a child element 'loc'
//        xmlwriter_start_element($xw, 'loc');
//        xmlwriter_text($xw, 'http://www.google.com');
//        // End the parent element 'url'
//        xmlwriter_end_element($xw); // loc tag

        // Start a child element 'lastmod'
//        xmlwriter_start_element($xw, 'lastmod');
//        xmlwriter_text($xw, '2011-12-06T17:38:21+00:00');
//        // End the parent element 'lastmod'
//        xmlwriter_end_element($xw); // lastmod tag

        $this->buildChildElement($xw, 'loc', 'http://www.google.com');
        $this->buildChildElement($xw, 'lastmod', '2011-12-06T17:38:21+00:00');
        $this->buildChildElement($xw, 'priority', '.5');
        $this->buildChildElement($xw, 'changefreq', 'weekly');


        // End the parent element 'url'
        xmlwriter_end_element($xw); // url tag

        // End the parent element 'urlset'
        xmlwriter_end_element($xw); // urlset


// Add a processing instruction
//        xmlwriter_start_pi($xw, 'php');
//        xmlwriter_text($xw, '$foo = 2; echo $foo;');
//        xmlwriter_end_pi($xw);

// End the XML document
        xmlwriter_end_document($xw);

// Output the XML
        return xmlwriter_output_memory($xw);
    }

    private function buildChildElement($xw, $elementName, $value) {
        // Start a child element 'lastmod'
        xmlwriter_start_element($xw, $elementName);
        xmlwriter_text($xw, $value);
        // End the parent element 'lastmod'
        xmlwriter_end_element($xw); // lastmod tag
    }
}
