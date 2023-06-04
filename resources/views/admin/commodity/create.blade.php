@extends('layouts.app')
@section('content')
  <h1>اضافه کردن محصول</h1>
  {{-- <div class="d-flex justify-content-center"> --}}
  <div style="margin:20px">

    <form method="post" action="{{ route('admin.commodity.store', Auth::id()) }}"
          enctype="multipart/form-data">
      @csrf
      <div class="form-group">

        <label for="name" class="required">نام</label>
        <input type="text" name="name"
               class="form-control @error('name') is-invalid  @enderror"
               value="{{ old('name') }}">

        @error('name')
          <div class="alert alert-danger"> {{ $message }}</div>
        @enderror
      </div>

      <div class="form-group">
        <label for="image">تصویر</label>
        <input type="file" name="image"
               class="form-control-file @error('image') is-invalid @enderror">
        @error('image')
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
        @enderror
      </div>

      <div class="form-group">
        <label for="body" class="required">توضیحات محصول</label>
        <textarea name="body"cols="30" rows="10"
                  class="form-control @error('body') is-invalid

      @enderror">{{ old('body') }}</textarea>
        @error('body')
          <div class="alert alert-danger">{{ $message }}</div>
        @enderror
      </div>

    <div class="form-group">
      <label for="price" class="form-label">قیمت</label>
      <input type="text" name="price" id="" class="form-control" placeholder="1234567890">
        @error('price')
          <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>

     <div class="form-group">
      <label for="amount" class="form-label">تعداد</label>
      <input type="text" name="amount" id="" class="form-control" placeholder="9999">
        @error('amount')
          <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>

      <div class="form-group">
        <button type="submit" class="btn btn-outline-success">ذخیره</button>
        <a href="{{ route('admin.commodity.index', Auth::id()) }}"
           class="btn btn-danger">لغو</a>
      </div>

    </form>
  </div>

@endsection
