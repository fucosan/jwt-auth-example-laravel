<!doctype html>
<html lang="en" class="fullscreen-bg">

<head>
	<title>Login | Klorofil - Free Bootstrap Dashboard Template</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<!-- VENDOR CSS -->
	<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/vendor/font-awesome/css/font-awesome.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/vendor/linearicons/style.css') }}">
	<!-- MAIN CSS -->
	<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
	<!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
	<link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}">
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
	<!-- ICONS -->
	<link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}">
	<link rel="icon" type="image/png" sizes="96x96" href="{{ asset('assets/img/favicon.png') }}">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
	<!-- WRAPPER -->
	<div id="wrapper">
		<div class="vertical-align-wrap">
			<div class="vertical-align-middle">
				<div class="auth-box ">
					<div class="left">
						<div class="content">
							<div class="header">
								<div class="logo text-center"><img src="{{ asset('assets/img/logo-dark.png') }}" alt="Klorofil Logo"></div>
								<p class="lead">Login to your account</p>
							</div>
								<div class="form-group">
									<label for="signin-email" class="control-label sr-only">Email</label>
									<input type="email" class="form-control" name="email" id="email" placeholder="Email">
								</div>
								<div class="form-group">
									<label for="signin-password" class="control-label sr-only">Password</label>
									<input type="password" class="form-control" name="password" id="password" placeholder="Password">
								</div>
								<div class="form-group clearfix">
									<label class="fancy-checkbox element-left">
										<input type="checkbox">
										<span>Remember me</span>
									</label>
								</div>
								<button onclick="f()" type="submit" class="login_submit btn btn-primary btn-lg btn-block">LOGIN</button>
								<div class="bottom">
									<span class="helper-text"><i class="fa fa-lock"></i> <a href="#">Forgot password?</a></span>
								</div>
						</div>
					</div>
					<div class="right">
						<div class="overlay"></div>
						<div class="content text">
							<h1 class="heading">Free Bootstrap dashboard template</h1>
							<p>by The Develovers</p>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>
	<!-- END WRAPPER -->
</body>

</html>

<script>

 function reqUserProfile() {
	 var token = localStorage.getItem("mytoken");
	 $.ajax({
		 method: "get",
		 url: "{{ url('api/user-profile') }}",
		 contentType: "application/json",
		 headers: {"Authorization": "Bearer " + token},
	 }).done(function(data, status){

	 }).fail(function(xhr, status, error){
			 console.log(xhr.responseText);
	 });
 }

 function reqhome() {
	 var token = localStorage.getItem("mytoken");
	 var json = "";
	 $.ajax({
		 method: "get",
		 url: "{{ url('api/home') }}",
		 contentType: "text/html",
		 headers: {"Authorization": "Bearer " + token},
	 }).done(function(data, status){
		 document.open();
        document.write(data);
        document.close();
	 });
 }

 function f() {
	 //var email = document.getElementById("email").value;
	 //var pwd = document.getElementByid("password").value;
	 var email = "admin@gmail.com";
	 var pwd = "admin";
	 if (email != "" && pwd != "") {
		  $.ajax({
			 method: "post",
			 url: "{{url('api/authen')}}",
			 data : {email : email, password: pwd}
		 }).done(function(data, status) {
			 localStorage.setItem('mytoken', data.access_token);
			 // the following part makes sure that all the requests made later with jqXHR will automatically have this header.
			 $( document ).ajaxSend(function( event, jqxhr, settings ) {
				 jqxhr.setRequestHeader('Authorization', "Bearer " + data.access_token);
			 });
			 //window.location.href = data_directUrl;
			 location.reload();
			 //reqUserProfile();
			 //reqhome();
		 }).fail(function(xhr, status, error){
			 alert(xhr.responseText);
			 // handle the error
		 });
	 }
 }
</script>
