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

class StoreBulkVideoAction
{
    use AsAction;
    use Response;
    private $video;
    
    function __construct(VideoImplementation $VideoImplementation)
    {
        $this->video = $VideoImplementation;
    }

    public function handle( array $data )
    {
        $videos = [];
        
        foreach($data['videos'] as $video)
        {            
            $data['url'] = UploadVideoAction::run($video);
            $imp = new VideoImplementation();
            $record = $imp->Create($data);
            array_push($videos, new VideoResource($record));
        }

        return $videos;
    }

    public function rules()
    {
        return [
            'videos' => ['required', 'array'],
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

        $videos = $this->handle($request->all());

        return $this->sendResponse($videos,'');
    }
}