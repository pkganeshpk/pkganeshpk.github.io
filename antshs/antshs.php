<!-- Example of nested vertical slides -->
				<div class="slides">
				<section>
				<section>
					<h3> Collective Transport in  <i> Aphaenogaster Cockerelli </i> </h3>
					<table style="width:1200px">
					<tr class = "noBorder">
					<td>	
					 <figure>
					<img src="Figs/Ganesh.png"  height="150" width="125"/>	

					</figure>
					</td>
					<td>	
					 <figure>
					<img src="Figs/Aurelie.png"  height="150" width="150"/>	

					</figure>
					</td>
					<td>	
					 <figure>
					<img src="Figs/Ted.png"  height="150" width="150"/>	

					</figure>
					</td>
					<td>	
					 <figure>
					<img src="Figs/Stephen.png"  height="150" width="150"/>	
				
					</figure>
					</td>
					<td>	
					 <figure>
					<img src="Figs/Spring.png"  height="150" width="150"/>	

					</figure>
					</td>

					</tr>
					</table>	
					
					<small>
					<b> Source </b> <a href= "http://goo.gl/FKaPtN"> (Kumar et al., HSCC '13) </a>
					</small>	
				</section>

				
				<section>
						<h3> Motivation </h3>


				</section>

				
					


				<section>
						<h3> Prior Work </h3>
						<h5 class = "fragment" data-fragment-index="1" >
						CT in Ants  </h5>	
						<ul class="fragment" 	data-fragment-index="1" align="center">	
						<li class="fragment" 	data-fragment-index="1"> <a href="http://goo.gl/jjZHwU"> (Berman et al., 2011) </a> 
						<li class="fragment"  	data-fragment-index="1"> <a href="https://goo.gl/Oxm0F7"> (Czaczkes and Ratnieks, 2013) </a>
						</ul>	
				
						<p> </p>
						<h5 class = "fragment" data-fragment-index="2" align="center">
						Polynomial Stochastic Hybrid Systems (pSHS)  </h5>
						<ul class="fragment" 	data-fragment-index="2" align="center">	
						<li class="fragment" 	data-fragment-index="2"> <a href="http://goo.gl/dZmVtV"> (Mather and Hsieh, 2011) </a> 
						<li class="fragment" 	data-fragment-index="2"> <a href="http://goo.gl/BhmMef"> (Napp et al., 2013) </a>
						</ul>


						
				</section>


					<section>
					
					<normal> <b> <i> A. cockerelli </i> team conveying payload </b> </normal>
					<video width="1420" height="700"  controls autoplay>
						<source  src="Videos/ant-transp.mp4" type="video/mp4" "style=position:relative;"/>

					</video>
					</section>

					<section>
				

					<h3> EXPERIMENTAL DETAILS </h3>
					<ul>
					
					<li>17 filmed trials of ants carrying foam-mounted dime
					<li>Segments spanning $145~s$ extracted from each video
					<li>Ant positions and load trajectory tracked using ImageJ and Mtrack

					 <figure>
					<img src="antshs/Figs/south-mtn-park.gif"  height="150" width="200" />
					</figure>

					 <figure>
					<img src="antshs/Figs/sample_traj.png"  height="400" width="500" style="position:absolute; BOTTOM:-50px; RIGHT:-100px;"/>
					</figure>
					</section>


					<section>
				

					<h3> OBSERVATIONS </h3>
				
					
					<ul>
					

					<li> Ants switched among three states: $$S:=\{F(\text{Front}), B(\text{Back}), D(\text{Detached}) \}$$
					<li> <i> Back</i> ants lift with force $F_L = 2.65 ~\text{mN}$ measured with load cell
					</ul>

							
					<figure>
					<img src="antshs/Figs/3states.png"  height="200" width="200" style="position:relative; BOTTOM:-50px; RIGHT:-100px;"/>
					</figure>
					</section>

					

					
					 
					<section>
				

					<h3> SHS : Behavioral Model </h3>
				
					<figure>
					<img src="antshs/Figs/StateDiag-1.svg"  height="400" width="1450" style="position:relative; "/>
					<figcaption> <normal> CRN with 6 reactions $S_i \underset{r_{ij}}{\stackrel{r_{ji}}{\rightleftharpoons}} S_j$ </normal></figcaption>
					</figure>
					
					</section>


					<section>
				

					<h3> SHS : Behavioral Model </h3>
				
					<ul>
					<li> Behavioral components = ant counts in each state 
					$$\mathbf{N}_S := \begin{bmatrix} N_F & N_B & N_D \end{bmatrix}^T$$
					<li> 6 Transitions $S_i \rightarrow S_{j}$
					<ul>
						<li> Intensity : $r_{ij} N_i$
						<li> Reset Map: $(N_i,N_j) \mapsto (N_i-1,N_j+1)$
					</ul>
					</ul>


					
					</section>

					<section>
					<h3> SHS : Dynamical Model </h3>
				
					<figure>
					<img src="antshs/Figs/FreeBody-1.svg"  height="400" width="1450" style="position:relative; "/>
					<figcaption> <normal> Free Body Diagram of Load </normal></figcaption>
					</figure>	


					
					</section>
				
					<section>
					<h3> SHS : Dynamical Model </h3>
				
					<ul>
					<li> Dynamical components : load position and velocity $x_L, v_L$
					 
					<li> Attached ants pull with net force $F_{up} = (N_F+N_B)F_L$
					<li> Each front ant pulls with proportional regulation
					$$ F_{p} = K (v_L^D - v_L) $$
					<ul>
						<li> $K$ = proportional gain
						<li> $v_L^D$ = desired load velocity
					
					</ul>	


					
					</section>


					
						

					
					<section>

					<h3>  Evolution of SHS </h3>
				

				

					<p> SHS State Vector </p>
					$$ \mathbf{x} = \begin{bmatrix} N_{F} & N_B & N_D & x_L & v_L \end{bmatrix}^T$$
				
					<p> Flow Equation </p>
					$$ \mathbf{\dot{x}} = \begin{bmatrix} 0 & 0 & 0& v_L & a_L \end{bmatrix}^T$$
					

					
					</section>
					

					
					<section>

					<h3>   Moment Dynamics </h3>
				

					$$



					$$

					

					
					</section>
					

					
					<section>
				

				
				

					<h3>   Best Fit Parameters </h3>
				
					
					
					</section>

					<section>
				
					<figure>
					<img src="antshs/Figs/HSCC2013Plots.png"  height="400" width="1450" style="position:relative; "/>
										   <figcaption> <normal> Predicted vs Observed Mean-Field Parameters </normal></figcaption>
					</figure>		
					
				
					
					
					</section>		

				
				
				</section> <!-- antshs ends -->


