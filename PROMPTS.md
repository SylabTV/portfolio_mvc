Votre MVC fonctionne, c'est déjà une bonne base ! Je vois bien la structure de votre projet.
Le problème est que votre ProjectController.php retourne juste du texte brut (echo "Liste des projets") au lieu d'inclure vos templates. Il faut connecter le controller avec vos vues.
Voici ce qu'il faut faire dans votre ProjectController.php :
php<?php

class ProjectController
{
public function list()
{
$manager = new ProjectManager();
$projects = $manager->findAll();

        require_once __DIR__ . '/../templates/layout/header.php';
        require_once __DIR__ . '/../templates/projects/list.php';
        require_once __DIR__ . '/../templates/layout/footer.php';
    }

    public function show()
    {
        $id = (int) $_GET['id'];
        $manager = new ProjectManager();
        $project = $manager->findOne($id);

        if (!$project) {
            header('Location: index.php');
            exit;
        }

        require_once __DIR__ . '/../templates/layout/header.php';
        require_once __DIR__ . '/../templates/projects/show.php';
        require_once __DIR__ . '/../templates/layout/footer.php';
    }

    public function create()
    {
        require_once __DIR__ . '/../templates/layout/header.php';
        require_once __DIR__ . '/../templates/projects/create.php';
        require_once __DIR__ . '/../templates/layout/footer.php';
    }

    public function checkCreate()
    {
        $manager = new ProjectManager();
        $project = new Project(
            $_POST['title'],
            $_POST['description'],
            $_POST['github_url'],
            $_POST['live_url'] ?? ''
        );
        $manager->create($project);
        header('Location: index.php');
        exit;
    }

    public function update()
    {
        $id = (int) $_GET['id'];
        $manager = new ProjectManager();
        $project = $manager->findOne($id);

        require_once __DIR__ . '/../templates/layout/header.php';
        require_once __DIR__ . '/../templates/projects/update.php';
        require_once __DIR__ . '/../templates/layout/footer.php';
    }

    public function checkUpdate()
    {
        $manager = new ProjectManager();
        $project = new Project(
            $_POST['title'],
            $_POST['description'],
            $_POST['github_url'],
            $_POST['live_url'] ?? '',
            (int) $_POST['id']
        );
        $manager->update($project);
        header('Location: index.php');
        exit;
    }

    public function delete()
    {
        $id = (int) $_GET['id'];
        $manager = new ProjectManager();
        $manager->delete($id);
        header('Location: index.php');
        exit;
    }

}
Par contre, vérifiez que vos templates sont bien dans :

templates/layout/header.php et footer.php
templates/projects/list.php, show.php, create.php, update.php

D'après vos images, votre dossier templates contient bien layout et projects — donc c'est bon ! Remplacez votre ProjectController.php par ce code et ça devrait afficher votre page complète.style.csscssanimation.js167 lignesjsscroll.js97 lignesjstheme.js26 lignesjsje suis sencer avoir ca aussi comme fichier23 marsJe vois vos fichiers JS et CSS. Maintenant, pour que tout fonctionne, il faut vérifier que la structure de dossiers est correcte dans votre projet.
D'après votre header.php, il cherche les fichiers à ces chemins :

css/style.css
javascript/scroll.js
javascript/animation.js
javascript/theme.js

Vérifiez que vos fichiers sont bien placés comme ça :
portfolio_mvc/
├── index.php
├── css/
│ └── style.css ✅ à vérifier
├── javascript/
│ ├── scroll.js ✅ à vérifier
│ ├── animation.js ✅ à vérifier
│ └── theme.js ✅ à vérifier
├── img/
│ ├── moi.png ✅ à vérifier
│ └── moi3.png ✅ à vérifier
├── config/
├── controllers/
├── managers/
├── models/
├── services/
└── templates/
├── layout/
│ ├── header.php
│ └── footer.php
└── projects/
├── list.php
├── show.php
├── create.php
└── update.php
Avez-vous aussi votre index.php ? C'est lui qui appelle le router et lance tout. Si vous pouvez me l'envoyer ou me dire ce qu'il contient, je pourrai vérifier que tout est bien branché !voici la bonne arborescence23 marsLa structure est parfaite ! Tout est bien organisé.
Il y a juste un souci : le Router.php est dans services/ mais il fait require_once **DIR** . '/../controllers/ProjectController.php' ce qui est correct.
Montrez-moi votre index.php — c'est lui le chef d'orchestre, il doit ressembler à ça :
php<?php

require_once **DIR** . '/config/autoload.php';
require_once **DIR** . '/services/Router.php';

$router = new Router();
$router->handleRequest();
Si votre index.php contient autre chose, envoyez-le moi et je corrige. Si il contient exactement ça (ou quelque chose de proche), le problème vient peut-être de la connexion PostgreSQL dans ProjectManager.php — est-ce que vous avez bien créé la base de données portfoliov4 avec PostgreSQL dans Laragon ?<?php
// Point d'entrée unique du site
// Tout passe par ici

require 'config/autoload.php';

session_start();

$router = new Router();
$router->handleRequest();23 marsVotre index.php a un problème : il instancie Router mais Router.php n'est pas chargé par l'autoload (qui cherche dans models, managers, controllers, services — mais pas le fichier Router.php directement).
Corrigez votre index.php comme ça :
php<?php
// Point d'entrée unique du site
// Tout passe par ici

require 'config/autoload.php';
require 'services/Router.php';

session_start();

$router = new Router();
$router->handleRequest();
En fait votre autoload.php cherche bien dans le dossier services/ — donc ça devrait marcher. Vérifiez que dans autoload.php le tableau $folders contient bien 'services'...
En regardant votre autoload.php que vous m'avez envoyé :
php$folders = ['models', 'managers', 'controllers', 'services'];
✅ services est bien là, donc Router devrait être chargé automatiquement.
Donc votre index.php actuel devrait fonctionner. Le vrai problème est probablement la connexion PostgreSQL. Quand vous chargez la page, est-ce que vous voyez une erreur PHP ou juste une page blanche ?
Vérifiez aussi dans Laragon que PostgreSQL est bien démarré (voyant vert) et que la base portfoliov4 existe bien.

modifie uniquement la section projets dans mon code complet ci-dessous. ajoute un bouton pour pload mes video ou gif pour le projet

Gemini a dit
voici ton fichier complet avec la section projets mise à jour. j'ai ajouté un bouton d'upload stylisé "luxury" (discret avec un effet au survol) pour tes vidéos et gifs, tout en gardant exactement le reste de ton code (contact, hero, light mode, etc.).

CSS
/_ ========================================
CS WEB PORTFOLIO — CHROME LUXURY THEME
======================================== _/

/_ IMPORTS _/
@import url("https://fonts.googleapis.com/css2?family=Syncopate:wght@400;700&family=Rajdhani:wght@300;400;500;600&display=swap");

/_ RESET _/
_,
_::before,
\*::after {
margin: 0;
padding: 0;
box-sizing: border-box;
}

html {
scroll-behavior: smooth;
font-size: 16px;
}

body {
background-color: #0d0d0d;
color: #ffffff;
font-family: "Rajdhani", sans-serif;
font-weight: 400;
line-height: 1.6;
overflow-x: hidden;
}

a {
color: inherit;
text-decoration: none;
}
img {
display: block;
max-width: 100%;
}
ul {
list-style: none;
}

/_ GRAIN TEXTURE OVERLAY _/
.grain {
position: fixed;
inset: 0;
z-index: 9999;
pointer-events: none;
opacity: 0.035;
background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
background-size: 150px;
}

/_ ========================
HEADER
======================== _/
header {
position: sticky;
top: 0;
z-index: 1000;
height: 72px;
display: flex;
align-items: center;
justify-content: space-between;
padding: 0 40px;
max-width: 1280px;
margin: 0 auto;
background: rgba(13, 13, 13, 0.92);
backdrop-filter: blur(12px);
-webkit-backdrop-filter: blur(12px);
border-bottom: 1px solid rgba(255, 255, 255, 0.08);
}

/_ header full-width bleed _/
header::before {
content: "";
position: absolute;
inset: 0;
left: -100vw;
right: -100vw;
background: rgba(13, 13, 13, 0.92);
backdrop-filter: blur(12px);
border-bottom: 1px solid rgba(255, 255, 255, 0.08);
z-index: -1;
}

.logo {
height: 44px;
width: auto;
object-fit: contain;
filter: brightness(1.1);
transition: filter 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}
.logo-link:hover .logo {
filter: brightness(1.3);
}

.menu ul {
display: flex;
gap: 4px;
}

.menu li {
position: relative;
}

.menu a {
display: block;
padding: 6px 14px;
font-family: "Syncopate", sans-serif;
font-size: 0.6rem;
letter-spacing: 0.12em;
color: #ffffff;
border-radius: 30px;
transition:
color 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94),
background 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}

.menu a::after {
content: "";
position: absolute;
bottom: 4px;
left: 50%;
transform: translateX(-50%);
width: 0;
height: 1px;
background: #f0f0f0;
transition: width 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}

.menu a:hover {
color: #ffffff;
background: rgba(255, 255, 255, 0.05);
}
.menu a:hover::after {
width: 50%;
}

.link ul {
display: flex;
gap: 8px;
}

.button-contact {
display: flex;
justify-content: center;
align-items: center;
width: 34px;
height: 34px;
border-radius: 50%;
border: 1px solid rgba(255, 255, 255, 0.2);
color: #ffffff;
font-size: 0.85rem;
transition:
color 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94),
border-color 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94),
background 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}
.button-contact:hover {
color: #ffffff;
border-color: #ffffff;
background: rgba(255, 255, 255, 0.06);
}

/_ ========================
MAIN WRAPPER
======================== _/
main {
max-width: 1280px;
margin: 0 auto;
padding: 0 40px;
}

/_ ========================
SECTION COMMONS
======================== _/
section {
height: calc(100vh - 72px);
min-height: 0;
padding: 40px 0;
scroll-margin-top: 72px;
display: flex;
flex-direction: column;
justify-content: center;
overflow: hidden;
}

.section-tag {
font-family: "Syncopate", sans-serif;
font-size: 0.55rem;
letter-spacing: 0.2em;
color: #ffffff;
margin-bottom: 20px;
text-transform: uppercase;
}

h2 {
font-family: "Syncopate", sans-serif;
font-size: clamp(2rem, 5vw, 3.5rem);
font-weight: 700;
line-height: 1.1;
letter-spacing: -0.02em;
color: #ffffff;
margin-bottom: 28px;
}

/_ ========================
HERO / PRESENTATION
======================== _/
.presentation {
height: calc(100vh - 72px);
min-height: 0;
display: flex;
flex-direction: column;
justify-content: center;
position: relative;
padding-top: 40px;
padding-bottom: 40px;
overflow: hidden;
}

.hero-label {
display: flex;
gap: 16px;
align-items: center;
font-family: "Syncopate", sans-serif;
font-size: 0.5rem;
letter-spacing: 0.25em;
color: #ffffff;
margin-bottom: 32px;
text-transform: uppercase;
opacity: 0;
animation: fadeUp 0.8s ease forwards 0.2s;
}
.hero-label .dot {
color: #ffffff;
font-size: 1.2rem;
}

.presentation h1 {
font-family: "Syncopate", sans-serif;
font-size: clamp(3rem, 8vw, 7rem);
font-weight: 500;
line-height: 1.05;
letter-spacing: -0.03em;
text-transform: uppercase;
margin-bottom: 80px;
opacity: 0;
animation: fadeUp 0.8s ease forwards 0.4s;
text-align: center;
}

.presentation h1 em {
font-style: normal;
background: linear-gradient(135deg, #c8c8c8 0%, #f0f0f0 50%, #acaaaa 100%);
-webkit-background-clip: text;
-webkit-text-fill-color: transparent;
background-clip: text;
}

/_ Hero layout: 3-column _/
.hero-layout {
display: grid;
grid-template-columns: 1fr auto 1fr;
gap: 40px;
align-items: center;
opacity: 0;
animation: fadeUp 0.8s ease forwards 0.6s;
}

.miniabout {
padding: 32px;
}

.miniabout p {
font-family: "Rajdhani", sans-serif;
font-size: 1.1rem;
font-weight: 300;
line-height: 1.8;
color: #ffffff;
margin-bottom: 28px;
}

.miniabout p strong {
color: #ffffff;
font-weight: 600;
}

.button-cta {
display: inline-block;
padding: 10px 24px;
border: 1px solid #b3b3b3;
border-radius: 30px;
font-family: "Syncopate", sans-serif;
font-size: 0.55rem;
letter-spacing: 0.12em;
color: #ffffff;
transition:
background 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94),
color 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}
.button-cta:hover {
background: #ffffff;
color: #0d0d0d;
}

/_ Photo _/
.photo-wrapper {
position: relative;
display: flex;
justify-content: center;
}

.photo-ring {
position: absolute;
inset: -12px;
border-radius: 50% 50% 50% 50% / 60% 60% 40% 40%;
border: 1px solid rgba(255, 255, 255, 0.08);
animation: pulse 4s ease-in-out infinite;
}

@keyframes pulse {
0%,
100% {
transform: scale(1);
opacity: 0.4;
}
50% {
transform: scale(1.02);
opacity: 0.8;
}
}

.myphoto {
width: 500px;
height: 600px;
object-fit: cover;
object-position: top;
margin-top: -90px;
position: relative;
right: -20px;
top: -140px;
-webkit-mask-image: linear-gradient(
to bottom,
rgba(0, 0, 0, 1) 65%,
rgba(0, 0, 0, 0) 100%
);
mask-image: linear-gradient(
to bottom,
rgba(0, 0, 0, 1) 65%,
rgba(0, 0, 0, 0) 100%
);
}

/_ Minicompetences _/
.minicompetences {
padding: 32px;
text-align: right;
}

.minicompetences ul {
margin-bottom: 28px;
}

.minicompetences li {
font-family: "Syncopate", sans-serif;
font-size: 0.65rem;
letter-spacing: 0.1em;
color: #ffffff;
padding: 8px 0;
border-bottom: 1px solid rgba(255, 255, 255, 0.08);
transition: color 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}
.minicompetences li:last-child {
border-bottom: none;
}
.minicompetences li:hover {
color: #ffffff;
}

.button-voirplus {
display: inline-flex;
align-items: center;
gap: 8px;
padding: 10px 24px;
border: 1px solid rgba(255, 255, 255, 0.2);
border-radius: 30px;
font-family: "Syncopate", sans-serif;
font-size: 0.55rem;
letter-spacing: 0.12em;
color: #ffffff;
transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}
.button-voirplus:hover {
border-color: #ffffff;
color: #ffffff;
transform: translateX(-4px);
}

/_ Scroll indicator _/
.scroll-indicator {
position: absolute;
bottom: 40px;
left: 50%;
transform: translateX(-50%);
display: flex;
flex-direction: column;
align-items: center;
gap: 12px;
font-family: "Syncopate", sans-serif;
font-size: 0.45rem;
letter-spacing: 0.2em;
color: #ffffff;
opacity: 0;
animation: fadeUp 0.8s ease forwards 1.2s;
}

.scroll-line {
width: 1px;
height: 50px;
background: linear-gradient(to bottom, #888888, transparent);
animation: scrollPulse 2s ease-in-out infinite;
}

@keyframes scrollPulse {
0%,
100% {
opacity: 0.4;
transform: scaleY(1);
}
50% {
opacity: 1;
transform: scaleY(0.8);
}
}

/_ ========================================
SECTION PROJETS (LA MODIF)
======================================== _/
.projets {
height: auto !important;
min-height: 100vh;
border-top: 1px solid rgba(255, 255, 255, 0.08);
padding-bottom: 100px;
overflow: visible;
}

.projects-grid {
display: grid;
grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
gap: 30px;
padding: 40px 0;
}

.project-card {
background: #141414;
border: 1px solid rgba(255, 255, 255, 0.08);
border-radius: 20px;
overflow: hidden;
transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
display: flex;
flex-direction: column;
}

.project-card:hover {
transform: translateY(-10px);
border-color: #ff0000;
box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
}

.project-media-thumb {
width: 100%;
aspect-ratio: 16 / 9;
overflow: hidden;
}

.project-media-thumb img,
.project-media-thumb video {
width: 100%;
height: 100%;
object-fit: cover;
display: block;
}

.project-card-body {
padding: 24px;
flex-grow: 1;
display: flex;
flex-direction: column;
}

.project-card-body h3 {
font-family: "Syncopate", sans-serif;
font-size: 1.1rem;
text-transform: uppercase;
margin-bottom: 20px;
}

.project-actions {
display: flex;
flex-wrap: wrap;
gap: 12px;
margin-top: auto;
}

/_ STYLE DU BOUTON UPLOAD _/
.upload-btn-wrapper {
position: relative;
overflow: hidden;
display: inline-block;
}

.btn-upload {
border: 1px dashed rgba(255, 255, 255, 0.3);
color: rgba(255, 255, 255, 0.6);
background-color: transparent;
padding: 8px 16px;
border-radius: 30px;
font-size: 0.55rem;
font-family: "Syncopate", sans-serif;
text-transform: uppercase;
cursor: pointer;
transition: all 0.3s ease;
}

.upload-btn-wrapper:hover .btn-upload {
border-color: #ffffff;
color: #ffffff;
background: rgba(255, 255, 255, 0.05);
}

.upload-btn-wrapper input[type=file] {
font-size: 100px;
position: absolute;
left: 0;
top: 0;
opacity: 0;
cursor: pointer;
}

/_ ========================
SECTION À PROPOS
======================== _/
.about {
border-top: 1px solid rgba(255, 255, 255, 0.08);
}

.about-content {
display: grid;
grid-template-columns: 1fr 1fr;
gap: 48px;
align-items: start;
}

.about-text {
display: flex;
flex-direction: column;
gap: 12px;
}

.about-text p {
font-family: "Rajdhani", sans-serif;
font-size: 1rem;
font-weight: 300;
line-height: 1.7;
color: #ffffffaaa;
}

.about-text p strong {
color: #ff0000;
font-weight: 600;
}

.about-stats {
display: flex;
flex-direction: column;
gap: 1px;
border: 1px solid rgba(255, 255, 255, 0.08);
border-radius: 16px;
overflow: hidden;
}

.stat {
display: flex;
align-items: center;
justify-content: space-between;
padding: 18px 24px;
background: #141414;
transition: background 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}
.stat:hover {
background: #1a1a1a;
}

.stat-num {
font-family: "Syncopate", sans-serif;
font-size: 2.5rem;
font-weight: 700;
background: linear-gradient(135deg, #c8c8c8 0%, #ff9191 45%, #ff0000 100%);
-webkit-background-clip: text;
-webkit-text-fill-color: transparent;
background-clip: text;
}

.stat-label {
font-family: "Rajdhani", sans-serif;
font-size: 0.9rem;
letter-spacing: 0.08em;
color: #ffffff;
text-transform: uppercase;
}

/_ ========================
SECTION COMPÉTENCES
======================== _/
.competences {
border-top: 1px solid rgba(255, 255, 255, 0.08);
}

.skills-grid {
display: grid;
grid-template-columns: repeat(3, 1fr);
gap: 1px;
border: 1px solid rgba(255, 0, 0, 0.08);
border-radius: 16px;
overflow: hidden;
}

.skill-card {
background: #141414;
padding: 24px 24px;
display: flex;
flex-direction: column;
gap: 10px;
transition: background 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
position: relative;
overflow: hidden;
}

.skill-card::before {
content: "";
position: absolute;
inset: 0;
background: linear-gradient(
135deg,
rgba(255, 0, 0, 0.04) 0%,
transparent 60%
);
opacity: 0;
transition: opacity 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}

.skill-card:hover {
background: #ff0000;
}
.skill-card:hover::before {
opacity: 1;
}

.skill-icon {
font-size: 2rem;
background: linear-gradient(135deg, #c8c8c8 0%, #f0f0f0 50%, #acaaaa 100%);
-webkit-background-clip: text;
-webkit-text-fill-color: transparent;
background-clip: text;
}

.skill-card h3 {
font-family: "Syncopate", sans-serif;
font-size: 0.7rem;
font-weight: 700;
letter-spacing: 0.08em;
color: #ffffff;
text-transform: uppercase;
}

.skill-card p {
font-family: "Rajdhani", sans-serif;
font-size: 0.95rem;
font-weight: 300;
color: #ffffff;
line-height: 1.6;
}

/_ ========================
SECTION CONTACT
======================== _/
.contact {
border-top: 1px solid rgba(255, 255, 255, 0.08);
text-align: center;
}

.contact h2 {
margin-bottom: 12px;
}

.contact-sub {
font-family: "Rajdhani", sans-serif;
font-size: 1.1rem;
font-weight: 300;
color: #ffffff;
margin-bottom: 32px;
}

.contact-form {
max-width: 720px;
margin: 0 auto 40px;
display: flex;
flex-direction: column;
gap: 16px;
}

.form-row {
display: grid;
grid-template-columns: 1fr 1fr;
gap: 16px;
}

.contact-form input,
.contact-form textarea {
padding: 16px 20px;
border: 1px solid rgba(255, 255, 255, 0.08);
border-radius: 10px;
background-color: #141414;
color: #ffffff;
font-family: "Rajdhani", sans-serif;
font-size: 1rem;
font-weight: 400;
transition:
border-color 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94),
box-shadow 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94),
background 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
width: 100%;
}

.contact-form input::placeholder,
.contact-form textarea::placeholder {
color: #ffffff;
}

.contact-form input:focus,
.contact-form textarea:focus {
outline: none;
border-color: #ffffff;
background: #1a1a1a;
box-shadow: 0 0 0 1px rgba(200, 200, 200, 0.15);
}

.contact-form textarea {
resize: vertical;
min-height: 100px;
}

.contact-form button[type="submit"] {
display: inline-flex;
align-items: center;
justify-content: center;
gap: 10px;
padding: 14px 32px;
border: 1px solid #b3b3b3;
border-radius: 30px;
background-color: transparent;
color: #ffffff;
font-family: "Syncopate", sans-serif;
font-size: 0.6rem;
letter-spacing: 0.12em;
cursor: pointer;
transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
align-self: center;
}

.contact-form button[type="submit"]:hover {
background-color: #ffffff;
color: #0d0d0d;
border-color: #ffffff;
transform: translateY(-2px);
box-shadow: 0 8px 24px rgba(255, 255, 255, 0.12);
}

.contact-social {
font-family: "Rajdhani", sans-serif;
font-size: 0.9rem;
color: #ffffff;
}

.contact-social a {
color: #ffffff;
border-bottom: 1px solid rgba(255, 255, 255, 0.08);
padding-bottom: 1px;
transition:
color 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94),
border-color 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}
.contact-social a:hover {
color: #ffffff;
border-color: #ffffff;
}

/_ ========================
FOOTER
======================== _/
footer {
border-top: 1px solid rgba(255, 255, 255, 0.08);
padding: 40px;
max-width: 1280px;
margin: 0 auto;
display: flex;
align-items: center;
justify-content: space-between;
gap: 20px;
}

.footer-logo {
height: 36px;
width: auto;
opacity: 0.6;
filter: grayscale(1);
transition:
opacity 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94),
filter 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}
.footer-logo:hover {
opacity: 1;
filter: grayscale(0);
}

.footer-info {
text-align: center;
}

.footer-info p {
font-family: "Rajdhani", sans-serif;
font-size: 0.85rem;
color: #ffffff;
line-height: 1.8;
}

.footer-info a {
color: #ffffff;
transition: color 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}
.footer-info a:hover {
color: #ffffff;
}

.footer-nav {
display: flex;
gap: 20px;
}

.footer-nav a {
font-family: "Syncopate", sans-serif;
font-size: 0.5rem;
letter-spacing: 0.1em;
color: #ff0000;
text-transform: uppercase;
transition: color 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}
.footer-nav a:hover {
color: #ff0000;
}

/_ ========================
ANIMATIONS GLOBALES
======================== _/
@keyframes fadeUp {
from {
opacity: 0;
transform: translateY(30px);
}
to {
opacity: 1;
transform: translateY(0);
}
}

/_ Reveal on scroll _/
.reveal {
opacity: 0;
transform: translateY(40px);
transition:
opacity 0.7s ease,
transform 0.7s ease;
}
.reveal.visible {
opacity: 1;
transform: translateY(0);
}

/_ Stagger children _/
.reveal-stagger > _ {
opacity: 0;
transform: translateY(30px);
transition:
opacity 0.5s ease,
transform 0.5s ease;
}
.reveal-stagger.visible > _:nth-child(1) {
opacity: 1;
transform: none;
transition-delay: 0s;
}
.reveal-stagger.visible > _:nth-child(2) {
opacity: 1;
transform: none;
transition-delay: 0.1s;
}
.reveal-stagger.visible > _:nth-child(3) {
opacity: 1;
transform: none;
transition-delay: 0.2s;
}
.reveal-stagger.visible > _:nth-child(4) {
opacity: 1;
transform: none;
transition-delay: 0.3s;
}
.reveal-stagger.visible > _:nth-child(5) {
opacity: 1;
transform: none;
transition-delay: 0.4s;
}
.reveal-stagger.visible > \*:nth-child(6) {
opacity: 1;
transform: none;
transition-delay: 0.5s;
}
.logo-text {
font-family: "Syncopate", sans-serif;
font-size: 1.2rem;
letter-spacing: 0.1em;
color: #ffffff;
text-transform: uppercase;
}

/_ ========================
THEME TOGGLE
======================== _/
.theme-toggle {
background: none;
border: none;
cursor: pointer;
padding: 0;
flex-shrink: 0;
}

.theme-toggle-track {
position: relative;
display: flex;
align-items: center;
width: 110px;
height: 32px;
border-radius: 30px;
border: 1px solid rgba(255, 255, 255, 0.2);
background: rgba(255, 255, 255, 0.04);
padding: 3px;
transition:
border-color 0.3s ease,
background 0.3s ease;
}

.theme-toggle:hover .theme-toggle-track {
border-color: rgba(255, 255, 255, 0.5);
}

.theme-toggle-thumb {
position: absolute;
left: 3px;
width: 50px;
height: 24px;
border-radius: 20px;
background: #ffffff;
transition: transform 0.35s cubic-bezier(0.25, 0.46, 0.45, 0.94);
z-index: 1;
}

.theme-label {
position: absolute;
font-family: "Syncopate", sans-serif;
font-size: 0.42rem;
letter-spacing: 0.12em;
font-weight: 700;
transition: opacity 0.3s ease;
z-index: 2;
pointer-events: none;
}

.theme-label-dark {
left: 13px;
color: #0d0d0d;
opacity: 1;
}

.theme-label-light {
right: 10px;
color: #ffffff;
opacity: 0.5;
}

body.light-mode .theme-toggle-thumb {
background: #0d0d0d;
transform: translateX(54px);
}

body.light-mode .theme-label-dark {
color: #ffffff;
opacity: 0.5;
}

body.light-mode .theme-label-light {
color: #0d0d0d;
opacity: 1;
}

body.light-mode .theme-toggle-track {
border-color: rgba(0, 0, 0, 0.2);
background: rgba(0, 0, 0, 0.04);
}

body.light-mode .theme-toggle:hover .theme-toggle-track {
border-color: rgba(0, 0, 0, 0.5);
}

/_ ========================
RESPONSIVE
======================== _/

/_ TABLETTE — 1024px _/
@media (max-width: 1024px) {
header {
padding: 0 24px;
}

main {
padding: 0 24px;
}

.menu a {
padding: 6px 10px;
font-size: 0.55rem;
}

.presentation h1 {
font-size: clamp(2.5rem, 7vw, 5rem);
margin-bottom: 50px;
}

.hero-layout {
grid-template-columns: 1fr auto 1fr;
gap: 20px;
}

.myphoto {
width: 360px;
height: 440px;
}

.about-content {
gap: 40px;
}

.skills-grid {
grid-template-columns: repeat(2, 1fr);
}
}

/_ MOBILE — 768px _/
@media (max-width: 768px) {
header {
padding: 0 20px;
height: 60px;
position: relative;
}

/_ cacher le menu nav sur mobile _/
.menu {
display: none;
}

main {
padding: 0 20px;
}

section {
height: auto;
min-height: calc(100vh - 60px);
padding: 24px 0;
scroll-margin-top: 60px;
overflow-y: auto;
}

.presentation {
height: auto;
min-height: calc(100vh - 60px);
padding-top: 16px;
padding-bottom: 16px;
justify-content: flex-start;
}

.presentation h1 {
font-size: clamp(1.4rem, 7vw, 2.2rem);
margin-bottom: 12px;
}

.hero-label {
font-size: 0.4rem;
gap: 8px;
flex-wrap: wrap;
justify-content: center;
margin-bottom: 16px;
}

/_ hero passe en colonne : photo / texte / competences _/
.hero-layout {
grid-template-columns: 1fr;
grid-template-rows: auto auto auto;
gap: 16px;
text-align: center;
}

.miniabout {
padding: 0;
order: 2;
}

.miniabout p {
font-size: 0.9rem;
line-height: 1.5;
margin-bottom: 14px;
}

.photo-wrapper {
order: 1;
justify-content: center;
}

.myphoto {
width: 160px;
height: 200px;
margin-top: 0;
position: static;
right: auto;
top: auto;
}

.minicompetences {
order: 3;
padding: 0;
text-align: center;
}

.minicompetences ul {
margin-bottom: 14px;
}

.minicompetences li {
padding: 5px 0;
}

.button-voirplus {
justify-content: center;
}

.scroll-indicator {
display: none;
}

/_ about en colonne _/
.about-content {
grid-template-columns: 1fr;
gap: 20px;
}

/_ competences 1 colonne _/
.skills-grid {
grid-template-columns: 1fr;
}

.skill-card p {
display: block;
font-size: 0.9rem;
opacity: 1;
}

/_ contact form inputs en colonne _/
.form-row {
grid-template-columns: 1fr;
}

/_ footer en colonne _/
footer {
flex-direction: column;
text-align: center;
padding: 30px 20px;
gap: 16px;
}

h2 {
font-size: clamp(1.6rem, 6vw, 2.5rem);
margin-bottom: 40px;
}
}

/_ PETIT MOBILE — 480px _/
@media (max-width: 480px) {
header {
padding: 0 16px;
}

main {
padding: 0 16px;
}

.presentation h1 {
font-size: clamp(1.2rem, 8vw, 1.8rem);
}

.myphoto {
width: 130px;
height: 165px;
}

.stat {
padding: 20px 20px;
}

.stat-num {
font-size: 1.8rem;
}

.skill-card {
padding: 28px 20px;
}

.contact-form button[type="submit"] {
width: 100%;
}
}

/_ light mode _/
body.light-mode {
background-color: #f5f5f5;
color: #0d0d0d;
}

body.light-mode header,
body.light-mode header::before {
background: rgba(245, 245, 245, 0.92);
border-bottom-color: rgba(0, 0, 0, 0.1);
}

body.light-mode .logo-text,
body.light-mode .menu a,
body.light-mode .section-tag,
body.light-mode h2,
body.light-mode .hero-label,
body.light-mode .miniabout p,
body.light-mode .minicompetences li,
body.light-mode .button-cta,
body.light-mode .button-voirplus,
body.light-mode .scroll-indicator,
body.light-mode .about-text p,
body.light-mode .stat-label,
body.light-mode .skill-card h3,
body.light-mode .skill-card p,
body.light-mode .contact-sub,
body.light-mode .contact-social,
body.light-mode .footer-info p,
body.light-mode .footer-info a {
color: #000000;
}
body.light-mode .footer-link,
body.light-mode .miniabout p strong {
color: #ff0000;
list-style: none;
}
body.light-mode .button-contact {
color: #0d0d0d;
border-color: rgba(0, 0, 0, 0.2);
}
body.light-mode .button-contact:hover {
color: #0d0d0d;
border-color: #0d0d0d;
background: rgba(0, 0, 0, 0.06);
}

body.light-mode .menu a:hover {
background: rgba(0, 0, 0, 0.05);
}
body.light-mode .menu a::after {
background: #0d0d0d;
}

body.light-mode .button-cta {
border-color: #555;
}
body.light-mode .button-cta:hover {
background: #0d0d0d;
color: #f5f5f5;
}

body.light-mode .button-voirplus {
border-color: rgba(0, 0, 0, 0.2);
}
body.light-mode .button-voirplus:hover {
border-color: #0d0d0d;
}

body.light-mode .about,
body.light-mode .competences,
body.light-mode .contact,
body.light-mode footer {
border-top-color: rgba(0, 0, 0, 0.1);
}

body.light-mode .stat {
background: #ebebeb;
}
body.light-mode .stat:hover {
background: #e0e0e0;
}
body.light-mode .about-stats {
border-color: rgba(0, 0, 0, 0.1);
}

body.light-mode .skills-grid {
border-color: rgba(0, 0, 0, 0.1);
}
body.light-mode .skill-card {
background: #ebebeb;
}
body.light-mode .skill-card:hover {
background: #e0e0e0;
}

body.light-mode .contact-form input,
body.light-mode .contact-form textarea {
background: #ebebeb;
border-color: rgba(0, 0, 0, 0.1);
color: #0d0d0d;
}
body.light-mode .contact-form input::placeholder,
body.light-mode .contact-form textarea::placeholder {
color: #666;
}
body.light-mode .contact-form input:focus,
body.light-mode .contact-form textarea:focus {
background: #e0e0e0;
border-color: #0d0d0d;
box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.1);
}

body.light-mode .contact-form button[type="submit"] {
border-color: #555;
color: #0d0d0d;
}
body.light-mode .contact-form button[type="submit"]:hover {
background: #0d0d0d;
color: #f5f5f5;
border-color: #0d0d0d;
box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
}

body.light-mode .minicompetences li {
border-bottom-color: rgba(0, 0, 0, 0.08);
}

body.light-mode .contact-social a {
border-bottom-color: rgba(0, 0, 0, 0.15);
}

/_ MEDIA PROJET - DETAIL _/
.project-media-full {
width: 100%;
max-width: 860px;
margin: 2rem auto;
border-radius: 12px;
overflow: hidden;
}

.project-media-full img,
.project-media-full video {
width: 100%;
height: auto;
display: block;
}
ce que j'ai fait :
j'ai intégré .upload-btn-wrapper et .btn-upload directement dans le style de la section projets.

le bouton est en pointillés avec une police Syncopate très petite (0.55rem) pour rester dans le look "chrome luxury".

il accepte tout type de fichier (vidéo/gif) via un <input type="file"> invisible placé par-dessus.

par contre j'aimerai que dans la list les card deviennes couleur chrome quand on passe en light mode

Gemini a dit
c'est noté, j'ai ajouté la règle dans la section light-mode à la fin du fichier. maintenant, quand tu passes en mode clair, tes cartes de projets deviennent argentées/chrome au survol avec un dégradé métallique.

voici le code complet :

CSS
/_ ========================================
CS WEB PORTFOLIO — CHROME LUXURY THEME
======================================== _/

/_ IMPORTS _/
@import url("https://fonts.googleapis.com/css2?family=Syncopate:wght@400;700&family=Rajdhani:wght@300;400;500;600&display=swap");

/_ RESET _/
_,
_::before,
\*::after {
margin: 0;
padding: 0;
box-sizing: border-box;
}

html {
scroll-behavior: smooth;
font-size: 16px;
}

body {
background-color: #0d0d0d;
color: #ffffff;
font-family: "Rajdhani", sans-serif;
font-weight: 400;
line-height: 1.6;
overflow-x: hidden;
}

a {
color: inherit;
text-decoration: none;
}
img {
display: block;
max-width: 100%;
}
ul {
list-style: none;
}

/_ GRAIN TEXTURE OVERLAY _/
.grain {
position: fixed;
inset: 0;
z-index: 9999;
pointer-events: none;
opacity: 0.035;
background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
background-size: 150px;
}

/_ ========================
HEADER
======================== _/
header {
position: sticky;
top: 0;
z-index: 1000;
height: 72px;
display: flex;
align-items: center;
justify-content: space-between;
padding: 0 40px;
max-width: 1280px;
margin: 0 auto;
background: rgba(13, 13, 13, 0.92);
backdrop-filter: blur(12px);
-webkit-backdrop-filter: blur(12px);
border-bottom: 1px solid rgba(255, 255, 255, 0.08);
}

header::before {
content: "";
position: absolute;
inset: 0;
left: -100vw;
right: -100vw;
background: rgba(13, 13, 13, 0.92);
backdrop-filter: blur(12px);
border-bottom: 1px solid rgba(255, 255, 255, 0.08);
z-index: -1;
}

.logo {
height: 44px;
width: auto;
object-fit: contain;
filter: brightness(1.1);
transition: filter 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}
.logo-link:hover .logo {
filter: brightness(1.3);
}

.menu ul {
display: flex;
gap: 4px;
}

.menu li {
position: relative;
}

.menu a {
display: block;
padding: 6px 14px;
font-family: "Syncopate", sans-serif;
font-size: 0.6rem;
letter-spacing: 0.12em;
color: #ffffff;
border-radius: 30px;
transition:
color 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94),
background 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}

.menu a::after {
content: "";
position: absolute;
bottom: 4px;
left: 50%;
transform: translateX(-50%);
width: 0;
height: 1px;
background: #f0f0f0;
transition: width 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}

.menu a:hover {
color: #ffffff;
background: rgba(255, 255, 255, 0.05);
}
.menu a:hover::after {
width: 50%;
}

.link ul {
display: flex;
gap: 8px;
}

.button-contact {
display: flex;
justify-content: center;
align-items: center;
width: 34px;
height: 34px;
border-radius: 50%;
border: 1px solid rgba(255, 255, 255, 0.2);
color: #ffffff;
font-size: 0.85rem;
transition:
color 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94),
border-color 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94),
background 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}
.button-contact:hover {
color: #ffffff;
border-color: #ffffff;
background: rgba(255, 255, 255, 0.06);
}

/_ ========================
MAIN WRAPPER
======================== _/
main {
max-width: 1280px;
margin: 0 auto;
padding: 0 40px;
}

/_ ========================
SECTION COMMONS
======================== _/
section {
height: calc(100vh - 72px);
min-height: 0;
padding: 40px 0;
scroll-margin-top: 72px;
display: flex;
flex-direction: column;
justify-content: center;
overflow: hidden;
}

.section-tag {
font-family: "Syncopate", sans-serif;
font-size: 0.55rem;
letter-spacing: 0.2em;
color: #ffffff;
margin-bottom: 20px;
text-transform: uppercase;
}

h2 {
font-family: "Syncopate", sans-serif;
font-size: clamp(2rem, 5vw, 3.5rem);
font-weight: 700;
line-height: 1.1;
letter-spacing: -0.02em;
color: #ffffff;
margin-bottom: 28px;
}

/_ ========================
HERO / PRESENTATION
======================== _/
.presentation {
height: calc(100vh - 72px);
min-height: 0;
display: flex;
flex-direction: column;
justify-content: center;
position: relative;
padding-top: 40px;
padding-bottom: 40px;
overflow: hidden;
}

.hero-label {
display: flex;
gap: 16px;
align-items: center;
font-family: "Syncopate", sans-serif;
font-size: 0.5rem;
letter-spacing: 0.25em;
color: #ffffff;
margin-bottom: 32px;
text-transform: uppercase;
opacity: 0;
animation: fadeUp 0.8s ease forwards 0.2s;
}
.hero-label .dot {
color: #ffffff;
font-size: 1.2rem;
}

.presentation h1 {
font-family: "Syncopate", sans-serif;
font-size: clamp(3rem, 8vw, 7rem);
font-weight: 500;
line-height: 1.05;
letter-spacing: -0.03em;
text-transform: uppercase;
margin-bottom: 80px;
opacity: 0;
animation: fadeUp 0.8s ease forwards 0.4s;
text-align: center;
}

.presentation h1 em {
font-style: normal;
background: linear-gradient(135deg, #c8c8c8 0%, #f0f0f0 50%, #acaaaa 100%);
-webkit-background-clip: text;
-webkit-text-fill-color: transparent;
background-clip: text;
}

.hero-layout {
display: grid;
grid-template-columns: 1fr auto 1fr;
gap: 40px;
align-items: center;
opacity: 0;
animation: fadeUp 0.8s ease forwards 0.6s;
}

.miniabout {
padding: 32px;
}

.miniabout p {
font-family: "Rajdhani", sans-serif;
font-size: 1.1rem;
font-weight: 300;
line-height: 1.8;
color: #ffffff;
margin-bottom: 28px;
}

.miniabout p strong {
color: #ffffff;
font-weight: 600;
}

.button-cta {
display: inline-block;
padding: 10px 24px;
border: 1px solid #b3b3b3;
border-radius: 30px;
font-family: "Syncopate", sans-serif;
font-size: 0.55rem;
letter-spacing: 0.12em;
color: #ffffff;
transition:
background 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94),
color 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}
.button-cta:hover {
background: #ffffff;
color: #0d0d0d;
}

.photo-wrapper {
position: relative;
display: flex;
justify-content: center;
}

.photo-ring {
position: absolute;
inset: -12px;
border-radius: 50% 50% 50% 50% / 60% 60% 40% 40%;
border: 1px solid rgba(255, 255, 255, 0.08);
animation: pulse 4s ease-in-out infinite;
}

@keyframes pulse {
0%, 100% { transform: scale(1); opacity: 0.4; }
50% { transform: scale(1.02); opacity: 0.8; }
}

.myphoto {
width: 500px;
height: 600px;
object-fit: cover;
object-position: top;
margin-top: -90px;
position: relative;
right: -20px;
top: -140px;
-webkit-mask-image: linear-gradient(to bottom, rgba(0,0,0,1) 65%, rgba(0,0,0,0) 100%);
mask-image: linear-gradient(to bottom, rgba(0,0,0,1) 65%, rgba(0,0,0,0) 100%);
}

.minicompetences {
padding: 32px;
text-align: right;
}

.minicompetences ul {
margin-bottom: 28px;
}

.minicompetences li {
font-family: "Syncopate", sans-serif;
font-size: 0.65rem;
letter-spacing: 0.1em;
color: #ffffff;
padding: 8px 0;
border-bottom: 1px solid rgba(255, 255, 255, 0.08);
transition: color 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}
.minicompetences li:last-child { border-bottom: none; }
.minicompetences li:hover { color: #ffffff; }

.button-voirplus {
display: inline-flex;
align-items: center;
gap: 8px;
padding: 10px 24px;
border: 1px solid rgba(255, 255, 255, 0.2);
border-radius: 30px;
font-family: "Syncopate", sans-serif;
font-size: 0.55rem;
letter-spacing: 0.12em;
color: #ffffff;
transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}
.button-voirplus:hover {
border-color: #ffffff;
color: #ffffff;
transform: translateX(-4px);
}

.scroll-indicator {
position: absolute;
bottom: 40px;
left: 50%;
transform: translateX(-50%);
display: flex;
flex-direction: column;
align-items: center;
gap: 12px;
font-family: "Syncopate", sans-serif;
font-size: 0.45rem;
letter-spacing: 0.2em;
color: #ffffff;
opacity: 0;
animation: fadeUp 0.8s ease forwards 1.2s;
}

.scroll-line {
width: 1px;
height: 50px;
background: linear-gradient(to bottom, #888888, transparent);
animation: scrollPulse 2s ease-in-out infinite;
}

@keyframes scrollPulse {
0%, 100% { opacity: 0.4; transform: scaleY(1); }
50% { opacity: 1; transform: scaleY(0.8); }
}

/_ ========================================
SECTION PROJETS
======================================== _/
.projets {
height: auto !important;
min-height: 100vh;
border-top: 1px solid rgba(255, 255, 255, 0.08);
padding-bottom: 100px;
overflow: visible;
}

.projects-grid {
display: grid;
grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
gap: 30px;
padding: 40px 0;
}

.project-card {
background: #141414;
border: 1px solid rgba(255, 255, 255, 0.08);
border-radius: 20px;
overflow: hidden;
transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
display: flex;
flex-direction: column;
}

.project-card:hover {
transform: translateY(-10px);
border-color: #ffffff;
box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
}

.project-media-thumb {
width: 100%;
aspect-ratio: 16 / 9;
overflow: hidden;
}

.project-media-thumb img,
.project-media-thumb video {
width: 100%;
height: 100%;
object-fit: cover;
}

.project-card-body {
padding: 24px;
flex-grow: 1;
display: flex;
flex-direction: column;
}

.project-card-body h3 {
font-family: "Syncopate", sans-serif;
font-size: 1.1rem;
text-transform: uppercase;
margin-bottom: 20px;
}

.project-actions {
display: flex;
flex-wrap: wrap;
gap: 12px;
margin-top: auto;
}

.upload-btn-wrapper {
position: relative;
overflow: hidden;
display: inline-block;
}

.btn-upload {
border: 1px dashed rgba(255, 255, 255, 0.3);
color: rgba(255, 255, 255, 0.6);
background-color: transparent;
padding: 8px 16px;
border-radius: 30px;
font-size: 0.55rem;
font-family: "Syncopate", sans-serif;
text-transform: uppercase;
cursor: pointer;
transition: all 0.3s ease;
}

.upload-btn-wrapper:hover .btn-upload {
border-color: #ffffff;
color: #ffffff;
background: rgba(255, 255, 255, 0.05);
}

.upload-btn-wrapper input[type=file] {
font-size: 100px;
position: absolute;
left: 0;
top: 0;
opacity: 0;
cursor: pointer;
}

/_ ========================
SECTION À PROPOS
======================== _/
.about { border-top: 1px solid rgba(255, 255, 255, 0.08); }

.about-content {
display: grid;
grid-template-columns: 1fr 1fr;
gap: 48px;
align-items: start;
}

.about-text { display: flex; flex-direction: column; gap: 12px; }

.about-text p {
font-family: "Rajdhani", sans-serif;
font-size: 1rem;
font-weight: 300;
line-height: 1.7;
color: #ffffffaaa;
}

.about-text p strong { color: #ffffff; font-weight: 600; }

.about-stats {
display: flex;
flex-direction: column;
gap: 1px;
border: 1px solid rgba(255, 255, 255, 0.08);
border-radius: 16px;
overflow: hidden;
}

.stat {
display: flex;
align-items: center;
justify-content: space-between;
padding: 18px 24px;
background: #141414;
transition: background 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}
.stat:hover { background: #1a1a1a; }

.stat-num {
font-family: "Syncopate", sans-serif;
font-size: 2.5rem;
font-weight: 700;
background: linear-gradient(135deg, #c8c8c8 0%, #f0f0f0 50%, #acaaaa 100%);
-webkit-background-clip: text;
-webkit-text-fill-color: transparent;
background-clip: text;
}

.stat-label {
font-family: "Rajdhani", sans-serif;
font-size: 0.9rem;
letter-spacing: 0.08em;
color: #ffffff;
text-transform: uppercase;
}

/_ ========================
SECTION COMPÉTENCES
======================== _/
.competences { border-top: 1px solid rgba(255, 255, 255, 0.08); }

.skills-grid {
display: grid;
grid-template-columns: repeat(3, 1fr);
gap: 1px;
border: 1px solid rgba(255, 255, 255, 0.08);
border-radius: 16px;
overflow: hidden;
}

.skill-card {
background: #141414;
padding: 24px 24px;
display: flex;
flex-direction: column;
gap: 10px;
transition: background 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
position: relative;
overflow: hidden;
}

.skill-card::before {
content: "";
position: absolute;
inset: 0;
background: linear-gradient(135deg, rgba(255,255,255,0.04) 0%, transparent 60%);
opacity: 0;
transition: opacity 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}

.skill-card:hover { background: #1a1a1a; }
.skill-card:hover::before { opacity: 1; }

.skill-icon {
font-size: 2rem;
background: linear-gradient(135deg, #c8c8c8 0%, #f0f0f0 50%, #acaaaa 100%);
-webkit-background-clip: text;
-webkit-text-fill-color: transparent;
background-clip: text;
}

.skill-card h3 {
font-family: "Syncopate", sans-serif;
font-size: 0.7rem;
font-weight: 700;
letter-spacing: 0.08em;
color: #ffffff;
text-transform: uppercase;
}

.skill-card p {
font-family: "Rajdhani", sans-serif;
font-size: 0.95rem;
font-weight: 300;
color: #ffffff;
line-height: 1.6;
}

/_ ========================
SECTION CONTACT
======================== _/
.contact { border-top: 1px solid rgba(255, 255, 255, 0.08); text-align: center; }
.contact h2 { margin-bottom: 12px; }

.contact-sub {
font-family: "Rajdhani", sans-serif;
font-size: 1.1rem;
font-weight: 300;
color: #ffffff;
margin-bottom: 32px;
}

.contact-form {
max-width: 720px;
margin: 0 auto 40px;
display: flex;
flex-direction: column;
gap: 16px;
}

.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

.contact-form input,
.contact-form textarea {
padding: 16px 20px;
border: 1px solid rgba(255, 255, 255, 0.08);
border-radius: 10px;
background-color: #141414;
color: #ffffff;
font-family: "Rajdhani", sans-serif;
font-size: 1rem;
transition: all 0.3s ease;
width: 100%;
}

.contact-form input::placeholder,
.contact-form textarea::placeholder { color: #ffffff; }

.contact-form input:focus,
.contact-form textarea:focus {
outline: none;
border-color: #ffffff;
background: #1a1a1a;
}

.contact-form textarea { resize: vertical; min-height: 100px; }

.contact-form button[type="submit"] {
display: inline-flex;
align-items: center;
justify-content: center;
gap: 10px;
padding: 14px 32px;
border: 1px solid #b3b3b3;
border-radius: 30px;
background-color: transparent;
color: #ffffff;
font-family: "Syncopate", sans-serif;
font-size: 0.6rem;
letter-spacing: 0.12em;
cursor: pointer;
transition: all 0.3s ease;
align-self: center;
}

.contact-form button[type="submit"]:hover {
background-color: #ffffff;
color: #0d0d0d;
}

.contact-social {
font-family: "Rajdhani", sans-serif;
font-size: 0.9rem;
color: #ffffff;
}

.contact-social a {
color: #ffffff;
border-bottom: 1px solid rgba(255, 255, 255, 0.08);
padding-bottom: 1px;
}

/_ ========================
FOOTER
======================== _/
footer {
border-top: 1px solid rgba(255, 255, 255, 0.08);
padding: 40px;
max-width: 1280px;
margin: 0 auto;
display: flex;
align-items: center;
justify-content: space-between;
}

.logo-text {
font-family: "Syncopate", sans-serif;
font-size: 1.2rem;
letter-spacing: 0.1em;
color: #ffffff;
text-transform: uppercase;
}

.footer-info p {
font-family: "Rajdhani", sans-serif;
font-size: 0.85rem;
color: #ffffff;
}

/_ ========================
ANIMATIONS GLOBALES
======================== _/
@keyframes fadeUp {
from { opacity: 0; transform: translateY(30px); }
to { opacity: 1; transform: translateY(0); }
}

/_ ========================
THEME TOGGLE
======================== _/
.theme-toggle { background: none; border: none; cursor: pointer; padding: 0; }
.theme-toggle-track {
position: relative;
display: flex;
align-items: center;
width: 110px;
height: 32px;
border-radius: 30px;
border: 1px solid rgba(255, 255, 255, 0.2);
background: rgba(255, 255, 255, 0.04);
padding: 3px;
}
.theme-toggle-thumb {
position: absolute;
left: 3px;
width: 50px;
height: 24px;
border-radius: 20px;
background: #ffffff;
transition: transform 0.35s ease;
z-index: 1;
}
.theme-label {
position: absolute;
font-family: "Syncopate", sans-serif;
font-size: 0.42rem;
letter-spacing: 0.12em;
font-weight: 700;
z-index: 2;
pointer-events: none;
}
.theme-label-dark { left: 13px; color: #0d0d0d; }
.theme-label-light { right: 10px; color: #ffffff; opacity: 0.5; }

/_ ========================
RESPONSIVE (SIMPLIFIÉ)
======================== _/
@media (max-width: 768px) {
.menu { display: none; }
.hero-layout { grid-template-columns: 1fr; text-align: center; }
.myphoto { width: 160px; height: 200px; position: static; }
.form-row { grid-template-columns: 1fr; }
}

/_ ========================================
LIGHT MODE (RÈGLES ICI)
======================================== _/
body.light-mode {
background-color: #f5f5f5;
color: #0d0d0d;
}

body.light-mode .theme-toggle-thumb {
background: #0d0d0d;
transform: translateX(54px);
}

body.light-mode .theme-label-dark { color: #ffffff; opacity: 0.5; }
body.light-mode .theme-label-light { color: #0d0d0d; opacity: 1; }

body.light-mode header,
body.light-mode header::before {
background: rgba(245, 245, 245, 0.92);
border-bottom-color: rgba(0, 0, 0, 0.1);
}

body.light-mode .logo-text,
body.light-mode .menu a,
body.light-mode .section-tag,
body.light-mode h2,
body.light-mode .hero-label,
body.light-mode .miniabout p,
body.light-mode .minicompetences li,
body.light-mode .button-cta,
body.light-mode .button-voirplus,
body.light-mode .about-text p,
body.light-mode .stat-label,
body.light-mode .skill-card h3,
body.light-mode .skill-card p,
body.light-mode .contact-sub,
body.light-mode .footer-info p {
color: #000000;
}

body.light-mode .projets,
body.light-mode .about,
body.light-mode .competences,
body.light-mode .contact,
body.light-mode footer {
border-top-color: rgba(0, 0, 0, 0.1);
}

/_ CARTES PROJETS EN LIGHT MODE — CHROME LOOK _/
body.light-mode .project-card {
background: #ffffff;
border-color: rgba(0, 0, 0, 0.1);
}

body.light-mode .project-card:hover {
background: linear-gradient(135deg, #e0e0e0 0%, #ffffff 50%, #d1d1d1 100%);
border-color: #0d0d0d;
box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
}

body.light-mode .btn-upload {
border-color: rgba(0, 0, 0, 0.2);
color: rgba(0, 0, 0, 0.6);
}

body.light-mode .upload-btn-wrapper:hover .btn-upload {
border-color: #0d0d0d;
color: #0d0d0d;
background: rgba(0, 0, 0, 0.05);
}

body.light-mode .stat,
body.light-mode .skill-card {
background: #ebebeb;
}

body.light-mode .contact-form input,
body.light-mode .contact-form textarea {
background: #ebebeb;
border-color: rgba(0, 0, 0, 0.1);
color: #0d0d0d;
}

body.light-mode .contact-form button[type="submit"] {
border-color: #0d0d0d;
color: #0d0d0d;
}

body.light-mode .contact-form button[type="submit"]:hover {
background: #0d0d0d;
color: #f5f5f5;
}
ce que j'ai ajouté :
effet chrome en mode clair : quand tu passes la souris sur une carte projet en light-mode, elle prend un dégradé métallique (linear-gradient) qui rappelle l'aspect chrome brossé.

visibilité : j'ai ajusté la couleur du bouton d'upload en mode clair pour qu'il soit bien lisible sur fond blanc (gris foncé/noir au lieu de blanc transparent).

est-ce que cet effet "chrome" te convient ou tu veux quelque chose de plus brillant/miroir ?
