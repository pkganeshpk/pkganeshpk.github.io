<!doctype html>
<html lang="en">

	<head>
		<meta charset="utf-8">

		<title>Stochastic Boundary Coverage</title>

		<meta name="description" content="">
		<meta name="author" content="Ganesh P Kumar">

		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, minimal-ui">

		<link rel="stylesheet" href="css/reveal.css">
		<link rel="stylesheet" href="css/theme/sky.css" id="theme">

		<!-- Code syntax highlighting -->
		<link rel="stylesheet" href="lib/css/zenburn.css">
		

			
		<script type="text/x-mathjax-config">
		MathJax.Hub.Config({
  		tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}
		});
		</script>


		<!-- Printing and PDF exports -->
		<script>
			var link = document.createElement( 'link' );
			link.rel = 'stylesheet';
			link.type = 'text/css';
			link.href = window.location.search.match( /print-pdf/gi ) ? 'css/print/pdf.css' : 'css/print/paper.css';
			document.getElementsByTagName( 'head' )[0].appendChild( link );
		</script>

		<!--[if lt IE 9]>
		<script src="lib/js/html5shiv.js"></script>
		<![endif]-->

		<script type="text/javascript"
		  src="./MathJax-master/unpacked/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
		</script>


	


		  <link rel="import" href="Macros.html">
	</head>

	<body>
		<?
		readfile("./Macros.php");
		?>
		
				<div class="reveal">

				<div class="slides">
			



				

			

			
		

				



				
			

		<?php
			readfile("./People.php");
			readfile("./CTBC.php");
			readfile("./Novel.php");			
			readfile("./antshs/antshs.php");
			readfile("./bcover-multi/bcover-multi.php");			
			/*readfile("./bcover-conn/bcover-conn.php");
			readfile("./comm-sim/comm-sim.php");
			readfile("./Conc.php");	*/
		?>

	


		
		<!-- these divs close out everything -->
	
	
			</div>

		</div>

		<!-- this should always be here -->

		<script src="lib/js/head.min.js"></script>
		<script src="js/reveal.js"></script>
		<script>
		Reveal.initialize();
		// Shows the slide number using default formatting
	Reveal.configure({ slideNumber: true });

// Slide number formatting can be configured using these variables:
//  "h.v":  horizontal . vertical slide number (default)
//  "h/v":  horizontal / vertical slide number
//    "c":  flattened slide number
//  "c/t":  flattened slide number / total slides
		Reveal.configure({ slideNumber: 'c/t' });
		</script>


		<script>

			// Full list of configuration options available at:
			// https://github.com/hakimel/reveal.js#configuration
			Reveal.initialize({
				controls: true,
				progress: true,
				history: true,
				center: true,

				transition: 'slide', // none/fade/slide/convex/concave/zoom

				// Optional reveal.js plugins
				dependencies: [
					{ src: 'lib/js/classList.js', condition: function() { return !document.body.classList; } },
					{ src: 'plugin/markdown/marked.js', condition: function() { return !!document.querySelector( '[data-markdown]' ); } },
					{ src: 'plugin/markdown/markdown.js', condition: function() { return !!document.querySelector( '[data-markdown]' ); } },
					{ src: 'plugin/highlight/highlight.js', async: true, callback: function() { hljs.initHighlightingOnLoad(); } },
					{ src: 'plugin/zoom-js/zoom.js', async: true },
					{ src: 'plugin/notes/notes.js', async: true }
				]
			});

		</script>

		





		
	
					
		
		
	</body>
</html>
