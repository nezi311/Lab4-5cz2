<?php
// src/zdarzenia.php
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @Entity
 * @Table(name="zdarzenia")
 */

 class Zdarzenia
 {
   /** @Id @Column(type="integer") @GeneratedValue **/
   private $id;
    /** @$nr_sali @Column(type="string", length=20)**/
   private $nr_sali;
   /**
   * @ManyToOne(targetEntity="Uzytkownik", inversedBy="zdarzenia")
   * @JoinColumn(name="id_naukowca", referencedColumnName="pesel")
   */
   private $naukowiec;

  public function getId()
  {
    return $this->id;
  }

  public function getNrSali()
  {
    return $this->nr_sali;
  }

  public function setNrSali($nr)
  {
    $this->nr_sali=$nr;
  }

  public function getNaukowiec()
  {
    return $this->naukowiec;
  }




    public function setNaukowiec($naukowiec)
    {
        if (!$naukowiec instanceof Uzytkownik)
        {
            throw new InvalidArgumentException('$naukowiec musi być instancją klasy Uzytkownik');
        }
        $this->naukowiec = $naukowiec;
    }




 }
?>
