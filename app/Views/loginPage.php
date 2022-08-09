<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

    <style>
        html,
        body {
            height: 100%;
        }

        div>#loginForm {
            background-color: #e8e8e8;
            border: 1px solid black;
        }

        .invalidfeedback {
            color: red !important;
        }
    </style>
</head>

<body>
    <div id="alertMsg" class="d-flex justify-content-center align-items-center">
        <?php
        if ($response['status'] == 401) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Access Denied : </strong> Check credintials.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
        ?>
    </div>
    <div class="h-100 d-flex align-items-center justify-content-center">
        <form id="loginForm" class="col-sm-10 col-md-6 col-lg-6 p-5" action="<?php echo base_url('verifyUser') ?>" method="POST">
            <div class="mb-3">
                <label for="inputEmail" class="form-label">Email</label>
                <input id="inputEmail" class="form-control" name="email" type="email" placeholder="Email">
                <div id="emailFeedback">
                    <p class="invalidfeedback">
                        <?php
                        if ($response['status'] == 409) {
                            if (isset($response['error']['email'])) echo $response['error']['email'];
                        }
                        ?>
                    </p>
                </div>
            </div>
            <div class="mb-3">
                <label for="inputPassword" class="form-label">Password</label>
                <input id="inputPassword" class="form-control" name="password" type="password" placeholder="Password">
                <div id="passwordFeedback" class="invalid-feedback">
                    <p class="invalidfeedback">
                        <?php
                        if ($response['status'] == 409) {
                            if (isset($response['error']['password'])) echo $response['error']['password'];
                        }
                        ?>
                    </p>
                </div>
            </div>
            <button class="btn btn-secondary float-start" type="button"><a class="link-light text-decoration-none" href="<?php echo base_url('/register') ?>">Register</a></button>
            <button class="btn btn-primary float-end" type="submit">Login</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>

    </script>
</body>

</html>