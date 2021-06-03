<!-- Main Sidebar Container -->
<aside class="main-sidebar elevation-4 sidebar-light-success">
    <!-- Brand Logo -->
    <a href="<?= base_url('admin/home') ?>" class="brand-link">
        <span class="brand-text font-weight-light main-sidebar-logo-holder">
            <img src="<?= base_url('assets/panel') ?>/dist/img/logo.png" alt="<?= $site_title ?>">
        </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <?php if (getenv('cms.config.form_management') == 'true') : ?>
                    <li class="nav-item">
                        <a href="<?= base_url(route_to('form_groups')) ?>" class="nav-link <?= $active_menu == 'form_groups' ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>
                                Form Groups
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url(route_to('form_fields')) ?>" class="nav-link <?= $active_menu == 'form_fields' ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-clipboard-list"></i>
                            <p>
                                Form Fields
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url(route_to('content_groups')) ?>" class="nav-link <?= $active_menu == 'content_groups' ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-layer-group"></i>
                            <p>
                                Content Groups
                            </p>
                        </a>
                    </li>
                <?php endif; ?>
                <?= view_cell('\App\Libraries\Sidebar::content_groups') ?>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>