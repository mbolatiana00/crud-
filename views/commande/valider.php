<div class="container mt-5">
    <h2>Finaliser votre commande</h2>

    <form method="post" action="/commande/valider" class="mt-4">
        <!-- Mode de consommation -->
        <div class="mb-3">
            <label class="form-label">Mode de consommation</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="mode_consommation"
                    id="sur_place" value="sur_place" checked>
                <label class="form-check-label" for="sur_place">Sur place</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="mode_consommation"
                    id="a_emporter" value="a_emporter">
                <label class="form-check-label" for="a_emporter">À emporter</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="mode_consommation"
                    id="livraison" value="livraison">
                <label class="form-check-label" for="livraison">Livraison</label>
            </div>
        </div>

        <!-- Numéro de table (visible seulement pour "sur place") -->
        <div class="mb-3" id="table_number_group">
            <label for="table_number" class="form-label">Numéro de table</label>
            <input type="text" class="form-control" name="table_number" id="table_number">
        </div>

        <!-- Adresse de livraison (visible seulement pour "livraison") -->
        <div class="mb-3 d-none" id="adresse_group">
            <label for="adresse_livraison" class="form-label">Adresse de livraison</label>
            <textarea class="form-control" name="adresse_livraison" id="adresse_livraison" rows="3"></textarea>
        </div>

        <!-- Récapitulatif du panier -->
        <div class="mb-4">
            <h4>Votre commande</h4>
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
                    <?php foreach ($panier_items as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item->getProductName()) ?></td>
                            <td><?= number_format($item->getProductPrice(), 2, ',', ' ') ?> €</td>
                            <td><?= $item->getQuantity() ?></td>
                            <td><?= number_format($item->getProductPrice() * $item->getQuantity(), 2, ',', ' ') ?> €</td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3">Total général</th>
                        <th><?= number_format($total, 2, ',', ' ') ?> €</th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <button type="submit" class="btn btn-primary btn-lg">Confirmer la commande</button>
    </form>
</div>

<script>
   
    document.querySelectorAll('input[name="mode_consommation"]').forEach(radio => {
        radio.addEventListener('change', function() {
            document.getElementById('table_number_group').classList.toggle('d-none', this.value !== 'sur_place');
            document.getElementById('adresse_group').classList.toggle('d-none', this.value !== 'livraison');
        });
    });
</script>