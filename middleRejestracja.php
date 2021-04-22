<div class="container">
<div class="row my-1">
<?php
			if (isset($_SESSION['udanarejestracja']))
			{
				echo '<div>'.$_SESSION['udanarejestracja'].'</div>';
				unset($_SESSION['udanarejestracja']);
			}
?>
    <h2 class="text-center">Rejestracja użytkownika</h2>
<div>
<div class="row my-1">
<form method="POST">
    <div class="mb-3">
        <label for="login" class="form-label">Nazwa użytkownika</label>
        <input type="text" class="form-control" id="login" name="login" required>
        <?php
			if (isset($_SESSION['e_nick']))
			{
				echo '<div>'.$_SESSION['e_nick'].'</div>';
				unset($_SESSION['e_nick']);
			}
		?>
    </div>
    <div class="mb-3">
        <label for="nazwisko" class="form-label">Hasło</label>
        <input type="text" class="form-control" id="nazwisko" name="pass" required>
        <?php
			if (isset($_SESSION['e_haslo']))
			{
				echo '<div>'.$_SESSION['e_haslo'].'</div>';
				unset($_SESSION['e_haslo']);
			}
		?>	
    </div>
    <div class="mb-3">
        <label for="nazwisko" class="form-label">Powtórz hasło</label>
        <input type="text" class="form-control" id="nazwisko" name="passRepeat" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">E-mail</label>
        <input type="email" class="form-control" id="email" placeholder="name@example.com" name="email" required>
        <?php
			if (isset($_SESSION['e_email']))
			{
				echo '<div>'.$_SESSION['e_email'].'</div>';
				unset($_SESSION['e_email']);
			}
		?>
    </div>
    <button type="sumbit" class="btn btn-success">Zarejestruj</button>
</form>
</div>
</div>