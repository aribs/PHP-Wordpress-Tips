<?php
/*FUNCIONES PHP*/
	/*DEBUG*/
		/*Útil para revisar todos los datos de la variable*/
			var_dump($variable)
	/*VARIABLES*/
		/*Devuelve todas las variables definidas en el script*/
			get_defined_vars()
		/*Devuelve true si la variable está declarada*/	
			isset($variable)
	/*STRINGS*/
		/*Búsqueda mediante regexp*/
			preg_match('/regexp/', $variable a buscar)
		/**Busca y reemplaza /
			str_replace('str a sustituir', 'str nuevo ', $variable);
		/*Tamaño en carácteres del string*/
			strlen($str); // 6
		/*Cuenta palabras*/
			str_word_count($str2); // 4
		/*Genera una cadena única*/
			 uniqid();
		/*Convierte un array en string*/
			serialize($array)
		/*Convierte un string en array*/
			unserialize($string)
		/*Convierte un string en JSON*/
			json_encode($myvar)
		/*Vuelve el JSON al formato original*/
			json_decode($myvar)
		/*Comprime una cadena de texto*/
			gzcompress($string)
		/*Descomprime dicha cadena*/
			gzuncompress($compressed)
		/*Muestra un texto con la síntaxis resaltada*/
			highlithgt_string('<?php echo "hola a todos en comunidadq"; ?>');
		/*Compara las diferencias entre dos string*/
			levenshtein( 'cancion', 'canncioon' )


	/*Array*/
		/*Permite listar de forma consecutiva, devuelve un array con el contenido*/
			 range('a', 'j') //Array con el alfabeto desde a hasta j
			 range('1', '8')//Array con los números del 1 al 8
			 range(3, 30, 3)//Así subiríamos números de dos en dos, hasta el 30 
		/*Comprueba si un valor está dentro del Array*/
			in_array($array)
		/*Devuelve true si el valor es un array*/
			is_array($variable)

	

	/*Búsqueda mediante string*/
		strpos($variable, 'string')

	/*FUNCIONES ÚTILES*/
		/*Cuando se inicia una sesión(cookie)*/
			session_start()
		/*Valida Email*/
			if(!preg_match("/^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/",$email)) 


	/*Variables Globales entorno PHP*/
		/*Útil para guardar datos globales durante la sesión*/
			$_SESSION['nom_variable']  = 'valor_variable';
		/*Devuelve string con la URI del navegador*/
			$_SERVER[REQUEST_URI]
		/*Devuelve string con la URL y dominio del servidor*/
			$_SERVER[HTTP_HOST]
		/*Detecta user agent*/
			$_SERVER['HTTP_USER_AGENT'];
		/*Obtiene IP de usuario*/
			$_SERVER['REMOTE_ADDR'];
		/*Obtiene los parámetros de la URL*/
			$_SERVER['QUERY_STRING']
		/*Retorna la ruta absoluta del script que se está ejecutando ahora mismo*/
			$_SERVER['SCRIPT_FILENAME']
		/*Muestra la página anterior en el navegador a esta*/
			$_SERVER['HTTP_REFERER']


	/*$_POST*/
		/*Array que recoge variables pasadas mediante HTTP POST*/
			$HTTP_POST_VARS	

	/*Redirecciones*/
		header('Location: http://www.google.com'); // Te redireccionara a google







/*////////////////////////////////////////WORDPRESS//////////////////////////////////////////////////////////*/
	/*Cargar Jquery desde CDN*/
		wp_register_script('jquery', ("http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js"), false);
	/*Crear un Widget*/


    if (function_exists('register_sidebar')) {
        register_sidebar(array(
            'name' => 'Sidebar Widgets',
            'id'   => 'sidebar-widgets',
            'description'   => 'These are widgets for the sidebar.',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h2>',
            'after_title'   => '</h2>'
        ));
    }
 
 	/*Añadir Google Analytics al footer*/
function add_google_analytics() {
    echo '<script src="http://www.google-analytics.com/ga.js" type="text/javascript"></script>';
    echo '<script type="text/javascript">';
    echo 'var pageTracker = _gat._getTracker("UA-XXXXX-X");';
    echo 'pageTracker._trackPageview();';
    echo '</script>';
}
add_action('wp_footer', 'add_google_analytics');
	

	/*Obtener artículos mas recientes*/
	/*Parámetros:
		1. Cantidad: (por defecto 5 ) – Número de entradas para mostrar.
		2. Categorías: (por defecto todas las categorías ) – Categorías a incluír o excluir.
		3. HTML anterior: ( por defecto li ) – HTML antes del enlace al artículo.
		4. HTML después: (por defecto /li ) – HTML después del enlace.
	Ejemplo de uso:*/
	PHP

<ul>
// obtiene las 10 últimas entradas de todas las categorías excepto de la categoría 5
if ( function_exists( 'wp_list_recent_posts' ) ) wp_list_recent_posts( 10, '-5' );
</ul>
</pre>
La función que va en functions.php es:
<pre lang="php" line="1">
function wp_list_recent_posts( $iAmount = 5, $szCat = null, $szBefore = "<li>", $szAfter = "</li>" )
{
    ( $szCat != null ) ? $szCat = "&cat=" . $szCat : $szCat ;
    $aRecentPosts = new WP_Query( "showposts=" . $iAmount . $szCat );
    while($aRecentPosts->have_posts()) : $aRecentPosts->the_post();
    $szReturn .= $szBefore . '<a href="' . get_permalink() . '">' . get_the_title() . '</a>' . $szAfter;
    endwhile;
    echo $szReturn;
}

	/*Obtiene artículos más populares basado en el número de comentarios*/
	/*Aquí mostrará los 6 primeros*/

function get_popular_posts() {
    global $wpdb;
    $now = gmdate("Y-m-d H:i:s",time());
    $lastmonth = gmdate("Y-m-d H:i:s",gmmktime(date("H"), date("i"), date("s"), date("m")-12,date("d"),date("Y")));
    $popularposts = "SELECT ID, post_title, COUNT($wpdb->comments.comment_post_ID) AS 'stammy' FROM $wpdb->posts, $wpdb->comments WHERE comment_approved = '1' AND $wpdb->posts.ID=$wpdb->comments.comment_post_ID AND post_status = 'publish' AND post_date < '$now' AND post_date > '$lastmonth' AND comment_status = 'open' GROUP BY $wpdb->comments.comment_post_ID ORDER BY stammy DESC LIMIT 6";
    $posts = $wpdb->get_results($popularposts);
    $popular = '';
    if($posts){
        foreach($posts as $post){
            $post_title = stripslashes($post->post_title);
            $guid = get_permalink($post->ID);
            $popular .= '<li><a href="'.$guid.'" title="'.$post_title.'">'.$post_title.'</a></li>';
            $i++;
        }
    }
    echo $popular;
}
	/*Obtener y mostrar la primera imagen de una entrada de blog*/
	<ul>
if ( function_exists( 'get_post_image' ) ) get_post_image( 0, true );
</ul>
	//Y en functions.php escribe esto:

function get_post_image( $iImageNumber = 0, $bPrint = false )
{
    global $post;
    $szPostContent = $post->post_content;
    $szSearchPattern = '~<img [^\>]*\ />~';
    preg_match( $szSearchPattern, $szPostContent, $pics );
    if ( $bPrint == true && !empty($pics) ) echo $pics[$iImageNumber]; else return $pics[$iImageNumber];
}

	/*Crear paginación de artículos sin plugin*/
	
function pagination($prev = '«', $next = '»') {
//En Functions.php
	global $wp_query, $wp_rewrite;
	$wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;
	$pagination = array(
	'base' => @add_query_arg('paged','%#%'),
	'format' => '',
	'total' => $wp_query->max_num_pages,
	'current' => $current,
	'prev_text' => __($prev),
	'next_text' => __($next), 'type' => 'plain'
	);
	if( $wp_rewrite->using_permalinks() )
		$pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ) . 'page/%#%/', 'paged' );
	if( !empty($wp_query->query_vars['s']) )
		$pagination['add_args'] = array( 's' => get_query_var( 's' ) ); echo paginate_links( $pagination );
//Añadir la función creada anteriormente (pagination()) al loop de worpress

	<?php if ( have_posts() ) : ?>
	<?php while ( have_posts() ) : the_post(); ?>
	// aquí va el contenido del artículo
	<?php endwhile; ?>
	<div class="pagination"><?php pagination('»', '«'); ?></div>
	<?php endif; 
//Se puede modificar el estilo del paginador

	.page-numbers { font-size: 15px; }
	.page-numbers.current { color: #222; }
	.page-numbers .dots { letter-spacing: 1px }
	a.page-numbers { font-size: 14px; color: #3888ff; }

//Redireccionar la búsqueda si solo hay un resultado
	//En functions PHP
	
	add_action('template_redirect', 'single_result');
	function single_result() {
	if (is_search()) {
		global $wp_query;
	if ($wp_query->post_count == 1) {
		wp_redirect( get_permalink( $wp_query->posts['0']->ID ) );
			}
		}
	}
//Limitar la búsqueda solo a los títulos de los artículos
	//En functions.php

function __search_by_title_only( $search, &amp;$wp_query )
	{
	if ( empty($search) )
		return $search;
		$q =&amp;amp;amp;amp; $wp_query->query_vars;
		// wp-includes/query.php line 2128 (version 3.1)
		$n = !empty($q['exact']) ? '' : '%';
		$searchand = '';
	foreach( (array) $q['search_terms'] as $term ) {
		$term = esc_sql( like_escape( $term ) );
		$search .= "{$searchand}($wpdb->posts.post_title LIKE '{$n}{$term}{$n}')";
		$searchand = ' AND ';
		}
	$term = esc_sql( like_escape( $q['s'] ) );
	if ( empty($q['sentence']) &amp;&amp; count($q['search_terms']) > 1 &amp;&amp; $q['search_terms'][0] != $q['s'] )
		$search .= " OR ($wpdb->posts.post_title LIKE '{$n}{$term}{$n}')";
	if ( !empty($search) ) {
		$search = " AND ({$search}) ";
	if ( !is_user_logged_in() )
		$search .= " AND ($wpdb->posts.post_password = '') ";
	}
	return $search;
	}
		add_filter( 'posts_search', '__search_by_title_only', 10, 2 );

//Ver número de visitar en un artículo
	//Dentro de functions.php		
function getPostViews($postID){
	$count_key = 'post_views_count';
	$count = get_post_meta($postID, $count_key, true);
	if($count==''){
		delete_post_meta($postID, $count_key);
		add_post_meta($postID, $count_key, '0');
		return "0 View";
		}
	return $count.' Views';
	}
	function setPostViews($postID) {
	$count_key = 'post_views_count';
	$count = get_post_meta($postID, $count_key, true);
	if($count==''){
		$count = 0;
		delete_post_meta($postID, $count_key);
		add_post_meta($postID, $count_key, '0');
	}else{
		$count++;
		update_post_meta($postID, $count_key, $count);
	}
}

?>

Funciones para el header.php 
	<?php bloginfo(’name’); ?> Título del blog 
	<?php bloginfo(’description’); ?> Descripción del blog 
	<?php bloginfo(’version’); ?> Versión de WordPress 
	<?php bloginfo(’url’); ?> URL del blog 
	<?php bloginfo(’pingback_url’); ?> URL de los Pingbacks del blog 
	<?php bloginfo(’atom_url’); ?> URL para los feeds Atom del blog 
	<?php bloginfo(’rss2_url’); ?> URL para los feeds RSS2 del blog 
	<?php bloginfo(’html_type’); ?> Versión HTML del blog 
	<?php bloginfo(’charset’); ?> Juego de Caracteres del blog 
	<?php bloginfo(’stylesheet_url’); ?> Ruta de la hoja de estilos(”‘style.css”) 
	<?php bloginfo(’template_url’); ?> Ruta del Theme actual 

	Funciones para el resto de ficheros 
	<?php the_content(); ?> Contenido de los posts 
	<?php if(have_posts()) : ?> Si hay posts… 
	<?php endif; ?> Cierra la condición 
	<?php while(have_posts()) : the_post(); ?> Mientras haya posts, muestralos 
	<?php endwhile; ?> Cierra el mientras 
	<?php get_header(); ?> Muestra el contenido de header.php 
	<?php get_sidebar(); ?> Muestra el contenido de sidebar.php 
	<?php get_footer(); ?> Muestra el contenido de footer.php 
	<?php the_date() ?> Muestra la fecha 
	<?php the_time() ?> Muestra la hora 
	<?php the_time(’d-m-y’) ?> Muestra la fecha en formato d-m-y 
	<?php comments_popup_link(); ?> Enlace a los comentarios del post 
	<?php wp_title(); ?> Título del post o página 
	<?php the_permalink() ?> URL de post 
	<?php the_category(’, ‘) ?> Categorías del post 
	<?php the_author(); ?> Autor del post 
	<?php the_ID(); ?> ID del post 
	<?php edit_post_link(); ?> Enlace para editar el post 
	<?php get_links_list(); ?> Enlaces del blogroll 
	<?php comments_template(); ?> Muestra el contenido de Comments.php 
	<?php wp_list_pages(); ?> Lista las páginas del blog 
	<?php wp_list_cats(); ?> Lista las categorías del blog 
	<?php next_post_link(’ %link ‘) ?> Enlace al siguiente post 
	<?php previous_post_link(’%link’) ?> Enlace al post anterior 
	<?php get_calendar(); ?> Muestra el calendario 
	<?php wp_get_archives() ?> Muestra los archivos del blog 
	<?php posts_nav_link(); ?> Enlaces al Siguiente o Anterior Post 
	<?php include(TEMPLATEPATH . ‘/archivo.php’); ?> Para incluir cualquier archivo que este dentro del theme 
	<?php the_search_query(); ?> Valor del formulario de búsqueda 
	<?php _e(’Texto’); ?> Muestra “Texto” 
	<?php wp_register(); ?> Enlace al registro 
	<?php wp_loginout(); ?> Enlace al login o logout 
	<?php wp_meta(); ?> Meta para administradores 
	<?php timer_stop(1); ?> Tiempo de carga del blog 
	<?php echo get_num_queries(); ?> Número de consultas al cargar el blog

	