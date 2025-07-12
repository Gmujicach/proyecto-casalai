<?php require_once "utils.php"; ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="icon" href="img/logo.png">
    <title>Manual de Usuario - Casa Lai.Ca</title>
</head>

<body>
    <main class="tarjeta card p-5">
        <header class="d-flex justify-content-between align-items-center border-bottom py-4">
            <h1 class="fw-bold">Manual de Usuario</h1>
            <img style="height: 85px;" src="img/logo-lg.png">
        </header>

        <section class="mb-5">
            <h2 class="text-primary">Introducción</h2>

            <p>
                El presente manual define con lujo de detalles cada sección que conforma el <strong>Sistema de Gestión
                    de Inventario y Ventas para la empresa Casa Lai, C.A</strong>.
            </p>

            <p>
                El sistema fué creado con la finalidad de favorecer a la empresa permitiendo manejar sus datos de
                manera ordenada y segura sin temor a la perdida de información, mejorando la eficiencia y rápidez en la
                atención al cliente. El servicio dado será online facilitando la realización de
                solicitudes
                por parte de los clientes.
            </p>
        </section>

        <section class="mb-5">
            <h2 class="text-primary" id="principal">Dashboard</h2>

            <p>Una vez <strong>iniciado sesión</strong> sera llevado a la <strong>pagina
                    principal</strong>:</p>

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Barra lateral</th>
                        <th>Dashboard</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td><?= renderImagen("dashboard", "barra.png") ?></td>
                        <td><?= renderImagen("dashboard", "vista.png") ?></td>
                    </tr>
                </tbody>
            </table>

            <p>
                Puede acceder al resto de opciones a traves de la <strong>barra lateral</strong>. Dependiendo de su
                <strong>Rol</strong> sera capaz de acceder a uno o más opciones.
            </p>

            <p>
                En la <strong>parte inferior</strong> de la <strong>Barra lateral</strong> encontrara su perfil
                indicando
                su <strong>rol</strong> actual.
            </p>

            <td><?= renderImagen("dashboard", "perfil.png") ?></td>

            <p>En este ejemplo, su <strong>rol</strong> es <strong>Almacenista</strong>.</p>
        </section>

        <section class="mb-5">
            <h2 class="text-primary">Cerrar sesión</h2>

            <p>
                En la <strong>parte inferior</strong> de la <strong>Barra lateral</strong> encontrara el boton
                <strong>Cerrar Sesion</strong>. Dar clic <strong>cerrara su sesión actual</strong> y lo devolvera al
                <strong>Inicio de sesión</strong>.
            </p>

            <?= renderImagen("dashboard", "cerrar-sesion.png") ?>
        </section>

        <div id="rol-usuario">
            <h1 class="fw-bold text-decoration-underline">Usuarios</h1>

            <p>Sera capaz de acceder a las siguientes opciones:</p>

            <section>
                <?php
                $datos = [
                    "id" => "catalogo",
                    "nombre_singular" => "Catalogo de productos",
                    "nombre_plural" => "Catalogo de productos",
                    "gestionable" => [
                        "Los productos que desee agregar a su carrito"
                    ],
                ];

                plantilla("inicio", $datos);
                ?>

                <p>A su vez en la <strong>parte superior</strong> encontrara pestañas que le permitiran ir a
                    <strong>Combos Promocionales</strong>.
                </p>

                <?= renderImagen("catalogo", "tab.png") ?>

                <p>En esta vista podra ver mas ofertas de productos:</p>

                <?= renderImagen("catalogo", "vista-2.png") ?>
            </section>

            <section>
                <h3 class="text-primary-emphasis">Agregar Producto al carrito</h3>

                <p>En cada producto podra presionar el boton <strong>Agregar</strong> en la
                    <strong>parte izquierda</strong> para agregarlo a su <strong>carrito de
                        compras</strong>.
                </p>

                <?= renderImagen("catalogo", "agregar.png") ?>
            </section>
        </div>

        <div id="rol-almacenista">
            <h1 class="fw-bold text-decoration-underline">Almacenista</h1>

            <p>Sera capaz de acceder a las opciones del <strong>Usuario</strong> en conjunto con las siguientes
                opciones:</p>

            <section>
                <?php
                $datos = [
                    "id" => "recepcion",
                    "nombre_singular" => "Recepción",
                    "nombre_plural" => "Recepciones",
                    "modificar_ubicacion" => "parte derecha",
                    "modificar_extra" => "Incluso podra <strong>agregar y remover</strong> sus productos si asi lo desea.",
                    "gestionable" => [
                        "Fecha",
                        "Correlación",
                        "Proveedor",
                        "Producto",
                        "Cantidad",
                        "Costo de inversión",
                    ],
                    "instrucciones" => [
                        "Correlativo del producto",
                        "Seleccionar un proveedor",
                        "Seleccionar uno o más productos de la <strong>Lista de Productos</strong>"
                    ]
                ];

                plantilla("inicio", $datos);
                plantilla("incluir", $datos);
                plantilla("modificar", $datos);
                ?>
            </section>

            <section class="mb-5">
                <?php
                $datos = [
                    "id" => "despacho",
                    "nombre_singular" => "Despacho",
                    "nombre_plural" => "Despachos",
                    "modificar_ubicacion" => "parte derecha",
                    "gestionable" => [
                        "Fecha",
                        "Correlación",
                        "Cliente",
                        "Producto",
                        "Cantidad",
                    ],
                    "instrucciones" => [
                        "Correlativo del producto",
                        "Seleccionar un cliente",
                        "Seleccionar uno o más productos de la <strong>Lista de Productos</strong>"
                    ]
                ];

                plantilla("inicio", $datos);
                plantilla("incluir", $datos);
                plantilla("modificar", $datos);
                plantilla("reporte", $datos);
                ?>
            </section>

            <section class="mb-5">
                <?php plantilla("crud", [
                    "id" => "marca",
                    "nombre_singular" => "Marca",
                    "nombre_plural" => "Marcas",
                    "modificar_ubicacion" => "parte izquierda",
                    "gestionable" => [
                        "Nombre",
                    ],
                    "instrucciones" => [
                        "Nombre de la Marca",
                    ]
                ]); ?>
            </section>

            <section class="mb-5">
                <?php plantilla("crud", [
                    "id" => "modelo",
                    "nombre_singular" => "modelo",
                    "nombre_plural" => "Modelos",
                    "modificar_ubicacion" => "parte izquierda",
                    "gestionable" => [
                        "Nombre",
                    ],
                    "instrucciones" => [
                        "Seleccionar una marca",
                        "Nombre del modelo",
                    ],
                ]); ?>
            </section>

            <section class="mb-5">
                <section>
                    <?php
                    $datos = [
                        "id" => "producto",
                        "nombre_singular" => "Producto",
                        "nombre_plural" => "Productos",

                        "gestionable" => [
                            "Foto del producto",
                            "Nombre",
                            "Descripción",
                            "Stock Actual",
                            "Stock Max / Stock Min",
                            "Serial",
                            "Clausula de garantia",
                            "Categoria",
                            "Precio",
                            "Estado"
                        ],
                        "instrucciones" => [
                            "Nombre del producto",
                            "Imagen del producto",
                            "Descripcion del producto",
                            "Seleccionar un modelo",
                            "Seleccionar el Stock Actual, Maximo y Minimo",
                            "Clausula de garantia",
                            "Seleccionar una categoria",
                            "Codigo serial",
                            "Precio",
                        ],
                    ];

                    plantilla("inicio", $datos);
                    plantilla("incluir", $datos);
                    ?>
                </section>

                <section class="mb-4">
                    <?php plantilla("estado", $datos); ?>
                </section>

                <section class="mb-4">
                    <?php plantilla("reporte", $datos); ?>
                </section>
            </section>

            <section class="mb-5">
                <?php plantilla("crud", [
                    "id" => "categoria",
                    "nombre_singular" => "Categoria",
                    "nombre_plural" => "Categorias",
                    "modificar_ubicacion" => "parte izquierda",
                    "modificar_extra" => "Debe haber como minimo una <strong>caracteristica</strong>",
                    "gestionable" => [
                        "Nombre",
                        "Caracteristicas",
                    ],
                    "instrucciones" => [
                        "Nombre de la categoria",
                        "Insertar al menos una caracteristica",
                    ],
                ]); ?>
            </section>
        </div>

        <div id="rol-administrador">
            <h1 class="fw-bold text-decoration-underline">Administradores</h1>

            <p>Sera capaz de acceder a las opciones del <strong>Usuario</strong> y del <strong>Despachador</strong>
                en conjunto con las siguientes opciones:</p>

            <section class="mb-5">
                <section>
                    <?php
                    $datos = [
                        "id" => "provedor",
                        "nombre_singular" => "Provedor",
                        "nombre_plural" => "Provedores",
                        "gestionable" => [
                            "Nombre",
                            "RIF",
                            "Nombre del proveedor",
                            "RIF del representante",
                            "Correo del proveedor",
                            "Dirección del proveedor",
                            "Telefono principal",
                            "Telefono secundario",
                            "Observación",
                            "Estado"
                        ],
                        "instrucciones" => [
                            "Nombre de la categoria",
                            "Insertar al menos una caracteristica",
                        ],
                    ];

                    plantilla("inicio", $datos);
                    # plantilla("incluir", $datos);
                    ?>
                </section>

                <section class="mb-4">
                    <?php plantilla("estado", $datos); ?>
                </section>
            </section>

            <section class="mb-5">
                <section>
                    <?php
                    $datos = [
                        "id" => "cliente",
                        "nombre_singular" => "Cliente",
                        "nombre_plural" => "Clientes",
                        "modificar_ubicacion" => "parte izquierda",
                        "reporte_boton" => "Compras",
                        "gestionable" => [
                            "Nombre del cliente",
                            "Cedula",
                            "Dirección",
                            "Teléfono",
                            "Correo",
                        ],
                        "instrucciones" => [
                            "Nombre de la categoria",
                            "Insertar al menos una caracteristica",
                        ],
                    ];

                    plantilla("crud", $datos);
                    ?>
                </section>

                <section class="mb-4">
                    <?php plantilla("reporte", $datos); ?>
                </section>
            </section>

            <section class="mb-5">
                <section>
                    <?php
                    $datos = [
                        "id" => "banco",
                        "nombre_singular" => "Cuenta Bancaria",
                        "nombre_plural" => "Cuentas Bancarias",
                        "modificar_ubicacion" => "parte izquierda",
                        "gestionable" => [
                            "Nombre del banco",
                            "Número de cuenta",
                            "RIF",
                            "Teléfono",
                            "Correo",
                            "Estatus",
                        ],
                        "instrucciones" => [
                            "Nombre del banco",
                            "Número de cuenta",
                            "RIF",
                            "Número de teléfono",
                            "Correo Electrónico",
                        ],
                    ];

                    plantilla("crud", $datos);
                    ?>
                </section>

                <section class="mb-4">
                    <?php plantilla("estado", $datos); ?>
                </section>
            </section>

            <section class="mb-5">
                <?php
                $datos = [
                    "id" => "usuario",
                    "nombre_singular" => "Usuario",
                    "nombre_plural" => "Usuarios",
                    "modificar_ubicacion" => "parte izquierda",
                    "gestionable" => [
                        "Nombre y Apellido",
                        "Correo",
                        "Usuario",
                        "Teléfono",
                        "Rol",
                        "Estatus",
                    ],
                    "instrucciones" => [
                        "Nombre de la persona",
                        "Apellido de la persona",
                        "Nombre de usuario",
                        "Número de teléfono",
                        "Correo electrónico",
                        "Seleccionar un rol de usuario",
                        "Contraseña",
                        "Confirmar su contraseña"
                    ],
                ];

                plantilla("crud", $datos);
                plantilla("reporte", $datos);
                ?>
            </section>

            <section class="mb-5">
                <?php
                $datos = [
                    "id" => "rol",
                    "nombre_singular" => "Rol",
                    "nombre_plural" => "Roles",
                    "modificar_ubicacion" => "parte izquierda",
                    "gestionable" => [
                        "Nombre",
                    ],
                ];

                plantilla("inicio", $datos);
                ?>
            </section>
        </div>
    </main>
</body>

</html>