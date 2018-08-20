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
        <li><a href="{{Help::url('periode')}}"></i> Periode</a></li>
        <li><a href="{{Help::js()}}"></i> {{$periode->periode}}</a></li>
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
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Edit Periode : <b>{{$periode->periode}}</b></h3>
        </div>
          <form class="" action="{{Help::url('periode/'.$periode->id)}}" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="put">
          <div class="box-body">
            <div class="row">
              <div class="col-md-4">
                <label>Periode</label>
                <input type="text" name="periode" value="{{$periode->periode}}" class="form-control" required>
              </div>
            </div>
            <div class="config">
              @php
                $count = 0;
                $config = json_decode($periode->config)
              @endphp
              @foreach ($config as $key => $value)
                <div class="cfg" id="conf-1">
                  <div class="row">
                    <div class="col-md-3">
                      <label>Config Title</label>
                      <input type="text" name="title[]" value="{{$key}}" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                      <label>Value</label>
                      <input type="text" name="config[]" value="{{$value}}" class="form-control" required>
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
                @php
                  $count++;
                @endphp
              @endforeach
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
    var conf = current = {{$count}};

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
