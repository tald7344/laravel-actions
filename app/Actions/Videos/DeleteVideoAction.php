<?php
namespace App\Actions\Videos;

use Lorisleiva\Actions\Concerns\AsAction;
use Lorisleiva\Actions\ActionRequest;
use Illuminate\Validation\Validator;
use Illuminate\Http\Request;
use App\Traits\Response;
use App\Implementations\VideoImplementation;
use App\Actions\Uploads\DeleteVideoFileAction;
use Hash;
class DeleteVideoAction
{
    use AsAction;
    use Response;
    private $video;
    
    function __construct(VideoImplementation $VideoImplementation)
    {
        $this->video = $VideoImplementation;
    }

    public function handle(int $id)
    {
        $video = $this->video->getOne($id);
        DeleteVideoFileAction::run($video->url);
        
        return $this->video->delete($id);
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
    
            if(auth('sanctum')->check() &&  !auth('sanctum')->user()->has_permission('video.delete'))
                return $this->sendError('Forbidden',[],403);

            $this->handle($id);
            return $this->sendResponse(['Success'], 'Video Deleted successfully.');
        
		}catch (\Exception $e) {
            return $this->sendError($e->getMessage());
			
		}
    }
}