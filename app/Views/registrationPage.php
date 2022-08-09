<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

    <style>
        html,
        body {
            height: 100%;
        }

        div>#registrationForm {
            background-color: #e8e8e8;
            border: 1px solid black;
        }

        .invalid-feedback {
            color: red;
        }
    </style>
</head>

<body>
    <div class="h-100 w-100 d-flex align-items-center justify-content-center">

        <form id="registrationForm" class="col-sm-10 col-lg-8 col-md-8 p-5" action="<?php echo base_url('/insertUser') ?>" method="POST">
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="inputName">Name</label>
                <div class="col-sm-10">
                    <input class="form-control" id="inputName" name="name" type="text">
                    <div id="nameFeedback">
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="inputEmail">Email</label>
                <div class="col-sm-10">
                    <input class="form-control" id="inputEmail" name="email" type="text">
                    <div id="emailFeedback">
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="inputMobileNo">Mobile No</label>
                <div class="col-sm-10">
                    <input class="form-control" id="inputMobileNo" name="mobileNo" type="text">
                    <div id="mobile_noFeedback">
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="inputPassword">Password</label>
                <div class="col-sm-10">
                    <input class="form-control" id="inputPassword" name="password" type="password">
                    <div id="passwordFeedback">
                    </div>
                </div>
            </div>
            <button class="btn btn-secondary float-start" type="button"><a class="link-light text-decoration-none" href="<?php echo base_url('/login') ?>">Login</a></button>
            <button class="btn btn-primary float-end" type="submit">Register</button>
        </form>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $('form').submit(function(e) {
            e.preventDefault();
            var form = $('#registrationForm');
            var url = form.attr('action');

            $.ajax({
                url: url,
                type: "POST",
                data: form.serialize(),
                dataType: 'JSON',

                success: function(data, code) {
                        var endTime = new Date();
                        endTime.setSeconds(endTime.getSeconds() + 7);
                        endTime = endTime.getTime();
                        Swal.fire({
                            title: 'Great',
                            html: '<p>User created successfully</p>',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 10000,
                            allowOutsideClick: false,
                            didOpen: () => {
                                const content = Swal.getFooter()
                                const $ = content.querySelector.bind(content)
                                const timeLeft = $('strong')
                                var x = setInterval(function() {
                                    var now = new Date().getTime();
                                    var distance = endTime - now;
                                    var seconds = Math.floor((distance % (1000 * 60)) / 1000)

                                    timeLeft.textContent = seconds;
                                }, 1000)
                            },
                            footer: '<p>Redirected to login page in <strong></strong> seconds...<p>',
                        }).then(setTimeout(function() {
                            window.location.href = "<?php echo base_url('login') ?>";
                        }, 6000));
                },
                error: function(xhr, statusText, error) {
                    if (xhr.status == 409) {
                        printValidation(xhr.responseJSON.error);
                    } else {

                        var msg = xhr.status + ': ' + xhr.statusText;
                        console.log(msg);
                        Swal.fire({
                            title: 'Oops',
                            text: 'Error Occurred',
                            icon: 'error',
                            showConfirmButton: true,
                            confirmButtonText: 'Try again'
                        })
                    }
                }
            })
        });

        function printValidation(validationErrors) {
            if (validationErrors.name != undefined) {
                $('#nameFeedback').text(validationErrors.name).addClass('invalid-feedback');
                $('#inputName').addClass('is-invalid');
            }
            else{
                $('#inputName').addClass('is-valid');
            }
            if (validationErrors.email !== undefined) {
                $('#emailFeedback').text(validationErrors.email).addClass('invalid-feedback');
                $('#inputEmail').addClass('is-invalid');
            }
            else
            {
                $('#inputEmail').addClass('is-valid');
            }
            if (validationErrors.mobile_no !== undefined) {
                $('#mobile_noFeedback').text(validationErrors.mobile_no).addClass('invalid-feedback');
                $('#inputMobileNo').addClass('is-invalid');
            }
            else
            {
                $('#inputMobileNo').addClass('is-valid');
            }
            if (validationErrors.password !== undefined) {
                $('#passwordFeedback').text(validationErrors.password).addClass('invalid-feedback');
                $('#inputPassword').addClass('is-invalid');
            }
            else
            {
                $('#inputPassword').addClass('is-valid');
            }
            return;
        }

        $('input').keyup(function() {
            $(this).removeClass('is-valid is-invalid');
        })
    </script>
</body>

</html>