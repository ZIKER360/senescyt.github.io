<div id="modalFile" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title">Subir o Crear Carpeta</h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <div class="d-grid">
                    <button type="button" id="btnNuevaCarpeta" class="btn btn-outline-primary m-r-xs"><i class="material-icons">folder</i>Nueva Carpeta</button>
                    <hr>
                    <input type="file" id="file" class="d-none" name="file">
                    <button type="button" id="btnSubirArchivo" class="btn btn-outline-success m-r-xs"><i class="material-icons">insert_drive_file</i>Subir Archivo</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modalCarpeta" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title-carpeta">Nueva Carpeta</h5>
                <button class="btnclose" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <form id="frmCarpeta" autocomplete="off">
                <div class="modal-body">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="material-icons">folder</i>
                        </span>
                        <input class="form-control" type="text" name="nombre" id="nombre" placeholder="Nombre">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">Crear</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="modalview" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title-view"></h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="id_folder">
                <div class="d-grid">
                    <a href="#" id="btnView" class="btn btn-outline-info m-r-xs"><i class="material-icons">insert_drive_file</i>Ver</a>
                    <hr>
                    <button type="button" id="btnuploadfile" class="btn btn-outline-primary m-r-xs"><i class="material-icons">insert_drive_file</i>Subir Archivo</button>
                    <hr>
                    <button type="button" id="btnshare" class="btn btn-outline-success m-r-xs"><i class="material-icons">share</i>Compartir</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modalshare" class="modal fade" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title-share">Compartir Archivos</h5>
                <button class="btnclose" data-bs-dismiss="modal" aria-label="Close">
                </button>   
            </div>
            <form id="frmShare">
                <div class="modal-body">
                    <div class="container-files">
                        
                    </div>
                    <select class="js-states form-control" id="usuarios" name="usuarios[]" tabindex="-1" style="display: none; width: 100%" multiple="multiple">
                    </select>
                    <hr>
                    <div class="accordion accordion-flush mb-3" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                    Seleccionar los archivos
                                </button>
                            </h2>
                            <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <div id="container-files">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="text-center">
                        <a class="btn btn-outline-info" href="#" id="btnSeeDetail">Detalles</a>
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-danger" type="button" data-bs-dismiss="modal">Cancelar</button>
                    <button class="btn btn-outline-success" type="submit">Compartir</button>
                </div>
            </form>
        </div>
    </div>