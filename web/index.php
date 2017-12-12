<html>
	<head>
		<title>Ricerca ristorante</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<link rel="shortcut icon" type="image/x-icon" href="images/l.png" />
	</head>
	<body>
		<?php
		    //Imposto i campi di ricerca di default
			if(isset($_POST["massimo"]))
				$limite=$_POST["massimo"];
			else
				$limite=10;
			if(isset($_POST["citta"]))
				$citta=$_POST["citta"];
			else
				$citta="Bergamo";
			if(isset($_POST["posto"]))
				$query=$_POST["posto"];
			else
				$query="Pizzeria";
			echo "<div class='login-div'>";
			 echo"<div class='login-form'>";
			  echo "<form id='forma' method='post' onsubmit='return controllo();'>";
			  echo "<div class='image-container'>";
			   echo "<img src='images/pizza.png'>";
			  echo "</div>";
			  echo "<div class='select'>";
			   echo "<select id='massimo' name='massimo'>";
			    //echo "<option selected disabled>Scegli il numero massimo</option>";
			    for($massimo=1;$massimo<51;$massimo++)
			     echo"<option value=$massimo>$massimo</option>";
			   echo"</select>";
			  echo "<div class='select_arrow'>";
			  echo "</div>";
			  echo "</div>";
			  echo " Città<br/><input type='text' value='$citta' name='citta' id='citta' /><br/>";
			  echo " Tipologia del locale<br/><input type='text' value='$query' name='query' id='query' /><br/>";
			  echo " <input type='submit' value='Aggiorna tabella' class='btn'/>";
			  echo "</form>";
			 echo "</div>";
			echo "</div>";
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
