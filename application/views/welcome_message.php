<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="Description" content="Enter your description here" />

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css">

	<!-- Font Awesome CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">

	<!-- Toastr CSS -->
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

	<!-- Datatables CSS -->
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.21/b-1.6.3/b-flash-1.6.3/b-html5-1.6.3/b-print-1.6.3/r-2.2.5/datatables.min.css" />

	<title>Codeigniter Datatables Ajax Crud With Image Upload Tutorial</title>
</head>

<body>
	<div class="container">
		<div class="row">
			<div class="col-md-12 mt-5">
				<h1 class="text-center">Codeigniter Datatables Ajax Crud With Image Upload Tutorial</h1>
				<hr>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<!-- Button trigger modal -->
				<button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#addRecords">
					Add Record
				</button>

				<!-- Add Records Modal -->
				<div class="modal fade" id="addRecords" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Add Record</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">

								<!-- Add Record Form -->
								<form id="addRecordForm">

									<!-- Name -->
									<div class="input-group mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text bg-info text-white" id="basic-addon1"><i class="fas fa-user"></i></span>
										</div>
										<input type="text" class="form-control" id="name" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
									</div>

									<!-- Email -->
									<div class="input-group mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text bg-info text-white" id="basic-addon1"><i class="fas fa-envelope"></i></span>
										</div>
										<input type="text" class="form-control" id="email" placeholder="Email Address">
									</div>

									<!-- Mobile No. -->
									<div class="input-group mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text bg-info text-white" id="basic-addon1"><i class="fas fa-phone-alt"></i></span>
										</div>
										<input type="text" class="form-control" id="mob" placeholder="Mobile No.">
									</div>

									<!-- Image -->
									<div class="custom-file">
										<input type="file" class="custom-file-input" id="img">
										<label class="custom-file-label" for="customFile">Choose file</label>
									</div>

								</form>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

								<!-- Insert Button -->
								<button type="button" class="btn btn-primary" id="add">Add Record</button>
							</div>
						</div>
					</div>
				</div>

				<!-- Edit Records Modal -->
				<!-- Modal -->
				<div class="modal fade" id="editRecords" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Edit Record</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<div class="container-fluid">
									<div class="row text-center">
										<div class="col-md-12 my-3">
											<div id="show_img"></div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">

											<!-- Edit Record Form -->
											<form id="editForm">

												<!-- ID -->
												<input type="hidden" id="edit_record_id">

												<!-- Name -->
												<div class="input-group mb-3">
													<div class="input-group-prepend">
														<span class="input-group-text bg-info text-white" id="basic-addon1"><i class="fas fa-user"></i></span>
													</div>
													<input type="text" class="form-control" id="edit_name" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
												</div>

												<!-- Email -->
												<div class="input-group mb-3">
													<div class="input-group-prepend">
														<span class="input-group-text bg-info text-white" id="basic-addon1"><i class="fas fa-envelope"></i></span>
													</div>
													<input type="text" class="form-control" id="edit_email" placeholder="Email Address">
												</div>

												<!-- Mobile -->
												<div class="input-group mb-3">
													<div class="input-group-prepend">
														<span class="input-group-text bg-info text-white" id="basic-addon1"><i class="fas fa-phone-alt"></i></span>
													</div>
													<input type="text" class="form-control" id="edit_mob" placeholder="Mobile No.">
												</div>

												<!-- Image -->
												<div class="custom-file">
													<input type="file" class="custom-file-input" id="edit_img">
													<label class="custom-file-label" for="customFile">Choose file</label>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

								<!-- Update Button -->
								<button type="button" class="btn btn-primary" id="update">Update Record</button>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row my-4">
			<div class="col-md-12 mx-auto">
				<table class="table table-borderless" id="recordTable" style="width:100%">
					<thead>
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Email</th>
							<th>Mobile</th>
							<th>Image</th>
							<th>Action</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>

	<input type="hidden" value="<?php echo base_url(); ?>" id="base_url">

	<!-- Jquery -->
	<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
	<!-- Popper JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
	<!-- Bootstrap JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<!-- Toastr JS -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
	<!-- Datatables JS -->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.21/b-1.6.3/b-flash-1.6.3/b-html5-1.6.3/b-print-1.6.3/r-2.2.5/datatables.min.js"></script>
	<!-- Sweetalert2 -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
	<!-- Main JS -->
	<script src="<?php echo base_url('/assets/js/main.js') ?>"></script>
</body>

</html>