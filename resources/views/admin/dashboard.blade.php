<!-- resources/views/admin/dashboard.blade.php -->
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
	  				<h3>{{$userName}}</h3>
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
            <a href="{{ route('ranking.index') }}"><span class="fa fa-trophy mr-3"></span> Ranking per Runner </a>
          </li>
          <li class="active">
            <a href="{{ route('teamRank') }}"><span class="fa fa-trophy mr-3"></span> Ranking per Team (All)</a>
          </li>
          <li class="active">
            <a href="{{ route('assignCategoriesAutomatically') }}"><span class="fa fa-support mr-3"></span> Category generation</a>
          </li>
          <li class="active">
            <a href="{{ route('import.importTwo') }}"><span class="fa fa-download mr-3"></span> Import Step + Result</a>
          </li>
          <li class="active">
            <a href="{{ route('import.point') }}"><span class="fa fa-download mr-3"></span> Import Point</a>
          </li>
          <li>
            <a href="{{route('penalties.show')}}"><span class="fa fa-cog mr-3"></span>Penalty</a>
          </li>
          <li>
            <a href="{{ route('admin.clearData') }}" id="resetDatabase"><span class="fa fa-cog mr-3"></span>Reinitialize Base</a>
          </li>
          <li>
            <a href="{{ route('admin.logout') }}"><span class="fa fa-sign-out mr-3"></span> Sign Out</a>
          </li>
        </ul>

    	</nav>

        <!-- Page Content  -->
      <div id="content" class="p-4 p-md-5 pt-5">
       <center> <h2 class="mb-4">Users</h2></center>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>ID role </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->id_role }}</td>
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
    <!-- Ajoutez un script pour la confirmation -->
<script>
    $(document).ready(function() {
        // Gérer le clic sur le lien de réinitialisation de la base de données
        $('#resetDatabase').click(function(e) {
            e.preventDefault();

            // Afficher une boîte de dialogue de confirmation
            if (confirm("Voulez-vous vraiment réinitialiser la base de données?")) {
                // Si l'utilisateur clique sur OK, envoyer une requête AJAX
                $.ajax({
                    url: '{{ route("admin.clearData") }}', // URL de la route Laravel pour réinitialiser la base de données
                    type: 'GET', // Méthode HTTP (GET, POST, etc.)
                    success: function(response) {
                        // Afficher un message de succès après réinitialisation
                        alert('Base de données réinitialisée avec succès.');
                        // Recharger la page pour mettre à jour les données affichées
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        // Gérer les erreurs éventuelles ici
                        console.error(error);
                        alert('Une erreur s\'est produite lors de la réinitialisation de la base de données.');
                    }
                });
            }
        });
    });
</script>

    <script src="sidebar/js/jquery.min.js"></script>
    <script src="sidebar/js/popper.js"></script>
    <script src="sidebar/js/bootstrap.min.js"></script>
    <script src="sidebar/js/main.js"></script>

</body>