// JSON-LD : MyCv
const structuredData = {
    "@context": "https://schema.org",
    "@graph": [
      {
        "@type": "Person",
        "@id": "http://www.follaco.fr#ludovic-follaco",
        "inLanguage": "fr-FR",
        "url": "http://www.follaco.fr",
        "name": "Ludovic FOLLACO",
        "description": "Ludovic FOLLACO, Ingénieur produit et développeur : compétences en ingénierie industrielle, développement web et web mobile, CATIA V5. Carrière et exemples concrets.",
        "image": "img/common/avatar/imgJsonLd.webp",
        "jobTitle": "Ingénieur et développeur web et web mobile",
        "telephone": "+33608818390",
        "email": "ludovic.follaco@free.fr",
        "address": {
          "@type": "PostalAddress",
          "streetAddress": "20 hameau de Thiron",
          "addressLocality": "Bréval",
          "postalCode": "78980",
          "addressCountry": "FR"
        },
        "sameAs": [
          "http://www.linkedin.com/in/ludovic.follaco",
          "https://viadeo.journaldunet.com/p/ludovic-follaco-1094426"
        ],
        "knowsAbout": [
          {
            "@type": "DefinedTerm",
            "name": "Chef d'entreprise",
            "description": "Stratégie, Budget, Gestion et Organisation"
          },
          {
            "@type": "DefinedTerm",
            "name": "Directeur",
            "description": "Stratégie, Budget, Gestion et Organisation"
          },
          {
            "@type": "DefinedTerm",
            "name": "Qualité",
            "description": "Rédaction manuel, rédaction des processus et procédures, audit interne, animation, formation, productivité"
          },
          {
            "@type": "DefinedTerm",
            "name": "ISO 9001",
            "description": "Rédaction manuel, rédaction des processus et procédures, audit interne, animation, formation, productivité"
          },
          {
            "@type": "DefinedTerm",
            "name": "Méthode",
            "description": "Rédaction manuel, rédaction des processus et procédures, audit interne, animation, formation, productivité"
          },
          {
            "@type": "DefinedTerm",
            "name": "Gestion de Projet",
            "description": "Planification et coordination de projets techniques."
          },
          {
            "@type": "DefinedTerm",
            "name": "Concepteur Web",
            "description": "Conception de sites web interactifs."
          },
          {
            "@type": "DefinedTerm",
            "name": "Développeur Web",
            "description": "Développement de sites web interactifs."
          },
          {
            "@type": "DefinedTerm",
            "name": "Développeur frontend sur figma",
            "description": "Maquettes et prototypes de sites web interactifs."
          },
          {
            "@type": "DefinedTerm",
            "name": "Développeur frontend en html, css et javascript",
            "description": "Développement frontend de sites web interactifs."
          },
          {
            "@type": "DefinedTerm",
            "name": "Développeur backend en PHP",
            "description": "Développement backend de sites web interactifs."
          },
          {
            "@type": "DefinedTerm",
            "name": "Développeur de bases de données MySQL/MariaDB",
            "description": "Développement et gestion de bases de données MySQL et MariaDB."
          },
          {
            "@type": "DefinedTerm",
            "name": "Etudes électrique de faisceaux embarqués",
            "description": "Rédaction de schémas électriques, de schémas de principes et de schémas fonctionnels ."
          },
          {
            "@type": "DefinedTerm",
            "name": "Architecture électrique de faisceaux embarqués",
            "description": "Rédaction de schémas électriques, de schémas de principes et de schémas fonctionnels ."
          },
          {
            "@type": "DefinedTerm",
            "name": "Concepteur sur CATIA V5 EHI",
            "description": "Numérisation des parcours de faisceaux avec CATIA V5 EHI et rédaction des plans de montage."
          },
          {
            "@type": "DefinedTerm",
            "name": "Etudes processus de fabrication de faisceaux embarqués",
            "description": "Rédaction de plan de fabrication de faisceaux embarqués (géomètrie, liste de fils, nomenclatures, préconisations)."
          },                     
          {
            "@type": "DefinedTerm",
            "name": "Développement d'application pour CATIA V5",
            "description": "Développement de logiciel de productivité pour CATIA V5 (VBA et DotNet)."
          },
          {
            "@type": "DefinedTerm",
            "name": "Développement d'application MS Office",
            "description": "Développement de logiciel de productivité pour le Pack Office (VBA)."
          }
        ]
      },
      {
        "@type": "Organization",
        "name": "Ludovic FOLLACO Consulting",
        "url": "http://follaco.fr",
        "logo": "http://follaco.fr/img/common/imgJsonLd.webp",
        "contactPoint": {
          "@type": "ContactPoint",
          "telephone": "+33608818390",
          "email": "ludovic.follaco@free.fr",
          "contactType": "Service Client"
        }
      }
    ]
  };
  
  const script = document.createElement('script');
  script.type = 'application/ld+json';
  script.text = JSON.stringify(structuredData);
  document.head.appendChild(script);