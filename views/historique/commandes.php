<div class="container">
    <div class="card-body">
        <?php if (empty($historiques)) : ?>
            <div class="alert alert-info m-3">historique vide</div>
        <?php else: ?>
            <table class="table table-bordered">
                <thead>
                    <h4>historique de votre commande</h4>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>nom du menu</th>
                        <th>table</th>
                        <th style="width: 40px">status commande</th>
                        <th>mode consommation</th>
                        <th>date </th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($historiques as $historique): ?>
                        <tr class="align-middle">
                            <td><?= $historique->getID() ?></td>
                            <td>Update software</td>
                            <td>
                               <?=$historique->getTableNumber() ?>
                            </td>
                            <td>
                                <?php
                                $statut = $historique->getStatut();
                                $class = 'badge bg-secondary'; // par défaut gris
                                if ($statut === 'pret') $class = 'badge bg-primary'; // bleu
                                elseif ($statut === 'en_preparation') $class = 'badge bg-success'; // vert
                                elseif ($statut === 'livre') $class = 'badge bg-secondary text-dark'; // jaune
                                elseif ($statut === 'en attente') $class = 'badge bg-warning text-dark'; // jaune
                                elseif ($statut === 'annuler') $class = 'badge bg-danger text-dark'; // jaune

                                ?>
                                <span class="<?= $class ?>"><?= ucfirst($statut) ?></span>
                            </td>
                            <td><?=$historique->getModeConsommation() ?></td>
                            <td><?= $historique->getDateCommande() ?></td>
                        </tr>


                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif ?>
    </div>
</div>