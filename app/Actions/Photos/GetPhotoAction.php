<?php
namespace App\Actions\Photos;
use Lorisleiva\Actions\Concerns\AsAction;
use Lorisleiva\Actions\ActionRequest;
use Illuminate\Validation\Validator;
use Illuminate\Http\Request;
use App\Traits\Response;
use App\Implementations\PhotoImplementation;
use App\Http\Resources\PhotoResource;
use Hash;
class GetPhotoAction
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
        return new PhotoResource($this->photo->getOne($id));
    }
    public function rules()
    {
        return [];
    }
    public function withValidator(Validator $validator, ActionRequest $request){}

    public function asController(int $id)
    {
        if(auth('sanctum')->check() &&  !auth('sanctum')->user()->has_permission('photo.get'))
                return $this->sendError('Forbidden',[],403);

        $record = $this->handle($id);

        return $this->sendResponse($record,'');
    }
}