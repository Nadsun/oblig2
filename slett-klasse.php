<?php  /* slett-klasse */
/*
/*  Programmet lager et skjema for å velge en klasse som skal slettes  
/*  Programmet sletter den valgte klassen
*/
?> 

<script src="funksjoner.js"></script>

<h3>Slett klasse</h3>

<form method="post" action="" id="slettKlasseSkjema" name="slettKlasseSkjema" onSubmit="return bekreft()">
  Klassekode 
  <select name="klassekode" id="klassekode" required>
    <option value="">-- Velg klasse --</option>
    <?php
    include("db-tilkobling.php");  // koble til databasen

    // Hent alle registrerte klasser
    $sqlSetning = "SELECT klassekode FROM klasse ORDER BY klassekode;";
    $sqlResultat = mysqli_query($db, $sqlSetning) or die("Ikke mulig å hente data fra databasen");

    while ($rad = mysqli_fetch_array($sqlResultat)) {
        $kode = $rad["klassekode"];
        echo "<option value='$kode'>$kode</option>";
    }
    ?>
  </select>
  <br/><br/>

  <input type="submit" value="Slett klasse" name="slettKlasseKnapp" id="slettKlasseKnapp" /> 
</form>

<?php
mysqli_report(MYSQLI_REPORT_OFF);

if (isset($_POST["slettKlasseKnapp"])) {	
    $klassekode = $_POST["klassekode"];
	  
    if (!$klassekode) {
        print("Klassekode må fylles ut");
    } else {
        include("db-tilkobling.php");

        $sqlSetning = "SELECT * FROM klasse WHERE klassekode='$klassekode';";
        $sqlResultat = mysqli_query($db, $sqlSetning) or die("Ikke mulig å hente data fra databasen");
        $antallRader = mysqli_num_rows($sqlResultat); 

        if ($antallRader == 0) {
            print("Klassekode finnes ikke");
        } else {	  
            $sqlSetning = "DELETE FROM klasse WHERE klassekode='$klassekode';";
            mysqli_query($db, $sqlSetning) or die("Ikke mulig å slette data i databasen");

            print("Følgende klasse er nå slettet: <strong>$klassenavn</strong><br />");
        }
    }
}
?>
