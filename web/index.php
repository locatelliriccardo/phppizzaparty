<!DOCTYPE html>
<html>
	<head>
		<title>Ricerca</title>
		<style type="text/css">
            body {
                background: #6b6b47;
                font-family: sans-serif;   
            }
        	.login-div{
                width: 460px;
                padding: 8% 0 0;
                margin: auto;
        	}
            .login-form{
                position: relative;
                background: #FFFFFF;
                margin: 0 auto 100px;
                padding: 45px;
                text-align: left;
                box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
        	}
        	.login-form p{
        	    margin: 2px;
                padding: 0;
        	}
        	.login-form input[type="text"], input[type="password"], input[type="submit"]{
                font-family: sans-serif;
                background: #ede9e1;
                width: 100%;
                border: 0;
                margin: 0 0 15px;
                padding: 15px;
                box-sizing: border-box;
                font-size: 14px;        	   
        	}
        	.login-form input[type="submit"]:hover{
        	   opacity: 0.8;
        	}
        	
        	.image-container{
        	   width: 50;
        	   padding: 10px;
        	}
        	.image-container img{
                display: block;
                margin-left: auto;
                margin-right: auto 
        	}
		</style>
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
			echo ("<div class=
			echo
			echo "<form id='forma' method='post' onsubmit='return controllo_campi();'><br/>";
			echo "<table>";
			echo "<tr>";
			echo " <td>Numero elementi (1-50): </td><td><input type='text' value='$lim' name='lim'id='lim' /></td>";
			echo "</tr>";
			echo "<tr>";
			echo " <td>Citta: </td><td><input type='text' value='$cit' name='cit' id='cit' /></td>";
			echo "</tr>";
			echo "<tr>";
			echo " <td>Cosa stai cercando?: </td><td><input type='text' value='$que' name='que' id='que' /></td><br/>";
			echo "</tr>";
			echo "</table>";
			echo " <input type='submit' value='Aggiorna tabella' class='btn'/>";
			echo "</form>";
		
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
			echo "<table>";
				echo "<tr>";
					echo "<th>NOME</th>";
					echo "<th>LATITUDINE</th>";
					echo "<th>LONGITUDINE</th>";
				echo "</tr>";
				for($i=0; $i<$lim; $i++)
				{	
					echo "<tr>";
					echo "<td>";
					echo $data->response->venues[$i]->name;
					echo "</td>";
					echo "<td>";
					echo $data->response->venues[$i]->location->lat;
					echo "</td>";
					echo "<td>";
					echo $data->response->venues[$i]->location->lng;
					echo "</td>";
					echo "</tr>";
				}
			echo "</table>";
			# Stampa di eventuali errori
			echo curl_error($ch);
			curl_close($ch);
		?>
	</body>
</html>
