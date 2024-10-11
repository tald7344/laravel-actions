<?php
namespace App\Actions\Sitemap;

use App\Models\User;
use Illuminate\Support\Facades\Response as FacadeResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Lorisleiva\Actions\Concerns\AsAction;
use Lorisleiva\Actions\ActionRequest;
use Illuminate\Validation\Validator;
use App\Traits\Response;

class GeneralLinksSitemapAction
{
    use AsAction;
    use Response;

    function __construct() {}

    public function handle(array $data)
    {
        $output = View::make('sitemap.general')->with(compact('data'))->render();
        Storage::disk('local')->put('sitemaps/general/sitemap.xml', $output);
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
