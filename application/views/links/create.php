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
                <h2>Upload a video to vimeo</h2>
            </div>
        </div>
    </div>
     
    <form action="<?php echo base_url('storeLink') ?>" method="POST" name="create_link" enctype="multipart/form-data">
        <input type="hidden" name="id">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <strong>Select Presentations</strong>
                    <?php if($presentations): ?>
                        <select name="presentationname" class="form-control">
                        <?php foreach($presentations as $key => $presentation): ?>
                            <option value="<?= $presentation->pres_name?>"><?= $presentation->pres_name?></option>
                        <?php endforeach; ?>
                        </select>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="myfile">Select a video file:</label>
                    <input type="file" id="myfile" name="myfile" required>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <strong>Link Name</strong>
                    <input class="form-control" col="4" name="linkname" placeholder="Enter Link Name" required></input>
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