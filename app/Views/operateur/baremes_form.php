<!DOCTYPE html>
<html lang="fr" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? ((isset($bareme) ? 'Modifier' : 'Ajouter') . ' un barème - MOMO PAY')) ?></title>

    <link rel="stylesheet" href="<?= base_url('css/operateur/op-sidebar.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/operateur/op-dashboard.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/operateur/op-form.css') ?>">
</head>
<body>

    <?= view('partials/sidebar_operateur', [
        'currentPage' => $currentPage ?? uri_string(),
    ]) ?>

    <div class="op-app">
        <header class="op-page-header">
            <div class="op-page-header-text">
                <span class="op-page-kicker">Configuration</span>
                <h1><?= isset($bareme) ? 'Modifier un barème' : 'Ajouter un barème' ?></h1>
                <p>
                    <?= isset($bareme)
                        ? 'Mettez à jour les tranches et frais de ce barème.'
                        : 'Créez une nouvelle tranche de frais pour un type d\'opération.' ?>
                </p>
            </div>

            <a href="<?= base_url('operateur/types-baremes') ?>" class="op-btn op-btn-ghost">
                ← Retour à la liste
            </a>
        </header>

        <main class="op-main">
            <section class="op-panel op-form-card">
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="op-alert op-alert-error" role="alert">
                        <?= esc(session()->getFlashdata('error')) ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('success')): ?>
                    <div class="op-alert op-alert-success" role="alert">
                        <?= esc(session()->getFlashdata('success')) ?>
                    </div>
                <?php endif; ?>

                <?php if (session('errors')): ?>
                    <div class="op-alert op-alert-error" role="alert">
                        <ul class="op-error-list">
                            <?php foreach (session('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form
                    method="post"
                    action="<?= base_url('operateur/types-baremes' . (isset($bareme) ? '/' . $bareme['id'] : '')) ?>"
                    class="op-form"
                    novalidate
                >
                    <?= csrf_field() ?>

                    <?php if (isset($bareme)): ?>
                        <input type="hidden" name="_method" value="PUT">
                    <?php endif; ?>

                    <div class="op-form-grid">
                        <div class="op-form-group op-form-group-full">
                            <label for="type_operation_id">Type d'opération</label>
                            <div class="op-input-wrap">
                                <select id="type_operation_id" name="type_operation_id" required>
                                    <option value="">Sélectionner un type</option>
                                    <?php foreach ($types as $t): ?>
                                        <option
                                            value="<?= esc($t['id']) ?>"
                                            <?= (isset($bareme) && $bareme['type_operation_id'] == $t['id']) ? 'selected' : '' ?>
                                        >
                                            <?= esc(ucfirst($t['libelle'])) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="op-form-group">
                            <label for="montant_min">Montant min (FCFA)</label>
                            <div class="op-input-wrap">
                                <input
                                    type="number"
                                    id="montant_min"
                                    name="montant_min"
                                    step="0.01"
                                    min="0"
                                    placeholder="Ex: 1000"
                                    value="<?= esc(old('montant_min', $bareme['montant_min'] ?? '')) ?>"
                                    required
                                >
                            </div>
                        </div>

                        <div class="op-form-group">
                            <label for="montant_max">Montant max (FCFA)</label>
                            <div class="op-input-wrap">
                                <input
                                    type="number"
                                    id="montant_max"
                                    name="montant_max"
                                    step="0.01"
                                    min="0"
                                    placeholder="Ex: 50000"
                                    value="<?= esc(old('montant_max', $bareme['montant_max'] ?? '')) ?>"
                                    required
                                >
                            </div>
                        </div>

                        <div class="op-form-group">
                            <label for="frais">Frais (FCFA)</label>
                            <div class="op-input-wrap">
                                <input
                                    type="number"
                                    id="frais"
                                    name="frais"
                                    step="0.01"
                                    min="0"
                                    placeholder="Ex: 250"
                                    value="<?= esc(old('frais', $bareme['frais'] ?? '')) ?>"
                                    required
                                >
                            </div>
                        </div>
                    </div>

                    <div class="op-form-actions">
                        <button type="submit" class="op-btn op-btn-primary">
                            <?= isset($bareme) ? 'Mettre à jour' : 'Enregistrer' ?>
                        </button>

                        <a href="<?= base_url('operateur/types-baremes') ?>" class="op-btn op-btn-ghost">
                            Annuler
                        </a>
                    </div>
                </form>
            </section>
        </main>
    </div>

    <script src="<?= base_url('js/operateur/theme.js') ?>"></script>
</body>
</html>