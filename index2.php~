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

			<!-- Any section element inside of this container is displayed as a slide -->
			<div class="slides">
				<section>
					<h3> Stochastic Boundary Coverage Strategies for Multi-Robot Systems</h3>
					<h4><b> Ganesh P Kumar</b></h4>
					<p> <b> Autonomous Collective Systems Lab</b>	</p>
 					<p> <b> Arizona State University </b> </p>

					<img src="Figs/ASU_Logo.jpg"  height="75" width="200" style="position:absolute; TOP:-100px; LEFT:-350px;"/>
				
					<img src="Figs/sideview_white.jpg"  height="100" width="250" style="position:absolute; TOP:350px; LEFT:-350px;"/>	

					<img src="Figs/Pheeno1.jpg"  height="150" width="250" style="position:absolute; TOP:350px; RIGHT:-350px;"/>	

					<img src="Figs/RoboZyme_problem_cartoon.png"  height="200" width="300" style="position:absolute; TOP:-100px; RIGHT:-300px;"/>


				</section>

				<!--
				<section>
					
					<h4>Committee</h4>


					<style type="text/css">
		  			tr.noBorder td {border: 0; }
					</style>

					<normal>
					<table style="width:75%"> 
					<tr class = "noBorder"> <td>Prof. Spring Berman</td> <td>Co-chair </td> </tr> 
					<tr class = "noBorder" > <td> Prof. Georgios Fainekos </td> <td> Co-chair </td> </tr>
					<tr class = "noBorder"> <td> Prof. Rida Bazzi </td> <td> Member </td> </tr>
					<tr class = "noBorder" > <td> Prof. Violet Syrotiuk </td> <td> Member </td> </tr>		
					<tr class = "noBorder"> <td> Prof. Thomas Taylor </td> <td> Member </td> </tr>						
					</table>						
					</normal>	

				</section>
				

				<div class="slides">
				<section> 

					<section>
					<h3> ACS Lab </h3>
					<style type="text/css">
		  			tr.noBorder td {border: 0; }
					table {border : none;}
					</style>
					
					<table>
					<tr class = "noBorder">
					<td>	
					 <figure>
					<img src="Figs/Spring.png"  height="150" width="150"/>	
					   <figcaption> <normal> Prof.Spring Berman </normal></figcaption>
					</figure>
					</td>
					
					<td>	
					 <figure>
					<img src="Figs/Sean.png"  height="150" width="150"/>	
					   <figcaption> <normal> Sean Wilson  </normal></figcaption>
					</figure>	
					</td>



					<td>
					 <figure>
					<img src="Figs/Ruben.png"  height="150" width="150"/>	
					   <figcaption> <normal> Ruben Gameros </normal></figcaption>
					</figure>
					</td>

					</table>	
					</section>

					<section>
					<h3> Collaborators </h3> 
					<style type="text/css">
		  			tr.noBorder td {border: 0; }
					</style>
					
					<table height="75%">
					<tr class = "noBorder">
					<td>	
					 <figure>
					<img src="Figs/Ted.png"  height="150" width="150"/>	
					   <figcaption> <normal> Prof. Ted Pavlic  <p> <small> <b> FSE / SOLS </b> </small> </p>  </normal></figcaption>
					</figure>
					</td>
					
					<td>	
					 <figure>
					<img src="Figs/Aurelie.png"  height="150" width="150"/>	
					   <figcaption> <normal> Dr. Aurelie Buffin  <p> <small> <b> SOLS </b> </small> </p>   </normal></figcaption>
					</figure>	
					</td>	

								

					<td>
					 <figure>
					<img src="Figs/Stephen.png"  height="150" width="150"/>	
					   <figcaption> <normal> Prof. Stephen Pratt <p><small> <b> SOLS </b> </small> </normal></figcaption>
					</figure>
					</td>
					</tr>
					</table> 					

					<small>
					<table> 
					<tr class = "noBorder"> <td> <b>FSE </b>:<td>Fulton Schools of Engg. </td> </tr> 
					<tr class = "noBorder" > <td> <b>SOLS </b>: </td> <td> School of Life Sciences </td> <tr>
					</table>
					</small>

					</section>


				</section>
									</div>

				

			

				<section>
					<h3>Motivation</h3>
					
		

					
				</section>

				<section>
					<h3>Novel Contributions</h3>
					
					
					
				</section>

				<section>
					<h2> Outline </h2>
					
					<ul>
					<li class = "fragment">SHS of Collective Transport in <i>A. Cockerelli</i> </p>
					<li class = "fragment">Multi-Robot Boundary Coverage  </p>

						
					<li class = "fragment">Maintaining a Connected Network on Boundary  </p>	
					<li class = "fragment">Integrating Multi-Robot and Wi-fi Simulators </p>
					</ul>
					
				</section>





		<?php 
			
			readfile("./antshs/antshs.php");
			readfile("./bcover-multi/bcover-multi.php");
			readfile("./bcover-sat/bcover-sat.php");		

		?>-->
					
		
		
	</body>
</html>
