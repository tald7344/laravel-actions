<?php
namespace App\Actions\Photos;

use Hash;
use App\Models\Photo;
use App\Traits\Response;
use App\Traits\BulkDelete;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;
use App\Actions\Uploads\DeleteImageAction;
use App\Implementations\PhotoImplementation;

class BulkDeletePhotoAction
{
    use AsAction;
    use Response;
    use BulkDelete;

    public function handle(array $data)
    {
        return $this->bulkDelete($data['in_ids'], new Photo);
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
    
            if(auth('sanctum')->check() &&  !auth('sanctum')->user()->has_permission('photo.delete'))
                return $this->sendError('Forbidden',[],403);

            $this->handle($request->all());
            return $this->sendResponse(['Success'], 'Photos Deleted successfully.');
        
		}catch (\Exception $e) {
            return $this->sendError($e->getMessage());
			
		}
    }
}