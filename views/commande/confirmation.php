
<div class="container mt-5">
    <div class="card text-center">
        <div class="card-body py-5">
            <h1 class="text-success mb-4">✔</h1>
            <h2 class="card-title">Commande confirmée !</h2>
          
            <p class="card-text lead">Votre commande # <?=$id?> a été enregistrée.</p>
         
            <div class="mt-4">
                <a href="/" class="btn btn-primary">Retour à l'accueil</a>
                <a href="/commande/confirmation/<?=$id ?>" class="btn btn-outline-secondary ms-2">
                    Voir mes commandes
                </a>
            </div>
        </div>
    </div>
</div>
