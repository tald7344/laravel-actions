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
use App\Actions\Translations\UpdateTranslationAction;
use App\Actions\Uploads\UploadImageAction;
use Hash;

class UpdatePageAction
{
    use AsAction;
    use Response;
    private $page;

    function __construct(PageImplementation $PageImplementation)
    {
        $this->page = $PageImplementation;
    }

    public function handle(array $data, int $id)
    {
        if(array_key_exists('file', $data))
            $data['photo'] = UploadImageAction::run($data['file'], ImageDimensions::PAGE_PHOTO);

        if (array_key_exists('languages', $data)) {
            foreach ($data['languages'] as $key => $lang) {
                foreach ($lang as $translationKey => $translation) {
                    UpdateTranslationAction::run([
                        'text_type' => $translationKey,
                        'value' => $translation,
                    ], (int) $key);
                }

            }
        }

        $page = $this->page->Update($data, $id);
        return new PageResource($page);
    }
    public function rules(Request $request)
    {
        return [
            'name' => ['unique:pages,name,'.$request->route('id')],
        ];
    }
    public function withValidator(Validator $validator, ActionRequest $request)
    {
    }

    public function asController(Request $request, int $id)
    {
        if(auth('sanctum')->check() &&  !auth('sanctum')->user()->has_permission('page.edit'))
            return $this->sendError('Forbidden',[],403);

        $page = $this->handle($request->all(), $id);

        return $this->sendResponse($page,'');
    }
}
