@extends('layouts.lte')
@section('css')

@endsection
@section('content')
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Profile
        <small>Ubah profile anda.</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{Help::url()}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="{{Help::url('profile')}}">Akun</a></li>
      </ol>
    </section>
    <section class="content">
      @if (Alert::have())
        <div class="alert alert-{{Alert::type()}} alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h4><i class="icon fa fa-check"></i> Informasi !</h4>
          {{Alert::msg()}}
        </div>
      @endif

      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Ubah Akun Anda</h3>
            </div>

            <div class="box-body">
              <div class="row">
                <div class="col-md-4 col-sm-4">
                  <div class="box-body">
                    <img src="{{Help::img(Auth::user()->picture)}}" alt="{{$data->name}}" class="img-responsive">
                  </div>
                  <div class="box-footer">
                    <button type="button" class="btn btn-flat btn-primary" onclick="changeimage()">Ganti Picture</button>
                    <button type="button" class="btn btn-flat btn-primary" onclick="updatePassword()">Ganti Password</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <form class="hidden" action="{{Help::url('akun/password')}}" method="post" id="formPassword">
    {{ csrf_field() }}
    <input type="hidden" name="password" value="" id="password">
  </form>

  <div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{Help::url('akun/picture')}}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Ganti Avatar</h4>
        </div>
        <div class="modal-body">
          <input type="file" name="picture" class="form-control-file" accept="image/*">
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary btn-flat">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
@push('js')
  <script src="{{asset('plugins/bootbox/bootbox.min.js')}}"></script>
  <script type="text/javascript">
    function updatePassword(){
      bootbox.prompt({
        title: 'Masukan password anda.',
        inputType: 'password',
        size: 'small',
        callback: function(result){
          if (result != null ) {
            bootbox.prompt({
              title: 'Masukan kembali password anda.',
              inputType: 'password',
              size: 'small',
              callback: function(password){
                if (password != null) {
                  if (result == password) {
                    $('#formPassword #password').val(password);
                    $('#formPassword').submit();
                  }else {
                    bootbox.alert("Password tidak sama. Silakan ulangi !");
                  }
                }
              }
            });
          }
        }
      });
    }

    function changeimage(){
      $('#myModal').modal('show');
    }
  </script>
@endpush
