<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $site_title ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="<?=base_url('assets/panel/dist/img/favicon.ico')?>" rel="shortcut icon" type="image/png">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('assets/panel') ?>/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="<?= base_url('assets/panel') ?>/plugins/daterangepicker/daterangepicker.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="<?= base_url('assets/panel') ?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?= base_url('assets/panel') ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/panel') ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="<?= base_url('assets/panel') ?>/plugins/toastr/toastr.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?= base_url('assets/panel') ?>/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/panel') ?>/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Summernote -->
    <link rel="stylesheet" href="<?= base_url('assets/panel') ?>/plugins/summernote/summernote-bs4.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="<?= base_url('assets/panel') ?>/dist/css/adminlte.min.css">
    <!-- Custom panel style sheet -->
    <link rel="stylesheet" href="<?= base_url('assets/panel') ?>/dist/css/panel.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <?= $this->renderSection('<<style>>') ?>
    <script>
        var csrf_token = '<?= csrf_token() ?>';
        var csrf_hash = '<?= csrf_hash() ?>';
    </script>
</head>

<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-user"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header"><?= $user->first_name . ' ' . $user->last_name ?></span>
                        <div class="dropdown-divider"></div>
                        <a href="<?= base_url(route_to('profile')) ?>" class="dropdown-item">
                            <i class="fas fa-id-card mr-2"></i> Profile
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="<?= base_url(route_to('change_password')) ?>" class="dropdown-item">
                            <i class="fas fa-key mr-2"></i> Change Password
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="<?= base_url(route_to('settings')) ?>" class="dropdown-item">
                            <i class="fas fa-cogs mr-2"></i> Settings
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="<?= base_url(route_to('admin/logout')) ?>" class="dropdown-item">
                            <i class="fas fa-sign-out-alt mr-2"></i> Sign Out
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->
        <?= $this->include('admin/layouts/sidebar') ?>
        <?= $this->renderSection('<<content>>') ?>
        <footer class="main-footer">
            <strong>Copyright &copy; <?= date('Y') ?> <a href="<?= base_url('home') ?>"></a>.</strong> All rights
            reserved.
        </footer>
    </div>
    <!-- ./wrapper -->
    <div class="modal fade" id="modal-confirm">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirm</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="modal-confirm-msg"></p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <a href="#" class="btn btn-primary" id="modal-confirm-btn">Confirm</a>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <?= $this->include('admin/layouts/script') ?>
</body>

</html>