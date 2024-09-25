<?php

namespace App\Models\Frontend;

use App\Models\Admin\PageContent as AdminPageContent;
use Illuminate\Http\Request;

class PageContent extends AdminPageContent
{
	/**
	* @param $type
	* @param $name
	* @param $dataType ( image/data )
	* 
	**/

	public static function getRow($type , $name , $dataType)
	{
		$getRow = PageContent::select('data')->where(['type' => $type , 'name' => $name])->first();

		if($dataType == 'data')
		{
			$res = isset($getRow) && $getRow ? json_decode($getRow->data ,true) : [];
		}elseif($dataType == 'image'){
			$res = isset($getRow) && $getRow ? $getRow->data : [];
		}else{
			$res = [];
		}

		return $res;
	}

	/**
	* get all data where type = param type 
	* @param $type
	* 
	**/

	public static function getAllData($type)
	{
	    $data = PageContent::select('data','name')->where(['type' => $type])->get();
	    $getAll = [];

        if(!empty($data))
        {
		    foreach ($data as $key => $value) 
		    {
		        if (is_string($value->data) && isJson($value->data))
		        {
		            $decodedData = json_decode($value->data, true);
		            if ($decodedData !== null) 
		            {
		                $getAll[$value->name] = $decodedData;
		            }
		            else
		            {
		                $getAll[$value->name] = $value->data;
		            }
		        }
		        else
		        {
		            $getAll[$value->name] = $value->data;
		        }
		    }        	
        }

	    return $getAll;
	}   
}
