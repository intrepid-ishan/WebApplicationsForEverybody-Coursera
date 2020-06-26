<!-- $ is object i.e used to acceess jquery -->
<!-- $(document) is passing object with parameter simple -->
<!-- $(document) is predefined object in browser so here are passing that value to our object $ -->
<!-- #understanding : it can mean that, there will be some method available for -->
<!-- #understanding : $(document) can access 324 method for ex,$(window) can access 210 methods -->
<!-- #understanding : inside the library jquery.min.js "ready","resize" are few methods -->
<html>
<head>
</head>
<body>
<p>Here is some awesome page content</p>
<!-- loading jquery library from my desktop -->
<!-- #otheroption : can load from internet, google has hosted copy of it, CDN(Content Data Networks) -->
<!-- #otheroption : which is unlimited super fast bandwidth-->
<script type="text/javascript" src="jquery.min.js">
</script>
<script type="text/javascript">

//ready has one parameter ready(X)
//instead of X here we are passing code, this is possible because of 
//keyword function() in javascript returns the code due to first class function
$(document).ready(function(){ 
  alert("Hello JQuery World!"); 
  window.console && console.log('Hello JQuery..');
});
</script>
</body>

<!-- shorter method for document ready event:) 
$(function(){

  // jQuery methods go here...

});
 -->

 <!-- when script will run?
 in most cases when DOM hierarchy has fully constructed
  -->