<?php
namespace App\Actions\Photos;

use Lorisleiva\Actions\Concerns\AsAction;
use Lorisleiva\Actions\ActionRequest;
use Illuminate\Validation\Validator;
use Illuminate\Http\Request;
use App\Traits\Response;
use App\Implementations\PhotoImplementation;
use App\Http\Resources\PhotoResource;
use App\Actions\Uploads\UploadImageAction;
use Hash;
class UpdatePhotoAction
{
    use AsAction;
    use Response;
    private $photo;
    
    function __construct(PhotoImplementation $PhotoImplementation)
    {
        $this->photo = $PhotoImplementation;
    }

    public function handle(array $data, int $id)
    {
        if(array_key_exists('photo', $data))
            $data['url'] = UploadImageAction::run($data['photo']);
        
        $photo = $this->photo->Update($data, $id);
        return new PhotoResource($photo);
    }
    public function rules()
    {
        return [
            'photo' => ['image']
        ];
    }
    public function withValidator(Validator $validator, ActionRequest $request)
    {
    }

    public function asController(Request $request, int $id)
    {
        if(auth('sanctum')->check() &&  !auth('sanctum')->user()->has_permission('photo.edit'))
                return $this->sendError('Forbidden',[],403);

        $photo = $this->handle($request->all(), $id);

        return $this->sendResponse($photo,'');
    }
}