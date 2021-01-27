<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $this->fetch('title'); ?>
	</title>
	
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css('cake.generic');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');

		echo $this->Html->css('https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css');
        echo $this->Html->css('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css');
        echo $this->Html->css('//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');
        echo $this->Html->css('https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css');
        echo $this->Html->css('mycss.css');

		echo $this->Html->script('https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js');
        echo $this->Html->script('https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js');   
        echo $this->Html->script('https://code.jquery.com/ui/1.12.1/jquery-ui.js');
        echo $this->Html->script('https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js');     
	?>
</head>
<body>
	<div id="container">
		<!--<div id="header">
			<h1><?php //echo $this->Html->link($cakeDescription, 'http://cakephp.org'); ?></h1>
		</div> -->

 
		
			<nav class="navbar navbar-inverse navbar-fixed-top">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand"  href="http://localhost/cakephp/users/profile">Timeline</a>
				</div>

				<?php if ($this->Session->read('Auth.User')){ ?>

					<ul class="nav navbar-nav">
						<li>
							<?php
								echo $this->Html->link(
									'Messages', array('controller' => 'messages', 'action' => 'index')
								);
							?>
						</li> 
					</ul>
					<ul class="nav navbar-nav pull-right">
						<li><a href="#"><?php echo AuthComponent::user('name'); ?></a></li> 
						<li>
							<?php
								echo $this->Html->link(
									'Logout', array('controller' => 'users', 'action' => 'logout')
								);
							?>
						</li> 
					</ul>

				<?php }	?>
				
			</div>
			</nav>  
		<div id="content" style="margin-top: 70px; ">

			<?php // echo $this->Flash->render(); ?> 
			<?php echo $this->fetch('content'); ?>

		</div>

	 

		<!--<div id="footer">
			<?php /*
			      echo $this->Html->link(
					$this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),
					'http://www.cakephp.org/',
					array('target' => '_blank', 'escape' => false, 'id' => 'cake-powered')
				 );*/
			?>
			<p>
				<?php// echo $cakeVersion; ?>
			</p>
		</div>-->
	</div>
	<?php  //echo $this->element('sql_dump'); ?>
</body>
</html>
