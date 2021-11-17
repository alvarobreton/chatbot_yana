<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php 
foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
</head>
<body>
	<div>
		<a href='<?php echo site_url('welcome')?>'>Casos</a> | 
		<a href='<?php echo site_url('welcome/conversations')?>'>Conversaciones</a> | 
		<a href='<?php echo site_url('welcome/users')?>'> Usuarios</a> | 
		<a href='<?php echo site_url('welcome/keys')?>'>API keys</a> | 
		<a href='<?php echo site_url('welcome/logs')?>'>API logs</a> | |
		<a href='<?php echo site_url('welcome/questions_bot')?>'>Preguntas Bot</a> | 
		<a href='<?php echo site_url('welcome/quick_replies')?>'>Respuestas sugeridas</a> | 
		<a href='<?php echo site_url('welcome/user_cases')?>'>Relación usuario caso</a>

		
	</div>
	<div style='height:20px;'></div>  
    <div style="padding: 10px">
		<?php echo $output; ?>
    </div>
    <?php foreach($js_files as $file): ?>
        <script src="<?php echo $file; ?>"></script>
    <?php endforeach; ?>


</body>
</html>
