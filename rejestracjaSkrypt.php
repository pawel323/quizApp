<?php
session_start();
if (isset($_POST['login'], $_POST['pass'], $_POST['passRepeat'], $_POST['email']) && $_POST['pass'] == $_POST['passRepeat'])
{
    
    $wszystko_OK=true;
    
    
    $nick = trim($_POST['login']);
    $nick = htmlentities($nick, ENT_QUOTES, "UTF-8");
    
    if (strlen($nick)<5)
    {
        $wszystko_OK=false;
        $_SESSION['e_nick']="Nick musi posiadać minimum 5 znaków!";
    }
    
    if (ctype_alnum($nick)==false)
    {
        $wszystko_OK=false;
        $_SESSION['e_nick']="Nick może składać się tylko z liter i cyfr (bez polskich znaków)";
    }
    
   
    $email = trim($_POST['email']);
    $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
    
    if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
    {
        $wszystko_OK=false;
        $_SESSION['e_email']="Podaj poprawny adres e-mail!";
    }
    
    
    $haslo1 = trim($_POST['pass']);
    $nick = htmlentities($nick, ENT_QUOTES, "UTF-8");
    
    if ((strlen($haslo1)<8) || (strlen($haslo1)>20))
    {
        $wszystko_OK=false;
        $_SESSION['e_haslo']="Hasło musi posiadać od 8 do 20 znaków!";
    }
    
   
    $haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);
    
    require_once "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);
    
    try 
    {
        $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
        if ($polaczenie->connect_errno!=0)
        {
            throw new Exception(mysqli_connect_errno());
        }
        else
        {
            
            $checkEmail = $polaczenie->query(sprintf("SELECT id FROM uzytkownicy WHERE email='%s'"),mysqli_real_escape_string($polaczenie,$emailB));
            
            if (!$checkEmail) throw new Exception($polaczenie->error);
            
            $ile_takich_maili = $checkEmail->num_rows;
            if($ile_takich_maili>0)
            {
                $wszystko_OK=false;
                $_SESSION['e_email']="Istnieje już konto przypisane do tego adresu e-mail!";
            }		

            
            $checkNick = $polaczenie->query(sprintf("SELECT id FROM uzytkownicy WHERE user='%s'"),mysqli_real_escape_string($polaczenie, $nick));
            
            if (!$checkNick) throw new Exception($polaczenie->error);
            
            $ile_takich_nickow = $checkNick->num_rows;
            if($ile_takich_nickow>0)
            {
                $wszystko_OK=false;
                $_SESSION['e_nick']="Istnieje już gracz o takim nicku! Wybierz inny.";
            }
            
            if ($wszystko_OK==true)
            {
                
                
                if ($polaczenie->query(sprintf("INSERT INTO uzytkownicy VALUES (NULL, '%s', '$haslo_hash', '%s')"),mysqli_real_escape_string($polaczenie,$nick,$emailB)))
                {
                    $_SESSION['udanarejestracja']="Rejestracja przebiegła pomyślnie";
                    header('Location: witamy.php');
                }
                else
                {
                    throw new Exception($polaczenie->error);
                }
                
            }
            
            $polaczenie->close();
        }
        
    }
    catch(Exception $e)
    {
        echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
    }
    
}
?>