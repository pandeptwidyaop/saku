@extends('layouts.lte')

@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Pembayaran Kas
        <small>Data Pembayaran Kas seluruh anggota periode {{Auth::user()->periode()}}</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{Help::url()}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Pembayaran Kas</li>
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
          <h3 class="box-title">Buat Pembayaran</h3>
        </div>
        <form class="" action="{{Help::url('pembayaran-kas')}}" method="post">
          {{ csrf_field() }}
          <div class="box-body">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label>Judul</label>
                  <input type="text" name="title" value="" class="form-control" required>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Tanggal</label>
                  <input type="text" name="date" value="" class="form-control" required>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Nominal Kas</label>
                  <input type="text" name="nominal" value="" class="form-control" required>
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
          <h3 class="box-title">Data Seluruh Pembayaran Kas</h3>
        </div>
        <div class="box-body">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Opsi</th>
                <th>Tanggal</th>
                <th>Judul</th>
                <th>Nominal Kas</th>
                <th>Dibayar</th>
                <th>Tidak Membayar</th>
                <th>Total</th>
                <th>Dibuat Oleh</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($payment as $data)
                <tr>
                  <td width="5%">
                    <div class="btn-group ">
                      <button type="button" class="btn btn-info dropdown-toggle btn-xs" data-toggle="dropdown">
                        <span><i class="fa fa-gear"></i> Opsi</span>
                      </button>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="{{Help::url('pembayaran-kas/'.$data->id.'/view')}}">Lihat</a></li>
                        <li><a href="{{Help::url('pembayaran-kas/'.$data->id.'/download')}}">Download (*.xls)</a></li>
                        <li class="divider"></li>
                        <li><a href="{{Help::js()}}" onclick="deleteAbsen('{{$data->id}}')">Hapus Data Kas</a></li>
                      </ul>
                    </div>
                  </td>
                  <td>{{date('d F Y',strtotime($data->date))}}</td>
                  <td>{{$data->title}}</td>
                  <td>Rp. {{number_format($data->nominal,0,',','.')}}</td>
                  <td>
                    @php
                    $bayar = 0;
                    $tbayar = 0;
                    $kas = 0;
                      foreach ($data->Memberpayment as $m) {
                        if ($m->status == 'paid') {
                          $bayar++;
                          $kas+=$data->nominal;
                        }else {
                          $tbayar++;
                        }
                      }
                    @endphp
                    {{$bayar}} anggota.
                  </td>
                  <td>{{$tbayar}} anggota.</td>
                  <td>Rp. {{number_format($kas,2,',','.')}}</td>
                  <td>{{$data->administrator->member->Profile->name}}</td>
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
