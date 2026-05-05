# TCP Inter — Thème WordPress Custom

Thème WordPress sur mesure pour **TCP Inter**, entreprise de nettoyage professionnel en Île-de-France.

🌐 Site en ligne : [https://tcpinter.com](https://tcpinter.com)

---

## À propos du projet

TCP Inter est une entreprise basée à Bobigny (93) qui intervient dans toute l'Île-de-France pour :
- Le nettoyage de bureaux et locaux professionnels
- Le nettoyage de fin de chantier
- Le nettoyage à domicile

Ce thème a été entièrement développé sur mesure, sans page builder ni plugin de design.

---

## Stack technique

- **CMS** : WordPress (zero plugin design)
- **PHP** : 8.2
- **CSS** : Variables CSS custom, Flexbox, Grid, animations natives
- **JS** : Vanilla JS (ES6+)
- **Fonts** : Manrope (titres) + Inter (corps) via Google Fonts
- **Carte** : Leaflet.js v1.9.4
- **Hébergement** : OVH Mutualisé

---

## Structure du thème

```
tcpinter/
├── assets/
│   ├── css/
│   │   ├── main.css          # Design system, variables, utilitaires
│   │   ├── header.css        # Header sticky + navigation
│   │   ├── hero.css          # Section hero
│   │   ├── sections.css      # Toutes les sections homepage
│   │   ├── cookies.css       # Popup consentement cookies
│   │   └── promo-popup.css   # Popup promo agence
│   ├── js/
│   │   ├── main.js           # Header scroll, FAQ, carousel témoignages
│   │   ├── map.js            # Carte Leaflet IDF (12 villes)
│   │   ├── cookies.js        # Consentement cookies (localStorage)
│   │   └── promo-popup.js    # Popup promo (1x/7 jours)
│   └── images/               # Logo, favicon, icônes, partenaires
├── inc/
│   ├── helpers.php           # Données témoignages, partenaires, villes
│   ├── ajax-devis.php        # Traitement formulaire devis (AJAX + DB)
│   ├── seo.php               # Meta, Open Graph, Twitter Card, Schema.org
│   ├── post-types.php        # CPT tcp_devis
│   └── fallback-menu.php     # Menu de secours
├── template-parts/
│   ├── hero.php              # Section hero
│   ├── about.php             # Section à propos
│   ├── solutions.php         # Nos services (accordion)
│   ├── stats.php             # Barre chiffres clés
│   ├── testimonials.php      # Carousel témoignages
│   ├── partners.php          # Défilement partenaires
│   ├── map.php               # Carte zones d'intervention
│   ├── cta-banner.php        # Bannière CTA
│   └── faq.php               # FAQ accordion
├── functions.php
├── header.php
├── footer.php
├── index.php
├── page-devis.php
└── style.css
```

---

## Fonctionnalités

- ✅ Design 100% custom responsive (mobile-first)
- ✅ Formulaire de devis AJAX avec sauvegarde en base de données
- ✅ Carousel témoignages avec avatars (auto-advance + navigation)
- ✅ Carte interactive Leaflet.js avec 12 villes IDF
- ✅ Bandeau cookies (RGPD) avec mémorisation localStorage
- ✅ SEO complet : meta description, Open Graph, Twitter Card, Schema.org LocalBusiness
- ✅ Favicon personnalisé
- ✅ Popup promo agence (apparaît 1 fois/7 jours après 2min)
- ✅ Animations au scroll (compteurs stats, fade-in)
- ✅ Sitemap XML + robots.txt

---

## Développé par

**HeyHappy Digital Agency**
- 🌐 [happyazondekon.github.io](https://happyazondekon.github.io/)
- 📧 heyhappyproject@gmail.com
- 📱 [Nos apps sur Google Play](https://play.google.com/store/apps/dev?id=6296680608247349537)
