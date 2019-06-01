<?php
namespace EversoftTeam\Form;
use pocketmine\Player;
use pocketmine\form\Form;
class MenuForm implements Form{

	private $datos;

	private $proceso;

	public function __construct(array $datos, callable $proceso)

	{

		$this->datos = $datos;

		$this->proceso = $proceso;

	}


	public function handleResponse(Player $player, $data): void

	{

        $llamada = $this->proceso;

        $llamada($player, $data);

	}

	public function jsonSerialize()

	{

		return $this->datos;

	}



}