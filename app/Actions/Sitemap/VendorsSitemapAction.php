<?php
namespace App\Actions\Sitemap;

use App\Implementations\UserImplementation;
use App\Models\User;
use Illuminate\Support\Facades\Response as FacadeResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Lorisleiva\Actions\Concerns\AsAction;
use Lorisleiva\Actions\ActionRequest;
use Illuminate\Validation\Validator;
use App\Traits\Response;

class VendorsSitemapAction
{
    use AsAction;
    use Response;
    private $vendors;
    function __construct(UserImplementation $UserImplementation) {
        $this->vendors = $UserImplementation;
    }

    public function handle($options)
    {
        $vendors = $this->vendors->getList([]);
        $pagesNumber = ceil(count($vendors) / $options['perPage']);
        $output = View::make('sitemap.vendor')->with(compact('pagesNumber', 'options'))->render();
        Storage::disk('local')->put('sitemaps/vendors/sitemap.xml', $output);

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