<?php
echo(
  "<div class='container'>
    <div class='row my-3'>
      <div class='col-md-6'>
        <form method='post' class=''>
        	<div class='input-group'>
            <button class='btn btn-dark' type='submit'>Filtrar</button>
        		<select class='form-select' name='vista'>
        			<option selected disabled>Seleccione una vista</option>
  	      		<option value='tickets'>Tickets</option>
  	      		<option value='usuarios'>Usuarios</option>
  	      		<option value='categorias'>Categorias</option>
  	      	</select>
        	</div>
        </form>
    	</div>

    	<div class='col-md-6'>
        <form method='post' class=''>
        	<div class='input-group mr-3'>
            <button type='submit' name='submit' class='btn btn-dark'>Ver resultados</button>
            <input type='text' id='$vista' name='$vista' placeholder='Buscar $vista' class='form-control'>
          </div>
        </form>
      </div>
    </div>
  </div>");
?>