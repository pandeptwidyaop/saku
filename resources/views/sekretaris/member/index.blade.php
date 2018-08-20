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
        <li class="active">Anggota</li>
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
      @if (Auth::user()->config()->open_registration === 'true')
        <div class="alert alert-info alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h4> Info Pendaftaran Anggota</h4>
          Pendaftaran Anggota untuk Periode {{Auth::user()->periode()}}, sudah diaktifkan oleh Administrator dengan alamat : <br> <code>{{url('member/'.Auth::user()->member()->periode_id.'/registration')}}</code> <br>Silakan kontak Administrator untuk menutup pendaftaran anggota baru.
        </div>
      @endif
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Data Seluruh Anggota</h3>
        </div>
        <div class="box-body">
          <a href="{{Help::url('download/anggota')}}" class="btn btn-primary">Download (*.xlsx)</a>
          <br>
          <br>
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Opsi</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Handphone</th>
                <th>Jenis Kelamin</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($member as $anggota)
                <tr>
                  <td width="5%">
                    <div class="btn-group ">
                      <button type="button" class="btn btn-info dropdown-toggle btn-xs" data-toggle="dropdown">
                        <span><i class="fa fa-gear"></i> Opsi</span>
                      </button>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="{{Help::url('anggota/'.$anggota->id.'/edit')}}">Ubah Profile</a></li>
                        <li class="divider"></li>
                        <li><a href="{{Help::js()}}" onclick="deleteAnggota('{{$anggota->id}}')">Hapus Keanggotaan</a></li>
                      </ul>
                    </div>
                  </td>
                  <td>{{$anggota->profile->nim}}</td>
                  <td>{{$anggota->profile->name}}</td>
                  <td>{{$anggota->profile->email}}</td>
                  <td>{{$anggota->profile->handphone}}</td>
                  <td>
                    @if ($anggota->profile->sex == 'male')
                      <span class="label label-success">Pria</span>
                    @else
                      <span class="label label-primary">Wanita</span>
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      {{-- <div class="box">
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
      </div> --}}
    </section>
  </div>
  <form class="hidden" action="" method="post" id="delete">
    {{ csrf_field() }}
    <input type="hidden" name="_method" value="delete">
  </form>

@endsection
@section('css')
<link rel="stylesheet" href="{{asset('plugins/datatables/dataTables.bootstrap.css')}}">
@endsection
@push('js')
  <script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
  <script src="{{asset('plugins/bootbox/bootbox.min.js')}}"></script>
  <script>
    $(document).ready(function() {
      $('table').dataTable();
    });

    function deleteAnggota(id) {
      var attr = '{{Help::url('anggota')}}/'+id;
      bootbox.confirm("Apakah anda yakin ingin menghapus anggota ini ?", function(result){
         if (result) {
           $('form#delete').attr('action', attr);
           $('form#delete').submit();
         }
      });
    }
  </script>
@endpush
