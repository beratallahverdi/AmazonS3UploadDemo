<!doctype html>
<html lang="tr">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

	<title>Bulut Bilişim</title>
</head>

<body>
	<div class="container">
		<div id="yukleme">
			<br>
			<form action="<?php echo base_url("Upload");?>" class="form" method="POST" enctype="multipart/form-data">
			<div class="input-group">
				<input class="form-control" type="file" name="file">
				<span class="input-group-btn">
					<input class="btn btn-success" type="submit">
				</span>
			</div>
			</form>
		</div>
		<div id="bulut">
			<h2>Bulut</h2>
			<table class="table">
				<thead class="thead thead-dark">
					<tr class="row">
						<th scope="col">Dosya Adı</th>
						<th scope="col">Boyut</th>
					</tr>
				</thead>
				<tbody class="tbody">
					<?php foreach($bulut as $dosya){?>
					<tr class="row">
						<td scope="col">
							<a href="<?php echo $dosya["url"];?>">
								<?php echo pathinfo($dosya["url"])["basename"];?>
							</a>
						</td>
						<td scope="col"><?php echo $dosya["boyut"];?></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div> <!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
		integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
	</script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>

</html>
