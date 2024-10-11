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
class GetPageAction
{
    use AsAction;
    use Response;
    private $page;
    
    function __construct(PageImplementation $PageImplementation)
    {
        $this->page = $PageImplementation;
    }

    public function handle(int $id)
    {
        return new PageResource($this->page->getOne($id));
    }
    public function rules()
    {
        return [];
    }
    public function withValidator(Validator $validator, ActionRequest $request){}

    public function asController(int $id)
    {
        if(auth('sanctum')->check() &&  !auth('sanctum')->user()->has_permission('page.get'))
            return $this->sendError('Forbidden',[],403);

        $record = $this->handle($id);

        return $this->sendResponse($record,'');
    }
}