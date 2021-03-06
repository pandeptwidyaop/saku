@extends('layouts.lte')

@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Home
        <small>Selamat datang di Sistem Administrasi & Keuangan</small>
      </h1>
      <ol class="breadcrumb">
        <li class="active"><a href="{{Help::url()}}"><i class="fa fa-dashboard"></i> Home</a></li>
        {{-- <li class="active">Here</li> --}}
      </ol>
    </section>

    <section class="content">
      @if (Alert::have())
        <div class="alert alert-{{Alert::type()}} alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h4> Perhatian</h4>
          {{Alert::msg()}}
        </div>
      @endif

    </section>
  </div>
@endsection
@section('css')

@endsection
@push('js')

@endpush
