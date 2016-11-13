<?php
require_once "vendor/autoload.php";
require_once "bootstrap.php";

            $ZdarzeniaAll = $entityManager->getRepository('Zdarzenia');
            $wszystkie = $ZdarzeniaAll->findAll();



            $licznik=0;
            $tablica = array();
            foreach ($wszystkie as $zdarz)
            {
                $sala=$zdarz->getNrSali();
                    if(in_array($sala,$tablica))
                    {

                    }
                    else
                    {
                        array_push($tablica,$sala);
                        $licznik++;
                    }
            }
            echo "<p>Wszystkie zdarzenia:</p>";
            echo "<ul>";
            while($licznik!=0)
            {
                $znacznik=array_pop($tablica);
                echo "<p>Sala numer: ".$znacznik."</p>";
                        foreach ($wszystkie as $zdarz)
                        {
                            if($zdarz->getNrSali() == $znacznik)
                            echo ("<p>Id Zdazenia: ".$zdarz->getId()."<br> Pesel naukowca: ".$zdarz->getNaukowiec()->getPesel()."<br> Imię naukowca: ".$zdarz->getNaukowiec()->getImie()."<br> Nazwisko naukowca: ".$zdarz->getNaukowiec()->getNazwisko()."<br> Firma naukowca: ".$zdarz->getNaukowiec()->getFirma()."</p><br><br>");
                        }
                $licznik--;

            }

            echo "</ul>";

            print("<a href='index.php'>Wroć</a>");
?>
