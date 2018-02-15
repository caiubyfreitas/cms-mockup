
<?php
	require_once ("../glb/helpers.php");
	use function Globals\helpers\redirect;

	// Creates session 
	if (version_compare(phpversion(), '5.4.0', '<')) {
		if(session_id() == ''){
			session_start();
		}
	}
	else{
		if (session_status() == PHP_SESSION_NONE){
			session_start();
		}
	}
	
	//Check if user's credential is still valid. if not, redirect to the login page
	if (!isset($_SESSION["USER_ID"])){
		redirect("es_login.html");
	}
	
	// Retrieve information from session variables
	function getUserPicture(){
		if (isset($_SESSION["PICTURE"])){
			echo $_SESSION["PICTURE"];
		}
	}
	function getUserId(){
		if (isset($_SESSION["USER_ID"])){
			echo $_SESSION["USER_ID"];
		}
	}
	function getUserName(){
		if (isset($_SESSION["FULLNAME"])){
			echo $_SESSION["FULLNAME"] . "<br>Administrador(a)";
		}
	}
	
?>

<!DOCTYPE html>
<html lang="en">

<head>

	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Essencial</title>

    <!-- FontAwesome CSS -->
	<link href="../css/font-awesome.min.css" rel="stylesheet">

    <!-- Bootstrap Reboot CSS -->
    <link href="../css/bootstrap-reboot.min.css" rel="stylesheet">
	
    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Grid CSS -->
    <link href="../css/bootstrap-grid.min.css" rel="stylesheet">
	
	<!-- Custom styles for this template-->
	<link href="../css/es_dashboard.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div class="page">
	
		<!-- Main Navbar-->
		<header class="header"> 
			<nav class="navbar navbar-toggleable-md navbar-light bg-faded">
				<div class="container-fluid">
					<div class="navbar-holder d-flex align-items-center justify-content-between" >
						<!-- Navbar Header-->
						<div class="navbar-header">
							<!-- Navbar Brand -->
							<div class="brand-text">
								<span>Essencial</span><strong>Content Management System - Dashboard</strong><BR><small><span id="fldToday"></small></small>
							</div>
						</div>
						<!-- Navbar Menu -->
						<ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
							<!-- Logout -->
							<li class="nav-item"><a href="es_disconnect.php" class="nav-link logout">Desconectar<i class="fa fa-sign-out"></i></a></li>
						</ul>				  
					</div>
				</div>
			</nav>
		</header> 

		<div class="page-content d-flex align-items-stretch"> 

			<!-- Side Navbar -->
			<nav class="side-navbar">

				<!-- Sidebar Header-->	
				<div id="sidebar-profile">
					<img src="<?php getUserPicture(); ?>" alt="..." class="img-fluid rounded-circle">
					<div style="float: right;">
						<a href="#" id="G01S01-lnk" data-id="<?php getUserId(); ?>"><?php getUserName(); ?></a>
					</div>
				</div>
				
				<!-- Sidebar Navidation Menus-->
				<span class="heading">Principal</span>
				<ul class="list-unstyled">
					<li><a href="#" id="lnkProspects"> <i id="icoProspects" class="fa fa-flag"></i>Prospectos </a></li>
					<!-- <li><a href="charts.html"> <i class="fa fa-address-card-o"></i>Clientes </a></li> -->
				</ul>
				<!--
				<span class="heading">Processos</span>
				<ul class="list-unstyled">
					<li> <a href="#"> <i class="icon-flask"></i>Demo </a></li>
					<li><a href="#exampledropdownDropdown" aria-expanded="false" data-toggle="collapse"> <i class="icon-interface-windows"></i>Example dropdown </a>
						<ul id="exampledropdownDropdown" class="collapse list-unstyled ">
							<li><a href="#">Page</a></li>
							<li><a href="#">Page</a></li>
							<li><a href="#">Page</a></li>
						</ul>
					</li>
				</ul>
				-->
			</nav>

			<div class="content-inner">

				<!-- Page Header
				<header class="page-header shadow-nohover">
					<div class="container-fluid">
						<h4 class="no-margin-bottom">Dashboard</h4>
					</div>
				</header>-->

				<!-- Page Content -->
				<div id="page-content">

					<section id="Section-Admin" class="container">
					
						<!--
						*
						* Container: G01S01 
						* Holds administrative user profile's viewable and editable data and is composed by
						* the following child-elements:
						* G01S01-Form		> container for editable fields
						* G01S01-fldFullName> field
						* G01S01-fldEmail	> field
						* G01S01-cmdClose	> go back to dashboard
						* G01S01-cmdSave	> save record command
						*
						-->
						<div id="G01S01" class="collapse">
							<div class="card shadow-nohover" style="width: 95%;">
								<div class="card-block">
									<div class="row">
										<div class="col">
											<h4 class="card-title"><span id="title">Alterar Perfil</span></h4>
										</div>
									</div>
									<div class="card-text">
										<form method="post" id="G01S01-Form">
											<div class="form-group alert alert-danger collapse" id="G01S01-Alerts"><ul></ul></div>
											<div class="form-group row">
												<label for="example-text-input" class="col-2 col-form-label">Nome completo</label>
												<div class="col-10">
													<input class="form-control" type="text" value="" id="G01S01-fldFullName" maxlength=30>
												</div>
											</div>
											<div class="form-group row">
												<label for="example-text-input" class="col-2 col-form-label">Nome de usuário</label>
												<div class="col-10">
													<input class="form-control" type="text" value="" id="G01S01-fldName" maxlength=20>
												</div>
											</div>
											<div class="form-group row">
												<label for="example-text-input" class="col-2 col-form-label">E-mail</label>
												<div class="col-10">
													<input class="form-control" type="email" value="" id="G01S01-fldEmail" maxlength=60>
												</div>
											</div>
											<div class="form-group row">
												<label for="example-text-input" class="col-2 col-form-label">Password</label>
												<div class="col-10">
													<input class="form-control" type="password" value="" id="G01S01-fldPassword" maxlength=20>
												</div>
											</div>
										</form>
									</div>
									<div id="G01S01-Commands" class="row command_header">
										<div class="col">
											<a id="G01S01-cmdClose" href="javascript: $('#G01S01-cmdClose').trigger('click');" class="btn btn-secondary table-button ">Fechar</a>
											<a id="G01S01-cmdSave" data-id="<?php echo $_SESSION["USER_ID"]; ?>" href="javascript: $('#G01S01-cmdSave').trigger('click');" class="btn btn-primary table-button ">Salvar</a>
										</div>
									</div>
								</div>
							</div>										
						</div>
											
					</section>
				
					<!-- BEGIN Prospects -->
					<section id="Section-Prospect" class="container">					
					
						<!-- 
						*
						* BEGIN Delete
						*
						For visibility control purposes, this section is composed of five parts. These parts are dynamically put 
						together as result of navigation events or data availability, and are named as follows:						
							- ProspectsEdit-DataView	: shows related data fields
							- ProspectsEdit-Commands	: show actions reflected upon record
						-->
						<div id="ProspectsDelete" class="modal fade" data-animation="false">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title">Confirma?</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<p>Os dados selecionados serão apagadas definitivamente.</p>
									</div>
									<div class="modal-footer">
										<button id="ProspectsDelete-Confirmation" type="button" class="btn btn-primary" data-id="" data-eventSource="">Continuar</button>
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
									</div>
								</div>
							</div>
						</div>					
						<!-- END Delete -->

						<!-- 
						*
						* BEGIN Edit
						*
						For visibility control purposes, this section is composed of five parts. These parts are dynamically put 
						together as result of navigation events or data availability, and are named as follows:						
							- ProspectsEdit-DataView	: shows related data fields
							- ProspectsEdit-Commands	: show actions reflected upon record
						-->
						<div id="ProspectsEdit">
							<div class="card shadow-nohover" style="width: 95%;">
								<div class="card-block">
									<div class="row">
										<div class="col">
											<h4 class="card-title"><span id="title">Prospecto</span></h4>
										</div>
									</div>
									<div class="card-text" id="ProspectsEdit-DataView">
										<form method="post" id="frmProspectEdit">
											<div class="form-group row">
												<label for="example-text-input" class="col-2 col-form-label">Nome completo</label>
												<div class="col-10">
													<input class="form-control" type="text" value="" id="fldFullName">
												</div>
											</div>
											<div class="form-group row">
												<label for="example-text-input" class="col-2 col-form-label">E-mail</label>
												<div class="col-10">
													<input class="form-control" type="email" value="" id="fldEmail">
												</div>
											</div>
										</form>
									</div>
									<div id="ProspectsEdit-Commands" class="row command_header">
										<div class="col">
											<a href="javascript: $('#lnkProspects').trigger('click');" class="btn btn-primary table-button ">Voltar</a>
										</div>
									</div>
								</div>
							</div>										
						</div>
						<!-- END Edit -->

						<!-- 
						*
						* BEGIN View 
						*
						For visibility control purposes, this section is composed of five parts. These parts are dynamically put 
						together as result of navigation events or data availability, and are named as follows:
							- ProspectsView-Records		: shows the total of records were retrieved from database
							- ProspectsView-DataView	: shows the entire data view area
							- ProspectsView-TableView	: shows records as lines of table 
							- ProspectsView-Message		: shows warning, information or error messages
							- ProspectsView-Pagination	: shows pagination controls 	
						/-->
						<div id="ProspectsView">
							<div class="card shadow-nohover" style="width: 95%;">
								<div class="card-block">
									<div class="row">
										<div class="col">
											<h4 class="card-title">Prospectos <span id="ProspectsView-Records" class="badge badge-info"></span> </h4>
										</div>
										<div class="col text-right">
											<a href="#" class="btn btn-primary table-button collapse">Novo cadastro...</a>
										</div>
									</div>
									<div class="card-text" id="ProspectsView-DataView">
										<table id="ProspectsView-DataTable" class="table table-bordered table-hover table-sm">
											<thead>
												<tr class="table_header">
													<th style="width: 40px">#</th>
													<th>Nome completo</th>
													<th>E-mail</th>
													<th>Ações</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
										</table>
										<div id="ProspectsView-Message" class="alert alert-danger" role="alert"></div>
									</div>
									<div class="row">
										<div class="col" id="ProspectsView-Pagination">
											<nav aria-label="Page navigation">
											  <ul class="pagination">
											  </ul>
											</nav>
										</div>
									</div>
								</div>
							</div>				
						</div>
						<!-- END View-->
						
					</section>
					<!-- END Prospects -->
					
					<section id="MESSAGEBOX" class="collapse modal fade" data-animation="false">
						<div class="modal-dialog" role="alert">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title">Notificação</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<p id="MESSAGEBOX-text"></p>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
								</div>
							</div>
						</div>
					</section>
				
				</div>
				
				<!-- Page Footer-->
				<footer class="main-footer">
					<div class="container-fluid">
						<div class="row">
							<div class="col-sm-6">
								<p>Your company &copy; 2017-2019</p>
							</div>
							<div class="col-sm-6 text-right">
								<p>Design by <a href="https://bootstrapious.com/admin-templates" class="external">Bootstrapious</a></p>
								<!-- Please do not remove the backlink to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
							</div>
						</div>
					</div>
				</footer>

			</div>
		</div>
		
	</div>
    <!-- /#wrapper -->

	<!-- JQuery Core -->
    <script src="../js/jquery-3.2.1.min.js"></script>

    <!-- Bootstrap 3rd party lib -->
    <script src="../js/tether.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../js/bootstrap.min.js"></script>	

    <!-- Core Controller -->
    <script src="../glb/controller.js"></script>

    <!-- Views -->
    <script src="view/es_admin.js"></script>
    <script src="view/es_prospects.js"></script>
	
    <!-- Dashboard specifics -->
    <script src="../js/es_dashboard.js"></script>
	
	
</body>

</html>