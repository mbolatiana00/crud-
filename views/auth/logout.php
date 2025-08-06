<style>
    .container {
        max-width: 800px;
        margin: 0 auto;
    }

    h2 {
        color: #2c3e50;
        font-weight: 600;
        margin-bottom: 30px;
        padding-bottom: 10px;
        border-bottom: 2px solid #f8f9fa;
    }

    .list-group {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .list-group-item {
        padding: 20px;
        border-left: none;
        border-right: none;
        display: flex;
        align-items: center;
        transition: all 0.3s ease;
    }

    .list-group-item:hover {
        background-color: #f8f9fa;
    }

    .list-group-item div:first-child {
        flex: 1;
        padding-right: 20px;
    }

    .list-group-item h5 {
        color: #3498db;
        font-size: 1.1rem;
        margin-bottom: 5px;
    }

    .list-group-item p {
        color: #7f8c8d;
        font-size: 0.9rem;
        margin-bottom: 5px;
    }

    .list-group-item small {
        color: #95a5a6;
        font-size: 0.85rem;
    }

    .fw-bold {
        color: #2c3e50;
        font-size: 1.1rem;
        min-width: 100px;
        text-align: right;
    }

    .btn-danger {
        background-color: #e74c3c;
        border: none;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .btn-danger:hover {
        background-color: #c0392b;
        transform: scale(1.05);
    }

    .bi-trash-fill {
        font-size: 1rem;
    }

    /* Message panier vide */
    .empty-cart {
        text-align: center;
        padding: 50px 20px;
        background-color: #f8f9fa;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .empty-cart i {
        font-size: 3rem;
        color: #bdc3c7;
        margin-bottom: 20px;
    }

    .empty-cart h3 {
        color: #7f8c8d;
        margin-bottom: 15px;
    }
</style>

<div class="container py-5">
    <div class=" d-flex justify-content-between">
        <div>
            <h2>Votre panier</h2>
        </div>
        <div>
            <form action="/panier/vider" method="post" onsubmit="return confirm(' ?');">
                <button type="submit" class="btn btn-warning mb-3">🧹 Vider le panier</button>
            </form>

        </div>
    </div>
        <div class="empty-cart">
            <i class="bi bi-cart-x"></i>
            <h3>Votre panier est vide</h3>
            <p>Parcourez nos produits et ajoutez des articles à votre panier</p>
            <a href="/" class="btn btn-outline-primary">Voir les produits</a>
        </div>
</div>