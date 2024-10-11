<?php
namespace App\Actions\Videos;
use Lorisleiva\Actions\Concerns\AsAction;
use Lorisleiva\Actions\ActionRequest;
use Illuminate\Validation\Validator;
use Illuminate\Http\Request;
use App\Traits\Response;
use App\Implementations\VideoImplementation;
use App\Http\Resources\VideoResource;
use Hash;
class GetVideoListAction
{
    use AsAction;
    use Response;
    private $video;
    
    function __construct(VideoImplementation $VideoImplementation)
    {
        $this->video = $VideoImplementation;
    }

    public function handle(array $data, int $perPage)
    {
        if (!is_numeric($perPage))
            $perPage = 10;
        
        return VideoResource::collection($this->video->getPaginatedList($data, $perPage));
    }
    public function rules()
    {
        return [];
    }
    public function withValidator(Validator $validator, ActionRequest $request){}

    public function asController(Request $request)
    {
        if(auth('sanctum')->check() &&  !auth('sanctum')->user()->has_permission('video.get'))
            return $this->sendError('Forbidden',[],403);

        $list = $this->handle($request->all(),  $request->input('results', 10));

        return $this->sendPaginatedResponse($list,'');
    }
}