<?php
/**
 * Template Part: FAQ Section
 */
$faqs = [
    [
        'q' => 'Comment obtenir un devis personnalisé ?',
        'a' => 'Il vous suffit de remplir notre formulaire en ligne sur la page Devis ou de nous appeler directement au +33 06 44 07 28 80. Un conseiller vous recontacte sous 24h avec une proposition personnalisée. Un conseiller vous contactera dans les 24h pour vous proposer un devis adapté à vos besoins.',
    ],
    [
        'q' => 'Utilisez-vous vos propres produits de nettoyage ?',
        'a' => 'Oui, TCP Inter fournit tous les produits et équipements professionnels nécessaires à l\'intervention. Nous utilisons des produits certifiés éco-responsables, efficaces et sans danger pour vos espaces et vos occupants.',
    ],
    [
        'q' => 'Intervenez-vous le week-end ?',
        'a' => 'Oui, nous proposons des créneaux du lundi au samedi. Pour les interventions d\'urgence ou les remises en état après chantier, nous sommes joignables 7j/7. Contactez-nous pour organiser une prestation selon vos disponibilités.',
    ],
    [
        'q' => 'Quelle est votre politique éco-responsable ?',
        'a' => 'TCP Inter s\'engage à réduire l\'impact environnemental de ses activités : produits biodégradables, dosage précis pour limiter les déchets, formation continue de nos agents aux bonnes pratiques écologiques, et optimisation des déplacements pour réduire notre empreinte carbone.',
    ],
    [
        'q' => 'Êtes-vous assurés et quel est votre garantie de qualité ?',
        'a' => 'Oui, TCP Inter dispose d\'une assurance responsabilité civile professionnelle. En cas d\'insatisfaction, nous intervenons de nouveau gratuitement pour corriger le travail. Votre satisfaction est notre priorité absolue.',
    ],
];
?>

<section class="section" id="faq" aria-labelledby="faq-heading">
  <div class="container">

    <div class="section-header">
      <span class="label-lg section-label text-secondary">Questions fréquentes</span>
      <h2 class="headline-lg" id="faq-heading">Vous avez des questions ?</h2>
      <p class="body-md text-muted">Retrouvez ici les réponses aux questions les plus fréquentes de nos clients.</p>
    </div>

    <div class="faq-list" role="list">
      <?php foreach ($faqs as $i => $faq) : ?>
        <div class="faq-item" role="listitem">
          <button class="faq-question"
                  aria-controls="faq-answer-<?php echo $i; ?>"
                  type="button">
            <?php echo esc_html($faq['q']); ?>
            <span class="faq-icon" aria-hidden="true">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <polyline points="6 9 12 15 18 9"/>
              </svg>
            </span>
          </button>
          <div class="faq-answer" id="faq-answer-<?php echo $i; ?>" role="region">
            <?php echo wp_kses_post($faq['a']); ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

  </div>
</section>
