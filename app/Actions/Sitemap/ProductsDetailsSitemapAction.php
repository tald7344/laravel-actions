<?php
namespace App\Actions\Sitemap;

use App\Implementations\ProductImplementation;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Lorisleiva\Actions\Concerns\AsAction;
use Lorisleiva\Actions\ActionRequest;
use Illuminate\Validation\Validator;
use App\Traits\Response;
use Illuminate\Support\Facades\Response as FacadeResponse;

class ProductsDetailsSitemapAction
{
    use AsAction;
    use Response;
    private $products;
    function __construct(ProductImplementation $productImplementation) {
        $this->products = $productImplementation;
    }

    public function handle($options)
    {
        $products= $this->products->getList([]);
        $output = View::make('sitemap.product_details')->with(compact('products', 'options'))->render();
        Storage::disk('local')->put('sitemaps/products/details/sitemap.xml', $output);

    }
    public function rules()
    {
        return [];
    }
    public function withValidator(Validator $validator, ActionRequest $request){}

    public function asController()
    {
        return $this->handle();
    }
}
