<?php 
$reservation = EventData::getById($_GET["id"]);
$pacients = ProjectData::getAll();
$medics = CategoryData::getAll();
?>
<div class="row">
    <div class="col-md-8">
        <h1>Editar Reserva</h1>
        <br>
        <form class="form-horizontal" role="form" method="post" action="./?action=updatereservation">

            <div class="form-group">
                <label for="inputEmail1" class="col-lg-2 control-label">Fecha</label>
                <div class="col-lg-4">
                <input type="date" name="date_at" value="<?php echo $reservation->date_at; ?>" required
                        class="form-control" id="inputEmail1" placeholder="Fecha">
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail1" class="col-lg-2 control-label">Hora Inicio</label>
                <div class="col-lg-2">
                <input type="time" name="time_at" value="<?php echo $reservation->time_at; ?>" class="form-control"
                        id="inputEmail1" placeholder="Hora">
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail1" class="col-lg-2 control-label">Hora Termino</label>
                <div class="col-lg-2">
                    <input type="time" name="time_end" value="<?php echo $reservation->time_end; ?>" class="form-control" id="inputEmail1" placeholder="Hora">
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail1" class="col-lg-2 control-label">Titulo</label>
                <div class="col-lg-10">
                    <input type="text" name="title" value="<?php echo $reservation->title; ?>" required
                        class="form-control" id="inputEmail1" placeholder="Titulo">
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail1" class="col-lg-2 control-label">Descripcion</label>
                <div class="col-lg-10">
                    <textarea class="form-control" rows="5" name="description"
                        placeholder="Descripcion"><?php echo $reservation->description;?></textarea>
                </div>
            </div>

            <div class="form-group">
                <label for="inputEmail1" class="col-lg-2 control-label">Prioridad</label>
                <div class="col-lg-4">
                    <select name="project_id" class="form-control">
                        <option value="">Seleccione</option>
                        <?php foreach($pacients as $p):?>
                        <option value="<?php echo $p->id; ?>"
                            <?php if($p->id==$reservation->project_id){ echo "selected"; }?>><?php echo $p->name; ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <label for="inputEmail1" class="col-lg-2 control-label">Categoria</label>
                <div class="col-lg-4">
                    <select name="category_id" class="form-control">
                        <option value="">Seleccione</option>
                        <?php foreach($medics as $p):?>
                        <option value="<?php echo $p->id; ?>"
                            <?php if($p->id==$reservation->category_id){ echo "selected"; }?>><?php echo $p->name; ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

            </div>
            <div class="form-group">
            </div>
            <div class="form-group">
                <div class="col-lg-offset-2 col-lg-10">
                    <input type="hidden" name="id" value="<?php echo $reservation->id; ?>">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save" aria-hidden="true"></i> Actualizar Reserva</button>
                    <a href="index.php?action=delreservation&amp;id=<?=$_GET["id"]?>" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i> Eliminar</a>
                </div>
            </div>
        </form>

    </div>
</div>