<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<?php if (isset($_SESSION['flash'])): ?>
    <div class="alert alert-<?= $_SESSION['flash']['type'] ?>">
        <?= htmlspecialchars($_SESSION['flash']['message']) ?>
    </div>
    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>

<div class="container my-5" style="max-width: 500px;">
    <h2 class="mb-4 text-center">Connexion</h2>

    <form action="/login" method="POST">
        <div class="mb-3">
            <label for="email" class="form-label">Adresse e-mail</label>
            <input type="email" name="email" class="form-control" id="email" placeholder="ex: exemple@gmail.com" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" name="password" class="form-control" id="password" placeholder="Mot de passe" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Se connecter</button>
    </form>

    <div class="text-center mt-3">
        <a href="/register">Pas encore de compte ? S'inscrire</a>
    </div>
</div>