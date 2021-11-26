  <!-- Modal -->
  <div class="modal fade" id="clientModal" tabindex="-1" aria-labelledby="clientModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="clientModalLabel">Agregar Cliente</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('/client/create') }}" method="post" id="form-client">
                @csrf

                <input type="hidden" name="id" id="id">

                <div class="mb-3">
                    <label for="name" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="name" name="name" value="">
                </div>
        
                <div class="mb-3">
                    <label for="last_name_p" class="form-label">Apellido Paterno</label>
                    <input type="text" class="form-control" id="last_name_p" name="last_name_p" rows="3" value="">
                </div>
        
                <div class="mb-3">
                    <label for="last_name_m" class="form-label">Apellido Materno</label>
                    <input type="text" class="form-control" id="last_name_m" name="last_name_m" value="">
                </div>
        
                <div class="mb-3">
                    <label for="address" class="form-label">Dirección</label>
                    <textarea  class="form-control" id="address" rows="3" name="address" value=""> </textarea>
                </div>
        
                <div class="mb-3">
                    <label for="email" class="form-label">Correo Electronico</label>
                    <input type="email" class="form-control" id="email" name="email" value="">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" id="btn-client" class="btn btn-primary">Guardar</button>
                  </div>
            </form> 
        </div>

      </div>
    </div>
  </div>
