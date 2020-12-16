<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>VimeoApp</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/css/bootstrap.css" rel="stylesheet">
    <style>
        .mt40{
            margin-top: 40px;
        }
        form {
            position: relative;
            top: 20px;
        }
    </style>
</head>
<body>
    
<div class="container">
    <div class="row">
        <div class="col-lg-12 mt40">
            <div class="pull-left">
                <h2>Edit Link</h2>
            </div>
        </div>
    </div>
    <form action="<?php echo base_url('updateLink') ?>" method="POST" name="store_link">
        <input type="hidden" name="id" value="<?php echo $link->link_id ?>">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <strong>Link Name</strong>
                    <input type="text" name="linkname" class="form-control" value="<?php echo $link->link_name ?>" placeholder="Enter LinkName">
                </div>
            </div>
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
</div>
     
</body>
</html>