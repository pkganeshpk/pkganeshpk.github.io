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
						<p align="left" class="fragment" data-fragment-index="1">	<b> Engineers: develop robust strategies for CT </b>
						<p align="left" class="fragment" data-fragment-index="2"> Ant CT is Scalable, decentralized, and has no map
						
					<table  class="fragment" data-fragment-index="2">
					<tr class="noBorder">
					<td>
					<figure>
					<img src="antshs/Figs/cockerelli-swarm.jpeg"  height="150" width="200" />
					</figure>
					</td>

						<td>
					 <figure>
					<img src="antshs/Figs/arrow.png"  height="150" width="200" style="border:none" />
					</figure> </td>
					
					<td>
					 <figure>
					<img src="antshs/Figs/marxBot.jpeg"  height="150" width="200"  />
					</figure> </td>
					
					</tr>
					</table>	


				</section>

					
				<section>
						<h3> Motivation </h3>
						<p align="left" class="fragment" data-fragment-index="1">	<b> Biologists: understand CT in certain ant species </b>
						<ul class="fragment" data-fragment-index="2">
						<li class="fragment" data-fragment-index="2"> Roles played by individual ants in CT   
						<li class="fragment" data-fragment-index="2"> Forces applied by each ant
						<li class="fragment" data-fragment-index="2"> Transition rules
						</ul> 
						
					<table  class="fragment" data-fragment-index="2">
					<tr class="noBorder">
					<td>
					<figure>
					<img src="antshs/Figs/ants-lexan.jpg"  height="300" width="400" />
					<figcaption> <small> <b> Ants carry  lexan structure which helps measure forces </b></small></figcaption>	
					</figure>
					</td>
					
					</tr>
					</table>	


				</section>

				
					


				<section>
						<h3> Prior Work </h3>
						<h5 class = "fragment" data-fragment-index="1" align="center">
						CT in Ants  </h5>	
						<ul class="fragment" 	data-fragment-index="1" align="left">	
						<li class="fragment" 	data-fragment-index="1"> <a href="http://goo.gl/jjZHwU"> (Berman et al., 2011) </a> </li>
						<li class="fragment"  	data-fragment-index="1"> <a href="https://goo.gl/Oxm0F7"> (Czaczkes and Ratnieks, 2013) </a></li>
						</ul>	
				
						<p> </p>
						<h5 class = "fragment" data-fragment-index="2" align="center">
						 pSHS Models of multi-robot transport  </h5>
						<ul class="fragment" 	data-fragment-index="2" align="left">	
						<li class="fragment" 	data-fragment-index="2" align="left"> <a href="http://goo.gl/dZmVtV"> (Mather and Hsieh, 2011) </a> </li>
						<li class="fragment" 	data-fragment-index="2" align="left"> <a href="http://goo.gl/BhmMef"> (Napp et al., 2013) </a> </li>
						</ul>

						<figure class="fragment" data-fragment-index="2" align="center">
					<img src="antshs/Figs/PSHS.gif"  height="150" width="650" />
					<figcaption> <small> <b> Stochastic Hybrid System <a href="http://goo.gl/x963vx"> (Hespanha and Singh,2005) </a></b></small></figcaption>	
					</figure>
					</td>


						
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

					<table>
					<tr class="noBorder">
					<td>
					 <figure>
					<img src="antshs/Figs/south-mtn-park.gif"  height="450" width="550" />
					</figure>
					</td>

					
					<td>
					 <figure>
					<img src="antshs/Figs/sample_traj.png"  height="400" width="500" />
					</figure>
					</td>
					</tr>
					</table>
						
					</section>


					<section>
				

					<h3> OBSERVATIONS </h3>
				
					
					<ul>
					

					<li> Ants switched among three states: $$S:=\{F(\text{Front}), B(\text{Back}), D(\text{Detached}) \}$$
					<li> <i> Back</i> ants lift with force $F_l = 2.65 ~\text{mN}$ measured with load cell
					</ul>
					
				
					<table>
					<tr class="noBorder" style="text-align:top">
					<td>

    					<img src="antshs/Figs/3states.png" height="300" width="300" />
					</td>
					<td style="vertical-align:top">
   					<small> <ul> <li> <b> Back </b> (resp. <b> Front </b>) ants attach to <br>  left (resp. right) of vertical orange line.
							<li> Two <b> Detached </b> ants at top and bottom.
							<li> Load moves right.
							
							 </ul>
					</td>
					</tr>
					</table>


				
					</section>

					

					
					 
					<section>
				

					<h3> SHS : Behavioral Model </h3>
					<table>
					<tr class="noBorder">
					<td style="vertical-align:top">
					<figure>
					<img src="antshs/Figs/StateDiag.png"  height="500" width="450" style="position:relative; "/>
					
					</figure>
					</td>
					<td style="vertical-align:top">
					<normal> <p align="justify"> CRN with 6 reactions $S_i \underset{r_{ij}}{\stackrel{r_{ji}}{\rightleftharpoons}} S_j$, where $S_i, S_j$ are distinct states from $S:=\{F,B,D\}$ </p> 
					</p>
					</normal>
					</td>
					</tr>
					</table>
					
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
				
					<table>
					<tr class="noBorder">
					<td style="vertical-align:top">
					<figure>
					<img src="antshs/Figs/FreeBody.png"  height="500" width="450" style="position:relative; "/>
					
					</figure>
					</td>
					<td style="vertical-align:top">
					<normal> <p align="justify"> Free Body Diagram of load in the dynamical model. Each front ant pulls with force $F_p$, and each attached ant lifts with force $F_l$. </p> 
					</p>
					</normal>
					</td>
					</tr>
					</table>	


					
					</section>
				
					<section>
					<h3> SHS : Dynamical Model </h3>
				
					<ul>
					<li> Dynamical components : load position and velocity $x_L, v_L$
					 
					<li> Attached ants pull with net force $F_{up} = (N_F+N_B)F_l$
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
					$$\newcommand {\Exp} {\mathbb{E}}$$
					<b> Population Counts </b>
					$$
					\frac{d}{dt} \Exp(N_{i:i\in S})
    						=
   				\sum_{\substack{j \in S, j \neq i}}
   				 \left( r_{ji} \Exp(N_j) - r_{ij} \Exp(N_i) \right) 
					$$

					<b> Load Position </b>
					$$\frac{d}{dt} \Exp(x_L) = \Exp( v_L )$$

					</section>

					<section>
					$$\newcommand{eqdef}{:=}$$

					<h3>   Moment Dynamics </h3>
					$$\newcommand {\Exp} {\mathbb{E}}$$
					<b> Load Velocity </b>
					<p align="left" class="fragment" data-fragment-index="1">$$
					 \frac{d}{dt} \Exp(v_L)

        \approx c_g + c_F \Exp(N_F) + c_B \Exp(N_B) + c_{Fv} \Exp( N_F ) \Exp( v_L )
		$$

			<p align ="left" class="fragment" data-fragment-index="2" >where  
			$$
			\begin{align}
			c_g \eqdef -\mu g &,& c_B \eqdef \mu F_l/m_L
			\\ c_F \eqdef (K v_L^d + \mu F_l)/m_L &,&
			 			c_{Fv} \eqdef K/m_L
			\end{align}
			$$.
			</p>

				





					

					
					</section>
					

					
					<section>
				

				
				

					<h3>   Best Fit Parameters </h3>
					<p align="left" class="fragment" data-fragment-index="1"> <b> Transition Rates </b>
	\begin{align*}
    r_{DB} &= 0.0197\,\text{s}^{-1},&
    r_{BD} &= 0.0205\,\text{s}^{-1},\\
    %
    r_{DF} &= 0, &
    r_{FD} &= 0,\\
    %
    r_{BF} &= 0.0301\,\text{s}^{-1},&
    r_{FB} &= 0.0184\,\text{s}^{-1},
    %
    %
\end{align*}
	</p>
				<p align="left" class="fragment" data-fragment-index="2"> <b> Proportional Regulator Parameters </b>

					\begin{align*}
    \text{Gain} &:& K &= 0.0035\,\text{N/(cm/s)},& \\
    \text{Velocity set-point} &:&v_L^d &= 0.3185 \,\text{cm/s}.
\end{align*}
	</p>

			
					
					</section>

					<section>
				
					<figure>
					<img src="antshs/Figs/HSCC2013Plots.png"  height="400" width="1450" style="position:relative; "/>
										   <figcaption> <normal><b> Predicted vs Observed Mean-Field Dynamics </b> </normal></figcaption>
					</figure>		
					
				
					
					
					</section>		

				
				
				</section> <!-- antshs ends -->


