<?
$conexion=@mysql_connect("localhost","root","12345678");
$db_name="metro";
$tabla="COCHERA";
$hide;

if(!$conexion){
  exit('<p>No pudo realizarce la conexion a la base de datos.</p>');
  }
  if (!@mysql_select_db(metro,$conexion)) {
    echo mysql_errno();
    exit('<p>Problema al seleccionar la base de datos</p>');
  }
  if (!$_GET && !isset($_POST['enviar']) /*($accion)*/){
  ?>
<html>
  <head>
    <title>Cocheras de Estaciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <img class="navbar-brand" style="width: 60px; margin-left: 8px; " src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/3b/Metro_de_la_Ciudad_de_México_logo.svg/1019px-Metro_de_la_Ciudad_de_México_logo.svg.png">
    <ul class="navbar-nav me-auto">
      <li class="nav-item">
          <a class="nav-link active" href="Linea.php">Lineas</a>
          </li>
          <li class="nav-item">
          <a class="nav-link active" href="Estaciones.php">Estaciones</a>
          </li>
          </li>
          <li class="nav-item">
          <a class="nav-link active" href="Estacion-Linea.php">Estacion-Linea</a>
          </li>
          <li class="nav-item">
          <a class="nav-link active" href="Trenes.php">Trenes</a>
          </li>
          <li class="nav-item">
          <a class="nav-link active" href="Acceso.php">Acceos</a>
          </li>
          <li class="nav-item">
          <a class="nav-link active" href="Cochera.php">Cocheras</a>
          </li>
    </ul>
    </div>  

    <form name="buscar" method="post" action="Cochera.php" class="d-flex">
      <select name="campo">
        <?
        $resultado=mysql_query("show fields from ".$tabla,$conexion);
        while ($row=mysql_fetch_array($resultado)) {
              ?>
              <option><? echo $row[0];?></option>
        <?
            }   
        ?>
      </select>

          <input class="form-control me-2" type="search" placeholder="Buscar" name="palabra">
          <button class="btn btn-outline-success" type="submit" name="enviar">Buscar</button>
        </form>

    </nav>
    <div class="mt-3" align="center">
      <a class="btn btn-success" href="Cochera-insertar.php">Agregar</a></button>
    </div>
  </body>
</html>

<?
$sql="SELECT ID_COCHERA,NOM_COCHERA,ID_ESTACION2,NOM_ESTACION FROM ".$tabla." inner join ESTACION on ID_ESTACION2=ID_ESTACION";
$result=@mysql_query($sql);
if(!$result){
  exit("Error de consulta\n Verifica consulta");
}
if($hide==false){
?>
<html>
  <body>
    <table id="texto" class="table table-dark table-striped table-hover mt-3" style="text-align: center; width: 800px; text-transform: capitalize;" align="center">
      <thead>
        <tr>
        <th>ID Cochera</th>
        <th>Nombre Cochera</th>
        <th>ID Estacion</th>
        <th>Cocchera De::</th>
        <th>Operaciones</th>
      </tr>
      </thead>
      <tbody>
        <?
          while ($row=@mysql_fetch_array($result)) {
            echo "<tr>";
            echo "<td>".$row[0]."</td>";
            echo "<td>".$row[1]."</td>";
            echo "<td>".$row[2]."</td>";
            echo "<td>".$row[3]."</td>";
            echo "<td>";
            echo "<a class='mx-2 btn btn-danger ml-5' href=".$_SERVER['PHP_SELF']."?borrar=".$row[0].">Borrar</a>";
            echo "<a class='mx-2 btn btn-primary ml-5' href=".$_SERVER['PHP_SELF']."?cambiar=".$row[0].">Editar</a>";
            echo "</td>";
            echo "</tr>";
          }
        ?>
      </tbody>
    </table>
  </body>
</html>

<?
}
}
if (empty($_GET['borrar'])==false)
{
$id=$_GET['borrar'];

    ?>
      <html>
      <head><title>Eliminando datos</title></head>
      <body>
    <?
    
    $sql="DELETE FROM ".$tabla." WHERE ID_COCHERA = '".$id."'";

    
    if(@mysql_query($sql)){

      echo "<p>Elemento eliminado.</p>";
    }
    else{
      echo mysql_errno();
      echo "<p>Error al eliminar el elemento.</p>";
    }
    mysql_close($conexion);
    echo "<script>alert('Registro Eliminado');window.location='Cochera.php';</script>";
  }
  ?>

<?
if (empty($_GET['cambiar'])==false)
{
$id=$_GET['cambiar'];

    $sql = "SELECT ID_COCHERA,NOM_COCHERA,ID_ESTACION2,NOM_ESTACION FROM ".$tabla." inner join ESTACION on ID_ESTACION2=ID_ESTACION WHERE ID_COCHERA ='".$id."'";
    $registro = @mysql_query($sql);
  if(!$registro){
    echo "Error ".mysql_errno();
    exit('<p>No se pudo obtener los detalles del registro.</p>');
  }
  $registro = mysql_fetch_array($registro);
  
  ?>

  <html>
      <head>
        <title>Actualizar datos</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
      </head>
      <body>

  <div class="row mt-5">
    <div class="col-md-5 mx-auto mt-5">
      <div class="card card text-white bg-dark mb-3">
        <div class="card-body">
          <h1 align="center">Inserta Datos</h1>
          <form action="<?php echo $_SERVER['PHP_self'];?>" method="post" name="Cochera.php">
          <p>
          <input  type="hidden" align="LEFT" name="ID" value="<?php echo $registro['ID_COCHERA'];?>" /><p>
          <p>Nombre de Cochera:
          <input class="form-control mt-2" type="text" align="LEFT" name="Nombre" value="<?php echo $registro['NOM_COCHERA'];?>"/><p>
          <p>ID Estacion:
          <input class="form-control mt-2" type="text" align="LEFT" name="Estacion" value="<?php echo $registro['ID_ESTACION2'];?>"/><p>         
          <input class="btn btn-success form-control mt-3" type="submit" value="Actualizar" name="actualizar">
          <a class="btn btn-danger form-control mt-3" href="Cochera.php">Atras</a>
          </form>
        </div>
      </div>
    </div>
  </div>
  </body>
  </html>

  <?PHP


if($_POST){
  ECHO '<html>
      <head><title>Resultado de UPDATE</title></head>
      <body>';

  
$subs_nombre = utf8_decode($_POST['Nombre']);
$subs_estacion = utf8_decode($_POST['Estacion']);


    $sql="UPDATE ".$tabla." SET
    NOM_COCHERA='$subs_nombre',ID_ESTACION2='$subs_estacion' WHERE ID_COCHERA ='".$id."'";
    

    if(@mysql_query($sql)){
      echo '<script>alert("Registro Actualizado.");window.location="Cochera.php";</script>';
    }
    else{
      echo "<p>Error al actualizar el registro.</p>";
      echo mysql_errno();
      if (mysql_errno()==1452){
        echo "existe una restricción y tendrá que actualizar datos en editorial.";
      }
    }
  
  echo '</body></html>';
mysql_close($conexion);
}
}
  ?>

  <?
if (isset($_POST['enviar'])) {
  $query ="SELECT ID_COCHERA,NOM_COCHERA,ID_ESTACION2,NOM_ESTACION from ".$tabla." inner join ESTACION on ID_ESTACION2=ID_ESTACION WHERE {$_POST['campo']} LIKE '%{$_POST['palabra']}%'";
  $resultado=mysql_query($query,$conexion);

?>
<head>
    <title>Estaciones de Lineas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  </head>
  <body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <img class="navbar-brand" style="width: 60px; margin-left: 8px; " src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/3b/Metro_de_la_Ciudad_de_México_logo.svg/1019px-Metro_de_la_Ciudad_de_México_logo.svg.png">
    <ul class="navbar-nav">
      <!-- <li class="nav-item">
          <a class="nav-link active" href="#">Cosultas</a>
          </li>
 -->          
    </ul>
    </div>  
    </nav>
    <div class="mt-3" align="center">
      <a class="btn btn-danger" href="Cochera.php">Regresar</a></button>
    </div>
    <table id="texto" class="table table-dark table-striped table-hover mt-3" style="text-align: center; width: 800px; text-transform: capitalize;" align="center">
      <thead>
        <tr>
        <th>ID Cochera</th>
        <th>Nombre</th>
        <th>ID Estacion</th>
        <th>Cochera De:</th>
        <th>Operaciones</th>
      </tr>
      </thead>
      <tbody>
<?

  $fond =false;
  while ($row=mysql_fetch_array($resultado)) {
    $fond=true;
    ?>
      <html>
    
        <?
            echo "<tr>";
            echo "<td>".$row[0]."</td>";
            echo "<td>".$row[1]."</td>";
            echo "<td>".$row[2]."</td>";
            echo "<td>".$row[3]."</td>";
            echo "<td>";
            echo "<a class='mx-2 btn btn-danger ml-5' href=".$_SERVER['PHP_SELF']."?borrar=".$row[0].">Borrar</a>";
            echo "<a class='mx-2 btn btn-primary ml-5' href=".$_SERVER['PHP_SELF']."?cambiar=".$row[0].">Editar</a>";
            echo "</td>";
            echo "</tr>";         
  }
  ?>
      </tbody>
    </table>
  </body>
</html>
  <?

  if (!$fond) {
    echo "No se encontró resultado";
  }
}
?>
