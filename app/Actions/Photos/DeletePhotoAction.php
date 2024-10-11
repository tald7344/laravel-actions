<?php
namespace App\Actions\Photos;

use Lorisleiva\Actions\Concerns\AsAction;
use Lorisleiva\Actions\ActionRequest;
use Illuminate\Validation\Validator;
use Illuminate\Http\Request;
use App\Traits\Response;
use App\Implementations\PhotoImplementation;
use App\Actions\Uploads\DeleteImageAction;
use Hash;
class DeletePhotoAction
{
    use AsAction;
    use Response;
    private $photo;
    
    function __construct(PhotoImplementation $PhotoImplementation)
    {
        $this->photo = $PhotoImplementation;
    }

    public function handle(int $id)
    {
        $photo = $this->photo->getOne($id);
        DeleteImageAction::run($photo->url);
        
        return $this->photo->delete($id);
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
    
            if(auth('sanctum')->check() &&  !auth('sanctum')->user()->has_permission('photo.delete'))
                return $this->sendError('Forbidden',[],403);

            $this->handle($id);
            return $this->sendResponse(['Success'], 'Photo Deleted successfully.');
        
		}catch (\Exception $e) {
            return $this->sendError($e->getMessage());
			
		}
    }
}