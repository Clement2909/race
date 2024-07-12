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
	  				<div class="img" style="background-image: url(../sidebar/images/pdp.png);"></div>
	  				<h3>Admin</h3>
	  			</div>
	  		</div>
        <ul class="list-unstyled components mb-5">
          <li class="active">
            <a href="{{ route('admin.dashboard') }}"><span class="fa fa-home mr-3"></span> Home Admin</a>
          </li>
          <li class="active">
            <a href="{{ route('steps.index') }}"><span class="fa fa-home mr-3"></span> Step List</a>
          </li>
          <li class="active">
            <a href="{{ route('ranking.index') }}"><span class="fa fa-trophy mr-3"></span> Ranking per Runner</a>
          </li>
          <li class="active">
            <a href="{{ route('teamRank') }}"><span class="fa fa-trophy mr-3"></span> Ranking per Team(All)</a>
          </li>
          <li>
            <a href="{{ route('admin.logout') }}"><span class="fa fa-sign-out mr-3"></span> Sign Out</a>
          </li>
        </ul>

    	</nav>

        <!-- Page Content  -->
      <div id="content" class="p-4 p-md-5 pt-5">
       <center> <h2 class="mb-4">Step List</h2></center>
       <h1>Step List</h1>

<table border="1">
    <thead>
        <tr>
            <th>Name</th>
            <th>Length</th>
            <th>Number of runner</th>
            <th>Rank</th>
            <th>Result</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($steps as $step)
        <tr>
            <td>{{ $step->name }}</td>
            <td>{{ $step->length }}</td>
            <td>{{ $step->number_runner_foreachteam }}</td>
            <td>{{ $step->rank_step }}</td>
            <td><a href="{{ route('step.showResults', ['id' => $step->id_step]) }}">View Results</a></td>
        </tr>
        @endforeach
    </tbody>
</table>

    <!-- Affichage du message de succès -->
@if(session('success'))
    <div class="alert alert-success" style="color:green">
        {{ session('success') }}
    </div>
@endif
      </div>
		</div>

    <script src="sidebar/js/jquery.min.js"></script>
    <script src="sidebar/js/popper.js"></script>
    <script src="sidebar/js/bootstrap.min.js"></script>
    <script src="sidebar/js/main.js"></script>

</body>