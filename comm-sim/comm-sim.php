<section> <!--- comm sim -->


<section>
<h3> Towards Realistic MultiRobot + Wireless Simulation</h3>

<img src="comm-sim/Figs/roslogo.png"  height="90" width="200" style="position:absolute; TOP:350px; LEFT:-250px;"/>

<img src="comm-sim/Figs/swarmanoid.jpeg"  height="200" width="350" style="position:absolute; TOP:350px; RIGHT:-250px;"/>
<img src="comm-sim/Figs/geni-logo.png"  height="90" width="150" style="position:absolute; TOP:350px; RIGHT:450px;"/>		
		
</section>

<section>
<h3> ROS </h3>

<table>
<tr class="noBorder" width="1200px">
<table>
<tr class="noBorder" width="1200px">
<td>
<img src="comm-sim/Figs/ros2.png"  height="200" width="300" class="fragment" data-fragment-index="1"/>	
</td>

<td "vertical-align:top;">
<ul>
<li class="fragment" 	data-fragment-index="1"> Excellent implementation of pose tracking, motion planning, etc.
<li class="fragment" 	data-fragment-index="2"> <b> Limited </b> Multi-Robot simulation support. 
</ul>

</td>
</tr>
</table>


</section>

<section>

<h3> ARGoS  </h3>

<table>
<tr class="noBorder" width="1200px">
<td>
<img src="comm-sim/Figs/argos2.jpeg"  height="200" width="300" class="fragment" data-fragment-index="1"/>	
</td>

<td style="vertical-align:top;">


<ul>

<li class="fragment" 	data-fragment-index="1"> <b> Excellent </b> Multi-Robot simulation
<ul>
<li class="fragment" 	data-fragment-index="1"> Up to 100,000 Robots supported <a href="http://goo.gl/Eswuj1">(Pinciroli et al., 2011) </a>
</ul> 
<li class="fragment" 	data-fragment-index="2">Little pose tracking, motion planning, etc.

<li class="fragment" 	data-fragment-index="3"> RoboNetsim patches ARGoS-2 with NS-3 <a href="http://goo.gl/CIcR75"> (Kudelski et al., 2013) </a>

 <ul>
<li class="fragment" 	data-fragment-index="3"> <b> Does not work with ARGoS3! </b>
</ul> 
</ul>
</td>


</tr>
</table>

</section>
<section>
<h3> <a href="https://www.geni.net/?page_id=2"> GENI </a>  </h3>

<table>
<tr class="noBorder" width="1200px">
<td>
<img src="comm-sim/Figs/Geni-manet.jpg"  height="300" width="300" class="fragment" data-fragment-index="1"/>	
</td>

<td style="vertical-align:top;">

<ul>
<li class="fragment" 	data-fragment-index="1"> Virtual networking lab, with support for MANET
<li class="fragment" 	data-fragment-index="2"> Can be used for accurate Wi-fi experiments
<li class="fragment" 	data-fragment-index="3"> Precludes need for simulation
<li class="fragment" 	data-fragment-index="4"> Not obvious how to combine this with robots 
 
</ul>
</tr>
</td>
</table>

</section>



</section> <!-- comm sim -->
