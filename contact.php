<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ogani Template">
    <meta name="keywords" content="Ogani, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contact</title>
    <?php include 'bs-cdn.php';?>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">
    <!-- Css Styles -->
    <link rel="stylesheet" href="/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="/css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="/css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="/css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="/css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="/css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="/css/style.css" type="text/css">
</head>

<body>
    <?php include 'header.php';?>
    <div class="container m-5 my-5">
        <div class="container d-flex align-items-center justify-content-center">
            <div class="row">
                <div class=" text-center"><br><br>
                    <h1>Contact Us</h1>
                    <p>Jika ada keluhan atau bug di website silahkan hubungi kami!!</p>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col">
                <span class="email-text">Email<i class="fa-solid fa-envelope"></i></span>
                <p class="email">Kantintpg2@gmail.com</p>
                <!-- Garis -->
                <div class="row">
                    <div class="col-5">
                        <hr class="my-4">
                    </div>
                </div>
                <!-- Garis -->
                <span>Whatsapp<i class="fa-brands fa-whatsapp"></i></span>
                <p>+62 856-9500-1799</p>
                <!-- Garis -->
                <div class="row">
                    <div class="col-5">
                        <hr class="my-4">
                    </div>
                </div>
                <!-- Garis -->
                <span>Instagram<i class="fa-brands fa-instagram"></i></span>
                <p>@kantintpgg2</p>
            </div>
            <div class="col">
                <form action="" id="phoneForm">
                    <div class="form-outline mb-4">
                        <label class="form-label" for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control col-5" placeholder="example: John Doe" required/>
                    </div>
                    <div class="form-outline mb-4">
                        <label class="form-label" for="email">Email</label>
                        <input type="text" name="email" id="email" class="form-control form-control-md" placeholder="name@example.com" required/>
                    </div>
                    <div class="form-outline mb-4">
                        <label class="form-label" for="phoneNumber">Phone Number</label>
                        <input type="tel" name="phoneNumber" id="phoneNumber" class="form-control form-control-md" placeholder="example: +6212345678" required/>
                    </div>
                    <div class="form-outline mb-4">
                        <label class="form-label" for="Message">Message</label>
                        <div class="col-md-12">
                            <textarea type="text" class="form-control form-control-sm" rows="5" name="Message" id="Message" required></textarea>
                        </div><br><br>
                        <div class="row mb-3">
                            <div class="col-4">
                                <button type="button" onclick="sendWhatsApp()" name="regis" class="btn btn-success btn-block w-100">Kirim</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
      function sendWhatsApp() {
          // Get form data
          var name = document.getElementById('name').value;
          var email = document.getElementById('email').value;
          var phoneNumber = document.getElementById('phoneNumber').value;
          var messageText = document.getElementById('Message').value;

          // Validate form data (you can add more validation as needed)
          if (!name || !email || !phoneNumber || !messageText) {
              alert("Please fill in all fields.");
              return;
          }

          // Prepare the message
          var message = "Name: " + name + "\n";
          message += "Email: " + email + "\n";
          message += "Phone Number: " + phoneNumber + "\n";
          message += "Message: " + messageText;

          // Send data to the server for processing
          var xhr = new XMLHttpRequest();
          xhr.open('POST', 'whatapptwilio.php', true);
          xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
          xhr.onload = function() {
              if (xhr.status === 200) {
                  alert(xhr.responseText);
              } else {
                  alert("Error sending WhatsApp message. Please try again.");
              }
          };

          // Send form data to the server
          xhr.send('message=' + encodeURIComponent(message));
      }
  </script>

</body>

</html>
