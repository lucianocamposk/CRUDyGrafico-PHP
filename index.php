<?php
$txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
$txtNombre=(isset($_POST['txtNombre']))?$_POST['txtNombre']:"";
$intEdad=(isset($_POST['intEdad']))?$_POST['intEdad']:"";
$txtSexo=(isset($_POST['txtSexo']))?$_POST['txtSexo']:"";
$txtRolid=(isset($_POST['txtRolid']))?$_POST['txtRolid']:"";
$accion=(isset($_POST['accion']))?$_POST['accion']:"";

include ("./bd.php");

switch($accion){

    case "Agregar":
        $sentenciaSQL = $conexion->prepare("INSERT INTO `usuarios` (id, nombre , edad, sexo, rolid) VALUES (:id, :nombre, :edad, :sexo, :rolid);");
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->bindParam(':nombre', $txtNombre);
        $sentenciaSQL->bindParam(':edad', $intEdad);
        $sentenciaSQL->bindParam(':sexo', $txtSexo);
        $sentenciaSQL->bindParam(':rolid', $txtRolid);
        $sentenciaSQL->execute();

        break;

    case "Modificar":

        $sentenciaSQL = $conexion->prepare("UPDATE usuarios SET nombre=:nombre, edad=:edad, sexo=:sexo, rolid=:rolid WHERE id=:id");
        $sentenciaSQL->bindParam(':nombre',$txtNombre);
        $sentenciaSQL->bindParam(':edad',$intEdad);
        $sentenciaSQL->bindParam(':sexo',$txtSexo);
        $sentenciaSQL->bindParam(':rolid',$txtRolid);
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();

        break;
      
    case "Seleccionar":

        $sentenciaSQL = $conexion->prepare("SELECT * FROM usuarios WHERE id=:id");
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();
        $usuario=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
        
        $txtID=$usuario['ID'];
        $txtNombre=$usuario['NOMBRE'];
        $intEdad=$usuario['EDAD'];  
        $txtSexo=$usuario['SEXO'];
        $txtRolid=$usuario['ROLID'];
     
        break;   

    case "Borrar":
        
        $sentenciaSQL = $conexion->prepare("DELETE FROM usuarios WHERE id=:id");
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();
        
        break;             
}

$sentenciaSQL = $conexion->prepare("SELECT * FROM usuarios");
$sentenciaSQL->execute();
$listaUsuarios=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>

    <div class="container">
        <br/>
        <div class="row">
        
            <div class="col-md-4">

            <div class="card">
                <div class="card-header">
                   <b>AGREGAR UN USUARIO</b> 
                </div>
                <div class="card-body">
                    <form method="POST" > 
                        
                        <div class = "form-group">
                            <label for="txtNombre">ID:</label>
                            <input type="text" class="form-control" id="txtID" name="txtID" value="<?php echo $txtID; ?>" required >
                        </div>   
                        <div class = "form-group">
                            <label for="txtNombre">Nombre:</label>
                            <input type="text" class="form-control" id="txtNombre" name="txtNombre" value="<?php echo $txtNombre; ?>"  required>
                        </div>             
                        <div class="form-group">
                            <label for="intEdad">Edad:</label>
                            <input type="number" class="form-control" id="intEdad"  name="intEdad" value="<?php echo $intEdad; ?>" required>
                        </div>             
                        <div class="form-check">
                            <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="txtSexo" id="txtSexo" value="H" required>
                            Masculino
                            <span style="padding:30px; ">
                            <input type="radio" class="form-check-input" name="txtSexo" id="txtSexo" value="M" >
                            Femenino</span>
                          </label>
                        </div>               
                        <br/>       
                        <div class="form-group">
                          <label for="txtRolid">Rol:</label>
                          <select class="form-control" name="txtRolid" id="txtRolid"  required>
                                <option value="" selected disabled>Seleccionar</option>
                                <option value="1">Alumno</option>
                                <option value="2">Docente</option>
                                <option value="3">Director</option>
                          </select>
                        </div>
                    
                        <div class="btn-group" role="group" aria-label="">
                            <button type="submit" name="accion" value="Agregar" class="btn btn-success">Agregar</button>
                         <button type="submit"   name="accion" value="Modificar" class="btn btn-warning">Modificar</button>  
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
                    <th>Edad</th>
                    <th>Sexo</th>
                    <th>Rol</th>
                    <th>Accion</th>
                </tr>
            </thead>
            <tbody>
        <?php  foreach ($listaUsuarios as $usuario) { ?> 
                <tr>
                    <td><?php echo $usuario['ID'] ?></td>
                    <td><?php echo $usuario['NOMBRE'] ?></td>
                    <td><?php echo $usuario['EDAD'] ?></td>
                    <td><?php echo $usuario['SEXO'] ?></td>
                    <td><?php echo $usuario['ROLID'] ?></td>
                    <td>                  
                    <form method="POST">
                    
                        <input type="hidden" name="txtID" id="txtID" value="<?php echo $usuario['ID']; ?>"/>
                        
                        <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary"/>
                        
                        <input type="submit" name="accion" value="Borrar" class="btn btn-danger"/>
                                   
                    </form>
                    </td>
                </tr> 
            <?php }  ?>
            </tbody>
        </table>

        </div>
     </div>
    </div>

</body>
</html>