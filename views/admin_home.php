<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Content Manager</title>

  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

  <script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

  <!-- Latest compiled and minified JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

  <script src="../bower_components/trumbowyg/dist/trumbowyg.min.js"></script>
  <link rel="stylesheet" href="../bower_components/trumbowyg/dist/ui/trumbowyg.min.css">

</head>
<body class="container">
  <h1>Content Manager</h1>
  <p><strong>PLEASE BE VERY CAREFUL! Any changes you make here will immediately appear on the website.</strong></p>

  <?foreach ($files as $key => $file): ?>
  <div class="">

    <div class="panel panel-default">
      <div class="panel-body">
        <h2>Filename: <?=$file->getFilename();?></h2>
        <textarea js-content-<?=md5($key)?> data-filename='<?=$file->getFilename();?>' class="trumbowyg"><?=$file->getContents();?></textarea>   
      </div>
      <div class="panel-footer">
        <button js-save-btn data-content-id="<?=md5($key)?>" class="btn btn-success">Save</button>
      </div>
    </div>

  </div>
  <?endforeach;?>

</body>
</html>
<script type="text/javascript">
  $('.trumbowyg').trumbowyg({
    btns: [
        ['viewHTML'],
        // ['formatting'],
        'btnGrp-design',
        'btnGrp-lists',
        ['superscript', 'subscript'],
        ['link'],
        // ['insertImage'],
        'btnGrp-justify',
        // ['horizontalRule'],
        // ['removeformat'],
        ['fullscreen']
    ],
    autogrow: true
  });
  $('[js-save-btn]').click(function() {
    var contentID = $(this).data('content-id');
    var $textArea = $('[js-content-'+ contentID +']');

    var filename = $textArea.data('filename');
    var content = $textArea.trumbowyg('html');
    if(confirm("You are about to make changes to: " + filename)) {
      saveContent(filename,content);  
    }
    
  });

  function saveContent(filename,contents)
  {


    $.ajax({
      type: "POST",
      url: '/index.php/saveFile',
      data: {fileName:filename,fileContents:contents},
      complete: function(rawResponse) {
        response = rawResponse.responseJSON;
        if(response.success) {
          alert('Saved successfully!');
        } else {
          alert('Error, unable to save. Please contact your administrator. Response: ' . response.message );
        }
      },
      dataType: 'json'
    });
  }
</script>