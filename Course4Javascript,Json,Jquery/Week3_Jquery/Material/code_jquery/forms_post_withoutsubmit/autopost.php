<!-- --------see in network how code executes #reference this video--------  -->
<!-- In this code we are submitting form data as post without submit button -->
<html>
<head>
</head>
<body>
<p>Change the contents of the text field and 
then tab away from the field
to trigger the change event. Do not use
Enter or the form will get submitted.</p>

<!-- --------simple-------- -->
<form id="target">
  <input type="text" name="one" value="Hello there" 
     style="vertical-align: middle;"/> 
  <img id="spinner" src="spinner.gif" height="25" 
      style="vertical-align: middle; display:none;">
</form>     
<hr/>
<div id="result"></div>
<hr/>
<script type="text/javascript" src="jquery.min.js">
</script>


<!-- --------understand-------- -->

<!-- cant put this above form because form ---#target--- must exist -->
<script type="text/javascript">
  $('#target').change(function(event) {
    $('#spinner').show();
    var form = $('#target');
    // ---#target---
    var txt = form.find('input[name="one"]').val(); //typical jquery
    window.console && console.log('Sending POST');
    //post has three parameter, (#file,#post value with key,#delayedcode)
    //in autoecho.php we can access $_POST['val'] and insert to sql db


    //--------if 200 OK Network--------
    $.post( 'autoecho.php', { 'val': txt }, //change val txt and see how code behaves
      function( data ) {//data explained in autoecho.php
          window.console && console.log(data);
          $('#result').empty().append(data);
          $('#spinner').hide();
      }
    )

    //--------if 404 Not found, or 500 some server error--------
    .error( function() { 
      $('#target').css('background-color', 'red');
      alert("Dang!");
	});
  });
</script>
</body>
<!-- typical way: post itself returns an object, and we are adding another async activity .error -->
<!-- what is async? #link : https://medium.com/magentacodes/what-the-hell-is-async-65aea57146ef -->
<!-- sync means one task depends on other i.e if first tasks doesnt get completed then second doesnt start -->
<!-- async means you can switch to other tasks before completing previous tasks -->

<!-- Asynchronous property of programming languages provide us the ability to use 
the system power continuously and doesn’t wait for a certain task to perform others. In this way,
 you can call multiple tasks which will take a long time to complete simultaneously. -->



 <!-- --------get out of here,bye------- -->