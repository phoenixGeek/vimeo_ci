<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title>VimeoApp</title>
      <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/css/bootstrap.css" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <style>
          .mt40 {
            margin-top: 40px;
          }
          .content {
            position: relative;
            top: 20px;
          }
          .content h5 {
            padding: 0px 10px 7px;
            color: deeppink;
          }
          .presentation-header {
            display: flex;
          }
          .presentation-input {
            display: none;
          }
          i:hover {
            cursor: pointer; 
          }
      </style>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  </head>
<body>
    
  <div class="container">
    <div class="row mt40">
      <div class="col-md-8">
        <h2>Basic Vimeo APP</h2>
      </div>
      <div class="col-md-4">
        <a href="<?php echo base_url('createPresentation/') ?>" class="btn btn-info">Add Presentation</a>
        <a href="<?php echo base_url('createLink/') ?>" class="btn btn-info">Add Link</a>
      </div>
      <br></br>
      <div class="content">
        <?php if($presentations): ?>
          <?php foreach($presentations as $key => $presentation): ?>
            <div class="presentation-header" id="presheader_<?= $presentation->pres_id?>">
              <h5><?= 'Presentation'. $key. ': '; ?><span><?= $presentation->pres_name ; ?></span>&nbsp;<i class="fa fa-pencil-square-o edit-icon" id="edit_<?= $presentation->pres_id?>" aria-hidden="true"></i></h5>
              <div id="presentation_<?= $presentation->pres_id?>" class="presentation-input">
                <input type="text" name="presentationname" value="<?= $presentation->pres_name?>" />&nbsp;<i class="fa fa-save fa-lg save-icon" id="save_<?= $presentation->pres_id?>"></i>&nbsp;<i class="fa fa-times fa-lg close-icon" aria-hidden="true" id="close_<?= $presentation->pres_id?>"></i>
              </div>
            </div>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Id</th>
                  <th>LinkName</th>
                  <th>Video URL</th>
                  <td colspan="2">Action</td>
                </tr>
              </thead>
              <tbody>
                <?php if($links): ?>
                  <?php foreach($links as $link): ?>
                    <?php if($presentation->pres_name === $link->pres_name): ?>
                      <tr>
                        <td><?php echo $link->link_id; ?></td>
                        <td style="min-width: 150px;"><?php echo $link->link_name; ?></td>
                        <td><a href="<?= $link->url?>"><?= $link->url?></a></td>
                        <td><a href="<?php echo base_url('editLink/'.$link->link_id) ?>" class="btn btn-primary">Edit</a></td>
                        <td>
                          <form action="<?php echo base_url('deleteLink/'.$link->link_id) ?>" method="post">
                            <button class="btn btn-danger" type="submit">Delete</button>
                          </form>
                        </td>
                      </tr>
                    <?php endif; ?>
                  <?php endforeach; ?>
                <?php endif; ?>
              </tbody>
            </table>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <script>
    $(document).ready(function() {

      // Handle part of edit presentation
      $('.edit-icon').on('click', function() {
        var _elid = $(this).attr('id');
        var _uid = _elid.split('_')[1];
        $('#presentation_' + _uid).show();
      })

      $('.save-icon').on('click', function() {
        var _elid = $(this).attr('id');
        var _uid = _elid.split('_')[1];
        $('#presentation_' + _uid).each(function(e) {

          var new_val = $(this).find('input').val();
          var ajaxUrl = '<?= base_url()?>' + 'editPresentation'
          var data = {
            pres_id: _uid,
            pres_name: new_val
          }
          
          // If the presentation name changes, call ajax call and save it
          $.ajax({
            url: 'editPresentation',
            data: data,
            dataType: 'JSON',
            type: 'POST',
            success: function(data) {
              $(`div #presheader_${_uid}`).each(function(e) {
                $(this).find('h5 span').text(new_val);
                $('#presentation_' + _uid).hide();
              })
            }
          })
        });
      })

      $('.close-icon').on('click', function() {
        var _elid = $(this).attr('id');
        var _uid = _elid.split('_')[1];
        $('#presentation_' + _uid).hide();
      })

    })
  </script>
</body>
</html>