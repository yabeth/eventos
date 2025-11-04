<bs5-1>
<!doctype html>
<html lang="en">
  <head>
  	<title>Iniciar sesión</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<link rel="stylesheet" href="assets/css/style.css">
 <style>
	.container{
		
	min-height:500px;
	width: 450px;
	border: 0.5px solid #999;
	border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, .2);
	backdrop-filter: blur(10px);
  
   top: 50%;
   left: 50%;
   transform: translate( -50% -50%);
   box-sizing: absolute;
   padding: 70px 30px;
}
.form-group{
	width: 270px;
	margin-left: -85px;
}
.usrimg { 
   width: 130px;
   height: 150px;

   overflow: hidden;
   position: absolute;
   top: calc(-80px/2);
   left: calc(50% - 50px);
   margin-left: -40px;
	} 

 </style>
	</head>
	<body class="img js-fullheight" style="background-image: url(assets/images/una.jpg);">
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 text-center mb-5">
				<img class="usrimg" src="assets/images/logou.png" /> 
					
				</div>
			</div>
			
			<div class="row justify-content-center">
				<div class="col-md-6 col-lg-4">
					<div class="login-wrap p-0">
					<br><br><h2 class="heading-section" style="margin-left: -45px;">Iniciar sesión</h2><br>
		      	<form action="#" class="signin-form">
		      		<div class="form-group">
		      			<input type="text" class="form-control" placeholder="Usuario" required>
		      		</div>
					
	            <div class="form-group ">
	              <input id="password-field" type="password" class="form-control" placeholder="Contraseña" required>
	              <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
	            </div>
	            <div class="form-group">
                <button type="button" class="form-control btn btn-green submit px-3" 
                onclick="window.location.href='http://localhost/eventos/public/principal.php'">INICIAR SESIÓN</button>

		
	            </div>
	            <div class="form-group d-md-flex">
	            	<div class="w-50">
		            	<label class="checkbox-wrap checkbox-primary">Acuérdate de mí
									  <input type="checkbox" checked>
									  <span class="checkmark"></span>
									</label>
								</div>
								<div class="w-50 text-md-right">
									<a href="#" style="color: #fff">Has olvidado tu contraseña</a>
								</div>
	            </div>
	          </form>
	          
	    
		      </div>
				</div>
			</div>
		</div>
	</section>

	<script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/popper.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/main.js"></script>

	</body>
</html>

</bs5-1>





