<?php

namespace App\Models\Admin;

use App\Models\AppModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Libraries\FileSystem;
use Illuminate\Support\Str;
use App\Libraries\General;
use App\Models\Admin\Setting;

class BlogCategory extends AppModel
{
    protected $table = 'blog_categories';
    protected $primaryKey = 'id';

    /**** ONLY USE FOR MAIN TALBLES NO NEED TO USE FOR RELATION TABLES OR DROPDOWNS OR SMALL SECTIONS ***/
    use SoftDeletes;

    /**
    * BlogCategory -> BlogCategory belongsTO relation
    * 
    * @return BlogCategory
    */
    public function parent()
    {
        return $this->belongsTo(BlogCategory::class, 'parent_id', 'id');
    }

    /**
    * BlogCategory -> BlogCategory hasMany relation
    * 
    * @return BlogCategory
    */
    public function sub_categories()
    {
        return $this->hasMany(BlogCategory::class, 'parent_id', 'id');
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
    * BlogCategory -> Admins belongsTO relation
    * 
    * @return Admins
    */
    public function owner()
    {
        return $this->belongsTo(Admin::class, 'created_by', 'id');
    }

    /**
    * To search and get pagination listing
    * @param Request $request
    * @param $limit
    */

    public static function getListing(Request $request, $where = [])
    {
    	$orderBy = $request->get('sort') ? $request->get('sort') : 'blog_categories.id';
    	$direction = $request->get('direction') ? $request->get('direction') : 'desc';
    	$page = $request->get('page') ? $request->get('page') : 1;
    	$limit = self::$paginationLimit;
    	$offset = ($page - 1) * $limit;
    	
    	$listing = BlogCategory::select([
	    		'blog_categories.*',
                'owner.first_name as owner_first_name',
                'owner.last_name as owner_last_name',
                'parent.title as parent_title'
	    	])
            ->leftJoin('admins as owner', 'owner.id', '=', 'blog_categories.created_by')
            ->leftJoin('blog_categories as parent', 'parent.id', '=', 'blog_categories.parent_id')
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
    public static function getAll($select = [], $where = [], $orderBy = 'blog_categories.id desc', $limit = null)
    {
    	$listing = BlogCategory::orderByRaw($orderBy);

    	if(!empty($select))
    	{
    		$listing->select($select);
    	}
    	else
    	{
    		$listing->select([
    			'blog_categories.*'
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

        $listing->orderByRaw($orderBy);

	    $listing = $listing->get();

	    return $listing;
    }

    /**
    * To get all records
    * @param $where
    * @param $orderBy
    * @param $limit
    */
    public static function getAllCategorySubCategory($ids = [])
    {
        $listing = BlogCategory::select([
                'id',
                'parent_id',
                'title'
            ])
            ->whereNotNull('parent_id');

        if($ids)
        {
            $listing->whereIn('id', $ids);
        }

        $subCategories = $listing->get();

        $finalSubCategories = [];
        foreach ($subCategories as $key => $value) {
            $finalSubCategories[$value->parent_id][] = $value;
        }

        $listing = BlogCategory::select([
                'id',
                'parent_id',
                'title'
            ])
            ->whereNull('parent_id');
            
        if($ids)
        {
            $listing->whereIn('id', $ids);
            if(!empty(array_keys($finalSubCategories)))
            {
                $listing->orWhereIn('id', array_keys($finalSubCategories));
            }
        }

        $categories = $listing->get();
        foreach($categories as $key => $value)
        {
            if(isset($finalSubCategories[$value->id]) && $finalSubCategories[$value->id])
            {
                $categories[$key]->sub_categories = $finalSubCategories[$value->id];
            }
        }
        return $categories;
    }

    /**
    * To get single record by id
    * @param $id
    */
    public static function get($id)
    {
    	$record = BlogCategory::where('id', $id)
            ->with([
                'parent' => function($query) {
                    $query->select(['id', 'title']);
                },
                'owner' => function($query) {
                    $query->select(['id', 'first_name', 'last_name']);
                },
            ])
            ->first();

	    return $record;
    }

    /**
    * To get single row by conditions
    * @param $where
    * @param $orderBy
    */
    public static function getRow($where = [], $orderBy = 'blog_categories.id desc')
    {
    	$record = BlogCategory::orderByRaw($orderBy);
        $record->with([
            'parent' => function($query) {
                $query->select(['id', 'title']);
            }
        ]);
	    foreach($where as $query => $values)
	    {
	    	if(is_array($values))
                $listing->whereRaw($query, $values);
            elseif(!is_numeric($query))
                $listing->where($query, $values);
            else
                $listing->whereRaw($values);
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
    	$category = new BlogCategory();

    	foreach($data as $k => $v)
    	{
    		$category->{$k} = $v;
    	}

        $category->created_by = AdminAuth::getLoginId();
    	
        // In case of timestamp true from setting table, Disabled default timestamps will be false
        if(Setting::get('timestamps'))
        {
            $category->created_at = date('Y-m-d H:i:s');
            $category->updated_at = date('Y-m-d H:i:s');
        }

	    if($category->save())
	    {
            if(isset($data['title']) && $data['title'])
            {
                $category->slug = Str::slug($category->title) . '-' . General::encode($category->id);
                $category->save();
            }
	    	return $category;
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
    	$category = BlogCategory::find($id);
    	foreach($data as $k => $v)
    	{
    		$category->{$k} = $v;
    	}

    	// In case of timestamp true from setting table, Disabled default timestamps will be false
        if(Setting::get('timestamps'))
        {
            $category->updated_at = date('Y-m-d H:i:s');
        }
        
	    if($category->save())
	    {
            if(isset($data['title']) && $data['title'])
            {
                $category->slug = Str::slug($category->title) . '-' . General::encode($category->id);
                $category->save();
            }
	    	return $category;
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
    		return BlogCategory::whereIn('blog_categories.id', $ids)
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
    	$category = BlogCategory::find($id);
    	return $category->delete();
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
    		return BlogCategory::whereIn('blog_categories.id', $ids)
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
        $record = BlogCategory::select([
                DB::raw('COUNT(blog_categories.id) as count'),
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