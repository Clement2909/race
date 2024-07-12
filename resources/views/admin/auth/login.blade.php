<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Admin Login</title>
    <link rel="stylesheet" href="../../css/login.css">
      <!-- Favicons -->
    <link href="../../img/skyscraper.png" rel="icon">
  </head>
  <body>
    <div class="bg-img">
      <div class="content">
        <header>Login Admin</header>
                @if (session('error'))
            <div class="alert alert-danger" style="color:red">
                {{ session('error') }}
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-danger" style="color:green">
                {{ session('success') }}
            </div>
        @endif
        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf
          <div class="field">
            <span class="fa fa-user"></span>
            <input type="login" name="login" value="{{ old('login') }}" required autofocus>
          </div>
          <div class="field space">
            <span class="fa fa-lock"></span>
            <input type="password" class="pass-key" name="password" required>
            <span class="show">SHOW</span>
          </div>
          <div class="pass">
          </div>
          <div class="field">
            <input type="submit" value="LOGIN">
          </div>
        </form>
        <div class="login"></div>
        <div class="links">
          <div class="facebook">
            <i class="fab fa-facebook-f"><span>Facebook</span></i>
          </div>
          <div class="instagram">
            <i class="fab fa-instagram"><span>Instagram</span></i>
          </div>
        </div>
      </div>
    </div>

    <script>
      const pass_field = document.querySelector('.pass-key');
      const showBtn = document.querySelector('.show');
      showBtn.addEventListener('click', function(){
       if(pass_field.type === "password"){
         pass_field.type = "text";
         showBtn.textContent = "HIDE";
         showBtn.style.color = "#3498db";
       }else{
         pass_field.type = "password";
         showBtn.textContent = "SHOW";
         showBtn.style.color = "#222";
       }
      });
    </script>

  </body>
</html>
