<h2>Liste des Paiements</h2>
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Commande</th>
            <th>Montant</th>
            <th>Méthode</th>
            <th>Date</th>
            <th>Statut</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($paiements as $paiement): ?>
            <tr>
                <td><?= $paiement->getId() ?></td>
                <td><?= $paiement->getCommandeId() ?></td>
                <td><?= $paiement->getAmount() ?> Ar</td>
                <td><?= ucfirst($paiement->getPaymentMethod()) ?></td>
                <td><?= $paiement->getPaymentDate() ?></td>
                <td><?= ucfirst($paiement->getStatut()) ?></td>
                <td>
                    <?php if ($paiement->getStatut() === 'en_attente'): ?>
                        <a href="/paiement/valider/<?= $paiement->getId() ?>" class="btn btn-success btn-sm">Valider</a>
                        <a href="/paiement/rejeter/<?= $paiement->getId() ?>" class="btn btn-danger btn-sm">Rejeter</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>