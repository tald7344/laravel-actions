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
class StoreBulkPhotoAction
{
    use AsAction;
    use Response;
    private $photo;

    function __construct(PhotoImplementation $PhotoImplementation)
    {
        $this->photo = $PhotoImplementation;
    }

    public function handle( array $data )
    {
        $photos = [];
        foreach($data['photos'] as $photo)
        {
            $data['url'] = UploadImageAction::run($photo);
            $imp = new PhotoImplementation();
            $record = $imp->Create($data);
            array_push($photos, new PhotoResource($record));
        }

        return $photos;
    }

    public function rules()
    {
        return [
            'photos' => ['required', 'array'],
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

        $photos = $this->handle($request->all());

        return $this->sendResponse($photos,'');
    }
}
