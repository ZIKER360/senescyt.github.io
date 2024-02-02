<?php include_once 'Views/template/header.php'; ?>

<div class="card">
    <div class="card-body">
        <div class="alert alert-custom alert-indicator-bottom indicator-info" role="alert">
            <div class="alert-content text-center">
                <span class="alert-title">Directorio</span>
                <span class="alert-text"><?php echo $data['folder']['nombre']; ?></span>
            </div>
        </div>
        <input type="hidden" id="id_folder" value="<?php echo $data['id_folder']; ?>">
        <div class="table-resposive">
            <table class="table table-striped table-hover display nowrap" style="width:100%" id="tblDetalle">
                <thead>
                    <tr>
                        <th></th>
                        <th>Archivo</th>
                        <th>Usuario</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include_once 'Views/template/footer.php' ?>