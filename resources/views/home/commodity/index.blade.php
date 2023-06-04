@extends('layouts.app')
@section('content')

  <div class="container">

  @forelse ($commodity as $c )


 <div class="row col d-inline" style="float: left">
        <div class="col col-md-5 d-inline">
          <div class="card" style="width: 500px; height: 500px  ; margin-left: 50px ">
            <div class="card-top">
              <strong style="margin: 2% 2% 0 0"> {{ $c->name }}</strong>
            </div>
            <hr>
            <div class="card-body">


                <img src="{{ asset('static/commodity/' . $c->image) }}" class="rounded"
                     style="width: 300px;max-height: 300px; float: left" alt="">
                     @php

                       $c->body= substr($c->body,0,256);
                     @endphp
                     <span>{!! $c->body !!}</span>

            </div>
            <div class="card-footer">
              <small style="color:"> تاریخ عرضه:
                {{ $c->created_at }}</small>

            </div>
            <a href="{{ route('home.commodity.show', $c->id) }}"
               class="btn btn-outline-primary">نمایش</a>
          </div>
        </div>
      </div>
    @empty
      <h2>محصولی جهت نمایش وجود ندارد</h2>
    @endforelse

  </div>
  </div>


@endsection
