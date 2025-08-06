<!-- views/admin/admin_add_user.php -->
<h2>Ajouter un utilisateur</h2>

<form method="POST" action="/admin/store">
    <div class="mb-3">
        <label>Nom</label>
        <input type="text" name="nom" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Prénom</label>
        <input type="text" name="prenom" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Mot de passe</label>
        <input type="password" name="password" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Rôle</label>
        <select name="role" class="form-control">
            <option value="client">Client</option>
            <option value="admin">Admin</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Ajouter</button>
</form>