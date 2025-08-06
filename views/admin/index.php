<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h4 class="mt-4">Gestion des commande d'utilisateur</h4>
            </div><!-- /.col -->

        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <?php if (isset($_SESSION['flash'])): ?>
            <div class="alert alert-<?= $_SESSION['flash']['type'] ?? 'info' ?> alert-dismissible fade show" role="alert">
                <?= $_SESSION['flash']['message'] ?? '' ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>


        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Liste des utilisateurs</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="usersTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Email</th>
                                    <th>Rôle</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($user->getPrenom() . ' ' . $user->getNom()) ?></td>
                                        <td><?= htmlspecialchars($user->getEmail()) ?></td>
                                        <td>
                                            <span class="badge 
                                                <?= $user->getRole() === 'admin' ? 'bg-danger' : ($user->getRole() === 'serveur' ? 'bg-primary' : ($user->getRole() === 'cuisinier' ? 'bg-success' : 'bg-secondary')) ?>">
                                                <?= htmlspecialchars($user->getRole()) ?>
                                            </span>
                                        </td>
                                        <td class="d-flex">
                                            <form action="/admin/users/<?= $user->getId() ?>/role" method="POST" class="mr-2">
                                                <div class="input-group input-group-sm">
                                                    <select name="role" class="form-control">
                                                        <?php foreach (['client', 'serveur', 'cuisinier', 'admin'] as $role): ?>
                                                            <option value="<?= $role ?>" <?= $user->getRole() === $role ? 'selected' : '' ?>>
                                                                <?= ucfirst($role) ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <div class="input-group-append">
                                                        <button type="submit" class="btn btn-info">Mettre à jour</button>
                                                    </div>
                                                </div>
                                            </form>
                                            <?php if ($_SESSION['user']['id'] !== $user->getId()): ?>
                                                <form action="/admin/users/<?= $user->getId() ?>/delete" method="POST" onsubmit="return confirm('Confirmer la suppression ?');">
                                                    <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                                                </form>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Ajouter un nouvel utilisateur</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form action="/admin/users/store" method="POST">
                            <div class="form-group">
                                <label for="nom">Nom</label>
                                <input type="text" class="form-control" id="nom" name="nom" required>
                            </div>
                            <div class="form-group">
                                <label for="prenom">Prénom</label>
                                <input type="text" class="form-control" id="prenom" name="prenom" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Mot de passe</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="form-group">
                                <label for="role">Rôle</label>
                                <select class="form-control" id="role" name="role" required>
                                    <option value="client">Client</option>
                                    <option value="serveur">Serveur</option>
                                    <option value="cuisinier">Cuisinier</option>
                                    <option value="admin">Administrateur</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Ajouter</button>
                        </form>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Commandes </h3>
                        <div class="card-tools">
                            <span class="badge badge-danger"><?= count($commandes) ?> en attente</span>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <?php if (empty($commandes)): ?>
                            <div class="alert alert-info m-3">Aucune commande en attente.</div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Client</th>
                                            <th>Montant</th>
                                            <th>Statut</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($commandes as $cmd): ?>
                                            <tr>
                                                <td>#<?= $cmd->getId() ?></td>
                                                <td><?= var_dump($cmd->getClientEmail()) ?></td>
                                                <td><?= number_format($cmd->getTotal(), 2) ?> €</td>
                                                <td>
                                                    <?php
                                                    $statut = $cmd->getStatut();
                                                    $class = 'badge bg-secondary';
                                                    if ($statut === 'pret') $class = 'badge bg-primary';
                                                    elseif ($statut === 'en_preparation') $class = 'badge bg-success'; 
                                                    elseif ($statut === 'livre') $class = 'badge bg-secondary text-dark'; 
                                                    elseif ($statut === 'en attente') $class = 'badge bg-warning text-dark'; 
                                                    elseif ($statut === 'annuler') $class = 'badge bg-danger text-dark'; 
                                                    ?>
                                                    <span class="<?= $class ?>"><?= ucfirst($statut) ?></span>
                                                </td>
                                                <td>
                                                    <div class="btn-group me-2">
                                                        <div class="me-2">
                                                            <form action="/admin/commandes/<?= $cmd->getId() ?>/valider" method="POST">
                                                                <button type="submit" class="btn btn-success btn-sm">Valider</button>
                                                            </form>
                                                        </div>

                                                        <div class="me-2">
                                                            <form action="/admin/commandes/<?= $cmd->getId() ?>/valider" method="POST">
                                                                <button type="submit" class="btn btn-warning btn-sm">preparation</button>
                                                            </form>
                                                        </div>
                                                        <div class="me-2">
                                                            <form action="/admin/commandes/<?= $cmd->getId() ?>/valider" method="POST">
                                                                <button type="submit" class="btn btn-primary btn-sm">livré</button>
                                                            </form>
                                                        </div>
                                                        <form action="/admin/commandes/<?= $cmd->getId() ?>/valider" method="POST">
                                                            <button type="submit" class="btn btn-danger btn-sm">annuler</button>
                                                        </form>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

<!-- DataTables JS -->
<script>
    $(function() {
        $('#usersTable').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/French.json"
            }
        });
    });
</script>