<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>VimeoApp</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <style>
        .mt40{
            margin-top: 40px;
        }
        form {
            position: relative;
            top: 20px;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
</head>
<body>
    
<div class="container">
    <?php if(isset($_GET['exist'])) {
        $isExisted = true;
    } else {
        $isExisted = false;
    }
    ?>
    <div class="row">
        <div class="col-lg-12 mt40">
            <div class="pull-left">
                <h2>Add Presentation</h2>
            </div>
        </div>
    </div>
     
    <form action="<?php echo base_url('storePresentation') ?>" method="POST" name="edit_note">
        <input type="hidden" name="id">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <input type="text" name="presentationname" class="form-control" placeholder="Enter Presentation Name">
                </div>
            </div>
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
</div>
     
</body>

<script>

    $(document).ready(function() {

        // If presentation already exists, alert a message using toastr
        let isExisted = '<?= $isExisted?>'
        if(isExisted) {

            toastr.options = {
                'closeButton': true,
                'debug': false,
                'newestOnTop': false,
                'progressBar': false,
                'positionClass': 'toast-top-right',
                'preventDuplicates': false,
                'showDuration': '2000',
                'hideDuration': '2000',
                'timeOut': '6000',
                'extendedTimeOut': '1000',
                'showEasing': 'swing',
                'hideEasing': 'linear',
                'showMethod': 'fadeIn',
                'hideMethod': 'fadeOut',
            }
            toastr.success('This presentation name already exists, please try another!');
        }
    })
</script>

</html>