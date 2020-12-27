<?php

class LUISModel{
	private $entidade_analise = "";
	private $campo_analise = "";
	private $entidade_agrupamento = "";
	private $campo_agrupamento = "";
	private $metrica = "";
	private $tipo_grafico = "";
	private $jsonArr = "";

	public function __construct($querystr){
		$query = $_POST['query'];

		$url = "INSERIR SUA URL_KEY DO LUIS CHATBOT AQUI";
		
		$url = str_replace(" ", "%20", $url);

		$json = file_get_contents(utf8_decode($url));

		$json = json_decode($json);

		$this->jsonArr = $json;

		$this->setMetrica();

		$this->setEntidadeAnalise();

		$this->setEntidadeAgrupamento();

		$this->setCampoAnalise();

		$this->setCampoAgrupamento();

		$this->setVisual();

		/*echo $this->metrica;
		echo $this->tipo_grafico;
		echo $this->entidade_analise;
		echo $this->entidade_agrupamento;
		echo $this->campo_analise;
		echo $this->campo_agrupamento;
		echo "<br>";
		echo "<br>";*/
	}

	private function setMetrica(){
		foreach ($this->jsonArr->entities as $entidades) {

			if($entidades->type == "Metrica"){
			
				switch($entidades->resolution->values[0]){
					case "Soma":
						$this->metrica = "SUM";
						break;

					case "Total":
						if(isset($entidades->role) && $entidades->role == "Campo_Analise"){
							$this->metrica = "SUM";
						}else{
							$this->metrica = "COUNT";
						}
						break;

					case "Maximo":
						$this->metrica = "MAX";
						break;

					case "Minimo":
						$this->metrica = "MIN";
						break;

					case "Quantidade":
						$this->metrica = "COUNT";
						break;

					case "Media":
						$this->metrica = "AVG";
						break;

					default:
						$this->metrica = "";
				}
			}
		}
	}

	private function setVisual(){
		foreach ($this->jsonArr->entities as $entidades) {
			
			if($entidades->type == "Visual"){
				
				switch($entidades->resolution->values[0]){
					case "Pizza":
						$this->tipo_grafico = "PIE";
						break;

					case "Linha":
						$this->tipo_grafico = "LINE";
						break;

					case "Barra":
						$this->tipo_grafico = "BAR";
						break;

					case "Coluna":
						$this->tipo_grafico = "COLUMN";
						break;

					case "Tabela":
						$this->tipo_grafico = "TABLE";
						break;

					default:
						$this->tipo_grafico = "";
				}
			}
		}
	}


	private function setEntidadeAnalise(){
		foreach ($this->jsonArr->entities as $entidades) {
			
			if(isset($entidades->role) && $entidades->role == "Entidade_Analise"){
				$this->entidade_analise = $entidades->resolution->values[0];
			}

		}
	}

	private function setEntidadeAgrupamento(){
		foreach ($this->jsonArr->entities as $entidades) {
			
			if(isset($entidades->role) && $entidades->role == "Entidade_Agrupamento"){
				$this->entidade_agrupamento = $entidades->resolution->values[0];
			}
			
		}
	}

	private function setCampoAnalise(){
		foreach ($this->jsonArr->entities as $entidades) {
			
			if(isset($entidades->role) && $entidades->role == "Campo_Analise"){
				$this->campo_analise = $entidades->resolution->values[0];
			}
			
		}
	}

	private function setCampoAgrupamento(){
		foreach ($this->jsonArr->entities as $entidades) {
			
			if(isset($entidades->role) && $entidades->role == "Campo_Agrupamento"){
				$this->campo_agrupamento = $entidades->resolution->values[0];
			}
			
		}
	}

	//GETTERS AND SETTERS
	public function getEntidadeAnalise(){
		return $this->entidade_analise;
	}

	public function getEntidadeAgrupamento(){
		return $this->entidade_agrupamento;
	}

	public function getCampoAnalise(){
		return $this->campo_analise;
	}

	public function getCampoAgrupamento(){
		return $this->campo_agrupamento;
	}

	public function getTipoGrafico(){
		return $this->tipo_grafico;
	}

	public function getMetrica(){
		return $this->metrica;
	}

	
}
?>
