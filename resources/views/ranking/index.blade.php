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
       <center> <h2 class="mb-4">Ranking per Runner per Step with points</h2></center>
       <!-- Navigation par étapes -->
       <nav aria-label="Step navigation">
            <ul class="pagination justify-content-center">
                @foreach ($steps as $step)
                <li class="page-item {{ $step->id_step == $currentStep ? 'active' : '' }}">
                    <a class="page-link" href="{{ route('ranking.index', ['step' => $step->id_step]) }}">{{ $step->name }}</a>
                </li>
                @endforeach
            </ul>
        </nav>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Step Name</th>
                    <th>Runner ID</th>
                    <th>Participant Name</th>
                    <th>Participant Team</th>
                    <th>Participant Rank</th>
                    <th>Time start</th>
                    <th>Date start</th>
                    <th>Time  end</th>
                    <th>Participant Chrono </th>
                    <th>Total Penalty </th>
                    <th>Chrono Final</th>
                    <th>Points Awarded</th>
                    <th> New end time</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($stepRanks as $stepRank)
                <tr>
                    <td>{{ $stepRank->step_name }}</td>
                    <td>{{ $stepRank->id_runner }}</td>
                    <td>{{ $stepRank->participant_name }}</td>
                    <td>{{ $stepRank->participant_team }}</td>
                    <td>{{ $stepRank->participant_rank }}</td>
                    <td>{{ $stepRank->start_time }}</td>
                    <td>{{ $stepRank->start_date }}</td>
                    <td>{{ $stepRank->end_time }}</td>
                    <td>{{ $stepRank->chrono }}</td>
                    <td>{{ $stepRank->total_penalty }}</td>
                    <td>{{ $stepRank->chrono_final }}</td>
                    <td>{{ $stepRank->points_awarded }}</td>
                    <td>
                    <form action="{{ route('ranking.update', ['step' => $currentStep]) }}" method="POST" id="update-form-{{ $stepRank->id_runner }}">
                        @csrf
                        @method('PUT')
                        <input type="datetime-local" step="1" name="end_times[{{ $stepRank->id_runner }}]" value="{{ \Carbon\Carbon::parse($stepRank->end_time)->format('Y-m-d\TH:i:s') }}">
                        <input type="hidden" name="runner_id" value="{{ $stepRank->id_runner }}">
                    </form>
                </td>
                <td>
                    <button type="submit" form="update-form-{{ $stepRank->id_runner }}">Save</button>
                </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        {{ $stepRanks->appends(['step' => $currentStep])->links() }}
    </div>

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
</html>