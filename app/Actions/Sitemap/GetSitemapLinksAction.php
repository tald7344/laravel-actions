<?php
namespace App\Actions\Sitemap;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Lorisleiva\Actions\ActionRequest;
use Illuminate\Validation\Validator;
use App\Traits\Response;

class GetSitemapLinksAction
{
    use AsAction;
    use Response;

    function __construct() {}

    public function handle()
    {
        return [
            ["path" => "/" ],
            ["path" => "/page/about"],
            ["path" => "/page/policy"],
            ["path" => "/support/FAQs"],
            ["path" => "/support/Transformative-Marketing"],
            ["path" => "/support/Complaint-and-suggestions"],
            ["path" => "/page/Shipping-information"],
            ["path" => "/page/Privacy-policy"],
            ["path" => "/page/Terms-and-conditions"],
            ["path" => "/blog"],
            ["path" => "/blog/{id}"],
        ];
    }
    public function rules()
    {
        return [];
    }
    public function withValidator(Validator $validator, ActionRequest $request){}

    public function asController(Request $request)
    {
        $record = $this->handle($request->all());
        return $this->sendResponse($record,'');
    }
}
