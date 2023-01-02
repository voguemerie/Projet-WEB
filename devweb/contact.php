

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style_contact.css">
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <title>Contact</title>
</head>

<body>

    <header>
        <nav>
            <ul id="nav-bar">
                <li><a href="index.php">Les musées</a></li>     
                <li><a href="logout.php">Déconnexion</a></li>
            </ul>
        </nav>
    </header>
    <h3>Vous pouvez nous contacter via ce formulaire</h3>

    <form>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email"><br>
        <label for="subject">Subject:</label><br>
        <input type="text" id="subject" name="subject"><br>
        <label for="text">Text:</label><br>
        <textarea id="text" name="text"></textarea><br>
        <input type="submit" value="Submit">
    </form> 
    
</body>

<script>
  $(document).ready(function() {
    $('form').submit(function(event) {
      event.preventDefault();
      var email = $('#email').val();
      var subject = $('#subject').val();
      var text = $('#text').val();
      $.ajax({
        type: 'POST',
        url: 'addcontact.php',
        data: {
          email: email,
          subject: subject,
          text: text
        },
        success: function(response) {
          // handle the response
          $('#email').val('');
          $('#subject').val('');
          $('#text').val('');
        }
      });
    });
  });

</script>