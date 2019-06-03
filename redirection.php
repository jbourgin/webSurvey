<!DOCTYPE html>

  <head>
      <meta charset="utf-8" />
  	<link rel="stylesheet" href="style2.css" />
      <title>Evaluation d'images</title>
  </head>


  <body>
    <div class = "justified">
      <p><strong>ATTENTION : Merci de noter que cette étude n'est plus ouverte aux étudiants à compter du 9 octobre 2018 (19h). Par conséquent, si vous commencez cette étude après cette date, vous ne pourrez pas bénéficier d'un bon d'expérience. Si vous avez commencé cette étude avant cette date et souhaitez la terminer, vous pouvez bien entendu le faire en indiquant à nouveau vos informations personnelles ci-dessous (et vous obtiendrez votre bon d'expérience).</strong> <br /> <br />
	  Oups ! Vous êtes arrivé(e) sur la page de test sans que vos identifiants aient été enregistrés ! <br /> <br />
      Merci de bien vouloir (re)donner vos informations personnelles ci-dessous pour pouvoir continuer le test.
      <br /> <br /><br /> <br /> </p>

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
