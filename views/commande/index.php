<div class="container mt-5">
    <h2>Validation de commande</h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif ?>

    <div class="row">
        <div class="col-md-8">
            <form method="post" action="/commande/valider">
                <div class="card mb-4">
                    <div class="card-header">Informations client</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nom complet*</label>
                                <input type="text" name="nom" class="form-control"
                                    value="<?= $form_data['nom'] ?? $user['username'] ?? '' ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email*</label>
                                <input type="email" name="email" class="form-control"
                                    value="<?= $form_data['email'] ?? $user['email'] ?? '' ?>" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Téléphone</label>
                            <input type="tel" name="telephone" class="form-control"
                                value="<?= $form_data['telephone'] ?? '' ?>">
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">Options de livraison</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Mode de consommation*</label>
                            <select name="mode_consommation" class="form-select" id="modeSelect" required>
                                <option value="sur_place" <?= ($form_data['mode_consommation'] ?? '') === 'sur_place' ? 'selected' : '' ?>>Sur place</option>
                                <option value="a_emporter" <?= ($form_data['mode_consommation'] ?? '') === 'a_emporter' ? 'selected' : '' ?>>À emporter</option>
                                <option value="livraison" <?= ($form_data['mode_consommation'] ?? '') === 'livraison' ? 'selected' : '' ?>>Livraison</option>
                            </select>
                        </div>

                        <div id="tableField" class="mb-3" style="display: <?= ($form_data['mode_consommation'] ?? '') === 'sur_place' ? 'block' : 'none' ?>">
                            <label class="form-label">Numéro de table</label>
                            <input type="text" name="table_number" class="form-control"
                                value="<?= $form_data['table_number'] ?? '' ?>">
                        </div>

                        <div id="addressField" class="mb-3" style="display: <?= ($form_data['mode_consommation'] ?? '') === 'livraison' ? 'block' : 'none' ?>">
                            <label class="form-label">Adresse de livraison</label>
                            <textarea name="adresse" class="form-control"><?= $form_data['adresse'] ?? '' ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">Commentaires</div>
                    <div class="card-body">
                        <textarea name="commentaires" class="form-control"><?= $form_data['commentaires'] ?? '' ?></textarea>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-lg">Confirmer la commande</button>
            </form>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Récapitulatif</div>
                <div class="card-body">
                    <table class="table">
                        <tbody>
                            <?php foreach ($items as $item): ?>
                                <tr>
                                    <td><?= $item->getProductName() ?> × <?= $item->getQuantity() ?></td>
                                    <td><?= number_format($item->getProductPrice() * $item->getQuantity(), 2, ',', ' ') ?> €</td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Total</th>
                                <th><?= number_format($total, 2, ',', ' ') ?> €</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('modeSelect').addEventListener('change', function() {
        document.getElementById('tableField').style.display = this.value === 'sur_place' ? 'block' : 'none';
        document.getElementById('addressField').style.display = this.value === 'livraison' ? 'block' : 'none';
    });
</script>