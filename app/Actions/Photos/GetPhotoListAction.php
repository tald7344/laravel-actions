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
class GetPhotoListAction
{
    use AsAction;
    use Response;
    private $photo;
    
    function __construct(PhotoImplementation $PhotoImplementation)
    {
        $this->photo = $PhotoImplementation;
    }

    public function handle(array $data, int $perPage)
    {
        if (!is_numeric($perPage))
            $perPage = 10;
        
        return PhotoResource::collection($this->photo->getPaginatedList($data, $perPage));
    }
    public function rules()
    {
        return [];
    }
    public function withValidator(Validator $validator, ActionRequest $request){}

    public function asController(Request $request)
    {
        if(auth('sanctum')->check() &&  !auth('sanctum')->user()->has_permission('photo.get'))
                return $this->sendError('Forbidden',[],403);

        $list = $this->handle($request->all(),  $request->input('results', 10));

        return $this->sendPaginatedResponse($list,'');
    }
}