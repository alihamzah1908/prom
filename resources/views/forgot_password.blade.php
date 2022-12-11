<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="{{url('assets/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    {{-- <link rel="stylesheet" href="{{url('assets/vendor/linearicons/style.css') }}"> --}}
	<!-- MAIN CSS -->
	<link rel="stylesheet" href="{{url('assets/css/main.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{url('assets/AdminLTE.min.css') }}">
    <!-- iCheck -->
    {{-- <link rel="stylesheet" href="{{url('assets/blue.css') }}"> --}}
    <script src="https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.23.0/firebase-messaging.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.23.0/firebase-analytics.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>

<body class="hold-transition login-page">
    <div id="wrapper">
		<div class="vertical-align-wrap">
			<div class="vertical-align-middle">
				<div class="auth-box ">
					<div class="left">
						<div class="content">
                            <div class="icon">
                                <span><i class="fa fa-user fa-10x"></i></span>
                            </div>
							<div class="header">
								<h3 class="lead text-primary"><b>Reset Password</b></h3>
							</div>
							<!--<form class="form-auth-small" action="index.php">-->
							<form method="POST" action="/reset_password" class="form-auth-small form-new-task-template">
                            @csrf
								<div class="form-group">
									<label for="signin-email" class="control-label sr-only">Email</label>
									<input type="email" class="form-control rounded" id="signin-email" placeholder="Masukan Email Anda" required name="email">
								</div>
                                <div class="bottom">
									<span class="helper-text"><i class="fa fa-sign-in"></i> <a href="/login">Login?</a></span>
                                </div>
                                <button type="submit" class="btn btn-primary btn-lg btn-block">RESET</button>
                                <div class="power">
                                    <span class="text-center">Power by</span>
                                    <img src="{{url('adminlte/img/logo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle">
                                </div>
							</form>
                        </div>
					</div>
					<div class="right">
						<div class="overlay"></div>
					</div>
                    <div class="clearfix"></div>

				</div>
			</div>
		</div>
	</div>
	@include('modals')
    <!-- /.login-box -->
    <!-- jQuery 2.2.3 -->
    <script src="{{url('assets/jquery-2.2.3.min.js') }}"></script>
    <!-- Bootstrap 3.3.6 -->
    <script src="{{url('assets/bootstrap.min.js') }}"></script>
    <script src="/js/helper.js?d={{date('y-m-d H:i:s')}}"></script>
    
    @if(Session::has('message'))
        <?php $message = Session::get('message'); ?>
        @if(Session::get('status') == 'success')
            <script>successAlert("{{$message}}")</script>
        @else
            <script>failedAlert("{{$message}}");</script>
        @endif
    @endif
    
            
    <script>
        $(document).on('submit', '.form-new-task-template', function(e){
            e.preventDefault();
            var ini = $(this),  input_token = ini.find('input[name=_token]'),   url = ini.attr('action');
            var post_data = {
                is_ajax: true,
                _token: input_token.val(),
                email: ini.find('input[name=email]').val()
            };
            
            var e_modal_wait = $("#modalWait");
            showLoading(e_modal_wait);
            
            postData(post_data);
    
            function postData(post_data) {
                $.ajax({
                    url: url,
                    type: "post",
                    data: post_data
                })
                .done(function (result) {
                    hideLoading(e_modal_wait);
                    if (result.status) {
                        var message = result.message || 'Success';
                        successAlert(message);
                        window.location.href = "/login";
                    } else {
                        var message = result.message || 'Not found!';
                        failedAlert(message);
                    }
                    input_token.val(result.newtoken);
                })
                .fail(ajax_fail);
            }
        })
    </script>

</body>

</html>
