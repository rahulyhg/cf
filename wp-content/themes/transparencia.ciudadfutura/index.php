<? get_header() ?>

 <style type="text/css">
		.slice text {
			font-size: 10px;
			font-family: Arial;
			fill:#FFFFFF;
		}   

		.slice path {
		  stroke: #fff;
		}
</style>

<section class="container">
	<div class="col-md-8  col-md-offset-2 chart">

	<?php 

	$args = array( 'post_type' => 'movimientos', 'posts_per_page' => 4 );
	$loop = new WP_Query( $args );
	while ( $loop->have_posts() ) : $loop->the_post(); ?>

		<div class="graph-group col-md-12 nomarginpadding">
			<h2><?php the_title(); ?></h2>
			<div id="chart<?php echo get_the_ID(); ?>" class="col-md-6 chart"></div>
			<div id="data-<?php echo get_the_ID(); ?>" class="col-md-6 chart"></div>

			<?php
			$meta = get_post_meta( get_the_ID() ); 
			$exclude = array('_edit_last', '_wp_page_template', '_edit_lock');
			?>
			<script type="text/javascript">
					var w = 300,                        //width
					h = 300,                            //height
					r = 150,                            //radius
					color = ["#C31F24", "#DE5A48", "#EEC94B", "#45B29D", "#344D5C", "#B2181C", "#E2493D","#3A9E8A","#375D70"];//d3.scale.category20c();     //builtin range of colors
					data = [
			<?php foreach( $meta as $key => $value ) {
				if( in_array( $key, $exclude) )
				    continue;
				?>
				{"label":"<?php echo $key; ?>", "value":<?php echo $value[0]; ?>}, 
			<?php
			}
			?>
			];
					var vis = d3.select("#chart<?php echo get_the_ID(); ?>")
						.append("svg:svg")              //create the SVG element inside the <body>
						.data([data])                   //associate our data with the document
							.attr("width", w)           //set the width and height of our visualization (these will be attributes of the <svg> tag
							.attr("height", h)
						.append("svg:g")                //make a group to hold our pie chart
							.attr("transform", "translate(" + r + "," + r + ")")    //move the center of the pie chart from 0, 0 to radius, radius
					var arc = d3.svg.arc()              //this will create <path> elements for us using arc data
						.outerRadius(r)
						.innerRadius(r-70);
					var pie = d3.layout.pie()           //this will create arc data for us given a list of values
						.value(function(d) { return d.value; });    //we must tell it out to access the value of each element in our data array
					var arcs = vis.selectAll("g.slice")     //this selects all <g> elements with class slice (there aren't any yet)
						.data(pie)                          //associate the generated pie data (an array of arcs, each having startAngle, endAngle and value properties) 
						.enter()                            //this will create <g> elements for every "extra" data element that should be associated with a selection. The result is creating a <g> for every object in the data array
							.append("svg:g")                //create a group to hold each slice (we will have a <path> and a <text> element associated with each slice)
								.attr("class", "slice");    //allow us to style things in the slices (like text)
						arcs.append("svg:path")
								.attr("fill", function(d, i) { return color[i]; } ) //set the color for each slice to be chosen from the color function defined above
								.attr("d", arc);                                    //this creates the actual SVG path using the associated data (pie) with the arc drawing function
						arcs.append("svg:text")                                     //add a label to each slice
								.attr("transform", function(d) {                    //set the label's origin to the center of the arc
								//we have to make sure to set these before calling arc.centroid
								d.innerRadius = 0;
								d.outerRadius = r;
								return "translate(" + arc.centroid(d) + ")";        //this gives us a pair of coordinates like [50, 50]
							})
							.attr("text-anchor", "middle")                          //center the text on it's origin
							.text(function(d, i) { 
							return data[i].value+"%"; 

							});        //get the label from our original data array
						
						$("#data-<?php echo get_the_ID(); ?>").html("<ul>");
						$.each(data,function(ind,val){
							console.log(data[ind].value)	
							var $li=$('<li></li>');
							$li.html('<h3>'+data[ind].value+'%</h3><p>'+data[ind].label+'</p>');
							$li.find("h3").css("color",color[ind])
							$("#data-<?php echo get_the_ID(); ?> ul").append($li);
						
						})

					</script>
		</div>

	<?php endwhile; // end of the loop. ?>
	</div>
</section>


<? get_footer() ?>