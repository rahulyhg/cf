<?php /* Template Name:Calendario */ 

get_header(); // This fxn gets the header.php file and renders it ?>


			<?php if ( have_posts() ) : 
			// Do we have any posts in the databse that match our query?
			?>

				<?php while ( have_posts() ) : the_post(); 
				// If we have a post to show, start a loop that will display it
				?>
	
				<div class="container">
						<div class="col-md-12 main-texto">
								<h1>
									<?php the_title(); ?>
								</h1>
								<?php the_content(); ?>
						</div>
				</div>
				
				<?php endwhile; // OK, let's stop the post loop once we've displayed it ?>
		
			<?php else : // Well, if there are no posts to display and loop through, let's apologize to the reader (also your 404 error) ?>
				
				<article class="post error">
					<h1 class="404">No hay nada</h1>
				</article>

			<?php endif; // OK, I think that takes care of both scenarios (having a post or not having a post to show) ?>
<div class="container">
<table class="table table-striped">
  <tr>
    <th class="tg-yw4l">Concejal</th>
    <th class="tg-yw4l">A pedido</th>
    <th class="tg-yw4l">Reunión Con</th>
    <th class="tg-yw4l">Tema</th>
    <th class="tg-yw4l">Fecha</th>
  </tr>


<?php $args = array( 'post_type' => 'agenda', 'posts_per_page' => -1, 'meta_key'=>'_fecha_agenda', 'orderby' => 'meta_value', 'order' => 'DESC'  );
	$loop = new WP_Query( $args );
	//print_r($loop);
	while ( $loop->have_posts() ) : $loop->the_post(); 


	$concejal = get_post_meta(get_the_ID(), '_concejal', true); 
	$apedido = get_post_meta(get_the_ID(), '_apedido', true);
	$reunioncon = get_post_meta(get_the_ID(), '_reunioncon', true);
    $tema = get_post_meta(get_the_ID(), '_tema', true);
	$fecha = get_post_meta(get_the_ID(), '_fecha_agenda', true);
	$date = date_create($fecha);
	
?>


  <tr>
    <td class="tg-yw4l"><?php echo $concejal ?></td>
    <td class="tg-yw4l"><?php echo $apedido ?></td>
    <td class="tg-yw4l"><?php echo $reunioncon ?></td>
    <td class="tg-yw4l"><?php echo $tema;?></td>
    <td class="tg-yw4l"><?php echo date_format($date,'d/m/y');?></td>
  </tr>
	<?php endwhile; ?>
</table>
</div>
<?php get_footer(); // This fxn gets the footer.php file and renders it ?>