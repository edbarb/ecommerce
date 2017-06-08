<?php 

namespace Hcode;
//Usando uma classe que esta em outro namespace que é o Rain\Tpl
use Rain\Tpl;
//Criando a classe de fato
class Page {

	private $tpl;
	private $options = [];
	private $defaults = [
		"header"=>true,
		"footer"=>true,
		"data"=>[]
	]; 

	public function __construct($opts = array(), $tpl_dir = "/views/") //primeiro a ser executado
	{
		//$this->defaults["data"]["session"] = $_SESSION;

		$this->options = array_merge($this->defaults, $opts);

		$config = array(
			"tpl_dir"       => $_SERVER["DOCUMENT_ROOT"].$tpl_dir, //vai trazer a pasta do DIR root
			"cache_dir"     => $_SERVER["DOCUMENT_ROOT"]."/views-cache/",
			"debug"         => false
		);

		Tpl::configure( $config );

		$this->tpl = new Tpl;

		$this->setData($this->options["data"]);

		if($this->options["header"] === true) $this->tpl->draw("header");

	}

	private function setData($data = array())
	{

		foreach ($data as $key => $value) {
			$this->tpl->assign($key, $value);
		}

	}

	public function setTpl($name, $data = array(), $returnHTML = false)
	{

		$this->setData($data);

		return $this->tpl->draw($name, $returnHTML);

	}
	//Criando o destruct
	public function __destruct() //Ultimo a ser executado
	{//Rodape
		if($this->options["footer"] === true) $this->tpl->draw("footer");
	}
}

 ?>