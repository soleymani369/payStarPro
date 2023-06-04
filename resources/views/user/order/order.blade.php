@extends('layouts.app')

@section('content')


  <h1>سبد خرید</h1>
  <div class="container">
    <a href="{{ route('home.commodity.index') }}"
       class="btn btn-outline-primary"> اضافه کردن محصول</a>
 <div class="table-responsive">
      <table class="table-hover table">
        <thead>
          <tr>
            <th>ردیف</th>
            <th>نام</th>
            <th>تعداد</th>
            <th>قیمت واحد(ریال)</th>
            <th>قیمت کل</th>
            <th>اقدامات</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            @php
              $i =0;
              $sum=0;
            @endphp
            @forelse ($commodities as $commodity)
              <td>{{ ++$i }}</td>
              <td>{{ $commodity->name }}</td>
              <td>{{ $commodity->amount}}</td>
              <td>{{ $commodity->price }}</td>
              <td>{{ $commodity->price*$commodity->amount }}</td>
            @php
              $sum+=($commodity->price*$commodity->amount );

            @endphp
              <td>

                   <a href="{{ route('home.commodity.show', $commodity->id) }} "
                    class="btn btn-success ">نمایش</a>
                    <form action="{{ route('user.commodity.removeItemFromOrder',$commodity->id)}}" method="post" class="d-inline">
                    @csrf
                      <input type="hidden" value="{{ Auth::id() }} " name="user_id">
                      <input type="hidden" value="{{ $commodity->id}} " name="commodity_id">
                    <button type="submit" class="btn btn-danger">حذف</button>
                    </form>

              </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="text-muted">محصولی جهت نمایش وجود ندارد!</td>
          </tr>
          @endforelse
        </tbody>
      </table>
      <b>جمع کل : {{number_format( $sum) }} ریال</b>
      <br>
      @if ($sum)

      <a href="{{ route('user.commodity.checkout') }}" class="btn btn-outline-success">نهایی کردن سفارش</a>
      @endif
    </div>
  </div>

@endsection
