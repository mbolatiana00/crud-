<!-- Register Modal -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="registerModalLabel">Créer un compte</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>

            <div class="modal-body">
                <form action="/register" method="POST">
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" name="nom" class="form-control" id="nom" placeholder="Nom" required>
                    </div>

                    <div class="mb-3">
                        <label for="prenom" class="form-label">Prénom</label>
                        <input type="text" name="prenom" class="form-control" id="prenom" placeholder="Prénom" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Adresse e-mail</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="ex: exemple@gmail.com" required>
                    </div>
                    <div class="mb-3">
                        <label for="adresse" class="form-label">lot</label>
                        <input type="text" name="adresse" class="form-control" id="adresse" placeholder="ex:|| R 4 ter" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Mot de passe" required>
                    </div>

                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirmer le mot de passe</label>
                        <input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="Confirmer le mot de passe" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">S'inscrire</button>
                </form>
            </div>

        </div>
    </div>
</div>