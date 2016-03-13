<div class="slides">
				<section>
				<section>
					<h3> Stochastic Control Policies for Multi-Boundary Coverage    </h3>
					<table style="width:1200px">
					<tr class = "noBorder">
					<td>	
					 <figure>
					<img src="Figs/Ted.png"  height="150" width="125"/>	

					</figure>
					</td>
					<td>	
					 <figure>
					<img src="Figs/Sean.png"  height="150" width="150"/>	

					</figure>
					</td>
					<td>	
					 <figure>
					<img src="Figs/Ganesh.png"  height="150" width="150"/>	

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
					<b> Sources </b> <a href= "http://goo.gl/FKaPtN"> (Pavlic et al., ISRR '13) </a>
					</small>	
				</section>

				<section>
						<h3> Motivation </h3>
						<p align="left" class="fragment" data-fragment-index="1">	<b> Devise a controller for covering multiple boundaries with provable target allocations</b>
						<ul class="fragment" data-fragment-index="2">
						<li class="fragment" data-fragment-index="2"> Robots have limited computational  and sensing ability 
						<li class="fragment" data-fragment-index="2"> Controller must be simple and scalable
						</ul> 
						
					<table  class="fragment" data-fragment-index="2">
					<tr class="noBorder">
					<td>
					<figure>
					<img src="bcover-multi/Figs/AllocationCartoon.png"  height="300" width="350" />
					<figcaption> <small> <b> Robots (small circles) allocate to red-blue and yellow-brown loads </b></small></figcaption>	
					</figure>
					</td>
					
					</tr>
					</table>	


				</section>

				
				<section>
						<h3> Prior Work </h3>

						<table width="1200px" height="500 px" align="left">
						<tr class="noBorder">
						<td class = "fragment" data-fragment-index="1" align="center">
						Multi-Robot Task Allocation  	
						<ul class="fragment" 	data-fragment-index="1" align="left">	
						<li class="fragment" 	data-fragment-index="1"> <a href="https://goo.gl/zrPAQE"> (Correll and Martinoli, 2008) </a> </li>
						<li class="fragment"  	data-fragment-index="1"> <a href="http://goo.gl/gK9GLL"> (Liu and Winfield, 2013) </a></li>
						</ul>	
						</td>
							
						
						<td class = "fragment" data-fragment-index="2" align="center">
						Robotic Self-Assembly 
						<ul class="fragment" 	data-fragment-index="2" align="left">	
						<li class="fragment" 	data-fragment-index="2" align="left"> <a href="https://goo.gl/3hXfi5"> (Berman et al., 2009) </a> </li>
						<li class="fragment" 	data-fragment-index="2" align="left"> <a href="http://goo.gl/BhmMef"> (Napp et al., 2013) </a> </li>
						</ul>
						</td>
						</tr>
						
						<tr class="noBorder">
						<td class = "fragment" data-fragment-index="3" align="center">
						Stochastic Task Switching 
						<ul class="fragment" 	data-fragment-index="3" align="left">	
						<li class="fragment" 	data-fragment-index="3" align="left"> <a href="https://goo.gl/2TzVRJ"> (Hamann and Worn, 2008) </a> </li>
						<li class="fragment" 	data-fragment-index="3" align="left"> <a href="http://goo.gl/j6VX1Y"> (Prorok et al., 2011) </a> </li>
						</ul>


						</td>
						</tr>
	
						</table>

					<figure class="fragment" data-fragment-index="4" style="float:top;">
					<img src="bcover-multi/Figs/self-assem.jpg"  height="275" width="275" style="position:absolute; BOTTOM:50px; RIGHT:-250px;"/>
					<figcaption align="right" style="position:absolute; BOTTOM:0px; RIGHT:-300px;" > <small> <b> Robotic Self Assembly <a href="http://goo.gl/0kcQEg"> (Design News 2013) </a></b></small></figcaption>	
					</figure>
					</td>


						
				</section>	


				<section>
					<h3> Problem Statement: Objective  </h3>
					<p align="left" class="fragment" data-fragment-index="1">
					Get robots to allocate to multiple disk types, with  <br>
					each type having a  <i> predefined target number </i> of attachments 
					</p>
					<p align="left" class="fragment" data-fragment-index="2">
					<i> Example goal </i>: Two types of disks,
					<ul>
						<li class="fragment" data-fragment-index="2"> Large, with 3 robots / disk
						<li class="fragment" data-fragment-index="2"> Small, with 1 robots / disk
					</ul>					
					</p>

					<figure class="fragment" data-fragment-index="4" style="float:top;">
					<img src="bcover-multi/Figs/RoboZyme_problem_cartoon.png"  height="275" width="375" style="position:absolute; BOTTOM:50px; RIGHT:-250px;"/>
					<figcaption align="right" style="position:absolute; BOTTOM:0px; RIGHT:-250px;" > <small> <b> Robots allocating to two disk types </b> </a></b></small></figcaption>	
					</figure>
				</section>

				<section>
					<h3>  Assumptions: Robot Capabilities </h3>


					<p  class="fragment" data-fragment-index="1" align="left">&#10003; Sense and identify object types within limited range </p>
					<p  class="fragment" data-fragment-index="1" align="left">&#10003; Sense whether other robot is bound or unbound
					<p  class="fragment" data-fragment-index="1" align="left">&#10003; Perform Correlated Random Walks (CRW) </p>
					<p  class="fragment" data-fragment-index="2" align="left">&#10006; Prior data about disks </p>


					<figure class="fragment" data-fragment-index="3">
					<img src="Figs/Pheeno_Treads_Gripper.JPG"  height="250" width="450" style="position:absolute; BOTTOM:-100px; RIGHT:-300px;"  > 
					<figcaption align="right" style="position:relative; BOTTOM:-200px; RIGHT:-550px;"> <small> <b> Pheeno Robot <a href="http://goo.gl/ObpwYC"> (Wilson et al., 2016) </a></b> </a></b></small></figcaption>	
					</figure>	

				</section>

				<section>
					<h3> Assumptions: Disk Properties  </h3>
					<ul>
						<li class="fragment" data-fragment-index="1"> Placed randomly in environment
						<li class="fragment" data-fragment-index="2"> Types distinguished by weight, colour, etc.
					</ul>	
				</section>

				<section>
					<h3> Robot Controller  </h3>
					<figure>
					<img src="bcover-multi/Figs/RobotController.png"  height="300" width="600" />
					</figure>	

					
				</section>

				<section>
					<h3> Microscopic Model: Bimolecular CRN  </h3>
					<figure>
					<img src="bcover-multi/Figs/crn-cartoon.png"  height="200" width="450" />
					</figure>

					<table>
					<tr class="noBorder">
					<td style="vertical-align:top">
					
					<ul class="fragment" data-fragment-index="1">  <b> Species </b>
					<li class="fragment" data-fragment-index="1"> Free robots  $r$ 
					<li class="fragment" data-fragment-index="1">  Bound zones  $B$
					<li class="fragment" data-fragment-index="1">  Unbound zones  $U$
					</ul> 
					</td>
					
					<td style="vertical-align:top"> 
					<ul class="fragment" data-fragment-index="2"> <b> Reactions </b>
					<li class="fragment" data-fragment-index="2"> Bind   $r + U \xrightarrow{p_b e_u} B$ 
					<li class="fragment" data-fragment-index="2"> Unbind $r+B \xrightarrow {p_u e_b} R$
					</ul> 	

					</td>
				
					</tr>
					</table>					

				
				</section>

				
				<section>
					<h3> Encounter rates  </h3>
					<figure>
					<img src="bcover-multi/Figs/crn-cartoon.png"  height="200" width="450"  />
					</figure>
					<p align="left">
					 $e_b~(\text{resp.} ~e_u)$: Probability rate at which free robot encounters bound (resp. unbound) zone
					
					</p>	

					<ul align="left" class="fragment" data-fragment-index="2">
					<li align="left" class="fragment" data-fragment-index="2"> Hard to derive from first principles! 
					<li align="left" class="fragment" data-fragment-index="2"> Not under designer's control. 
					</p>
				
				</section>

						<section>
					<h3> Binding and Unbinding probabilities  </h3>
					<figure>
					<img src="bcover-multi/Figs/crn-cartoon.png"  height="200" width="450"  />
					</figure>
					<p align="left">
					 $p_b~(\text{resp.} ~p_u)$: Probability that a free robot will bind (resp. ask a bound robot to unbind)
					
					</p>	

					<p align="left" class="fragment" data-fragment-index="2">
					Under designer's control
					</p>
				
				</section>


					<section>
					<h3> Macroscopic ODE Model  </h3>

					<p align="left">
					Describes the time evolution of species concentrations
					$$\mathbf{x} := \begin{bmatrix} r & U  & B \end{bmatrix}^T$$ 
					</p>	

					<p align="left" class="fragment" data-fragment-index="2"> <b> ODE System </b>
					$$
					\dot{\mathbf{x}} = r(p_u e_b B - p_b e_u U) \begin{bmatrix} 1 & 1 & -1 \end{bmatrix}^T , ~\text{with}~
					\mathbf{x}_0 ~ \text{given}.
					$$

					</p>
				
					</section>

					
					<section>
					<h3> Equilibria  </h3>

					<p align="left">
					ODE has two equilibria of the form </p>

					<p align="left">

					$$
						\mathbf{x}^* = (r^*,U^*,B^*), ~\text{with}~ B^* + U^* = B_0^* +U_0^*.  
					$$
					
					</p>
					
					<p align="left" class="fragment" data-fragment-index="2"> <b> Trivial Equilibrium </b> <br> </p>
					<p align="left" class="fragment" data-fragment-index="2">
					If  $r_0 +B_0 < B^*$, then we have </p>

					 					<p align="left" class="fragment" data-fragment-index="2">$(r^*,U^*,b^*) = (0, U_0 -r_0, B_0+r_0)$ </p>
		
										<p align="left" class="fragment" data-fragment-index="2">caused by free robot depletion.
					</p>
				
				
					</section>

					<section>
					<h3> Nontrivial equilibrium  </h3>

					<p align="left">
					When $r_0 + B_0 > B^*$,  </p>

					<p align="left" class="fragment" data-fragment-index="2">
					\begin{align}r^* &= (r_0 +B_0) (1- \frac{B^*}{B_0+U_0}) -(U_0-r_0) \frac{B^*}{B_0+U_0} \\		
									   \frac{B^*}{U^*} &= \frac{p_be_u}{p_ue_b} \\
									  B^*+U^* &= B_0+U_0	
						\end{align}

					 	<br> <br>						
					with a unique solution.
										</p>
				
					</section>	

						<section>
					<h3> Unimolecular approximation  </h3>

					<p align="left">
					When $r_0$ is very large, $r(t) \approx r(0)$, and we approximate the CRN by  </p>

					<p align="left" class="fragment" data-fragment-index="2">
					\begin{align}	
					U \xrightarrow {p_b e_u r_0} B \\
					B \xrightarrow {p_u e_b r_0} U
					\end{align}

					 	<br> <br>						
					with time constant $\tau = \frac{1}{r_0(p_b e_u + p_u e_b)}$.
					</p>
				
					</section>


				
				
					<section>
					<h3> Correction for Spatial Effects  </h3>
					<figure>
					<img src="bcover-multi/Figs/DeltaCartoon.png"  height="400" width="400" />
					<figcaption align="bottom"  <small> <b> Robot attach too closely to leave space for another in between them  </b></small></figcaption>	
					</figure>	

				
				</section>
				<section>
					<h3> Correction for Spatial Effects  </h3>
						

				
				</section>
				
				<section>
					<h3> Validation of Control Strategy  </h3>
					<figure>
					<img src="bcover-multi/Figs/ValidationControl.png"  height="400" width="500" />
					
					</figure>	
	

				
				</section>

				
				<section>
					<h3> Robustness to Environmental variations  </h3>
						

				
				</section>
				

				</section> <!-- multi boundary -->
