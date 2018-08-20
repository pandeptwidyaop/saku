@extends('layouts.lte')

@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Kas Anggota
        <small>Data Pembayaran Kas seluruh anggota periode {{Auth::user()->periode()}}</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{Help::url()}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Data Kas Anggota</li>
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
          <h3 class="box-title">Data Seluruh Pembayaran Kas</h3>
        </div>
        <div class="box-body">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>NIM</th>
                <th>Nama</th>
                <th>Tunggakan</th>
                <th>Lunas</th>
                <th>#</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($member as $data)
                <tr>
                  <td>{{$data->Profile->nim}}</td>
                  <td>{{$data->Profile->name}}</td>
                  @php
                    $tunggakan = $lunas = 0;
                    foreach ($data->Memberpayment as $pay) {
                      if ($pay->status == 'not_paid') {
                        $tunggakan++;
                      }else {
                        $lunas++;
                      }
                    }
                  @endphp
                  <td>
                    @if ($tunggakan != 0)
                      <span class="label label-danger">{{$tunggakan}}</span>
                    @endif
                  </td>
                  <td>
                    @if ($lunas != 0)
                      <span class="label label-success">{{$lunas}}</span>
                    @endif
                  </td>
                  <td><a href="{{Help::url('kas-anggota/'.$data->id.'/view')}}" class="btn btn-default">LIHAT DATA</a></td>
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
  <script src="{{asset('plugins/number/jquery.number.min.js')}}" charset="utf-8"></script>
  <script>
    $(document).ready(function() {
      $('table').dataTable();
      $('input[name=date]').datepicker({
        format: "dd-mm-yyyy"
      });
      $('input[name=nominal]').number( true, 0 );
    });

    function deleteAbsen(id) {
      var attr = '{{Help::url('pembayaran-kas')}}/'+id;
      bootbox.confirm("Apakah anda yakin ingin menghapus data pembayaran ini ? Semua data kas akan terhapus.", function(result){
         if (result) {
           $('form#delete').attr('action', attr);
           $('form#delete').submit();
         }
      });
    }
  </script>
@endpush
