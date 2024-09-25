<?php

/**
 * Actions Class
 *
 * @package    ActionsController
 * @copyright  2023
 * @author     Irfan Ahmad <irfan.ahmad@globiztechnology.com>
 * @version    Release: 1.0.0
 * @since      Class available since Release 1.0.0
 */


namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\Admin\Setting;
use App\Libraries\FileSystem;
use App\Models\Admin\States;
use App\Models\Admin\Cities;
use App\Models\Admin\PostalCodes;
use Session;

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
	* To Upload File
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

    function convertLanguage(Request $request, $slug)
    {
        $allLangs = Language::getAll();;
        $results = array_filter($allLangs, function($item) use ($slug) {
            return $item['short_code'] == $slug;
        });

        if(!empty($results)) {
            $request->session()->put('language', $slug);
        }
        return redirect()->back();
    }

    /**
    * To Video Streaming
    * @param Request $request
    */
    function videoStreaming(Request $request)
    {
    
        if($request->isMethod('get') && isset($_SERVER['HTTP_REFERER']))
        {
            $data = $request->toArray();

            $filePath = isset($data['path']) && $data['path'] ? General::decrypt($data['path']) : false;
            if($filePath)
            {
                $stream = new VideoStream(public_path($filePath));
                $stream->start();
            }
            else
            {
                abort(404);
            }           
        }
        else
        {
            abort(404);
        }
    }


    /**
	* To Upload File
	* @param Request $request
	*/
    function cropperUploadFile(Request $request)
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
	    				
	    				FileSystem::resizeImage($file, $originalName, $data['resize_large']);
	    				
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
					elseif(in_array(strtolower($ext), ['pdf','docx']))
					{
			    		$file = FileSystem::uploadFile(
		    				$request->file('file'),
		    				$data['path']
		    			);
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
			    	return Response()->json([
			        	'status' => 'success',
			        	'message' => 'File uploaded successfully.',
			        	'url' => url($file),
			        	'name' => end($names),
			        	'path' => $file
			        ]);
    			}
    			else
    			{
    				return Response()->json([
				    	'status' => 'error',
				    	'message' => 'File could not be upload.'
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
    function cropperRemoveFile(Request $request)
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
	    	$getDeleteFile = json_decode($data['file'], true);
	    	
	    	if(isset($data['relation']) && $data['relation'])
	    	{
	    		$relation = explode('.', $data['relation']);
	    		
	    		if(count($relation) > 1 && isset($data['id']) && $data['id'])
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
						
						$searchFiles = [];
						foreach($allFiles as $k => $v)
						{
							$searchFiles[$k] = $v['path'];
						}

						$index = array_search($getDeleteFile['path'], $searchFiles);
						
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

							if($updated)
							{
								FileSystem::deleteFile($getDeleteFile['path']);
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
	    	elseif(FileSystem::deleteFile($getDeleteFile['path']))
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

    function getStatesByCountryId(Request $request, $countryId)
    {
    	$select = [
    		'states.id',
    		'states.name'
    	];
    	$where['states.status = ?'] = [1];
    	$where['states.country_id = ?'] = [$countryId];
    	
    	$order = 'states.name asc';
    	$states = States::getAll($select, $where, $order);
    	
	    $html = view(
    		"frontend/actions/getStates", 
    		[
    			'states' => $states
    		]
    	)->render();

    	return Response()->json([
	    	'status' => 'success',
	    	'html' => $html
	    ]);
    }

    function getCitiesByStateId(Request $request, $stateId)
    {
    	$select = [
    		'cities.id',
    		'cities.name'
    	];
    	$where['cities.status = ?'] = [1];
    	$where['cities.state_id = ?'] = [$stateId];
    	
    	$order = 'cities.name asc';
    	$cities = Cities::getAll($select, $where, $order);
    	
	    $html = view(
    		"frontend/actions/getCities", 
    		[
    			'cities' => $cities
    		]
    	)->render();

    	return Response()->json([
	    	'status' => 'success',
	    	'html' => $html
	    ]);
    }

    function getPostalCodesByCityId(Request $request, $cityId)
    {
    	$select = [
    		'postal_codes.id',
    		'postal_codes.name'
    	];
    	$where['postal_codes.status = ?'] = [1];
    	$where['postal_codes.city_id = ?'] = [$cityId];
    	
    	$order = 'postal_codes.name asc';
    	$postalCodes = PostalCodes::getAll($select, $where, $order);
    	
	    $html = view(
    		"frontend/actions/getPostalCodes", 
    		[
    			'postalCodes' => $postalCodes
    		]
    	)->render();

    	return Response()->json([
	    	'status' => 'success',
	    	'html' => $html
	    ]);
    }
}
