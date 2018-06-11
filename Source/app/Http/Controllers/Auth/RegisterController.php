<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

//php mailer unit installed via => composer require phpmailer/phpmailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        //create instance
        $getUser = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
        //get user settings
        $userName = $getUser->name;
        $userEmail = $getUser->email;
        $userID = $getUser->id;
        //create activation token
        $activateToken = md5(uniqid(rand(), true));
        //update db
        $affected = DB::update('update users set activation_token = ? where id = ?', [$activateToken,$userID]);
        //send email to user
        if ($affected){
            $this->sendEmail($userEmail,$userName,$activateToken);
        }

        return $getUser;
    }

    function sendEmail($toEmail,$toUserName,$token){ 
        //phpmailer settings from https://packagist.org/packages/phpmailer/phpmailer
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host = env('MAIL_HOST');
            $mail->SMTPAuth = true;
            $mail->Username = env('MAIL_USERNAME');
            $mail->Password = env('MAIL_PASSWORD');
            $mail->SMTPSecure = 'tls';
            $mail->Port = env('MAIL_PORT');
        
            //Recipients
            $mail->setFrom('test@test.com', 'Newspaper');
            $mail->addAddress($toEmail, $toUserName);
            $mail->addReplyTo('no-reply@test.com', 'No-Reply');        
        
            //Content
            $mail->isHTML(true);
            $mail->Subject = 'Newspaper - Please activate your account!';
            $mail->Body    = "Please check this <a href='http://newspaper/activate/$token'>link</a> to activate your account. <br>This action is needed to posts articles.";
            $mail->AltBody = 'Please check this link to activate your account. This action is needed to posts articles.';
        
            $mail->send();
            Log::info('Message has been sent for activation to : '.$toEmail);
        } catch (Exception $e) {
            Log::info('Message could not be sent to : '.$toEmail);
            Log::info('Mailer Error: ' . $mail->ErrorInfo);
        }
    }
}
