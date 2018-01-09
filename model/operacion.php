<?php
error_reporting(E_ERROR | E_PARSE);
//////////////////////////////////
/*
Elaborado por: Ing. Gabriel Pérez
Enero 2018
Caracas- Venezuela
*/
//////////////////////////////////
// Capturamos valores enviados por post //
$dataIn=$_POST['entrada'];
$data=explode(",",$dataIn);
/*$data= array();
$data[]="2";
$data[]="2-5";
$data[]="UPDATE-111-4";
$data[]="UPDATE-122-2";
$data[]="UPDATE-222-5";
$data[]="QUERY-111-111";
$data[]="QUERY-222-222";
$data[]="2-2";*/

// array de respuesta//
$respuesta= array();
$respuesta[]="STATUS 200";
$respuesta[]="OPERACION EJECUTADA EN PHP";
$respuesta[]="ING. GABRIEL PEREZ, SALUDOS";


// Obtenemos numero de casos a realizar, el cual deberia ser el primer valor del array//
$test_cases=intval($data[0]);

	
		// For para recorrer los casos de uso y determinar tamano de matriz y cantidad de operaciones //
		// Basado en N numero de casos//
		// tam_matriz - Tamano de matriz a ejecutar
		// tam_operaciones - Cantidad de operaciones a ejecutar en la matriz
		// posicion - guarda la posicion para ubicar donde se encuentran los datos de la matriz
		for($k=0;$k<$test_cases;$k++)
		{
	
			$matriz= array();
				if($k==0)
			{ 	
				$Explodeinfo=explode("-",$data[1]);
				$tam_matriz=intval($Explodeinfo[0]);
				$posicion_inicial=2;
				$tam_operaciones=intval($Explodeinfo[1]);
				
			}
			
		
			else if($k==1)
			{
				$posicion=$tam_operaciones+2;	
				//Esta variable sera donde inicia las operaciones//
				$posicion_inicial=$posicion+1;
				$Explodeinfo=explode("-",$data[$posicion]);
				$tam_matriz=intval($Explodeinfo[0]);				
				$tam_operaciones=intval($Explodeinfo[1]);
				$posicion=$posicion+$tam_operaciones;
				
				
			} 
			
			
			else
			{					
				$posicion=$posicion+1;	
				//Esta variable sera donde inicia las operaciones//
				$posicion_inicial=$posicion+1;
				$Explodeinfo=explode("-",$data[$posicion]);
				$tam_matriz=intval($Explodeinfo[0]);				
				$tam_operaciones=intval($Explodeinfo[1]);
				$posicion=$posicion+$tam_operaciones;
				
			}
			
			// Ejecutamos dada la matriz y numero de operaciones//
			for($j=$posicion_inicial;$j<($tam_operaciones+$posicion_inicial);$j++)
			{				
				$Explodeinfo=explode("-",$data[$j]);
			
				
				// CAPTURAMOS EL TIPO DE OPERACION - QUERY //
				if ($Explodeinfo[0]=="UPDATE")
				{
					$ExplodeCordenadaA=$Explodeinfo[1];
					$x1=intval($ExplodeCordenadaA[0]);
					$y1=intval($ExplodeCordenadaA[1]);
					$z1=intval($ExplodeCordenadaA[2]);
					$valorNumerico=intval($Explodeinfo[2]);					
					//asignamos valores capturados de x,y,z al arreglo matriz //
					$matriz["$x1,$y1,$z1"]= $valorNumerico;
								
				}
				
				if ($Explodeinfo[0]=="QUERY")
				{
					// capturamos cordenadasA
					$ExplodeCordenadaA=$Explodeinfo[1];
					$x1=intval($ExplodeCordenadaA[0]);
					$y1=intval($ExplodeCordenadaA[1]);
					$z1=intval($ExplodeCordenadaA[2]);
					
					// capturamos cordenadasB
					$ExplodeCordenadaB=$Explodeinfo[2];
					$x2=intval($ExplodeCordenadaB[0]);
					$y2=intval($ExplodeCordenadaB[1]);
					$z2=intval($ExplodeCordenadaB[2]);
					
					
					// realizamos suma de acuerdo a las cordenadas dadas//
					$suma=0;
					$tamano=count($matriz);					
					
					// usamos foreach para recorrer array asociativo //	
					foreach ( $matriz as $indice=> $valor )
					{
						$valorActual=explode(",",$indice);
						
						// obtenemos valor de posicion actual y comparamos
						$x=intval($valorActual[0]);
						$y=intval($valorActual[1]);
						$z=intval($valorActual[2]);
						$valorAct=intval($valor);				
						
						if( ($x>=$x1) && ($x<=$x2) )
						{
							if( ($y>=$y1) && ($y<=$y2) )
							{
								if( ($z>=$z1) && ($z<=$z2) )
								{									
									// Cumple con las condiciones y sumamos
									$suma=$suma+$valorAct;
									
								}
							}						
							
						}
						
				
					} // fin foreach comparativo
					
					// Agregamos resultado a array de respuesta
					$respuesta[]="Numero de caso: ".$k."| QUERY($x1-$y1-$z1)($x2-$y2-$z2)"."|Resultado: ".$suma;
				}
								
			}
		}		
	// FINALMENTE DEVOLVEMOS ARRAY EN JSON PARA MOSTRAR EN FORNTEND

	echo json_encode($respuesta, JSON_FORCE_OBJECT);

?>