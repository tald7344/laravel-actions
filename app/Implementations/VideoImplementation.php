<?php
 
namespace App\Implementations;
 
use App\Interfaces\Model;
use App\Models\Video;
 
class VideoImplementation implements Model
{
    private $video;

    function __construct()
    {
        $this->video = New Video();
    }
    public function resolveCriteria($data = [])
    {
        $query = Video::Query();

        if (array_key_exists('columns', $data)) {
            $query = $query->select($data['columns']);
        } elseif (array_key_exists('raw_columns', $data)) {
            $query = $query->selectRaw($data['raw_columns']);
        } else {
            $query = $query->select("*");
        }
        if (array_key_exists('url', $data)) {
            $query = $query->where('url',  $data['url']);
        }
        if (array_key_exists('type', $data)) {
            $query = $query->where('type',  $data['type']);
        }
        if (array_key_exists('type_id', $data)) {
            $query = $query->where('type_id',  $data['type_id']);
        }
        if (array_key_exists('orderBy', $data)) {
            $query = $query->orderBy($data['orderBy'], 'DESC');
        }else {
            $query = $query->orderBy('id', 'DESC');
        }
        return $query;

    }

    public function getOne($id) 
    {
        $user = Video::findOrFail($id);
        return $user;
    }
    public function getList($data) {
        $list = $this->resolveCriteria($data)->get();
        return $list;
    }
    public function getPaginatedList($data, $perPage) {
        $list = $this->resolveCriteria($data)->paginate($perPage);
        return $list;
    }
    public function Create($data = []) 
    {

        $this->mapDataModel($data);

        $this->video->save();

        return $this->video;

    }
    public function Update($data = [], $id) 
    {
        $this->video = $this->getOne($id);
        
        $this->mapDataModel($data);

        $this->video->save();

        return $this->video;
    }
    public function Delete($id) {
        $record = $this->getOne($id);

        $record->delete();
    }

    public function mapDataModel($data)
    {
        $attribute = [	
			'id'
			,'url'
			,'type'
			,'type_id'
			,'created_at'
			,'updated_at'
			,'deleted_at'
			,'created_by'
			,'updated_by'
			,'deleted_by'
        ];

        foreach ($attribute as $val) {
            if (array_key_exists($val, $data)) {
                $this->video->$val = $data[$val];
            }
        }
    }


}