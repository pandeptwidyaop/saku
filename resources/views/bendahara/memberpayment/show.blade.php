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
        <li><a href="{{Help::url('kas-anggota')}}"> Data Kas Anggota</a></li>
        <li class="active">{{$member->Profile->name}}</li>
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
          <h3 class="box-title">Data Seluruh Pembayaran Kas : {{$member->profile->name}}</h3>
        </div>
        <div class="box-body">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Judul</th>
                <th>Tanggal</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($payment as $pay)
                <tr>
                  <td>{{$pay->Payment->title}}</td>
                  <td>{{date('d F Y',strtotime($pay->Payment->date))}}</td>
                  <td>
                    @if ($pay->status == 'paid')
                      <span class="label label-success">LUNAS</span>
                    @else
                      <button type="button" class="btn btn-primary btn-sm" onclick="setLunas('{{$pay->id}}')">BAYAR</button>
                    @endif
                  </td>
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
    <input type="hidden" name="_method" value="put">
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
      //$('table').dataTable();
      $('input[name=date]').datepicker({
        format: "dd-mm-yyyy"
      });
      $('input[name=nominal]').number( true, 0 );
    });

    function setLunas(id) {
      var attr = '{{Help::url('kas-anggota/'.$member->id.'/bayar')}}/'+id;
      bootbox.confirm("Apakah anda yakin ingin melakukan pembayaran ?", function(result){
         if (result) {
           $('form#delete').attr('action', attr);
           $('form#delete').submit();
         }
      });
    }
  </script>
@endpush
