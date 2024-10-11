<?php
namespace App\Actions\Pages;

use Lorisleiva\Actions\Concerns\AsAction;
use Lorisleiva\Actions\ActionRequest;
use Illuminate\Validation\Validator;
use Illuminate\Http\Request;
use App\Traits\Response;
use App\Implementations\PageImplementation;
use Hash;
class DeletePageAction
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
        return $this->page->delete($id);
    }
    public function rules()
    {
        return [];
    }
    public function withValidator(Validator $validator, ActionRequest $request)
    {
    }

    public function asController(int $id)
    {
        try{
            if(auth('sanctum')->check() &&  !auth('sanctum')->user()->has_permission('page.delete'))
                return $this->sendError('Forbidden',[],403);

            $this->handle($id);
            return $this->sendResponse(['Success'], 'Page Deleted successfully.');
        
		}catch (\Exception $e) {
            return $this->sendError($e->getMessage());
			
		}
    }
}