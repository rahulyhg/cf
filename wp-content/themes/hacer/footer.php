<?php
	/*-----------------------------------------------------------------------------------*/
	/* This template will be called by all other template files to finish 
	/* rendering the page and display the footer area/content
	/*-----------------------------------------------------------------------------------*/
?>
<?php wp_footer(); 
// This fxn allows plugins to insert themselves/scripts/css/files (right here) into the footer of your website. 
// Removing this fxn call will disable all kinds of plugins. 
// Move it if you like, but keep it around.
?>
<div class="modal-wrapper">
	<div class="container" style="position:relative;top:5%;">
		<div class="modal col-md-6 col-md-offset-3">
			<div class="cerrar"><span class="glyphicon glyphicon-remove"></span> </div>
			<div class="inner-modal ">
				
			</div>
		</div>
	</div>
</div>
<footer>
	<div class="container">
		<img src="<?php  echo get_template_directory_uri(); ?>/img/footer_logo.png" alt="">
	</div>
</footer>
   </body>
   <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-89072709-1', 'auto');
  ga('send', 'pageview');

</script>
   </html>