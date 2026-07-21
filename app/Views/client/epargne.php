<!DOCTYPE html>
<html lang="fr" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Configuration epargne - MOMO PAY') ?></title>

   
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
                <h1>Configuration epargne</h1>
                <p>Définissez le pourcentage appliqué aux opérations externes.</p>
            </div>
        </header>

        <main class="op-main">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="op-alert op-alert-success" role="alert">
                    <?= esc(session()->getFlashdata('success')) ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="op-alert op-alert-error" role="alert">
                    <?= esc(session()->getFlashdata('error')) ?>
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

            <section class="op-stats-grid op-stats-grid-single">
                <article class="op-stat-card op-stat-card-highlight">
                    <span class="op-stat-label">Taux actuel</span>
                    <strong class="op-stat-value">
                        <?= esc(number_format((float) ($commission['pourcentage'] ?? 0), 2, ',', ' ')) ?> %
                    </strong>
                    <span class="op-stat-meta">Commission externe en vigueur</span>
                </article>
            </section>

            <section class="op-panel op-form-card">
                <div class="op-panel-head">
                    <div>
                        <h2>Modifier le taux</h2>
                        <p>Saisissez un nouveau pourcentage de commission.</p>
                    </div>
                </div>

                <form
                    method="post"
                    action="<?= base_url('operateur/commission/update') ?>"
                    class="op-form"
                    novalidate
                >
                    <?= csrf_field() ?>

                    <div class="op-form-grid">
                        <div class="op-form-group op-form-group-full">
                            <label for="pourcentage">Nouveau pourcentage (%)</label>
                            <div class="op-input-wrap">
                                <input
                                    type="number"
                                    id="pourcentage"
                                    name="pourcentage"
                                    step="0.01"
                                    min="0"
                                    max="100"
                                    placeholder="Ex: 2.50"
                                    value="<?= esc(old('pourcentage', $commission['pourcentage'] ?? '')) ?>"
                                    required
                                >
                            </div>
                            <small class="op-form-help">Valeur entre 0 et 100.</small>
                        </div>
                    </div>

                    <div class="op-form-actions">
                        <button type="submit" class="op-btn op-btn-primary">
                            Enregistrer
                        </button>
                    </div>
                </form>
            </section>
        </main>
    </div>

    <script src="<?= base_url('js/operateur/theme.js') ?>"></script>
</body>
</html>