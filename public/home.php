<?php 
require_once 'header.php';

/*require_once 'slider.php';*/

$getPosts = getPost();
?>

<?php foreach ($getPosts as $getPost): ?>
	<div>
		<h3><?php echo $getPost['title'] ?></h3>
		<img src="../include/uploads/<?php echo $getPost['url'] ?>" alt="<?php echo $getPost['alt'] ?>">
		<p><?php echo $getPost['content'] ?></p>
		<p>Ecrit par <?php echo $getPost['firstname'] ?> <?php echo $getPost['lastname'] ?> le : <?php echo $getPost['datePost'] ?></p>
	</div>
<?php endforeach ?>