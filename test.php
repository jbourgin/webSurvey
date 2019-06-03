<?php
    // We make contact with the database
    try
    {
	// Enter database login information here
      if($_SERVER['HTTP_HOST'] != 'localhost')
      {
        $bdd = new PDO('mysql:host=XXX;dbname=XXX;charset=utf8', 'username', 'password', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        define('URL','');
      }
      else {
        $bdd = new PDO('mysql:host=localhost;dbname=XXX;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        define('URL','');
      }

    }
    catch(Exception $e)
    {
        die('Erreur : '.$e->getMessage());
    }

    // We set the variables to put in the database
    $code = isset($_POST['code']) ? $_POST['code'] : NULL;
    $age = isset($_POST['age']) ? $_POST['age'] : NULL;
    $gender = isset($_POST['gender']) ? $_POST['gender'] : NULL;
    $arousal = isset($_POST['arousal']) ? $_POST['arousal'] : NULL;
    $valence = isset($_POST['valence']) ? $_POST['valence'] : NULL;
    $image = isset($_POST['image']) ? $_POST['image'] : NULL;
    $participant = isset($_POST['participant']) ? $_POST['participant'] : NULL;

    // If a previous trial has been validated, we put the fetched data in the database
    if (isset($_POST['validResp'])) {

        // We make sure that the participant has not already given an answer for this image
        $queryTest = "  SELECT id_answer
                        FROM answer
                        WHERE id_participant = '".$participant."' AND name_image = '".$image."'
        ";
        $selectTest = $bdd->prepare($queryTest);
        $selectTest->execute();
        $resultTest = $selectTest->fetch();
        if(!$resultTest)
        {
          // We set the time zone to Paris
          date_default_timezone_set('Europe/Paris');
          $date_time=date('Y-m-d H:i:s');
          $image = str_replace("images/", "", $image);
          $req = $bdd->prepare('INSERT INTO answer(id_participant, name_image, valence, arousal, date_time) VALUES(:participant, :image, :valence, :arousal, :date_time)');
              $req->execute(array(
              	'participant' => $participant,
              	'image' => $image,
              	'valence' => $valence,
              	'arousal' => $arousal,
              	'date_time' => $date_time
              	));
        }
    }

    elseif (isset($_POST['Begin_exp']))
    {

      // We make sure that the participant does not already exist
      $queryTestParticipantExists = "  SELECT id_participant
                      FROM participant
                      WHERE code = '".$code."' AND age = '".$age."' AND genre = '".$gender."'
      ";
      $selectTest = $bdd->prepare($queryTestParticipantExists);
      $selectTest->execute();
      $resultParticipantExists = $selectTest->fetch();

      // If the participant does not exist, we automatically create an id for him in the participant table
      if(!$resultParticipantExists)
      {

        $insertParticipant =  $bdd->prepare('INSERT INTO participant (code, age, genre) VALUES(:code, :age, :genre)');
        $insertParticipant->execute(array(
          'code' => $code,
          'age' => $age,
          'genre' => $gender,
        ));
        $participant = $bdd->lastInsertId();
      }

      // Else, we get back his id from the participant table
      else {
        $participant = $resultParticipantExists[0];
      }
    }

    // We determine the trial number
    $inter = $bdd->prepare("SELECT COUNT(*) FROM answer WHERE id_participant = '".$participant."'");
    $inter->execute();
    $result = $inter->fetchAll();
    $trialnumber = $result[0][0];
    //echo $trialnumber;

    // We exit the trial page if the number of trials has reached 115
    if ($trialnumber >= 120)
    {
        header('location: '.URL.'end');
        exit();
    }

    elseif ($participant == NULL)
    {
        header('location: '.URL.'redirection');
        exit();
    }

?>

<!DOCTYPE html>

<html>

	<?php
  // We get the images from the database Image
  $imageToPrint = NULL;

  $imagesDir = 'images/';
	$images = glob($imagesDir . '*.{png}', GLOB_BRACE);
  shuffle($images);
  //var_dump($images);

  // We get the images for which we have an answer
  $queryImagesAnswered = "  SELECT name_image
                            FROM answer
  ";
  $inter = $bdd->prepare($queryImagesAnswered);
  $inter->execute();
  $resultImagesAnswered = $inter->fetchAll();

  $ImagesAnswered = array();
  foreach($resultImagesAnswered as $ImageAnswered)
  {
    $ImagesAnswered[] = $ImageAnswered['name_image'];
  }

  // If an image has never been seen, it is prioritised
  foreach($images as $image)
  {
    $image = str_replace("images/", "", $image);
    if(!in_array($image, $ImagesAnswered)) {
      $imageToPrint = $image;
      break;
    }
  }

  if (empty($imageToPrint)) {

    // We get the minimal number of occurrences of images
    $less_occ = NULL;
    $queryOccurrences = " SELECT name_image, count(name_image)
                          AS less_fq
                          FROM answer
                          GROUP BY name_image
                          ORDER BY less_fq
                          ";
    $inter = $bdd->prepare($queryOccurrences);
    $inter->execute();
    $resultOccurrences = $inter->fetchAll();
    if(!empty($resultOccurrences))
    {
        $less_occ = $resultOccurrences[0]['less_fq'];
    }

    // We get the images for which we have answers superior to the minimal number of occurrences
    $queryImagesNotOk = "  SELECT name_image AS name_image
                        FROM (SELECT name_image, COUNT(*) AS counter
                        FROM answer
                        GROUP BY name_image) AS tbl
                        WHERE counter > '".$less_occ."'
    ";
    $inter = $bdd->prepare($queryImagesNotOk);
    $inter->execute();
    $resultImagesNotOk = $inter->fetchAll();

    $ImagesNotOk = array();
    foreach($resultImagesNotOk as $ImageNotOk)
    {
      $ImagesNotOk[] = $ImageNotOk['name_image'];
    }

    // We get the images already seen by the current participant
    $queryImagesSeen = " SELECT name_image
                            FROM answer
                            WHERE id_participant = '".$participant."'
    ";

    $inter = $bdd->prepare($queryImagesSeen);
    $inter->execute();
    $resultImagesSeen = $inter->fetchAll();

    $ImagesSeen = array();
    foreach($resultImagesSeen as $ImageSeen)
    {
      $ImagesSeen[] = $ImageSeen['name_image'];
    }

    foreach($images as $image) {
      $image = str_replace("images/", "", $image);
      // If all images have already been seen, we get an image conform to the two conditions (not seen by the participant and low number of occurrences)
      if(!in_array($image, $ImagesSeen) && !in_array($image, $ImagesNotOk))
      {
        $imageToPrint = $image;
        break;
      }
    }
  }

  // If we find no correct image -> we redirect to the end
  if(empty($imageToPrint))
  {
    //die("c'est la fin ".$participant);
    header('location: '.URL.'end');
    exit();
  }

	?>

	<head>
        <meta charset="utf-8" />
		<link rel="stylesheet" type="text/css" href="style.css?v=1" />
        <title>Evaluation d'images</title>
    </head>


    <body>
		<div class="main_part">
			<div class = "buttonHolder">
        <img src= 'images/<?= $imageToPrint ?>' />
			</div>

			<form action="test" method = 'post'>

				<!--We draw the table with the two questions that each participant must answer-->
				<p>
					<table class = "fixed" align="center">
					    <col width="560px" />
                        <col width="88px" />
                        <col width="88px" />
                        <col width="88px" />
                        <col width="88px" />
                        <col width="88px" />
						<tr class = "centered">
							<td></td>
							<td>Très agréable</td>
							<td>Un peu agréable</td>
							<td>Neutre</td>
							<td>Un peu désagréable</td>
							<td>Très désagréable</td>
						</tr>

						<tr class = "justified">
							<td>Ce type d'événement est-il pour vous plutôt agréable ou désagréable ?</td>
							<td><input type="radio" name="valence" value="1" id="1" required/></td>
							<td><input type="radio" name="valence" value="2" id="2" /></td>
							<td><input type="radio" name="valence" value="3" id="3" /></td>
							<td><input type="radio" name="valence" value="4" id="4" /></td>
							<td><input type="radio" name="valence" value="5" id="5" /></td>
						</tr>
					</table>

					<table class = "fixed" align="center">
					    <col width="560px" />
                        <col width="88px" />
                        <col width="88px" />
                        <col width="88px" />
                        <col width="88px" />
                        <col width="88px" />
						<tr class = "centered">
							<td></td>
							<td>Pas du tout</td>
							<td>Un peu</td>
							<td>Moyen</td>
							<td>Beaucoup</td>
							<td>Tout à fait</td>
						</tr>

						<tr class = "justified">
							<td>Si vous étiez face à cette situation, l'intensité de votre sentiment serait-elle élevée ?</td>
							<td><input type="radio" name="arousal" value="1" id="1" required/></td>
							<td><input type="radio" name="arousal" value="2" id="2" /></td>
							<td><input type="radio" name="arousal" value="3" id="3" /></td>
							<td><input type="radio" name="arousal" value="4" id="4" /></td>
							<td><input type="radio" name="arousal" value="5" id="5" /></td>
						</tr>

					</table>
				</p>

				<div class="buttonHolder">
					<!--We get bach the Code, Age, Gender and image value for next trial.-->
					<input type="hidden" name="code" value= <?php echo $code ?> />
                    <input type="hidden" name="age" value= <?php echo $age ?> />
                    <input type="hidden" name="gender" value= <?php echo $gender ?> />
                    <input type="hidden" name="image" value= <?php echo $imageToPrint ?> />
                    <input type="hidden" name="participant" value= <?php echo $participant ?> />
					<input type="submit" value="Valider" name="validResp"/>
				</div>
			</form>
        <div class="buttonHolder">
            <progress id="file" name="file" max="120" value= <?php echo $trialnumber ?> >
            </progress>
        </div>
		</div>
    </body>
</html>
