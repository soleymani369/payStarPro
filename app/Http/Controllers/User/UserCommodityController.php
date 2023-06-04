<?php

namespace App\Http\Controllers\User;

use Exception;
use App\Models\User;
use App\Models\Order;
use App\Helpers\Basket;
use App\Helpers\PayStar;
use App\Models\Commodity;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\OrderCommodity;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserCommodityController extends Controller
{
    public function orderList(User $user)
    {
        $commodities =Commodity::whereIn('id', array_keys(Basket::all()))->get();
        foreach ($commodities as $commodity) {
            foreach (Basket::all() as $key => $value) {
                if ($commodity->id ==$key) {
                    $commodity->amount = $value;
                    continue;
                }
            }
        }

        return view('user.order.order', compact('commodities'));
    }

    public function checkout()
    {
        return  DB::transaction(function () {
            $commodities = Commodity::whereIn('id', array_keys(Basket::all()))->get();
            $order = Auth::user()->orders()->create(['status' => 'pending']);
            foreach ($commodities as $commodity) {
                $count = Basket::$items[$commodity->id];
                if ($count == 0) {
                    continue;
                }

                if ($commodity->amount < $count) {
                    throw new Exception("موجودی محصول کمتر از تعداد وارد شده در سبد است.");
                }

                $commodity->amount -= $count;
                $commodity->update();

                $order->items()->create(['count' => $count, 'commodity_id' => $commodity->id, 'price' => $commodity->price]);
            }

            return to_route('user.commodity.checkoutList', $order);
        });
    }

    public function orderResult(Request $request)
    {
        $transaction = Transaction::where(['ref_num' => $request->input('ref_num')])->first();
        $transaction->update([
            'tracking_code'=>$request->input('tracking_code'),
        ]);
        $resualt = $request->input('status');
        if ($resualt == 1) {
            PayStar::verify($transaction);
        } else {
            $data=  PayStar::verifyData($resualt);
            return to_route('home.commodity.index')->withErrors($data);
        }
    }
    public function payOrder(Request $request, Order $order)
    {
        Basket::clear();
        $user = Auth::user();
        if (!$user->card_number) {
            if (!$request->input('card_number')) {
                return redirect()->back()->withErrors('شماره کارت خود را وارد کنید');
            }
            $user->card_number = $request->query('card_number');
            $user->save();
        }
        return redirect(PayStar::pay($order->totalPrice(), $order->id));
    }
    public function addItemToOrder(Commodity $commodity, Request $request)
    {
        $request->validate([

          'user_id' => 'required | numeric | exists:users,id',
          'commodity_id'=> 'required|numeric|exists:commodities,id',
          'count' => ['required','string', ]
        ]);

        if ($request->count > $commodity->amount) {
            return back()->with('danger', 'مقدار درخواستی بیش از موجودی است');
        }

        Basket::add($commodity->id, $request->count);


        return to_route('home.commodity.index')->with('success', 'کالا مورد نظر با موفقیت به سبد خرید اضافه شد');
    }

    public function removeItemFromOrder(User $user, Commodity $commodity, Request $request)
    {
        $request->validate([

          'user_id' => 'required | numeric | exists:users,id',
          'commodity_id'=> 'required|numeric|exists:commodities,id'

        ]);
        Basket::remove($commodity->id);
        return to_route('home.commodity.index')->with('success', 'کالا مورد نظر با موفقیت حذف شد');
    }

    public function checkoutList(Order $order)
    {
        $order->load('items.commodity');
        return view('user.order.checkout', compact('order'));
    }
}
