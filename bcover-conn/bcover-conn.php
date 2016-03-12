

<section>

<section>
<h3> Analyzing the Wireless Network of an SCS</h3>
</section>

<section>
$$
\newcommand{\Bo}{\mathcal{B}}
\newcommand{\conn}{d}
\newcommand{\Rob}[1]{\mathcal{R}_{#1}}
\newcommand{\dia}{\delta}
\newcommand{\upos}[1]{x'_{#1}}
\newcommand{\uposvec}{\mathbf{x}'}
\newcommand{\rvupos}[1]{X'_{#1}}
\newcommand{\rvuposvec}{\mathbf{X}}
$$
<h3> Problem Setting</h3>

<p  class="fragment" 	data-fragment-index="1">
<ul>
<li>  Environment has coloured line segment boundary $\Bo$ 
<li>  Robots $\Rob{1:n}$ placed in environment
	<ul>
	<li> each of diameter $\dia$
	<li> communication and sensing radius $\conn$
	</ul>
<li>  Robots walk randomly and attach to $\Bo$ 
</ul>
</p>

<p  class="fragment" 	data-fragment-index="2"> <b> Goal </b> : <i> Cover </i> the boundary, forming a connected network




</section>

<section> 

<h3> Robot Configuration </h3>

<p  class="fragment" 	data-fragment-index="1">
<ul>
<li> Boundary has length $s$ 
<li> Position of $\Rob{i}$ = position of its left end = $\upos{i}$ on $\Bo$
<li> Configuration = <i>unordered</i> positions $\uposvec = \upos{1:n}$ 
<li> Configuration is <it>collision-free (CF) </it> iff $|\upos{i} - \upos{j}| \geq \delta$
</ul>
</p>

<p  class="fragment" 	data-fragment-index="2"> Only CF configurations considered from now. </p>

</section>



<section>

<h3> Robot communication</h3>


<ul>
<li>  Captures the notion of robots "being close enough to each other"
<li> $\Rob{i}$ and $\Rob{j}$ inter-communicate iff $|\upos{i} - \upos{j} |  \leq \conn$
</ul>

</section>




<section>
<h3> Communication Graph $\mathcal{G}$ </h3>

<p class="fragment" 	data-fragment-index="1" align="left">
Define the communication graph $\mathcal{G}$ as one with
<ul class="fragment" 	data-fragment-index="1" align="left">
<li class="fragment" 	data-fragment-index="1"> vertices at each position $\upos{i}$ 
<li class="fragment" 	data-fragment-index="1"> edges connecting pairs of inter-communicating robots
</ul>
</p>


<p class="fragment" 	data-fragment-index="2" align="left">
We define $\G$ to be <i>connected</i> when

<ul class="fragment" 	data-fragment-index="2" align="left">
<li class="fragment" 	data-fragment-index="2"> $\G$ forms a connected graph, and
<li class="fragment" 	data-fragment-index="2">  every point on $\Bo$ is within range from at least one $\Rob{i}$
</ul>
</p>
</section>

<section>
$$
\newcommand{\pos}[1]{{x}_{#1}}
\newcommand{\posvec}{\mathbf{x}}
\newcommand{\rvpos}[1]{{X}_{#1}}
\newcommand{\rvposvec}{\mathbf{X}}
\newcommand{\si}[1]{s_{#1}}
\newcommand{\svec} {\mathbf{s}}
$$
<h3> Order Statistics </h3>

<ul class="fragment" 	data-fragment-index="1" align="left">  <b> Order Statistics :</b> Sorted positions $\posvec = \pos{1:n}$ <a href="https://goo.gl/4nzdyK"> (David &amp; Nagaraja '03) </a>
<li class="fragment" 	data-fragment-index="2" align="left"> Virtual Robots : $\pos{0} := -\dia, \pos{n+1} := s$
<li class="fragment" 	data-fragment-index="3" align="left">  $\uposvec$ is called <i> parent </i> of $\posvec$  
</ul>
</p>



</section>

<section>
<h3> Slacks </h3>

<ul class="fragment" 	data-fragment-index="1" align="left"> 
<li class="fragment" 	data-fragment-index="1" align="left"> <b> Slacks </b> are interrobot distances $$\si{i} :=\pos{i} - \pos{i-1}$$
<li class="fragment" 	data-fragment-index="2" align="left"> <b> Slack vector </b> $\svec := \si{1:n+1}$
<li class="fragment" 	data-fragment-index="3" align="left"> CF requires $\si{i} \geq \dia$

<li class="fragment" 	data-fragment-index="4" align="left"> Connectivity requires $\si{i} \leq \conn$

 </ul>
</p>



</section>


<section>
<h3> Communication Graph $\mathcal{G}$ </h3>

<ul class="fragment" 	data-fragment-index="1" align="left">
<li class="fragment" 	data-fragment-index="2"> $\G$ is a <i> Geometric Graph </i>
<li class="fragment" data-fragment-index="3"> When $\upos{i}$ are drawn from iid rv's, $G$ is a<i> Random Geometric Graph (RGG) </i>  <a href="https://goo.gl/LGVqWr"> (Penrose '03)</a>
<li class="fragment" data-fragment-index="4"> $\G$ is  <i>Gilbert's Disk Graph </i> <a href="https://goo.gl/LxWbzh" > (Haenggi '12)</a> in $\mathbb{R}^1$ 

</ul>

</section>



<section>
$$
\newcommand{\upos}[1]{x_{#1}}
\newcommand{\rvupos}[1] {X_{#1}}
\newcommand{\rvuposvec}{\mathbf{X}}
\newcommand{\fpar}{h}
\newcommand{\Fpar}{H}
\newcommand{\rvsi}[1] {S_{#1}}
$$
<h3> Problem Statement - I</h3>

<p class="fragment" 	data-fragment-index="1" align="left">Suppose $\upos{i}$ are realizations of iid parents $\rvupos{i}$ each with pdf $\fpar(t)$ supported on $\Bo=\{t:0\leq t\leq s\}$. 
<p class="fragment" 	data-fragment-index="1" align="left"> Determine:

<ul class="fragment" 	data-fragment-index="1" align="left"> 
<li class="fragment" 	data-fragment-index="2" align="left"> Probability $\pcon$ that $\G$ is connected.
<li class="fragment" 	data-fragment-index="3" align="left"> PDFs of $\rvpos{i}$ and $\rvsi{i}$ for general $\G$
<li class="fragment" 	data-fragment-index="4" align="left"> PDFs of  $\rvpos{i}$ and $\rvsi{i}$ when $\G$ is <i> connected </i>. 
</ul> 


</section>

<section>

<h3> Problem Statement - II</h3>

<p class="fragment" 	data-fragment-index="1" align="left">Extend the analysis in Part I to the cases when: 
<p class="fragment" 	data-fragment-index="1" align="left"> 

<ul class="fragment" 	data-fragment-index="2" align="left"> 
<li class="fragment" 	data-fragment-index="2" align="left"> robots have distinct communication radii $d_i$ 
<li class="fragment" 	data-fragment-index="2" align="left"> parents $\rvuposvec$ are inid
</ul> 
<p class="fragment" 	data-fragment-index="3" align="left"> Determine the complexity of computing $\pcon$. 


</section>


					
</section> <!-- problem setting -->


<section>

<section>
<h3> Problem Solving Tools</h3>



<ul class="fragment" 	data-fragment-index="1" align="left">
<li class="fragment" 	data-fragment-index="2"> Geometric interpretation of $\posvec$ and $\svec$ 
<li class="fragment" data-fragment-index="3"> Order Statistics  
<li class="fragment" data-fragment-index="4"> Polytopes  
<li class="fragment" data-fragment-index="5"> Complexity of simplex/hypercube intersection   

</ul>

</section>


<section>
<h3> Position Simplex </h3>
$$
\newcommand{R}{\mathbb{R}}
\newcommand{\psimp}{\mathcal{P}}
$$

<p ul class="fragment" 	data-fragment-index="1" align="left"> Consider <i>point</i> robots, for which CF is irrelevant </p>

<ul class="fragment" 	data-fragment-index="1" align="left">
<li class="fragment" 	data-fragment-index="2"> Think of $\posvec$ (and $\uposvec$) as a point in $\R^n$
<li class="fragment" data-fragment-index="3"> Valid (sorted) positions have 
$$
\pos{0} = 0\leq \pos{1} \leq \ldots \pos{n} \leq \pos{n+1} =s
$$

<li class="fragment" data-fragment-index="4"> Set of such positions forms <i> position simplex </i> $\psimp$  
<li class="fragment" data-fragment-index="5"> Vertices of $\psimp$ are of the form $$(0,0,\ldots,0,s,s,\ldots,s)$$   

</ul>

</section>

<section>
<h3> Slack Simplex </h3>
$$
\newcommand{\ssimp}{\mathcal{S}}
\newcommand{\1}{\mathbf{1}}
$$

<ul class="fragment" 	data-fragment-index="1" align="left">
<li class="fragment" 	data-fragment-index="2"> Think of $\svec$ as a point in $\R^{n+1}$
<li class="fragment" data-fragment-index="3"> Valid slack vectors have 
$$
\begin{align}
\si{i} \geq 0 \\
 \sum_{i=1}^{n+1} \si{i} = s, ~\text{or as a half space}~ \sum_{i=1}^{n}  \si{i} \leq s.
\end{align}
$$

<li class="fragment" data-fragment-index="4"> Set of such vectors forms <i> slack simplex </i> $\ssimp$  

</ul>

</section>


<section>
<h3> Defining Connectivity </h3>
$$
\newcommand{\hyp}{\mathcal{hyp}}
\newcommand{\1}{\mathbf{1}}
$$

<ul class="fragment" 	data-fragment-index="1" align="left">
<li class="fragment" 	data-fragment-index="2"> Connected slack vectors have $0 \leq \si{i} \leq \conn$
<li class="fragment" data-fragment-index="3"> All these vectors lie in a hypercube 
$$
\hyp := \{ \svec \in \R^{n+1} : 0\leq \si{i} \leq \conn \}
$$

<li class="fragment" data-fragment-index="4"> This is immaterial of $\svec$ lying in $\ssimp$.  

</ul>

</section>

<section>
<h3> Connected and Disconnected Regions </h3>
$$
\newcommand{\hyp}{\mathcal{H}}
\newcommand{\1}{\mathbf{1}}
\newcommand{\fav}{\mathcal{F}}
\newcommand{\unfav}{\mathcal{U}}
\newcommand{\vvec}{\mathbf{v}}
$$

<ul class="fragment" 	data-fragment-index="1" align="left">
<li class="fragment" 	data-fragment-index="2"> For $\G%$ to be connected, we need $\svec \in \ssimp \cap \hyp$
<li class="fragment" data-fragment-index="3"> Define  the <i> connected region</i> $\fav := \ssimp \cap \hyp$
<li class="fragment" data-fragment-index="4"> Define the <i> disconnected region </i> $\unfav := \ssimp \setminus \fav$ 

</ul>

</section>


<section>
<h3> Decomposing  $\unfav$ </h3>
$$
\newcommand{\hyp}{\mathcal{H}}
\newcommand{\1}{\mathbf{1}}
\newcommand{\fav}{\mathcal{F}}
\newcommand{\unfav}{\mathcal{U}}
\newcommand{\vvec}{\mathbf{v}}
$$

<p align="left" class="fragment" 	data-fragment-index="1"><b> Theorem (<a href="https://goo.gl/B0D4L1"> Kumar and Berman </a>) </b> The disconnected region can be expressed as the intersection of simplices 
$$
\unfav := \bigcap\limits_{\vvec \in \{0,1 \} ^{n+1}, \1^T \vvec \geq 1} \ssimp(\vvec), 
$$

where

$$
\begin{align}
\label{eqn:decomp}
\ssimp(\vvec):= \{ \svec \in \ssimp : s_i \geq \conn ~\text{whenever}~ v_i =1  \}.
\end{align}
$$


<p align="left" class="fragment" 	data-fragment-index="2"> $\ssimp(\vvec)$ forms a simplex of side $s-d\1^T\vvec$.


</section>
</section> <!-- toools -->


<section> <! --- Result summary -->

<section>
<h3> Summary of Results </h3>
</section>

<section>
<h3> Uniform Coverage: Finding $\pcon(\G)$  </h3>
$$
\newcommand{\Vol}{\mathrm{Vol}}
\newcommand{\nmin}{n_{\min}}
$$

<p align="left" class="fragment" 	data-fragment-index="1">
When parents $\rvupos{i}$ are each uniform on $\Bo$, we have  
$$

\pcon(\G) =  1 - \sum _{k=1} ^{\nmin} (-1)^{k-1} \binom{n}{k} {(1-kd/s)^n } ~\text{where}~ \nmin = \lfloor \frac{s}{\conn} \rfloor. 
$$
</p>

<p align="left" class="fragment" 	data-fragment-index="2">
Here, $\nmin$ is the minimum number of robots needed for connectivity.

</p>

</section>

<section>
<h3> IID Coverage: Finding $\pcon(\G)$  </h3>
$$
\newcommand{\rvsvec}{\mathbf{S}}
\newcommand{\jsla}{f_{\rvsvec}(\svec)}
$$

<ul align="left" class="fragment" 	data-fragment-index="1">

<li  class="fragment" 	data-fragment-index="2">
When parents $\rvupos{i}$ are each iid on $\Bo$, we have  
$$
\pcon(\G) =  \frac{\int_{\svec \in \fav} \jsla d\svec }{\int_{\svec \in \ssimp} \jsla d\svec }.
$$

<li class="fragment" 	data-fragment-index="3"> No easy way to do this in general!
<li class="fragment" data-fragment-index="4"> Can be simplified using the probability integral transform $Y'_i := \Fpar_{X'_i}(t)$.

</ul>

</section>

<section>
<h3> IID Coverage: Order Statistics  </h3>


<ul align="left" class="fragment" 	data-fragment-index="1">

<li  class="fragment" 	data-fragment-index="2">
For general $\G$ <a href="https://goo.gl/4nzdyK"> (David &amp; Nagaraja '03) </a>
$$
f_{\rvpos{i}}(t) = \sum \limits_{j=i}^n \Fpar(t)^j (1-\Fpar(t))^{n-j}.
$$


<li class="fragment" 	data-fragment-index="3"> For connected $\G$, we need to marginalize similarly to $\pcon(\G)$.
<li class="fragment" 	data-fragment-index="4"> Formulas for slacks found by a similar process.
</ul>

</section>

<section>
<h3> Finite Robots with IID Coverage  </h3>
$$
\newcommand{\Vol}{\mathrm{Vol}}
\newcommand{\nmin}{n_{\min}}
$$

<p align="left" class="fragment" 	data-fragment-index="1">
When robots have diameter $\dia$, use $\ssimp_{CF}$ instead of $\ssimp$ 
$$
\ssimp_{CF} := \{ \svec \in \ssimp: s_i \geq d  \}.
$$
</p>

<p align="left" class="fragment" 	data-fragment-index="2">
No (simple) formula for any of $\rvpos{i}, S_i$, and $\pcon$! 
</p>


</section>

</section> <!-- Result summary -->


<section> <!-- lower bounds -->
$$
\newcommand{\PCON} {\mathsf{PCON}}
\newcommand{\Q}{\mathbb{Q}}
$$
<section>
<h3> Lower bounds for  $\pcon$ </h3>


<p class="fragment" 	data-fragment-index="1" align ="left">Define the $\PCON(\fpar)$ problem with 


<ul>
<li class="fragment" 	data-fragment-index="2"> <b> Inputs </b>: $(s,d,n) \in \Q_+$ and $\fpar$ is the parent
<li class="fragment" 	data-fragment-index="3"> <b> Output </b>: $\pcon(\G) \in \Q_+$ 
</ul>

</section>



<section>

<h3>  $\PCON(\mathrm{Uni})$ is $\mathrm{Psuedo}-\mathsf{P}$  </h3>


<p class="fragment" 	data-fragment-index="1" align="left" >
<b> Theorem  <a href="" > (Kumar and Berman, to appear) </a></b>  $\PCON(\mathrm{Uni})$ can be solved in $\Omega(n)$ and $O(n \log n)$ time. </b>

<p class="fragment" 	data-fragment-index="2" align="left" >
<b> Proof  </b>: Straightforward from formula.


</section>


<section>
$$
\newcommand{\PH}{\#\mathsf{PH}}
$$

<h3>  $\PCON(\mathrm{poly})$ is $\PH$ </h3>


<p class="fragment" 	data-fragment-index="1" align="left" >
<b> Theorem  <a href="" > (Kumar and Berman, to appear) </a></b>  $\PCON$  is $\PH$ for arbitrary polynomial parents supported on $\Bo$.

<p class="fragment" 	data-fragment-index="2" align="left" >
<b> Proof  </b>: Reduction from <a href="http://goo.gl/nDYL7n" > (Dyer and Frieze '87) </a>.



</section>

<section>
<h3> Other hard cases of $\PCON$  </h3>


<p class="fragment" 	data-fragment-index="1" align="left" >
<b> Theorem  <a href="" > (Kumar and Berman, to appear) </a></b>  $\PCON$  is $\PH$ for the following instances:

<ul>
<li class="fragment" 	data-fragment-index="2"> Uniform parents of robots with distinct radii
<li class="fragment" 	data-fragment-index="3"> General INID parents
</ul>




</section>


</section> <!-- Lower Bounds -->





</section> <!-- comm sim -->














