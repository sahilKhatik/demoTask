<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

    <style>
        html, body{
            height: 100%;
        }

        div.container{
            position: relative;
            top: 50%;
            transform: translate(0, -50%);
            background-color: #e8e8e8;
        }

        

    </style>
</head>

<body>
    <div class="container h-50 pt-5">
        <h2 class="w-100 text-center mb-5">Upload File</h2>
        <form id="uploadFileForm" class="d-flex justify-content-center row row-cols-lg-auto g-3 align-items-center" action="uploadFile" method="POST" enctype="multipart/form-data">
            <div class="col-12">
                <label class="visually-hidden" for="upload">Upload</label>
                <div class="input-group">
                    <input id="upload" class="form-control" type="file" name="file" placeholder="Select File" required>
                    <p id="msg"></p>
                </div>
            </div>
            <div class="col-12">
                <button class="btn btn-primary" type="submit" name="uploadFile">Upload</button>
            </div>
            <div class="col-12">
                <button class="btn btn-secondary" type="reset">Reset</button>
            </div>
        </form>
        <div id="progress_wrapper" class="progress d-block d-none mt-3">
            <div id="bar" class="progress-bar" role="progressbar" aria-label="Example with label" style="width: 0;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">25%</div>
        </div>
        <div>
            <form action="<?php echo base_url('logout')?>" method="POST">
                <button class="btn btn-danger float-end me-5 mt-5" type="submit">Logout</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>
        const form = document.getElementById('uploadFileForm');
        const bar = document.getElementById('bar');
        const inputFile = document.getElementById('upload');

        form.addEventListener('submit', uploadFile);

        function uploadFile(e){
            e.preventDefault();
            const url = $(form).attr('action');
            const xhr = new XMLHttpRequest();
            
            xhr.open('POST', url);
            $('#progress_wrapper').removeClass('d-none');
            xhr.upload.addEventListener('progress', e => {
                const percent = e.lengthComputable ? (e.loaded / e.total) * 100 : 0;
                $(bar).css('width', percent+'%');
                $(bar).attr('aria-valuenow', percent);
                $(bar).text(percent+'%');
            });
            
            xhr.send(new FormData(form));
        }

        form.addEventListener('reset', function(){
            $('#progress_wrapper').addClass('d-none');
            $(bar).css('width', 0);
            $(bar).attr('aria-valuenow', 0);
            $(bar).text(0);
        })
    </script>
</body>

</html>