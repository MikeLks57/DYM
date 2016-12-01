<?php

require_once 'header.php';

$getPortfolios = getPortfolio($pdo);

?>
<div>
	<?php foreach ($getPortfolios as $getPortfolio): ?>
		<img src="../include/uploads/<?php echo $getPortfolio['url'] ?>" alt="<?php echo $getPortfolio['alt'] ?>">
		<p><?php echo $getPortfolio['legend'] ?></p>
	<?php endforeach ?>
</div>
