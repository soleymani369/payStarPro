<?php

namespace App\Helpers;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PayStar
{
    private static $kay = '9A3EC03483556C73714510C507529DF70A1228C83477D1455E0511BD72C5AAB8A6715A414AA48B7C905FCEF45868BD26DA58196EF29C77C194C9F14A4B47456CC6454E9D50B388D6FC5AC91BB08B234A8060FDC85B1CEC32CA036DC907F8A4A635D9CBB9CAA31B42549B8D70B2CE5EDE8274FFB55DABFE92D76BC42D91696FAF';
    private static $token = '0yovdk2l6e143';


    public static function pay($amount, $transactionId)
    {
        $response = Http::withToken(self::$token)->post('https://core.paystar.ir/api/pardakht/create', [
          'amount' => $amount,
          'order_id' => (string)$transactionId,
          'callback' => route('user.commodity.orderResualt'),
          'card_number'=>Auth::user()->card_number,
          'sign' => hash_hmac('sha512', (string)$amount.'#'.(string)$transactionId.'#'.route('user.commodity.orderResualt'), self::$kay),

        ]);
        $transaction=Transaction::create([
          'user_id'=>Auth::user()->id,
           'ref_num' =>$response->json('data.ref_num') ,
           'order_id'=>$transactionId ,
           'card_number' =>Auth::user()->card_number,
           'amount' =>$amount,
          ]);
        $transaction->save();
        return 'https://core.paystar.ir/api/pardakht/payment?token=' . $response->json('data.token');
    }


    public static function verify($transaction)
    {
        $request = Http::timeout(15)->withToken(self::$token)->post('https://core.paystar.ir/api/pardakht/verify', [

          'ref_num' => $transaction->ref_num,
          'amount' => $transaction->amount,
          'sign' => hash_hmac('sha512', $transaction->amount.'#'.$transaction->ref_num.'#'.$transaction->card_number.'#'.$transaction->tracking_code, self::$kay),
        ]);
        return to_route('home.commodity.index')->with('success', 'خرید با موفقت انجام شد');
    }

    public static function verifyData($data)
    {
        $data = (string)$data;
        switch ($data) {
            case '1':
                $data = 'موفق';
                break;
            case '-1':
                $data = 'درخواست نامعتبر';
                break;

            case '-2':
                $data = 'درگاه فعال نیست';
                break;
            case '-3':
                $data = 'توکن تکراری است';
                break;

            case '-4':
                $data = 'مبلغ بیشتر از سطح مجاز درگاه است';
                break;

            case '-5':
                $data = 'شناسه ref_num معتبر نیست';
                break;

            case '-6':
                $data = 'تراکنش قبلا وریفای شده است';
                break;

            case '-7':
                $data = 'پارامتر های ارسالی نامعتبر است';
                break;

            case '-8':
                $data = 'تراکنش را نمیتوان وریفای کرد';
                break;

            case '-9':
                $data = 'تراکنش وریفای نشده';
                break;

            case '-98':
                $data = 'تراکنش ناموفق';
                break;

            case '-99':
                $data = 'خطای سامانه';
                break;


            default:'خطای جدید!';
                # code...
                break;
        }
        return $data;
    }
}
