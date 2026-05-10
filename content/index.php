<?php $meta = [
    'title' => 'Wordless',
]; ?>

<div class="splash">
    <div class="splash__logo">
         <img src="<?= img('logo.png') ?>" alt="Wordless" height="96">
    </div>
    <p class="splash__tagline">Pure PHP. No database. Just Magic.</p>
    <div class="splash__langs">
        <a class="btn btn--primary" href="<?= route('index', 'en') ?>">English</a>
        <a class="btn btn--outline" href="<?= route('index', 'es') ?>">Espa&ntilde;ol</a>
    </div>
</div>
