<?php
require_once("../lib/Database.php");

class QueryModel{
	public $tipo_grafico;
	public $data1;
	public $data2;
	public $luisModel;

	public function __construct($luisModel){
		$this->luisModel = $luisModel;

		if (!empty($luisModel->getCampoAgrupamento())){
			//com agrupamento
			if(!empty($luisModel->getCampoAgrupamento())){
				//com agrupamento com campo analise
				if(!empty($luisModel->getMetrica())){
					//tem metrica
					if(!empty($luisModel->getTipoGrafico())){
						//metrica no grafico agrupado
						$this->groupedQuery();
						$this->tipo_grafico = $this->luisModel->getTipoGrafico();
					}else{
						//metrica num grafico de barras agrupado
						$this->groupedQuery();
						$this->tipo_grafico = "BAR";
					}

				}else{
					//nao tem metrica
					if(!empty($luisModel->getTipoGrafico())){
						//soma de campo analise no grafico agrupado
						$this->groupedQuery();
						$this->tipo_grafico = $this->luisModel->getTipoGrafico();
					}else{
						//soma de campo analise num grafico de barras agrupado
						$this->groupedQuery();
						$this->tipo_grafico = "BAR";
					}
				}

			}else{
				// sem campo analise agrupado (contagem de linha agrupado)
				if(!empty($luisModel->getTipoGrafico())){
					//contagem de linha agrupado no grafico
					$this->groupedQuery();
					$this->tipo_grafico = $this->luisModel->getTipoGrafico();
				}else{
					//contagem de linha agrupado num grafico de barras
					$this->groupedQuery();
					$this->tipo_grafico = "BAR";
				}
			}

		}else{
			//sem agrupamento
			if(!empty($luisModel->getCampoAnalise())){
				//sem agrupamento com campo analise
				if(!empty($luisModel->getMetrica())){
					//tem metrica
					if(!empty($luisModel->getTipoGrafico())){
						//metrica no grafico
						$this->normalQuery();
						$this->tipo_grafico = $this->luisModel->getTipoGrafico();
					}else{
						//metrica num card
						$this->normalQuery();
					}

				}else{
					//nao tem metrica
					if(!empty($luisModel->getTipoGrafico())){
						//soma de campo analise no grafico
						$this->normalQuery();
						$this->tipo_grafico = $this->luisModel->getTipoGrafico();
					}else{
						//soma de campo analise num card
						$this->normalQuery();
					}
				}

			}else{
				//sem agrupamento sem campo analise (contagem de linha)
				if(!empty($luisModel->getTipoGrafico())){
					//contagem de linha agrupado no grafico
					$this->normalQuery();
					$this->tipo_grafico = $this->luisModel->getTipoGrafico;
				}else{
					//contagem de linha agrupado num grafico de barras
					$this->normalQuery();
					$this->tipo_grafico = "BAR";
				}
			}
		}
		
	}

	public function groupedQuery(){
		$db = new Database();

		//consulta no banco
		if($this->luisModel->getMetrica() == "COUNT" || $this->luisModel->getMetrica() == "" || $this->luisModel->getCampoAnalise() == ""){
			$sql = "SELECT ".$this->luisModel->getEntidadeAgrupamento().".".$this->luisModel->getCampoAgrupamento().",COUNT(*) FROM ".$this->luisModel->getEntidadeAnalise()." LEFT JOIN ".$this->luisModel->getEntidadeAgrupamento()." ON ".$this->luisModel->getEntidadeAnalise().".".$this->luisModel->getEntidadeAgrupamento()." = ".$this->luisModel->getEntidadeAgrupamento().".id GROUP BY ".$this->luisModel->getEntidadeAgrupamento().".".$this->luisModel->getCampoAgrupamento();

		}else{
			$sql = "SELECT ".$this->luisModel->getEntidadeAgrupamento().".".$this->luisModel->getCampoAgrupamento().",".$this->luisModel->getMetrica()."(".$this->luisModel->getEntidadeAnalise().".".$this->luisModel->getCampoAnalise().") FROM ".$this->luisModel->getEntidadeAnalise()." LEFT JOIN ".$this->luisModel->getEntidadeAgrupamento()." ON ".$this->luisModel->getEntidadeAnalise().".".$this->luisModel->getEntidadeAgrupamento()." = ".$this->luisModel->getEntidadeAgrupamento().".id GROUP BY ".$this->luisModel->getEntidadeAgrupamento().".".$this->luisModel->getCampoAgrupamento();

			//SELECT categorias.nome,SUM(vendas.valor) FROM vendas LEFT JOIN categorias ON vendas.categorias = categorias.id GROUP BY categorias.nome
		}
		//echo $sql;
		$result = $db->query($sql);

		if($result){//sem erro na consulta
			//retorna dados
			while($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$results[] = $row;
			}
			
			$this->data1 = array_column($results,$this->luisModel->getCampoAgrupamento());

			if($this->luisModel->getMetrica() == "COUNT" || $this->luisModel->getMetrica() == "" || $this->luisModel->getCampoAnalise() == ""){

				$this->data2 = array_column($results, "COUNT(*)");

			}else{
				$this->data2 = array_column($results, $this->luisModel->getMetrica()."(".$this->luisModel->getEntidadeAnalise().".".$this->luisModel->getCampoAnalise().")");
			}

		}else{
			return false;
		}
	}

	public function normalQuery(){
		$db = new Database();

		//consulta no banco
		if($this->luisModel->getMetrica() == "COUNT" || $this->luisModel->getMetrica() == "" || $this->luisModel->getCampoAnalise() == ""){
			$sql = "SELECT COUNT(*) FROM ".$this->luisModel->getEntidadeAnalise();
		}else{
			$sql = "SELECT ".$this->luisModel->getMetrica()."(".$this->luisModel->getCampoAnalise().") FROM ".$this->luisModel->getEntidadeAnalise();
		}

		$result = $db->query($sql);

		if($result){//sem erro na consulta
			//retorna dados
			while($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$results[] = $row;
			}
			var_dump($results);

		}else{
			return false;
		}

		//echo $sql;
	}

	//GETTERS E SETTESR
	public function getData1(){
		return $this->data1;
	}

	public function getData2(){
		return $this->data2;
	}
}
?>