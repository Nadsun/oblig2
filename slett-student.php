<?php  /* slett-student */
/*
/*  Programmet lager et skjema for å velge en student som skal slettes  
/*  Programmet sletter den valgte studenten
*/
?> 

<script src="funksjoner.js"> </script>

<h3>Slett student</h3>

Velg student:
<select name="brukernavn" id="brukernavn" required>
  <option value="">-- Velg student --</option>

  <?php  
  include("db-tilkobling.php");  // koble til databasen

  $sqlSetning = "SELECT brukernavn, fornavn, etternavn FROM student ORDER BY etternavn, fornavn;";
  $sqlResultat = mysqli_query($db, $sqlSetning) or die("Ikke mulig å hente data fra databasen");

  while ($rad = mysqli_fetch_array($sqlResultat)) {
      $brukernavn = $rad["brukernavn"];
      $fornavn = $rad["fornavn"];
      $etternavn = $rad["etternavn"];
      echo "<option value='$brukernavn'>$fornavn $etternavn ($brukernavn)</option>";
  }
  ?>
</select>
<br/><br/>


<?php
mysqli_report(MYSQLI_REPORT_OFF);
  if (isset($_POST ["slettStudentKnapp"]))
    {	
      $brukernavn=$_POST ["brukernavn"];
	  
	  if (!$brukernavn)
        {
          print ("Brukernavn m&aring; fylles ut");
        }
      else
        {
          include("db-tilkobling.php");  /* tilkobling til database-serveren utført og valg av database foretatt */

          $sqlSetning="SELECT * FROM student WHERE brukernavn='$brukernavn';";
          $sqlResultat=mysqli_query($db,$sqlSetning) or die ("ikke mulig &aring; hente data fra databasen");
          $antallRader=mysqli_num_rows($sqlResultat); 

          if ($antallRader==0)  /* studenten er ikke registrert */
            {
              print ("Studenten finnes ikke");
            }
          else
            {	  
              $sqlSetning="DELETE FROM student WHERE brukernavn='$brukernavn';";
              mysqli_query($db,$sqlSetning) or die ("ikke mulig &aring; slette data i databasen");
                /* SQL-setning sendt til database-serveren */
		
              print ("F&oslash;lgende student er n&aring; slettet: $brukernavn <br />");
            }
        }
    }
?> 