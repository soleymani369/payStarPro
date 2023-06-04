@extends('layouts.app')
@section('content')
  <div style="margin: 0 30px">



    <h1>محصولات</h1>
    <a href="{{ route('admin.commodity.create') }}"
       class="btn btn-outline-primary"> ایجاد محصول</a>
    <div class="table-responsive">
      <table class="table-hover table">
        <thead>
          <tr>
            <th>شناسه</th>
            <th>نام</th>
            <th>قیمت(ریال)</th>
            <th>موجودی</th>
            <th>اقدامات</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            @forelse ($commodity as $c)
              <td>{{ $c->id }}</td>
              <td>{{ $c->name }}</td>
              <td>{{ $c->price }}</td>
              <td>{{ $c->amount}}</td>
              <td>
                <a href="{{ route('admin.commodity.edit', $c->id) }}"
                   class="btn btn-warning">ویرایش</a>
                <a href="{{ route('admin.commodity.delete', $c->id) }} "
                   class="btn btn-danger">حذف</a>
                <a href="{{ route('admin.commodity.show', $c->id) }} "
                   class="btn btn-success">نمایش</a>

              </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="text-muted">محصولی جهت نمایش وجود ندارد!</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
@endsection
