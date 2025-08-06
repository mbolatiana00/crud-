<div class="container py-5">
    <div class="row">
        <div class="col-md-6">
            <h1><?= htmlspecialchars($product->getName()) ?></h1>
            <p class="text-muted"><?= htmlspecialchars($product->getCategory()) ?></p>
            <hr>
            <p><?= nl2br(htmlspecialchars($product->getDescription())) ?></p>

            <div class="d-flex align-items-center mt-4">
                <h3 class="mb-0 me-3"><?= number_format($product->getPrice(), 2) ?> €</h3>

                <div class="input-group me-3" style="width: 120px;">
                    <button class="btn btn-outline-secondary minus-btn" type="button">-</button>
                    <input type="number" class="form-control text-center quantity-input" value="1" min="1">
                    <button class="btn btn-outline-secondary plus-btn" type="button">+</button>
                </div>

                <button class="btn btn-primary add-to-cart" data-id="<?= $product->getId() ?>">
                    <i class="bi bi-cart-plus"></i> Ajouter au panier
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Gestion des quantités
    document.querySelector('.minus-btn').addEventListener('click', function() {
        const input = this.nextElementSibling;
        if (parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
        }
    });

    document.querySelector('.plus-btn').addEventListener('click', function() {
        const input = this.previousElementSibling;
        input.value = parseInt(input.value) + 1;
    });

    // Ajout au panier via AJAX
    document.querySelector('.add-to-cart').addEventListener('click', function() {
        const productId = this.dataset.id;
        const quantity = document.querySelector('.quantity-input').value;

        fetch('/panier/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `product_id=${productId}&quantity=${quantity}`
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erreur lors de l\'ajout au panier');
                }
                return fetch('/panier/count');
            })
            .then(res => res.json())
            .then(data => {
                document.getElementById('cart-count').innerText = data.count;
                alert('Produit ajouté au panier !');
            })
            .catch(err => {
                console.error(err);
                alert("Erreur lors de l'ajout au panier.");
            });
    });
</script>