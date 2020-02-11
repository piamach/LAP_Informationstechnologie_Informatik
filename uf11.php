<html>
<body>
<?php

// Aufgabenstellung: Anzeigen bestimmter Preisgruppen  der Festplatten mit einem PHP-Programm aus der Tabelle fp der Datenbank hardware. 
//  Preisgruppen (bis 99 Euro, ab 100 Euro bis 149 Euro, ab 150 Euro) auswählbar in einem Formular über Radio-Buttons.
// Ausgabe von Hersteller, Typ und Preis.
// Kontrollkästchens mit der Option der Sortierung der Ausgabe nach Hersteller-Name.

// open new connection
$database=new mysqli('localhost', 'mach', 'naeriel', 'hardware'); 

$auswahl=isset($_POST["auswahl"]);
$check=isset($_POST["check"]);
// isset () function- is used to check whether a variable is set or not
//  returns false if testing variable contains a NULL value
// $_POST is an array of variables passed to the current script via the HTTP POST method

// check connection
if($database->connect_error){
	die('Connect Error('.$database->connect_errno.')'.$database->connect_error);
}

$sqlab="select Hersteller, Typ, Preis from fp where ";

if($auswahl==1)
	$sqlab .= "Preis<=99";
else if($auswahl==2)
	$sqlab .= "Preis>99 and Preis<150";
else if($auswahl==3)
	$sqlab .= "Preis>=150";

if($auswahl==0)
	echo "Es konnten keine passenden Einträge für Sie ermittelt werden.";

if($_POST["check"]=="Yes")
	$sqlab .= "order by Hersteller asc";

// Perform query
$query=sprintf($sqlab);
$resolution=$database->query($query);

if($resolution=$database->query($query)){
	while($row=$resolution->fetch_row()){
		$cnt=mysqli_num_fields($resolution);
		for($i=0;$i<$cnt;$i++)
		{
			printf("%s | ", $row[$i]);
		}
		echo"<br>";
	}
	$resolution->close();
}

// Close the opened database connection	
mysqli_close($database);?>
</body>
</html>