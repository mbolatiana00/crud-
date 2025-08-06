-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 06, 2025 at 03:51 PM
-- Server version: 5.7.39
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `restaurant`
--

-- --------------------------------------------------------

--
-- Table structure for table `commandes`
--

CREATE TABLE `commandes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_nom` varchar(100) DEFAULT NULL,
  `client_email` varchar(100) DEFAULT NULL,
  `client_telephone` varchar(20) DEFAULT NULL,
  `table_number` int(11) DEFAULT NULL,
  `date_commande` datetime DEFAULT CURRENT_TIMESTAMP,
  `statut` enum('en_attente','en_preparation','pret','livre','annule') DEFAULT 'en_attente',
  `mode_consommation` enum('sur_place','a_emporter','livraison') DEFAULT NULL,
  `adresse_livraison` text,
  `commentaires` text,
  `total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `commandes`
--

INSERT INTO `commandes` (`id`, `user_id`, `client_nom`, `client_email`, `client_telephone`, `table_number`, `date_commande`, `statut`, `mode_consommation`, `adresse_livraison`, `commentaires`, `total`) VALUES
(58, 5, 'travis', 'lovambolatia@gmail.com', '4544535332', NULL, '2025-08-05 13:56:43', 'en_preparation', 'a_emporter', NULL, '', '36.00'),
(59, 5, 'travis', 'lovambolatia@gmail.com', '4544535332', NULL, '2025-08-05 13:58:48', 'en_preparation', 'livraison', '', '', '7.20'),
(60, 5, 'travis', 'lovambolatia@gmail.com', '4544535332', NULL, '2025-08-05 14:02:40', 'en_preparation', 'a_emporter', NULL, '', '7.20'),
(61, 5, 'travis', 'lovambolatia@gmail.com', '4544535332', NULL, '2025-08-05 19:42:47', 'pret', 'a_emporter', NULL, '', '7.20'),
(62, 5, 'travis', 'lovambolatia@gmail.com', '4544535332', NULL, '2025-08-05 19:48:00', 'pret', 'a_emporter', NULL, '', '9.00'),
(63, 5, 'travis', 'lovambolatia@gmail.com', '4544535332', NULL, '2025-08-05 19:48:40', 'pret', 'a_emporter', NULL, '', '7.20'),
(64, 5, 'mbola', 'lovambolatia@gmail.com', '4544535332', NULL, '2025-08-06 18:46:54', 'en_attente', 'a_emporter', NULL, '', '7.20');

-- --------------------------------------------------------

--
-- Table structure for table `commandes_items`
--

CREATE TABLE `commandes_items` (
  `id` int(11) NOT NULL,
  `commande_id` int(11) NOT NULL,
  `menu_item_id` int(11) NOT NULL,
  `item_name` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL,
  `prix_unitaire` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `commandes_items`
--

INSERT INTO `commandes_items` (`id`, `commande_id`, `menu_item_id`, `item_name`, `quantity`, `prix_unitaire`, `created_at`) VALUES
(71, 58, 2, 'Bruschetta', 5, '7.20', '2025-08-05 10:56:43'),
(72, 59, 2, 'Bruschetta', 1, '7.20', '2025-08-05 10:58:48'),
(73, 60, 2, 'Bruschetta', 1, '7.20', '2025-08-05 11:02:40'),
(74, 61, 2, 'Bruschetta', 1, '7.20', '2025-08-05 16:42:47'),
(75, 62, 3, 'Soupe à l\'oignon', 1, '9.00', '2025-08-05 16:48:00'),
(76, 63, 2, 'Bruschetta', 1, '7.20', '2025-08-05 16:48:40'),
(77, 64, 2, 'Bruschetta', 1, '7.20', '2025-08-06 15:46:54');

-- --------------------------------------------------------

--
-- Table structure for table `commande_details`
--

CREATE TABLE `commande_details` (
  `id` int(11) NOT NULL,
  `commande_id` int(11) NOT NULL,
  `menu_item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '1',
  `special_requests` text,
  `prix_unitaire` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `livraisons`
--

CREATE TABLE `livraisons` (
  `id` int(11) NOT NULL,
  `commande_id` int(11) NOT NULL,
  `livreur_id` int(11) DEFAULT NULL,
  `heure_livraison_prevue` datetime NOT NULL,
  `heure_livraison_reelle` datetime DEFAULT NULL,
  `statut` enum('en_attente','en_cours','livree','retard') DEFAULT 'en_attente',
  `notes` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  `price` decimal(10,2) NOT NULL,
  `category` varchar(50) DEFAULT NULL,
  `image` varchar(255) DEFAULT 'default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`id`, `name`, `description`, `price`, `category`, `image`) VALUES
(1, 'Salade César', 'Salade fraîche avec croûtons et parmesan', '8.50', 'Entrées', 'default.jpg'),
(2, 'Bruschetta', 'Pain grillé à l\'ail avec tomates et basilic', '7.20', 'Entrées', 'default.jpg'),
(3, 'Soupe à l\'oignon', 'Soupe traditionnelle française avec fromage fondu', '9.00', 'Entrées', 'default.jpg'),
(4, 'Tartare de saumon', 'Saumon frais coupé au couteau avec citron et aneth', '12.50', 'Entrées', 'default.jpg'),
(5, 'Foie gras', 'Foie gras de canard maison avec toast', '18.00', 'Entrées', 'default.jpg'),
(6, 'Carpaccio de bœuf', 'Tranches fines de bœuf avec parmesan et roquette', '14.50', 'Entrées', 'default.jpg'),
(7, 'Crevettes cocktail', 'Crevettes fraîches avec sauce cocktail maison', '13.00', 'Entrées', 'default.jpg'),
(8, 'Terrine de campagne', 'Terrine maison avec cornichons et pain grillé', '9.50', 'Entrées', 'default.jpg'),
(9, 'Oeufs mimosa', 'Oeufs durs farcis à la mayonnaise et moutarde', '6.50', 'Entrées', 'default.jpg'),
(10, 'Assiette de charcuterie', 'Sélection de charcuteries artisanales', '11.00', 'Entrées', 'default.jpg'),
(11, 'Gazpacho', 'Soupe froide andalouse à la tomate', '7.50', 'Entrées', 'default.jpg'),
(12, 'Avocat crevettes', 'Demi-avocat farci aux crevettes', '10.50', 'Entrées', 'default.jpg'),
(13, 'Croustillant de chèvre', 'Feuilleté au fromage de chèvre et miel', '8.00', 'Entrées', 'default.jpg'),
(14, 'Perles du Japon', 'Caviar végétal à la betterave et fromage frais', '9.50', 'Entrées', 'default.jpg'),
(15, 'Tartare d\'algues', 'Mélange d\'algues fraîches à l\'huile de sésame', '7.50', 'Entrées', 'default.jpg'),
(16, 'Granité de melon', 'Granité rafraîchissant au melon et menthe', '6.00', 'Entrées', 'default.jpg'),
(17, 'Velouté de champignons', 'Soupe onctueuse aux champignons des bois', '8.50', 'Entrées', 'default.jpg'),
(18, 'Feuilleté aux escargots', 'Feuilleté beurré aux escargots de Bourgogne', '12.00', 'Entrées', 'default.jpg'),
(19, 'Salade de chèvre chaud', 'Salade verte avec toast de chèvre tiède', '10.50', 'Entrées', 'default.jpg'),
(20, 'Assiette de crudités', 'Légumes frais de saison avec sauces', '7.00', 'Entrées', 'default.jpg'),
(21, 'Steak frites', 'Entrecôte 250g avec frites maison', '19.50', 'Plats principaux', 'default.jpg'),
(22, 'Poulet rôti', 'Poulet fermier rôti avec légumes de saison', '16.50', 'Plats principaux', 'default.jpg'),
(23, 'Saumon grillé', 'Filet de saumon avec purée de céleri', '18.00', 'Plats principaux', 'default.jpg'),
(24, 'Risotto aux champignons', 'Risotto crémeux aux cèpes et parmesan', '15.50', 'Plats principaux', 'default.jpg'),
(25, 'Magret de canard', 'Magret grillé avec sauce aux figues', '21.00', 'Plats principaux', 'default.jpg'),
(26, 'Lasagnes bolognaise', 'Lasagnes maison à la viande de boeuf', '14.50', 'Plats principaux', 'default.jpg'),
(27, 'Burger gourmet', 'Burger 180g avec cheddar et oignons confits', '13.50', 'Plats principaux', 'default.jpg'),
(28, 'Ratatouille niçoise', 'Légumes provençaux mijotés avec riz basmati', '12.50', 'Plats principaux', 'default.jpg'),
(29, 'Couscous royal', 'Couscous avec agneau, poulet et merguez', '17.50', 'Plats principaux', 'default.jpg'),
(30, 'Bouillabaisse', 'Soupe de poissons méditerranéenne', '22.00', 'Plats principaux', 'default.jpg'),
(31, 'Filet mignon', 'Filet mignon de porc à la moutarde', '16.00', 'Plats principaux', 'default.jpg'),
(32, 'Tajine d\'agneau', 'Tajine aux pruneaux et amandes', '18.50', 'Plats principaux', 'default.jpg'),
(33, 'Pâtes carbonara', 'Spaghetti à la carbonara traditionnelle', '13.00', 'Plats principaux', 'default.jpg'),
(34, 'Blanquette de veau', 'Veau mijoté à l\'ancienne', '17.00', 'Plats principaux', 'default.jpg'),
(35, 'Plateau de fruits de mer', 'Fruits de mer frais avec sauces', '25.00', 'Plats principaux', 'default.jpg'),
(36, 'Curry de légumes', 'Curry de légumes de saison au lait de coco', '14.00', 'Plats principaux', 'default.jpg'),
(37, 'Chili con carne', 'Chili épicé à la viande de boeuf', '15.00', 'Plats principaux', 'default.jpg'),
(38, 'Canard à l\'orange', 'Cuisses de canard confites à l\'orange', '19.50', 'Plats principaux', 'default.jpg'),
(39, 'Tartiflette', 'Gratin de pommes de terre avec reblochon', '16.00', 'Plats principaux', 'default.jpg'),
(40, 'Moules-frites', 'Moules marinières avec frites maison', '15.50', 'Plats principaux', 'default.jpg'),
(41, 'Pizza Margherita', 'Tomate, mozzarella, basilic', '12.00', 'Pizzas', 'default.jpg'),
(42, 'Pizza Reine', 'Tomate, mozzarella, jambon, champignons', '14.00', 'Pizzas', 'default.jpg'),
(43, 'Pizza 4 fromages', 'Tomate, mozzarella, gorgonzola, chèvre, parmesan', '15.00', 'Pizzas', 'default.jpg'),
(44, 'Pizza Calzone', 'Pizza repliée avec jambon, fromage et champignons', '13.50', 'Pizzas', 'default.jpg'),
(45, 'Pizza Romaine', 'Tomate, mozzarella, anchois, câpres', '13.00', 'Pizzas', 'default.jpg'),
(46, 'Pizza Végétarienne', 'Tomate, mozzarella, légumes grillés', '14.50', 'Pizzas', 'default.jpg'),
(47, 'Pizza Pepperoni', 'Tomate, mozzarella, pepperoni épicé', '14.00', 'Pizzas', 'default.jpg'),
(48, 'Pizza Hawaïenne', 'Tomate, mozzarella, jambon, ananas', '13.50', 'Pizzas', 'default.jpg'),
(49, 'Pizza Tartiflette', 'Crème fraîche, pommes de terre, reblochon, lardons', '15.50', 'Pizzas', 'default.jpg'),
(50, 'Pizza Provençale', 'Tomate, mozzarella, poivrons, oignons, olives', '13.50', 'Pizzas', 'default.jpg'),
(51, 'Pizza Quattro Stagioni', '4 quartiers différents: artichaut, jambon, champignons, olives', '16.00', 'Pizzas', 'default.jpg'),
(52, 'Pizza Diavola', 'Tomate, mozzarella, chorizo, piments', '14.50', 'Pizzas', 'default.jpg'),
(53, 'Pizza Norvégienne', 'Crème fraîche, saumon fumé, aneth', '17.00', 'Pizzas', 'default.jpg'),
(54, 'Pizza Raclette', 'Crème fraîche, pommes de terre, raclette, jambon cru', '16.50', 'Pizzas', 'default.jpg'),
(55, 'Pizza Forestière', 'Crème fraîche, mozzarella, champignons, lardons', '14.50', 'Pizzas', 'default.jpg'),
(56, 'Pizza Chevre Miel', 'Crème fraîche, chèvre, miel, noix', '15.00', 'Pizzas', 'default.jpg'),
(57, 'Pizza Orientale', 'Tomate, mozzarella, merguez, poivrons', '14.50', 'Pizzas', 'default.jpg'),
(58, 'Pizza BBQ', 'Sauce BBQ, mozzarella, poulet grillé, oignons', '15.00', 'Pizzas', 'default.jpg'),
(59, 'Pizza Truffe', 'Crème fraîche, mozzarella, champignons, huile de truffe', '18.00', 'Pizzas', 'default.jpg'),
(60, 'Pizza Fruits de Mer', 'Tomate, mozzarella, fruits de mer', '19.00', 'Pizzas', 'default.jpg'),
(61, 'Tiramisu', 'Dessert italien au café et mascarpone', '7.50', 'Desserts', 'default.jpg'),
(62, 'Crème brûlée', 'Crème vanille caramélisée', '7.00', 'Desserts', 'default.jpg'),
(63, 'Fondant au chocolat', 'Moelleux coulant au chocolat noir', '8.00', 'Desserts', 'default.jpg'),
(64, 'Tarte tatin', 'Tarte renversée aux pommes caramélisées', '7.50', 'Desserts', 'default.jpg'),
(65, 'Profiteroles', 'Choux garnis de glace vanille et chocolat chaud', '8.50', 'Desserts', 'default.jpg'),
(66, 'Mousse au chocolat', 'Mousse légère au chocolat noir', '6.50', 'Desserts', 'default.jpg'),
(67, 'Île flottante', 'Meringue sur crème anglaise', '6.50', 'Desserts', 'default.jpg'),
(68, 'Cheesecake', 'Cheesecake new-yorkais avec coulis de fruits rouges', '7.50', 'Desserts', 'default.jpg'),
(69, 'Panna cotta', 'Crème italienne à la vanille', '6.50', 'Desserts', 'default.jpg'),
(70, 'Soufflé au Grand Marnier', 'Soufflé léger à l\'orange', '9.00', 'Desserts', 'default.jpg'),
(71, 'Tarte au citron', 'Tarte acidulée au citron meringuée', '7.00', 'Desserts', 'default.jpg'),
(72, 'Glaces artisanales', '3 boules au choix', '6.50', 'Desserts', 'default.jpg'),
(73, 'Crêpe Suzette', 'Crêpes flambées à l\'orange', '8.50', 'Desserts', 'default.jpg'),
(74, 'Clafoutis aux cerises', 'Clafoutis traditionnel aux cerises', '7.00', 'Desserts', 'default.jpg'),
(75, 'Poire Belle Hélène', 'Poire pochée, glace vanille, chocolat', '8.00', 'Desserts', 'default.jpg'),
(76, 'Banana split', 'Glace vanille, chocolat, fraise avec banane', '8.50', 'Desserts', 'default.jpg'),
(77, 'Macarons', 'Assortiment de 6 macarons', '9.50', 'Desserts', 'default.jpg'),
(78, 'Millefeuille', 'Feuilleté à la crème pâtissière', '7.50', 'Desserts', 'default.jpg'),
(79, 'Eclair au café', 'Eclair garni de crème au café', '6.00', 'Desserts', 'default.jpg'),
(80, 'Salade de fruits frais', 'Fruits de saison coupés frais', '6.50', 'Desserts', 'default.jpg'),
(81, 'Eau minérale', 'Eau plate ou gazeuse 50cl', '2.50', 'Boissons', 'default.jpg'),
(82, 'Soda', 'Coca-Cola, Fanta, Sprite 33cl', '3.00', 'Boissons', 'default.jpg'),
(83, 'Jus de fruits', 'Jus d\'orange, pomme, multifruits 25cl', '3.50', 'Boissons', 'default.jpg'),
(84, 'Thé glacé', 'Thé glacé maison 50cl', '4.00', 'Boissons', 'default.jpg'),
(85, 'Bières pression', 'Demi (25cl) ou pinte (50cl)', '4.00', 'Boissons', 'default.jpg'),
(86, 'Vin au verre', 'Rouge, blanc ou rosé 12cl', '4.50', 'Boissons', 'default.jpg'),
(87, 'Champagne', 'Coupe de champagne brut', '9.00', 'Boissons', 'default.jpg'),
(88, 'Cocktails sans alcool', 'Mojito, Piña colada, etc.', '6.50', 'Boissons', 'default.jpg'),
(89, 'Café', 'Expresso, allongé, noisette', '2.00', 'Boissons', 'default.jpg'),
(90, 'Thé', 'Thé vert, noir, infusion', '2.50', 'Boissons', 'default.jpg'),
(91, 'Chocolat chaud', 'Chocolat chaud maison', '3.50', 'Boissons', 'default.jpg'),
(92, 'Limonade maison', 'Limonade artisanale', '4.50', 'Boissons', 'default.jpg'),
(93, 'Milkshake', 'Vanille, chocolat, fraise', '5.50', 'Boissons', 'default.jpg'),
(94, 'Smoothie', 'Smoothie fruits frais', '5.00', 'Boissons', 'default.jpg'),
(95, 'Whisky', 'Whisky single malt', '8.00', 'Boissons', 'default.jpg'),
(96, 'Digestif', 'Cognac, Armagnac, Calvados', '7.00', 'Boissons', 'default.jpg'),
(97, 'Eau aromatisée', 'Eau infusée aux fruits', '3.50', 'Boissons', 'default.jpg'),
(98, 'Lait frappé', 'Lait frappé à la vanille', '4.00', 'Boissons', 'default.jpg'),
(99, 'Jus de légumes', 'Jus de carotte, betterave, etc.', '4.50', 'Boissons', 'default.jpg'),
(100, 'Cidre', 'Cidre brut ou doux', '5.00', 'Boissons', 'default.jpg'),
(101, 'Nuggets de poulet', 'Nuggets avec frites et ketchup', '8.50', 'Menus enfants', 'default.jpg'),
(102, 'Steak haché', 'Steak haché avec purée et haricots verts', '9.00', 'Menus enfants', 'default.jpg'),
(103, 'Pâtes bolognaise', 'Pâtes avec sauce tomate et viande', '7.50', 'Menus enfants', 'default.jpg'),
(104, 'Omelette nature', 'Omelette avec salade et pain', '7.00', 'Menus enfants', 'default.jpg'),
(105, 'Fish sticks', 'Bâtonnets de poisson avec riz', '8.00', 'Menus enfants', 'default.jpg'),
(106, 'Petite pizza', 'Pizza margherita ou jambon', '7.50', 'Menus enfants', 'default.jpg'),
(107, 'Croque-monsieur', 'Croque-monsieur avec salade', '7.00', 'Menus enfants', 'default.jpg'),
(108, 'Assiette de crudités', 'Légumes coupés avec sauce', '6.50', 'Menus enfants', 'default.jpg'),
(109, 'Mini burger', 'Burger avec frites', '8.50', 'Menus enfants', 'default.jpg'),
(110, 'Galette de légumes', 'Galette de légumes avec compote', '7.50', 'Menus enfants', 'default.jpg'),
(111, 'Mini saucisses', 'Saucisses avec purée', '8.00', 'Menus enfants', 'default.jpg'),
(112, 'Pancakes', 'Pancakes avec sirop d\'érable', '6.50', 'Menus enfants', 'default.jpg'),
(113, 'Petite salade César', 'Salade César en version enfant', '7.00', 'Menus enfants', 'default.jpg'),
(114, 'Riz au lait', 'Riz au lait à la vanille', '5.50', 'Menus enfants', 'default.jpg'),
(115, 'Assiette de fruits', 'Fruits coupés', '5.00', 'Menus enfants', 'default.jpg'),
(116, 'Glace', 'Boule de glace au choix', '4.50', 'Menus enfants', 'default.jpg'),
(117, 'Crêpe nature', 'Crêpe avec sucre ou confiture', '5.00', 'Menus enfants', 'default.jpg'),
(118, 'Yaourt à boire', 'Yaourt à boire avec biscuit', '4.50', 'Menus enfants', 'default.jpg'),
(119, 'Compote', 'Compote de pomme ou autre fruit', '4.00', 'Menus enfants', 'default.jpg'),
(120, 'Bonbons', 'Petit sachet de bonbons', '3.50', 'Menus enfants', 'default.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `paiements`
--

CREATE TABLE `paiements` (
  `commande_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `payment_method` enum('mvola','airtel','orange') DEFAULT 'mvola',
  `payment_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `statut` enum('en_attente','en_preparation','pret','livre','annule') DEFAULT 'en_preparation'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `panier`
--

CREATE TABLE `panier` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `menu_item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `panier`
--

INSERT INTO `panier` (`id`, `user_id`, `menu_item_id`, `quantity`, `created_at`, `updated_at`) VALUES
(60, 6, 2, 1, '2025-08-01 09:05:49', '2025-08-01 09:05:49'),
(61, 2, 1, 1, '2025-08-01 20:42:21', '2025-08-01 20:42:21');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('client','serveur','cuisinier','admin') DEFAULT 'client',
  `adresse` text,
  `telephone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nom`, `prenom`, `email`, `password`, `role`, `adresse`, `telephone`) VALUES
(2, 'teste', 'teste', 'tiana@gmail.com', '$2y$10$cDSN2fNoBDkk6Hzno/pV/OObKsXVcPlID3x5EKoCjoJR1pJmKPJdq', 'client', '480', NULL),
(5, 'travis', 'kely', 'lovambolatia@gmail.com', '$2y$10$ft9YtXIWdS7.mBIqM1XlauN8PG3uud95K2CVO2IvbGl8.tLEil4Ju', 'admin', NULL, NULL),
(6, 'travis', 'noù', 'scotty@gmail.com', '$2y$10$KTiKDe7/IfrmFeM4915DhOOg7XmdzRz7cLQJKSMqnl7YC7Kjer3S6', 'client', '480', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `commandes`
--
ALTER TABLE `commandes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `commandes_items`
--
ALTER TABLE `commandes_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `commande_id` (`commande_id`),
  ADD KEY `menu_item_id` (`menu_item_id`);

--
-- Indexes for table `commande_details`
--
ALTER TABLE `commande_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `commande_id` (`commande_id`),
  ADD KEY `menu_item_id` (`menu_item_id`);

--
-- Indexes for table `livraisons`
--
ALTER TABLE `livraisons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `commande_id` (`commande_id`),
  ADD KEY `livreur_id` (`livreur_id`);

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `paiements`
--
ALTER TABLE `paiements`
  ADD PRIMARY KEY (`commande_id`);

--
-- Indexes for table `panier`
--
ALTER TABLE `panier`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_panier_item` (`user_id`,`menu_item_id`),
  ADD KEY `menu_item_id` (`menu_item_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `commandes`
--
ALTER TABLE `commandes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `commandes_items`
--
ALTER TABLE `commandes_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `commande_details`
--
ALTER TABLE `commande_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `livraisons`
--
ALTER TABLE `livraisons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `paiements`
--
ALTER TABLE `paiements`
  MODIFY `commande_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `panier`
--
ALTER TABLE `panier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `commandes`
--
ALTER TABLE `commandes`
  ADD CONSTRAINT `commandes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `commandes_items`
--
ALTER TABLE `commandes_items`
  ADD CONSTRAINT `commandes_items_ibfk_1` FOREIGN KEY (`commande_id`) REFERENCES `commandes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `commandes_items_ibfk_2` FOREIGN KEY (`menu_item_id`) REFERENCES `menu_items` (`id`);

--
-- Constraints for table `commande_details`
--
ALTER TABLE `commande_details`
  ADD CONSTRAINT `commande_details_ibfk_1` FOREIGN KEY (`commande_id`) REFERENCES `commandes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `commande_details_ibfk_2` FOREIGN KEY (`menu_item_id`) REFERENCES `menu_items` (`id`);

--
-- Constraints for table `livraisons`
--
ALTER TABLE `livraisons`
  ADD CONSTRAINT `livraisons_ibfk_1` FOREIGN KEY (`commande_id`) REFERENCES `commandes` (`id`),
  ADD CONSTRAINT `livraisons_ibfk_2` FOREIGN KEY (`livreur_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `panier`
--
ALTER TABLE `panier`
  ADD CONSTRAINT `panier_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `panier_ibfk_2` FOREIGN KEY (`menu_item_id`) REFERENCES `menu_items` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
