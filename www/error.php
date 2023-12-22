<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Print GoGoCarto</title>
  <link rel="stylesheet" href="./style.css">
</head>
<body>
  <h1>Print GoGoCarto</h1>
  <div class="container">
    <div class="cta-form">
      <h2>Que voulez-vous imprimer ?</h2> 
    <p></p>
    </div>
    <form action="errors.php" class="form" method="POST">
      <input type="text" placeholder="Name" class="form__input" name="title" id="title" value="My GoGoCartoPrint"/>
      <label for="name" class="form__label">Name</label>
      <input type="text" placeholder="Subject" class="form__input" name="zone" id="zone" value="https://transiscope.gogocarto.fr/api/elements.json?bounds=-4.57031%2C47.50236%2C-3.42773%2C48.26857" />
      <label for="subject" class="form__label">Zone</label>
      <button class="form__input">Voir les erreurs</button>
    </form>
  </div>
</body>
</html>
