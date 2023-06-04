@extends('layouts.app')
@section('content')
@php
use Illuminate\Support\Facades\Auth;

@endphp
  <h1>نمایش</h1>

  {{-- <div class="d-flex justify-content-center"> --}}
  <div style="margin:20px">


    <div>
      <img src="{{ asset('static/commodity/' . $commodity->image) }}" class="rounded"
           style="width: 300px" alt="">
    </div>

    <div class="form-group">
      <label for="name">نام</label>
      <input type="text" name="name" class="form-control"
             value="{{ $commodity->name }}" readonly>
    </div>

        <div class="form-group">
      <label for="price">قیمت</label>
      <input type="text" price="price" class="form-control"
             value="{{ $commodity->price }}" readonly>
    </div>

        <div class="form-group">
      <label for="amount">موجودی</label>
      <input type="text" amount="amount" class="form-control"
             value="{{ $commodity->amount }}" readonly>
    </div>


    <div class="form-group">
      <label for="body">توضیحات</label>
      <textarea name="body" rows="10" class="form-control" cols="80"
                readonly>{{ $commodity->body }}</textarea>
    </div>

<form action="{{ route('user.commodity.addItemToOrder',$commodity->id)}}" method="post">
@csrf
  <input type="hidden" value="{{ Auth::id() }} " name="user_id">
  <input type="hidden" value="{{ $commodity->id}} " name="commodity_id">
  <input type="text" name="count" placeholder="نیاز شما؟">
<button type="submit" class="btn btn-success">خرید</button>
</form>

    <form class="form-group">
      <a href="{{ route('home.commodity.index') }}" class="btn btn-danger">بازگشت</a>
    </form>
  </div>
@endsection
