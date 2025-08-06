<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0">Commande #<?= $commande['commande']->getId() ?></h1>
        <a href="/admin/commandes" class="d-none d-sm-inline-block btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Détails des articles -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Articles commandés</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Produit</th>
                                    <th>Prix unitaire</th>
                                    <th>Quantité</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($commande['items'] as $item): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($item['name']) ?></td>
                                        <td><?= number_format($item['prix_unitaire'], 2, ',', ' ') ?> €</td>
                                        <td><?= $item['quantity'] ?></td>
                                        <td><?= number_format($item['prix_unitaire'] * $item['quantity'], 2, ',', ' ') ?> €</td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3">Total commande</th>
                                    <th><?= number_format($commande['commande']->getTotal(), 2, ',', ' ') ?> €</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Informations client -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Client</h6>
                </div>
                <div class="card-body">
                    <?php if ($commande['commande']->username): ?>
                        <p><strong>Nom :</strong> <?= htmlspecialchars($commande['commande']->username) ?></p>
                        <p><strong>Email :</strong> <?= htmlspecialchars($commande['commande']->email ?? 'Non renseigné') ?></p>
                    <?php else: ?>
                        <p>Commande anonyme</p>
                    <?php endif ?>
                </div>
            </div>

            <!-- Informations livraison -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Livraison</h6>
                </div>
                <div class="card-body">
                    <p><strong>Mode :</strong> <?= $this->getModeLabel($commande['commande']->getModeConsommation()) ?></p>

                    <?php if ($commande['commande']->getModeConsommation() === 'sur_place'): ?>
                        <p><strong>Table :</strong> <?= $commande['commande']->getTableNumber() ?? 'Non spécifiée' ?></p>
                    <?php elseif ($commande['commande']->getModeConsommation() === 'livraison'): ?>
                        <p><strong>Adresse :</strong> <?= nl2br(htmlspecialchars($commande['commande']->getAdresseLivraison())) ?></p>
                    <?php endif ?>
                </div>
            </div>

            <!-- Gestion du statut -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Statut de la commande</h6>
                </div>
                <div class="card-body">
                    <form method="post" action="/admin/commandes/<?= $commande['commande']->getId() ?>/statut">
                        <div class="form-group">
                            <select name="statut" class="form-control">
                                <option value="en_attente" <?= $commande['commande']->getStatut() === 'en_attente' ? 'selected' : '' ?>>En attente</option>
                                <option value="preparation" <?= $commande['commande']->getStatut() === 'preparation' ? 'selected' : '' ?>>En préparation</option>
                                <option value="pret" <?= $commande['commande']->getStatut() === 'pret' ? 'selected' : '' ?>>Prête</option>
                                <option value="livre" <?= $commande['commande']->getStatut() === 'livre' ? 'selected' : '' ?>>Livrée</option>
                                <option value="annule" <?= $commande['commande']->getStatut() === 'annule' ? 'selected' : '' ?>>Annulée</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Mettre à jour</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>