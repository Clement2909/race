<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluation Juin 2024</title>
    <meta name="description" content="Site make by ETU001642">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../sidebar/css/style.css">
    <link rel="icon" href="{{ asset('img/skyscraper.png') }}">
    <style>
        .delete-btn {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: red;
            color: white;
            border: none;
            cursor: pointer;
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

    <!-- Page Content -->
    <div id="content" class="p-4 p-md-5 pt-5">
        <center><h2 class="mb-4">Penalty List</h2></center>
        <!-- Bouton pour ajouter une pénalité -->
<center><p><form action="{{ route('penalties.create') }}" method="GET" style="display: inline;">
    @csrf
    <button type="submit" class="add-penalty-btn">Add Penalty</button>
</form></p></center>
    </br>
    </br>

        <table class="table table-bordered" border="1">
            <thead>
                <tr>
                    <th>Étape</th>
                    <th>Équipe</th>
                    <th>Temps de Pénalité</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($penalties as $penalty)
                <tr>
                    <td>{{ $penalty->step->name }}</td>
                    <td>{{ $penalty->user->name }}</td>
                    <td>{{ $penalty->val }}</td>
                    <td>
                        <form action="{{ route('penalties.destroy', $penalty->id) }}" method="POST" onsubmit="return confirmDelete(event, '{{ $penalty->step->name }}', '{{ $penalty->user->name }}', '{{ $penalty->val }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-btn">-</button>
                        </form>
                    </td>
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
<script>
    function confirmDelete(event, stepName, teamName, penaltyTime) {
        event.preventDefault();
        const confirmation = confirm(`Are you sure you want to delete the penalty for step "${stepName}", team "${teamName}", with a penalty time of "${penaltyTime}"?`);
        if (confirmation) {
            event.target.submit();
        }
    }
</script>
</body>
</html>
