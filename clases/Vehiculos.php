<?php
require_once"accesoDatos.php";
class Vehiculo
{
//--------------------------------------------------------------------------------//
//--ATRIBUTOS
	private $id;
	private $patente;
 	private $fecha;

//--------------------------------------------------------------------------------//

//--------------------------------------------------------------------------------//
//--GETTERS Y SETTERS
  	public function GetId()
	{
		return $this->id;
	}
	public function GetPatente()
	{
		return $this->patente;
	}
	public function GetFecha()
	{
		return $this->fecha;
	}
	
	public function SetId($valor)
	{
		$this->id = $valor;
	}
	public function SetPatente($valor)
	{
		$this->patente = $valor;
	}
	public function SetFecha($valor)
	{
		$this->fecha = $valor;
	}
	
//--------------------------------------------------------------------------------//
//--CONSTRUCTOR
	public function __construct($patente=NULL)
	{
		if($patente != NULL){
			$obj = Vechiculo::TraerUnVechiculo($patente);
			
			$this->patente = $patente;
			$this->fecha = $obj->fecha;
		}
	}

//--------------------------------------------------------------------------------//
//--TOSTRING	
  	public function ToString()
	{
	  	return $this->patente."-".$this->fecha;
	}
//--------------------------------------------------------------------------------//

//--------------------------------------------------------------------------------//
//--METODO DE CLASE
	public static function TraerUnVehiculo($idParametro) 
	{	


		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT * from vehiculo where id =:id");
		$consulta->bindValue(':id', $idParametro, PDO::PARAM_INT);
		$consulta->execute();
		$vehiculoBuscado= $consulta->fetchObject('vehiculo');
		return $vehiculoBuscado;	
					
	}
	
	public static function TraerTodosLosVehiculos()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT * from vehiculo");
		$consulta->execute();			
		$arrVehiculos= $consulta->fetchAll(PDO::FETCH_CLASS, "vehiculo");	
		return $arrVehiculos;
	}
	
	public static function Borrar($idParametro)
	{	
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("DELETE from vehiculo where id =:id");
		$consulta->bindValue(':id', $idParametro, PDO::PARAM_INT);
		$consulta->execute();
		return $consulta->rowCount();	
	}
	
	public static function Modificar($vehiculo)
	{
		$id = $vehiculo->GetId();
		$patente = $vehiculo->GetPatente();
		$fecha = $vehiculo->GetFecha();

		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("UPDATE vehiculo set patente=:patente,fecha=:fecha where id =:id");
		
		$consulta->bindValue(':id', $id, PDO::PARAM_INT);
		$consulta->bindValue(':patente', $patente, PDO::PARAM_STR);
		$consulta->bindValue(':fecha', $fecha, PDO::PARAM_STR);
		
		$consulta->execute();
		$vehiculoBuscado= $consulta->fetchObject('vehiculo');
		return $vehiculoBuscado;
	}

//--------------------------------------------------------------------------------//

//--------------------------------------------------------------------------------//

	public static function Insertar($vehiculo)
	{
		$patente = $vehiculo->GetPatente();
		$fecha = $vehiculo->GetFecha();

		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO vehiculo (patente,fecha)VALUES(:patente,:fecha)");
		
		$consulta->bindValue(':patente', $patente, PDO::PARAM_STR);
		$consulta->bindValue(':fecha', $fecha, PDO::PARAM_STR);
		
		$consulta->execute();
		$vehiculoBuscado= $consulta->fetchObject('vehiculo');
		return $vehiculoBuscado;
	}	
//--------------------------------------------------------------------------------//

}
?>