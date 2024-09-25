<?php

/**
 * Home Class
 *
 * @package    HomeController
 * @copyright  2023 Globiz Technology Inc..
 * @author     Irfan Ahmad <irfan.ahmad@globiztechnology.com>
 * @version    Release: 1.0.0
 * @since      Class available since Release 1.0.0
 */

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\Frontend\PageContent;
use App\Models\Frontend\Testimonials;
use App\Models\Frontend\Faq;


class HomeController extends Controller
{
    function index(Request $request)
    {   
        $limit = $request->has('viewAll') ? null : 3;

        $pageContent = PageContent::getAllData('home');

        $faq = Faq::getAllFront([
                'faqs.id',
                'faqs.title',
                'faqs.description',
            ],[
                'faqs.status' => 1
            ],
            'faqs.id desc',
            $limit
        );

        $testimonials = Testimonials::getAllFront([
                'testimonials.id',
                'testimonials.title',
                'testimonials.description',
                'testimonials.designation',
            ],[
                'testimonials.status' => 1
            ]);
        
        $meta = [
            'meta_title' => $pageContent['meta']['title'] ?? 'Homepage',
            'meta_keywords' => $pageContent['meta']['keywords'] ?? 'Homepage',
            'meta_description' => $pageContent['meta']['description'] ??'Homepage',
        ];

        return view(
            "frontend.home.index",
            [
                'meta' => $meta ,
                'data' => $pageContent,
                'faq' => $faq,
                'testimonials' => $testimonials
            ]
        );
    }
}