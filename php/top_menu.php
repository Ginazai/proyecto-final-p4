<div class="container">
  <div class="row">
    <div class="col-md-12">
      <form method="post" class="form-inline">
      	<div class="form-group">
      		<select class="form-control mb-3" name="vista">
      			<option selected disabled>Seleccione una vista</option>
	      		<option value="tickets">Tickets</option>
	      		<option value="usuarios">Usuarios</option>
	      		<option value="categorias">Categorias</option>
	      	</select>
	      	<button class="form-control btn btn-primary mt-3" type="submit">Filtrar</button>
      	</div>
	    <hr>
      </form>
  	</div>

  	<div class="col-md-12">
      <form method="post" class="form-inline">
      	<div class="form-group mr-3">
          <input type="text" id="ticket" name="ticket" placeholder="Buscar por # de ticket" class="form-control">
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Ver resultados</button>
      </form>
    </div>
  </div>
</div>