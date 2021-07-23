<div class="row">
    <div class="col-md-12">
        <div class="btn-group pull-right">
            <!--<div class="btn-group pull-right">
  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
    <i class="fa fa-download"></i> Descargar <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" role="menu">
    <li><a href="report/clients-word.php">Word 2007 (.docx)</a></li>
  </ul>
</div>
-->
        </div>
        <!--a href="./index.php?view=oldreservations" class="btn btn-default pull-right">Eventos Anteriores</a-->
        <h1>Agenda</h1>
        <br>
        <form class="form-horizontal" role="form">
            <input type="hidden" name="view" value="reservations">
            <?php
$dias = array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
$meses = array(1=>"enero",2=>"febrero",3=>"marzo",4=>"abril",5=>"mayo",6=>"junio",7=>"julio",8=>"agosto",9=>"septiembre",10=>"octubre",11=>"noviembre",12=>"diciembre");
$pacients = ProjectData::getAll();
$medics = CategoryData::getAll();
        ?>

            <div class="form-group">
                <div class="col-lg-2">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-search"></i></span>
                        <input type="text" name="q"
                            value="<?php if(isset($_GET["q"]) && $_GET["q"]!=""){ echo $_GET["q"]; } ?>"
                            class="form-control" placeholder="Palabra clave">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-flask"></i></span>
                        <select name="project_id" class="form-control">
                            <option value="">Prioridad</option>
                            <?php foreach($pacients as $p):?>
                            <option value="<?php echo $p->id; ?>"
                                <?php if(isset($_GET["project_id"]) && $_GET["project_id"]!=""){ echo "selected"; } ?>>
                                <?php echo $p->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-th-list"></i></span>
                        <select name="category_id" class="form-control">
                            <option value="">Categoria</option>
                            <?php foreach($medics as $p):?>
                            <option value="<?php echo $p->id; ?>"
                                <?php if(isset($_GET["category_id"]) && $_GET["category_id"]!=""){ echo "selected"; } ?>>
                                <?php echo $p->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <input type="date" name="date_at"
                            value="<?php if(isset($_GET["date_at"]) && $_GET["date_at"]!=""){ echo $_GET["date_at"]; } ?>"
                            class="form-control" placeholder="Palabra clave">
                    </div>
                </div>

                <div class="col-lg-2">
                    <button class="btn btn-primary btn-block">Buscar</button>
                </div>

            </div>
        </form>

        <?php
$users= array();
if((isset($_GET["q"]) && isset($_GET["project_id"]) && isset($_GET["category_id"]) && isset($_GET["date_at"])) && ($_GET["q"]!="" || $_GET["project_id"]!="" || $_GET["category_id"]!="" || $_GET["date_at"]!="") ) {
$sql = "select * from event where ";
if($_GET["q"]!=""){
	$sql .= " title like '%$_GET[q]%' and description like '%$_GET[q] %' ";
}

if($_GET["project_id"]!=""){
if($_GET["q"]!=""){
	$sql .= " and ";
}
	$sql .= " project_id = ".$_GET["project_id"];
}

if($_GET["category_id"]!=""){
if($_GET["q"]!=""||$_GET["project_id"]!=""){
	$sql .= " and ";
}

	$sql .= " category_id = ".$_GET["category_id"];
}



if($_GET["date_at"]!=""){
if($_GET["q"]!=""||$_GET["project_id"]!="" ||$_GET["category_id"]!="" ){
	$sql .= " and ";
}

	$sql .= " date_at = \"".$_GET["date_at"]."\"";
}

		$users = EventData::getBySQL($sql);

}else{
		$users = EventData::getAll();

}
		if(count($users)>0){
			// si hay usuarios
			?>
        <table class="table table-bordered table-hover">
            <thead>
                <th>Titulo</th>
                <th>Descripción</th>
                <th>Prioridad</th>
                <th>Categoria</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Opciones</th>
            </thead>
            <?php
			foreach($users as $user){
				$project = null;
				if($user->project_id!=null){
				$project  = $user->getProject();
				}
				$category = null;
				if($user->category_id!=null){
				$category = $user->getCategory();
				}

				$hora_inicio = new DateTime($user->time_at);
				$hora_termino = new DateTime($user->time_end);
				$tiempo = $hora_inicio->diff($hora_termino);

				?>
            <tr>
                <td><?= $user->title; ?></td>
                <td><?= $user->description; ?></td>
                <td><?php if($project!=null ){ echo $project->name;} ?></td>
                <td><?php if($category!=null){ echo $category->name; }?></td>
                <td><?= $dias[date_format(date_create($user->date_at), 'w')]." ".date_format(date_create($user->date_at), 'd')." de ".$meses[date_format(date_create($user->date_at), 'n')]." de ".date_format(date_create($user->date_at), 'Y'); ?>
                </td>
                <td><?= $user->time_at." - ".$user->time_end. " <b>(" .$tiempo->format('%H:%I').")</b>";?></td>
                <td style="width:130px;">
                    <a href="index.php?view=editreservation&id=<?php echo $user->id;?>" class="btn btn-warning"><i
                            class="fa fa-edit" aria-hidden="true"></i></a>
                    <a href="index.php?action=delreservation&id=<?php echo $user->id;?>" class="btn btn-danger"><i
                            class="fa fa-trash" aria-hidden="true"></i></a>
                </td>
            </tr>
            <?php

			}



		}else{
			echo "<p class='alert alert-danger'>No hay Eventos</p>";
		}


		?>


    </div>
</div>