@include('Vistas.Header')
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css"> 
   <link rel="stylesheet" href="https://www.flaticon.es/iconos-gratis/enlace"> 
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>
<style>
    
/* @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap'); */
h1 {
  font-size: 9vw;
 
  margin-top: 20px;
  font-weight: 600;
  font-size: 18px; 
  text-align: center;   

 background: linear-gradient(
  45deg,
  #000000,
  #1c1c1c,
  #383838,  
  #545454,  
  #707070,  
  #888888,  
  #a9a9a9,  
  #d3d3d3  
); 


font-family: 'Roboto', sans-serif;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  text-fill-color: transparent;
 
} 
.linea {
  border: none;
  height: 0.8px; 
  background-color: #888; 
  width: 100%; 
  margin-top: 10px;
  margin-bottom: 20px; 
}

    </style>
<body>

    <div class="container">
        
         <br><br>
         <h3 style="text-align: center; color: #6f42c1; font-weight: bold; font-family: 'Poppins', sans-serif;">
    No tienes permiso para acceder a esta página.
</h3>
<img src="{{ asset('img/sad-scared.gif') }}" alt="Acceso denegado" class="img-fluid" style="display: block; margin-left: auto; margin-right: auto; width: 40%;">
        <div class="message">
        <h3 style="text-align: center; color: #ff6347; font-family: 'Comic Sans MS', cursive; font-weight: bold;">
    Acceso denegado
</h3>

            <a href="{{ route('principal') }}" class="btn btn-primary">Volver al inicio</a>
        </div>
    </div>
</body>

@include('Vistas.Footer')  