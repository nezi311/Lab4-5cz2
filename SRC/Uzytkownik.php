<?php
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @Entity
 * @Table(name="naukowcy")
 */


class Uzytkownik
{

    /** @Id @Column(type="bigint") **/
    private $pesel;
    /** @Column(type="string", length=50) **/
    private $imie;
    /** @Column(type="string", length=100) **/
    private $nazwisko;
    /** @Column(type="string", length=100) **/
    private $nazwa_firmy;

    /**
    * @OneToMany(targetEntity="Zdarzenia", mappedBy="naukowiec")
    */
    private $zdarzenia;

    public function __construct()
    {
        $this->zdarzenia = new ArrayCollection();
    }

    public function setImie($i)
    {
       $this->imie=$i;
    }

    public function setNazwisko($n)
    {
        $this->nazwisko=$n;
    }

    public function setFirma($f)
    {
      $this->nazwa_firmy=$f;
    }

    public function setPesel($p)
    {
      if(is_numeric($p))
        $this->pesel=$p;
        else
        {
            print("<br>Podany numer pesel nie jest liczbą");
        }
    }


    public function getPesel()
    {
        return $this->pesel;
    }

    public function getImie()
    {
        return $this->imie;
    }

    public function getNazwisko()
    {
        return $this->nazwisko;
    }

    public function getFirma()
    {
        return $this->nazwa_firmy;
    }






    public function addZdarzenia($zdarzenie)
    {
      if($zdarzenie !== null)
      {
          if(!$zdarzenie instanceof Zdarzenia) {
              throw new InvalidArgumentException('$zdarzenie musi być instancją klasy Zdarzenia');
          }

          $this->zdarzenia[] = $zdarzenie;

      }
    }
}

?>
