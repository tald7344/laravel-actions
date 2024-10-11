<?php
namespace App\Actions\Photos;

use App\Helpers\ImageDimensions;
use Lorisleiva\Actions\Concerns\AsAction;
use Lorisleiva\Actions\ActionRequest;
use Illuminate\Validation\Validator;
use Illuminate\Http\Request;
use App\Traits\Response;
use App\Implementations\PhotoImplementation;
use App\Http\Resources\PhotoResource;
use App\Actions\Uploads\UploadImageAction;
use Hash;


class StorePhotoAction
{
    use AsAction;
    use Response;
    private $photo;

    function __construct(PhotoImplementation $PhotoImplementation)
    {
        $this->photo = $PhotoImplementation;
    }

    public function handle(array $data)
    {
        $data['url'] = UploadImageAction::run($data['photo']);

        $photo = $this->photo->Create($data);
        return new PhotoResource($photo);
    }
    public function rules()
    {
        return [
            'photo' => ['required', 'image'],
            'visible' => ['numeric'],
            'type' => ['required'],
            'type_id' => ['required'],
        ];
    }
    public function withValidator(Validator $validator, ActionRequest $request)
    {
    }

    public function asController(Request $request)
    {
        if(auth('sanctum')->check() &&  !auth('sanctum')->user()->has_permission('photo.add'))
                return $this->sendError('Forbidden',[],403);

        $photo = $this->handle($request->all());

        return $this->sendResponse($photo,'');
    }
}
