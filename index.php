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

					<img src="Figs/ASU_Logo.jpg"  height="50" width="150" style="position:absolute; TOP:-100px; LEFT:350px;"/>
				
					<img src="Figs/sideview_white.jpg"  height="100" width="250" style="position:absolute; TOP:350px; LEFT:-330px;"/>	

					<img src="Figs/Pheeno1.jpg"  height="150" width="250" style="position:absolute; TOP:350px; RIGHT:-330px;"/>	

					<img src="Figs/Pheeno_side.jpg"  height="120" width="200" style="position:absolute; TOP:420px; RIGHT:350px;"/>


				</section>

				<section>
					<h3> Committee </h3>
			

					<style type="text/css">
		  			tr.noBorder td {border: 0; }
					table {border : none;}
					</style>

					<small> <b>
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
					<img src="Figs/Georgios.jpeg"  height="150" width="150"/>	
					   <figcaption> <normal> Prof.Georgios Fainekos  </normal></figcaption>
					</figure>
					</td>

					
					</tr>

					<tr class = "noBorder">
					<td>	
					 <figure>
					<img src="Figs/Rida.jpeg"  height="150" width="175"/>	
					   <figcaption> <normal> Prof.Rida Bazzi  </normal></figcaption>
					</figure>
					</td>


					<td>	
					 <figure>
					<img src="Figs/Violet.jpeg"  height="150" width="150"/>	
					   <figcaption> <normal> Prof.Violet Syrotiuk  </normal></figcaption>
					</figure>
					</td>

					<td>	
					 <figure>
					<img src="Figs/Tom.png"  height="150" width="150"/>	
					   <figcaption> Prof.Thomas Taylor  </figcaption>
					</figure>
					</td>
					
					</tr>	

					

					</table>
					</b>
					</small>


				</section>


			
				

				<div class="slides">
				<section> 

					<section>
					<h3> ACS Lab </h3>
					<style type="text/css">
		  			tr.noBorder td {border: 0; }
					table {border : none;}
					</style>
					
					<table style="width:1200px">
					<tr class = "noBorder">
					<td>	
					 <figure>
					<img src="Figs/Spring.png"  height="150" width="150"/>	
					   <figcaption> <normal> Prof.Spring <p> Berman </normal></figcaption>
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
					   <figcaption> <normal> Prof. Ted Pavlic  <p> <small> <b> FSE / GIS / SOLS </b> </small> </p>  </normal></figcaption>
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
					<tr class = "noBorder"> <td> <b>FSE </b><td>Fulton Schools of Engg. </td> </tr> 
					<tr class = "noBorder" > <td> <b>SOLS </b> </td> <td> School of Life Sciences </td> <tr>
										<tr class = "noBorder" > <td> <b>GIS </b> </td> <td> Global Institute of Sustainability </td> <tr>	
					</table>
					</small>

					<img src="Figs/ant-exp.jpeg"  height="200" width="300" style="position:absolute; BOTTOM:-100px; LEFT:-300px;"/>

					</section>


				</section>

									

				

			

				<section>

					<section> <h3> Swarms of Low-cost Robots </h3> 


					<style type="text/css">
		  			tr.noBorder td {border: 0; }
					</style>

					<table  style="width=2000px"> 
					<tr class = "noBorder">
					<td>	
					 <figure>
					<img src="Figs/drone-swarms.jpeg"  height="300" width="350"/>
					   <figcaption> <normal> <b> Hummingbird Quadrotors (GRASP Lab, UPenn)  </normal></figcaption>
					</figure>
					</td>
					
					<td>	
					 <figure>
					<img src="Figs/marxbot-swarm.jpg"  height="300" width="300"/>	
					   <figcaption> <normal> <b> Marxbots (EPFL)  </normal></figcaption>
					</figure>	
					</td>

					
											

					<td>	
					 <figure>
					<img src="Figs/Pheeno_transport.png"  height="300" width="300"/>	
					   <figcaption> <normal> <b> Pheenos (ACS Lab, ASU)  </b> </normal></figcaption>
					</figure>
					</td>
					
					</tr>
					</table>
					
					

					</section>

					


					<section> <h3> Swarm Applications </h3>


				

					<style type="text/css">
		  			tr.noBorder td {border: 0; }
					</style>

					<table  style="width=2000px"> 
					<tr class = "noBorder">
					<td>	
					 <figure>
					<img src="Figs/human_swarm.jpg"  height="300" width="300"/>
					   <figcaption> <normal> <b> Human Swarm Interaction (Georgia Tech.) </normal></figcaption>
					</figure>
					</td>
					
					<td>	
					 <figure>
					<img src="Figs/nanobots.jpg"  height="300" width="300"/>	
					   <figcaption> <normal> <b> Nanoscale Robots (Univ. Sheffield)   </normal></figcaption>
					</figure>	
					</td>

					
											

					<td>	
					 <figure>
					<img src="Figs/warehouse.jpeg"  height="300" width="300"/>	
					   <figcaption> <normal> <b> Warehouses (Kiva Systems)  </b> </normal></figcaption>
					</figure>
					</td>
					
					</tr>
					</table>
					
					

					</section>


					
					<section>
					<h3>Collective Transport (CT)</h3>

					<style type="text/css">
		  			tr.noBorder td {border: 0; }
					</style>

					<table  style="width=2000px"> 
					<tr class = "noBorder">
					<td>	
					 <figure>
					<img src="Figs/search+rescue.png"  height="300" width="300"/>
					   <figcaption> <normal> <b> Search and Rescue  </normal></figcaption>
					</figure>
					</td>
					
					<td>	
					 <figure>
					<img src="Figs/construction.png"  height="300" width="300"/>	
					   <figcaption> <normal> <b> Construction  </normal></figcaption>
					</figure>	
					</td>

					
											

					<td>	
					 <figure>
					<img src="Figs/Pheeno_transport.png"  height="300" width="300"/>	
					   <figcaption> <normal> <b> Collective Lifting  </b> </normal></figcaption>
					</figure>
					</td>
					
					</tr>
					</table>
					
					

					</section>





					<section>
					<h3>BOUNDARY COVERAGE</h3>

					<table  style="width=2000px">
					<tr class="noBorder">

					<td>	
					 <figure>
					<img src="Figs/DrugDel.jpg"  height="250" width="350"/>
					   <figcaption> <normal> <b>  Drug Delivery </b> </normal>  
						<p> <small> <a href="http://goo.gl/zXVHGw" > Sinha et al., Mol. Cancer. Ther. '06  <small> </p> </a>
						</figcaption>
					</figure>

					
					<td>		
					 <figure>
					<img src="Figs/CancerCell.png"  height="300" width="300"/>	
					   <figcaption> <normal> <b>  Imaging Cancer Cells  </b>  </normal> 
									<p> <small>  <a href="http://goo.gl/ZhRYSb "> Qin et al., Adv. Funct. Mater. '12 </a> </small>  </p> 
									</normal></figcaption>
					</figure>

					<td>

					
					 <figure>
					<img src="Figs/DistSens.png"  height="300" width="300"/>	
					   <figcaption> <normal> <b> Distributed Sensing with SwarmBots </b> </normal>
						<p> <small>  <a href="http://goo.gl/utjpbc"> J. Brandon, Digital Trends '11 </a> </small>  </p> 
						</figcaption>
					</figure>	
					
					</td>


					</tr>
					</table>	


					

					</section>
					
					

					<section>	
					<h3> BOUNDARY COVERAGE PROBLEM </h3>						
					 <b> Goal: Claim positions on boundary  </b> 
					
					<p class = "fragment" 	data-fragment-index="1" align="left">  Robot capabilities 	

					<p  class="fragment" data-fragment-index="2" align="left">&#10003; Sense / Communicate within limited range </p>
					<p  class="fragment" data-fragment-index="2" align="left">&#10006; Global Localization </p>
					<p  class="fragment" data-fragment-index="2" align="left">&#10006; Environment Map </p>


					<normal class="fragment" data-fragment-index="3" > <b> <small> Multi-Boundary Coverage  <p>  <a href="http://goo.gl/5pCqCg">  Pavlic et al., <i> ISRR '13</i> </a></small></p> </b>  </normal> 
					<video width="420" height="315" controls autoplay class="fragment" data-fragment-index="3" style="position:absolute; BOTTOM:-50px; RIGHT:-150px;">
						<source  src="Videos/netlogo-sim.mp4" type="video/mp4"/>

					</video>
					

					</section>

					
					



					<section>	
					<h3> WHY STOCHASTIC COVERAGE SCHEMES (SCS) ? </h3>						
					
					<ul class="fragment" data-fragment-index="1" align = "left"> 
					<li class="fragment" data-fragment-index="2"> More robust  to error in lifting and transport
					<li class="fragment" data-fragment-index="3"> Easier to program than Deterministic Coverage Schemes (DCS)
					<li class ="fragment"  data-fragment-index="4"> Odometric error leads even DCS to random positions 
				
					
					</ul>
					<figure class="fragment" data-fragment-index="4">					  		
					<img src="Figs/OdomError.png"  height="200" width="300"/>	
					   <figcaption> <small> <b> Odometric error leading to  Gaussian pdf  </b> 
						 <a href="http://goo.gl/YXnMqD"> (Thrun, et al. 2005) </a> </small> 
						</figcaption>
					</figure>
							

					</section>


						
		

					
				</section>
					
		

				



				
				<section>
					<section>
					<h3>Novel Contributions</h3>
						<b> Devised Stochastic Hybrid System (SHS) model of CT in <i>A. Cockerelli</i> </b>
						<p>  <small> <b> Source: <a href="https://goo.gl/SqG93d"> Kumar et al., HSCC '13</a> </b>  </small> </p> 
						<p> <div style="color:blue;"> <b> My contributions </b></p>
						 	
						   <ul> <li> Devised CRN <li> Derived moments of SHS <li> Helped validate parameter estimation </ul>   
						</div> 

						<img src="Figs/sideview_white.jpg"  height="100" width="300" style="position:absolute; BOTTOM:-200px; RIGHT:300px;"/>	
					</section>

					
					<section>
					<h3>Novel Contributions</h3>
					<b> Formulated stochastic controller for Multi-Boundary Coverage </b>
						<p>
						<small> <b> Sources: </b> <a href="http://goo.gl/5pCqCg"> <b> Pavlic et al., <i> ISRR '13</i> </b> </a>; <a href="https://goo.gl/DFligW"> <b> Pavlic et al., <i> SME '14 </i> </b> </a>;<a href="https://goo.gl/DbbUC1"> <b> Wilson et al., <i> Swarm Int '14 </i> </b> </a>  </small>
						</p>
						<p> <div style="color:blue;"> <b> My contributions </b></p>
						 	
						   <ul> <li> Devised a closed-form solution to bimolecular CRN <li> Analyzed the unimolecular approximation to CRN </ul>   
						</div> 
						<img src="Figs/RoboZyme_thinks.png"  height="100" width="300" style="position:absolute; BOTTOM:-200px; RIGHT:300px;"/>	
						
					</section>

					<section>
					$$ 
					\newcommand{\Poly}{\mathcal{P}}
					\newcommand{\G} {\mathcal{G}}
					\newcommand{\pcon}{p_{\mathsf{con}}}
					$$
					
					<h3>Novel Contributions</h3>
					<b> Analyzed Communication Graph $\G$ on Boundary  </b>
						<ul>
							<li> Computed connectivity probability $\pcon(\G)$ and spatial statistics for uniform coverage  </li>
								<p> <small> <a href="https://goo.gl/z2OhbC" > Kumar and Berman, <i> ICRA '14 </i> </a>  </small>  </p>
							<li>  Spatial statistics over connected communication graphs </li>
								<p> <small> Kumar and Berman, <i> IEEE-TRO (under review) </i>  </small>  </p>	
								
							<li> Non-uniform SCS, Non-iid SCS, Finite Robots </li>
								<p> <small> Kumar and Berman, <i> SICOMP (in prep.) </i>  </small>  </p>
	
						</ul>
				 
						<figure style="position:absolute; TOP: 300px; RIGHT:-200px;">
						<img src="Figs/config.svg"  height="75" width="400" />

						</figure>
					</section>

					<section>
					<h3>Agenda</h3>
					
						<ul>
							<li> Study of CT in Desert Ant 
							<li> Formulating Stochastic Control policies for multi-boundary coverage								
							<li> Analyzing properties of communication network generated by SCS
							<li> Challenges in integrating Multi-Robot  simulation with wireless communications 
	
						</ul>
				 
						
					</section>


				
					
				</section> 	


		<?php
			readfile("./antshs/antshs.php");
			readfile("./bcover-multi/bcover-multi.php");			
			readfile("./bcover-conn/bcover-conn.php");
			readfile("./comm-sim/comm-sim.php");
		?>

		<section>
		<section>
		<h3>  Conclusions </h3>	
		<ul class = "fragment" 	data-fragment-index="1" align="left">
		<li class = "fragment" 	data-fragment-index="2" align="left"> Devised SHS Model of CT in Desert Ant   </li>
		<li class = "fragment" 	data-fragment-index="3" align="left"> Formulated stochastic controller for multi-boundary coverage </li>
		<li  class = "fragment" data-fragment-index="4" align="left"> Investigated the properties of communication network generated by SCS</li>
		<li  class = "fragment" data-fragment-index="5" align="left"> <div style="color:blue"> Explored challenges of multi-robot simulation with communication </div>
		</li>
		</ul>
		</section>


		<section>
		<h3> ACS Lab </h3>	
		<img src="Figs/ACSLab.jpg"  height="400" width="800" />

	
		</section>
		</section>	

		<!-- these divs close out everything -->
	
	
			</div>

		</div>

		<!-- this should always be here -->

		<script src="lib/js/head.min.js"></script>
		<script src="js/reveal.js"></script>

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
