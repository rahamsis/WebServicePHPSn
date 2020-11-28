<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="image/usuario.png" class="img-circle" alt="Usuario">
            </div>

            <div class="pull-left info">
                <p><?php echo $_SESSION["RolName"] ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Buscar...">
                <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat">
                        <i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">Opciones</li>
            <li>
                <a href="./index.php"><i class="fa fa-home"></i> <span>Dashboard</span></a>
            </li>
            <li>
                <a href="./ventas.php"><i class="fa fa-sitemap"></i> <span>Ventas</span></a>
            </li>
            <li>
                <a href="./productos.php"><i class="fa fa-archive"></i> <span>Productos</span></a>
            </li>
            <li>
                <a href="./inventario.php"><i class="fa fa-th-large"></i> <span>Inventario</span></a>
            </li>
            <li>
                <a href="./movimiento.php"><i class="fa fa-arrows-h"></i> <span>Movimientos</span></a>
            </li>
            <li>
                <a href="./empresa.php"><i class="fa  fa-building-o"></i> <span>Empresa</span></a>
            </li>

    </section>
    <!-- /.sidebar -->
</aside>