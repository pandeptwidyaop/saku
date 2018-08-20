@extends('layouts.lte')

@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Absen
        <small>Absen seluruh anggota periode {{Auth::user()->periode()}}</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{Help::url()}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Absen</li>
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
          <h3 class="box-title">Buat Absen</h3>
        </div>
        <form class="" action="{{Help::url('absen')}}" method="post">
          {{ csrf_field() }}
          <div class="box-body">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label>Judul Absen</label>
                  <input type="text" name="title" value="" class="form-control" required>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Tanggal</label>
                  <input type="text" name="date" value="" class="form-control" required>
                </div>
              </div>
            </div>
          </div>
          <div class="box-footer ">
                <button type="submit" class="btn btn-primary pull-right">Submit</button>
          </div>
        </form>
      </div>
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Data Seluruh Absen</h3>
        </div>
        <div class="box-body">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Opsi</th>
                <th>Tanggal</th>
                <th>Judul</th>
                <th>Anggota Hadir</th>
                <th>Anggota Tidak Hadir</th>
                <th>Dibuat oleh</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($absent as $absen)
                <tr>
                  <td width="5%">
                    <div class="btn-group ">
                      <button type="button" class="btn btn-info dropdown-toggle btn-xs" data-toggle="dropdown">
                        <span><i class="fa fa-gear"></i> Opsi</span>
                      </button>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="{{Help::url('absen/'.$absen->id.'/view')}}">Absen</a></li>
                        <li><a href="{{Help::url('absen/'.$absen->id.'/download')}}">Download (*.xls)</a></li>
                        <li class="divider"></li>
                        <li><a href="{{Help::js()}}" onclick="deleteAbsen('{{$absen->id}}')">Hapus Absen</a></li>
                      </ul>
                    </div>
                  </td>
                  <td>{{date('d F Y',strtotime($absen->date))}}</td>
                  <td>{{$absen->title}}</td>
                  @php
                    $hadir = $thadir = 0;
                    foreach ($absen->Absentmember as $am) {
                      if ($am->absent == 'present') {
                        $hadir++;
                      }else {
                        $thadir++;
                      }
                    }
                  @endphp
                  <td>{{$hadir}}</td>
                  <td>{{$thadir}}</td>
                  <td>{{$absen->administrator->member->profile->name}}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>

    </section>
  </div>
  <form class="hidden" action="" method="post" id="delete">
    {{ csrf_field() }}
    <input type="hidden" name="_method" value="delete">
  </form>

@endsection
@section('css')
<link rel="stylesheet" href="{{asset('plugins/datepicker/datepicker3.css')}}">
<link rel="stylesheet" href="{{asset('plugins/datatables/dataTables.bootstrap.css')}}">
@endsection
@push('js')
  <script src="{{asset('plugins/datepicker/bootstrap-datepicker.js')}}"></script>
  <script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
  <script src="{{asset('plugins/bootbox/bootbox.min.js')}}"></script>
  <script>
    $(document).ready(function() {
      $('table').dataTable();
      $('input[name=date]').datepicker({
        format: "dd-mm-yyyy"
      });
    });

    function deleteAbsen(id) {
      var attr = '{{Help::url('absen')}}/'+id;
      bootbox.confirm("Apakah anda yakin ingin menghapus absensi ini ? Semua data absensi akan terhapus.", function(result){
         if (result) {
           $('form#delete').attr('action', attr);
           $('form#delete').submit();
         }
      });
    }
  </script>
@endpush
