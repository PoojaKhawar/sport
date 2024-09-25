<?php

/**
 * pageContent Class
 *
 * @package    PageContentController
 * @copyright  2024 Globiz Technology Inc..
 * @author     Irfan Ahmad <irfan.ahmad@globiztechnology.com>
 * @version    Release: 1.0.0
 * @since      Class available since Release 1.0.0
 */

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Models\Admin\PageContent;
use App\Libraries\FileSystem;


class PageContentController extends AppController
{
    function __construct()
    {
        parent::__construct();
    }

    function index(Request $request , $type)
    {
        if($request->isMethod('post'))
        {
            $data = $request->all();
            unset($data['_token']);
            $record = []; 
            foreach($data as $key =>  $d )
            {
                $type = $type;
                $data = [];
                if($key == 'data')
                {
                    foreach($d as $k => $val)
                    {
                        $name = $k;
                        $data = isset($val) && $val ? json_encode($val) : null;      
                    }
                    
                    $response = PageContent::put($type, $name, $data);
                }
                elseif($key == 'image')
                {
                    foreach($d as $k => $val)
                    {
                        $name = $k;
                        $image = PageContent::getData($type, $name, 'image');
                        $oldImage = isset($image->data) && $image->data ? $image->data : null;

                        if(isset($val) && isJson($val))
                        {
                            if(isset($val) && $val)
                            {
                                $val = json_decode($val, true);
                                $oldImage = $oldImage ? json_decode($oldImage) : [];
                                $data = array_merge($oldImage, $val);
                                $data = json_encode($data);
                            }
                        }
                        else
                        {
                            if(isset($val) && $val)
                            {
                                if($oldImage)
                                {    
                                    FileSystem::deleteFile($oldImage);
                                };
                                
                                $data = isset($val) && $val ? $val : null;
                            }
                            else
                            {
                                $data = isset($oldImage) && $oldImage ? $oldImage : null;
                            }

                        }

                        $response = PageContent::put($type, $name, $data);
                    }
                }
                elseif($key == 'json') 
                { 
                    foreach($d as $k => $row) {
                        $encondData = json_encode($row);
                        $response = PageContent::put($type, $k, $encondData);
                    }
                }
            }

            if($response)
            {
                return  redirect()->back()->with('success','Data Updated Successfully');
            }
            else
            {
                return back()->with('success','SomeThing Error');
            }
        }
    } 

}
