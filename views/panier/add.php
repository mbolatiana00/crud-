<h2>Ajouter au panier</h2>

<form method="POST" action="/panier/add">
    <div class="mb-3">
        <label for="product_id" class="form-label">ID du produit :</label>
        <input type="number" name="product_id" id="product_id" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="quantity" class="form-label">Quantité :</label>
        <input type="number" name="quantity" id="quantity" value="1" class="form-control" min="1" required>
    </div>

    <button type="submit" class="btn btn-primary">Ajouter</button>
</form>