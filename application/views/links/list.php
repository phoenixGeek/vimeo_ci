<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title>VimeoApp</title>
      <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/css/bootstrap.css" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
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
          .loader {
            display: none;
            position: absolute;
            top: 10%;
            left: 90%;
          }
          .loader h6 {
            color: blue;
            position: relative;
            left: 30%;
          }
          /* creates a ball for each div */
          .loader div {
            content: " ";
            width: 5px;
            height: 5px;
            background: #2196F3;
            border-radius: 100%;
            /* positions all dots inside parent div, all on top of each other, presumably: */
            position: absolute;   
            animation: shift 3.1s linear infinite;  
            animation-fill-mode: both;
          }
          
          /* sets the other 4 div-dots off at different times: */
          .loader div:nth-of-type(1) { animation-delay: -0.3s; }
          .loader div:nth-of-type(2) { animation-delay: -0.6; }
          .loader div:nth-of-type(3) { animation-delay: -0.9s; }
          .loader div:nth-of-type(4) { animation-delay: -1.2s; }
          .loader div:nth-of-type(5) { animation-delay: -1.5s; }
          .loader div:nth-of-type(6) { animation-delay: -1.8s; }
          .loader div:nth-of-type(7) { animation-delay: -2.1s; }
          .loader div:nth-of-type(8) { animation-delay: -2.4s; }
          .loader div:nth-of-type(9) { animation-delay: -2.7s; }
          
          @keyframes shift {
            0%   {opacity: 1; background-color: blue; transform: rotate(0deg) translateX(20px) rotate(0deg);}
            50%  {opacity: 1; background-color: white; transform: rotate(180deg) translateX(20px) rotate(-180deg);}
            100% {opacity: 1; background-color: blue; transform: rotate(360deg) translateX(20px) rotate(-360deg)}
          }

      </style>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
  </head>
<body>
    
  <div class="container">
    <div class="row mt40">
      <div class="col-md-8">
        <h2>Basic Vimeo APP</h2>
      </div>

      <div class="loader">
        
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        
        <h6>Transcoding...</h6>
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
                        <td><a href="<?= $link->url?>" target="_blank"><?= $link->url?></a></td>
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

      toastr.options = {
        'closeButton': true,
        'debug': false,
        'newestOnTop': false,
        'progressBar': false,
        'positionClass': 'toast-top-right',
        'preventDuplicates': false,
        'showDuration': '2000',
        'hideDuration': '2000',
        'timeOut': '4000',
        'extendedTimeOut': '1000',
        'showEasing': 'swing',
        'hideEasing': 'linear',
        'showMethod': 'fadeIn',
        'hideMethod': 'fadeOut',
      }
      var links = JSON.parse('<?= json_encode($links)?>')
      var transcodingLinks= links.filter(link => link.active === "0")
      transcodingLinks.forEach(tLink => {

        $('.loader').show();
        var _vid = tLink.url.split('/')[3];
        data = {
          _vid: _vid,
          _linkid: tLink.link_id
        }
        toastr.success(`${tLink.link_name} - This newly uploaded onto vimeo is starting to transcode! `);
        var vimeoTrack = setInterval(() => {

          $.ajax({
            url: 'trackUpload',
            data: data,
            dataType: 'JSON',
            type: 'POST',
            success: function(data) {

              if(data === 'available') {
                clearInterval(vimeoTrack);
                $('.loader').hide();
                toastr.success(`${tLink.link_name} - This newly uploaded onto vimeo is now available! `);

              }

              // switch(data) {
              //   case 'transcode_starting':
              //     toastr.success(`${tLink.link_name} - This newly uploaded onto vimeo is starting to transcode! `);
              //     break;
              //   case 'transcoding':
              //     toastr.success(`${tLink.link_name} - This newly uploaded onto vimeo is transcoding! `);
              //     break;
              //   case 'available': 
              //     clearInterval(vimeoTrack);
              //     toastr.success(`${tLink.link_name} - This newly uploaded onto vimeo is now available! `);
              //     break;
              //   default:
              //     break;
              // }
            }
          })
        }, 2000);

      })

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