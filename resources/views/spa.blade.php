<!DOCTYPE html>
<html lang="en">
<head>
    <title>Parqueadero</title>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="image/png" href="{{ asset('img/logo.jpg') }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
 
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}" >
 
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-highway.css">
    <style>
        body,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: "Raleway", Arial, Helvetica, sans-serif
        }

    </style>
</head>
<body>
    <div id="app">
         <app></app>
    </div>
    <script>
        //recuperar token
        let token = "{{ session('token') }}" ? "{{ session('token') }}":'';
        if(token){
             localStorage.setItem('token', token)
        }
    </script>
    <script src="{{ mix('js/app.js') }}"></script>


</body>
</html>