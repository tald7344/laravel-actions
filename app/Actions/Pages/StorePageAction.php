<?php
namespace App\Actions\Pages;

use App\Helpers\ImageDimensions;
use Lorisleiva\Actions\Concerns\AsAction;
use Lorisleiva\Actions\ActionRequest;
use Illuminate\Validation\Validator;
use Illuminate\Http\Request;
use App\Traits\Response;
use App\Models\Page;
use App\Implementations\PageImplementation;
use App\Http\Resources\PageResource;
use App\Actions\Translations\StoreTranslationAction;
use App\Actions\Uploads\UploadImageAction;
use Hash;
class StorePageAction
{
    use AsAction;
    use Response;
    private $page;

    function __construct(PageImplementation $PageImplementation)
    {
        $this->page = $PageImplementation;
    }

    public function handle(array $data)
    {
       $data['photo'] = UploadImageAction::run($data['file'], ImageDimensions::PAGE_PHOTO);

        $page = $this->page->Create($data);

        foreach($data['languages'] as $key => $lang)
        {
            foreach($lang as $translationKey => $translation)
            {
                StoreTranslationAction::run([
                    'language_id' => $key,
                    'type' => Page::class,
                    'type_id' => $page->id,
                    'text_type' => $translationKey,
                    'value' => $translation,
                ]);
            }

        }
        return new PageResource($page);
    }
    public function rules()
    {
        return [
            'name' => ['required', 'unique:pages,name'],
            'url' => ['required'],
            'file' => ['required'],
            'languages' => ['required'],
        ];
    }
    public function withValidator(Validator $validator, ActionRequest $request)
    {
    }

    public function asController(Request $request)
    {
        if(auth('sanctum')->check() &&  !auth('sanctum')->user()->has_permission('page.add'))
            return $this->sendError('Forbidden',[],403);

        $page = $this->handle($request->all());

        return $this->sendResponse($page,'');
    }
}
