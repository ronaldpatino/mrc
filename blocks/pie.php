<!--footer-->
<div class='container margen-container-pie'>
    <div id='footer' class='row-fluid'>
        <div class="span6">
            <div class='navbar-pie nomargen-abajo'>
                <div class='navbar-inner-pie nav-collapse-pie' style="height: auto;">
                    <ul class="nav-pie">
                        <li><a href="#">Agencias</a></li>
                        <li><a href="#">Quienes Somos</a></li>
                        <li><a href="#">Contacto</a></li>
                        <li><a href="#">Clasificados</a></li>
                        <li><a href="#">Hemeroteca</a></li>
                    </ul>
                </div>
            </div>
            <p class="direccion">
                Diario El Mercurio Cuenca - Ecuador.<br/>
                Matriz: Conmutador: (593) 7 4095682 Fax: (593) 7 4095685<br/>
                Av. Las Am&eacute;ricas (Sector El Arenal) Casilla: 60.<br/>
                Diario El Mercurio 2013 &copy; Todos los Derechos Reservados
            </p>
        </div>
        <div class="span6">
            <?php if ( dynamic_sidebar('publicidadpie') ) : else : endif; ?>
        </div>
    </div>
</div>
<!-- Fin footer-->
