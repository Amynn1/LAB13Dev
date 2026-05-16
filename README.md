# LAB13Dev
# LAB 13 – Système de Suivi GPS en Temps Réel

## 📱 Présentation du projet

Ce LAB a pour objectif de mettre en place une application mobile Android capable de :

* 📍 Détecter et récupérer les coordonnées GPS de l'appareil
* 🌐 Transmettre ces coordonnées vers un serveur web local (XAMPP)
* 🗄️ Persister les données de localisation dans une base de données MySQL
* 🗺️ Visualiser la position géographique sur une carte interactive via OSMDroid (OpenStreetMap)

---

## 🛠️ Stack technique

| Côté | Technologie |
|------|-------------|
| Mobile | Java – Android Studio |
| Cartographie | OSMDroid (OpenStreetMap) |
| Réseau | Volley (HTTP) |
| Serveur | PHP – XAMPP |
| Base de données | MySQL |

---

## ⚙️ Fonctionnalités implémentées

* ✔ Acquisition de la position GPS en temps réel
* ✔ Envoi des coordonnées au backend via requête HTTP POST
* ✔ Enregistrement des données (latitude, longitude, horodatage) en base
* ✔ Rendu cartographique avec marqueur de position
* ✔ Interface épurée avec bouton de déclenchement

---

## 📸 Aperçu de l'application

🔹 Interface principale

🔹 Carte avec marqueur GPS

---

## 🗄️ Structure de la base de données

```sql
CREATE TABLE localisation (
    id        INT AUTO_INCREMENT PRIMARY KEY,
    latitude  DOUBLE       NOT NULL,
    longitude DOUBLE       NOT NULL,
    timestamp DATETIME     DEFAULT NOW()
);
```

---

## 🌐 Script PHP – Réception des coordonnées

```php
<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=gps_tracker", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $latitude  = $_POST['latitude']  ?? null;
    $longitude = $_POST['longitude'] ?? null;

    if ($latitude && $longitude) {
        $query = "INSERT INTO localisation (latitude, longitude) VALUES (:lat, :lon)";
        $stmt  = $pdo->prepare($query);
        $stmt->execute([':lat' => $latitude, ':lon' => $longitude]);
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Données manquantes"]);
    }
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>
```

---

## 🚀 Guide de démarrage

1. Démarrer **XAMPP** (modules Apache + MySQL)
2. Créer la base de données `gps_tracker` via phpMyAdmin
3. Placer le fichier PHP dans `htdocs/gps_tracker/`
4. Exécuter le script SQL pour créer la table `localisation`
5. Ouvrir le projet dans **Android Studio** et le lancer
6. Accorder la permission de localisation à l'application
7. Appuyer sur **Afficher la carte** pour déclencher la géolocalisation

---

## ⚠️ Points importants  
<img width="389" height="740" alt="image" src="https://github.com/user-attachments/assets/1664cf2a-bc34-468c-b66c-b5dafef0c007" />
<img width="389" height="740" alt="image" src="https://github.com/user-attachments/assets/d5032f44-81e1-42b3-91ca-fe848bd1be8d" />


* Depuis l'émulateur Android, utiliser l'adresse `10.0.2.2` pour joindre `localhost`
* Vérifier que le GPS est bien activé dans les paramètres de l'émulateur
* Les permissions suivantes sont requises dans `AndroidManifest.xml` :
  ```xml
  <uses-permission android:name="android.permission.ACCESS_FINE_LOCATION" />
  <uses-permission android:name="android.permission.INTERNET" />
  ```

---

## 🎯 Résultats obtenus

* 📍 Coordonnées GPS récupérées et affichées correctement
* 🗄️ Enregistrements insérés avec succès dans MySQL
* 🗺️ Carte OSMDroid chargée avec marqueur positionné sur la localisation réelle
