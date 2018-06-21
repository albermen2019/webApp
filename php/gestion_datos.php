<?php 

	/**
	* 
	*/
	include_once 'conexion.php';
		
	
	$resultado = false;
	$server = new conexion();
	$conexion = $server->conectar();
	

	if (isset($_POST["json"])){
		$datos = json_decode($_POST["json"]);

#####################   TEST HONEY ALONSO ###########################################
		if ($datos->{"datos"}[0]->{"operacion"} == "ver") {
			$sql = "SELECT id_datos, nombre, apellido, edad FROM datos";
			$stmts = $conexion->prepare($sql);

			if($stmts->execute()){
				$json = array();
				$stmts->store_result();

				$stmts->bind_result($id, $nombre, $apellido, $edad);

				while ($stmts->fetch()) {
					$fila = array('id' => $id, 'nombre' => $nombre, 'apellido' => $apellido, 'edad' => $edad);
					$json[] = $fila;
				}
				$conexion->close();
				echo json_encode($json);

			}else{
					$conexion->close();
				echo $conexion->error;
			}
		}

		
		if ($datos->{"datos"}[0]->{"operacion"} == "guardar") {
			$nombre = $datos->{"datos"}[0]->{"nombre"};
			$apellido = $datos->{"datos"}[0]->{"apellido"};
			$edad = $datos->{"datos"}[0]->{"edad"};
					
			
			$sql='INSERT INTO datos(nombre, apellido, edad) VALUES("'.$nombre.'","'.$apellido.'","'.$edad.'")'; 
			$stmts = $conexion->prepare($sql);
			
			if ($stmts->execute()) {

				return $resultado = true;			

	        }else{
		    	return $resultado = false;     	
	        }

		}

		if ($datos->{"datos"}[0]->{"operacion"} == "actualizar") {
			    	
			$nombre = $datos->{"datos"}[0]->{"nombre"};
			$apellido = $datos->{"datos"}[0]->{"apellido"};
			$edad = $datos->{"datos"}[0]->{"edad"};
			$id = $datos->{"datos"}[0]->{"id"};
			

			//echo $descripcion." ".$estilo." ".$id_item;

			$sql="UPDATE datos SET nombre='".$nombre."', apellido='".$apellido."', edad='".$edad."' WHERE id_datos='".$id."'"; 
			if ($conexion->query($sql)) {
				 $respuesta = true;
	        }else{
		    	 $respuesta = false;     	
	        }

	        echo $respuesta;

		}

		if ($datos->{"datos"}[0]->{"operacion"} == "eliminar") {

			$id = $datos->{"datos"}[0]->{"id"};	

			$sql='DELETE FROM datos WHERE id_datos = '.$id.';'; 
			$stmts = $conexion->prepare($sql);
			if ($stmts->execute()) {
				

				return $resultado = true;
					
	            
	        }else{
		    	return $resultado = false;     	
	        }

		}


												



	}



 ?>