<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluation Juin 2024</title>
    <meta name="description" content="Site  make by ETU001642">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="../../sidebar/css/style.css">
    <link rel="icon" href="{{ asset('img/skyscraper.png') }}">
</head>
<body>				
<div class="wrapper d-flex align-items-stretch">
			<nav id="sidebar">
				<div class="custom-menu">
					<button type="button" id="sidebarCollapse" class="btn btn-primary">
	        </button>
        </div>
	  		<div class="img bg-wrap text-center py-4" style="background-image: url(../../sidebar/images/bg_1.jpg);">
	  			<div class="user-logo">
	  				<div class="img" style="background-image: url(../../sidebar/images/pdp.png);"></div>
	  				<h3>Team</h3>
	  			</div>
	  		</div>
        <ul class="list-unstyled components mb-5">
        <!--  <li class="active">
            <a href="{{ route('team.dashboard') }}"><span class="fa fa-home mr-3"></span> Home Team</a>
          </li> -->
          <li class="active">
            <a href="{{ route('steps.indexteam') }}"><span class="fa fa-home mr-3"></span> Step List</a>
          </li>
          <li class="active">
            <a href="{{ route('ranking.indext') }}"><span class="fa fa-trophy mr-3"></span> Ranking per Runner</a>
          </li>
          <li class="active">
            <a href="{{ route('teamRankt') }}"><span class="fa fa-trophy mr-3"></span> Ranking per Team(All)</a>
          </li>
          <li>
            <a href="{{ route('team.logout') }}"><span class="fa fa-sign-out mr-3"></span> Sign Out</a>
          </li>
        </ul>

    	</nav>

        <!-- Page Content  -->
      <div id="content" class="p-4 p-md-5 pt-5">
       <center> <h2 class="mb-4">Nombre de coureurs restant a selectionner : {{ $rest  }}</h2></center>

       
    <form action="{{ route('storeSelectedRunners', ['step_id' => $step->id_step, 'rest'=>$rest]) }}" method="POST">
        @csrf
        <ul>
            @foreach ($teamRunners as $runner)
                <p>
                    <label>
                        <input type="checkbox" name="selectedRunners[]" value="{{$runner->id_runner}}">
                        {{ $runner->name }}

                    </label></p>
            @endforeach
        </ul>
        <button type="submit">Valider la sélection</button>
    </form>
    @if ($errors->any())
    <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
              <p style="color: red;">  {{ $error }}</p>
            @endforeach
 @endif



    <!-- Affichage du message de succès -->
@if(session('success'))
    <div class="alert alert-success" style="color:green">
        {{ session('success') }}
    </div>
@endif
      </div>
		</div>

    <script src="../sidebar/js/jquery.min.js"></script>
    <script src="../sidebar/js/popper.js"></script>
    <script src="../sidebar/js/bootstrap.min.js"></script>
    <script src="../sidebar/js/main.js"></script>

</body>