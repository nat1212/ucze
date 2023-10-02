<!DOCTYPE html>
<html>
<head>
    <title>Przypomnienie o wydarzeniu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
			
        }
        
        h1 {
            margin: 0;
            padding: 10px;
            background-color: #000;
            color: #fff;
            border: 2px solid #000;
            padding-right: 20px; 
        }
		
		h2 {
			
            margin-left: 20px;
            
        }
        p {
		font-size:19px;
			margin-left: 20px;
              color: black;
        }
		
		h3 {
		font-size:17px;
		font-weight:bold;
			margin-top:15px;
            margin-left: 20px;
            
        }
		space{
		margin:40px;
		}
		
		span{
			font-weight: normal
		
		}
		
		.tak{
		margin:25px;
		}
		
		.tak1{
		margin:35px;
		}
		.tak3{
		font-size:19px;
			margin-left: 15px;
            color: black;
			font-weight:bold;
		}
		
		.tak4{
		margin:70px;
		}
		.tak7{
		margin:50px;
		}
    </style>
</head>
<body>
    <h1>Przypomnienie o wydarzeniu!</h1>
		 <div class = "tak1"></div>
	<h2>{{  $uNazwisko }}!</h2>
	 <div class = "tak1"></div>
	
	 <p>Z przyjemnością informujemy o zbliżającym się wydarzeniu: <strong>{{ $nazwaWydarzenia }}</strong> na które jesteś zapisany/a. Wydarzenie startuje <strong>{{ $dataWydarzenia }}</strong> o godz.<strong>{{ $godzinaWydarzenia }}</strong>. </p>
 <div class = "tak"></div>
	 <p>Nie może cię tam zabraknąć!</p>
	
 <div class = "tak4"></div>
	<h3>Nazwa wydarzenia: <span>{{ $nazwaWydarzenia }}</span></h3>
	<h3>Data: <span>{{ $dataWydarzenia }} </span> </h3>
	<h3>Godzina: <span> {{$godzinaWydarzenia }}</span> </h3>
	<h3>Prowadzący: <span>{{ $Imie }} {{ $Nazwisko }}</span> </h3>

	<div class = "tak4"></div>
	<h3><span>Aby przejść do naszej aplikacji, kliknij poniższy link:</span></h3>
	<h3><span><a href="http://szkola.test/home">Przejdź do aplikacji</a></span></h3>

	<div class = "tak7"></div>
	  <div class="tak3">Ta wiadomość została wygenerowana automatycznie,prosimy na nią nie odpowiadać.</div>
	  <p>Pozdrawiamy,</p>
	  <p>SN</p>

	

</body>
</html>
