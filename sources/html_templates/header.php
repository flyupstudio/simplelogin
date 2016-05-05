<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Author" content="Programming FlyUpStudio" />
<meta name="description" content="<?= $this->MetaDescription ?>" />
<meta name="keywords" content="<?= $this->MetaKeywords ?>" />
<title><?= $this->Title ?></title>
<link rel="shortcut icon" href="<?= $this->RootUrl ?>public/images/favicon.ico" />

<? foreach($this->CSS as $path){ ?>
	<link rel="stylesheet" type="text/css" href="<?= $path ?>" media="screen" />
<? } ?>

<? foreach($this->JS as $path){ ?>
	<script type="text/javascript" src="<?= $path ?>"></script>
<? } ?>



</head>
<body>
	<table class="body-container" cellpadding="0" cellspacing="0">
		<tr>
			<td class="body-container-td">
				
			
				<div id="main_container">