<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Step List</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../sidebar/css/style.css">
    <link rel="icon" href="{{ asset('img/skyscraper.png') }}">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
            text-align: center;
        }
        .step-header {
            font-weight: bold;
            margin-top: 20px;
            font-size: 18px;
        }
        .runner-table {
            margin-top: 10px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="wrapper d-flex align-items-stretch">
        <nav id="sidebar">
            <div class="custom-menu">
                <button type="button" id="sidebarCollapse" class="btn btn-primary"></button>
            </div>
            <div class="img bg-wrap text-center py-4" style="background-image: url(../sidebar/images/bg_1.jpg);">
                <div class="user-logo">
                    <div class="img" style="background-image: url(../sidebar/images/pdp.png);"></div>
                    <h3>Team</h3>
                </div>
            </div>
            <ul class="list-unstyled components mb-5">
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

        <div id="content" class="p-4 p-md-5 pt-5">
            <center><h2 class="mb-4">Step List</h2></center>
            <div>
                @foreach ($steps as $step)
                    <div class="step-header">
                        {{ $step->name }} ({{ $step->length }} km) - Number of runners required: {{ $step->number_runner_foreachteam }}
                    </div>
                    <table>
                            <tr>
                                <th style="color:black">Runner Name</th>
                                <th style="color:black">Chrono</th>
                            </tr>
                        <tbody>
                            @foreach ($step->runners as $runner)
                                <tr>
                                    <td>{{ $runner->name }}</td>
                                    <td>{{ $runner->chrono }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if ($step->user_runners_count < $step->number_runner_foreachteam)
    <!-- Lien vers la page d'affectation des coureurs pour cette étape -->
    <a href="{{ route('selectRunners', ['step_id' => $step->id_step, 'remaining_runners' => $step->number_runner_foreachteam - $step->user_runners_count]) }}">Affecting runners</a>
@endif
                @endforeach
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

