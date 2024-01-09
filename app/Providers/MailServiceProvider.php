<?php

namespace App\Providers;

use Config; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class MailServiceProvider extends ServiceProvider
{
    public function register()
    {
        if (\Schema::hasTable('site_settings')) {
            $site_setting = DB::table('site_settings')->first();
            if (@$site_setting->email_configuration){
                $mail = json_decode(@$site_setting->email_configuration,true);
                $config = array(
                    'driver'     => @$mail['MAIL_MAILER'],
                    'host'       => @$mail['MAIL_HOST'],
                    'port'       => @$mail['MAIL_PORT'],
                    'from'       => array('address' => @$mail['MAIL_FROM_ADDRESS'], 'name' => @$mail['MAIL_FROM_NAME']),
                    'encryption' => @$mail['MAIL_ENCRYPTION'],
                    'username'   => @$mail['MAIL_USERNAME'],
                    'password'   => @$mail['MAIL_PASSWORD'],
                    'sendmail'   => '/usr/sbin/sendmail -bs',
                    'pretend'    => false,
                );
                Config::set('mail', $config);
            }
        }
    }
}
