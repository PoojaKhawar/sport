<?php
namespace App\Libraries;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use App\Models\Admin\Setting;
use App\Models\Admin\EmailTemplate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use App\Libraries\SendGrid;
use App\Mail\MyMail;
use App\Models\Admin\EmailLog;
use Hashids\Hashids;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

class General
{
	/** 
	* To make random hash string
	*/	
	public static function hash($limit = 32)
	{
		return Str::random($limit);
	}

	/** 
	* To make random number
	*/	
	public static function randomNumber($limit = 8)
	{
		$characters = '0123456789';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $limit; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}

	/** 
	* To encrypt
	*/
	public static function encrypt($string)
	{
		return Crypt::encryptString($string);
	}

	/** 
	* To decrypt
	*/
	public static function decrypt($string)
	{
		return Crypt::decryptString($string);
	}

	/** 
	* To encode
	*/
	public static function encode($string)
	{
		$hashids = new Hashids(config('app.key'), 6);
		return $hashids->encode($string);
	}

	/** 
	* To decode
	*/
	public static function decode($string)
	{
		$hashids = new Hashids(config('app.key'), 6);
		return current($hashids->decode($string));
	}

	/** 
	* Url to Anchor Tag
	* @param 
	*/
	public static function urlToAnchor($url)
	{
		return '<a href="' . $url . '" target="_blank">'.$url.'</a>';
	}

	/**
	* To validate the captcha
	* @param $token 
	**/
	public static function validateReCaptcha($token)
	{
		$data = [
			'secret' => Setting::get('recaptcha_secret'),
			'response' => $token,
			'remoteip' => $_SERVER['REMOTE_ADDR']
		];

		$response = Http::asForm()
			->post(
				'https://www.google.com/recaptcha/api/siteverify',
				$data
			);
			
		return $response->successful() && $response->json() && isset($response->json()['success']) && $response->json()['success'];
	}

	/**
	* To send template email
	**/
	public static function sendTemplateEmail($to, $template, $shortCodes = [], $attachments = [], $cc = null, $bcc = null)
	{	
		$template = EmailTemplate::getRow([
				'slug LIKE ?', [$template]
			]);

		if($template)
		{
			$shortCodes = array_merge($shortCodes, [
				'{company_name}' => Setting::get('company_name'),
				'{admin_link}' => General::urlToAnchor(url('/admin')),
				'{website_link}' => General::urlToAnchor(url('/'))
			]);
			$subject = $template->subject;
			$message = $template->description;
			$subject = str_replace (
				array_keys($shortCodes), 
				array_values($shortCodes), 
				$subject
			);

			$message = str_replace (
				array_keys($shortCodes), 
				array_values($shortCodes), 
				$message
			);

			return General::sendEmail(
				$to,
				$subject,
				$message,
				$cc,
				$bcc,
				$attachments,
				$template->slug
			);
		}
		else
		{
			throw new \Exception("Tempalte could be found.", 500);
		}
	}

	/**
	* To send email
	**/
	public static function sendEmail($to, $subject, $message, $cc = null, $bcc = null, $attachments = [], $slug = null, $from = null, $username = null)
	{
		$from = $from ? $from : Setting::get('from_email');
		$emailMethod = Setting::get('email_method');

		// Block Email Addresses
		$blockEmailDomains = Setting::get('block_email_domains');

		$sent = false;

		if($blockEmailDomains)
		{
			if($to && is_array($to))
			{
				foreach ($to as $key => $toValue)
				{
					$array =  explode(',', $blockEmailDomains);	
					$check = explode('@', $toValue);		

					if(in_array($check[1],$array))
					{
						unset($to[$key]);
					}	
				}
				$to = array_values($to);

				if (count($to) < 1) 
				{
					return true;	
				}
			}
			else
			{
				$array =  explode(',', $blockEmailDomains);	
				$check = explode('@', $to);		

				if(in_array($check[1],$array))
				{
					return true;
				}
			}
		}

		$log = EmailLog::create([
			'slug' => $slug,
			'subject' => $subject,
			'description' => $message,
			'from' => $from,
			'to' => $to && is_array($to) ? json_encode($to) : $to,
			'cc' => $cc && is_array($cc) ? json_encode($cc) : $cc,
			'bcc' => $bcc,
			'open' => 0,
			'sent' => 0
		]);

		if($log)
		{	
			if($emailMethod == 'smtp')
			{

				//$company = Setting::get('company_name');

				if(isset($username) && $username)
				{
					$company = $username;
				}
				else
				{
					$company = 'Globiz Technology';
				}
				
				/** OVERWRITE SMTP SETTIGS AS WE HAVE IN DB. CHECK config/mail.php **/
				$password = Setting::get('smtp_password');
				
				//$password = $password ? General::decrypt($password) : "";
				
				config([
					'mail.mailers.smtp.host' => Setting::get('smtp_host'),
					'mail.mailers.smtp.port' => Setting::get('smtp_port'),
					'mail.mailers.smtp.encryption' => Setting::get('smtp_encryption'),
					'mail.mailers.smtp.username' => Setting::get('smtp_username'),
					'mail.mailers.smtp.password' => $password,
				]);
				/** OVERWRITE SMTP SETTIGS AS WE HAVE IN DB. CHECK config/mail.php **/

				$mail = Mail::mailer('smtp')
					->to($to);

				if($cc)
				{
				    if(is_array($cc))
				    {
				        $mail->cc($cc);
				    }
				    else
				    {
				    	$mail->cc($cc);
				    }
			    }

				/*if($cc)
					$mail->cc($cc);*/
				if($bcc)
					$mail->bcc($bcc);
				try
				{
					$mail->send( 
						new MyMail($from, $company, $subject, $message, $attachments, $slug) 
					);
					$sent = true;
				}
				catch(\Exception $e)
				{
					$sent = false;
				}
			}
			else if($emailMethod == 'sendgrid')
			{
				$message = view(
		    		"mail", 
		    		[
		    			'content' => $message
		    		]
		    	)->render();

				$sent = SendGrid::sendEmail(
					$to,
					$subject,
					$message,
					$cc,
					$bcc,
					$attachments
				);

			}
			else
			{
				throw new \Exception("Email method does not exist.", 500);	
			}

			// Create email log
			if($sent && $log && $log->id)
			{
				$log->sent = 1;
				$log->save();
			}

			return $sent;
		}
		else
		{
			throw new \Exception("Not able to make email log.", 500);
		}
	}

	/**
	* Render Image if no image it will be show default image
	**/
	public static function renderImage($array, $key) {
		return isset($array) && isset($array[$key]) && $array[$key] && file_exists(public_path($array[$key])) ? url($array[$key]) : url('admin/assets/img/no_image.jpg') ;
	}

	/**
	* Render Profile Image if no image it will be show default user image
	**/
	public static function renderProfileImage($array, $key) {
		return isset($array) && isset($array[$key]) && $array[$key] && file_exists(public_path($array[$key])) ? url($array[$key]) : url('admin/assets/img/noprofile.png') ;
	}

	public static function renderImageUrl($image, $size, $noImage = null)
    {
		$image = FileSystem::getAllSizeImages($image);
		
		if(isset($image) && $image && isset($image[$size]) && $image[$size])
		{
		    return url($image[$size]);
		}
		else
		{
			if(isset($noImage) && $noImage)
			{
				return url($noImage);
			}
			else
			{
				return url('/admin/assets/img/noprofile.png');
			}
		}
    }

    // 
    public static function geolocationAPI($loginIp)
    {
    	/*if(isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] != 'localhost' || $_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] != '127.0.0.1:8000')
    	{*/
	    	$geolocation_api = Setting::get('geolocation_api');
	    	
	    	$httpClient = new \GuzzleHttp\Client();
	        $request =
	            $httpClient
	                ->get("https://api.geoapify.com/v1/ipinfo?apiKey={$geolocation_api}&ip={$loginIp}");

	        $response = json_decode($request->getBody()->getContents());

	        return $response;
        /*}
        else
        {
        	return true;
        }*/
    }

	public static function pagination($request,$array, $limit = 10)
	{
		$listing = [];
		if(isset($request) && $request)
		{
			$total = count($array);
			$per_page = $limit;
			$current_page = $request->input("page") ?? 1;
			$starting_point = ($current_page * $per_page) - $per_page;
			$array = array_slice($array, $starting_point, $per_page, true);
	    	$listing = new Paginator($array, $total, $per_page, $current_page, [
	            'path'  => $request->url(),
	            'query' => $request->query(),
	            'total' => $total,
	            'currentPage' => $current_page,
	            'perPage' => $per_page,
	        ]);
		}

		return $listing;
	}
}