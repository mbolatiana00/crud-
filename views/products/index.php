<section id="menu" class="menu section mt-0">

    <div class="container-fluid section-title" data-aos="fade-up">
        
        <p><span></span> <span class="description-title">resto Menu</span></p>
    </div>

    <div class="container" data-aos="fade-up" data-aos-delay="100">

        <?php if (!empty($products)): ?>

            <?php
            $categories = [];
            foreach ($products as $product) {
                $cat = $product->getCategory();
                if (!isset($categories[$cat])) {
                    $categories[$cat] = [];
                }
                $categories[$cat][] = $product;
            }

            $categoryKeys = array_keys($categories);
            ?>


            <ul class="nav nav-tabs d-flex justify-content-center mb-4">
                <?php foreach ($categoryKeys as $index => $category): ?>
                    <li class="nav-item">
                        <a class="nav-link <?= $index === 0 ? 'active show' : '' ?>" data-bs-toggle="tab" href="#tab-<?= strtolower(str_replace(' ', '-', $category)) ?>">
                            <h4><?= htmlspecialchars($category) ?></h4>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>


            <div class="tab-content" data-aos="fade-up" data-aos-delay="200">
                <?php foreach ($categories as $category => $productsInCategory): ?>
                    <div class="tab-pane fade <?= ($category === $categoryKeys[0]) ? 'active show' : '' ?>" id="tab-<?= strtolower(str_replace(' ', '-', $category)) ?>">

                        <div class="tab-header text-center mb-4">
                            <p>Menu</p>
                            <h3><?= htmlspecialchars($category) ?></h3>
                        </div>

                        <div class="row gy-4">
                            <?php foreach ($productsInCategory as $product): ?>
                                <div class="col-lg-4 menu-item">


                                    <h5><?= htmlspecialchars($product->getName()) ?></h5>
                                    <p class="ingredients">
                                        <?= nl2br(htmlspecialchars($product->getDescription())) ?>
                                    </p>
                                    <p class="price text-success fw-bold">
                                        <?= number_format($product->getPrice(), 2) ?> €
                                    </p>
                                    <a href="/products/<?= urlencode($product->getId()) ?>" class="btn btn-primary mt-2">
                                        Voir détails
                                    </a>
                                   

                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php else: ?>
            <div class="alert alert-warning m-5 text-center">
                <i class="bi bi-exclamation-triangle"></i>
                Aucun produit n'est disponible pour le moment.
            </div>
        <?php endif; ?>

    </div>
</section>