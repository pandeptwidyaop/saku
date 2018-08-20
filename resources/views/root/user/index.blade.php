@extends('layouts.lte')

@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Pengguna
        <small>Atur seluruh pengguna Aplikasi</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{Help::url()}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">User</li>
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
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Data Seluruh Pengguna</h3>
        </div>
        <div class="box-body">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Opsi</th>
                <th>Username</th>
                <th>Level</th>
                <th>Name</th>
                <th>Email</th>
                <th>Position</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($user as $u)
                @if ($u->role != null)
                  <tr>
                    <td width="5%">
                      <div class="btn-group ">
                        <button type="button" class="btn btn-info dropdown-toggle btn-xs" data-toggle="dropdown">
                          <span><i class="fa fa-gear"></i> Opsi</span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="{{Help::url('user/'.$u->id.'/change')}}">Rubah Akses</a></li>
                          <li><a href="{{Help::js()}}" onclick="resetPass('{{$u->id}}')">Reset Password</a></li>
                          <li class="divider"></li>
                          <li><a href="{{Help::js()}}" onclick="deleteUser('{{$u->id}}')">Hapus</a></li>
                        </ul>
                      </div>
                    </td>
                    <td>{{$u->username}}</td>
                    <td><span class="label label-primary">{{$u->role}}</span></td>
                    @if (count($u->Administrator) > 0)
                      <td>{{$u->profile()->name}}</td>
                      <td>{{$u->profile()->email}}</td>
                      <td>{{ucfirst($u->position())}}</td>
                    @else
                      <td></td>
                      <td></td>
                      <td></td>
                    @endif
                    <td>
                      @if ($u->access == 'granted')
                        <span class="label label-success">Granted</span>
                      @else
                        <span class="label label-danger">Denied</span>
                      @endif
                    </td>
                  </tr>
                @endif
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Buatkan Akses</h3>
        </div>

          <div class="box-body">
            <div class="row">
              <div class="col-md-3">
                <label>Periode</label>
                <form class="" action="{{Help::url('user')}}" method="get" id="formGet">
                  <select class="form-control select2" style="width: 100%;" name="periode" onchange="getData()">
                    <option>Pilih Periode Anggota</option>
                    @foreach ($periode as $pe)
                      <option value="{{$pe->id}}" {{Request::input('periode') == $pe->id ? 'selected' : ''}}>{{$pe->periode}}</option>
                    @endforeach
                  </select>
                </form>
              </div>
              <form class="" action="{{Help::url('user')}}" method="post">
                {{ csrf_field() }}
              <div class="col-md-3">
                <label>Username</label>
                <select class="form-control select2" style="width: 100%;" name="user" required>
                  @foreach ($user as $u)
                    @if ($u->role == null)
                      <option value="{{$u->id}}">{{$u->username}}</option>
                    @endif
                  @endforeach
                </select>
              </div>
              <div class="col-md-3">
                <label>Nama</label>
                <select class="form-control select2" style="width: 100%;" name="member" required>
                  @foreach ($member as $mem)
                    @if (count($mem->Administrator) == 0)
                      <option value="{{$mem->id}}">{{$mem->Profile->name}}</option>
                    @endif
                  @endforeach
                </select>
              </div>

              <div class="col-md-3">
                <label>Jabatan</label>
                <select class="form-control select2" style="width: 100%;" name="administrator" required>
                  <option value="sekretaris">Sekretaris</option>
                  <option value="bendahara">Bendahara</option>
                </select>
              </div>

            </div>
          </div>
          <div class="box-footer ">
                <button type="submit" class="btn btn-primary pull-right">Submit</button>
          </div>
        </form>
      </div>
    </section>
  </div>
  <form class="hidden" action="" method="post" id="delete">
    {{ csrf_field() }}
    <input type="hidden" name="_method" value="delete">
  </form>
  <form class="hidden" action="" method="post" id="password">
    {{ csrf_field() }}
    <input type="hidden" name="password" value="">
  </form>
@endsection
@section('css')
<link rel="stylesheet" href="{{asset('plugins/datatables/dataTables.bootstrap.css')}}">
<link rel="stylesheet" href="{{asset('plugins/select2/select2.min.css')}}">
@endsection
@push('js')
  <script src="{{asset('plugins/select2/select2.full.min.js')}}"></script>
  <script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
  <script src="{{asset('plugins/bootbox/bootbox.min.js')}}"></script>
  <script>
    $(document).ready(function() {
      $('table').dataTable();
      $('select').select2();
    });

    function deleteUser(id) {
      var attr = '{{Help::url('user')}}/'+id;
      bootbox.confirm("Apakah anda yakin ingin menghapus pengguna ini ?", function(result){
         if (result) {
           $('form#delete').attr('action', attr);
           $('form#delete').submit();
         }
      });
    }

    function resetPass(id) {
      var attr = '{{Help::url('user')}}/'+id+'/reset';
      bootbox.prompt("Ganti password.", function(result){
        if (result != null) {
          $('form#password').attr('action', attr);
          $('form#password input[name=password]').val(result);
          $('form#password').submit();
        }
      });
    }

    function getData() {
      $('#formGet').submit();
    }
  </script>
@endpush
