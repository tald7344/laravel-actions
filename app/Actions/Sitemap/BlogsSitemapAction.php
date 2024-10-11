<?php
namespace App\Actions\Sitemap;

use App\Implementations\BlogImplementation;
use App\Implementations\ProductImplementation;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Lorisleiva\Actions\Concerns\AsAction;
use Lorisleiva\Actions\ActionRequest;
use Illuminate\Validation\Validator;
use App\Traits\Response;
use Illuminate\Support\Facades\Response as FacadeResponse;

class BlogsSitemapAction
{
    use AsAction;
    use Response;
    private $blogs;
    function __construct(BlogImplementation $blogImplementation) {
        $this->blogs = $blogImplementation;
    }

    public function handle($options)
    {
        $blogCount = $this->blogs->getList([]);
        $pagesNumber = ceil(count($blogCount) / $options['perPage']);
        $output = View::make('sitemap.blog')->with(compact('pagesNumber', 'options'))->render();
        Storage::disk('local')->put('sitemaps/blogs/sitemap.xml', $output);

    }
    public function rules()
    {
        return [];
    }
    public function withValidator(Validator $validator, ActionRequest $request){}

    public function asController()
    {
        return $this->handle();
    }
}
