<?php

namespace App\Models\Admin;

use App\Models\AppModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use App\Libraries\General;
use App\Models\Admin\Setting;

class Slider extends AppModel
{
    protected $table = 'sliders';
    protected $primaryKey = 'id';

    /**** ONLY USE FOR MAIN TALBLES NO NEED TO USE FOR RELATION TABLES OR DROPDOWNS OR SMALL SECTIONS ***/
    use SoftDeletes;
    
    /**
    * Slider -> Admins belongsTO relation
    * 
    * @return Admins
    */
    public function owner()
    {
        return $this->belongsTo(Admin::class, 'created_by', 'id');
    }

    /**
    * Get resize images
    *
    * @return array
    */
    public function getResizeImagesAttribute()
    {
        return $this->image ? FileSystem::getAllSizeImages($this->image) : null;
    }

    /**
    * To search and get pagination listing
    * @param Request $request
    * @param $limit
    */

    public static function getListing(Request $request, $where = [])
    {
        $orderBy = $request->get('sort') ? $request->get('sort') : 'sliders.id';
        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $page = $request->get('page') ? $request->get('page') : 1;
        $limit = self::$paginationLimit;
        $offset = ($page - 1) * $limit;
        
        $listing = Slider::select([
                'sliders.*',
                'owner.first_name as owner_first_name',
                'owner.last_name as owner_last_name'
            ])
            ->leftJoin('admins as owner', 'owner.id', '=', 'sliders.created_by')
            ->orderBy($orderBy, $direction);

        if(!empty($where))
        {
            foreach($where as $query => $values)
            {
                if(is_array($values))
                    $listing->whereRaw($query, $values);
                elseif(!is_numeric($query))
                    $listing->where($query, $values);
                else
                    $listing->whereRaw($values);
            }
        }

        // Put offset and limit in case of pagination
        if($page !== null && $page !== "" && $limit !== null && $limit !== "")
        {
            $listing->offset($offset);
            $listing->limit($limit);
        }

        $listing = $listing->paginate($limit);

        return $listing;
    }

    /**
    * To get all records
    * @param $where
    * @param $orderBy
    * @param $limit
    */
    public static function getAll($select = [], $where = [], $orderBy = 'sliders.id desc', $limit = null)
    {
        $listing = Slider::orderByRaw($orderBy);

        if(!empty($select))
        {
            $listing->select($select);
        }
        else
        {
            $listing->select([
                'sliders.*'
            ]); 
        }

        if(!empty($where))
        {
            foreach($where as $query => $values)
            {
                if(is_array($values))
                    $listing->whereRaw($query, $values);
                elseif(!is_numeric($query))
                    $listing->where($query, $values);
                else
                    $listing->whereRaw($values);
            }
        }
        
        if($limit !== null && $limit !== "")
        {
            $listing->limit($limit);
        }

        $listing = $listing->get();

        return $listing;
    }

    /**
    * To get single record by id
    * @param $id
    */
    public static function get($id, $select = [])
    {
        $record = Slider::select($select ? $select : ['sliders.*'])
            ->where('id', $id)
            ->with([
                'owner' => function($query) {
                    $query->select([
                            'id',
                            'first_name',
                            'last_name'
                        ]);
                }
            ])
            ->first();

        return $record;
    }

    /**
    * To get single row by conditions
    * @param $where
    * @param $orderBy
    */
    public static function getRow($where = [], $orderBy = 'sliders.id desc', $select = [])
    {
        $record = Slider::orderByRaw($orderBy);

        if(!empty($select))
        {
            $record->select($select);
        }
        else
        {
            $record->select([
                'sliders.*'
            ]); 
        }

        foreach($where as $query => $values)
        {
            if(is_array($values))
                $record->whereRaw($query, $values);
            elseif(!is_numeric($query))
                $record->where($query, $values);
            else
                $record->whereRaw($values);
        }
        
        $record = $record->limit(1)->first();

        return $record;
    }

    /**
    * To insert
    * @param $where
    * @param $orderBy
    */
    public static function create($data)
    {
        $slider = new Slider();

        foreach($data as $k => $v)
        {
            $slider->{$k} = $v;
        }

        $slider->created_by = AdminAuth::getLoginId();

        // In case of timestamp true from setting table, Disabled default timestamps will be false
        if(Setting::get('timestamps'))
        {
            $slider->created_at = date('Y-m-d H:i:s');
            $slider->updated_at = date('Y-m-d H:i:s');
        }

        if($slider->save())
        {
            if(isset($data['title']) && $data['title'])
            {
                $slider->slug = Str::slug($slider->title) . '-' . General::encode($slider->id);
                $slider->save();
            }

            return $slider;
        }
        else
        {
            return null;
        }
    }

    /**
    * To update
    * @param $id
    * @param $where
    */
    public static function modify($id, $data)
    {
        $slider = Slider::find($id);

        foreach($data as $k => $v)
        {
            $slider->{$k} = $v;
        }

        // In case of timestamp true from setting table, Disabled default timestamps will be false
        if(Setting::get('timestamps'))
        {
            $slider->updated_at = date('Y-m-d H:i:s');
        }

        if($slider->save())
        {
            return $slider;
        }
        else
        {
            return null;
        }
    }

    
    /**
    * To update all
    * @param $id
    * @param $where
    */
    public static function modifyAll($ids, $data)
    {
        if(!empty($ids))
        {
            return Slider::whereIn('sliders.id', $ids)
                    ->update($data);
        }
        else
        {
            return null;
        }
    }

    /**
    * To delete
    * @param $id
    */
    public static function remove($id)
    {
        $slider = Slider::find($id);
        return $slider->delete();
    }

    /**
    * To delete all
    * @param $id
    * @param $where
    */
    public static function removeAll($ids)
    {
        if(!empty($ids))
        {
            return Slider::whereIn('sliders.id', $ids)
                    ->delete();
        }
        else
        {
            return null;
        }
    }

    /**
    * To get count
    * @param $where
    */
    public static function getCount($where = [])
    {
        $record = Slider::select([
                DB::raw('COUNT(sliders.id) as count'),
            ]);

        if(!empty($where))
        {
            foreach($where as $query => $values)
            {
                if(is_array($values))
                    $record->whereRaw($query, $values);
                elseif(!is_numeric($query))
                    $record->where($query, $values);
                else
                    $record->whereRaw($values);
            }

            $record = $record->limit(1)->first();
        }

        return $record ? $record->count : '';
    }
}