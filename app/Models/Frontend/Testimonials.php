<?php

namespace App\Models\Frontend;

use App\Models\Admin\Testimonial as AdminTestimonial;
use Illuminate\Http\Request;

class Testimonials extends AdminTestimonial
{
    /**
    * To get all records
    * @param $where
    * @param $orderBy
    * @param $limit
    */
    public static function getAllFront($select = [], $where = [], $orderBy = 'testimonials.id desc', $limit = null)
    {
        $listing = Testimonials::orderByRaw($orderBy);

        if(!empty($select))
        {
            $listing->select($select);
        }
        else
        {
            $listing->select([
                'testimonials.*'
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

        return !empty($listing) ? $listing->toArray() : [];
    }
}