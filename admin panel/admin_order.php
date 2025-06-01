INSERT INTO `orders` (
    `user_id`, `seller_id`, `name`, `number`, `email`, `address`, `address_type`,
    `method`, `product_id`, `price`, `qty`, `date`, `status`, `payment_status`
) VALUES (
    '2',                     -- ID de l'utilisateur
    '1',                     -- ID du vendeur
    'Jean Dupont',           -- Nom du client
    '0123456789',            -- Numéro de téléphone
    'jean@example.com',      -- Email
    '123 Rue de Paris, Lyon',-- Adresse
    'domicile',              -- Type d'adresse
    'carte bancaire',        -- Méthode de paiement
    '5',                     -- ID du produit
    '29.99',                 -- Prix unitaire
    '2',                     -- Quantité
    NOW(),                   -- Date actuelle
    'en attente',            -- Statut de la commande
    'non payé'               -- Statut de paiement
);
