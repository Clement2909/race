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
            <a href="{{ route('assignCategoriesAutomatically') }}"><span class="fa fa-support mr-3"></span> Category generation</a>
          </li>
          <li class="active">
            <a href="{{ route('import.importTwo') }}"><span class="fa fa-download mr-3"></span> Import Step + Result</a>
          </li>
          <li class="active">
            <a href="{{ route('import.point') }}"><span class="fa fa-download mr-3"></span> Import Point</a>
          </li>
          <li>
            <a href="{{ route('admin.logout') }}"><span class="fa fa-sign-out mr-3"></span> Sign Out</a>
          </li>
        </ul>

    	</nav>

        <!-- Page Content  -->
      <div id="content" class="p-4 p-md-5 pt-5">
       <center> <h2 class="mb-4">Import Step + Result</h2></center>

       @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <form action="{{ route('importTwoCsv') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="step_csv">Step CSV</label>
            <input type="file" class="form-control-file" id="step_csv" name="csv_file_steps" required>
        </div>
        <div class="form-group">
            <label for="result_csv">Result CSV</label>
            <input type="file" class="form-control-file" id="result_csv" name="csv_file_results" required>
        </div>
        <button type="submit" class="btn btn-primary">Import</button>
    </form>
      </div>
		</div>


    <script src="sidebar/js/jquery.min.js"></script>
    <script src="sidebar/js/popper.js"></script>
    <script src="sidebar/js/bootstrap.min.js"></script>
    <script src="sidebar/js/main.js"></script>

</body>
