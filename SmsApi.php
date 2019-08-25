<?php
/**
 * Created by PhpStorm.
 * User: stebio
 * Date: 27/04/16
 * Time: 11:44
 */


class SmsApi
{

    public function isSmsapi($to, $message)
    {

        $username = 'luxury';
        $password = 'EBDNUZL9'; //'08710358'
        $sender   = 'LUXURY';
        $type     = 'text';
        $message = urlencode($message); //$this->converUnicode($message);

        // $to = '02280768';

        // $datetime = urlencode(date('Y-m-d H:i:s'));
        //$destinataire = ;

        /*http://africasmshub.mondialsms.net/api/api_http.php?username=emitic&password=007Jockers%40&sender=AFRIKHOTEL&to=22508710358&text=Hello%20world
        &type=text&datetime=2017-08-12%2010%3A02%3A42*/

        $smsapiUrl = 'http://app.emisms.com/sms/api?action=send-sms&api_key=S2NnRmFuck5KZGJheEFBQUVoc2k=&to=225'.$to.'&from=' . $sender . '&sms=' . $message.'&unicode=1';

        // $smsapiUrl = 'http://sms.e-mitic.com/api/api_http.php?username=' . $username . '&password=' . $password . '&sender=' . $sender . '&to=+225' . $to
        //     . '&text=' . $message . '&type=' . $type . '&datetime=' . $datetime;

        //dump($smsapiUrl);die();
        //return file_get_contents($smsapiUrl);

        $reste_sms = file_get_contents($smsapiUrl);
        $reste_sms_list = json_decode($reste_sms,true);
        return $reste_sms_list['0']['code'];
        // return 'KO';
        //return file_get_contents($smsapiUrl);
    }

    public function converUnicode($text)
    {

        $convert = new Unicode();

        return $text = $convert->str_to_unicode($text, 'UTF-8');
    }
}
