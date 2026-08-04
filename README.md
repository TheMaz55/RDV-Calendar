# 📅 RDV Calendar

## Présentation

**RDV Calendar** est un système de prise de rendez-vous interactif conçu pour les entreprises.

L'objectif du projet est de proposer une solution **simple, moderne et facilement personnalisable** permettant aux clients de réserver des créneaux et aux administrateurs de gérer efficacement leur agenda.

Le projet a été pensé pour être :
- ✅ **User-friendly**
- ✅ **Modulable facilement**
- ✅ **Adaptable aux besoins de différentes entreprises**
- ✅ **Simple à intégrer dans un environnement existant**

---

## ⚠️ Installation & configuration

La version publiée ici utilise actuellement une **connexion à une base de données locale**.

Il est donc normal que le projet **ne fonctionne pas directement après un simple téléchargement du dépôt**.

Avant de l'utiliser, vous devrez :

1. Configurer votre propre base de données.
2. Modifier les informations de connexion dans les fichiers concernés.
3. Adapter la structure de la base de données selon vos besoins.

Tout en haut des pages "popup.js", "adminCalendar.js" et "clientCalendar.js" vous pourrez définir les horaires et jours d'ouvertures de votre entreprise afin que vos clients ne puissent pas ajouter de rendez-vous en dehors de ces horaires.

Si besoin, vous pouvez utiliser une IA en lui fournissant :
- La structure de votre base de données.
- Les fichiers de configuration.
- Les erreurs rencontrées.

Elle pourra vous aider à adapter le projet à votre environnement.

---

# ✨ Fonctionnalités

## 👤 Espace client

Les clients peuvent :

- ➕ Ajouter un créneau de rendez-vous.
- ❌ Supprimer un rendez-vous existant.

---

## 🔐 Espace administration

Les administrateurs disposent de fonctionnalités avancées :

### Gestion des rendez-vous
- ➕ Création de nouveaux créneaux.
- ❌ Suppression de rendez-vous.
- ✏️ Modification d'un rendez-vous directement en cliquant dessus.

### Gestion du calendrier
- 🖱️ Déplacement des rendez-vous en **drag & drop**.
- 📆 Affichage du calendrier en :
  - Vue journalière.
  - Vue hebdomadaire.
  - Vue mensuelle.

---

# 🛠️ Technologies utilisées

- PHP
- JavaScript
- MySQL
- HTML / CSS
- FullCalendar

---

# 📷 Aperçu

*(Ajoutez ici des captures d'écran du projet)*

---

# 🚀 Installation

Clonez le projet :

```bash
git clone https://github.com/votre-utilisateur/RDV-Calendar.git
