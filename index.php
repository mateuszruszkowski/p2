<?php
error_reporting(-1); # Report all PHP errors
ini_set("display_errors", 1);
?>

<!DOCTYPE html>
<html>
<head>
	<title>xkcd Password Generator</title>
	
	<meta charset='utf-8'>
	<meta name='viewport' content='width=device-width, initial-scale=1'>

	<link href='//netdna.bootstrapcdn.com/bootswatch/3.1.1/flatly/bootstrap.min.css' rel="stylesheet">

	<?php require "logic.php"; ?>

	<style type="text/css">
	.bg-primary, .bg-danger { padding: 15px;}
	.description { margin: 30px 0; }
	</style>
	
</head>	
<body>
	<div class="container-fluid">
  		<div class="row">
  			<div class="col-md-6 col-md-offset-3">

			<h1>xkcd Password Generator</h1>

			<h4>Project 2</h4>

			<p class="description">
				This Web App generates random passwords which are really difficult to break.<br />
				If you need you can add numbers and/or specials chars to your new password.<br />
				You can also change a separator char and transform words by uppercase or lowercase them.<br />
				<br />
				When you generate your password, you can bookmark page's link to generate similar password in the future.<br />
			</p>

			<?php if($passString){ ?>
				<p class="bg-primary"><?=$passString?></p>
			<?php } ?>

			<?php if($error){ ?>
				<p class="bg-danger"><?=$error?> </p>
			<?php } ?>
			<br />
			<br />
			<form method="GET" action="index.php" class="form-horizontal">

				<div class="form-group">

					<label for="words_number" class="col-sm-2">Number of words</label>
					<input maxlength=1 type="text" name="words_number" id="words_number" value="<?=isset($_GET['words_number']) ? $_GET['words_number'] : '5';?>"> Default 5, Max 9

				</div>
				
				<div class="form-group">

					<label for="numbers" class="col-sm-2">Add numbers</label>
					<input maxlength=1 type="text" name="numbers" id="numbers" value="<?=isset($_GET['numbers']) ? $_GET['numbers'] : '0';?>"> Default 0, Max 9
				
				</div>

				<div class="form-group">
				
					<label for="symbols" class="col-sm-2">Add symbols</label>
					<input maxlength=1 type="text" name="symbols" id="symbols" value="<?=isset($_GET['symbols']) ? $_GET['symbols'] : '0';?>"> Default 0, Max 9

			    </div>

		        <div class="form-group">

		        	<label for="max_length" class="col-sm-2">Max length</label>
					<input maxlength=2 type="text" name="max_length" id="max_length" value="<?=isset($_GET['max_length']) ? $_GET['max_length'] : '30';?>"> Default 30

				</div>

				<div class="form-group">

					<label for="separator" class="col-sm-2">Separator</label>
					<input maxlength=1 type="text" name="separator" id="separator" value="<?=isset($_GET['separator']) ? $_GET['separator'] : '-';?>">  Default -

				</div>

				<div class="form-group">
					<label for="cases" class="col-sm-2">Cases</label>
					<select id="cases" name="cases">
			                  <option <?=( !isset($_GET['cases']) || ($_GET['cases']==0)) ? 'selected="selected"' : '';?> value="0">First letters</option>
			                  <option <?=( isset($_GET['cases'])  && $_GET['cases']==1) ? 'selected="selected"' : '';?> value="1">Upper case</option>
			                  <option <?=( isset($_GET['cases'])  &&$_GET['cases']==2) ? 'selected="selected"' : '';?> value="2">Lower case</option>
			        </select>
				</div>

				<input type='submit' class='btn btn-primary' value='Generate'>
			</form>

			<br />
			<br />
			<p>
				<a href="/">Reset form to default</a>
			</p>

			</div>
	  	</div>
	</div>

	<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src='//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js'></script>

</body></html>