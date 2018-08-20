<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('saku.title', 'Laravel') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{asset('plugins/datepicker/bootstrap-datepicker3.min.css')}}">
    <link rel="icon" href="{{asset(config('saku.default.logo'))}}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
      <nav class="navbar navbar-default navbar-static-top">
          <div class="container">
              <div class="navbar-header">
                  <!-- Branding Image -->
                  <a class="navbar-brand" href="{{ url('/') }}">
                      {{ config('saku.title', 'Laravel') }}
                  </a>

              </div>

          </div>

      </nav>
      <div class="container">
          <div class="row">
              <div class="col-md-8 col-md-offset-2">
                @if (Alert::have())
                  <div class="alert alert-{{Alert::type()}}">{{Alert::msg()}}</div>
                @endif

                  <div class="panel panel-default">
                      <div class="panel-heading">Pendaftaran Anggota Aktif Periode {{$periode->periode}}</div>
                      <div class="panel-body">
                          <form class="form-horizontal" method="POST" action="{{ url('member/'.$periode->id.'/oldmember') }}">
                              {{ csrf_field() }}

                              <div class="form-group{{ $errors->has('nim') ? ' has-error' : '' }}">
                                  <label for="nim" class="col-md-4 control-label">NIM</label>

                                  <div class="col-md-6">
                                      <input id="nim" type="text" class="form-control" name="nim" value="{{ old('nim') }}" placeholder="Masukan nim anda" required autofocus>

                                      @if ($errors->has('nim'))
                                          <span class="help-block">
                                              <strong>{{ $errors->first('nim') }}</strong>
                                          </span>
                                      @endif
                                  </div>
                              </div>



                              <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                  <label for="email" class="col-md-4 control-label">Alamat Email</label>

                                  <div class="col-md-6">
                                      <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Masukan alamat email anda yang terdaftar" required autofocus>

                                      @if ($errors->has('email'))
                                          <span class="help-block">
                                              <strong>{{ $errors->first('email') }}</strong>
                                          </span>
                                      @endif
                                  </div>
                              </div>

                              <div class="form-group{{ $errors->has('birthday') ? ' has-error' : '' }}">
                                  <label for="d" class="col-md-4 control-label">Tanggal Lahir</label>

                                  <div class="col-md-6">
                                      <input id="d" type="text" class="form-control" name="birthday" value="{{ old('birthday') }}" placeholder="Ex : 20-04-1995" required autofocus>

                                      @if ($errors->has('birthday'))
                                          <span class="help-block">
                                              <strong>{{ $errors->first('birthday') }}</strong>
                                          </span>
                                      @endif
                                  </div>
                              </div>
                              <div class="form-group {{ $errors->has('agreement') ? ' has-error' : '' }}">
                                <div class="col-md-6 col-md-offset-4">
                                  <input type="checkbox" name="agreement"> Dengan ini sayan menyatakan bersedia menjadi anggota aktif {{$periode->periode}}
                                  @if ($errors->has('agreement'))
                                      <span class="help-block">
                                          <strong>{{ $errors->first('agreement') }}</strong>
                                      </span>
                                  @endif
                                </div>
                              </div>
                              <div class="form-group">
                                  <div class="col-md-6 col-md-offset-4">
                                      <button type="submit" class="btn btn-primary pull-right">
                                          Daftar
                                      </button>
                                  </div>
                              </div>
                          </form>
                      </div>
                  </div>
              </div>
          </div>
      </div>
    </div>

    <!-- Scripts -->
    <script src="{{asset('plugins/jQuery/jquery-2.2.3.min.js')}}" charset="utf-8"></script>
    <script src="{{asset('plugins/datepicker/bootstrap-datepicker.js')}}" charset="utf-8"></script>
    <script type="text/javascript">
      $(document).ready(function() {
        $('input[name=birthday]').datepicker({
            format: 'dd-mm-yyyy',
        });
      });
    </script>
</body>
</html>
