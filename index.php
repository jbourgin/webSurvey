<!DOCTYPE html>

  <head>
      <meta charset="utf-8" />
  	<link rel="stylesheet" href="style2.css" />
      <title>Evaluation d'images</title>
  </head>


  <body>
    <div class = "justified">
      <p><strong>ATTENTION : Merci de noter que cette étude n'est plus ouverte aux étudiants à compter du 9 octobre 2018 (19h). Par conséquent, si vous commencez cette étude après cette date, vous ne pourrez pas bénéficier d'un bon d'expérience. Si vous avez commencé cette étude avant cette date et souhaitez la terminer, vous pouvez bien entendu le faire en indiquant à nouveau vos informations personnelles ci-dessous (et vous obtiendrez votre bon d'expérience).</strong> <br /> <br />
	  Bonjour et merci pour votre participation à cette recherche. <br /> <br />
      Vous allez voir apparaître des images à l'écran. Pour chaque image, vous devrez donner une note de <strong>valence</strong> et une note <strong>d'intensité</strong> sur une échelle de 1 à 5.<br /> <br />
      La <strong>valence</strong> correspond à votre sentiment général lorsque vous regardez l'image : le contenu de l'image est-il plutôt négatif ou positif, agréable ou désagréable à regarder ? <br /> <br />
      L'<strong>intensité</strong> correspond à l'intensité de votre sentiment lorsque vous regardez l'image. Une image intense peut correspondre à une situation générant par exemple émotion, excitation, colère ou peur. <br /> <br />
      Essayez de répondre le plus spontanément possible. Une fois que vous aurez choisi deux notes pour chaque image, appuyez sur valider pour passer à l'image suivante. <br /> <br />
      La durée totale de l'évaluation est d'environ <strong>30 minutes</strong>. Cette tâche étant répétitive, vous pouvez faire une pause si vous le souhaitez. A votre retour sur le site, il vous suffira de redonner les mêmes informations personnelles (code de passation, sexe, âge) pour pouvoir reprendre où vous en étiez.<br /> <br />
      Vous êtes libre d'arrêter la recherche à tout moment. Toutes vos réponses sont anonymes, confidentielles, et ne seront utilisées qu'à des fins de recherche scientifique. <br /> <br />
      Pour cette étude, nous devons collecter quelques informations personnelles, que nous vous demandons de reporter dans l'espace réservé à cet effet ci-dessous. Ces informations resteront strictement confidentielles, et ne seront en aucun cas transmises à un tiers. <br /> <br />
      Si vous avez des questions, ou si vous rencontrez un problème pendant la passation, merci de contacter l'expérimentateur à l'adresse suivante : <strong> jessica.bourgin@univ-savoie.fr</strong> . <br /> <br /> <br /> <br /> <br /> <br />
      </p>

        <form action="test" method="post">
            <p> Veuillez indiquer votre <strong>code de passation</strong>, qui vous sera notamment utile pour récupérer votre bon d'expérience si vous êtes étudiant en psychologie. Ce code se compose de la première lettre de <strong>votre nom</strong>, la première lettre de <strong>votre prénom</strong>, la première lettre du <strong>prénom de votre mère</strong>, et la première lettre du <strong>prénom de votre père</strong>. Par exemple, si vous vous appelez Jean Dupont, que votre mère s'appelle Simone et votre père Marcel, votre code sera : DJSM. </p>

            <input type="text" name="code" required/>

            <p> Veuillez indiquer votre sexe : </p>
                	<input type="radio" value="Femme" name="gender" id = "Femme" required/>
                	<label for="Femme">Femme</label>
                	<input type="radio" value="Homme" name="gender" id = "Homme"/>
                	<label for="Homme">Homme</label>

            <p> Veuillez indiquer votre âge (ex : 19) : </p>
              <input type="text" name="age" required/>

            <p> Veuillez cocher la case suivante afin de continuer : </p>
                <input type="checkbox" name="consent" id="consent" required/>
                <label for="case">Je déclare accepter librement et de façon éclairée de participer à cette étude.</label>

        <div class="buttonHolder">
            <input type="submit" value=">>" name="Begin_exp"/>
        </div>

        </form>
    </div>
  </body>
