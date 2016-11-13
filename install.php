<?php
require_once "vendor/autoload.php";
require_once "bootstrap.php";

/*function __autoload($className)

{

    $path = __DIR__.DIRECTORY_SEPARATOR.'SRC'.DIRECTORY_SEPARATOR. str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';

    require_once($path);

}*/
//usunięcie obiektów - Doctrine Query Language (DQL)
$query = $entityManager->createQuery('DELETE Uzytkownik u');
$query->execute();

$query = $entityManager->createQuery('DELETE Zdarzenia z');
$query->execute();

$naukowiec1 = new Uzytkownik();
$naukowiec1->setPesel("94051904017");
$naukowiec1->setImie("Dawid");
$naukowiec1->setNazwisko("Dominiak");
$naukowiec1->setFirma("PWSZ");
$entityManager->persist($naukowiec1);

$naukowiec2 = new Uzytkownik();
$naukowiec2->setPesel("94011104019");
$naukowiec2->setImie("Damian");
$naukowiec2->setNazwisko("Krupnik");
$naukowiec2->setFirma("DDas");
$entityManager->persist($naukowiec2);

$naukowiec3 = new Uzytkownik();
$naukowiec3->setPesel("94010654789");
$naukowiec3->setImie("Bartosz");
$naukowiec3->setNazwisko("Nagato");
$naukowiec3->setFirma("AssDa");
$entityManager->persist($naukowiec3);

$naukowiec4 = new Uzytkownik();
$naukowiec4->setPesel("94051632145");
$naukowiec4->setImie("Andrzej");
$naukowiec4->setNazwisko("Kowalski");
$naukowiec4->setFirma("Anonimowi Anrzeje");
$entityManager->persist($naukowiec4);

$naukowiec5 = new Uzytkownik();
$naukowiec5->setPesel("94326547891");
$naukowiec5->setImie("Janek");
$naukowiec5->setNazwisko("Mielczarek");
$naukowiec5->setFirma("Janki z czarnolasu");
$entityManager->persist($naukowiec5);


echo "<p>Dodanie Naukowców</p>";
$entityManager->flush();




$zdarzenie = new Zdarzenia();
$zdarzenie->setNrSali('2A');
$zdarzenie->setNaukowiec($naukowiec1);
$naukowiec1->addZdarzenia($zdarzenie);
$entityManager->persist($zdarzenie);

$zdarzenie1 = new Zdarzenia();
$zdarzenie1->setNrSali('2B');
$zdarzenie1->setNaukowiec($naukowiec1);
$naukowiec1->addZdarzenia($zdarzenie1);
$entityManager->persist($zdarzenie1);

$zdarzenie2 = new Zdarzenia();
$zdarzenie2->setNrSali('110');
$zdarzenie2->setNaukowiec($naukowiec2);
$naukowiec1->addZdarzenia($zdarzenie2);
$entityManager->persist($zdarzenie2);

echo "<p>Dodanie Zdarzeń</p>";
$entityManager->flush();



print("<a href='index.php'>Wroć</a>");
?>
