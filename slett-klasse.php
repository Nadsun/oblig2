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
<?php
mysqli_report(MYSQLI_REPORT_OFF);

if (isset($_POST["slettKlasseKnapp"])) {	
    $klassekode = $_POST["klassekode"];
	  
    if (!$klassekode) {
        print("Klassekode må fylles ut");
    } else {
        include("db-tilkobling.php"); // koble til databasen

        // Hent klassenavn FØR sletting
        $sqlSetning = "SELECT klassenavn FROM klasse WHERE klassekode='$klassekode';";
        $sqlResultat = mysqli_query($db, $sqlSetning) or die("Ikke mulig å hente data fra databasen");
        
        if (mysqli_num_rows($sqlResultat) == 0) {
            print("Klasse finnes ikke");
        } else {
            $rad = mysqli_fetch_assoc($sqlResultat);  // hent rad som assosiativ array
            $klassenavn = $rad['klassenavn'];        // nå er variabelen definert

            // Slett klassen
            $sqlSlett = "DELETE FROM klasse WHERE klassekode='$klassekode';";
            mysqli_query($db, $sqlSlett) or die("Ikke mulig å slette data i databasen");

            print("Følgende klasse er nå slettet: <strong>$klassenavn</strong> ($klassekode)<br />");
        }
    }
}
?>
