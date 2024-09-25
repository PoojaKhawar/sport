<?php

/**
 * Page Class
 *
 * @package    PagesController
 * @copyright  2023 Globiz Technology Inc..
 * @author     Irfan Ahmad <irfan.ahmad@globiztechnology.com>
 * @version    Release: 1.0.0
 * @since      Class available since Release 1.0.0
 */

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Frontend\Page;


class PagesController extends Controller
{
    function index(Request $request , $slug)
    {
        $pages = Page::where('slug' , $slug)->select('title','description','image')->first();

        if(!empty($pages)) 
        {
            $meta = [
                'meta_title' => $pages->meta_title ??  'Pages',
                'meta_keywords' => $pages->meta_keywords ??  'Pages',
                'meta_description' => $pages->meta_description ??  'Pages',
                'image' => $pages->image ??  '',
            ];

            return view(
                "frontend.pages.index",
                [
                    'page' => $pages,
                    'meta' => $meta
                ]
            );

        } else {
            return view('errors.404');
        }
    }
}