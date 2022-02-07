<?php include('../template/cabecera.php'); ?>

<?php

$txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
$txtNombre=(isset($_POST['txtNombre']))?$_POST['txtNombre']:"";
$txtImagen=(isset($_FILES['txtImagen']['name']))?$_FILES['txtImagen']['name']:"";
$accion=(isset($_POST['accion']))?$_POST['accion']:"";

include ("../config/bd.php");

switch($accion){

    case "Agregar":
        $sentenciaSQL = $conexion->prepare("INSERT INTO `libros` (nombre , imagen) VALUES (:nombre, :imagen);");
        $sentenciaSQL->bindParam(':nombre', $txtNombre);
        $sentenciaSQL->bindParam(':imagen', $txtImagen);
        $sentenciaSQL->execute();

        break;

    case "Modificar":
        echo "Presionado el boton modificar";
        break;

    case "Cancelar":
        echo "Presionado el boton cancelar";
        break;
        
    case "Seleccionar":

        $sentenciaSQL = $conexion->prepare("SELECT * FROM libros WHERE id=:id");
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();
        $libro=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
        
        $txtNombre=$libro['nombre'];
        $txtImagen=$libro['imagen'];
     
        break;   
     //   echo "Presionado el boton Seleccionar";

    case "Borrar":
        $sentenciaSQL = $conexion->prepare("DELETE FROM libros WHERE id=:id");
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();
     //   echo "Presionado el boton Borrar";
        break;             
}

$sentenciaSQL = $conexion->prepare("SELECT * FROM libros");
$sentenciaSQL->execute();
$listaLibros=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="col-md-4">

<div class="card">
    <div class="card-header">
        Datos de libro
    </div>
    <div class="card-body">
        <form method="POST" enctype="multipart/form-data"> 
            
            <div class = "form-group">
                <label for="txtID">ID:</label>
                <input type="text" class="form-control" id="txtID" value="<?php echo $txtID; ?>" name="txtID" placeholder="ID">
            </div>
        
            <div class="form-group">
                <label for="txtNombre">Nombre:</label>
                <input type="text" class="form-control" id="txtNombre" value="<?php echo $txtNombre; ?>" name="txtNombre" placeholder="Nombre del libro">
            </div>
        
            <div class="form-group">
                <label for="txtNombre">Imagen:</label>
                <?php echo $txtImagen; ?>"
                <input type="file" class="form-control" id="txtImagen" name="txtImagen" placeholder="Nombre">
            </div>
        
            <div class="btn-group" role="group" aria-label="">
                <button type="submit" name="accion" value="Agregar" class="btn btn-success">Agregar</button>
                <button type="submit" name="accion" value="Modificar" class="btn btn-warning">Modificar</button>
                <button type="submit" name="accion" value="Cancelar" class="btn btn-info">Cancelar</button>
            </div>
        
        </form>
        
    </div>
 
</div>






</div>
<div class="col-md-7">

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php  foreach ($listaLibros as $libro) { ?> 
            <tr>
                <td><?php echo $libro['id'] ?></td>
                <td><?php echo $libro['nombre'] ?></td>
                <td><?php echo $libro['imagen'] ?></td>
                <td>
                    
                Seleccionar \ borrar

                 <form method="POST">
                   
                    <input type="hidden" name="txtID" id="txtID" value="<?php echo $libro['id']; ?>"/>
                     
                     <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary"/>
                    
                     <input type="submit" name="accion" value="Borrar" class="btn btn-danger"/>

                
                
                
                </form>


                </td>
            </tr> 
        <?php }  ?>
        </tbody>
    </table>

</div>


<?php include('../template/pie.php'); ?>
