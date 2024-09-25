<?php

/**
 * ContactUs Class
 *
 * @package    ContactUsController
 * @copyright  2023
 * @author     Irfan Ahmad <irfanahmed1555@gmail.com>
 * @version    Release: 1.0.0
 * @since      Class available since Release 1.0.0
 */


namespace App\Http\Controllers\Frontend;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Frontend\PageContent;
use App\Models\Admin\ContactUs;
use App\Models\Admin\Setting;
use Illuminate\Http\Request;
use App\Libraries\General;


class ContactUsController extends Controller
{
    function index(Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $data = $request->except('_token');
            
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'company_name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phonenumber' => 'required|digits_between:10,14',
                'message' => 'required|string',
                'subject' => 'required|string|max:255',                 
            ]);

            if (!$validator->fails()) 
            {
                if(Setting::get('frontend_recaptcha'))
                {
                    if(!$request->get('g-recaptcha-response') || !General::validateReCaptcha( $request->get('g-recaptcha-response') ))
                    {
                        $request->session()->flash('error', 'Captcha does not match. Please try again.');
                        return redirect()->back()->withInput();
                    }
                }

                unset($data['g-recaptcha-response']);
                $contactUs = ContactUs::create($data);

                if ($contactUs)
                {

                    $codes = [
                        '{first_name}' => $data['first_name'],
                        '{last_name}' => $data['last_name'],
                        '{email}' => $data['email'],
                        '{phonenumber}' => $data['phonenumber'],
                        '{company_name}' => $data['company_name'],
                        '{country}' => $data['country'],
                        '{subject}' => $data['subject'],
                        '{message}' => $data['message'],
                    ];
                    
                    General::sendTemplateEmail($data['email'], 'client-contact-request', $codes);


                    $adminEmail = Setting::get('admin_notification_email');
                    if($adminEmail)
                    {
                        General::sendTemplateEmail($adminEmail, 'admin-contact-request', $codes);
                    }

                    return Response()->json([
                        'status' => 'success',
                        'message' => 'Thank you for submitting your queries.',
                    ]);
                }
                else
                {
                    return Response()->json([
                        'status' => 'error',
                        'message' => 'Contact-Us could not be saved. Please try again.',
                    ]);
                }
            }    
            else
            {
                return Response()->json([
                    'status' => 'error',
                    'message' => current( current( $validator->errors()->getMessages() ) ),
                ]);
            }    
        }

        $type = 'contact_us';
        $pageContent = PageContent::getAllDecodedData($type);
        $content = $pageContent['content'] ?? [];
        $meta = $pageContent['metaTag'] ?? [];

        $meta = [
                'meta_title' => $meta['meta_title'] ?? 'Groot ERP Technologies' ,
                'meta_description' => $meta['meta_description'] ?? 'Groot ERP Technologies' ,
                'meta_keywords' =>  $meta['meta_keywords'] ?? 'Groot ERP Technologies' ,
        ];

        return view(
            "frontend.contactUs.index",
            [
                'content' => $content,
                'meta' => $meta
                
            ]
        );
    }
}