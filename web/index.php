<html>
	<head>
		<title>Ricerca ristorante</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<link rel="shortcut icon" type="image/x-icon" href="images/l.png" />
		<script>
			function controllo()
			{
				var numero=document.getElementById("limite").value;
				var ok=false;
				var verifica=/^\d{1,2}$/
				if(document.getElementById("limite").value!=""&&document.getElementById("citta").value!=""&&document.getElementById("query").value!="")
					if(numero.match(verifica)&&parseInt(numero)<51)
						ok=true;
				return ok; 
			}
		</script>
	</head>
	<font size="6">Pagina per la ricerca di un ristorante:</font><br />
	<body>
		<?php
		    //Imposto i campi di ricerca di default
			if(isset($_POST["limite"]))
				$limite=$_POST["limite"];
			else
				$limite=15;
			if(isset($_POST["citta"]))
				$citta=$_POST["citta"];
			else
				$citta="Bergamo";
			if(isset($_POST["query"]))
				$query=$_POST["query"];
			else
				$query="Pizzeria";
			
			//Form ddei dati di ricerca
			echo "<div class='login-div'>";
			 echo"<div class='login-form'>";
			  echo "<form id='forma' method='post' onsubmit='return controllo();'>";
			  echo " Numero elementi (da 1 a massimo 50):<input type='text' value='$limite' name='limite'id='limite' /><br/>";
			  echo " Citta: <input type='text' value='$citta' name='citta' id='citta' /><br/>";
			  echo " Tipologia del locale: <input type='text' value='$query' name='query' id='query' /><br/>";
			  echo " <input type='submit' value='Aggiorna tabella' class='btn'/>";
			  echo "</form>";
			 echo "</div>";
			echo "</div>";
			//Salvo il link di richiestain una variabile
	    
			$indirizzo="https://api.foursquare.com/v2/venues/search?v=20161016&query=$query&limit=$limite&intent=checkin&client_id=4DLLUZVXJEQIL0DFCN3B3YFG4EN4W4DMICUVPSNMRD24XKVU&W&client_secret=ZWWMV4LSNXGTZIRIUWHGE5PQDESQ0AHBACUPXVDPTESUTLRX&near=$citta";
			$ch = curl_init() or die(curl_error());
			curl_setopt($ch, CURLOPT_URL,$indirizzo);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$json=curl_exec($ch) or die(curl_error());
			$dati = json_decode($json);
			echo "<div class='table-div'>";
			echo"<div class='login-form'>";
			echo"<table id='customers'><tr><th>Nome Pizzeria</th><th>Latitudine</th><th>Longitudine</th></tr>";
			for($i=0; $i<$limite; $i++)
			{	
				echo "<tr>";
					echo "<td>";
					echo $dati->response->venues[$i]->name;
					echo "</td>";
					echo "<td>";
					echo $dati->response->venues[$i]->location->lat;
					echo "</td>";
					echo "<td>";
					echo $dati->response->venues[$i]->location->lng;
					echo "</td>";
				echo "</tr>";
			}
			echo "</table>";
			echo "</div>";
			echo "</div>";
			echo curl_error($ch);
			curl_close($ch);	
		?>
	</body>
</html>
