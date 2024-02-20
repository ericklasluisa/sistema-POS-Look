<div class="content-wrapper">
    <section class="content-header">

        <h1>
            Administrar Usuarios
        </h1>

        <ol class="breadcrumb">
            <li><a href="inicio"><i class="fa fa-dashboard"></i>Inicio</a></li>
            <li class="active">Administrar Usuarios</li>
        </ol>
    </section>

    <section class="content">

        <div class="box">

            <div class="box-header with-border">

                <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#modalAgregarUsuario">
                    Agregar Usuario
                </button>

            </div>

            <div class="box-body">

                <table class="table table-bordered table-striped dt-responsive tablas">

                    <thead>

                        <tr>

                            <th>#</th>
                            <th>Nombre</th>
                            <th>Usuario</th>
                            <th>Foto</th>
                            <th>Perfil</th>
                            <th>Estado</th>
                            <th>Último Login</th>
                            <th>Acciones</th>

                        </tr>

                    </thead>

                    <tbody>

                        <tr>

                            <td>1</td>
                            <td>Usuario Administrado</td>
                            <td>admin</td>
                            <td><img src="vistas/dist/img/user2-160x160.jpg" class="img-thumbnail" width="40px"></td>
                            <!-- TODO -->
                            <td>Administrador</td>
                            <td><button class="btn btn-success btn-xs">Activado</button></td>
                            <td>2024-02-15 18:10:32</td>
                            <td>
                                <div class="btn-group">

                                    <button class="btn btn-warning"><i class="fa fa-pencil"></i></button>

                                    <button class="btn btn-danger"><i class="fa fa-times"></i></button>

                                </div>
                            </td>

                        </tr>

                        <tr>

                            <td>1</td>
                            <td>Usuario Administrado</td>
                            <td>admin</td>
                            <td><img src="vistas/dist/img/user2-160x160.jpg" class="img-thumbnail" width="40px"></td>
                            <!-- TODO -->
                            <td>Administrador</td>
                            <td><button class="btn btn-success btn-xs">Activado</button></td>
                            <td>2024-02-15 18:10:32</td>
                            <td>
                                <div class="btn-group">

                                    <button class="btn btn-warning"><i class="fa fa-pencil"></i></button>

                                    <button class="btn btn-danger"><i class="fa fa-times"></i></button>

                                </div>
                            </td>

                        </tr>

                        <tr>

                            <td>1</td>
                            <td>Usuario Administrado</td>
                            <td>admin</td>
                            <td><img src="vistas/dist/img/user2-160x160.jpg" class="img-thumbnail" width="40px"></td>
                            <!-- TODO -->
                            <td>Administrador</td>
                            <td><button class="btn btn-danger btn-xs">Inactivo</button></td>
                            <td>2024-02-15 18:10:32</td>
                            <td>
                                <div class="btn-group">

                                    <button class="btn btn-warning"><i class="fa fa-pencil"></i></button>

                                    <button class="btn btn-danger"><i class="fa fa-times"></i></button>

                                </div>
                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>

        </div>

    </section>
</div>

<!-- ========================
VENTANA MODAL AGREGAR USUARIO
============================= -->

<div class="modal fade" id="modalAgregarUsuario" role="dialog">

    <div class="modal-dialog">

        <div class="modal-content">

            <form role="form" method="post" enctype="multipart/form-data">

                <div class="modal-header" style="background: #3c8dbc; color: white;">

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                        <span aria-hidden="true">&times;</span></button>

                    <h4 class="modal-title">Agregar Usuario</h4>

                </div>

                <div class="modal-body">

                    <div class="box-body">
                        <div class="form-group">
                            <!-- ENTRADA DE NOMBRE -->
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" class="form-control input-lg" name="nuevoNombre"
                                    placeholder="Ingresar Nombre" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <!-- ENTRADA PARA USUARIO -->
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                <input type="text" class="form-control input-lg" name="nuevoUsuario"
                                    placeholder="Ingresar Usuario" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <!-- ENTRADA PARA CONTRASEÑA -->
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                <input type="password" class="form-control input-lg" name="nuevoPassword"
                                    placeholder="Ingresar Contraseña" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <!-- SELECCIONAR PERFIL -->
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-users"></i></span>
                                <select name="nuevoPerfil" class="form-control input-lg">

                                    <option value="" disabled selected>Seleccionar Perfil</option>
                                    <option value="Administrador">Administrador</option>
                                    <option value="Especial">Especial</option>
                                    <option value="Vendedor">Vendedor</option>

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <!-- ENTRADA PARA SUBIR FOTO -->
                            <div class="input-group">
                                <div class="panel">SUBIR FOTO</div>
                                <input type="file" id="nuevaFoto" name="nuevaFoto">
                                <p class="help-block">Peso máximo de la foto 200 MB</p>
                                <img src="vistas/img/usuarios/default/anonymous.png" class="img-thumbnail"
                                    width="100px">
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>

                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>

                </div>
            </form>
        </div>

    </div>

</div>