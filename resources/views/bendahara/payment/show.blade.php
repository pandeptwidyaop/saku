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
        <li><a href="{{Help::url('pembayaran-kas')}}"></i> Pembayaran Kas</a></li>
        <li class="active">{{$payment->title}}</li>
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
          <h3 class="box-title">Pembayaran Kas : {{$payment->title}}</h3>
        </div>
        <div class="box-body">
          <div class="col-md-8">
            <form class="" action="{{Help::url('pembayaran-kas/'.$payment->id.'')}}" method="post" id="formAbsen">
              {{ csrf_field() }}
              <input type="hidden" name="_method" value="put">
                <table class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th rowspan="2">NIM</th>
                      <th rowspan="2">Nama</th>
                      <th colspan="4">Kas</th>
                    </tr>
                    <tr>
                      <td>Lunas</td>
                      <td>Belum</td>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>NIM</th>
                      <th>Nama</th>
                      <th>Lunas</th>
                      <th>Belum</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <input type="hidden" name="_method" value="put">
                    @foreach ($payment->Memberpayment as $absen)
                      <tr>
                        <td>{{$absen->member->profile->nim}}</td>
                        <td>{{$absen->member->profile->name}}</td>
                        <td width="1%"><input type="radio" name="kas[{{$absen->id}}]" value="paid" {{$absen->status == 'paid' ? 'checked' : ''}}></td>
                        <td width="1%"><input type="radio" name="kas[{{$absen->id}}]" value="not_paid" {{$absen->status == 'not_paid' ? 'checked' : ''}}></td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
                <div class="form-group">
                  <button type="submit" class="btn btn-primary pull-right">Simpan</button>
                </div>
            </form>
          </div>
          <div class="col-md-4">
            <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-cog fa-spin"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Otomatis menyimpan</span>
              <span class="info-box-number timer"></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          </div>
        </div>
      </div>
      @if (count($member) != 0)
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Anggota yang belum terdaftar di pembayaran kas : {{$payment->title}}</h3>
            <br><small>Centang untuk memasukan anggota ke pembayaran.</small>
          </div>
          <form class="" action="{{Help::url('pembayaran-kas/'.$payment->id.'/tambah')}}" method="post">
            {{ csrf_field() }}
            <div class="box-body">
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Handphone</th>
                    <th>Pilih</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($member as $m)
                    <tr>
                      <td>{{$m->profile->nim}}</td>
                      <td>{{$m->profile->name}}</td>
                      <td>{{$m->profile->email}}</td>
                      <td>{{$m->profile->handphone}}</td>
                      <td><input type="checkbox" name="member[]" value="{{$m->id}}"></td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <div class="box-footer ">
                  <button type="submit" class="btn btn-primary pull-right">Tambahkan</button>
            </div>
          </form>
        </div>
      @endif
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
  <script src="{{asset('plugins/jquerycountdown/jquery.countdown.min.js')}}"></script>
  <script>
    $(document).ready(function() {
      var expired = new Date().getTime() + 1200000;
      $('table').dataTable({
      "searching": true,
      "ordering": false,
      "paging": true,
      "lengthChange": true,
      "autoWidth": false
      });
      $('input[name=date]').datepicker({
        format: "dd-mm-yyyy"
      });
      $('span.timer').countdown(expired).on('update.countdown', function(event) {
        var $this = $(this);
        $this.html(event.strftime('%H:%M:%S'));
      }).on('finish.countdown',function(event){
        $('#formAbsen').submit();
      });
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
