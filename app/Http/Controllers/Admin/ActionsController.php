<?php

/**
 *
 * @package    ActionsController
 * @copyright  2023
 * @author     Irfan Ahmad <irfan.ahmad@globiztechnology.com>
 * @version    Release: 1.0.0
 * @since      Class available since Release 1.0.0
 */

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

use App\Libraries\FileSystem;

use App\Models\Admin\Setting;
use App\Models\Admin\State;
use App\Models\Admin\City;

class ActionsController extends AppController
{
	function __construct()
	{
		parent::__construct();
	}

	/**
	* To Upload File
	* @param Request $request
	*/
    function uploadFile(Request $request)
    {
    	$data = $request->toArray();
    	$validator = Validator::make(
            $request->toArray(),
            [
                'path' => 'required',
                'file_type' => 'required',
                'file' => 'required',
            ]
        );

    	if(!$validator->fails())
	    {
	    	if($request->file('file')->isValid())
	    	{
	    		$file = null;
	    		if($data['file_type'] == 'image')
	    		{
		    		$file = FileSystem::uploadImage(
	    				$request->file('file'),
	    				$data['path']
	    			);

	    			if($file)
	    			{
	    				$originalName = FileSystem::getFileNameFromPath($file);
	    				
	    				if(isset($data['resize_large']) && $data['resize_large'])
	    				{
	    					FileSystem::resizeImage($file, 'L-' . $originalName, $data['resize_large']);
	    				}

	    				if(isset($data['resize_medium']) && $data['resize_medium'])
	    				{
	    					FileSystem::resizeImage($file, 'M-' . $originalName, $data['resize_medium']);
	    				}
	    				
	    				if(isset($data['resize_small']) && $data['resize_small'])
	    				{
	    					FileSystem::resizeImage($file, 'S-' . $originalName, $data['resize_small']);
	    				}
					}

					$errorMessage = "Please upload .jpg, .jpeg, .png, .gif files only.";
		    	}
		    	else if($data['file_type'] == 'svg')
		    	{
		    		$file = FileSystem::uploadFileSvg(
	    				$request->file('file'),
	    				$data['path']
	    			);

	    			$errorMessage = "Please upload .svg files only.";
		    	}
		    	else if($data['file_type'] == 'audio')
		    	{
		    		$file = FileSystem::uploadAudioFile(
	    				$request->file('file'),
	    				$data['path']
	    			);

	    			$errorMessage = "Please upload .mp3 files only.";
		    	}
		    	else if($data['file_type'] == 'video')
		    	{
		    		$file = FileSystem::uploadVideoFile(
	    				$request->file('file'),
	    				$data['path']
	    			);

		    		if($file)
		    		{
	    				$thumbnail = FileSystem::saveThumbnail($file, $data['path']);
		    			
	    				if($thumbnail)
	    				{
	    					$filename = FileSystem::getFileNameFromPath($thumbnail);
	    					
	    					FileSystem::resizeImage($thumbnail, $filename, $data['resize_large']);
	    					
	    					if(isset($data['resize_medium']) && $data['resize_medium'])
	    					{
	    						FileSystem::resizeImage($thumbnail, 'M-' . $filename, $data['resize_medium']);
	    					}
	    					
	    					if(isset($data['resize_small']) && $data['resize_small'])
	    					{
	    						FileSystem::resizeImage($thumbnail, 'S-' . $filename, $data['resize_small']);
	    					}
	    				}
		    		}

		    		$errorMessage = "Please upload .mp4, .avi, .flv, .mov files only.";
		    	}
		    	else if($data['file_type'] == 'files')
		    	{
	    			$ext = $request->file('file')->extension();

					if(in_array(strtolower($ext), ['jpg', 'jpeg', 'png']))
					{
			    		$file = FileSystem::uploadImage(
		    				$request->file('file'),
		    				$data['path']
		    			);
		    			if($file)
		    			{
		    				$originalName = FileSystem::getFileNameFromPath($file);

		    				if(isset($data['resize_large']) && $data['resize_large'])
		    				{
		    					FileSystem::resizeImage($file, 'L-' . $originalName, $data['resize_large']);
		    				}
		    				
		    				if(isset($data['resize_medium']) && $data['resize_medium'])
		    				{
		    					FileSystem::resizeImage($file, 'M-' . $originalName, $data['resize_medium']);
		    				}
		    				
		    				if(isset($data['resize_small']) && $data['resize_small'])
		    				{
		    					FileSystem::resizeImage($file, 'S-' . $originalName, $data['resize_small']);
		    				}
						}
					}
					elseif(in_array(strtolower($ext), ['svg']))
					{
			    		$file = FileSystem::uploadFileSvg(
		    				$request->file('file'),
		    				$data['path']
		    			);
					}
					elseif(in_array(strtolower($ext), ['pdf', 'docx']))
					{
			    		$file = FileSystem::uploadFile(
		    				$request->file('file'),
		    				$data['path']
		    			);
					}
					elseif(in_array(strtolower($ext), ['mp3']))
					{
			    		$file = FileSystem::uploadAudioFile(
		    				$request->file('file'),
		    				$data['path']
		    			);
					}
					elseif(in_array(strtolower($ext), ['mp4', 'avi', 'flv', 'mov']))
					{
			    		$file = FileSystem::uploadVideoFile(
		    				$request->file('file'),
		    				$data['path']
		    			);

			    		if($file)
			    		{
		    				$thumbnail = FileSystem::saveThumbnail($file, $data['path']);
			    			
		    				if($thumbnail)
		    				{
		    					$filename = FileSystem::getFileNameFromPath($thumbnail);
		    					
		    					FileSystem::resizeImage($thumbnail, $filename, $data['resize_large']);
		    					
		    					if(isset($data['resize_medium']) && $data['resize_medium'])
		    					{
		    						FileSystem::resizeImage($thumbnail, 'M-' . $filename, $data['resize_medium']);
		    					}
		    					
		    					if(isset($data['resize_small']) && $data['resize_small'])
		    					{
		    						FileSystem::resizeImage($thumbnail, 'S-' . $filename, $data['resize_small']);
		    					}
		    				}
			    		}
					}
		    	}
		    	else
		    	{
		    		$file = FileSystem::uploadFile(
	    				$request->file('file'),
	    				$data['path']
	    			);
		    	}

    			if($file)
    			{
    				$names = explode('/', $file);

    				if($data['file_type'] == 'video' || $data['file_type'] == 'files')
    				{
						return Response()->json([
					    	'status' => 'success',
					    	'message' => 'File uploaded successfully.',
					    	'url' => url($file),
					    	'name' => end($names),
					    	'path' => $file,
					    	'thumbnail' => isset($thumbnail) && $thumbnail ? $thumbnail : '',
					    	'thumbnail_url' => isset($thumbnail) && $thumbnail ? url($thumbnail) : ''
					    ]);
    				}
    				else
    				{
						return Response()->json([
					    	'status' => 'success',
					    	'message' => 'File uploaded successfully.',
					    	'url' => url($file),
					    	'name' => end($names),
					    	'path' => $file
					    ]);
				    }
    			}
    			else
    			{
    				return Response()->json([
				    	'status' => 'error',
				    	'message' => $errorMessage ? $errorMessage : 'File could not be upload.'
				    ]);		
    			}
	    	}
	    	else
	    	{
	    		return Response()->json([
			    	'status' => 'error',
			    	'message' => 'File could not be uploaded.'
			    ]);	
	    	}
	   	}
	    else
	    {
	    	return Response()->json([
		    	'status' => 'error',
		    	'message' => 'File could not be uploaded due to missing parameters.'
		    ]);	
	    }
    }

    /**
	* To Remove File
	* @param Request $request
	*/
    function removeFile(Request $request)
    {
    	$data = $request->toArray();
    								
    	$validator = Validator::make(
            $request->toArray(),
            [
                'file' => 'required',
            ]
        );

    	if(!$validator->fails())
	    {
	    	if(isset($data['relation']) && $data['relation'])
	    	{
	    		$relation = explode('.', $data['relation']);
	    		if(count($relation) > 1 && $relation[0] == 'settings')
	    		{
	    			// In case of settings table
	    			if(Setting::put($relation[1], ""))
					{
						FileSystem::deleteFile($data['file']);
						return Response()->json([
					    	'status' => 'success',
					    	'message' => 'File removed successfully.'
					    ]);
					}
					else
					{
						return Response()->json([
					    	'status' => 'error',
					    	'message' => 'File could not be removed.'
					    ]);  		
					}
	    		}
	    		else if(count($relation) > 1 && isset($data['id']) && $data['id'])
	    		{
	    			// In case of other tables
	    			$record = DB::table($relation[0])
			            ->select([
			            	$relation[1]
			            ])
			            ->where('id', $data['id'])
			            ->limit(1)
			            ->first();

			        if($record && $record->{$relation[1]})
			        {
			        	$file = $record->{$relation[1]};
			        	$multiple = json_decode($file, true);
						$allFiles = $multiple && is_array($multiple) ? $multiple : ($file ? [$file] : null);
						
						$index = array_search($data['file'], $allFiles);
						if($index !== false && isset($allFiles[$index]) && $allFiles[$index])
						{
							unset($allFiles[$index]);
							$allFiles = array_values($allFiles);
							$allFiles = !empty($allFiles) ? json_encode($allFiles) : "";
							
							$updated  = DB::table($relation[0])
							->where('id', $data['id'])
							->update([
								"{$relation[1]}" => $allFiles
							]);

							if(isset($data['relationThumbnail']) && $data['relationThumbnail'])
							{
								$thumbnail = explode('.', $data['relationThumbnail']);

								// In case of other tables
				    			$reacordThumbnail = DB::table($thumbnail[0])
						            ->select([
						            	$thumbnail[1]
						            ])
						            ->where('id', $data['id'])
						            ->limit(1)
						            ->first();

						        if($reacordThumbnail && $reacordThumbnail->{$thumbnail[1]})
						        {
						        	$fileThumbnail = $reacordThumbnail->{$thumbnail[1]};
						        	$multipleThumbnail = json_decode($fileThumbnail, true);
									$allFilesThumbnail = $multipleThumbnail && is_array($multipleThumbnail) ? $multipleThumbnail : ($fileThumbnail ? [$fileThumbnail] : null);
									
									$indexThumbnail = array_search($data['thumbnail'], $allFilesThumbnail);
									
									if($indexThumbnail !== false && isset($allFilesThumbnail[$indexThumbnail]) && $allFilesThumbnail[$indexThumbnail])
									{
										unset($allFilesThumbnail[$indexThumbnail]);
										$allFilesThumbnail = array_values($allFilesThumbnail);
										$allFilesThumbnail = !empty($allFilesThumbnail) ? json_encode($allFilesThumbnail) : "";

										$updatedThumbnail  = DB::table($thumbnail[0])
										->where('id', $data['id'])
										->update([
											"{$thumbnail[1]}" => $allFilesThumbnail
										]);
									}
								}
							}

							if($updated)
							{
								FileSystem::deleteFile($data['file']);
								return Response()->json([
							    	'status' => 'success',
							    	'message' => 'File removed successfully.'
							    ]);
							}
							else
							{
								return Response()->json([
							    	'status' => 'error',
							    	'message' => 'File could not be removed.'
							    ]);  		
							}
						}
						else
						{
							return Response()->json([
						    	'status' => 'error',
						    	'message' => 'File could not be removed.'
						    ]);  
						}
			        }
			    }
			    else
			    {
			 		return Response()->json([
				    	'status' => 'error',
				    	'message' => 'Relation is missing or invalid.'
				    ]);   	
			    }
	    	}
	    	elseif(FileSystem::deleteFile($data['file']))
    		{
    			return Response()->json([
			    	'status' => 'success',
			    	'message' => 'File removed successfully.'
			    ]);
    		}
    		else
    		{
	    		return Response()->json([
			    	'status' => 'error',
			    	'message' => 'File could not be removed.'
			    ]);
	    	}
	    }
	    else
	    {
	    	return Response()->json([
		    	'status' => 'error',
		    	'message' => 'File parameter is missing.'
		    ]);
	    }
    }

    /**
	* Switch Button like status
	* @param Request $request
	* @param $table
	* @param $field
	* @param $id
	*/
    function switchUpdate(Request $request, $table, $field, $id)
    {
    	$data = $request->toArray();

    	$validator = Validator::make(
            $request->toArray(),
            [
                'flag' => 'required'
            ]
        );

    	if(!$validator->fails())
	    {
	    	$updated  = DB::table($table)
				->where('id', $id)
				->update([
					"{$field}" => $request->get('flag')
				]);
			
	    	if($updated)
	    	{
	    		if($request->get('flag') == 1)
	    		{
		    		return Response()->json([
				    	'status' => 'success',
				    	'message' => '<b> Record has been marked as "Active". </b>'
				    ]);
	    		}
	    		else
	    		{
	    			return Response()->json([
				    	'status' => 'error',
				    	'message' => 'Record has been marked as "Inactive".'
				    ]);
	    		}
	    	}
	    	else
	    	{
	    		return Response()->json([
			    	'status' => 'error',
			    	'message' => 'Record could not be update.'
			    ]);		
	    	}
	    	
	    }
	    else
	    {
	    	return Response()->json([
		    	'status' => 'error',
		    	'message' => 'Record could not be update.'
		    ]);
	    }
    }

    /**
	* To Media Sort
	* @param Request $request
	*/
    function mediaSort(Request $request)
    {
    	$data = $request->toArray();
    								
    	$validator = Validator::make(
            $request->toArray(),
            [
                'paths' => 'required',
                'relation' => 'required',
                'id' => 'required',
            ]
        );

    	if(!$validator->fails())
	    {
	    	$relation = explode('.', $data['relation']);
	    	$paths = json_encode($data['paths']);
	    	$id = $data['id'];

    		if(count($relation) > 1 && $relation[0] == 'settings')
    		{
    			// In case of settings table
    			if(Settings::put($relation[1], $paths))
				{
					FileSystem::deleteFile($data['file']);
					return Response()->json([
				    	'status' => 'success',
				    	'message' => 'Sort updated successfully.'
				    ]);
				}
				else
				{
					return Response()->json([
				    	'status' => 'error',
				    	'message' => 'Sort could not be updated.'
				    ]);  		
				}
    		}
			elseif(count($relation) > 1 && $relation[0] == 'page_custom_field')
    		{
    			$update = DB::table($relation[0])->where('name',$relation[1])->where('page_id',$id)->update(['value' => $paths]);

    			if($update)
    			{
    				return Response()->json([
				    	'status' => 'success',
				    	'message' => 'Sort updated successfully.'
				    ]);
    			}
    			else
    			{
    				return Response()->json([
				    	'status' => 'error',
				    	'message' => 'Sort could not be updated.'
				    ]);
    			}									
    		}
    		elseif(count($relation) > 1 && $relation[0])
    		{
    			$update = DB::table($relation[0])->where('id',$id)->update([$relation[1] => $paths]);

    			if($update)
    			{
    				return Response()->json([
				    	'status' => 'success',
				    	'message' => 'Sort updated successfully.'
				    ]);
    			}
    			else
    			{
    				return Response()->json([
				    	'status' => 'error',
				    	'message' => 'Sort could not be updated.'
				    ]);
    			}									
    		}
	    }
	    else
	    {
	    	return Response()->json([
		    	'status' => 'error',
		    	'message' => 'File could not be uploaded due to missing parameters.'
		    ]);	
	    }	    	
    }

    /**
	* Switch Button like status it works on custom table
	* @param Request $request
	* @param $table
	* @param $field
	* @param $id
	*/
    function customPageSwitchUpdate(Request $request, $table, $field, $id)
    {
    	$data = $request->toArray();

    	$validator = Validator::make(
            $request->toArray(),
            [
                'flag' => 'required'
            ]
        );

    	if(!$validator->fails())
	    {
	    	$getPage =  DB::table($table)
			->where('name', $field)
			->where('page_id', $id)
			->first();

	    	if(isset($getPage) && $getPage)
	    	{
	    		$updated = DB::table($table)
				->where('name', $field)
				->where('page_id', $id)
				->update([
					"value" => $request->get('flag')
				]);
	    	}
	    	else
	    	{
	    		$insertData['page_id'] = $id;
	    		$insertData['name'] = $field;
	    		$insertData['value'] = $request->get('flag');
	    		$updated = DB::table($table)->insert($insertData);
	    	}

	    	if($updated)
	    	{
	    		return Response()->json([
			    	'status' => 'success',
			    	'message' => 'Record updated successfully.'
			    ]);	
	    	}
	    	else
	    	{
	    		return Response()->json([
			    	'status' => 'error',
			    	'message' => 'Record could not be update.'
			    ]);		
	    	}
	    }
	    else
	    {
	    	return Response()->json([
		    	'status' => 'error',
		    	'message' => 'Record could not be update.'
		    ]);
	    }
    }

    function getStatesByCountryId(Request $request, $country_id)
    {
    	$select = [
    		'states.id',
    		'states.name'
    	];
    	$where['states.status = ?'] = [1];
    	$where['states.country_id = ?'] = [$country_id];
    	
    	$order = 'states.name asc';
    	$states = State::getAll($select, $where, $order);
    	
	    $html = view(
    		"admin/actions/getStates", 
    		[
    			'states' => $states
    		]
    	)->render();

    	return Response()->json([
	    	'status' => 'success',
	    	'html' => $html
	    ]);
    }

    function getCitiesByStateId(Request $request, $state_id)
    {
    	$select = [
    		'cities.id',
    		'cities.name'
    	];
    	$where['cities.status = ?'] = [1];
    	$where['cities.state_id = ?'] = [$state_id];
    	
    	$order = 'cities.name asc';
    	$cities = Cities::getAll($select, $where, $order);
    	
	    $html = view(
    		"admin/actions/getCities", 
    		[
    			'cities' => $cities
    		]
    	)->render();

    	return Response()->json([
	    	'status' => 'success',
	    	'html' => $html
	    ]);
    }
}
