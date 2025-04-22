<?php 


class Vol implements JsonSerializable {
    // ✅ Propriétés
    private int $id;
    private string $airline;
    private string $flightNumber;
    private string $aircraftModele;
    private string $departureDate;
    private string $departureTime;
    private string $departureAirport;
    private string $departureCode;
    private string $arrivalDate;
    private string $arrivalTime;
    private string $arrivalAirport;
    private string $arrivalCode;
    private string $duration;
    private string $stops;
    private ?string $stopDetails;
    private float $price;

    // ✅ Constructeur
    public function __construct(
        int $id,
        string $airline,
        string $flightNumber,
        string $aircraftModele,
        string $departureDate,
        string $departureTime,
        string $departureAirport,
        string $departureCode,
        string $arrivalDate,
        string $arrivalTime,
        string $arrivalAirport,
        string $arrivalCode,
        string $duration,
        string $stops,
        ?string $stopDetails,
        float $price
    ) {
        $this->id = $id;
        $this->airline = $airline;
        $this->flightNumber = $flightNumber;
        $this->aircraftModele = $aircraftModele;
        $this->departureDate = $departureDate;
        $this->departureTime = $departureTime;
        $this->departureAirport = $departureAirport;
        $this->departureCode = $departureCode;
        $this->arrivalDate = $arrivalDate;
        $this->arrivalTime = $arrivalTime;
        $this->arrivalAirport = $arrivalAirport;
        $this->arrivalCode = $arrivalCode;
        $this->duration = $duration;
        $this->stops = $stops;
        $this->stopDetails = $stopDetails;
        $this->price = $price;
    }

    // ✅ Getters (tu peux ajouter des setters si tu veux modifier les données)
    public function getId(): int { return $this->id; }
    public function getAirline(): string { return $this->airline; }
    public function getFlightNumber(): string { return $this->flightNumber; }
    public function getAircraftModel(): string {return $this->aircraftModele;}
    public function getDepartureDate(): string { return $this->departureDate; }
    public function getDepartureTime(): string { return $this->departureTime; }
    public function getDepartureAirport(): string { return $this->departureAirport; }
    public function getDepartureCode(): string { return $this->departureCode; }
    public function getArrivalDate(): string { return $this->arrivalDate; }
    public function getArrivalTime(): string { return $this->arrivalTime; }
    public function getArrivalAirport(): string { return $this->arrivalAirport; }
    public function getArrivalCode(): string { return $this->arrivalCode; }
    public function getDuration(): string { return $this->duration; }
    public function getStops(): string { return $this->stops; }
    public function getStopDetails(): ?string { return $this->stopDetails; }
    public function getPrice(): float { return $this->price; }
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'airline' => $this->airline,
            'flightNumber' => $this->flightNumber,
            'aircraftModele' => $this->aircraftModele,
            'departureDate' => $this->departureDate,
            'departureTime' => $this->departureTime,
            'departureAirport' => $this->departureAirport,
            'departureCode' => $this->departureCode,
            'arrivalDate' => $this->arrivalDate,
            'arrivalTime' => $this->arrivalTime,
            'arrivalAirport' => $this->arrivalAirport,
            'arrivalCode' => $this->arrivalCode,
            'duration' => $this->duration,
            'stops' => $this->stops,
            'stopDetails' => $this->stopDetails,
            'price' => $this->price,
        ];
    }

}



