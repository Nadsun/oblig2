<?php  /* registrer-student */ ?> 

<h3>Registrer Student </h3>

<form method="post" action="" id="registrerStudentSkjema" name="registrerstudentSkjema">
  Brukernavn <input type="text" id="brukernavn" name="brukernavn" required /> <br/>
  Fornavn <input type="text" id="fornavn" name="fornavn" required /> <br/>
  Etternavn <input type="text" id="etternavn" name="etternavn" required /> <br/>
  
  Klassekode 
  <select name="klassekode" id="klassekode" required>
    <option value="">-- Velg klasse --</option>
    <?php
    include("db-tilkobling.php");  // koble til databasen

    // Hent alle unike klassekoder fra tabellen "klasse" eller "student"
    $sqlSetning = "SELECT DISTINCT klassekode FROM klasse ORDER BY klassekode;";
    $sqlResultat = mysqli_query($db, $sqlSetning) or die("Ikke mulig å hente klassekoder fra databasen");

    while ($rad = mysqli_fetch_array($sqlResultat)) {
        $kode = $rad["klassekode"];
        echo "<option value='$kode'>$kode</option>";
    }
    ?>
  </select>
  <br/><br/>

  <input type="submit" value="Registrer student" id="registrerStudentKnapp" name="registrerStudentKnapp" /> 
  <input type="reset" value="Nullstill" id="nullstill" name="nullstill" /> <br />
</form>

<?php 
mysqli_report(MYSQLI_REPORT_OFF);

if (isset($_POST["registrerStudentKnapp"])) {
    $brukernavn = $_POST["brukernavn"];
    $fornavn = $_POST["fornavn"];
    $etternavn = $_POST["etternavn"];
    $klassekode = $_POST["klassekode"];

    if (!$brukernavn || !$fornavn || !$etternavn || !$klassekode) {
        print("Alle felt må fylles ut, brukernavn, fornavn, etternavn og klassekode må fylles ut");
    } else {
        include("db-tilkobling.php");  

        // Sjekk om brukernavn allerede finnes
        $sqlSetning = "SELECT * FROM student WHERE brukernavn='$brukernavn';";
        $sqlResultat = mysqli_query($db, $sqlSetning) or die("Ikke mulig å hente data fra databasen");
        $antallRader = mysqli_num_rows($sqlResultat); 

        if ($antallRader != 0) {
            print("Studenten er registrert fra før");
        } else {
            $sqlSetning = "INSERT INTO student VALUES('$brukernavn','$fornavn','$etternavn','$klassekode');";
            mysqli_query($db, $sqlSetning) or die("Ikke mulig å registrere data i databasen");

            print("Følgende student er nå registrert: ($brukernavn) - $fornavn $etternavn i $klassekode.<br> Ha en fin dag :)"); 
        }
    }
}
?>
