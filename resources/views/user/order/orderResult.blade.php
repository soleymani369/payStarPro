@extends('layouts.app')
@section('content')

<h1>نتیجه تراکنش</h1>
<div class="container">
   <div class="table-responsive">
      <table class="table-hover table">
        <thead>
          <tr>
            <th>نتیجه تراکنش</th>
            <th>مد رهگیری</th>
            <th>قیمت(ریال)</th>
            <th>شماره کارت</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>{{ $transaction->status }}</td>
              <td>{{ $transaction->name }}</td>
              <td>{{ $transaction->card_number }}</td>

          </tr>
        @empty
          <tr>
            <td colspan="5" class="text-muted">تراکنشی یافت نشد</td>
          </tr>
        </tbody>
      </table>
    </div>

</div>
@endsection
