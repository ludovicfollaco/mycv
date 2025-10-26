# 🌐 MyCV – Site web personnel de Ludovic Follaco

**Live :** https://follaco.fr  
**Objectif :** présenter le parcours, les projets et les compétences de **Ludovic Follaco** via un site PHP modulaire.

> ⚠️ Ce README est une version **technique**. Il inclut l’architecture probable du projet et des consignes d’installation **alignées avec les extraits de code/échanges** (Composer, autoload PSR‑4, Fancybox, etc.).

---

## ✅ Prérequis

- **PHP ≥ 8.0** (extensions standard : `mbstring`, `json`, `pdo`, `pdo_mysql`)
- **Apache** (WAMP/XAMPP) ou **PHP built‑in server**
- **MySQL/MariaDB** (si base activée)
- **Composer** (recommandé si autoload PSR‑4 utilisé)

---

## 🧩 Architecture (vue d’ensemble)

```
mycv/
├── index.php                       # Routeur/point d'entrée (ex: index.php?page=home)
├── includes/                       # Header, footer, config, helpers globaux
├── model/                          # Domaine métier (classes & services)
│   ├── common/                     # Utilitaires, accès BDD, sécurité, logger
│   ├── garageparrot/               # Exemple de sous‑domaine (Car, Brand, Model…)
│   └── ...                         # Autres domaines (user, presse, etc.)
├── assets/
│   ├── css/                        # Styles
│   ├── js/                         # Scripts (jQuery, Fancybox init, etc.)
│   └── img/                        # Images et médias
├── views/                          # Templates HTML/PHP
├── vendor/                         # (si Composer) dépendances & autoload
├── composer.json                   # (si Composer) mapping PSR‑4
└── README.md
```

### 👇 Exemple d’autoload PSR‑4 (extrait plausible)

```json
{
  "autoload": {
    "psr-4": {
      "Model\\Comment\\": "model/common/",
      "Model\\DbConnect\\": "model/common/",
      "Model\\Page\\": "model/common/",
      "Model\\Subscription\\": "model/common/",
      "Model\\Type\\": "model/common/",
      "Model\\User\\": "model/common/",
      "Model\\UserForm\\": "model/common/",
      "Model\\Utilities\\": "model/common/",
      "Model\\Car\\": "model/garageparrot/",
      "Model\\CarBrand\\": "model/garageparrot/",
      "Model\\CarForm\\": "model/garageparrot/",
      "Model\\GpHome\\": "model/garageparrot/",
      "Model\\CarModel\\": "model/garageparrot/",
      "Model\\CarEngine\\": "model/garageparrot/",
      "Model\\GpSchedules\\": "model/garageparrot/"
    }
  }
}
```

> Après modification du `composer.json`, exécuter : `composer dump-autoload -o`

---

## 🔧 Installation (local)

```bash
# 1) Cloner
git clone https://github.com/ludovicfollaco/mycv.git
cd mycv

# 2) Dépendances (si Composer utilisé)
composer install

# 3) Config locale
#   - copier includes/config.sample.php -> includes/config.php
#   - renseigner constantes/ENV (host BDD, user, pass, DB_NAME, DEBUG, etc.)

# 4) Lancer en local
# Option A : WAMP/XAMPP -> http://localhost/mycv
# Option B : serveur PHP intégré
php -S localhost:8000 -t .
```

### ⚙️ Base de données (si activée)

- Créer une base (ex :`mycv_db`)
- Importer le script SQL s’il existe (`/model/common/` ou `/sql/`)
- Vérifier les identifiants dans `includes/config.php` :

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'mycv_db');
```

- Classe d’accès BDD suggérée : `Model\DbConnect\...` (PDO, erreurs en exceptions, requêtes préparées)

---

## 🖼️ Front‑end & plugins

- **Bootstrap** : layout responsive
- **jQuery**
- **Fancybox** : galeries/diaporamas (ex. slider « presse », portfolio)
- **Font Awesome** : icônes

👉 Exemple d’initialisation Fancybox (JS) :

```js
document.addEventListener("DOMContentLoaded", function () {
  if (window.Fancybox) {
    Fancybox.bind("[data-fancybox='gallery']", {});
  }
});
```

---

## 🧱 Patterns & routing

- Routing simple via `index.php?page=...`
- Découplage **métier** (`/model`) vs **présentation** (`/views`)
- Helpers **Utilities** (échapements `htmlspecialchars`, `escapeInput`, etc.)

> Exemple (PHP) – filtrage d’un tableau de médias par section :

```php
$resultMedia = array_values(array_filter($medias, function($item) use ($i) {
  return isset($item['section_id']) && (int)$item['section_id'] === (int)$i;
}));
```

---

## 🧭 Bonnes pratiques

- **Sécurité**
  - Échapper **toutes** les sorties HTML (`htmlspecialchars`)
  - Requêtes **PDO préparées**
  - Vérifier/valider les entrées (`filter_input`, regex)
  - Protection CSRF sur formulaires sensibles
- **Logs & debug**
  - Flag `DEBUG` en session/ENV (ex : `$_SESSION['debug']['monolog']`)
  - (Optionnel) **Monolog** pour tracer erreurs/accès (fichiers `/logs/app.log`)
- **Qualité**
  - PSR‑1/PSR‑12, autoload PSR‑4
  - Nommage explicite (`PascalCase` classes, `snake_case` fichiers)
  - Pas de SQL inline dans les vues
- **Performances**
  - Minifier CSS/JS en prod
  - Cache HTTP (headers) et ETag sur assets

---

## 🛣️ Roadmap

- [ ] Formulaire de **contact** sécurisé (honeypot/rate‑limit)
- [ ] Module **Actualités/Blog**
- [ ] **SEO** : balises meta, OpenGraph, sitemap, schema.org
- [ ] **Internationalisation** (fr/en)
- [ ] **CI/CD** GitHub Actions (lint + déploiement)
- [ ] **Tests unitaires** (PHPUnit) sur Utilities/DbConnect
- [ ] Passage progressif à un micro‑framework (Slim/Lumen) si besoin

---

## 🚀 Déploiement

- Envoi FTP/SSH ou pipeline CI vers l’hébergement (ex. **OVH**)
- Vérifier : `display_errors=Off` en prod, variables ENV, permissions `/logs`

Exemple (SSH) :

```bash
rsync -av --delete --exclude .git --exclude vendor/ mycv/ user@server:/var/www/html/mycv
```

---

## 🤝 Contribuer

- Branches : `feat/*`, `fix/*`, `docs/*`
- Commits : convention **Conventional Commits**
- PR : description claire + étapes de test

---

## 👤 Auteur

**Ludovic Follaco** – Ingénieur produit & consultant en amélioration de la performance industrielle  
📍 Bréval, Yvelines (FR) — 🌐 https://follaco.fr — 📧 contact@follaco.fr

---

## 🪪 Licence

© 2025 Ludovic Follaco – Tous droits réservés.  
Reproduction/distribution interdites sans accord préalable.
