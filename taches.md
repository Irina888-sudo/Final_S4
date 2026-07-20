Découpage : Personne A (toi) / Personne B (ton binôme)
Étape 1 — SÉQUENTIELLE, obligatoire, tout le monde attend (20 min)

Une seule personne code, l'autre ne peut pas commencer sans ça :

Personne A : migrations + seeders (les 6 tables + données de test)
Personne B pendant ce temps (non-bloquant, en parallèle) : monte le layout HTML de base (app/Views/layout.php), navbar, structure des dossiers Views/operateur/ et Views/client/, prépare les routes vides dans Routes.php

→ Sync obligatoire à la fin : Personne A push, Personne B pull. Vérifiez ensemble que les tables sont bonnes avant de continuer.

Étape 2 — PARALLÈLE, split net par espace (le gros du travail)
	Personne A — Espace OPÉRATEUR	Personne B — Espace CLIENT
1	Login + filter opérateur (15 min)	Login + filter client (15 min)
2	CRUD Préfixes (25 min)	Dashboard + affichage solde (15 min)
3	CRUD Types + Barèmes (25 min)	Dépôt (20 min)
4	Situation gains (readonly) (10 min)	Retrait (20 min)
5	Situation comptes (readonly) (10 min)	Historique (15 min)

Aucune dépendance entre A et B pendant cette phase → vous codez en même temps sans vous marcher dessus (fichiers différents, pas de conflit git).

Étape 3 — SÉQUENTIELLE, à faire ensemble (dernière partie, ~20-25 min)

Le transfert touche 2 comptes clients → dépend du dépôt/retrait déjà fait par B. Faites-le à deux (l'un code, l'autre relit/teste), c'est la partie la plus risquée en bug.

Étape 4 — Ensemble (10 min)
Test croisé : A teste le flow client de B, B teste le flow opérateur de A
Merge final, tag v1, livraison
Règle git pour éviter les conflits
Chacun sur sa branche (feature/operateur, feature/client)
Commit/push toutes les 15-20 min
Merge dans main seulement après l'étape 2, pas avant

Vous voulez qu'on démarre le code des migrations (étape 1, la partie bloquante) tout de suite ?