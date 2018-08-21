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
                          <form class="form-horizontal" method="POST" action="{{ url('member/'.$periode->id.'/registration') }}">
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

                              <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                  <label for="b" class="col-md-4 control-label">Nama</label>

                                  <div class="col-md-6">
                                      <input id="b" type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Masukan nama lengkap anda" required autofocus>

                                      @if ($errors->has('name'))
                                          <span class="help-block">
                                              <strong>{{ $errors->first('name') }}</strong>
                                          </span>
                                      @endif
                                  </div>
                              </div>

                              <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                  <label for="email" class="col-md-4 control-label">Alamat Email</label>

                                  <div class="col-md-6">
                                      <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Masukan alamat email anda" required autofocus>

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

                              <div class="form-group{{ $errors->has('sex') ? ' has-error' : '' }}">
                                  <label for="f" class="col-md-4 control-label">Jenis Kelamin</label>

                                  <div class="col-md-6">
                                      <select id ="f" class="form-control" name="sex" required autofocus>
                                        <option value="">Jenis Kelamin</option>
                                        <option value="male" {{old('sex') == 'male' ? 'selected' : ''}}>Pria</option>
                                        <option value="female" {{old('sex') == 'female' ? 'selected' : ''}}>Wanita</option>
                                      </select>
                                      @if ($errors->has('sex'))
                                          <span class="help-block">
                                              <strong>{{ $errors->first('sex') }}</strong>
                                          </span>
                                      @endif
                                  </div>
                              </div>
                              <div class="form-group{{ $errors->has('handphone') ? ' has-error' : '' }}">
                                  <label for="g" class="col-md-4 control-label">Handphone</label>

                                  <div class="col-md-6">
                                      <input id="g" type="text" class="form-control" name="handphone" value="{{ old('handphone') }}" placeholder="Masukan nomor handphone anda" required autofocus>

                                      @if ($errors->has('handphone'))
                                          <span class="help-block">
                                              <strong>{{ $errors->first('handphone') }}</strong>
                                          </span>
                                      @endif
                                  </div>
                              </div>

                              <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                  <label for="h" class="col-md-4 control-label">Alamat</label>

                                  <div class="col-md-6">
                                      <textarea id="h" class="form-control" name="address" rows="4" cols="80" required autofocus>{{ old('address') }}</textarea>
                                      @if ($errors->has('address'))
                                          <span class="help-block">
                                              <strong>{{ $errors->first('address') }}</strong>
                                          </span>
                                      @endif
                                  </div>
                              </div>
                              <div class="form-group{{ $errors->has('captcha') ? ' has-error' : '' }}">
                                  <label for="h" class="col-md-4 control-label"></label>

                                  <div class="col-md-6">
                                  <div class="g-recaptcha" data-sitekey="{{env('RECAPTCHA_SITE_KEY',null)}}"></div>
                                      @if ($errors->has('captch'))
                                          <span class="help-block">
                                              <strong>{{ $errors->first('address') }}</strong>
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
                              <a href="{{url('member/'.$periode->id.'/oldmember')}}" class="center">Saya sudah pernah menjadi anggota sebelumnya.</a>
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
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script type="text/javascript">
      $(document).ready(function() {
        $('input[name=birthday]').datepicker({
            format: 'dd-mm-yyyy',
        });
      });
    </script>
</body>
</html>
