<!DOCTYPE html>
<html>
	<head>
		<title>cose</title>
		<link rel="shortcut icon" type="image/x-icon" href="images/l.png" />
		<link rel="stylesheet" type="text/css" href="style.css">
		<script>
			function controllo_campi()
			{
				var valore=document.getElementById("lim").value;
				var esito=false;
				var verifica=/^\d{1,2}$/
				if(document.getElementById("lim").value!=""&&document.getElementById("cit").value!=""&&document.getElementById("que").value!="")
					if(valore.match(verifica)&&parseInt(valore)<51)
						esito=true;
				return esito;
			}
		</script>
	</head>
	<body>
		<?php
			if(isset($_POST["lim"]))
				$lim=$_POST["lim"];
			else
				$lim=10;
			if(isset($_POST["cit"]))
				$cit=$_POST["cit"];
			else
				$cit="bergamo";
			if(isset($_POST["que"]))
				$que=$_POST["que"];
			else
				$que="pizzeria";
			echo ("<div class='login-div'>");
                         echo ("<div class='login-form'>");
			  echo ("<form id='forma' method='post' onsubmit='return controllo_campi();'><br/>");
			     echo ("Numero elementi (1-50) <input type='text' value='$lim' name='lim'id='lim' />");
			     echo ("Citta <input type='text' value='$cit' name='cit' id='cit' />");
			     echo ("Cosa stai cercando <input type='text' value='$que' name='que' id='que' />");
			   echo ("<input type='submit' value='Aggiorna tabella' />");
			  echo ("</form>");
			 echo("</div>");
			echo("</div></br></br></br></br></br>");
			# Questo script chiama un'API e la inserisce in una tabella 
			# Indirizzo dell'API da richiedere
		        $indirizzo_pagina="https://api.foursquare.com/v2/venues/search?v=20161016&query=$que&limit=$lim&intent=checkin&client_id=4DLLUZVXJEQIL0DFCN3B3YFG4EN4W4DMICUVPSNMRD24XKVU&W&client_secret=ZWWMV4LSNXGTZIRIUWHGE5PQDESQ0AHBACUPXVDPTESUTLRX&near=$cit";
			# Codice di utilizzo di cURL
			# Chiama l'API e la immagazzina in $json
			$ch = curl_init() or die(curl_error());
			curl_setopt($ch, CURLOPT_URL,$indirizzo_pagina);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$json=curl_exec($ch) or die(curl_error());
			# Decodifico la stringa json e la salvo nella variabile $data
			$data = json_decode($json);
			# Stampa della tabella delle pizzerie.
			  echo ("<table>");
				echo("<tr>");
				 echo ("<th>NOME</th>");
				 echo ("<th>LATITUDINE</th>");
				 echo ("<th>LONGITUDINE</th>");
				echo "(</tr>");
				for($i=0; $i<$lim; $i++)
				{	
					echo ("<tr>");
					echo ("<td>");
					echo $data->response->venues[$i]->name
					echo ("</td>");
					echo ("<td>");
					echo $data->response->venues[$i]->location->lat;
				 	echo ("</td>");
					echo ("<td>");
					echo $data->response->venues[$i]->location->lng;
					echo ("</td>");
					echo ("</tr>");
				}
			  echo ("</table>");
			# Stampa di eventuali errori
			echo curl_error($ch);
			curl_close($ch);
		?>
	</body>
</html>
