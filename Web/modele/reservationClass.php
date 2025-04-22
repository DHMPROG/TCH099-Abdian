<?php

class Reservation implements JsonSerializable
{
    private $id;
    private $id_passager;
    private $id_vol;
    private $id_siege;
    private $date_reservation;
    private $statut;

    public function __construct($id_passager, $id_vol, $id_siege, $statut = 'confirmée')
    {
        $this->id_passager = $id_passager;
        $this->id_vol = $id_vol;
        $this->id_siege = $id_siege;
        $this->statut = $statut;
        $this->date_reservation = date('Y-m-d H:i:s');
    }

    // Getters
    public function getId()
    {
        return $this->id;
    }

    public function getIdPassager()
    {
        return $this->id_passager;
    }

    public function getIdVol()
    {
        return $this->id_vol;
    }

    public function getIdSiege()
    {
        return $this->id_siege;
    }

    public function getDateReservation()
    {
        return $this->date_reservation;
    }

    public function getStatut()
    {
        return $this->statut;
    }

    // Setters
    public function setIdPassager($id_passager)
    {
        $this->id_passager = $id_passager;
    }

    public function setIdVol($id_vol)
    {
        $this->id_vol = $id_vol;
    }

    public function setIdSiege($id_siege)
    {
        $this->id_siege = $id_siege;
    }

    public function setStatut($statut)
    {
        if (in_array($statut, ['confirmée', 'annulée'])) {
            $this->statut = $statut;
        } else {
            throw new InvalidArgumentException("Statut invalide.");
        }
    }
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'id_passager' => $this->id_passager,
            'id_vol' => $this->id_vol,
            'id_siege' => $this->id_siege,
            'date_reservation' => $this->date_reservation,
            'statut' => $this->statut,
        ];
    }
}
?>