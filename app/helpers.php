<?php
use App\Models\Admin\Setting;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

function _dt($datetime)
{
	$dateFormat = Setting::get('date_format');
	$timeFormat = Setting::get('time_format');

	return date($dateFormat . ' ' . $timeFormat, strtotime($datetime));
}

function _d($date)
{
	$dateFormat = Setting::get('date_format');
	return date($dateFormat, strtotime($date));
}

function _time($time)
{
	$timeFormat = Setting::get('time_format');
	return date($timeFormat, strtotime($time));
}

function timeAgo($time)
{
	$date = new Carbon($time);
    return $date->diffForHumans();
}

function priceFormat($amount)
{
	$currencySymbol = Setting::get('currency_symbol');
    $amount = floatval(str_replace(",","",$amount));
	return $currencySymbol.''.number_format($amount, 2, '.', '');
}

function amountFormat($amount)
{
    $amount = floatval(str_replace(",","",$amount));
    return number_format($amount, 2, '.', '');
}

/*function sanitizePhone($phone)
{
    $number = explode('-', $phone, 2);
    $number[0] = str_replace(["+", '-'], '', $number[0]);
    //$phonenumber = str_replace('+'.$number[0], '', $number[1]);

    $phone = str_replace(['+'.$number[0], '-'], '', count($number) > 1 ? $number[1] : $phone);
    $phone = str_replace("/[0-9]/g", '', $phone);
	$phone = trim($phone);
	
    if($phone && substr($phone, 0, 1) == '1')
    {
        $phone = substr($phone, 1, strlen($phone));
    }
    else if($phone)
    {
        $phone = (substr($phone, 0, 1) == 0 ? substr($phone, 1, strlen($phone)) : $phone);
    }
    return $number[0] . '' . $phone;
}*/

function sanitizePhone($phone)
{
    $number = explode('-', $phone, 2);
    $number[0] = str_replace(['-'], '', $number[0]);
    //$phonenumber = str_replace('+'.$number[0], '', $number[1]);

    $phone = str_replace([$number[0], '-'], '', count($number) > 1 ? $number[1] : $phone);
    $phone = str_replace("/[0-9]/g", '', $phone);
    $phone = trim($phone);
    
    if($phone && substr($phone, 0, 1) == '1')
    {
        $phone = substr($phone, 1, strlen($phone));
    }
    else if($phone)
    {
        $phone = (substr($phone, 0, 1) == 0 ? substr($phone, 1, strlen($phone)) : $phone);
    }
    return $number[0] . '-' . $phone;
}

function arrayEqual($a, $b, $skip = []) {
    $r = false;
    foreach($a as $k => $v)
    {
        if($b[$k] != $v && !in_array($k, $skip))
        {
            $r = false;
            break;
        }
        $r = true;
    }

    return $r;
}

function filesizeFormatted($file)
{
    $bytes = filesize($file);

    if($bytes >= 1073741824)
    {
        return number_format($bytes / 1073741824, 2) . ' GB';
    }
    elseif($bytes >= 1048576)
    {
        return number_format($bytes / 1048576, 2) . ' MB';
    }
    elseif($bytes >= 1024)
    {
        return number_format($bytes / 1024, 2) . ' KB';
    }
    elseif($bytes > 1)
    {
        return $bytes . ' bytes';
    }
    elseif ($bytes == 1)
    {
        return '1 byte';
    }
    else
    {
        return '0 bytes';
    }
}

function convertToBytes(string $from): ?int {
    $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
    $number = substr($from, 0, -2);
    $suffix = strtoupper(substr($from,-2));

    //B or no suffix
    if(is_numeric(substr($suffix, 0, 1)))
    {
        return preg_replace('/[^\d]/', '', $from);
    }

    $exponent = array_flip($units)[$suffix] ?? null;
    if($exponent === null)
    {
        return null;
    }

    return $number * (1024 ** $exponent);
}    

function renderStarRating($rating)
{
    if($rating == 5.0):
        echo '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>';
    elseif($rating >= 4.5 && $rating < 5.0):
        echo '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>';
    elseif($rating >= 4.0 && $rating <= 4.5):
        echo '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i>';
    elseif($rating >= 3.5 && $rating <= 4.0):
        echo '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i><i class="far fa-star"></i>';
    elseif($rating >= 3.0 && $rating <= 3.5):
        echo '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>';
    elseif($rating >= 2.5 && $rating < 3.0):
        echo '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i><i class="far fa-star"></i><i class="far fa-star"></i>';
    elseif($rating >= 2.0 && $rating < 2.5):
        echo '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>';
    elseif($rating >= 1.5 && $rating < 2.0):
        echo '<i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>';
    elseif($rating >= 1.0 && $rating < 1.5):
        echo '<i class="fas fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>';
    elseif($rating >= 0.5 && $rating < 1.0):
        echo '<i class="fas fa-star-half-alt"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>';
    else:
        echo '<i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>';
    endif;
}

function removeEmptyAndAllowTags($html, $allowEmpty = false)
{
    //$pattern = "/<p[^>]*><\\/p[^>]*>/"; 
    $pattern = "/<[^\/>]*>([\s]?)*<\/[^>]*>/";
    $data = preg_replace($pattern, '', $html); 
    $tags = strip_tags($data, '<h1><h2><h3><h4><h5><h6><p><a><ul><li><ol><b><strong><i><u><sup><sub><figure><table><tbody><tr><td><br>');
    return $allowEmpty = true ? html_entity_decode($tags) : html_entity_decode(str_replace('&nbsp;', ' ', $tags));
}

function thoughtsTags($html, $allowEmpty = false)
{
    //$pattern = "/<p[^>]*><\\/p[^>]*>/"; 
    $pattern = "/<[^\/>]*>([\s]?)*<\/[^>]*>/";
    $data = preg_replace($pattern, '', $html); 
    $tags = strip_tags($data, '<p><a><ul><li><ol><b><strong><i><u><sup><sub><br><img>');
    return $allowEmpty = true ? html_entity_decode($tags) : html_entity_decode(str_replace('&nbsp;', ' ', $tags));
}

function characterLimitWithRemoveTags($html, $limit = null)
{
    $content = str::limit(strip_tags($html),$limit,'...');
    return html_entity_decode(str_replace('&nbsp;', ' ', $content));
    //return html_entity_decode($content);
}

/**
* To compactPriceFormat
**/
function compactPriceFormat($n)
{
    // first strip any formatting;
    $n = (0+str_replace(",","",$n));
   
    // is this a number?
    if(!is_numeric($n)) return false;
   
    // now filter it;
    if($n>1000000000000) return round(($n/1000000000000),1).' T';
    else if($n>1000000000) return round(($n/1000000000),1).' B';
    else if($n>1000000) return round(($n/1000000),1).' M';
    else if($n>1000) return round(($n/1000),1).' K';
   
    return number_format($n);
}

function isJson($string)
{
    // Check if $string is a string
    if (!is_string($string)) {
        return false; // If not a string, return false
    }
    
    // Attempt to decode the JSON string
    json_decode($string);
    
    // Check if there are any errors during decoding
    return (json_last_error() == JSON_ERROR_NONE);
}

/**
* To get embeded id from YouTube url
**/
function embededIdFromYouTubeUrl($url)
{
    if($url)
    {
        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
        return isset($match[1]) && $match[1] ? $match[1] : "" ;
        
    } else {
        return "";
    }   
}

function hex2rgba($color, $opacity = false)
{
    $default = 'rgb(0,0,0)';

    //Return default if no color provided
    if(empty($color))
    {
        return $default;
    }

    //Sanitize $color if "#" is provided 
    if($color[0] == '#')
    {
        $color = substr($color, 1);
    }

    //Check if color has 6 or 3 characters and get values
    if(strlen($color) == 6)
    {
        $hex = array($color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]);
    }
    elseif(strlen($color) == 3)
    {
        $hex = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]);
    }
    else
    {
        return $default;
    }

    //Convert hexadec to rgb
    $rgb = array_map('hexdec', $hex);

    //Check if opacity is set(rgba or rgb)
    if($opacity)
    {
        if(abs($opacity) > 1)
        {
            $opacity = 1.0;
        }
        
        $output = 'rgba(' . implode(",", $rgb) . ',' . $opacity . ')';
    }
    else
    {
        $output = 'rgb(' . implode(",", $rgb) . ')';
    }

    //Return rgb(a) color string
    return $output;
}

function addBrTag($text = null, $position = 3)
{
    $string2Explode = $text; //Also string
    $stringExploded = explode(" ",$string2Explode); //array([0] => "One", [1]=> "great" etc.);
    $preventedWords = array("One","Two","Three"); //Add prevented words here
    $stringImploded = "";
    $found = 0;
    $count = 0;
    
    while($count !== count($stringExploded))
    {
        $stringImploded .= $stringExploded[$count];
        if(!in_array($stringExploded[$count],$preventedWords))
        {
            $found++;

            if($found % 1 == 0)
            {
                $stringImploded .= " ";
            }
            else
            {
                $stringImploded .= " ";
            }
            if($found % $position == 0)
            {
                $stringImploded .= "<br> ";
            }
        }
        $count++;
    }

    return $stringImploded;
}

function addTag($text = null, $position = 3)
{
    $string2Explode = $text; //Also string
    $stringExploded = explode(" ",$string2Explode); //array([0] => "One", [1]=> "great" etc.);
    $preventedWords = array("One","Two","Three"); //Add prevented words here
    $stringImploded = "";
    $found = 0;
    $count = 0;

    while ($count !== count($stringExploded))
    {
        $stringImploded .= $stringExploded[$count];
        if(!in_array($stringExploded[$count],$preventedWords))
        {
            $found++;
            if($found % 1 == 0)
            {
                $stringImploded .= " </span>";
            }
            else
            {
                $stringImploded .= " ";
            }

            if($found % $position == 0)
            {
                $stringImploded .= "<span> ";
            }
        }
        $count++;
    } 

    return $stringImploded;
}

function __dl($object, $field)
{
    $lang = session('language') ? session('language') : 'en';
    $cField = $field . '_' . $lang;

    if(is_object($object) && isset($object->{$cField})) 
    { 
        return $object->{$cField};
    }
    elseif(is_array($object) && isset($object[$cField]))
    {
        return $object[$cField];
    }
    else if(isset($object[$field]) && $object[$field])
    {
        return $object[$field];
    }
    else
    {
        return '???';
    }
}

function secondToTime($seconds)
{
    if($seconds > 0)
    {
        $hours = floor($seconds / 3600);
        $mins = floor($seconds / 60 % 60);
        $secs = floor($seconds % 60);
        $timeFormat = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
    }
    else
    {
        $timeFormat = '00:00:00';
    }

    return $timeFormat;
}

function timeToSecond($time)
{
    if($time)
    {
        $pattern = "/(\d+):(\d+):(\d+)/";
        preg_match($pattern, $time, $matches);
        $totalTime = $time ? $matches[3] + $matches[2] * 60 + $matches[1] * 3600 : 0;
    }
    else
    {
        $totalTime = 0;
    }

    return $totalTime;
}

function getNameFromNumber($num) {
    $numeric = $num % 26;
    $letter = chr(65 + $numeric);
    $num2 = intval($num / 26);
    if ($num2 > 0) {
        return getNameFromNumber($num2 - 1) . $letter;
    } else {
        return $letter;
    }
}
