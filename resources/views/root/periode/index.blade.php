@extends('layouts.lte')

@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Periode
        <small>Atur seluruh periode kepengurusan</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{Help::url()}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Periode</li>
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
          <h3 class="box-title">Data Seluruh Periode</h3>
        </div>
        <div class="box-body">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Opsi</th>
                <th>Periode</th>
                <th>Jumlah Anggota</th>
                <th>Jumlah Pengguna</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($periode as $p)
                <tr>
                  <td width="5%">
                    <div class="btn-group ">
                      <button type="button" class="btn btn-info dropdown-toggle btn-xs" data-toggle="dropdown">
                        <span><i class="fa fa-gear"></i> Opsi</span>
                      </button>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="{{Help::url('periode/'.$p->id.'/edit')}}">Edit</a></li>
                      </ul>
                    </div>
                  </td>
                  <td>{{$p->periode}}</td>
                  <td>{{count($p->member)}}</td>
                  @php
                    $count = 0;
                    foreach ($p->member as $member) {
                      if ($member->Administrator != null) {
                        $count ++;
                      }
                    }
                  @endphp
                  <td>{{$count}}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Buat Periode Baru</h3>
        </div>
          <form class="" action="{{Help::url('periode')}}" method="post">
            {{ csrf_field() }}
          <div class="box-body">
            <div class="row">
              <div class="col-md-4">
                <label>Periode</label>
                <input type="text" name="periode" value="" class="form-control" required>
              </div>
            </div>
            <div class="config">
              <div class="cfg" id="conf-1">
                <div class="row">
                  <div class="col-md-3">
                    <label>Config Title</label>
                    <input type="text" name="title[]" value="" class="form-control" required>
                  </div>
                  <div class="col-md-4">
                    <label>Value</label>
                    <input type="text" name="config[]" value="" class="form-control" required>
                  </div>
                  <div class="col-md-2">
                    <label>Opsi</label>
                    <br>
                    <div class="btn-group">
                      <button type="button" class="btn btn-default" onclick="deleteConf(this)"><i class="fa fa-minus"></i></button>
                      <button type="button" class="btn btn-default" onclick="addConf(this)"><i class="fa fa-plus"></i></button>
                    </div>
                  </div>
                </div>
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

  <div class="cfg hidden" id="clone">
    <div class="row">
      <div class="col-md-3">
        <label>Config Title</label>
        <input type="text" name="title[]" value="" class="form-control" required>
      </div>
      <div class="col-md-4">
        <label>Value</label>
        <input type="text" name="config[]" value="" class="form-control" required>
      </div>
      <div class="col-md-2">
        <label>Opsi</label>
        <br>
        <div class="btn-group">
          <button type="button" class="btn btn-default" onclick="deleteConf(this)"><i class="fa fa-minus"></i></button>
          <button type="button" class="btn btn-default" onclick="addConf(this)"><i class="fa fa-plus"></i></button>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('css')
<link rel="stylesheet" href="{{asset('plugins/datatables/dataTables.bootstrap.css')}}">
@endsection
@push('js')
  <script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
  <script src="{{asset('plugins/bootbox/bootbox.min.js')}}"></script>
  <script>
    var conf = current = 1;

    $(document).ready(function() {
      $('table').dataTable();
    });

    function addConf(node){
      conf++;
      current++;
      var id = $(node).closest('div.cfg').attr('id');
      var clone  = $('#clone').clone();
      clone.removeClass('hidden');
      clone.attr('id', 'conf-'+conf);
      clone.insertAfter('#'+id);
    }

    function deleteConf(node){
      if (current > 1) {
        current--;
        var id = $(node).closest('div.cfg').attr('id');
        $('#'+id).remove();
      }
    }
  </script>
@endpush
