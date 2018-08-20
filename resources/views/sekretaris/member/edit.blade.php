@extends('layouts.lte')

@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Anggota
        <small>Atur seluruh anggota periode {{Auth::user()->periode()}}</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{Help::url()}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{Help::url('anggota')}}"> Anggota</a></li>
        <li><a href="{{Help::url('anggota')}}"> {{$profile->name}}</a></li>
        <li class="active">Edit</li>
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
      @if ($errors->any())
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h4> Perhatian</h4>
          @foreach ($errors->all() as $e)
            <p>{{$e}}</p>
          @endforeach
        </div>
      @endif
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Ubah Profile Anggota : {{$profile->name}}</h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-4">
              <form class="" action="{{Help::url('anggota/'.$profile->id)}}" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="put">
                <div class="form-group">
                  <label>NIM</label>
                  <input type="text" name="nim" value="{{$profile->nim}}" class="form-control" required autofocus>
                </div>
                <div class="form-group">
                  <label>Nama</label>
                  <input type="text" name="name" value="{{$profile->name}}" class="form-control" required autofocus>
                </div>
                <div class="form-group">
                  <label>Email</label>
                  <input type="email" name="email" value="{{$profile->email}}" class="form-control" required autofocus>
                </div>
                <div class="form-group">
                  <label>Handphone</label>
                  <input type="text" name="handphone" value="{{$profile->handphone}}" class="form-control" required autofocus>
                </div>
                <div class="form-group">
                  <label>Tanggal Lahir</label>
                  <input type="text" name="birthday" value="{{date('d-m-Y',strtotime($profile->birthday))}}" class="form-control" required autofocus>
                </div>
                <div class="form-group">
                  <label>Jenis Kelamin</label>
                  <select class="form-control" name="sex" required autofocus>
                    <option value="male" {{$profile->sex == 'male' ? 'checked' : ''}}>Pria</option>
                    <option value="female" {{$profile->sex == 'female' ? 'checked' : ''}}>Wanita</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Alamat</label>
                  <textarea name="address" rows="4" cols="80" class="form-control">{{$profile->address}}</textarea>
                </div>
                <div class="form-group">
                  <button type="submit" class="btn btn-primary pull-right">Simpan</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

    </section>
  </div>

@endsection
@section('css')
  <link rel="stylesheet" href="{{asset('plugins/datepicker/datepicker3.css')}}">
@endsection
@push('js')
  <script src="{{asset('plugins/datepicker/bootstrap-datepicker.js')}}"></script>
  <script>
    $(document).ready(function() {
      $('input[name=birthday]').datepicker({
        format: "dd-mm-yyyy"
      });
    });
  </script>
@endpush
