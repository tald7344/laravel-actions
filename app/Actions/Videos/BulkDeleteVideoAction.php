<?php
namespace App\Actions\Videos;

use Hash;
use App\Models\Video;
use App\Traits\Response;
use App\Traits\BulkDelete;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;
use App\Actions\Uploads\DeleteImageAction;
use App\Implementations\PhotoImplementation;

class BulkDeleteVideoAction
{
    use AsAction;
    use Response;
    use BulkDelete;

    public function handle(array $data)
    {
        return $this->bulkDelete($data['in_ids'], new Video);
    }
    public function rules()
    {
        return ['in_ids'=>'required'];
    }
    public function withValidator(Validator $validator, ActionRequest $request)
    {
    }

    public function asController(Request $request)
    {
        try{
    
            if(auth('sanctum')->check() &&  !auth('sanctum')->user()->has_permission('video.delete'))
                return $this->sendError('Forbidden',[],403);

            $this->handle($request->all());
            return $this->sendResponse(['Success'], 'Videos Deleted successfully.');
        
		}catch (\Exception $e) {
            return $this->sendError($e->getMessage());
			
		}
    }
}