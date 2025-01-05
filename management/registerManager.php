<!DOCTYPE html>

<html lang="en">

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Manager Register</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
        <link rel="stylesheet" href="../css/registerManager.css" type="text/css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    </head>
    <body>

        <div class="rtn-home">
            <a href="admin.php">
                <button>
                    <i class="fa-solid fa-arrow-left"></i>
                </button>
            </a>
        </div>
        <div class="form-container">
            <h2>Manager Register</h2>
            <form method="POST" id="managerRegister">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="maUsername" name="mUsername" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="mPassword" name="mPassword" required>
                </div>
                <div class="form-group">
                    <label for="repassword">Re-enter Password</label>
                    <input type="password" id="mRepassword" name="mRepassword" required>
                </div>
                <button type="submit" class="btn">Register</button>
            </form>
            <div class="form-footer">
                <p>Note: Managers must inquire or be found by the admin for registration.</p>
            </div>
        </div>
        <div class="position-absolute bottom-0">&#x00A9; Copyright 2025 Republika | All Rights Reserved.</div>

        <script>
            $(document).ready(function() {
                $("#managerRegister").submit(function(event) {
                    event.preventDefault();
                    var formData = $(this).serialize();
                    $.ajax({
                        type: "POST",
                        url: "registerManagerServer.php",
                        data: formData,
                        success: function(response) {
                            $("body").prepend(response);
                        },
                        error: function(xhr, status, error) {
                            alert("Error: " + error);
                        }
                    });
                });
            });
        </script>
    </body>

</html>
