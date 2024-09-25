<?php 
    use App\Models\Admin\Setting; 
    $companyName = Setting::get('company_name');
    $heading = 'Attendance Portal';
    
    if($slug == 'client-enrollement-form' || $slug == 'client-logistics-form' || $slug == 'owner-logistics-form')
    {
        $companyName = 'Globiz Technology';
        $heading = $companyName;
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $companyName; ?></title>
    <style>
        body {
            font-family: Verdana,Geneva,sans-serif; 

            margin: 0;
            background-color: #eee;
            font-weight: 500;
            font-size: 14px;
            line-height: inherit;
        }
        h3 {
            font-weight: 700;
            font-size: 24px;
            line-height: 31px;
            color: #000000;
            text-align: center;
            margin-top: 0;
        }

        p {
            margin: 0;
            padding: 5px;
            font-size: 16px;
            text-align: left;
        }

        p a {
            color: #0e1e42 !important;
            /*padding-left: 15px;
            font-weight: 700;*/
        }

        .btn {
            margin: 0 auto;
            width: 205px;
            height: 51px;
            background: #0e1e42;
            display: block;
            text-decoration: none;
            color: #fff !important;
            border-radius: 10px;
            font-weight: 700;
            font-size: 20px;
            text-transform: capitalize;
            border: none;
            text-align: center;
            line-height: 51px;
        }
        small {
            display: block;
            padding: 0;
            font-size: 12px;
            font-weight: 400;
            text-align: center;
        }
    </style>

</head>

<body>
    <div>
        <center style="background-color: #eee; ">
            <table style="width: 660px; margin: 0 auto; background-color: #eee;">
                <tbody>
                    <tr>
                        <td style="background-color: #0e1e42; color: #fff; padding-bottom: 20px; border-radius: 4px;">
                            <h2 style="font-weight: 800; font-size: 36px;text-align: center; margin: 30px 0 20px;">{{ $heading }}</h2>
                        </td>
                    </tr>
                    <tr>
                        <td style="background-color: #fff; text-align: center; padding: 60px 40px; border-bottom: 5px solid #0e1e42;">
                            <h3>{{ $subject }}</h3>
                            {!! $content !!}
                        </td>
                    </tr>
                </tbody>
            </table>
        </center>
    </div>
</body>

</html>
