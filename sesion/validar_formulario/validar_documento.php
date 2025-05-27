
<?php
include('../../mostrar/config/config.php');
header('Content-Type: application/json');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $documento = $_POST["documento"];
//Verificando si existe algun cliente en bd ya con dicha cedula asignada
//Preparamos un arreglo que es el que contendrá toda la información
$jsonData = array();
$selectQuery   = ("SELECT documento FROM usuarios WHERE documento='".$documento."' ");
$query         = mysqli_query($con, $selectQuery);
$totalCliente  = mysqli_num_rows($query);

//Validamos que la consulta haya retornado información
if( $totalCliente <= 0 ){
    $jsonData['success'] = 0;
   // $jsonData['message'] = 'No existe Cédula ' .$cedula;
    $jsonData['message'] = '';
} else{
    //Si hay datos entonces retornas algo
    $jsonData['success'] = 1;
    $jsonData['message'] = '<p style="color:red;">Ya existe la Cédula <strong>(' .$documento.')<strong></p>';
}

//Mostrando mi respuesta en formato Json
header('Content-type: application/json; charset=utf-8');
echo json_encode( $jsonData );


}
?>