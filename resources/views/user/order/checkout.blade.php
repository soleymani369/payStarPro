@extends('layouts.app')

@section('content')
@php
    use App\Models\Commodity;
@endphp
                      @forelse ($order->items as $item)


                    <div class="table-responsive">
                          <table class="table-hover table">
                            <thead>
                              <tr>
                                <th>نام محصول</th>
                                <th>تعداد</th>
                                <th>قیمت(ریال)</th>
                                <th>قیمت کل</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>

                                  <td>{{ Commodity::where(['id'=>$item->commodity_id])->pluck('name')[0] }}</td>
                                  <td>{{ $item->count }}</td>
                                  <td>{{ $item->price }}</td>
                                  <td>{{ $item->price *$item->count}}</td>

                              </tr>
                            @empty
                              <tr>
                                <td colspan="5" class="text-muted">تراکنشی یافت نشد</td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        @endforelse


                  <form action="{{ route('user.commodity.pay',$order->id) }}">
                    @if (!Auth::user()->card_number)

                  <input type="text" name="card_number" placeholder="شماره کارت خود را وارد کنید">
                    @else
                         <h5 >شماره کارت</h5>
                    <div class="mb-5">
                      <div class="form-outline">
                        <i>{{ Auth::user()->card_number }}</i>
                        <input type="hidden"name="card_number" value="{{ Auth::user()->card_number }}">
                      </div>
                    </div>
                    @endif

                    <hr class="my-4">

                    <div class="d-flex justify-content-between mb-5">
                      <h5 class="text-uppercase">جمع کل</h5>
                      <h5>{{ $order->totalPrice() }}</h5>
                    </div>

                    <button type="submit" class="btn btn-dark btn-block btn-lg"
                      data-mdb-ripple-color="dark">خرید از درگاه پی استار</button>

                  </form>


</section>
@endsection
