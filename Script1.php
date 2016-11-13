<?php
require_once "vendor/autoload.php";
require_once "bootstrap.php";

if(empty($_POST["txtImie"]) && empty($_POST["txtNazwisko"]) && empty($_POST["numPesel"]) && empty($_POST["txtFirma"]))
{
  print("<p>Nie wypełniono wszystkich danych.</p>");
}
if(!is_numeric($_POST["numPesel"]))
{
  die("<p>Pesel nie jest liczbą.</p>");
}
else
{
  $imie = $_POST["txtImie"];
  $nazwisko = $_POST["txtNazwisko"];
  $pesel = $_POST["numPesel"];
  $firma = $_POST["txtFirma"];
  $sala = $_POST["selSala"];

  if(($entityManager->find('Uzytkownik',$pesel))===null)
  {
    print("<p>Naukowca nie ma w bazie...</p>");
    print("<p>Następuje dodanie naukowca...</p>");

    $uzytkownik = new Uzytkownik();
    $uzytkownik->setPesel($pesel);
    $uzytkownik->setImie($imie);
    $uzytkownik->setNazwisko($nazwisko);
    $uzytkownik->setFirma($Firma);
    $entityManager->persist($uzytkownik);
    $entityManager->flush();
  }

    print("<p>Dodanie zdarzenia do bazy...</p>");
    $zdarzenie = new Zdarzenia();
    $zdarzenie->setNrSali($sala);
    $zdarzenie->setNaukowiec($entityManager->find('Uzytkownik',$pesel));
    $entityManager->find('Uzytkownik',$pesel)->addZdarzenia($zdarzenie);
    $entityManager->persist($zdarzenie);
    $entityManager->flush();




    $user= $entityManager->find('Uzytkownik',$pesel);

    echo '<p>Zdarzenia związane z naukowcem:<strong> '.$user->getPesel().' '.$user->getImie().' '.$user->getNazwisko().' '.$user->getFirma().'</strong></p>';
    $ZdarzeniaAll = $entityManager->getRepository('Zdarzenia');
    $wszystkie = $ZdarzeniaAll->findAll();

    echo "<p>Wszystkie zdarzenia:</p>";
    foreach ($wszystkie as $zdarz)
    {
        if($user->getPesel() == $zdarz->getNaukowiec()->getPesel())
            print("<p>Sala numer: ".$zdarz->getNrSali().", Naukowiec: ".$zdarz->getNaukowiec()->getImie()." ".$zdarz->getNaukowiec()->getNazwisko()." ".$zdarz->getNaukowiec()->getFirma()."</p>");
    }

    print("<a href='index.php'>Wroć</a>");

}
 ?>
