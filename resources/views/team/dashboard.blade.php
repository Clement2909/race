<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluation Juin 2024</title>
    <meta name="description" content="Site  make by ETU001642">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="../sidebar/css/style.css">
    <link rel="icon" href="{{ asset('img/skyscraper.png') }}">
</head>
<body>				
<div class="wrapper d-flex align-items-stretch">
			<nav id="sidebar">
				<div class="custom-menu">
					<button type="button" id="sidebarCollapse" class="btn btn-primary">
	        </button>
        </div>
	  		<div class="img bg-wrap text-center py-4" style="background-image: url(../sidebar/images/bg_1.jpg);">
	  			<div class="user-logo">
	  				<div class="img" style="background-image: url(../sidebar/images/pdp1.png);"></div>
	  				<h3>{{ $userName }}</h3>
	  			</div>
	  		</div>
        <ul class="list-unstyled components mb-5">
          <li class="active">
            <a href="{{ route('team.dashboard') }}"><span class="fa fa-home mr-3"></span>Team Home</a>
          </li>
          <li class="active">
            <a href="{{ route('steps.indexteam') }}"><span class="fa fa-home mr-3"></span>Step List</a>
          </li>
          <li class="active">
            <a href="{{ route('ranking.indext') }}"><span class="fa fa-trophy mr-3"></span> Ranking per Runner</a>
          </li>
          <li class="active">
            <a href="{{ route('teamRankt') }}"><span class="fa fa-trophy mr-3"></span> Ranking per Team (All)</a>
          </li>
        <!--   <li>
              <a href="#"><span class="fa fa-download mr-3 notif"><small class="d-flex align-items-center justify-content-center">5</small></span> Download</a>
          </li>
         <li>
            <a href="#"><span class="fa fa-gift mr-3"></span> Details</a>
          </li>
          <li>
            <a href="#"><span class="fa fa-trophy mr-3"></span> Top Review</a>
          </li>
          <li>
            <a href="#"><span class="fa fa-support mr-3"></span> Support</a>
          </li>
-->       
          <li>
            <a href="{{ route('team.logout') }}"><span class="fa fa-sign-out mr-3"></span> Sign Out</a>
          </li>
        </ul>

    	</nav>
      
        <!-- Page Content  -->
      <div id="content" class="p-4 p-md-5 pt-5">
        <h2 class="mb-4">Acceuil Team</h2>
    </div>

      </div>
		</div>
    <script src="sidebar/js/jquery.min.js"></script>
    <script src="sidebar/js/popper.js"></script>
    <script src="sidebar/js/bootstrap.min.js"></script>
    <script src="sidebar/js/main.js"></script>

</body>