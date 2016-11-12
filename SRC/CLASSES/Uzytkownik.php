<?php
// src/Product.php
namespace CLASSES;
/**
 *
 * @Table(name="naukowcy")
 */


class Uzytkownik

    /** @pesel @Column(type="biginteger") @GeneratedValue **/
    private $pesel;
    /** @Column(type="string", length=50) **/
    private $imie;
    /** @Column(type="string", length=100) **/
    private $nazwisko;
    /** @Column(type="string", length=100) **/
    private $firma;

        /**
        * @ManyToOne(targetEntity="Category", inversedBy="products")
        * @JoinColumn(name="category_id", referencedColumnName="id")
        */
    public function __construct($i,$n,$p,$f)
    {
        $this->imie=$i;
        $this->nazwisko=$n;

        // sprawdzenie czy pesel jest liczbą
        // funkcja is_numeric zwraca true lub false jeśli podana zmienna jest liczbą
        if(is_numeric($p))
        {
            $this->pesel = $p; // przypisanie pod zmienną pesel wartości liczbowej ze zemiennej $p
            if($this->checkIfExists($p)==false) // sprawdzenie za pomocą metody checkIfExists czy naukowiec o podanym numerze pesel istnieje juz w bazie danych
            {
                try
                {
                    // przygotowanie zapytania sql
                    $stmt = DB::getHandle() -> prepare('INSERT naukowcy VALUES (:pesel,:imie,:nazwisko,:nazwa_firmy)');
                    $stmt -> bindValue(':pesel',$p,PDO::PARAM_INT); // podpinanie parametrow do zapytania
                    $stmt -> bindValue(':imie',$i,PDO::PARAM_STR);
                    $stmt -> bindValue(':nazwisko',$n,PDO::PARAM_STR);
                    $stmt -> bindValue(':nazwa_firmy',$f,PDO::PARAM_STR);
                    $wynik_zapytania = $stmt -> execute(); // wykonanie zapytania

                    if($wynik_zapytania)
                    {
                      print("<br>Udało się dodać naukowca $i $n");
                    }
                }
                catch(PDOException $e)
                {
                    echo 'Wystąpił błąd biblioteki PDO: ' . $e->getMessage();
                    return true;
                }
            }
        }
        else
        {
            print("<br>Podany numer pesel nie jest liczbą");
        }
        $this->firma = $f;

    }

    public function setImie($i)
    {
       $this->imie=$i;
    }

    public function setNazwisko($n)
    {
        $this->nazwisko=$n;
    }

    public function getImie()
    {
        return $this->imie;
    }

    public function getNazwisko()
    {
        return $this->nazwisko;
    }


    public function getPesel()
    {
        return $this->pesel;
    }

    public function getFirma()
    {
        return $this->firma;
    }

    // metoda checkIfExists sprawdza czy podany numer pesel istnieje w bazie danych, zwraca true jeśli istnieje lub false jeśli nie istnieje
    public function checkIfExists($p)
    {
        try
        {
            $stmt = DB::getHandle() -> prepare('SELECT * FROM naukowcy WHERE pesel = :pesel'); // przygotowanie zapytania do bazy danych

            // podpięcie parametrow pod przygotowany uchwyt :pesel
            // robimy to w celu profilaktycznym, aby atak sql_injection sie nie powiodl
            $stmt -> bindValue(':pesel',$p,PDO::PARAM_STR);

            $stmt -> execute(); // wykonujemy zapytanie
            $liczba = $stmt->rowCount(); // zliczamy ilość wierszy ktore zwroci zapytanie

            if($liczba==0 || $liczba==null)
                return false;
        }
        catch(PDOException $e)
        {
            echo 'Wystąpił błąd biblioteki PDO: ' . $e->getMessage();
            return true;
        }


        return true;
    }

    // metoda ma za zadanie pokazywać wynajete przez naukowca pokoje
    public function showRooms()
    {
      try
      {
        $stmt = DB::getHandle() -> prepare('SELECT * FROM zdarzenia WHERE id_naukowca = :tempPesel');
        $stmt -> bindValue(':tempPesel',$this->pesel,PDO::PARAM_INT);
        $stmt -> execute();
        //$row=$stmt -> fetch(PDO::FETCH_ASSOC);

        if($stmt!=false)
        {
          $tempImie = parent::getImie();
          $tempNazwisko = parent::getNazwisko();
          print("<h1>Sale wynajęte przez naukowca $tempImie $tempNazwisko .</h1>");
          while($row=$stmt -> fetch(PDO::FETCH_ASSOC))
          {
            $sala = $row["nr_sali"];
            print('<h3>nr sali : '.$sala.'<h3>');
          }
        }
      }
      catch(PDOException $e)
      {
        	echo 'Wystąpił błąd biblioteki PDO: ' . $e->getMessage();
      }
    }

    public function addToEvents($ev)
    {
      try
      {
        $stmt = DB::getHandle() -> prepare('INSERT zdarzenia VALUES (NULL,:nr,:naukowiec)'); // przygotowanie zapytania do bazy danych

        // podpięcie parametrow pod przygotowany uchwyt :pesel
        // robimy to w celu profilaktycznym, aby atak sql_injection sie nie powiodl
        $stmt -> bindValue(':nr',$ev,PDO::PARAM_STR);
        $stmt -> bindValue(':naukowiec',$this->pesel,PDO::PARAM_INT);


        $stmt -> execute(); // wykonujemy zapytanie

        if($stmt!=false)
        {
          print("Udało się wynająć pokoj.");
          $this->showRooms();
        }



      }
      catch(PDOException $e)
      {
        	echo 'Wystąpił błąd biblioteki PDO: ' . $e->getMessage();
      }

    }



}

?>
