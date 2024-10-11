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
class StoreVideoAction
{
    use AsAction;
    use Response;
    private $video;
    
    function __construct(VideoImplementation $VideoImplementation)
    {
        $this->video = $VideoImplementation;
    }

    public function handle(array $data)
    {
        try{
            $data['url'] = UploadVideoAction::run($data['video']);
            
            $video = $this->video->Create($data);
            return new VideoResource($video);
        }catch(\Exception $e){}
    }
    public function rules()
    {
        return [
            'video' => ['required'],
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
        if(auth('sanctum')->check() &&  !auth('sanctum')->user()->has_permission('video.add'))
            return $this->sendError('Forbidden',[],403);

        $video = $this->handle($request->all());

        return $this->sendResponse($video,'');
    }
}