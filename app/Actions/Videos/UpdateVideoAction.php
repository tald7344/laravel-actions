<?php
namespace App\Actions\Videos;

use Lorisleiva\Actions\Concerns\AsAction;
use Lorisleiva\Actions\ActionRequest;
use Illuminate\Validation\Validator;
use Illuminate\Http\Request;
use App\Traits\Response;
use App\Implementations\VideoImplementation;
use App\Http\Resources\VideoResource;
use App\Actions\Uploads\UploadVideoAction;
use Hash;
class UpdateVideoAction
{
    use AsAction;
    use Response;
    private $video;
    
    function __construct(VideoImplementation $VideoImplementation)
    {
        $this->video = $VideoImplementation;
    }

    public function handle(array $data, int $id)
    {
        if(array_key_exists('video', $data))
            $data['url'] = UploadVideoAction::run($data['video']);
        
        $video = $this->video->Update($data, $id);
        return new VideoResource($video);
    }
    public function rules()
    {
        return [
        ];
    }
    public function withValidator(Validator $validator, ActionRequest $request)
    {
    }

    public function asController(Request $request, int $id)
    {
        if(auth('sanctum')->check() &&  !auth('sanctum')->user()->has_permission('video.edit'))
            return $this->sendError('Forbidden',[],403);

        $video = $this->handle($request->all(), $id);

        return $this->sendResponse($video,'');
    }
}