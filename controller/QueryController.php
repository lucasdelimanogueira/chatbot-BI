<?php
require_once("../model/LUISModel.php");
require_once("../model/QueryModel.php");

$luisModel = new LUISModel($_POST['query']);
$queryModel = new QueryModel($luisModel);

if(true){
	$data1="['".implode($queryModel->data1, "','")."']";
	$data2="[".implode($queryModel->data2, ',')."]";

	$tipo_grafico = $queryModel->tipo_grafico;

	switch($tipo_grafico){
		case "BAR":
			gerarBarrasAction($data1, $data2);
			break;

		case "COLUMN":
			gerarColunasAction($data1, $data2);
			break;

		case "PIE":
			gerarPizzaAction($data1, $data2);
			break;

		case "LINE":
			gerarLinhaAction($data1, $data2);
			break;

		case "TABLE":
			gerarTabelaAction($data1, $data2);
			break;

		case "CARD":
			gerarCardAction($data1, $data2);
			break;
	}

}else{

}


function gerarColunasAction($data1, $data2){

	ob_start();
	include("../view/ColumnView.html");
	$view = ob_get_clean(); 
	echo $view;

}

function gerarTabelaAction($data1, $data2){

	ob_start();
	include("../view/TableView.html");
	$view = ob_get_clean(); 
	echo $view;

}

function gerarLinhaAction($data1, $data2){

	ob_start();
	include("../view/LineView.html");
	$view = ob_get_clean(); 
	echo $view;

}

function gerarCardAction($data1, $data2){

	ob_start();
	include("../view/CardView.html");
	$view = ob_get_clean(); 
	echo $view;

}

function gerarBarrasAction($data1, $data2){
	
	ob_start();
	include("../view/BarView.html");
	$view = ob_get_clean(); 
	echo $view;

}

function gerarPizzaAction($data1, $data2){

	ob_start();
	include("../view/PieView.html");
	$view = ob_get_clean(); 
	echo $view;

}

?>
