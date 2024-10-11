<?php
namespace App\Actions\Pages;
use Lorisleiva\Actions\Concerns\AsAction;
use Lorisleiva\Actions\ActionRequest;
use Illuminate\Validation\Validator;
use Illuminate\Http\Request;
use App\Traits\Response;
use App\Implementations\PageImplementation;
use App\Http\Resources\PageResource;
use Hash;
class GetPageListAction
{
    use AsAction;
    use Response;
    private $page;
    
    function __construct(PageImplementation $PageImplementation)
    {
        $this->page = $PageImplementation;
    }

    public function handle(array $data = [], int $perPage = 10)
    {
        if (!is_numeric($perPage))
            $perPage = 10;
        
        return PageResource::collection($this->page->getPaginatedList($data, $perPage));
    }
    public function rules()
    {
        return [];
    }
    public function withValidator(Validator $validator, ActionRequest $request){}

    public function asController(Request $request)
    {
        if(auth('sanctum')->check() &&  !auth('sanctum')->user()->has_permission('page.get'))
            return $this->sendError('Forbidden',[],403);
        
        $list = $this->handle($request->all(),  $request->input('results', 10));
        
        return $this->sendPaginatedResponse($list,'');
    }
}