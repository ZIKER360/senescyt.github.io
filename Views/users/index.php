<?php include_once 'Views/template/header.php' ?>


<div class="container">
    <div class="row">
        <div class="col">
            <div class="page-description">
                <h1><?php echo $data['title']; ?></h1>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <button class="btn btn-outline-primary mb-3" type="button" id="btnNew">Nuevo</button>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover display nowrap" style="width:100%" id="tblUsers">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Id</th>
                                    <th>Nombres</th>
                                    <th>Usuario</th>
                                    <th>Celular</th>
                                    <th>Perfil</th>
                                    <th>F. Registro</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modalRegistration" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title"></h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <form id="form" autocomplete="off">
                <input type="hidden" id="id_user" name="id_user">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="nombre">Nombre</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="material-icons">
                                        face
                                    </i>
                                </span>
                                <input class="form-control" type="text" id="nombre" name="nombre" placeholder="Nombre">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <bel for="apellido">Apellido</bel>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="material-icons">
                                        face
                                    </i>
                                </span>
                                <input class="form-control" type="text" id="apellido" name="apellido" placeholder="Apellido">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="usuario">Usuario</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="material-icons">
                                        face_6
                                    </i>
                                </span>
                                <input class="form-control" type="text" id="usuario" name="usuario" placeholder="Usuario">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="celular">Celular</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="material-icons">
                                        phone_android
                                    </i>
                                </span>
                                <input class="form-control" type="number" id="celular" name="celular" placeholder="Celular">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="password">Contraseña</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="material-icons">
                                        vpn_key
                                    </i>
                                </span>
                                <input class="form-control" type="password" id="password" name="password" placeholder="Contraseña">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="rol">Rol</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="material-icons">
                                        people
                                    </i>
                                </span>
                                <select name="rol" id="rol" class="form-control">
                                    <option value="1">Administrador</option>
                                    <option value="2">Usuario</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-primary" type="submit">
                        <i class="material-icons">
                            verified_user
                        </i>Guardar
                    </button>
                    <button class="btn btn-outline-danger" type="button" data-bs-dismiss="modal">
                        <i class="material-icons">
                            gpp_bad
                        </i>Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once 'Views/template/footer.php' ?>