<?php
 
namespace App\Implementations;
 
use App\Interfaces\Model;
use App\Models\Blog;
 
class BlogImplementation implements Model
{
    private $blog;

    function __construct()
    {
        $this->blog = New Blog();
    }
    public function resolveCriteria($data = [])
    {
        $query = Blog::Query();

        if (array_key_exists('columns', $data)) {
            $query = $query->select($data['columns']);
        } elseif (array_key_exists('raw_columns', $data)) {
            $query = $query->selectRaw($data['raw_columns']);
        } else {
            $query = $query->select("*");
        }
        if (array_key_exists('keywords', $data)) {
            $query = $query->whereHas('allTranslations', function ($query) use ($data){
                return $query->where('value', 'like', '%'.$data['keywords'].'%');
            })->orWhere('name',  'like', '%'.$data['keywords'].'%');
        }
        if (array_key_exists('created_by', $data)) {
            $query = $query->where('created_by',  $data['created_by']);
        }
        if (array_key_exists('name', $data)) {
            $query = $query->where('name',  $data['name']);
        }
        if (array_key_exists('photo', $data)) {
            $query = $query->where('photo',  $data['photo']);
        }
        
        if (array_key_exists('orderBy', $data)) {
            $query = $query->orderBy($data['orderBy'], 'DESC');
        }else {
            $query = $query->orderBy('id', 'DESC');
        }

        if (array_key_exists('limit', $data) && array_key_exists('offset', $data)) {
            $query = $query->take($data['limit']);
            $query = $query->skip($data['offset']);
        }

        return $query;

    }

    public function getOne($id) 
    {
        $user = Blog::findOrFail($id);
        return $user;
    }
    public function getList($data) {
        $list = $this->resolveCriteria($data)->get();
        return $list;
    }
    public function getPaginatedList($data, $perBlog) {
        $list = $this->resolveCriteria($data)->paginate($perBlog);
        return $list;
    }
    public function Create($data = []) 
    {

        $this->mapDataModel($data);

        $this->blog->save();

        return $this->blog;

    }
    public function Update($data = [], $id) 
    {
        $this->blog = $this->getOne($id);
        
        $this->mapDataModel($data);

        $this->blog->save();

        return $this->blog;
    }
    public function Delete($id) {
        $record = $this->getOne($id);

        $record->delete();
    }

    public function mapDataModel($data)
    {
        $attribute = [	
			'id'
			,'name'
			,'photo'
			,'created_at'
			,'updated_at'
			,'deleted_at'
			,'created_by'
			,'updated_by'
			,'deleted_by'
        ];

        foreach ($attribute as $val) {
            if (array_key_exists($val, $data)) {
                $this->blog->$val = $data[$val];
            }
        }
    }


}