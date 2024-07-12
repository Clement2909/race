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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <style>
        .highlight {
            background-color: grey; /* Couleur de fond pour les lignes avec des rangs égaux */
            color: white; /* Garder le texte noir pour la lisibilité */
        }
    </style>
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
            <a href="{{ route('teamRank') }}"><span class="fa fa-trophy mr-3"></span> Ranking per Team(All)</a>
          </li>
          <li class="active">
            <a href="{{ route('rankMale') }}"><span class="fa fa-trophy mr-3"></span> Ranking per Team (Male)</a>
          </li>
          <li class="active">
            <a href="{{ route('rankFemale') }}"><span class="fa fa-trophy mr-3"></span> Ranking per Team (Female)</a>
          </li>
          <li class="active">
            <a href="{{ route('rankJunior') }}"><span class="fa fa-trophy mr-3"></span> Ranking per Team (Junior)</a>
          </li>
          <li class="active">
            <a href="{{ route('rankSenior') }}"><span class="fa fa-trophy mr-3"></span> Ranking per Team (Senior)</a>
          </li>
          <li>
            <a href="{{ route('admin.logout') }}"><span class="fa fa-sign-out mr-3"></span> Sign Out</a>
          </li>
        </ul>

    	</nav>

        <!-- Page Content  -->
      <div id="content" class="p-4 p-md-5 pt-5">
       <center> <h2 class="mb-4">Team Junior Ranking</h2></center>
       <table border="1">
    <thead>
        <tr>
            <th>Team Rank</th>
            <th>Team Name</th>
            <th>Total Points</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @php
            $highlightRows = []; // Tableau pour garder les indices des lignes à colorier
            $totalRanks = count($teamRanks);

            // Première passe : Identifier les lignes à colorier
            for ($i = 0; $i < $totalRanks; $i++) {
                if ($i > 0 && $teamRanks[$i]->team_rank == $teamRanks[$i - 1]->team_rank) {
                    $highlightRows[$i] = true; // Marquer la ligne actuelle
                    $highlightRows[$i - 1] = true; // Marquer la ligne précédente
                }
            }
        @endphp

        <!-- Deuxième passe : Appliquer le style aux lignes marquées -->
        @foreach ($teamRanks as $index => $teamRank)
            <tr class="{{ $highlightRows[$index] ?? false ? 'highlight' : '' }}">
                <td class="{{ $highlightRows[$index] ?? false ? 'highlight' : '' }}">{{ $teamRank->team_rank }}</td>
                <td class="{{ $highlightRows[$index] ?? false ? 'highlight' : '' }}">{{ $teamRank->team_name }}</td>
                <td class="{{ $highlightRows[$index] ?? false ? 'highlight' : '' }}">{{ $teamRank->total_points }}</td>
                <td class="{{ $highlightRows[$index] ?? false ? 'highlight' : '' }}">
                    @if($teamRank->team_rank == 1)
                        <a href="{{ route('downloadCertificate', ['team' => $teamRank->team_name, 'category' => 'Female Category']) }}">Download PDF</a>  
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

    <h3>Graphique camembert</h3>
    <div style="width: 50%; margin: auto;">
        <canvas id="teamRankChart"></canvas>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Récupération des données depuis la variable Blade
            const teamRanks = @json($teamRanks);

            // Extraction des noms d'équipes et des points
            const teamNames = teamRanks.map(team => team.team_name);
            const teamPoints = teamRanks.map(team => team.total_points);

            const ctx = document.getElementById('teamRankChart').getContext('2d');
            const chart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: teamNames,
                    datasets: [{
                        label: 'Total Points',
                        data: teamPoints,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(211, 211, 211, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(211, 211, 211, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    return `${context.label}: ${context.raw} points`;
                                }
                            }
                        },
                        datalabels: {
                          formatter: (value, context) => {
                                return `${value} points`;
                            },
                            color: '#000', // Change color to black
                            font: {
                                size: 14, // Increase font size
                                weight: 'bold'
                            }
                        }
                    }
                },
                plugins: [ChartDataLabels]
            });
        });
    </script>

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