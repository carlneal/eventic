
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eventic`
--

-- --------------------------------------------------------

--
-- Table structure for table `eventic_amenity`
--

DROP TABLE IF EXISTS `eventic_amenity`;
CREATE TABLE IF NOT EXISTS `eventic_amenity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `icon` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `hidden` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `eventic_amenity`
--

INSERT INTO `eventic_amenity` (`id`, `icon`, `hidden`, `created_at`, `updated_at`, `deleted_at`) VALUES
(5, 'fas fa-spa', 0, '2019-07-17 17:48:39', '2019-07-17 17:48:39', NULL),
(6, 'fas fa-umbrella-beach', 0, '2019-07-17 17:49:23', '2020-04-21 13:17:32', NULL),
(7, 'fas fa-briefcase', 0, '2019-07-17 17:50:16', '2020-04-22 12:51:01', NULL),
(8, 'fas fa-wheelchair', 0, '2019-07-17 17:51:20', '2019-07-17 17:51:20', NULL),
(9, 'fas fa-cloud-sun', 0, '2019-07-17 17:52:12', '2019-07-17 17:52:12', NULL),
(10, 'fas fa-dog', 0, '2019-07-17 17:53:08', '2020-04-22 12:50:46', NULL),
(11, 'fas fa-wifi', 0, '2019-07-17 17:54:51', '2020-04-22 12:51:26', NULL),
(12, 'fas fa-volume-up', 0, '2019-08-10 11:15:43', '2020-04-22 12:51:14', NULL),
(13, 'fas fa-chair', 0, '2019-08-10 11:16:47', '2020-04-22 12:50:54', NULL),
(14, 'fas fa-parking', 0, '2019-08-10 11:17:27', '2019-08-10 11:17:27', NULL),
(15, 'fas fa-desktop', 0, '2019-08-10 11:18:55', '2019-08-10 11:18:55', NULL),
(16, 'fas fa-city', 0, '2019-08-10 11:20:20', '2019-08-10 11:20:20', NULL),
(17, 'fas fa-theater-masks', 0, '2019-08-10 11:21:03', '2020-04-22 12:51:08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `eventic_amenity_translation`
--

DROP TABLE IF EXISTS `eventic_amenity_translation`;
CREATE TABLE IF NOT EXISTS `eventic_amenity_translation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `translatable_id` int(11) DEFAULT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_3C354FF8989D9B62` (`slug`),
  UNIQUE KEY `eventic_amenity_translation_unique_translation` (`translatable_id`,`locale`),
  KEY `IDX_3C354FF82C2AC5D3` (`translatable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `eventic_amenity_translation`
--

INSERT INTO `eventic_amenity_translation` (`id`, `translatable_id`, `name`, `slug`, `locale`) VALUES
(21, 5, 'Spa', 'spa', 'en'),
(22, 5, '温泉', '温泉', 'zh'),
(23, 5, 'Spa', 'spa-1', 'es'),
(24, 5, 'Spa', 'spa-2', 'fr'),
(25, 5, 'منتجع صحي', 'منتجع-صحي', 'ar'),
(26, 6, 'Beachfront', 'beachfront', 'en'),
(27, 6, '海滨', '海滨', 'zh'),
(28, 6, 'Frente a la playa', 'frente-a-la-playa', 'es'),
(29, 6, 'Front de mer', 'front-de-mer', 'fr'),
(30, 6, 'على شاطئ البحر', 'على-شاطئ-البحر', 'ar'),
(31, 7, 'Business Center', 'business-center', 'en'),
(32, 7, '商业中心', '商业中心', 'zh'),
(33, 7, 'Centro de negocios', 'centro-de-negocios', 'es'),
(34, 7, 'Centre d\'affaires', 'centre-daffaires', 'fr'),
(35, 7, 'مركز أعمال', 'مركز-أعمال', 'ar'),
(36, 8, 'Handicap Accessible', 'handicap-accessible', 'en'),
(37, 8, '障碍无障碍', '障碍无障碍', 'zh'),
(38, 8, 'Accesible para discapacitados', 'accesible-para-discapacitados', 'es'),
(39, 8, 'Accessible aux personnes handicapées', 'accessible-aux-personnes-handicapees', 'fr'),
(40, 8, 'في متناول الأشخاص ذوي الإعاقة', 'في-متناول-الأشخاص-ذوي-الإعاقة', 'ar'),
(41, 9, 'Outdoor Space', 'outdoor-space', 'en'),
(42, 9, '户外空间', '户外空间', 'zh'),
(43, 9, 'Espacio al aire libre', 'espacio-al-aire-libre', 'es'),
(44, 9, 'Espace extérieur', 'espace-exterieur', 'fr'),
(45, 9, 'فضاء خارجي', 'فضاء-خارجي', 'ar'),
(46, 10, 'Pet Friendly', 'pet-friendly', 'en'),
(47, 10, '宠物友好', '宠物友好', 'zh'),
(48, 10, 'Mascota amigable', 'mascota-amigable', 'es'),
(49, 10, 'Animaux acceptés', 'animaux-acceptes', 'fr'),
(50, 10, 'حيوانات اليفة', 'حيوانات-اليفة', 'ar'),
(51, 11, 'WiFi', 'wifi', 'en'),
(52, 11, '无线上网', '无线上网', 'zh'),
(53, 11, 'WiFi', 'wifi-1', 'es'),
(54, 11, 'WiFi', 'wifi-2', 'fr'),
(55, 11, 'واي فاي', 'واي-فاي', 'ar'),
(56, 12, 'A/V Equipement', 'av-equipement', 'en'),
(57, 12, '设备', '设备', 'zh'),
(58, 12, 'Equipo de A / V', 'equipo-de-a-v', 'es'),
(59, 12, 'Equipements audiovisuels', 'equipements-audiovisuels', 'fr'),
(60, 12, 'معدات الصوت و الفيديو', 'معدات-الصوت-و-الفيديو', 'ar'),
(61, 13, 'Breakout rooms', 'breakout-rooms', 'en'),
(62, 13, '分组讨论室', '分组讨论室', 'zh'),
(63, 13, 'Salas de descanso', 'salas-de-descanso', 'es'),
(64, 13, 'Salles de repos', 'salles-de-repos', 'fr'),
(65, 13, 'غرف جانبية', 'غرف-جانبية', 'ar'),
(66, 14, 'Parking', 'parking', 'en'),
(67, 14, '停车处', '停车处', 'zh'),
(68, 14, 'Estacionamiento', 'estacionamiento', 'es'),
(69, 14, 'Parking', 'parking-1', 'fr'),
(70, 14, 'موقف سيارات', 'موقف-سيارات', 'ar'),
(71, 15, 'Media room', 'media-room', 'en'),
(72, 15, '多媒体室', '多媒体室', 'zh'),
(73, 15, 'Sala de prensa', 'sala-de-prensa', 'es'),
(74, 15, 'Salle de presse', 'salle-de-presse', 'fr'),
(75, 15, 'غرفة وسائل الاعلام', 'غرفة-وسائل-الاعلام', 'ar'),
(76, 16, 'Rooftop', 'rooftop', 'en'),
(77, 16, '屋顶', '屋顶', 'zh'),
(78, 16, 'En la azotea', 'en-la-azotea', 'es'),
(79, 16, 'Toit', 'toit', 'fr'),
(80, 16, 'سطح', 'سطح', 'ar'),
(81, 17, 'Theater space', 'theater-space', 'en'),
(82, 17, '剧院空间', '剧院空间', 'zh'),
(83, 17, 'Espacio de teatro', 'espacio-de-teatro', 'es'),
(84, 17, 'Espace théâtre', 'espace-theatre', 'fr'),
(85, 17, 'مساحة المسرح', 'مساحة-المسرح', 'ar');

-- --------------------------------------------------------

--
-- Table structure for table `eventic_app_layout_setting`
--

DROP TABLE IF EXISTS `eventic_app_layout_setting`;
CREATE TABLE IF NOT EXISTS `eventic_app_layout_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `logo_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `logo_size` int(11) DEFAULT NULL,
  `logo_mime_type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `logo_original_name` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `logo_dimensions` longtext COLLATE utf8_unicode_ci COMMENT '(DC2Type:simple_array)',
  `favicon_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `favicon_size` int(11) DEFAULT NULL,
  `favicon_mime_type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `favicon_original_name` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `favicon_dimensions` longtext COLLATE utf8_unicode_ci COMMENT '(DC2Type:simple_array)',
  `updated_at` datetime DEFAULT NULL,
  `og_image_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `og_image_size` int(11) DEFAULT NULL,
  `og_image_mime_type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `og_image_original_name` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `og_image_dimensions` longtext COLLATE utf8_unicode_ci COMMENT '(DC2Type:simple_array)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `eventic_app_layout_setting`
--

INSERT INTO `eventic_app_layout_setting` (`id`, `logo_name`, `logo_size`, `logo_mime_type`, `logo_original_name`, `logo_dimensions`, `favicon_name`, `favicon_size`, `favicon_mime_type`, `favicon_original_name`, `favicon_dimensions`, `updated_at`, `og_image_name`, `og_image_size`, `og_image_mime_type`, `og_image_original_name`, `og_image_dimensions`) VALUES
(1, '5f626cc22a186068458664.png', 3964, 'image/png', 'logo.png', '200,50', '5ecac8821172a412596921.png', 2200, 'image/png', '32x32.png', '32,32', '2020-11-10 13:30:44', '5faadc546e235285098877.jpg', 57754, 'image/jpeg', 'ogImage.jpg', '1200,630');

-- --------------------------------------------------------

--
-- Table structure for table `eventic_audience`
--

DROP TABLE IF EXISTS `eventic_audience`;
CREATE TABLE IF NOT EXISTS `eventic_audience` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_size` int(11) DEFAULT NULL,
  `image_mime_type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_original_name` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_dimensions` longtext COLLATE utf8_unicode_ci COMMENT '(DC2Type:simple_array)',
  `hidden` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `eventic_audience`
--

INSERT INTO `eventic_audience` (`id`, `image_name`, `image_size`, `image_mime_type`, `image_original_name`, `image_dimensions`, `hidden`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '5d641402c4cf9162849552.png', 15678, 'image/png', 'adults.png', '512,512', 0, '2019-08-26 17:16:50', '2019-08-26 17:16:50', NULL),
(2, '5d641451ca81e833369961.png', 15496, 'image/png', 'children.png', '512,512', 0, '2019-08-26 17:18:09', '2020-04-21 13:23:14', NULL),
(3, '5d2e2503df8b7852878320.png', 21688, 'image/png', 'family.png', '512,512', 0, '2019-07-16 19:26:59', '2019-07-16 19:26:59', NULL),
(4, '5d2e2527b07e2010325395.png', 15442, 'image/png', 'group.png', '512,512', 0, '2019-07-16 19:27:35', '2019-07-16 19:27:35', NULL),
(5, '5d2e254d3af82934317748.png', 17113, 'image/png', 'youth.png', '512,512', 0, '2019-07-16 19:28:13', '2019-07-16 19:28:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `eventic_audience_translation`
--

DROP TABLE IF EXISTS `eventic_audience_translation`;
CREATE TABLE IF NOT EXISTS `eventic_audience_translation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `translatable_id` int(11) DEFAULT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_5CF81D36989D9B62` (`slug`),
  UNIQUE KEY `eventic_audience_translation_unique_translation` (`translatable_id`,`locale`),
  KEY `IDX_5CF81D362C2AC5D3` (`translatable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `eventic_audience_translation`
--

INSERT INTO `eventic_audience_translation` (`id`, `translatable_id`, `name`, `slug`, `locale`) VALUES
(11, 3, 'Family', 'family', 'en'),
(12, 3, '家庭', '家庭', 'zh'),
(13, 3, 'Familia', 'familia', 'es'),
(14, 3, 'Famille', 'famille', 'fr'),
(15, 3, 'عائلة', 'عائلة', 'ar'),
(16, 4, 'Group', 'group', 'en'),
(17, 4, '组', '组', 'zh'),
(18, 4, 'Grupo', 'grupo', 'es'),
(19, 4, 'Groupe', 'groupe', 'fr'),
(20, 4, 'مجموعة', 'مجموعة', 'ar'),
(21, 5, 'Youth', 'youth', 'en'),
(22, 5, '青年', '青年', 'zh'),
(23, 5, 'Juventud', 'juventud', 'es'),
(24, 5, 'Jeunes', 'jeunes', 'fr'),
(25, 5, 'شباب', 'شباب', 'ar'),
(26, 1, 'Adults', 'adults', 'en'),
(27, 1, '成人', '成人', 'zh'),
(28, 1, 'Adultos', 'adultos', 'es'),
(29, 1, 'Adultes', 'adultes', 'fr'),
(30, 1, 'كبار', 'كبار', 'ar'),
(31, 2, 'Children', 'children', 'en'),
(32, 2, '孩子', '孩子', 'zh'),
(33, 2, 'Niños', 'ninos', 'es'),
(34, 2, 'Enfants', 'enfants', 'fr'),
(35, 2, 'أطفال', 'أطفال', 'ar');

-- --------------------------------------------------------

--
-- Table structure for table `eventic_blog_post`
--

DROP TABLE IF EXISTS `eventic_blog_post`;
CREATE TABLE IF NOT EXISTS `eventic_blog_post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `readtime` int(11) DEFAULT NULL,
  `image_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_size` int(11) DEFAULT NULL,
  `image_mime_type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_original_name` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_dimensions` longtext COLLATE utf8_unicode_ci COMMENT '(DC2Type:simple_array)',
  `views` int(11) DEFAULT NULL,
  `hidden` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E66028C712469DE2` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `eventic_blog_post_category`
--

DROP TABLE IF EXISTS `eventic_blog_post_category`;
CREATE TABLE IF NOT EXISTS `eventic_blog_post_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hidden` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `eventic_blog_post_category`
--

INSERT INTO `eventic_blog_post_category` (`id`, `hidden`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 0, '2019-09-28 06:26:16', '2019-09-28 06:26:16', NULL),
(3, 0, '2019-09-28 06:27:36', '2019-09-28 06:27:36', NULL),
(4, 0, '2019-09-28 06:28:34', '2019-09-28 06:28:34', NULL),
(5, 0, '2019-09-28 06:29:33', '2019-09-28 06:29:33', NULL),
(6, 0, '2019-09-28 06:30:20', '2019-09-28 06:30:20', NULL),
(7, 0, '2019-09-28 06:31:06', '2019-09-28 06:31:06', NULL),
(8, 0, '2019-09-28 06:32:13', '2019-09-28 06:32:13', NULL),
(9, 0, '2019-09-28 06:32:58', '2019-09-28 06:32:58', NULL),
(10, 0, '2019-09-28 06:33:37', '2019-09-28 06:33:37', NULL),
(11, 0, '2019-09-28 06:34:16', '2019-09-28 06:34:16', NULL),
(12, 0, '2019-09-28 06:35:05', '2019-09-28 06:35:05', NULL),
(13, 0, '2019-09-28 06:35:45', '2019-09-28 06:35:45', NULL),
(14, 0, '2019-09-28 06:36:40', '2019-09-28 06:36:40', NULL),
(15, 0, '2019-09-28 07:05:09', '2020-04-21 13:29:27', NULL),
(16, 0, '2019-09-28 07:53:11', '2019-09-28 07:53:11', NULL),
(17, 0, '2019-09-28 07:54:23', '2019-09-28 07:54:23', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `eventic_blog_post_category_translation`
--

DROP TABLE IF EXISTS `eventic_blog_post_category_translation`;
CREATE TABLE IF NOT EXISTS `eventic_blog_post_category_translation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `translatable_id` int(11) DEFAULT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_BAF151EA989D9B62` (`slug`),
  UNIQUE KEY `eventic_blog_post_category_translation_unique_translation` (`translatable_id`,`locale`),
  KEY `IDX_BAF151EA2C2AC5D3` (`translatable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `eventic_blog_post_category_translation`
--

INSERT INTO `eventic_blog_post_category_translation` (`id`, `translatable_id`, `name`, `slug`, `locale`) VALUES
(6, 2, 'Attendees', 'attendees', 'en'),
(7, 2, '与会者', '与会者', 'zh'),
(8, 2, 'Asistentes', 'asistentes', 'es'),
(9, 2, 'Participants', 'participants', 'fr'),
(10, 2, 'الحاضرين', 'الحاضرين', 'ar'),
(11, 3, 'Branding', 'branding', 'en'),
(12, 3, '品牌', '品牌', 'zh'),
(13, 3, 'Marca', 'marca', 'es'),
(14, 3, 'Image de marque', 'image-de-marque', 'fr'),
(15, 3, 'العلامات التجارية', 'العلامات-التجارية', 'ar'),
(16, 4, 'Budgeting', 'budgeting', 'en'),
(17, 4, '预算', '预算', 'zh'),
(18, 4, 'Presupuesto', 'presupuesto', 'es'),
(19, 4, 'Budget & Finance', 'budget-finance', 'fr'),
(20, 4, 'وضع الميزانية', 'وضع-الميزانية', 'ar'),
(21, 5, 'Catering', 'catering', 'en'),
(22, 5, '餐饮', '餐饮', 'zh'),
(23, 5, 'Abastecimiento', 'abastecimiento', 'es'),
(24, 5, 'Restauration', 'restauration', 'fr'),
(25, 5, 'تقديم الطعام', 'تقديم-الطعام', 'ar'),
(26, 6, 'Collaboration', 'collaboration', 'en'),
(27, 6, '合作', '合作', 'zh'),
(28, 6, 'Colaboración', 'colaboracion', 'es'),
(29, 6, 'collaboration', 'collaboration-1', 'fr'),
(30, 6, 'تعاون', 'تعاون', 'ar'),
(31, 7, 'Community', 'community', 'en'),
(32, 7, '社区', '社区', 'zh'),
(33, 7, 'Comunidad', 'comunidad', 'es'),
(34, 7, 'Communauté', 'communaute', 'fr'),
(35, 7, 'تواصل اجتماعي', 'تواصل-اجتماعي', 'ar'),
(36, 8, 'Content', 'content', 'en'),
(37, 8, '内容', '内容', 'zh'),
(38, 8, 'Contenido', 'contenido', 'es'),
(39, 8, 'Contenu', 'contenu', 'fr'),
(40, 8, 'محتوى', 'محتوى', 'ar'),
(41, 9, 'Feature', 'feature', 'en'),
(42, 9, '特征', '特征', 'zh'),
(43, 9, 'Característica', 'caracteristica', 'es'),
(44, 9, 'Fonctionnalité', 'fonctionnalite', 'fr'),
(45, 9, 'خاصية', 'خاصية', 'ar'),
(46, 10, 'News', 'news', 'en'),
(47, 10, '新闻', '新闻', 'zh'),
(48, 10, 'Noticias', 'noticias', 'es'),
(49, 10, 'Actualité', 'actualite', 'fr'),
(50, 10, 'أخبار', 'أخبار', 'ar'),
(51, 11, 'Pricing', 'pricing', 'en'),
(52, 11, '价钱', '价钱', 'zh'),
(53, 11, 'Precios', 'precios', 'es'),
(54, 11, 'Prix', 'prix', 'fr'),
(55, 11, 'التسعير', 'التسعير', 'ar'),
(56, 12, 'Marketing', 'marketing', 'en'),
(57, 12, '营销', '营销', 'zh'),
(58, 12, 'Márketing', 'marketing-1', 'es'),
(59, 12, 'Commercialisation', 'commercialisation', 'fr'),
(60, 12, 'تسويق', 'تسويق', 'ar'),
(61, 13, 'Social Media', 'social-media', 'en'),
(62, 13, '社交媒体', '社交媒体', 'zh'),
(63, 13, 'Redes sociales', 'redes-sociales', 'es'),
(64, 13, 'Réseaux sociaux', 'reseaux-sociaux', 'fr'),
(65, 13, 'وسائل التواصل الاجتماعي', 'وسائل-التواصل-الاجتماعي', 'ar'),
(66, 14, 'Sponsoring', 'sponsoring', 'en'),
(67, 14, '赞助', '赞助', 'zh'),
(68, 14, 'Patrocinio', 'patrocinio', 'es'),
(69, 14, 'Parrainage', 'parrainage', 'fr'),
(70, 14, 'الراعية', 'الراعية', 'ar'),
(71, 15, 'Other', 'other', 'en'),
(72, 15, '其他', '其他', 'zh'),
(73, 15, 'Otro', 'otro', 'es'),
(74, 15, 'Autre', 'autre', 'fr'),
(75, 15, 'آخر', 'آخر', 'ar'),
(76, 16, 'Tips', 'tips', 'en'),
(77, 16, '提示', '提示', 'zh'),
(78, 16, 'Consejos', 'consejos', 'es'),
(79, 16, 'Astuces', 'astuces', 'fr'),
(80, 16, 'نصائح', 'نصائح', 'ar'),
(81, 17, 'Planning', 'planning', 'en'),
(82, 17, '规划', '规划', 'zh'),
(83, 17, 'Planificación', 'planificacion', 'es'),
(84, 17, 'Planification', 'planification', 'fr'),
(85, 17, 'تنظيم', 'تنظيم', 'ar');

-- --------------------------------------------------------

--
-- Table structure for table `eventic_blog_post_translation`
--

DROP TABLE IF EXISTS `eventic_blog_post_translation`;
CREATE TABLE IF NOT EXISTS `eventic_blog_post_translation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `translatable_id` int(11) DEFAULT NULL,
  `name` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `tags` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_6A7C548D989D9B62` (`slug`),
  UNIQUE KEY `eventic_blog_post_translation_unique_translation` (`translatable_id`,`locale`),
  KEY `IDX_6A7C548D2C2AC5D3` (`translatable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `eventic_cart_element`
--

DROP TABLE IF EXISTS `eventic_cart_element`;
CREATE TABLE IF NOT EXISTS `eventic_cart_element` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `eventticket_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `ticket_fee` decimal(10,2) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_FFABA270A76ED395` (`user_id`),
  KEY `IDX_FFABA270182CEB62` (`eventticket_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `eventic_category`
--

DROP TABLE IF EXISTS `eventic_category`;
CREATE TABLE IF NOT EXISTS `eventic_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `icon` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `image_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_size` int(11) DEFAULT NULL,
  `image_mime_type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_original_name` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_dimensions` longtext COLLATE utf8_unicode_ci COMMENT '(DC2Type:simple_array)',
  `hidden` tinyint(1) NOT NULL,
  `featured` tinyint(1) NOT NULL,
  `featuredorder` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `eventic_category`
--

INSERT INTO `eventic_category` (`id`, `icon`, `image_name`, `image_size`, `image_mime_type`, `image_original_name`, `image_dimensions`, `hidden`, `featured`, `featuredorder`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'fas fa-film', '5d25bbce39c23158021633.jpg', 92885, 'image/jpeg', 'cinema.jpg', '750,500', 0, 1, 1, '2019-07-10 10:19:58', '2019-07-10 13:33:20', NULL),
(2, 'fas fa-theater-masks', '5d25c74653488828593881.jpg', 85274, 'image/jpeg', 'theater.jpg', '750,500', 0, 1, 9, '2019-07-10 11:08:54', '2019-07-10 13:35:59', NULL),
(3, 'fas fa-music', '5d25c8ac2dc08429295620.jpg', 59988, 'image/jpeg', 'concert.jpg', '750,500', 0, 1, 2, '2019-07-10 11:14:52', '2019-07-10 13:33:43', NULL),
(4, 'fas fa-campground', '5d25c9b886052025417773.jpg', 85024, 'image/jpeg', 'trip.jpg', '750,499', 0, 1, 7, '2019-07-10 11:19:20', '2019-07-10 13:35:49', NULL),
(5, 'fas fa-chalkboard-teacher', '5d25cb1f3a427433186059.jpg', 54280, 'image/jpeg', 'workshop.jpg', '750,500', 0, 1, 8, '2019-07-10 11:25:19', '2019-07-10 13:35:54', NULL),
(6, 'fas fa-user-tie', '5d25cc9cc231a164708177.jpg', 51918, 'image/jpeg', 'conference.jpg', '750,500', 0, 0, NULL, '2019-07-10 11:31:40', '2019-07-10 11:31:40', NULL),
(7, 'fab fa-napster', '5d25cfdc11d70946653978.jpg', 68172, 'image/jpeg', 'festival.jpg', '750,370', 0, 0, NULL, '2019-07-10 11:45:32', '2019-07-10 11:45:32', NULL),
(8, 'fas fa-trophy', '5d25d516bcd55290062056.jpg', 66105, 'image/jpeg', 'game.jpg', '750,500', 0, 0, NULL, '2019-07-10 12:07:50', '2019-07-10 12:07:50', NULL),
(9, 'fas fa-paint-brush', '5d25d6243005b576277820.jpg', 112121, 'image/jpeg', 'exposition.jpg', '750,500', 0, 0, NULL, '2019-07-10 12:12:20', '2019-07-10 12:12:20', NULL),
(10, 'fas fa-futbol', '5d25d7010f95c921309680.jpg', 96009, 'image/jpeg', 'sport.jpg', '750,425', 0, 1, 3, '2019-07-10 12:16:01', '2019-07-10 13:34:00', NULL),
(11, 'fas fa-landmark', '5d25d7a6ef131527844501.jpg', 93875, 'image/jpeg', 'museum.jpg', '750,500', 0, 1, 6, '2019-07-10 12:18:46', '2019-07-10 13:35:20', NULL),
(12, 'fas fa-utensils', '5d25d857e88a1398473545.jpg', 63488, 'image/jpeg', 'restaurant.jpg', '750,500', 0, 1, 4, '2019-07-10 12:21:43', '2019-07-10 13:34:35', NULL),
(13, 'fas fa-rocket', '5d25d9a094f16789345310.jpg', 80876, 'image/jpeg', 'park.jpg', '750,563', 0, 1, 5, '2019-07-10 12:27:12', '2019-07-10 13:35:15', NULL),
(14, 'fas fa-parking', '5d25dab442a6a081728408.jpg', 137639, 'image/jpeg', 'parking.jpg', '750,1002', 0, 0, NULL, '2019-07-10 12:31:48', '2019-07-10 12:31:48', NULL),
(15, 'fas fa-folder-open', NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, '2019-07-10 12:32:56', '2020-04-21 13:32:06', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `eventic_category_translation`
--

DROP TABLE IF EXISTS `eventic_category_translation`;
CREATE TABLE IF NOT EXISTS `eventic_category_translation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `translatable_id` int(11) DEFAULT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_3CFC55AB989D9B62` (`slug`),
  UNIQUE KEY `eventic_category_translation_unique_translation` (`translatable_id`,`locale`),
  KEY `IDX_3CFC55AB2C2AC5D3` (`translatable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `eventic_category_translation`
--

INSERT INTO `eventic_category_translation` (`id`, `translatable_id`, `name`, `slug`, `locale`) VALUES
(1, 1, 'Cinema', 'cinema', 'en'),
(2, 1, '电影', '电影', 'zh'),
(3, 1, 'Cine', 'cine', 'es'),
(4, 1, 'Cinéma', 'cinema-1', 'fr'),
(5, 1, 'سينما', 'سينما', 'ar'),
(6, 2, 'Theater', 'theater', 'en'),
(7, 2, '剧院', '剧院', 'zh'),
(8, 2, 'Teatro', 'teatro', 'es'),
(9, 2, 'Théâtre', 'theatre', 'fr'),
(10, 2, 'مسرح', 'مسرح', 'ar'),
(11, 3, 'Concert / Music', 'concert-music', 'en'),
(12, 3, '音乐会/音乐', '音乐会音乐', 'zh'),
(13, 3, 'Concierto / Musica', 'concierto-musica', 'es'),
(14, 3, 'Concert / Musique', 'concert-musique', 'fr'),
(15, 3, 'حفلة / موسيقى', 'حفلة-موسيقى', 'ar'),
(16, 4, 'Trip / Camp', 'trip-camp', 'en'),
(17, 4, '旅行/营地', '旅行营地', 'zh'),
(18, 4, 'Viaje / Campamento', 'viaje-campamento', 'es'),
(19, 4, 'Randonnée / Camping', 'randonnee-camping', 'fr'),
(20, 4, 'رحلة / معسكر', 'رحلة-معسكر', 'ar'),
(21, 5, 'Workshop / Training', 'workshop-training', 'en'),
(22, 5, '研讨会/培训', '研讨会培训', 'zh'),
(23, 5, 'Taller / Entrenamiento', 'taller-entrenamiento', 'es'),
(24, 5, 'Atelier / formation', 'atelier-formation', 'fr'),
(25, 5, 'ورشة / تدريب', 'ورشة-تدريب', 'ar'),
(26, 6, 'Conference', 'conference', 'en'),
(27, 6, '会议', '会议', 'zh'),
(28, 6, 'Conferencia', 'conferencia', 'es'),
(29, 6, 'Conférence', 'conference-1', 'fr'),
(30, 6, 'مؤتمر', 'مؤتمر', 'ar'),
(31, 7, 'Festival / Spectacle', 'festival-spectacle', 'en'),
(32, 7, '节/景观', '节景观', 'zh'),
(33, 7, 'Festival / Espectáculo', 'festival-espectaculo', 'es'),
(34, 7, 'Festival / Spectacle', 'festival-spectacle-1', 'fr'),
(35, 7, 'مهرجان', 'مهرجان', 'ar'),
(36, 8, 'Game / Competition', 'game-competition', 'en'),
(37, 8, '游戏/比赛', '游戏比赛', 'zh'),
(38, 8, 'Juego / Competición', 'juego-competicion', 'es'),
(39, 8, 'Jeu / Compétition', 'jeu-competition', 'fr'),
(40, 8, 'لعبة / منافسة', 'لعبة-منافسة', 'ar'),
(41, 9, 'Exposition', 'exposition', 'en'),
(42, 9, '解释', '解释', 'zh'),
(43, 9, 'Exposición', 'exposicion', 'es'),
(44, 9, 'Exposition', 'exposition-1', 'fr'),
(45, 9, 'معرض', 'معرض', 'ar'),
(46, 10, 'Sport / Fitness', 'sport-fitness-1', 'en'),
(47, 10, '运动/健身', '运动健身', 'zh'),
(48, 10, 'Deporte / Fitness', 'deporte-fitness', 'es'),
(49, 10, 'Sport / Fitness', 'sport-fitness', 'fr'),
(50, 10, 'رياضة / لياقة بدنية', 'رياضة-لياقة-بدنية', 'ar'),
(51, 11, 'Museum / Monument', 'museum-monument', 'en'),
(52, 11, '博物馆/纪念碑', '博物馆纪念碑', 'zh'),
(53, 11, 'Museo / Monumento', 'museo-monumento', 'es'),
(54, 11, 'Musée / Monument', 'musee-monument', 'fr'),
(55, 11, 'متحف / نصب تذكاري', 'متحف-نصب-تذكاري', 'ar'),
(56, 12, 'Restaurant / Gastronomy', 'restaurant-gastronomy', 'en'),
(57, 12, '餐厅/美食', '餐厅美食', 'zh'),
(58, 12, 'Restaurante / Gastronomía', 'restaurante-gastronomia', 'es'),
(59, 12, 'Restaurant / Gastronomie', 'restaurant-gastronomie', 'fr'),
(60, 12, 'مطعم / فن الطهو', 'مطعم-فن-الطهو', 'ar'),
(61, 13, 'Recreation park / Attraction', 'recreation-park-attraction', 'en'),
(62, 13, '休闲公园/景点', '休闲公园景点', 'zh'),
(63, 13, 'Parque recreativo / atracción', 'parque-recreativo-atraccion', 'es'),
(64, 13, 'Parc de loisir / Attraction', 'parc-de-loisir-attraction', 'fr'),
(65, 13, 'متنزه', 'متنزه', 'ar'),
(66, 14, 'Parking / Services', 'parking-services', 'en'),
(67, 14, '停车/服务', '停车服务', 'zh'),
(68, 14, 'Parking / Servicios', 'parking-servicios', 'es'),
(69, 14, 'Parking / Services', 'parking-services-1', 'fr'),
(70, 14, 'وقوف السيارات / خدمات', 'وقوف-السيارات-خدمات', 'ar'),
(71, 15, 'Other', 'other', 'en'),
(72, 15, '其他', '其他', 'zh'),
(73, 15, 'Otra', 'otra', 'es'),
(74, 15, 'Autre', 'autre', 'fr'),
(75, 15, 'آخر', 'آخر', 'ar');

-- --------------------------------------------------------

--
-- Table structure for table `eventic_comment`
--

DROP TABLE IF EXISTS `eventic_comment`;
CREATE TABLE IF NOT EXISTS `eventic_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `thread_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `author_id` int(11) DEFAULT NULL,
  `body` longtext COLLATE utf8_unicode_ci NOT NULL,
  `ancestors` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `depth` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `state` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E58109F5E2904019` (`thread_id`),
  KEY `IDX_E58109F5F675F31B` (`author_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `eventic_country`
--

DROP TABLE IF EXISTS `eventic_country`;
CREATE TABLE IF NOT EXISTS `eventic_country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `hidden` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=250 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `eventic_country`
--

INSERT INTO `eventic_country` (`id`, `code`, `hidden`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'BD', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(2, 'BE', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(3, 'BF', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(4, 'BG', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(5, 'BA', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(6, 'BB', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(7, 'WF', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(8, 'BL', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(9, 'BM', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(10, 'BN', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(11, 'BO', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(12, 'BH', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(13, 'BI', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(14, 'BJ', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(15, 'BT', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(16, 'JM', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(17, 'BV', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(18, 'BW', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(19, 'WS', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(20, 'BQ', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(21, 'BR', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(22, 'BS', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(23, 'JE', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(24, 'BY', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(25, 'BZ', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(26, 'RU', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(27, 'RW', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(28, 'RS', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(29, 'TL', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(30, 'RE', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(31, 'TM', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(32, 'TJ', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(33, 'RO', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(34, 'TK', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(35, 'GW', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(36, 'GU', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(37, 'GT', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(38, 'GS', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(39, 'GR', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(40, 'GQ', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(41, 'GP', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(42, 'JP', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(43, 'GY', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(44, 'GG', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(45, 'GF', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(46, 'GE', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(47, 'GD', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(48, 'GB', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(49, 'GA', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(50, 'SV', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(51, 'GN', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(52, 'GM', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(53, 'GL', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(54, 'GI', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(55, 'GH', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(56, 'OM', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(57, 'TN', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(58, 'JO', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(59, 'HR', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(60, 'HT', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(61, 'HU', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(62, 'HK', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(63, 'HN', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(64, 'HM', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(65, 'VE', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(66, 'PR', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(67, 'PS', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(68, 'PW', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(69, 'PT', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(70, 'SJ', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(71, 'PY', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(72, 'IQ', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(73, 'PA', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(74, 'PF', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(75, 'PG', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(76, 'PE', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(77, 'PK', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(78, 'PH', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(79, 'PN', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(80, 'PL', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(81, 'PM', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(82, 'ZM', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(83, 'EH', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(84, 'EE', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(85, 'EG', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(86, 'ZA', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(87, 'EC', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(88, 'IT', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(89, 'VN', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(90, 'SB', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(91, 'ET', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(92, 'SO', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(93, 'ZW', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(94, 'SA', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(95, 'ES', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(96, 'ER', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(97, 'ME', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(98, 'MD', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(99, 'MG', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(100, 'MF', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(101, 'MA', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(102, 'MC', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(103, 'UZ', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(104, 'MM', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(105, 'ML', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(106, 'MO', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(107, 'MN', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(108, 'MH', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(109, 'MK', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(110, 'MU', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(111, 'MT', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(112, 'MW', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(113, 'MV', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(114, 'MQ', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(115, 'MP', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(116, 'MS', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(117, 'MR', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(118, 'IM', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(119, 'UG', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(120, 'TZ', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(121, 'MY', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(122, 'MX', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(123, 'FR', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(124, 'IO', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(125, 'SH', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(126, 'FI', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(127, 'FJ', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(128, 'FK', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(129, 'FM', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(130, 'FO', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(131, 'NI', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(132, 'NL', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(133, 'NO', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(134, 'NA', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(135, 'VU', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(136, 'NC', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(137, 'NE', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(138, 'NF', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(139, 'NG', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(140, 'NZ', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(141, 'NP', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(142, 'NR', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(143, 'NU', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(144, 'CK', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(145, 'XK', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(146, 'CI', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(147, 'CH', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(148, 'CO', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(149, 'CN', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(150, 'CM', 0, '2019-07-15 16:29:15', '2019-07-15 16:29:15', NULL),
(151, 'CL', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(152, 'CC', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(153, 'CA', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(154, 'CG', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(155, 'CF', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(156, 'CD', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(157, 'CZ', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(158, 'CY', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(159, 'CX', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(160, 'CR', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(161, 'CW', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(162, 'CV', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(163, 'CU', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(164, 'SZ', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(165, 'SY', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(166, 'SX', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(167, 'KG', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(168, 'KE', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(169, 'SS', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(170, 'SR', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(171, 'KI', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(172, 'KH', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(173, 'KN', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(174, 'KM', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(175, 'ST', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(176, 'SK', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(177, 'KR', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(178, 'SI', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(179, 'KP', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(180, 'KW', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(181, 'SN', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(182, 'SM', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(183, 'SL', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(184, 'SC', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(185, 'KZ', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(186, 'KY', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(187, 'SG', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(188, 'SE', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(189, 'SD', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(190, 'DO', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(191, 'DM', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(192, 'DJ', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(193, 'DK', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(194, 'VG', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(195, 'DE', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(196, 'YE', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(197, 'DZ', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(198, 'US', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(199, 'UY', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(200, 'YT', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(201, 'UM', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(202, 'LB', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(203, 'LC', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(204, 'LA', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(205, 'TV', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(206, 'TW', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(207, 'TT', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(208, 'TR', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(209, 'LK', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(210, 'LI', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(211, 'LV', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(212, 'TO', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(213, 'LT', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(214, 'LU', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(215, 'LR', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(216, 'LS', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(217, 'TH', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(218, 'TF', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(219, 'TG', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(220, 'TD', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(221, 'TC', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(222, 'LY', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(223, 'VA', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(224, 'VC', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(225, 'AE', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(226, 'AD', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(227, 'AG', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(228, 'AF', 0, '2019-07-15 16:29:16', '2020-04-21 13:34:30', NULL),
(229, 'AI', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(230, 'VI', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(231, 'IS', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(232, 'IR', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(233, 'AM', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(234, 'AL', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(235, 'AO', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(236, 'AQ', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(237, 'AS', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(238, 'AR', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(239, 'AU', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(240, 'AT', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(241, 'AW', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(242, 'IN', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(243, 'AX', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(244, 'AZ', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(245, 'IE', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(246, 'ID', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(247, 'UA', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(248, 'QA', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL),
(249, 'MZ', 0, '2019-07-15 16:29:16', '2019-07-15 16:29:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `eventic_country_translation`
--

DROP TABLE IF EXISTS `eventic_country_translation`;
CREATE TABLE IF NOT EXISTS `eventic_country_translation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `translatable_id` int(11) DEFAULT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_1AAA1D02989D9B62` (`slug`),
  UNIQUE KEY `eventic_country_translation_unique_translation` (`translatable_id`,`locale`),
  KEY `IDX_1AAA1D022C2AC5D3` (`translatable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1246 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `eventic_country_translation`
--

INSERT INTO `eventic_country_translation` (`id`, `translatable_id`, `name`, `slug`, `locale`) VALUES
(1, 1, 'Bangladesh', 'bangladesh', 'en'),
(2, 1, '孟加拉国', '孟加拉国', 'zh'),
(3, 1, 'Bangladesh', 'bangladesh-1', 'es'),
(4, 1, 'Bangladesh', 'bangladesh-2', 'fr'),
(5, 1, 'بنغلاديش', 'بنغلاديش', 'ar'),
(6, 2, 'Belgium', 'belgium', 'en'),
(7, 2, '比利时', '比利时', 'zh'),
(8, 2, 'Bélgica', 'belgica', 'es'),
(9, 2, 'Belgique', 'belgique', 'fr'),
(10, 2, 'بلجيكا', 'بلجيكا', 'ar'),
(11, 3, 'Burkina Faso', 'burkina-faso', 'en'),
(12, 3, '布基纳法索', '布基纳法索', 'zh'),
(13, 3, 'Burkina Faso', 'burkina-faso-1', 'es'),
(14, 3, 'Burkina Faso', 'burkina-faso-2', 'fr'),
(15, 3, 'بوركينا فاسو', 'بوركينا-فاسو', 'ar'),
(16, 4, 'Bulgaria', 'bulgaria', 'en'),
(17, 4, '保加利亚', '保加利亚', 'zh'),
(18, 4, 'Bulgaria', 'bulgaria-1', 'es'),
(19, 4, 'Bulgarie', 'bulgarie', 'fr'),
(20, 4, 'بلغاريا', 'بلغاريا', 'ar'),
(21, 5, 'Bosnia and Herzegovina', 'bosnia-and-herzegovina', 'en'),
(22, 5, '波斯尼亚和黑塞哥维那', '波斯尼亚和黑塞哥维那', 'zh'),
(23, 5, 'Bosnia y Herzegovina', 'bosnia-y-herzegovina', 'es'),
(24, 5, 'Bosnie Herzégovine', 'bosnie-herzegovine', 'fr'),
(25, 5, 'البوسنة والهرسك', 'البوسنة-والهرسك', 'ar'),
(26, 6, 'Barbados', 'barbados', 'en'),
(27, 6, '巴巴多斯', '巴巴多斯', 'zh'),
(28, 6, 'Barbadas', 'barbadas', 'es'),
(29, 6, 'La Barbade', 'la-barbade', 'fr'),
(30, 6, 'بربادوس', 'بربادوس', 'ar'),
(31, 7, 'Wallis and Futuna', 'wallis-and-futuna', 'en'),
(32, 7, '瓦利斯和富图纳群岛', '瓦利斯和富图纳群岛', 'zh'),
(33, 7, 'Wallis y Futuna', 'wallis-y-futuna', 'es'),
(34, 7, 'Wallis et Futuna', 'wallis-et-futuna', 'fr'),
(35, 7, 'واليس وفوتونا', 'واليس-وفوتونا', 'ar'),
(36, 8, 'Saint Barthelemy', 'saint-barthelemy', 'en'),
(37, 8, '瓦利斯和富图纳群岛', '瓦利斯和富图纳群岛-1', 'zh'),
(38, 8, 'San Bartolomé', 'san-bartolome', 'es'),
(39, 8, 'Saint Barthélemy', 'saint-barthelemy-1', 'fr'),
(40, 8, 'سانت بارتيليمي', 'سانت-بارتيليمي', 'ar'),
(41, 9, 'Bermuda', 'bermuda', 'en'),
(42, 9, '百慕大', '百慕大', 'zh'),
(43, 9, 'islas Bermudas', 'islas-bermudas', 'es'),
(44, 9, 'Bermudes', 'bermudes', 'fr'),
(45, 9, 'برمودا', 'برمودا', 'ar'),
(46, 10, 'Brunei', 'brunei', 'en'),
(47, 10, '文莱', '文莱', 'zh'),
(48, 10, 'Brunei', 'brunei-1', 'es'),
(49, 10, 'Brunei', 'brunei-2', 'fr'),
(50, 10, 'بروناي', 'بروناي', 'ar'),
(51, 11, 'Bolivia', 'bolivia', 'en'),
(52, 11, '玻利维亚', '玻利维亚', 'zh'),
(53, 11, 'Bolivia', 'bolivia-1', 'es'),
(54, 11, 'Bolivie', 'bolivie', 'fr'),
(55, 11, 'بوليفيا', 'بوليفيا', 'ar'),
(56, 12, 'Bahrain', 'bahrain', 'en'),
(57, 12, '巴林', '巴林', 'zh'),
(58, 12, 'Bahrein', 'bahrein', 'es'),
(59, 12, 'Bahreïn', 'bahrein-1', 'fr'),
(60, 12, 'البحرين', 'البحرين', 'ar'),
(61, 13, 'Burundi', 'burundi', 'en'),
(62, 13, '布隆迪', '布隆迪', 'zh'),
(63, 13, 'Burundi', 'burundi-1', 'es'),
(64, 13, 'Burundi', 'burundi-2', 'fr'),
(65, 13, 'بوروندي', 'بوروندي', 'ar'),
(66, 14, 'Benin', 'benin', 'en'),
(67, 14, '贝宁', '贝宁', 'zh'),
(68, 14, 'Benin', 'benin-1', 'es'),
(69, 14, 'Bénin', 'benin-2', 'fr'),
(70, 14, 'بنين', 'بنين', 'ar'),
(71, 15, 'Bhutan', 'bhutan', 'en'),
(72, 15, '不丹', '不丹', 'zh'),
(73, 15, 'Bután', 'butan', 'es'),
(74, 15, 'Bhoutan', 'bhoutan', 'fr'),
(75, 15, 'بوتان', 'بوتان', 'ar'),
(76, 16, 'Jamaica', 'jamaica', 'en'),
(77, 16, '牙买加', '牙买加', 'zh'),
(78, 16, 'Jamaica', 'jamaica-1', 'es'),
(79, 16, 'Jamaïque', 'jamaique', 'fr'),
(80, 16, 'جامايكا', 'جامايكا', 'ar'),
(81, 17, 'Bouvet Island', 'bouvet-island', 'en'),
(82, 17, '布维岛', '布维岛', 'zh'),
(83, 17, 'Isla Bouvet', 'isla-bouvet', 'es'),
(84, 17, 'Île Bouvet', 'ile-bouvet', 'fr'),
(85, 17, 'جزيرة بوفيت', 'جزيرة-بوفيت', 'ar'),
(86, 18, 'Botswana', 'botswana', 'en'),
(87, 18, '博茨瓦纳', '博茨瓦纳', 'zh'),
(88, 18, 'Botsuana', 'botsuana', 'es'),
(89, 18, 'Botswana', 'botswana-1', 'fr'),
(90, 18, 'بوتسوانا', 'بوتسوانا', 'ar'),
(91, 19, 'Samoa', 'samoa', 'en'),
(92, 19, '萨摩亚', '萨摩亚', 'zh'),
(93, 19, 'Samoa', 'samoa-1', 'es'),
(94, 19, 'Samoa', 'samoa-2', 'fr'),
(95, 19, 'ساموا', 'ساموا', 'ar'),
(96, 20, 'Bonaire, Saint Eustatius and Saba', 'bonaire-saint-eustatius-and-saba', 'en'),
(97, 20, '博内尔岛，圣尤斯特歇斯岛和萨巴岛', '博内尔岛，圣尤斯特歇斯岛和萨巴岛', 'zh'),
(98, 20, 'Bonaire, San Eustaquio y Saba', 'bonaire-san-eustaquio-y-saba', 'es'),
(99, 20, 'Bonaire, Saint Eustache et Saba', 'bonaire-saint-eustache-et-saba', 'fr'),
(100, 20, 'ونير وسانت اوستاتيوس وسابا', 'ونير-وسانت-اوستاتيوس-وسابا', 'ar'),
(101, 21, 'Brazil', 'brazil', 'en'),
(102, 21, '巴西', '巴西', 'zh'),
(103, 21, 'Brasil', 'brasil', 'es'),
(104, 21, 'Brésil', 'bresil', 'fr'),
(105, 21, 'البرازيل', 'البرازيل', 'ar'),
(106, 22, 'Bahamas', 'bahamas', 'en'),
(107, 22, '巴哈马', '巴哈马', 'zh'),
(108, 22, 'Bahamas', 'bahamas-1', 'es'),
(109, 22, 'Bahamas', 'bahamas-2', 'fr'),
(110, 22, 'الباهاماس', 'الباهاماس', 'ar'),
(111, 23, 'Jersey', 'jersey', 'en'),
(112, 23, '新泽西', '新泽西', 'zh'),
(113, 23, 'Jersey', 'jersey-1', 'es'),
(114, 23, 'Jersey', 'jersey-2', 'fr'),
(115, 23, 'جيرسي', 'جيرسي', 'ar'),
(116, 24, 'Belarus', 'belarus', 'en'),
(117, 24, '白俄罗斯', '白俄罗斯', 'zh'),
(118, 24, 'Bielorrusia', 'bielorrusia', 'es'),
(119, 24, 'Biélorussie', 'bielorussie', 'fr'),
(120, 24, 'روسيا البيضاء', 'روسيا-البيضاء', 'ar'),
(121, 25, 'Belize', 'belize', 'en'),
(122, 25, '伯利兹', '伯利兹', 'zh'),
(123, 25, 'Belice', 'belice', 'es'),
(124, 25, 'Belize', 'belize-1', 'fr'),
(125, 25, 'بليز', 'بليز', 'ar'),
(126, 26, 'Russia', 'russia', 'en'),
(127, 26, '俄国', '俄国', 'zh'),
(128, 26, 'Rusia', 'rusia', 'es'),
(129, 26, 'Russie', 'russie', 'fr'),
(130, 26, 'روسيا', 'روسيا', 'ar'),
(131, 27, 'Rwanda', 'rwanda', 'en'),
(132, 27, '卢旺达', '卢旺达', 'zh'),
(133, 27, 'Ruanda', 'ruanda', 'es'),
(134, 27, 'Rwanda', 'rwanda-1', 'fr'),
(135, 27, 'رواندا', 'رواندا', 'ar'),
(136, 28, 'Serbia', 'serbia', 'en'),
(137, 28, '塞尔维亚', '塞尔维亚', 'zh'),
(138, 28, 'Serbia', 'serbia-1', 'es'),
(139, 28, 'Serbie', 'serbie', 'fr'),
(140, 28, 'صربيا', 'صربيا', 'ar'),
(141, 29, 'East Timor', 'east-timor', 'en'),
(142, 29, '东帝汶', '东帝汶', 'zh'),
(143, 29, 'Timor oriental', 'timor-oriental', 'es'),
(144, 29, 'Timor oriental', 'timor-oriental-1', 'fr'),
(145, 29, 'تيمور الشرقية', 'تيمور-الشرقية', 'ar'),
(146, 30, 'Reunion', 'reunion', 'en'),
(147, 30, '团圆', '团圆', 'zh'),
(148, 30, 'Reunión', 'reunion-1', 'es'),
(149, 30, 'Réunion', 'reunion-2', 'fr'),
(150, 30, 'ريونيون', 'ريونيون', 'ar'),
(151, 31, 'Turkmenistan', 'turkmenistan', 'en'),
(152, 31, '土库曼斯坦', '土库曼斯坦', 'zh'),
(153, 31, 'Turkmenistán', 'turkmenistan-1', 'es'),
(154, 31, 'Turkménistan', 'turkmenistan-2', 'fr'),
(155, 31, 'تركمانستان', 'تركمانستان', 'ar'),
(156, 32, 'Tajikistan', 'tajikistan', 'en'),
(157, 32, '塔吉克斯坦', '塔吉克斯坦', 'zh'),
(158, 32, 'Tayikistan', 'tayikistan', 'es'),
(159, 32, 'Tadjikistan', 'tadjikistan', 'fr'),
(160, 32, 'طاجيكستان', 'طاجيكستان', 'ar'),
(161, 33, 'Romania', 'romania', 'en'),
(162, 33, '罗马尼亚', '罗马尼亚', 'zh'),
(163, 33, 'Rumania', 'rumania', 'es'),
(164, 33, 'Roumanie', 'roumanie', 'fr'),
(165, 33, 'رومانيا', 'رومانيا', 'ar'),
(166, 34, 'Tokelau', 'tokelau', 'en'),
(167, 34, '托克劳', '托克劳', 'zh'),
(168, 34, 'Tokelau', 'tokelau-1', 'es'),
(169, 34, 'Tokelau', 'tokelau-2', 'fr'),
(170, 34, 'توكيلاو', 'توكيلاو', 'ar'),
(171, 35, 'Guinea-Bissau', 'guinea-bissau', 'en'),
(172, 35, '几内亚比绍', '几内亚比绍', 'zh'),
(173, 35, 'Guinea-Bissau', 'guinea-bissau-1', 'es'),
(174, 35, 'Guinée-Bissau', 'guinee-bissau', 'fr'),
(175, 35, 'غينيا بيساو', 'غينيا-بيساو', 'ar'),
(176, 36, 'Guam', 'guam', 'en'),
(177, 36, '关岛', '关岛', 'zh'),
(178, 36, 'Guam', 'guam-1', 'es'),
(179, 36, 'Guam', 'guam-2', 'fr'),
(180, 36, 'غوام', 'غوام', 'ar'),
(181, 37, 'Guatemala', 'guatemala', 'en'),
(182, 37, '危地马拉', '危地马拉', 'zh'),
(183, 37, 'Guatemala', 'guatemala-1', 'es'),
(184, 37, 'Guatemala', 'guatemala-2', 'fr'),
(185, 37, 'غواتيمالا', 'غواتيمالا', 'ar'),
(186, 38, 'South Georgia and the South Sandwich Islands', 'south-georgia-and-the-south-sandwich-islands', 'en'),
(187, 38, '南乔治亚岛和南桑威奇群岛', '南乔治亚岛和南桑威奇群岛', 'zh'),
(188, 38, 'Georgia del sur y las islas Sandwich del sur', 'georgia-del-sur-y-las-islas-sandwich-del-sur', 'es'),
(189, 38, 'Géorgie du Sud et les îles Sandwich du Sud', 'georgie-du-sud-et-les-iles-sandwich-du-sud', 'fr'),
(190, 38, 'جورجيا الجنوبية وجزر ساندويتش الجنوبية', 'جورجيا-الجنوبية-وجزر-ساندويتش-الجنوب', 'ar'),
(191, 39, 'Greece', 'greece', 'en'),
(192, 39, '希腊', '希腊', 'zh'),
(193, 39, 'Grecia', 'grecia', 'es'),
(194, 39, 'Grèce', 'grece', 'fr'),
(195, 39, 'اليونان', 'اليونان', 'ar'),
(196, 40, 'Equatorial Guinea', 'equatorial-guinea', 'en'),
(197, 40, '赤道几内亚', '赤道几内亚', 'zh'),
(198, 40, 'Guinea Ecuatorial', 'guinea-ecuatorial', 'es'),
(199, 40, 'Guinée Équatoriale', 'guinee-equatoriale', 'fr'),
(200, 40, 'غينيا الإستوائية', 'غينيا-الإستوائية', 'ar'),
(201, 41, 'Guadeloupe', 'guadeloupe', 'en'),
(202, 41, '瓜德罗普岛', '瓜德罗普岛', 'zh'),
(203, 41, 'Guadalupe', 'guadalupe', 'es'),
(204, 41, 'La guadeloupe', 'la-guadeloupe', 'fr'),
(205, 41, 'جوادلوب', 'جوادلوب', 'ar'),
(206, 42, 'Japan', 'japan', 'en'),
(207, 42, '日本', '日本', 'zh'),
(208, 42, 'Japón', 'japon', 'es'),
(209, 42, 'Japon', 'japon-1', 'fr'),
(210, 42, 'اليابان', 'اليابان', 'ar'),
(211, 43, 'Guyana', 'guyana', 'en'),
(212, 43, '圭亚那', '圭亚那', 'zh'),
(213, 43, 'Guayana', 'guayana', 'es'),
(214, 43, 'Guyane', 'guyane', 'fr'),
(215, 43, 'غيانا', 'غيانا', 'ar'),
(216, 44, 'Guernsey', 'guernsey', 'en'),
(217, 44, '根西岛', '根西岛', 'zh'),
(218, 44, 'Guernsey', 'guernsey-1', 'es'),
(219, 44, 'Guernesey', 'guernesey', 'fr'),
(220, 44, 'غيرنسي', 'غيرنسي', 'ar'),
(221, 45, 'French Guiana', 'french-guiana', 'en'),
(222, 45, '法属圭亚那', '法属圭亚那', 'zh'),
(223, 45, 'Guayana Francesa', 'guayana-francesa', 'es'),
(224, 45, 'Guinée Française', 'guinee-francaise', 'fr'),
(225, 45, 'غيانا الفرنسية', 'غيانا-الفرنسية', 'ar'),
(226, 46, 'Georgia', 'georgia', 'en'),
(227, 46, '格鲁吉亚', '格鲁吉亚', 'zh'),
(228, 46, 'Georgia', 'georgia-1', 'es'),
(229, 46, 'Géorgie', 'georgie', 'fr'),
(230, 46, 'جورجيا', 'جورجيا', 'ar'),
(231, 47, 'Grenada', 'grenada', 'en'),
(232, 47, '格林纳达', '格林纳达', 'zh'),
(233, 47, 'Granada', 'granada', 'es'),
(234, 47, 'Grenade', 'grenade', 'fr'),
(235, 47, 'غرينادا', 'غرينادا', 'ar'),
(236, 48, 'United Kingdom', 'united-kingdom', 'en'),
(237, 48, '英国', '英国', 'zh'),
(238, 48, 'Reino Unido', 'reino-unido', 'es'),
(239, 48, 'Royaume-Uni', 'royaume-uni', 'fr'),
(240, 48, 'المملكة المتحدة', 'المملكة-المتحدة', 'ar'),
(241, 49, 'Gabon', 'gabon', 'en'),
(242, 49, '加蓬', '加蓬', 'zh'),
(243, 49, 'Gabón', 'gabon-1', 'es'),
(244, 49, 'Gabon', 'gabon-2', 'fr'),
(245, 49, 'الغابون', 'الغابون', 'ar'),
(246, 50, 'El Salvador', 'el-salvador', 'en'),
(247, 50, '萨尔瓦多', '萨尔瓦多', 'zh'),
(248, 50, 'El Salvador', 'el-salvador-1', 'es'),
(249, 50, 'Le Salvador', 'le-salvador', 'fr'),
(250, 50, 'السلفادور', 'السلفادور', 'ar'),
(251, 51, 'Guinea', 'guinea', 'en'),
(252, 51, '几内亚', '几内亚', 'zh'),
(253, 51, 'Guinea', 'guinea-1', 'es'),
(254, 51, 'Guinée', 'guinee', 'fr'),
(255, 51, 'غينيا', 'غينيا', 'ar'),
(256, 52, 'Gambia', 'gambia', 'en'),
(257, 52, '冈比亚', '冈比亚', 'zh'),
(258, 52, 'Gambia', 'gambia-1', 'es'),
(259, 52, 'Gambie', 'gambie', 'fr'),
(260, 52, 'غامبيا', 'غامبيا', 'ar'),
(261, 53, 'Greenland', 'greenland', 'en'),
(262, 53, '格陵兰', '格陵兰', 'zh'),
(263, 53, 'Tierra Verde', 'tierra-verde', 'es'),
(264, 53, 'Groenland', 'groenland', 'fr'),
(265, 53, 'الأرض الخضراء', 'الأرض-الخضراء', 'ar'),
(266, 54, 'Gibraltar', 'gibraltar', 'en'),
(267, 54, '直布罗陀', '直布罗陀', 'zh'),
(268, 54, 'Gibraltar', 'gibraltar-1', 'es'),
(269, 54, 'Gibraltar', 'gibraltar-2', 'fr'),
(270, 54, 'جبل طارق', 'جبل-طارق', 'ar'),
(271, 55, 'Ghana', 'ghana', 'en'),
(272, 55, '加纳', '加纳', 'zh'),
(273, 55, 'Ghana', 'ghana-1', 'es'),
(274, 55, 'Ghana', 'ghana-2', 'fr'),
(275, 55, 'غانا', 'غانا', 'ar'),
(276, 56, 'Oman', 'oman', 'en'),
(277, 56, '阿曼', '阿曼', 'zh'),
(278, 56, 'Omán', 'oman-1', 'es'),
(279, 56, 'Oman', 'oman-2', 'fr'),
(280, 56, 'سلطنة عمان', 'سلطنة-عمان', 'ar'),
(281, 57, 'Tunisia', 'tunisia', 'en'),
(282, 57, '突尼斯', '突尼斯', 'zh'),
(283, 57, 'Túnez', 'tunez', 'es'),
(284, 57, 'Tunisie', 'tunisie', 'fr'),
(285, 57, 'تونس', 'تونس', 'ar'),
(286, 58, 'Jordan', 'jordan', 'en'),
(287, 58, '约旦', '约旦', 'zh'),
(288, 58, 'Jordán', 'jordan-1', 'es'),
(289, 58, 'Jordan', 'jordan-2', 'fr'),
(290, 58, 'الأردن', 'الأردن', 'ar'),
(291, 59, 'Croatia', 'croatia', 'en'),
(292, 59, '克罗地亚', '克罗地亚', 'zh'),
(293, 59, 'Croacia', 'croacia', 'es'),
(294, 59, 'Croatie', 'croatie', 'fr'),
(295, 59, 'كرواتيا', 'كرواتيا', 'ar'),
(296, 60, 'Haiti', 'haiti', 'en'),
(297, 60, '海地', '海地', 'zh'),
(298, 60, 'Haití', 'haiti-1', 'es'),
(299, 60, 'Haïti', 'haiti-2', 'fr'),
(300, 60, 'هايتي', 'هايتي', 'ar'),
(301, 61, 'Hungary', 'hungary', 'en'),
(302, 61, '匈牙利', '匈牙利', 'zh'),
(303, 61, 'Hungría', 'hungria', 'es'),
(304, 61, 'Hongrie', 'hongrie', 'fr'),
(305, 61, 'المجر', 'المجر', 'ar'),
(306, 62, 'Hong Kong', 'hong-kong', 'en'),
(307, 62, '香港', '香港', 'zh'),
(308, 62, 'Hong Kong', 'hong-kong-1', 'es'),
(309, 62, 'Hong Kong', 'hong-kong-2', 'fr'),
(310, 62, 'هونغ كونغ', 'هونغ-كونغ', 'ar'),
(311, 63, 'Honduras', 'honduras', 'en'),
(312, 63, '洪都拉斯', '洪都拉斯', 'zh'),
(313, 63, 'Honduras', 'honduras-1', 'es'),
(314, 63, 'Honduras', 'honduras-2', 'fr'),
(315, 63, 'هندوراس', 'هندوراس', 'ar'),
(316, 64, 'Heard Island and McDonald Islands', 'heard-island-and-mcdonald-islands', 'en'),
(317, 64, '赫德岛和麦当劳群岛', '赫德岛和麦当劳群岛', 'zh'),
(318, 64, 'Islas Heard y McDonald', 'islas-heard-y-mcdonald', 'es'),
(319, 64, 'Îles Heard et McDonald', 'iles-heard-et-mcdonald', 'fr'),
(320, 64, 'قلب الجزيرة وجزر ماكدونالز', 'قلب-الجزيرة-وجزر-ماكدونالز', 'ar'),
(321, 65, 'Venezuela', 'venezuela', 'en'),
(322, 65, '委内瑞拉', '委内瑞拉', 'zh'),
(323, 65, 'Venezuela', 'venezuela-1', 'es'),
(324, 65, 'Venezuela', 'venezuela-2', 'fr'),
(325, 65, 'فنزويلا', 'فنزويلا', 'ar'),
(326, 66, 'Puerto Rico', 'puerto-rico', 'en'),
(327, 66, '波多黎各', '波多黎各', 'zh'),
(328, 66, 'Puerto Rico', 'puerto-rico-1', 'es'),
(329, 66, 'Porto Rico', 'porto-rico', 'fr'),
(330, 66, 'بورتوريكو', 'بورتوريكو', 'ar'),
(331, 67, 'Palestinian Territory', 'palestinian-territory', 'en'),
(332, 67, '巴勒斯坦领土', '巴勒斯坦领土', 'zh'),
(333, 67, 'Territorio Palestino', 'territorio-palestino', 'es'),
(334, 67, 'Territoire Palestinien', 'territoire-palestinien', 'fr'),
(335, 67, 'الأراضي الفلسطينية', 'الأراضي-الفلسطينية', 'ar'),
(336, 68, 'Palau', 'palau', 'en'),
(337, 68, '帕劳', '帕劳', 'zh'),
(338, 68, 'Palau', 'palau-1', 'es'),
(339, 68, 'Palau', 'palau-2', 'fr'),
(340, 68, 'بالاو', 'بالاو', 'ar'),
(341, 69, 'Portugal', 'portugal', 'en'),
(342, 69, '葡萄牙', '葡萄牙', 'zh'),
(343, 69, 'Portugal', 'portugal-1', 'es'),
(344, 69, 'Portugal', 'portugal-2', 'fr'),
(345, 69, 'البرتغال', 'البرتغال', 'ar'),
(346, 70, 'Svalbard and Jan Mayen', 'svalbard-and-jan-mayen', 'en'),
(347, 70, '斯瓦尔巴和扬马延', '斯瓦尔巴和扬马延', 'zh'),
(348, 70, 'Svalbard y Jan Mayen', 'svalbard-y-jan-mayen', 'es'),
(349, 70, 'Svalbard et Jan Mayen', 'svalbard-et-jan-mayen', 'fr'),
(350, 70, 'سفالبارد وجان مايان', 'سفالبارد-وجان-مايان', 'ar'),
(351, 71, 'Paraguay', 'paraguay', 'en'),
(352, 71, '巴拉圭', '巴拉圭', 'zh'),
(353, 71, 'Paraguay', 'paraguay-1', 'es'),
(354, 71, 'Paraguay', 'paraguay-2', 'fr'),
(355, 71, 'باراغواي', 'باراغواي', 'ar'),
(356, 72, 'Iraq', 'iraq', 'en'),
(357, 72, '伊拉克', '伊拉克', 'zh'),
(358, 72, 'Irak', 'irak', 'es'),
(359, 72, 'Irak', 'irak-1', 'fr'),
(360, 72, 'العراق', 'العراق', 'ar'),
(361, 73, 'Panama', 'panama', 'en'),
(362, 73, '巴拿马', '巴拿马', 'zh'),
(363, 73, 'Panamá', 'panama-1', 'es'),
(364, 73, 'Panama', 'panama-2', 'fr'),
(365, 73, 'بنما', 'بنما', 'ar'),
(366, 74, 'French Polynesia', 'french-polynesia', 'en'),
(367, 74, '法属波利尼西亚', '法属波利尼西亚', 'zh'),
(368, 74, 'Polinesia francés', 'polinesia-frances', 'es'),
(369, 74, 'Polynésie française', 'polynesie-francaise', 'fr'),
(370, 74, 'بولينيزيا الفرنسية', 'بولينيزيا-الفرنسية', 'ar'),
(371, 75, 'Papua New Guinea', 'papua-new-guinea', 'en'),
(372, 75, '巴布亚新几内亚', '巴布亚新几内亚', 'zh'),
(373, 75, 'Papúa Nueva Guinea', 'papua-nueva-guinea', 'es'),
(374, 75, 'Papouasie Nouvelle Guinée', 'papouasie-nouvelle-guinee', 'fr'),
(375, 75, 'بابوا غينيا الجديدة', 'بابوا-غينيا-الجديدة', 'ar'),
(376, 76, 'Peru', 'peru', 'en'),
(377, 76, '秘鲁', '秘鲁', 'zh'),
(378, 76, 'Perú', 'peru-1', 'es'),
(379, 76, 'Pérou', 'perou', 'fr'),
(380, 76, 'بيرو', 'بيرو', 'ar'),
(381, 77, 'Pakistan', 'pakistan', 'en'),
(382, 77, '巴基斯坦', '巴基斯坦', 'zh'),
(383, 77, 'Pakistán', 'pakistan-1', 'es'),
(384, 77, 'Pakistan', 'pakistan-2', 'fr'),
(385, 77, 'باكستان', 'باكستان', 'ar'),
(386, 78, 'Philippines', 'philippines', 'en'),
(387, 78, '菲律宾', '菲律宾', 'zh'),
(388, 78, 'Filipinos', 'filipinos', 'es'),
(389, 78, 'Philippines', 'philippines-1', 'fr'),
(390, 78, 'الفلبين', 'الفلبين', 'ar'),
(391, 79, 'Pitcairn', 'pitcairn', 'en'),
(392, 79, '皮特凯恩', '皮特凯恩', 'zh'),
(393, 79, 'Pitcairn', 'pitcairn-1', 'es'),
(394, 79, 'Pitcairn', 'pitcairn-2', 'fr'),
(395, 79, 'بيتكيرن', 'بيتكيرن', 'ar'),
(396, 80, 'Poland', 'poland', 'en'),
(397, 80, '波兰', '波兰', 'zh'),
(398, 80, 'Polonia', 'polonia', 'es'),
(399, 80, 'Pologne', 'pologne', 'fr'),
(400, 80, 'بولندا', 'بولندا', 'ar'),
(401, 81, 'Saint Pierre and Miquelon', 'saint-pierre-and-miquelon', 'en'),
(402, 81, '圣皮埃尔和密克隆', '圣皮埃尔和密克隆', 'zh'),
(403, 81, 'San Pedro y Miquelón', 'san-pedro-y-miquelon', 'es'),
(404, 81, 'Saint Pierre et Miquelon', 'saint-pierre-et-miquelon', 'fr'),
(405, 81, 'سانت بيير وميكلون', 'سانت-بيير-وميكلون', 'ar'),
(406, 82, 'Zambia', 'zambia', 'en'),
(407, 82, '赞比亚', '赞比亚', 'zh'),
(408, 82, 'Zambia', 'zambia-1', 'es'),
(409, 82, 'Zambie', 'zambie', 'fr'),
(410, 82, 'زامبيا', 'زامبيا', 'ar'),
(411, 83, 'Western Sahara', 'western-sahara', 'en'),
(412, 83, '撒哈拉沙漠西部', '撒哈拉沙漠西部', 'zh'),
(413, 83, 'Sahara Occidental', 'sahara-occidental', 'es'),
(414, 83, 'Sahara occidental', 'sahara-occidental-1', 'fr'),
(415, 83, 'الصحراء الغربية', 'الصحراء-الغربية', 'ar'),
(416, 84, 'Estonia', 'estonia', 'en'),
(417, 84, '爱沙尼亚', '爱沙尼亚', 'zh'),
(418, 84, 'Estonia', 'estonia-1', 'es'),
(419, 84, 'Estonie', 'estonie', 'fr'),
(420, 84, 'استونيا', 'استونيا', 'ar'),
(421, 85, 'Egypt', 'egypt', 'en'),
(422, 85, '埃及', '埃及', 'zh'),
(423, 85, 'Egipto', 'egipto', 'es'),
(424, 85, 'Egypte', 'egypte', 'fr'),
(425, 85, 'مصر', 'مصر', 'ar'),
(426, 86, 'South Africa', 'south-africa', 'en'),
(427, 86, '南非', '南非', 'zh'),
(428, 86, 'Sudáfrica', 'sudafrica', 'es'),
(429, 86, 'Afrique du Sud', 'afrique-du-sud', 'fr'),
(430, 86, 'جنوب أفريقيا', 'جنوب-أفريقيا', 'ar'),
(431, 87, 'Ecuador', 'ecuador', 'en'),
(432, 87, '厄瓜多尔', '厄瓜多尔', 'zh'),
(433, 87, 'Ecuador', 'ecuador-1', 'es'),
(434, 87, 'L\'Équateur', 'lequateur', 'fr'),
(435, 87, 'الإكوادور', 'الإكوادور', 'ar'),
(436, 88, 'Italy', 'italy', 'en'),
(437, 88, '意大利', '意大利', 'zh'),
(438, 88, 'Italia', 'italia', 'es'),
(439, 88, 'Italie', 'italie', 'fr'),
(440, 88, 'إيطاليا', 'إيطاليا', 'ar'),
(441, 89, 'Vietnam', 'vietnam', 'en'),
(442, 89, '越南', '越南', 'zh'),
(443, 89, 'Vietnam', 'vietnam-1', 'es'),
(444, 89, 'Vietnam', 'vietnam-2', 'fr'),
(445, 89, 'فيتنام', 'فيتنام', 'ar'),
(446, 90, 'Solomon Islands', 'solomon-islands', 'en'),
(447, 90, '所罗门群岛', '所罗门群岛', 'zh'),
(448, 90, 'Islas Salomón', 'islas-salomon', 'es'),
(449, 90, 'Les îles Salomon', 'les-iles-salomon', 'fr'),
(450, 90, 'جزر سليمان', 'جزر-سليمان', 'ar'),
(451, 91, 'Ethiopia', 'ethiopia', 'en'),
(452, 91, '埃塞俄比亚', '埃塞俄比亚', 'zh'),
(453, 91, 'Etiopía', 'etiopia', 'es'),
(454, 91, 'Ethiopie', 'ethiopie', 'fr'),
(455, 91, 'أثيوبيا', 'أثيوبيا', 'ar'),
(456, 92, 'Somalia', 'somalia', 'en'),
(457, 92, '索马里', '索马里', 'zh'),
(458, 92, 'Somalia', 'somalia-1', 'es'),
(459, 92, 'Somalie', 'somalie', 'fr'),
(460, 92, 'الصومال', 'الصومال', 'ar'),
(461, 93, 'Zimbabwe', 'zimbabwe', 'en'),
(462, 93, '津巴布韦', '津巴布韦', 'zh'),
(463, 93, 'Zimbabue', 'zimbabue', 'es'),
(464, 93, 'Zimbabwe', 'zimbabwe-1', 'fr'),
(465, 93, 'زيمبابوي', 'زيمبابوي', 'ar'),
(466, 94, 'Saudi Arabia', 'saudi-arabia', 'en'),
(467, 94, '沙特阿拉伯', '沙特阿拉伯', 'zh'),
(468, 94, 'Arabia Saudita', 'arabia-saudita', 'es'),
(469, 94, 'Arabie Saoudite', 'arabie-saoudite', 'fr'),
(470, 94, 'المملكة العربية السعودية', 'المملكة-العربية-السعودية', 'ar'),
(471, 95, 'Spain', 'spain', 'en'),
(472, 95, '西班牙', '西班牙', 'zh'),
(473, 95, 'España', 'espana', 'es'),
(474, 95, 'Espagne', 'espagne', 'fr'),
(475, 95, 'إسبانيا', 'إسبانيا', 'ar'),
(476, 96, 'Eritrea', 'eritrea', 'en'),
(477, 96, '厄立特里亚', '厄立特里亚', 'zh'),
(478, 96, 'Eritrea', 'eritrea-1', 'es'),
(479, 96, 'Erythrée', 'erythree', 'fr'),
(480, 96, 'إريتريا', 'إريتريا', 'ar'),
(481, 97, 'Montenegro', 'montenegro', 'en'),
(482, 97, '黑山', '黑山', 'zh'),
(483, 97, 'Montenegro', 'montenegro-1', 'es'),
(484, 97, 'Monténégro', 'montenegro-2', 'fr'),
(485, 97, 'الجبل الأسود', 'الجبل-الأسود', 'ar'),
(486, 98, 'Moldova', 'moldova', 'en'),
(487, 98, '摩尔多瓦', '摩尔多瓦', 'zh'),
(488, 98, 'Moldavia', 'moldavia', 'es'),
(489, 98, 'La Moldavie', 'la-moldavie', 'fr'),
(490, 98, 'مولدوفا', 'مولدوفا', 'ar'),
(491, 99, 'Madagascar', 'madagascar', 'en'),
(492, 99, '马达加斯加', '马达加斯加', 'zh'),
(493, 99, 'Madagascar', 'madagascar-1', 'es'),
(494, 99, 'Madagascar', 'madagascar-2', 'fr'),
(495, 99, 'مدغشقر', 'مدغشقر', 'ar'),
(496, 100, 'Saint Martin', 'saint-martin', 'en'),
(497, 100, '圣马丁', '圣马丁', 'zh'),
(498, 100, 'San Martín', 'san-martin', 'es'),
(499, 100, 'Saint Martin', 'saint-martin-1', 'fr'),
(500, 100, 'القديس مارتن', 'القديس-مارتن', 'ar'),
(501, 101, 'Morocco', 'morocco', 'en'),
(502, 101, '摩洛哥', '摩洛哥', 'zh'),
(503, 101, 'Marruecos', 'marruecos', 'es'),
(504, 101, 'Maroc', 'maroc', 'fr'),
(505, 101, 'المغرب', 'المغرب', 'ar'),
(506, 102, 'Monaco', 'monaco', 'en'),
(507, 102, '摩纳哥', '摩纳哥', 'zh'),
(508, 102, 'Mónaco', 'monaco-1', 'es'),
(509, 102, 'Monaco', 'monaco-2', 'fr'),
(510, 102, 'موناكو', 'موناكو', 'ar'),
(511, 103, 'Uzbekistan', 'uzbekistan', 'en'),
(512, 103, '乌兹别克斯坦', '乌兹别克斯坦', 'zh'),
(513, 103, 'Uzbekistán', 'uzbekistan-1', 'es'),
(514, 103, 'Ouzbékistan', 'ouzbekistan', 'fr'),
(515, 103, 'أوزبكستان', 'أوزبكستان', 'ar'),
(516, 104, 'Myanmar', 'myanmar', 'en'),
(517, 104, '缅甸', '缅甸', 'zh'),
(518, 104, 'Myanmar', 'myanmar-1', 'es'),
(519, 104, 'Myanmar', 'myanmar-2', 'fr'),
(520, 104, 'ميانمار', 'ميانمار', 'ar'),
(521, 105, 'Mali', 'mali', 'en'),
(522, 105, '马里', '马里', 'zh'),
(523, 105, 'Mali', 'mali-1', 'es'),
(524, 105, 'Mali', 'mali-2', 'fr'),
(525, 105, 'مالي', 'مالي', 'ar'),
(526, 106, 'Macao', 'macao', 'en'),
(527, 106, '澳门', '澳门', 'zh'),
(528, 106, 'Macao', 'macao-1', 'es'),
(529, 106, 'Macao', 'macao-2', 'fr'),
(530, 106, 'ماكاو', 'ماكاو', 'ar'),
(531, 107, 'Mongolia', 'mongolia', 'en'),
(532, 107, '蒙古', '蒙古', 'zh'),
(533, 107, 'Mongolia', 'mongolia-1', 'es'),
(534, 107, 'Mongolie', 'mongolie', 'fr'),
(535, 107, 'منغوليا', 'منغوليا', 'ar'),
(536, 108, 'Marshall Islands', 'marshall-islands', 'en'),
(537, 108, '马绍尔群岛', '马绍尔群岛', 'zh'),
(538, 108, 'Islas Marshall', 'islas-marshall', 'es'),
(539, 108, 'Iles Marshall', 'iles-marshall', 'fr'),
(540, 108, 'جزر مارشال', 'جزر-مارشال', 'ar'),
(541, 109, 'Macedonia', 'macedonia', 'en'),
(542, 109, '马其顿', '马其顿', 'zh'),
(543, 109, 'Macedonia', 'macedonia-1', 'es'),
(544, 109, 'Macedonia', 'macedonia-2', 'fr'),
(545, 109, 'مقدونيا', 'مقدونيا', 'ar'),
(546, 110, 'Mauritius', 'mauritius', 'en'),
(547, 110, '毛里求斯', '毛里求斯', 'zh'),
(548, 110, 'Mauricio', 'mauricio', 'es'),
(549, 110, 'Maurice', 'maurice', 'fr'),
(550, 110, 'موريشيوس', 'موريشيوس', 'ar'),
(551, 111, 'Malta', 'malta', 'en'),
(552, 111, '马耳他', '马耳他', 'zh'),
(553, 111, 'Malta', 'malta-1', 'es'),
(554, 111, 'Malte', 'malte', 'fr'),
(555, 111, 'مالطا', 'مالطا', 'ar'),
(556, 112, 'Malawi', 'malawi', 'en'),
(557, 112, '马拉维', '马拉维', 'zh'),
(558, 112, 'Malawi', 'malawi-1', 'es'),
(559, 112, 'Malawi', 'malawi-2', 'fr'),
(560, 112, 'مالاوي', 'مالاوي', 'ar'),
(561, 113, 'Maldives', 'maldives', 'en'),
(562, 113, '马尔代夫', '马尔代夫', 'zh'),
(563, 113, 'Maldivos', 'maldivos', 'es'),
(564, 113, 'Maldives', 'maldives-1', 'fr'),
(565, 113, 'جزر المالديف', 'جزر-المالديف', 'ar'),
(566, 114, 'Martinique', 'martinique', 'en'),
(567, 114, '马提尼克', '马提尼克', 'zh'),
(568, 114, 'Martinica', 'martinica', 'es'),
(569, 114, 'Martinique', 'martinique-1', 'fr'),
(570, 114, 'مارتينيك', 'مارتينيك', 'ar'),
(571, 115, 'Northern Mariana Islands', 'northern-mariana-islands', 'en'),
(572, 115, '北马里亚纳群岛', '北马里亚纳群岛', 'zh'),
(573, 115, 'Islas Marianas del Norte', 'islas-marianas-del-norte', 'es'),
(574, 115, 'Northern Mariana Islands', 'northern-mariana-islands-1', 'fr'),
(575, 115, 'جزر مريانا الشمالية', 'جزر-مريانا-الشمالية', 'ar'),
(576, 116, 'Montserrat', 'montserrat', 'en'),
(577, 116, '蒙特塞拉特', '蒙特塞拉特', 'zh'),
(578, 116, 'Montserrat', 'montserrat-1', 'es'),
(579, 116, 'Montserrat', 'montserrat-2', 'fr'),
(580, 116, 'مونتسيرات', 'مونتسيرات', 'ar'),
(581, 117, 'Mauritania', 'mauritania', 'en'),
(582, 117, '毛里塔尼亚', '毛里塔尼亚', 'zh'),
(583, 117, 'Mauritania', 'mauritania-1', 'es'),
(584, 117, 'Mauritanie', 'mauritanie', 'fr'),
(585, 117, 'موريتانيا', 'موريتانيا', 'ar'),
(586, 118, 'Isle of Man', 'isle-of-man', 'en'),
(587, 118, '马恩岛', '马恩岛', 'zh'),
(588, 118, 'Isla del hombre', 'isla-del-hombre', 'es'),
(589, 118, 'Ile de Man', 'ile-de-man', 'fr'),
(590, 118, 'جزيرة آيل أوف مان', 'جزيرة-آيل-أوف-مان', 'ar'),
(591, 119, 'Uganda', 'uganda', 'en'),
(592, 119, '乌干达', '乌干达', 'zh'),
(593, 119, 'Uganda', 'uganda-1', 'es'),
(594, 119, 'Ouganda', 'ouganda', 'fr'),
(595, 119, 'أوغندا', 'أوغندا', 'ar'),
(596, 120, 'Tanzania', 'tanzania', 'en'),
(597, 120, '坦桑尼亚', '坦桑尼亚', 'zh'),
(598, 120, 'Tanzania', 'tanzania-1', 'es'),
(599, 120, 'Tanzanie', 'tanzanie', 'fr'),
(600, 120, 'تنزانيا', 'تنزانيا', 'ar'),
(601, 121, 'Malaysia', 'malaysia', 'en'),
(602, 121, '马来西亚', '马来西亚', 'zh'),
(603, 121, 'Malasia', 'malasia', 'es'),
(604, 121, 'Malaisie', 'malaisie', 'fr'),
(605, 121, 'ماليزيا', 'ماليزيا', 'ar'),
(606, 122, 'Mexico', 'mexico', 'en'),
(607, 122, '墨西哥', '墨西哥', 'zh'),
(608, 122, 'Mexico', 'mexico-1', 'es'),
(609, 122, 'Mexique', 'mexique', 'fr'),
(610, 122, 'المكسيك', 'المكسيك', 'ar'),
(611, 123, 'France', 'france', 'en'),
(612, 123, '法国', '法国', 'zh'),
(613, 123, 'Francia', 'francia', 'es'),
(614, 123, 'France', 'france-1', 'fr'),
(615, 123, 'فرنسا', 'فرنسا', 'ar'),
(616, 124, 'British Indian Ocean Territory', 'british-indian-ocean-territory', 'en'),
(617, 124, '英属印度洋领地', '英属印度洋领地', 'zh'),
(618, 124, 'Territorio Británico del Océano Índico', 'territorio-britanico-del-oceano-indico', 'es'),
(619, 124, 'Territoire britannique de l\'océan Indien', 'territoire-britannique-de-locean-indien', 'fr'),
(620, 124, 'إقليم المحيط البريطاني الهندي', 'إقليم-المحيط-البريطاني-الهندي', 'ar'),
(621, 125, 'Saint Helena', 'saint-helena', 'en'),
(622, 125, '圣赫勒拿岛', '圣赫勒拿岛', 'zh'),
(623, 125, 'Santa helena', 'santa-helena', 'es'),
(624, 125, 'Sainte Hélène', 'sainte-helene', 'fr'),
(625, 125, 'سانت هيلانة', 'سانت-هيلانة', 'ar'),
(626, 126, 'Finland', 'finland', 'en'),
(627, 126, '芬兰', '芬兰', 'zh'),
(628, 126, 'Finlandia', 'finlandia', 'es'),
(629, 126, 'Finlande', 'finlande', 'fr'),
(630, 126, 'فنلندا', 'فنلندا', 'ar'),
(631, 127, 'Fiji', 'fiji', 'en'),
(632, 127, '斐', '斐', 'zh'),
(633, 127, 'Fiyi', 'fiyi', 'es'),
(634, 127, 'Fidji', 'fidji', 'fr'),
(635, 127, 'فيجي', 'فيجي', 'ar'),
(636, 128, 'Falkland Islands', 'falkland-islands', 'en'),
(637, 128, '福克兰群岛', '福克兰群岛', 'zh'),
(638, 128, 'Islas Malvinas', 'islas-malvinas', 'es'),
(639, 128, 'les îles Falkland', 'les-iles-falkland', 'fr'),
(640, 128, 'جزر فوكلاند', 'جزر-فوكلاند', 'ar'),
(641, 129, 'Micronesia', 'micronesia', 'en'),
(642, 129, '密克罗尼西亚', '密克罗尼西亚', 'zh'),
(643, 129, 'Micronesia', 'micronesia-1', 'es'),
(644, 129, 'Micronésie', 'micronesie', 'fr'),
(645, 129, 'ميكرونيزيا', 'ميكرونيزيا', 'ar'),
(646, 130, 'Faroe Islands', 'faroe-islands', 'en'),
(647, 130, '法罗群岛', '法罗群岛', 'zh'),
(648, 130, 'Islas Faroe', 'islas-faroe', 'es'),
(649, 130, 'Îles Féroé', 'iles-feroe', 'fr'),
(650, 130, 'جزر فارو', 'جزر-فارو', 'ar'),
(651, 131, 'Nicaragua', 'nicaragua', 'en'),
(652, 131, '尼加拉瓜', '尼加拉瓜', 'zh'),
(653, 131, 'Nicaragua', 'nicaragua-1', 'es'),
(654, 131, 'Nicaragua', 'nicaragua-2', 'fr'),
(655, 131, 'نيكاراغوا', 'نيكاراغوا', 'ar'),
(656, 132, 'Netherlands', 'netherlands', 'en'),
(657, 132, '荷兰', '荷兰', 'zh'),
(658, 132, 'Países Bajos', 'paises-bajos', 'es'),
(659, 132, 'Pays-Bas', 'pays-bas', 'fr'),
(660, 132, 'هولندا', 'هولندا', 'ar'),
(661, 133, 'Norway', 'norway', 'en'),
(662, 133, '挪威', '挪威', 'zh'),
(663, 133, 'Noruega', 'noruega', 'es'),
(664, 133, 'Norvège', 'norvege', 'fr'),
(665, 133, 'النرويج', 'النرويج', 'ar'),
(666, 134, 'Namibia', 'namibia', 'en'),
(667, 134, '纳米比亚', '纳米比亚', 'zh'),
(668, 134, 'Namibia', 'namibia-1', 'es'),
(669, 134, 'Namibie', 'namibie', 'fr'),
(670, 134, 'ناميبيا', 'ناميبيا', 'ar'),
(671, 135, 'Vanuatu', 'vanuatu', 'en'),
(672, 135, '瓦努阿图', '瓦努阿图', 'zh'),
(673, 135, 'Vanuatu', 'vanuatu-1', 'es'),
(674, 135, 'Vanuatu', 'vanuatu-2', 'fr'),
(675, 135, 'فانواتو', 'فانواتو', 'ar'),
(676, 136, 'New Caledonia', 'new-caledonia', 'en'),
(677, 136, '新喀里多尼亚', '新喀里多尼亚', 'zh'),
(678, 136, 'Nueva Caledonia', 'nueva-caledonia', 'es'),
(679, 136, 'Nouvelle Calédonie', 'nouvelle-caledonie', 'fr'),
(680, 136, 'كاليدونيا الجديدة', 'كاليدونيا-الجديدة', 'ar'),
(681, 137, 'Niger', 'niger', 'en'),
(682, 137, '尼日尔', '尼日尔', 'zh'),
(683, 137, 'Níger', 'niger-1', 'es'),
(684, 137, 'Niger', 'niger-2', 'fr'),
(685, 137, 'النيجر', 'النيجر', 'ar'),
(686, 138, 'Norfolk Island', 'norfolk-island', 'en'),
(687, 138, '诺福克岛', '诺福克岛', 'zh'),
(688, 138, 'Isla Norfolk', 'isla-norfolk', 'es'),
(689, 138, 'l\'ile de Norfolk', 'lile-de-norfolk', 'fr'),
(690, 138, 'جزيرة نورفولك', 'جزيرة-نورفولك', 'ar'),
(691, 139, 'Nigeria', 'nigeria', 'en'),
(692, 139, '尼日利亚', '尼日利亚', 'zh'),
(693, 139, 'Nigeria', 'nigeria-1', 'es'),
(694, 139, 'Nigeria', 'nigeria-2', 'fr'),
(695, 139, 'نيجيريا', 'نيجيريا', 'ar'),
(696, 140, 'New Zealand', 'new-zealand', 'en'),
(697, 140, '新西兰', '新西兰', 'zh'),
(698, 140, 'Nueva Zelanda', 'nueva-zelanda', 'es'),
(699, 140, 'Nouvelle-Zélande', 'nouvelle-zelande', 'fr'),
(700, 140, 'نيوزيلاندا', 'نيوزيلاندا', 'ar'),
(701, 141, 'Nepal', 'nepal', 'en'),
(702, 141, '尼泊尔', '尼泊尔', 'zh'),
(703, 141, 'Nepal', 'nepal-1', 'es'),
(704, 141, 'Népal', 'nepal-2', 'fr'),
(705, 141, 'نيبال', 'نيبال', 'ar'),
(706, 142, 'Nauru', 'nauru', 'en'),
(707, 142, '瑙鲁', '瑙鲁', 'zh'),
(708, 142, 'Nauru', 'nauru-1', 'es'),
(709, 142, 'Nauru', 'nauru-2', 'fr'),
(710, 142, 'ناورو', 'ناورو', 'ar'),
(711, 143, 'Niue', 'niue', 'en'),
(712, 143, '纽埃', '纽埃', 'zh'),
(713, 143, 'Niue', 'niue-1', 'es'),
(714, 143, 'Niue', 'niue-2', 'fr'),
(715, 143, 'نيوي', 'نيوي', 'ar'),
(716, 144, 'Cook Islands', 'cook-islands', 'en'),
(717, 144, '库克群岛', '库克群岛', 'zh'),
(718, 144, 'Islas Cook', 'islas-cook', 'es'),
(719, 144, 'les Îles Cook', 'les-iles-cook', 'fr'),
(720, 144, 'جزر كوك', 'جزر-كوك', 'ar'),
(721, 145, 'Kosovo', 'kosovo', 'en'),
(722, 145, '科索沃', '科索沃', 'zh'),
(723, 145, 'Kosovo', 'kosovo-1', 'es'),
(724, 145, 'Kosovo', 'kosovo-2', 'fr'),
(725, 145, 'كوسوفو', 'كوسوفو', 'ar'),
(726, 146, 'Ivory Coast', 'ivory-coast', 'en'),
(727, 146, '象牙海岸', '象牙海岸', 'zh'),
(728, 146, 'Costa de Marfil', 'costa-de-marfil', 'es'),
(729, 146, 'Côte d\'Ivoire', 'cote-divoire', 'fr'),
(730, 146, 'ساحل العاج', 'ساحل-العاج', 'ar'),
(731, 147, 'Switzerland', 'switzerland', 'en'),
(732, 147, '瑞士', '瑞士', 'zh'),
(733, 147, 'Suiza', 'suiza', 'es'),
(734, 147, 'Suisse', 'suisse', 'fr'),
(735, 147, 'سويسرا', 'سويسرا', 'ar'),
(736, 148, 'Colombia', 'colombia', 'en'),
(737, 148, '哥伦比亚', '哥伦比亚', 'zh'),
(738, 148, 'Colombia', 'colombia-1', 'es'),
(739, 148, 'Colombie', 'colombie', 'fr'),
(740, 148, 'كولومبيا', 'كولومبيا', 'ar'),
(741, 149, 'China', 'china', 'en'),
(742, 149, '中国', '中国', 'zh'),
(743, 149, 'China', 'china-1', 'es'),
(744, 149, 'Chine', 'chine', 'fr'),
(745, 149, 'الصين', 'الصين', 'ar'),
(746, 150, 'Cameroon', 'cameroon', 'en'),
(747, 150, '喀麦隆', '喀麦隆', 'zh'),
(748, 150, 'Camerún', 'camerun', 'es'),
(749, 150, 'Cameroun', 'cameroun', 'fr'),
(750, 150, 'الكاميرون', 'الكاميرون', 'ar'),
(751, 151, 'Chile', 'chile', 'en'),
(752, 151, '智利', '智利', 'zh'),
(753, 151, 'Chile', 'chile-1', 'es'),
(754, 151, 'Chili', 'chili', 'fr'),
(755, 151, 'تشيلي', 'تشيلي', 'ar'),
(756, 152, 'Cocos Islands', 'cocos-islands', 'en'),
(757, 152, '科科斯群岛', '科科斯群岛', 'zh'),
(758, 152, 'Islas cocos', 'islas-cocos', 'es'),
(759, 152, 'Îles Cocos', 'iles-cocos', 'fr'),
(760, 152, 'جزر كوكوس', 'جزر-كوكوس', 'ar'),
(761, 153, 'Canada', 'canada', 'en'),
(762, 153, '加拿大', '加拿大', 'zh'),
(763, 153, 'Canadá', 'canada-1', 'es'),
(764, 153, 'Canada', 'canada-2', 'fr'),
(765, 153, 'كندا', 'كندا', 'ar'),
(766, 154, 'Republic of the Congo', 'republic-of-the-congo', 'en'),
(767, 154, '刚果共和国', '刚果共和国', 'zh'),
(768, 154, 'Republica del congo', 'republica-del-congo', 'es'),
(769, 154, 'République du Congo', 'republique-du-congo', 'fr'),
(770, 154, 'جمهورية الكونغو', 'جمهورية-الكونغو', 'ar'),
(771, 155, 'Central African Republic', 'central-african-republic', 'en'),
(772, 155, '中非共和国', '中非共和国', 'zh'),
(773, 155, 'República Centroafricana', 'republica-centroafricana', 'es'),
(774, 155, 'République centrafricaine', 'republique-centrafricaine', 'fr'),
(775, 155, 'جمهورية افريقيا الوسطى', 'جمهورية-افريقيا-الوسطى', 'ar'),
(776, 156, 'Democratic Republic of the Congo', 'democratic-republic-of-the-congo', 'en'),
(777, 156, '刚果民主共和国', '刚果民主共和国', 'zh'),
(778, 156, 'República Democrática del Congo', 'republica-democratica-del-congo', 'es'),
(779, 156, 'République Démocratique du Congo', 'republique-democratique-du-congo', 'fr'),
(780, 156, 'جمهورية الكونغو الديموقراطية', 'جمهورية-الكونغو-الديموقراطية', 'ar'),
(781, 157, 'Czech Republic', 'czech-republic', 'en'),
(782, 157, '捷克共和国', '捷克共和国', 'zh'),
(783, 157, 'Republica checa', 'republica-checa', 'es'),
(784, 157, 'République Tchèque', 'republique-tcheque', 'fr'),
(785, 157, 'جمهورية التشيك', 'جمهورية-التشيك', 'ar'),
(786, 158, 'Cyprus', 'cyprus', 'en'),
(787, 158, '塞浦路斯', '塞浦路斯', 'zh'),
(788, 158, 'Chipre', 'chipre', 'es'),
(789, 158, 'Chypre', 'chypre', 'fr'),
(790, 158, 'قبرص', 'قبرص', 'ar'),
(791, 159, 'Christmas Island', 'christmas-island', 'en'),
(792, 159, '圣诞岛', '圣诞岛', 'zh'),
(793, 159, 'Isla de Navidad', 'isla-de-navidad', 'es'),
(794, 159, 'L\'île de noël', 'lile-de-noel', 'fr'),
(795, 159, 'جزيرة الكريسماس', 'جزيرة-الكريسماس', 'ar'),
(796, 160, 'Costa Rica', 'costa-rica', 'en'),
(797, 160, '哥斯达黎加', '哥斯达黎加', 'zh'),
(798, 160, 'Costa Rica', 'costa-rica-1', 'es'),
(799, 160, 'Costa Rica', 'costa-rica-2', 'fr'),
(800, 160, 'كوستا ريكا', 'كوستا-ريكا', 'ar'),
(801, 161, 'Curacao', 'curacao', 'en'),
(802, 161, '库拉索', '库拉索', 'zh'),
(803, 161, 'Curazao', 'curazao', 'es'),
(804, 161, 'Curacao', 'curacao-1', 'fr'),
(805, 161, 'كوراكاو', 'كوراكاو', 'ar'),
(806, 162, 'Cape Verde', 'cape-verde', 'en'),
(807, 162, '佛得角', '佛得角', 'zh'),
(808, 162, 'Cabo Verde', 'cabo-verde', 'es'),
(809, 162, 'Cap-Vert', 'cap-vert', 'fr'),
(810, 162, 'الرأس الأخضر', 'الرأس-الأخضر', 'ar'),
(811, 163, 'Cuba', 'cuba', 'en'),
(812, 163, '古巴', '古巴', 'zh'),
(813, 163, 'Cuba', 'cuba-1', 'es'),
(814, 163, 'Cuba', 'cuba-2', 'fr'),
(815, 163, 'كوبا', 'كوبا', 'ar'),
(816, 164, 'Swaziland', 'swaziland', 'en'),
(817, 164, '斯威士兰', '斯威士兰', 'zh'),
(818, 164, 'Suazilandia', 'suazilandia', 'es'),
(819, 164, 'Swaziland', 'swaziland-1', 'fr'),
(820, 164, 'سوازيلاند', 'سوازيلاند', 'ar'),
(821, 165, 'Syria', 'syria', 'en'),
(822, 165, '叙利亚', '叙利亚', 'zh'),
(823, 165, 'Siria', 'siria', 'es'),
(824, 165, 'Syria', 'syria-1', 'fr'),
(825, 165, 'سوريا', 'سوريا', 'ar'),
(826, 166, 'Sint Maarten', 'sint-maarten', 'en'),
(827, 166, '圣马丁岛', '圣马丁岛', 'zh'),
(828, 166, 'San Martín', 'san-martin-1', 'es'),
(829, 166, 'Sint Maarten', 'sint-maarten-1', 'fr'),
(830, 166, 'سينت مارتن', 'سينت-مارتن', 'ar'),
(831, 167, 'Kyrgyzstan', 'kyrgyzstan', 'en'),
(832, 167, '吉尔吉斯斯坦', '吉尔吉斯斯坦', 'zh'),
(833, 167, 'Kirguizstán', 'kirguizstan', 'es'),
(834, 167, 'Kirghizistan', 'kirghizistan', 'fr'),
(835, 167, 'قرغيزستان', 'قرغيزستان', 'ar'),
(836, 168, 'Kenya', 'kenya', 'en'),
(837, 168, '肯尼亚', '肯尼亚', 'zh'),
(838, 168, 'Kenia', 'kenia', 'es'),
(839, 168, 'Kenya', 'kenya-1', 'fr'),
(840, 168, 'كينيا', 'كينيا', 'ar'),
(841, 169, 'South Sudan', 'south-sudan', 'en'),
(842, 169, '南苏丹', '南苏丹', 'zh'),
(843, 169, 'Sudán del Sur', 'sudan-del-sur', 'es'),
(844, 169, 'Soudan du sud', 'soudan-du-sud', 'fr'),
(845, 169, 'جنوب السودان', 'جنوب-السودان', 'ar'),
(846, 170, 'Suriname', 'suriname', 'en'),
(847, 170, '苏里南', '苏里南', 'zh'),
(848, 170, 'Surinam', 'surinam', 'es'),
(849, 170, 'Suriname', 'suriname-1', 'fr'),
(850, 170, 'سورينام', 'سورينام', 'ar'),
(851, 171, 'Kiribati', 'kiribati', 'en'),
(852, 171, '基里巴斯', '基里巴斯', 'zh'),
(853, 171, 'Kiribati', 'kiribati-1', 'es'),
(854, 171, 'Kiribati', 'kiribati-2', 'fr'),
(855, 171, 'كيريباس', 'كيريباس', 'ar'),
(856, 172, 'Cambodia', 'cambodia', 'en'),
(857, 172, '柬埔寨', '柬埔寨', 'zh'),
(858, 172, 'Camboya', 'camboya', 'es'),
(859, 172, 'Cambodge', 'cambodge', 'fr'),
(860, 172, 'كمبوديا', 'كمبوديا', 'ar'),
(861, 173, 'Saint Kitts and Nevis', 'saint-kitts-and-nevis', 'en'),
(862, 173, '圣基茨和尼维斯', '圣基茨和尼维斯', 'zh'),
(863, 173, 'San Cristóbal y Nieves', 'san-cristobal-y-nieves', 'es'),
(864, 173, 'Saint-Christophe-et-Niévès', 'saint-christophe-et-nieves', 'fr'),
(865, 173, 'سانت كيتس ونيفيس', 'سانت-كيتس-ونيفيس', 'ar'),
(866, 174, 'Comoros', 'comoros', 'en'),
(867, 174, '科摩罗', '科摩罗', 'zh'),
(868, 174, 'Comoras', 'comoras', 'es'),
(869, 174, 'Comores', 'comores', 'fr'),
(870, 174, 'جزر القمر', 'جزر-القمر', 'ar'),
(871, 175, 'Sao Tome and Principe', 'sao-tome-and-principe', 'en'),
(872, 175, '圣多美和普林西比', '圣多美和普林西比', 'zh'),
(873, 175, 'Santo Tomé y Príncipe', 'santo-tome-y-principe', 'es'),
(874, 175, 'Sao Tomé et Principe', 'sao-tome-et-principe', 'fr'),
(875, 175, 'ساو تومي وبرنسيبي', 'ساو-تومي-وبرنسيبي', 'ar'),
(876, 176, 'Slovakia', 'slovakia', 'en'),
(877, 176, '斯洛伐克', '斯洛伐克', 'zh'),
(878, 176, 'Eslovaquia', 'eslovaquia', 'es'),
(879, 176, 'La slovaquie', 'la-slovaquie', 'fr'),
(880, 176, 'سلوفاكيا', 'سلوفاكيا', 'ar'),
(881, 177, 'South Korea', 'south-korea', 'en'),
(882, 177, '韩国', '韩国', 'zh'),
(883, 177, 'Corea del Sur', 'corea-del-sur', 'es'),
(884, 177, 'Corée du Sud', 'coree-du-sud', 'fr'),
(885, 177, 'كوريا الجنوبية', 'كوريا-الجنوبية', 'ar'),
(886, 178, 'Slovenia', 'slovenia', 'en'),
(887, 178, '斯洛文尼亚', '斯洛文尼亚', 'zh'),
(888, 178, 'Eslovenia', 'eslovenia', 'es'),
(889, 178, 'La slovénie', 'la-slovenie', 'fr'),
(890, 178, 'سلوفينيا', 'سلوفينيا', 'ar'),
(891, 179, 'North Korea', 'north-korea', 'en'),
(892, 179, '北朝鲜', '北朝鲜', 'zh'),
(893, 179, 'Corea del Norte', 'corea-del-norte', 'es'),
(894, 179, 'Corée du Nord', 'coree-du-nord', 'fr'),
(895, 179, 'كوريا الشمالية', 'كوريا-الشمالية', 'ar'),
(896, 180, 'Kuwait', 'kuwait', 'en'),
(897, 180, '科威特', '科威特', 'zh'),
(898, 180, 'Kuwait', 'kuwait-1', 'es'),
(899, 180, 'Koweit', 'koweit', 'fr'),
(900, 180, 'الكويت', 'الكويت', 'ar'),
(901, 181, 'Senegal', 'senegal', 'en'),
(902, 181, '塞内加尔', '塞内加尔', 'zh'),
(903, 181, 'Senegal', 'senegal-1', 'es'),
(904, 181, 'Sénégal', 'senegal-2', 'fr'),
(905, 181, 'السنغال', 'السنغال', 'ar'),
(906, 182, 'San Marino', 'san-marino', 'en'),
(907, 182, '圣马力诺', '圣马力诺', 'zh'),
(908, 182, 'San Marino', 'san-marino-1', 'es'),
(909, 182, 'Saint Marin', 'saint-marin', 'fr'),
(910, 182, 'سان مارينو', 'سان-مارينو', 'ar'),
(911, 183, 'Sierra Leone', 'sierra-leone', 'en'),
(912, 183, '塞拉利昂', '塞拉利昂', 'zh'),
(913, 183, 'Sierra Leona', 'sierra-leona', 'es'),
(914, 183, 'Sierra Leone', 'sierra-leone-1', 'fr'),
(915, 183, 'سيرا ليون', 'سيرا-ليون', 'ar'),
(916, 184, 'Seychelles', 'seychelles', 'en'),
(917, 184, '塞舌尔', '塞舌尔', 'zh'),
(918, 184, 'Seychelles', 'seychelles-1', 'es'),
(919, 184, 'les Seychelles', 'les-seychelles', 'fr'),
(920, 184, 'سيشيل', 'سيشيل', 'ar'),
(921, 185, 'Kazakhstan', 'kazakhstan', 'en'),
(922, 185, '哈萨克斯坦', '哈萨克斯坦', 'zh'),
(923, 185, 'Kazajstán', 'kazajstan', 'es'),
(924, 185, 'Le kazakhstan', 'le-kazakhstan', 'fr'),
(925, 185, 'كازاخستان', 'كازاخستان', 'ar'),
(926, 186, 'Cayman Islands', 'cayman-islands', 'en'),
(927, 186, '开曼群岛', '开曼群岛', 'zh'),
(928, 186, 'Islas Caimán', 'islas-caiman', 'es'),
(929, 186, 'Îles Caïmans', 'iles-caimans', 'fr'),
(930, 186, 'جزر كايمان', 'جزر-كايمان', 'ar'),
(931, 187, 'Singapore', 'singapore', 'en'),
(932, 187, '新加坡', '新加坡', 'zh'),
(933, 187, 'Singapur', 'singapur', 'es'),
(934, 187, 'Singapour', 'singapour', 'fr'),
(935, 187, 'سنغافورة', 'سنغافورة', 'ar'),
(936, 188, 'Sweden', 'sweden', 'en'),
(937, 188, '瑞典', '瑞典', 'zh'),
(938, 188, 'Suecia', 'suecia', 'es'),
(939, 188, 'Suède', 'suede', 'fr'),
(940, 188, 'السويد', 'السويد', 'ar'),
(941, 189, 'Sudan', 'sudan', 'en'),
(942, 189, '苏丹', '苏丹', 'zh'),
(943, 189, 'Sudán', 'sudan-1', 'es'),
(944, 189, 'Soudan', 'soudan', 'fr'),
(945, 189, 'سودان', 'سودان', 'ar'),
(946, 190, 'Dominican Republic', 'dominican-republic', 'en'),
(947, 190, '多明尼加共和国', '多明尼加共和国', 'zh'),
(948, 190, 'República Dominicana', 'republica-dominicana', 'es'),
(949, 190, 'République Dominicaine', 'republique-dominicaine', 'fr'),
(950, 190, 'جمهورية الدومنيكان', 'جمهورية-الدومنيكان', 'ar'),
(951, 191, 'Dominica', 'dominica', 'en'),
(952, 191, '多米尼加', '多米尼加', 'zh'),
(953, 191, 'Dominica', 'dominica-1', 'es'),
(954, 191, 'Dominique', 'dominique', 'fr'),
(955, 191, 'دومينيكا', 'دومينيكا', 'ar'),
(956, 192, 'Djibouti', 'djibouti', 'en'),
(957, 192, '吉布提', '吉布提', 'zh'),
(958, 192, 'Djibouti', 'djibouti-1', 'es'),
(959, 192, 'Djibouti', 'djibouti-2', 'fr'),
(960, 192, 'جيبوتي', 'جيبوتي', 'ar'),
(961, 193, 'Denmark', 'denmark', 'en'),
(962, 193, '丹麦', '丹麦', 'zh'),
(963, 193, 'Dinamarca', 'dinamarca', 'es'),
(964, 193, 'Danemark', 'danemark', 'fr'),
(965, 193, 'الدنمارك', 'الدنمارك', 'ar'),
(966, 194, 'British Virgin Islands', 'british-virgin-islands', 'en'),
(967, 194, '英属维尔京群岛', '英属维尔京群岛', 'zh'),
(968, 194, 'Islas Vírgenes Británicas', 'islas-virgenes-britanicas', 'es'),
(969, 194, 'Îles Vierges britanniques', 'iles-vierges-britanniques', 'fr'),
(970, 194, 'جزر فيرجن البريطانية', 'جزر-فيرجن-البريطانية', 'ar'),
(971, 195, 'Germany', 'germany', 'en'),
(972, 195, '德国', '德国', 'zh'),
(973, 195, 'Alemania', 'alemania', 'es'),
(974, 195, 'Allemagne', 'allemagne', 'fr'),
(975, 195, 'ألمانيا', 'ألمانيا', 'ar'),
(976, 196, 'Yemen', 'yemen', 'en'),
(977, 196, '也门', '也门', 'zh'),
(978, 196, 'Yemen', 'yemen-1', 'es'),
(979, 196, 'Yémen', 'yemen-2', 'fr'),
(980, 196, 'اليمن', 'اليمن', 'ar'),
(981, 197, 'Algeria', 'algeria', 'en'),
(982, 197, '阿尔及利亚', '阿尔及利亚', 'zh'),
(983, 197, 'Argelia', 'argelia', 'es'),
(984, 197, 'Algérie', 'algerie', 'fr'),
(985, 197, 'الجزائر', 'الجزائر', 'ar'),
(986, 198, 'United States', 'united-states', 'en'),
(987, 198, '美国', '美国', 'zh'),
(988, 198, 'Estados Unidos', 'estados-unidos', 'es'),
(989, 198, 'États Unis', 'etats-unis', 'fr'),
(990, 198, 'الولايات المتحدة الأمريكية', 'الولايات-المتحدة-الأمريكية', 'ar'),
(991, 199, 'Uruguay', 'uruguay', 'en'),
(992, 199, '乌拉圭', '乌拉圭', 'zh'),
(993, 199, 'Uruguay', 'uruguay-1', 'es'),
(994, 199, 'Uruguay', 'uruguay-2', 'fr'),
(995, 199, 'أوروغواي', 'أوروغواي', 'ar'),
(996, 200, 'Mayotte', 'mayotte', 'en'),
(997, 200, '马约特', '马约特', 'zh'),
(998, 200, 'Mayotte', 'mayotte-1', 'es'),
(999, 200, 'Mayotte', 'mayotte-2', 'fr'),
(1000, 200, 'مايوت', 'مايوت', 'ar'),
(1001, 201, 'United States Minor Outlying Islands', 'united-states-minor-outlying-islands', 'en'),
(1002, 201, '美国本土外小岛屿', '美国本土外小岛屿', 'zh'),
(1003, 201, 'Islas menores alejadas de los Estados Unidos', 'islas-menores-alejadas-de-los-estados-unidos', 'es'),
(1004, 201, 'Îles mineures éloignées des États-Unis', 'iles-mineures-eloignees-des-etats-unis', 'fr'),
(1005, 201, 'جزر الولايات المتحدة البعيدة الصغرى', 'جزر-الولايات-المتحدة-البعيدة-الصغرى', 'ar'),
(1006, 202, 'Lebanon', 'lebanon', 'en'),
(1007, 202, '黎巴嫩', '黎巴嫩', 'zh'),
(1008, 202, 'Líbano', 'libano', 'es'),
(1009, 202, 'Liban', 'liban', 'fr'),
(1010, 202, 'لبنان', 'لبنان', 'ar'),
(1011, 203, 'Saint Lucia', 'saint-lucia', 'en'),
(1012, 203, '圣卢西亚', '圣卢西亚', 'zh'),
(1013, 203, 'Santa Lucía', 'santa-lucia', 'es'),
(1014, 203, 'Sainte-Lucie', 'sainte-lucie', 'fr'),
(1015, 203, 'القديسة لوسيا', 'القديسة-لوسيا', 'ar'),
(1016, 204, 'Laos', 'laos', 'en'),
(1017, 204, '老挝', '老挝', 'zh'),
(1018, 204, 'Laos', 'laos-1', 'es'),
(1019, 204, 'Laos', 'laos-2', 'fr'),
(1020, 204, 'لاوس', 'لاوس', 'ar'),
(1021, 205, 'Tuvalu', 'tuvalu', 'en'),
(1022, 205, '图瓦卢', '图瓦卢', 'zh'),
(1023, 205, 'Tuvalu', 'tuvalu-1', 'es'),
(1024, 205, 'Tuvalu', 'tuvalu-2', 'fr'),
(1025, 205, 'توفالو', 'توفالو', 'ar'),
(1026, 206, 'Taiwan', 'taiwan', 'en'),
(1027, 206, '台湾', '台湾', 'zh'),
(1028, 206, 'Taiwán', 'taiwan-1', 'es'),
(1029, 206, 'Taïwan', 'taiwan-2', 'fr'),
(1030, 206, 'تايوان', 'تايوان', 'ar'),
(1031, 207, 'Trinidad and Tobago', 'trinidad-and-tobago', 'en'),
(1032, 207, '特立尼达和多巴哥', '特立尼达和多巴哥', 'zh'),
(1033, 207, 'Trinidad y Tobago', 'trinidad-y-tobago', 'es'),
(1034, 207, 'Trinité-et-Tobago', 'trinite-et-tobago', 'fr'),
(1035, 207, 'ترينداد وتوباغو', 'ترينداد-وتوباغو', 'ar'),
(1036, 208, 'Turkey', 'turkey', 'en'),
(1037, 208, '火鸡', '火鸡', 'zh'),
(1038, 208, 'Turquía', 'turquia', 'es'),
(1039, 208, 'la Turquie', 'la-turquie', 'fr'),
(1040, 208, 'تركيا', 'تركيا', 'ar'),
(1041, 209, 'Sri Lanka', 'sri-lanka', 'en'),
(1042, 209, '斯里兰卡', '斯里兰卡', 'zh'),
(1043, 209, 'Sri Lanka', 'sri-lanka-1', 'es'),
(1044, 209, 'Sri Lanka', 'sri-lanka-2', 'fr'),
(1045, 209, 'سيريلانكا', 'سيريلانكا', 'ar'),
(1046, 210, 'Liechtenstein', 'liechtenstein', 'en'),
(1047, 210, '列支敦士登', '列支敦士登', 'zh'),
(1048, 210, 'Liechtenstein', 'liechtenstein-1', 'es'),
(1049, 210, 'Le Liechtenstein', 'le-liechtenstein', 'fr'),
(1050, 210, 'ليختنشتاين', 'ليختنشتاين', 'ar'),
(1051, 211, 'Latvia', 'latvia', 'en'),
(1052, 211, '拉脱维亚', '拉脱维亚', 'zh'),
(1053, 211, 'Letonia', 'letonia', 'es'),
(1054, 211, 'Lettonie', 'lettonie', 'fr'),
(1055, 211, 'لاتفيا', 'لاتفيا', 'ar'),
(1056, 212, 'Tonga', 'tonga', 'en'),
(1057, 212, '汤加', '汤加', 'zh'),
(1058, 212, 'Tonga', 'tonga-1', 'es'),
(1059, 212, 'Tonga', 'tonga-2', 'fr'),
(1060, 212, 'تونغا', 'تونغا', 'ar'),
(1061, 213, 'Lithuania', 'lithuania', 'en'),
(1062, 213, '立陶宛', '立陶宛', 'zh'),
(1063, 213, 'Lituania', 'lituania', 'es'),
(1064, 213, 'Lituanie', 'lituanie', 'fr'),
(1065, 213, 'ليتوانيا', 'ليتوانيا', 'ar'),
(1066, 214, 'Luxembourg', 'luxembourg', 'en'),
(1067, 214, '卢森堡', '卢森堡', 'zh'),
(1068, 214, 'Luxemburgo', 'luxemburgo', 'es'),
(1069, 214, 'Luxembourg', 'luxembourg-1', 'fr'),
(1070, 214, 'لوكسمبورغ', 'لوكسمبورغ', 'ar'),
(1071, 215, 'Liberia', 'liberia', 'en'),
(1072, 215, '利比里亚', '利比里亚', 'zh'),
(1073, 215, 'Liberia', 'liberia-1', 'es'),
(1074, 215, 'Libéria', 'liberia-2', 'fr'),
(1075, 215, 'ليبيريا', 'ليبيريا', 'ar'),
(1076, 216, 'Lesotho', 'lesotho', 'en'),
(1077, 216, '莱索托', '莱索托', 'zh'),
(1078, 216, 'Lesoto', 'lesoto', 'es'),
(1079, 216, 'Lesotho', 'lesotho-1', 'fr'),
(1080, 216, 'ليسوتو', 'ليسوتو', 'ar'),
(1081, 217, 'Thailand', 'thailand', 'en'),
(1082, 217, '泰国', '泰国', 'zh'),
(1083, 217, 'Tailandia', 'tailandia', 'es'),
(1084, 217, 'Thaïlande', 'thailande', 'fr'),
(1085, 217, 'تايلاند', 'تايلاند', 'ar'),
(1086, 218, 'French Southern Territories', 'french-southern-territories', 'en'),
(1087, 218, '法属南部领土', '法属南部领土', 'zh'),
(1088, 218, 'Territorios Franceses del Sur', 'territorios-franceses-del-sur', 'es'),
(1089, 218, 'Terres australes françaises', 'terres-australes-francaises', 'fr'),
(1090, 218, 'المناطق الجنوبية لفرنسا', 'المناطق-الجنوبية-لفرنسا', 'ar'),
(1091, 219, 'Togo', 'togo', 'en'),
(1092, 219, '多哥', '多哥', 'zh'),
(1093, 219, 'Togo', 'togo-1', 'es'),
(1094, 219, 'Togo', 'togo-2', 'fr'),
(1095, 219, 'توغو', 'توغو', 'ar'),
(1096, 220, 'Chad', 'chad', 'en'),
(1097, 220, '乍得', '乍得', 'zh'),
(1098, 220, 'Chad', 'chad-1', 'es'),
(1099, 220, 'Le tchad', 'le-tchad', 'fr'),
(1100, 220, 'تشاد', 'تشاد', 'ar'),
(1101, 221, 'Turks and Caicos Islands', 'turks-and-caicos-islands', 'en'),
(1102, 221, '特克斯和凯科斯群岛', '特克斯和凯科斯群岛', 'zh'),
(1103, 221, 'Islas Turcas y Caicos', 'islas-turcas-y-caicos', 'es'),
(1104, 221, 'îles Turques-et-Caïques', 'iles-turques-et-caiques', 'fr'),
(1105, 221, 'جزر تركس وكايكوس', 'جزر-تركس-وكايكوس', 'ar'),
(1106, 222, 'Libya', 'libya', 'en'),
(1107, 222, '利比亚', '利比亚', 'zh'),
(1108, 222, 'Libia', 'libia', 'es'),
(1109, 222, 'Libye', 'libye', 'fr'),
(1110, 222, 'ليبيا', 'ليبيا', 'ar'),
(1111, 223, 'Vatican', 'vatican', 'en'),
(1112, 223, '教廷', '教廷', 'zh'),
(1113, 223, 'Vaticano', 'vaticano', 'es'),
(1114, 223, 'Vatican', 'vatican-1', 'fr'),
(1115, 223, 'الفاتيكان', 'الفاتيكان', 'ar'),
(1116, 224, 'Saint Vincent and the Grenadines', 'saint-vincent-and-the-grenadines', 'en'),
(1117, 224, '圣文森特和格林纳丁斯', '圣文森特和格林纳丁斯', 'zh'),
(1118, 224, 'San Vicente y las Granadinas', 'san-vicente-y-las-granadinas', 'es'),
(1119, 224, 'Saint-Vincent-et-les-Grenadines', 'saint-vincent-et-les-grenadines', 'fr'),
(1120, 224, 'سانت فنسنت وجزر غرينادين', 'سانت-فنسنت-وجزر-غرينادين', 'ar'),
(1121, 225, 'United Arab Emirates', 'united-arab-emirates', 'en'),
(1122, 225, '阿拉伯联合酋长国', '阿拉伯联合酋长国', 'zh'),
(1123, 225, 'Emiratos Árabes Unidos', 'emiratos-arabes-unidos', 'es'),
(1124, 225, 'Emirats Arabes Unis', 'emirats-arabes-unis', 'fr'),
(1125, 225, 'الإمارات العربية المتحدة', 'الإمارات-العربية-المتحدة', 'ar'),
(1126, 226, 'Andorra', 'andorra', 'en'),
(1127, 226, '安道尔', '安道尔', 'zh'),
(1128, 226, 'Andorra', 'andorra-1', 'es'),
(1129, 226, 'Andorre', 'andorre', 'fr'),
(1130, 226, 'أندورا', 'أندورا', 'ar'),
(1131, 227, 'Antigua and Barbuda', 'antigua-and-barbuda', 'en'),
(1132, 227, '安提瓜和巴布达', '安提瓜和巴布达', 'zh'),
(1133, 227, 'Antigua y Barbuda', 'antigua-y-barbuda', 'es'),
(1134, 227, 'Antigua-et-Barbuda', 'antigua-et-barbuda', 'fr'),
(1135, 227, 'أنتيغوا وبربودا', 'أنتيغوا-وبربودا', 'ar'),
(1136, 228, 'Afghanistan', 'afghanistan', 'en'),
(1137, 228, '阿富汗', '阿富汗', 'zh'),
(1138, 228, 'Afganistán', 'afganistan', 'es'),
(1139, 228, 'L\'Afghanistan', 'lafghanistan', 'fr'),
(1140, 228, 'أفغانستان', 'أفغانستان', 'ar'),
(1141, 229, 'Anguilla', 'anguilla', 'en'),
(1142, 229, '安圭拉', '安圭拉', 'zh'),
(1143, 229, 'Anguila', 'anguila', 'es'),
(1144, 229, 'Anguilla', 'anguilla-1', 'fr'),
(1145, 229, 'أنغيلا', 'أنغيلا', 'ar'),
(1146, 230, 'U.S. Virgin Islands', 'u-s-virgin-islands', 'en'),
(1147, 230, '美属维尔京群岛', '美属维尔京群岛', 'zh'),
(1148, 230, 'Islas Vírgenes de EE.UU', 'islas-virgenes-de-ee-uu', 'es'),
(1149, 230, 'Îles Vierges américaines', 'iles-vierges-americaines', 'fr'),
(1150, 230, 'جزر فيرجن الأمريكية', 'جزر-فيرجن-الأمريكية', 'ar'),
(1151, 231, 'Iceland', 'iceland', 'en'),
(1152, 231, '冰岛', '冰岛', 'zh'),
(1153, 231, 'Islandia', 'islandia', 'es'),
(1154, 231, 'Islande', 'islande', 'fr'),
(1155, 231, 'أيسلندا', 'أيسلندا', 'ar'),
(1156, 232, 'Iran', 'iran', 'en'),
(1157, 232, '伊朗', '伊朗', 'zh'),
(1158, 232, 'Iran', 'iran-1', 'es'),
(1159, 232, 'Iran', 'iran-2', 'fr'),
(1160, 232, 'إيران', 'إيران', 'ar'),
(1161, 233, 'Armenia', 'armenia', 'en'),
(1162, 233, '亚美尼亚', '亚美尼亚', 'zh'),
(1163, 233, 'Armenia', 'armenia-1', 'es'),
(1164, 233, 'Arménie', 'armenie', 'fr'),
(1165, 233, 'أرمينيا', 'أرمينيا', 'ar'),
(1166, 234, 'Albania', 'albania', 'en'),
(1167, 234, '阿尔巴尼亚', '阿尔巴尼亚', 'zh'),
(1168, 234, 'Albania', 'albania-1', 'es'),
(1169, 234, 'Albanie', 'albanie', 'fr'),
(1170, 234, 'ألبانيا', 'ألبانيا', 'ar'),
(1171, 235, 'Angola', 'angola', 'en'),
(1172, 235, '安哥拉', '安哥拉', 'zh'),
(1173, 235, 'Angola', 'angola-1', 'es'),
(1174, 235, 'Angola', 'angola-2', 'fr'),
(1175, 235, 'أنغولا', 'أنغولا', 'ar'),
(1176, 236, 'Antarctica', 'antarctica', 'en'),
(1177, 236, '南极洲', '南极洲', 'zh'),
(1178, 236, 'Antártida', 'antartida', 'es'),
(1179, 236, 'Antarctique', 'antarctique', 'fr'),
(1180, 236, 'القارة القطبية الجنوبية', 'القارة-القطبية-الجنوبية', 'ar'),
(1181, 237, 'American Samoa', 'american-samoa', 'en'),
(1182, 237, '美属萨摩亚', '美属萨摩亚', 'zh'),
(1183, 237, 'Samoa Americana', 'samoa-americana', 'es'),
(1184, 237, 'Samoa américaines', 'samoa-americaines', 'fr'),
(1185, 237, 'ساموا الأمريكية', 'ساموا-الأمريكية', 'ar'),
(1186, 238, 'Argentina', 'argentina', 'en'),
(1187, 238, '阿根廷', '阿根廷', 'zh'),
(1188, 238, 'Argentina', 'argentina-1', 'es'),
(1189, 238, 'Argentine', 'argentine', 'fr'),
(1190, 238, 'الأرجنتين', 'الأرجنتين', 'ar'),
(1191, 239, 'Australia', 'australia', 'en'),
(1192, 239, '澳大利亚', '澳大利亚', 'zh'),
(1193, 239, 'Australia', 'australia-1', 'es'),
(1194, 239, 'Australie', 'australie', 'fr'),
(1195, 239, 'أستراليا', 'أستراليا', 'ar'),
(1196, 240, 'Austria', 'austria', 'en'),
(1197, 240, '奥地利', '奥地利', 'zh'),
(1198, 240, 'Austria', 'austria-1', 'es'),
(1199, 240, 'L\'Autriche', 'lautriche', 'fr'),
(1200, 240, 'النمسا', 'النمسا', 'ar'),
(1201, 241, 'Aruba', 'aruba', 'en'),
(1202, 241, '阿鲁巴', '阿鲁巴', 'zh'),
(1203, 241, 'Aruba', 'aruba-1', 'es'),
(1204, 241, 'Aruba', 'aruba-2', 'fr'),
(1205, 241, 'أروبا', 'أروبا', 'ar'),
(1206, 242, 'India', 'india', 'en'),
(1207, 242, '印度', '印度', 'zh'),
(1208, 242, 'India', 'india-1', 'es');
INSERT INTO `eventic_country_translation` (`id`, `translatable_id`, `name`, `slug`, `locale`) VALUES
(1209, 242, 'Inde', 'inde', 'fr'),
(1210, 242, 'الهند', 'الهند', 'ar'),
(1211, 243, 'Aland Islands', 'aland-islands', 'en'),
(1212, 243, '奥兰群岛', '奥兰群岛', 'zh'),
(1213, 243, 'Islas Aland', 'islas-aland', 'es'),
(1214, 243, 'Iles Aland', 'iles-aland', 'fr'),
(1215, 243, 'جزر آلاند', 'جزر-آلاند', 'ar'),
(1216, 244, 'Azerbaijan', 'azerbaijan', 'en'),
(1217, 244, '阿塞拜疆', '阿塞拜疆', 'zh'),
(1218, 244, 'Azerbaiyán', 'azerbaiyan', 'es'),
(1219, 244, 'Azerbaïdjan', 'azerbaidjan', 'fr'),
(1220, 244, 'أذربيجان', 'أذربيجان', 'ar'),
(1221, 245, 'Ireland', 'ireland', 'en'),
(1222, 245, '爱尔兰', '爱尔兰', 'zh'),
(1223, 245, 'Irlanda', 'irlanda', 'es'),
(1224, 245, 'Irlande', 'irlande', 'fr'),
(1225, 245, 'أيرلندا', 'أيرلندا', 'ar'),
(1226, 246, 'Indonesia', 'indonesia', 'en'),
(1227, 246, '印度尼西亚', '印度尼西亚', 'zh'),
(1228, 246, 'Indonesia', 'indonesia-1', 'es'),
(1229, 246, 'Indonésie', 'indonesie', 'fr'),
(1230, 246, 'أندونيسيا', 'أندونيسيا', 'ar'),
(1231, 247, 'Ukraine', 'ukraine', 'en'),
(1232, 247, '乌克兰', '乌克兰', 'zh'),
(1233, 247, 'Ucrania', 'ucrania', 'es'),
(1234, 247, 'Ukraine', 'ukraine-1', 'fr'),
(1235, 247, 'أوكرانيا', 'أوكرانيا', 'ar'),
(1236, 248, 'Qatar', 'qatar', 'en'),
(1237, 248, '卡塔尔', '卡塔尔', 'zh'),
(1238, 248, 'Katar', 'katar', 'es'),
(1239, 248, 'Qatar', 'qatar-1', 'fr'),
(1240, 248, 'دولة قطر', 'دولة-قطر', 'ar'),
(1241, 249, 'Mozambique', 'mozambique', 'en'),
(1242, 249, '莫桑比克', '莫桑比克', 'zh'),
(1243, 249, 'Mozambique', 'mozambique-1', 'es'),
(1244, 249, 'Mozambique', 'mozambique-2', 'fr'),
(1245, 249, 'موزمبيق', 'موزمبيق', 'ar');

-- --------------------------------------------------------

--
-- Table structure for table `eventic_currency`
--

DROP TABLE IF EXISTS `eventic_currency`;
CREATE TABLE IF NOT EXISTS `eventic_currency` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ccy` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `symbol` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=152 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `eventic_currency`
--

INSERT INTO `eventic_currency` (`id`, `ccy`, `symbol`) VALUES
(1, 'AED', 'د.إ'),
(2, 'AFN', 'Af'),
(3, 'ALL', 'L'),
(4, 'AMD', 'Դ'),
(5, 'AOA', 'Kz'),
(6, 'ARS', '$'),
(7, 'AUD', '$'),
(8, 'AWG', 'ƒ'),
(9, 'AZN', 'ман'),
(10, 'BAM', 'КМ'),
(11, 'BBD', '$'),
(12, 'BDT', '৳'),
(13, 'BGN', 'лв'),
(14, 'BHD', 'ب.د'),
(15, 'BIF', '₣'),
(16, 'BMD', '$'),
(17, 'BND', '$'),
(18, 'BOB', 'Bs.'),
(19, 'BRL', 'R$'),
(20, 'BSD', '$'),
(21, 'BTN', ''),
(22, 'BWP', 'P'),
(23, 'BYN', 'Br'),
(24, 'BZD', '$'),
(25, 'CAD', '$'),
(26, 'CDF', '₣'),
(27, 'CHF', '₣'),
(28, 'CLP', '$'),
(29, 'CNY', '¥'),
(30, 'COP', '$'),
(31, 'CRC', '₡'),
(32, 'CUP', '$'),
(33, 'CVE', '$'),
(34, 'CZK', 'Kč'),
(35, 'DJF', '₣'),
(36, 'DKK', 'kr'),
(37, 'DOP', '$'),
(38, 'DZD', 'د.ج'),
(39, 'EGP', '£'),
(40, 'ERN', 'Nfk'),
(41, 'ETB', ''),
(42, 'EUR', '€'),
(43, 'FJD', '$'),
(44, 'FKP', '£'),
(45, 'GBP', '£'),
(46, 'GEL', 'ლ'),
(47, 'GHS', '₵'),
(48, 'GIP', '£'),
(49, 'GMD', 'D'),
(50, 'GNF', '₣'),
(51, 'GTQ', 'Q'),
(52, 'GYD', '$'),
(53, 'HKD', '$'),
(54, 'HNL', 'L'),
(55, 'HRK', 'Kn'),
(56, 'HTG', 'G'),
(57, 'HUF', 'Ft'),
(58, 'IDR', 'Rp'),
(59, 'ILS', '₪'),
(60, 'INR', '₹'),
(61, 'IQD', 'ع.د'),
(62, 'IRR', '﷼'),
(63, 'ISK', 'Kr'),
(64, 'JMD', '$'),
(65, 'JOD', 'د.ا'),
(66, 'JPY', '¥'),
(67, 'KES', 'Sh'),
(68, 'KGS', ''),
(69, 'KHR', '៛'),
(70, 'KPW', '₩'),
(71, 'KRW', '₩'),
(72, 'KWD', 'د.ك'),
(73, 'KYD', '$'),
(74, 'KZT', '〒'),
(75, 'LAK', '₭'),
(76, 'LBP', 'ل.ل'),
(77, 'LKR', 'Rs'),
(78, 'LRD', '$'),
(79, 'LSL', 'L'),
(80, 'LYD', 'ل.د'),
(81, 'MAD', 'د.م.'),
(82, 'MDL', 'L'),
(83, 'MGA', ''),
(84, 'MKD', 'ден'),
(85, 'MMK', 'K'),
(86, 'MNT', '₮'),
(87, 'MOP', 'P'),
(88, 'MRU', 'UM'),
(89, 'MUR', '₨'),
(90, 'MVR', 'ރ.'),
(91, 'MWK', 'MK'),
(92, 'MXN', '$'),
(93, 'MYR', 'RM'),
(94, 'MZN', 'MTn'),
(95, 'NAD', '$'),
(96, 'NGN', '₦'),
(97, 'NIO', 'C$'),
(98, 'NOK', 'kr'),
(99, 'NPR', '₨'),
(100, 'NZD', '$'),
(101, 'OMR', 'ر.ع.'),
(102, 'PAB', 'B/.'),
(103, 'PEN', 'S/.'),
(104, 'PGK', 'K'),
(105, 'PHP', '₱'),
(106, 'PKR', '₨'),
(107, 'PLN', 'zł'),
(108, 'PYG', '₲'),
(109, 'QAR', 'ر.ق	'),
(110, 'RON', 'L'),
(111, 'RSD', 'din'),
(112, 'RUB', 'р.'),
(113, 'RWF', '₣'),
(114, 'SAR', 'ر.س'),
(115, 'SBD', '$'),
(116, 'SCR', '₨'),
(117, 'SDG', '£'),
(118, 'SEK', 'kr'),
(119, 'SGD', '$'),
(120, 'SHP', '£'),
(121, 'SLL', 'Le'),
(122, 'SOS', 'Sh'),
(123, 'SRD', '$'),
(124, 'STN', 'Db'),
(125, 'SYP', 'ل.س'),
(126, 'SZL', 'L'),
(127, 'THB', '฿'),
(128, 'TJS', 'ЅМ'),
(129, 'TMT', 'm'),
(130, 'TND', 'د.ت'),
(131, 'TOP', 'T$'),
(132, 'TRY', '₤'),
(133, 'TTD', '$'),
(134, 'TWD', '$'),
(135, 'TZS', 'Sh'),
(136, 'UAH', '₴'),
(137, 'UGX', 'Sh'),
(138, 'USD', '$'),
(139, 'UYU', '$'),
(140, 'UZS', ''),
(141, 'VEF', 'Bs F'),
(142, 'VND', '₫'),
(143, 'VUV', 'Vt'),
(144, 'WST', 'T'),
(145, 'XAF', '₣'),
(146, 'XCD', '$'),
(147, 'XPF', '₣'),
(148, 'YER', '﷼'),
(149, 'ZAR', 'R'),
(150, 'ZMW', 'ZK'),
(151, 'ZWL', '$');

-- --------------------------------------------------------

--
-- Table structure for table `eventic_event`
--

DROP TABLE IF EXISTS `eventic_event`;
CREATE TABLE IF NOT EXISTS `eventic_event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `organizer_id` int(11) DEFAULT NULL,
  `isonhomepageslider_id` int(11) DEFAULT NULL,
  `reference` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `views` int(11) NOT NULL,
  `youtubeurl` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `externallink` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phonenumber` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `twitter` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `instagram` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `facebook` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `googleplus` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `linkedin` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `artists` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tags` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `year` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_size` int(11) DEFAULT NULL,
  `image_mime_type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_original_name` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_dimensions` longtext COLLATE utf8_unicode_ci COMMENT '(DC2Type:simple_array)',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `published` tinyint(1) NOT NULL,
  `enablereviews` tinyint(1) NOT NULL,
  `showattendees` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E1933DCB12469DE2` (`category_id`),
  KEY `IDX_E1933DCBF92F3E70` (`country_id`),
  KEY `IDX_E1933DCB876C4DDA` (`organizer_id`),
  KEY `IDX_E1933DCB376C51EF` (`isonhomepageslider_id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `eventic_eventdate_pointofsale`
--

DROP TABLE IF EXISTS `eventic_eventdate_pointofsale`;
CREATE TABLE IF NOT EXISTS `eventic_eventdate_pointofsale` (
  `eventdate_id` int(11) NOT NULL,
  `pointofsale_id` int(11) NOT NULL,
  PRIMARY KEY (`eventdate_id`,`pointofsale_id`),
  KEY `IDX_7E37EBFC733DA6BA` (`eventdate_id`),
  KEY `IDX_7E37EBFC18E07BF3` (`pointofsale_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `eventic_eventdate_scanner`
--

DROP TABLE IF EXISTS `eventic_eventdate_scanner`;
CREATE TABLE IF NOT EXISTS `eventic_eventdate_scanner` (
  `eventdate_id` int(11) NOT NULL,
  `scanner_id` int(11) NOT NULL,
  PRIMARY KEY (`eventdate_id`,`scanner_id`),
  KEY `IDX_A9110493733DA6BA` (`eventdate_id`),
  KEY `IDX_A911049367C89E33` (`scanner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `eventic_event_audience`
--

DROP TABLE IF EXISTS `eventic_event_audience`;
CREATE TABLE IF NOT EXISTS `eventic_event_audience` (
  `Event_id` int(11) NOT NULL,
  `Audience_Id` int(11) NOT NULL,
  PRIMARY KEY (`Event_id`,`Audience_Id`),
  KEY `IDX_F46FAEC788818ADD` (`Event_id`),
  KEY `IDX_F46FAEC797946D63` (`Audience_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `eventic_event_date`
--

DROP TABLE IF EXISTS `eventic_event_date`;
CREATE TABLE IF NOT EXISTS `eventic_event_date` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) DEFAULT NULL,
  `venue_id` int(11) DEFAULT NULL,
  `online` tinyint(1) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `reference` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `startdate` datetime DEFAULT NULL,
  `enddate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D30F7AD371F7E88B` (`event_id`),
  KEY `IDX_D30F7AD340A73EBA` (`venue_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `eventic_event_date_ticket`
--

DROP TABLE IF EXISTS `eventic_event_date_ticket`;
CREATE TABLE IF NOT EXISTS `eventic_event_date_ticket` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eventdate_id` int(11) DEFAULT NULL,
  `active` tinyint(1) NOT NULL,
  `reference` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `free` tinyint(1) NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `promotionalprice` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `ticketsperattendee` int(11) DEFAULT NULL,
  `salesstartdate` datetime DEFAULT NULL,
  `salesenddate` datetime DEFAULT NULL,
  `position` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E8B0FCF9733DA6BA` (`eventdate_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `eventic_event_image`
--

DROP TABLE IF EXISTS `eventic_event_image`;
CREATE TABLE IF NOT EXISTS `eventic_event_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) DEFAULT NULL,
  `image_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_size` int(11) DEFAULT NULL,
  `image_mime_type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_original_name` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_dimensions` longtext COLLATE utf8_unicode_ci COMMENT '(DC2Type:simple_array)',
  `position` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6A4E8E5E71F7E88B` (`event_id`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `eventic_event_language`
--

DROP TABLE IF EXISTS `eventic_event_language`;
CREATE TABLE IF NOT EXISTS `eventic_event_language` (
  `Event_id` int(11) NOT NULL,
  `Language_Id` int(11) NOT NULL,
  PRIMARY KEY (`Event_id`,`Language_Id`),
  KEY `IDX_DD794B6A88818ADD` (`Event_id`),
  KEY `IDX_DD794B6A91E91181` (`Language_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `eventic_event_subtitle`
--

DROP TABLE IF EXISTS `eventic_event_subtitle`;
CREATE TABLE IF NOT EXISTS `eventic_event_subtitle` (
  `Event_id` int(11) NOT NULL,
  `Language_Id` int(11) NOT NULL,
  PRIMARY KEY (`Event_id`,`Language_Id`),
  KEY `IDX_5827AD6E88818ADD` (`Event_id`),
  KEY `IDX_5827AD6E91E91181` (`Language_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `eventic_event_translation`
--

DROP TABLE IF EXISTS `eventic_event_translation`;
CREATE TABLE IF NOT EXISTS `eventic_event_translation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `translatable_id` int(11) DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  `slug` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_2FCD2BD6989D9B62` (`slug`),
  UNIQUE KEY `eventic_event_translation_unique_translation` (`translatable_id`,`locale`),
  KEY `IDX_2FCD2BD62C2AC5D3` (`translatable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `eventic_favorites`
--

DROP TABLE IF EXISTS `eventic_favorites`;
CREATE TABLE IF NOT EXISTS `eventic_favorites` (
  `Event_id` int(11) NOT NULL,
  `User_Id` int(11) NOT NULL,
  PRIMARY KEY (`Event_id`,`User_Id`),
  KEY `IDX_B853A82F88818ADD` (`Event_id`),
  KEY `IDX_B853A82FFD57CEAB` (`User_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `eventic_following`
--

DROP TABLE IF EXISTS `eventic_following`;
CREATE TABLE IF NOT EXISTS `eventic_following` (
  `Organizer_id` int(11) NOT NULL,
  `User_Id` int(11) NOT NULL,
  PRIMARY KEY (`Organizer_id`,`User_Id`),
  KEY `IDX_2D8545399F5D9622` (`Organizer_id`),
  KEY `IDX_2D854539FD57CEAB` (`User_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `eventic_help_center_article`
--

DROP TABLE IF EXISTS `eventic_help_center_article`;
CREATE TABLE IF NOT EXISTS `eventic_help_center_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `views` int(11) DEFAULT NULL,
  `hidden` tinyint(1) NOT NULL,
  `featured` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_75F977E312469DE2` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `eventic_help_center_article_translation`
--

DROP TABLE IF EXISTS `eventic_help_center_article_translation`;
CREATE TABLE IF NOT EXISTS `eventic_help_center_article_translation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `translatable_id` int(11) DEFAULT NULL,
  `title` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `tags` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_54AB4030989D9B62` (`slug`),
  UNIQUE KEY `eventic_help_center_article_translation_unique_translation` (`translatable_id`,`locale`),
  KEY `IDX_54AB40302C2AC5D3` (`translatable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=141 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `eventic_help_center_category`
--

DROP TABLE IF EXISTS `eventic_help_center_category`;
CREATE TABLE IF NOT EXISTS `eventic_help_center_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `icon` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hidden` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9BE9AD17727ACA70` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `eventic_help_center_category`
--

INSERT INTO `eventic_help_center_category` (`id`, `parent_id`, `icon`, `hidden`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, NULL, 'fas fa-user-alt', 0, '2019-10-15 16:17:04', '2019-10-15 16:37:37', NULL),
(2, NULL, 'fas fa-calendar-plus', 0, '2019-10-15 16:46:12', '2019-10-15 16:46:12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `eventic_help_center_category_translation`
--

DROP TABLE IF EXISTS `eventic_help_center_category_translation`;
CREATE TABLE IF NOT EXISTS `eventic_help_center_category_translation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `translatable_id` int(11) DEFAULT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_2B8AFEF5989D9B62` (`slug`),
  UNIQUE KEY `eventic_help_center_category_translation_unique_translation` (`translatable_id`,`locale`),
  KEY `IDX_2B8AFEF52C2AC5D3` (`translatable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `eventic_help_center_category_translation`
--

INSERT INTO `eventic_help_center_category_translation` (`id`, `translatable_id`, `name`, `slug`, `locale`) VALUES
(1, 1, 'Attendee', 'attendee', 'en'),
(2, 1, '参加者', '参加者', 'zh'),
(3, 1, 'Asistente', 'asistente', 'es'),
(4, 1, 'Participant', 'participant', 'fr'),
(5, 1, 'مشترك', 'مشترك', 'ar'),
(6, 2, 'Organizer', 'organizer', 'en'),
(7, 2, '组织者', '组织者', 'zh'),
(8, 2, 'Organizador', 'organizador', 'es'),
(9, 2, 'Organisateur', 'organisateur', 'fr'),
(10, 2, 'منظم أحداث', 'منظم-أحداث', 'ar');

-- --------------------------------------------------------

--
-- Table structure for table `eventic_homepage_hero_setting`
--

DROP TABLE IF EXISTS `eventic_homepage_hero_setting`;
CREATE TABLE IF NOT EXISTS `eventic_homepage_hero_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `custom_background_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `custom_background_size` int(11) DEFAULT NULL,
  `custom_background_mime_type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `custom_background_original_name` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `custom_background_dimensions` longtext COLLATE utf8_unicode_ci COMMENT '(DC2Type:simple_array)',
  `show_search_box` tinyint(1) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Dumping data for table `eventic_homepage_hero_setting`
--

INSERT INTO `eventic_homepage_hero_setting` (`id`, `content`, `custom_background_name`, `custom_background_size`, `custom_background_mime_type`, `custom_background_original_name`, `custom_background_dimensions`, `show_search_box`, `updated_at`) VALUES
(1, 'custom', '5d99d60e41207545475471.jpg', 346806, 'image/jpeg', 'ezra-jeffrey-comeau-pPquxoraq_M-unsplash.jpg', '1500,1000', 1, '2020-10-10 13:11:55');

--
-- Table structure for table `eventic_homepage_hero_setting_translation`
--

DROP TABLE IF EXISTS `eventic_homepage_hero_setting_translation`;
CREATE TABLE IF NOT EXISTS `eventic_homepage_hero_setting_translation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `translatable_id` int(11) DEFAULT NULL,
  `title` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `paragraph` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `eventic_homepage_hero_setting_translation_unique_translation` (`translatable_id`,`locale`),
  KEY `IDX_5DD4B1372C2AC5D3` (`translatable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Dumping data for table `eventic_homepage_hero_setting_translation`
--

INSERT INTO `eventic_homepage_hero_setting_translation` (`id`, `translatable_id`, `title`, `paragraph`, `locale`) VALUES
(1, 1, 'Eventic', 'Online Event Management And Ticket Sales', 'en'),
(2, 1, 'Eventic', '在线活动管理和门票销售', 'zh'),
(3, 1, 'Eventic', 'Gestión de eventos en línea y venta de entradas', 'es'),
(4, 1, 'Eventic', 'Gestion d\'événements en ligne et vente de billets', 'fr'),
(5, 1, 'Eventic', 'إدارة الأحداث عبر الإنترنت ومبيعات التذاكر', 'ar');

--
-- Table structure for table `eventic_language`
--

DROP TABLE IF EXISTS `eventic_language`;
CREATE TABLE IF NOT EXISTS `eventic_language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `hidden` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=136 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `eventic_language`
--

INSERT INTO `eventic_language` (`id`, `code`, `hidden`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'en', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(2, 'aa', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(3, 'ab', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(4, 'af', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(5, 'am', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(6, 'ar', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(7, 'as', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(8, 'ay', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(9, 'az', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(10, 'ba', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(11, 'be', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(12, 'bg', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(13, 'bh', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(14, 'bi', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(15, 'bn', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(16, 'bo', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(17, 'br', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(18, 'ca', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(19, 'co', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(20, 'cs', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(21, 'cy', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(22, 'da', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(23, 'de', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(24, 'dz', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(25, 'el', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(26, 'eo', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(27, 'es', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(28, 'et', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(29, 'eu', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(30, 'fa', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(31, 'fi', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(32, 'fj', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(33, 'fo', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(34, 'fr', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(35, 'fy', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(36, 'ga', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(37, 'gd', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(38, 'gl', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(39, 'gn', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(40, 'gu', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(41, 'ha', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(42, 'hi', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(43, 'hr', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(44, 'hu', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(45, 'hy', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(46, 'ia', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(47, 'ie', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(48, 'ik', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(49, 'in', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(50, 'is', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(51, 'it', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(52, 'iw', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(53, 'ja', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(54, 'ji', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(55, 'jw', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(56, 'ka', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(57, 'kk', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(58, 'kl', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(59, 'km', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(60, 'kn', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(61, 'ko', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(62, 'ks', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(63, 'ku', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(64, 'ky', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(65, 'la', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(66, 'ln', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(67, 'lo', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(68, 'lt', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(69, 'lv', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(70, 'mg', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(71, 'mi', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(72, 'mk', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(73, 'ml', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(74, 'mn', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(75, 'mo', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(76, 'mr', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(77, 'ms', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(78, 'mt', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(79, 'my', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(80, 'na', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(81, 'ne', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(82, 'nl', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(83, 'no', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(84, 'oc', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(85, 'om', 0, '2019-08-26 17:21:00', '2020-04-21 13:45:11', NULL),
(86, 'pa', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(87, 'pl', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(88, 'ps', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(89, 'pt', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(90, 'qu', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(91, 'rm', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(92, 'rn', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(93, 'ro', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(94, 'ru', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(95, 'rw', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(96, 'sa', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(97, 'sd', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(98, 'sg', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(99, 'sh', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(100, 'si', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(101, 'sk', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(102, 'sl', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(103, 'sm', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(104, 'sn', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(105, 'so', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(106, 'sq', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(107, 'sr', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(108, 'ss', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(109, 'st', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(110, 'su', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(111, 'sv', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(112, 'sw', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(113, 'ta', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(114, 'te', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(115, 'tg', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(116, 'th', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(117, 'ti', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(118, 'tk', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(119, 'tl', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(120, 'tn', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(121, 'to', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(122, 'tr', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(123, 'ts', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(124, 'tt', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(125, 'tw', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(126, 'uk', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(127, 'ur', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(128, 'uz', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(129, 'vi', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(130, 'vo', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(131, 'wo', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(132, 'xh', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(133, 'yo', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(134, 'zh', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL),
(135, 'zu', 0, '2019-08-26 17:21:00', '2019-08-26 17:21:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `eventic_language_translation`
--

DROP TABLE IF EXISTS `eventic_language_translation`;
CREATE TABLE IF NOT EXISTS `eventic_language_translation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `translatable_id` int(11) DEFAULT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_E8216272989D9B62` (`slug`),
  UNIQUE KEY `eventic_language_translation_unique_translation` (`translatable_id`,`locale`),
  KEY `IDX_E82162722C2AC5D3` (`translatable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=676 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `eventic_language_translation`
--

INSERT INTO `eventic_language_translation` (`id`, `translatable_id`, `name`, `slug`, `locale`) VALUES
(1, 1, 'English', 'english', 'en'),
(2, 1, '英语', '英语', 'zh'),
(3, 1, 'Inglés', 'ingles', 'es'),
(4, 1, 'Anglais', 'anglais', 'fr'),
(5, 1, 'الإنجليزية', 'الإنجليزية', 'ar'),
(6, 2, 'Afar', 'afar', 'en'),
(7, 2, '远', '远', 'zh'),
(8, 2, 'Lejos', 'lejos', 'es'),
(9, 2, 'Afar', 'afar-1', 'fr'),
(10, 2, 'عفار', 'عفار', 'ar'),
(11, 3, 'Abkhazian', 'abkhazian', 'en'),
(12, 3, '阿布哈兹', '阿布哈兹', 'zh'),
(13, 3, 'Abjasio', 'abjasio', 'es'),
(14, 3, 'Abkhaze', 'abkhaze', 'fr'),
(15, 3, 'الأبخازية', 'الأبخازية', 'ar'),
(16, 4, 'Afrikaans', 'afrikaans', 'en'),
(17, 4, '南非荷兰语', '南非荷兰语', 'zh'),
(18, 4, 'Afrikaans', 'afrikaans-1', 'es'),
(19, 4, 'Afrikaans', 'afrikaans-2', 'fr'),
(20, 4, 'الأفريكانية', 'الأفريكانية', 'ar'),
(21, 5, 'Amharic', 'amharic', 'en'),
(22, 5, '阿姆哈拉语', '阿姆哈拉语', 'zh'),
(23, 5, 'Amárico', 'amarico', 'es'),
(24, 5, 'Amharique', 'amharique', 'fr'),
(25, 5, 'الأمهرية', 'الأمهرية', 'ar'),
(26, 6, 'Arabic', 'arabic', 'en'),
(27, 6, '阿拉伯', '阿拉伯', 'zh'),
(28, 6, 'Arábica', 'arabica', 'es'),
(29, 6, 'Arabe', 'arabe', 'fr'),
(30, 6, 'العربية', 'العربية', 'ar'),
(31, 7, 'Assamese', 'assamese', 'en'),
(32, 7, '阿萨姆', '阿萨姆', 'zh'),
(33, 7, 'Asamés', 'asames', 'es'),
(34, 7, 'Assamais', 'assamais', 'fr'),
(35, 7, 'الأسامية', 'الأسامية', 'ar'),
(36, 8, 'Aymara', 'aymara', 'en'),
(37, 8, '艾马拉', '艾马拉', 'zh'),
(38, 8, 'Aimara', 'aimara', 'es'),
(39, 8, 'Aymara', 'aymara-1', 'fr'),
(40, 8, 'الأيمارا', 'الأيمارا', 'ar'),
(41, 9, 'Azerbaijani', 'azerbaijani', 'en'),
(42, 9, '阿塞拜疆', '阿塞拜疆', 'zh'),
(43, 9, 'Azerbaiyana', 'azerbaiyana', 'es'),
(44, 9, 'Azerbaïdjanais', 'azerbaidjanais', 'fr'),
(45, 9, 'الأذربيجانية', 'الأذربيجانية', 'ar'),
(46, 10, 'Bashkir', 'bashkir', 'en'),
(47, 10, '巴什基尔', '巴什基尔', 'zh'),
(48, 10, 'Bashkir', 'bashkir-1', 'es'),
(49, 10, 'Bachkir', 'bachkir', 'fr'),
(50, 10, 'الباشكيرية', 'الباشكيرية', 'ar'),
(51, 11, 'Byelorussian', 'byelorussian', 'en'),
(52, 11, '白俄罗斯', '白俄罗斯', 'zh'),
(53, 11, 'Bielorrusa', 'bielorrusa', 'es'),
(54, 11, 'Biélorusse', 'bielorusse', 'fr'),
(55, 11, 'البيلاروسية', 'البيلاروسية', 'ar'),
(56, 12, 'Bulgarian', 'bulgarian', 'en'),
(57, 12, '保加利亚语', '保加利亚语', 'zh'),
(58, 12, 'Búlgaro', 'bulgaro', 'es'),
(59, 12, 'Bulgare', 'bulgare', 'fr'),
(60, 12, 'البلغارية', 'البلغارية', 'ar'),
(61, 13, 'Bihari', 'bihari', 'en'),
(62, 13, '比哈里', '比哈里', 'zh'),
(63, 13, 'Bihari', 'bihari-1', 'es'),
(64, 13, 'Bihari', 'bihari-2', 'fr'),
(65, 13, 'بيهاري', 'بيهاري', 'ar'),
(66, 14, 'Bislama', 'bislama', 'en'),
(67, 14, '比斯拉马语', '比斯拉马语', 'zh'),
(68, 14, 'Bislama', 'bislama-1', 'es'),
(69, 14, 'Bislama', 'bislama-2', 'fr'),
(70, 14, 'البيسلامية', 'البيسلامية', 'ar'),
(71, 15, 'Bengali/Bangla', 'bengalibangla', 'en'),
(72, 15, '孟加拉/孟加拉语', '孟加拉孟加拉语', 'zh'),
(73, 15, 'Bengalí / Bangla', 'bengali-bangla', 'es'),
(74, 15, 'Bengali / Bangla', 'bengali-bangla-1', 'fr'),
(75, 15, 'البنغالية', 'البنغالية', 'ar'),
(76, 16, 'Tibetan', 'tibetan', 'en'),
(77, 16, '藏', '藏', 'zh'),
(78, 16, 'Tibetano', 'tibetano', 'es'),
(79, 16, 'Tibétain', 'tibetain', 'fr'),
(80, 16, 'التبت', 'التبت', 'ar'),
(81, 17, 'Breton', 'breton', 'en'),
(82, 17, '布列塔尼', '布列塔尼', 'zh'),
(83, 17, 'Bretón', 'breton-1', 'es'),
(84, 17, 'Breton', 'breton-2', 'fr'),
(85, 17, 'البريتونية', 'البريتونية', 'ar'),
(86, 18, 'Catalan', 'catalan', 'en'),
(87, 18, '加泰罗尼亚', '加泰罗尼亚', 'zh'),
(88, 18, 'Catalana', 'catalana', 'es'),
(89, 18, 'Catalan', 'catalan-1', 'fr'),
(90, 18, 'الكاتالونية', 'الكاتالونية', 'ar'),
(91, 19, 'Corsican', 'corsican', 'en'),
(92, 19, '科西嘉', '科西嘉', 'zh'),
(93, 19, 'Crso', 'crso', 'es'),
(94, 19, 'Corse', 'corse', 'fr'),
(95, 19, 'الكورسيكية', 'الكورسيكية', 'ar'),
(96, 20, 'Czech', 'czech', 'en'),
(97, 20, '捷克', '捷克', 'zh'),
(98, 20, 'Checo', 'checo', 'es'),
(99, 20, 'Tchèque', 'tcheque', 'fr'),
(100, 20, 'التشيكية', 'التشيكية', 'ar'),
(101, 21, 'Welsh', 'welsh', 'en'),
(102, 21, '威尔士语', '威尔士语', 'zh'),
(103, 21, 'Galés', 'gales', 'es'),
(104, 21, 'Gallois', 'gallois', 'fr'),
(105, 21, 'الويلزية', 'الويلزية', 'ar'),
(106, 22, 'Danish', 'danish', 'en'),
(107, 22, '丹麦', '丹麦', 'zh'),
(108, 22, 'Danés', 'danes', 'es'),
(109, 22, 'Danois', 'danois', 'fr'),
(110, 22, 'الدنماركية', 'الدنماركية', 'ar'),
(111, 23, 'German', 'german', 'en'),
(112, 23, '德语', '德语', 'zh'),
(113, 23, 'Aleman', 'aleman', 'es'),
(114, 23, 'Allemand', 'allemand', 'fr'),
(115, 23, 'الالمانية', 'الالمانية', 'ar'),
(116, 24, 'Bhutani', 'bhutani', 'en'),
(117, 24, '不丹', '不丹', 'zh'),
(118, 24, 'Butaní', 'butani', 'es'),
(119, 24, 'Bhutani', 'bhutani-1', 'fr'),
(120, 24, 'بوتاني', 'بوتاني', 'ar'),
(121, 25, 'Greek', 'greek', 'en'),
(122, 25, '希腊语', '希腊语', 'zh'),
(123, 25, 'Griega', 'griega', 'es'),
(124, 25, 'Grec', 'grec', 'fr'),
(125, 25, 'اليونانية', 'اليونانية', 'ar'),
(126, 26, 'Esperanto', 'esperanto', 'en'),
(127, 26, '世界语', '世界语', 'zh'),
(128, 26, 'Esperanto', 'esperanto-1', 'es'),
(129, 26, 'Espéranto', 'esperanto-2', 'fr'),
(130, 26, 'اسبرانتو', 'اسبرانتو', 'ar'),
(131, 27, 'Spanish', 'spanish', 'en'),
(132, 27, '西班牙语', '西班牙语', 'zh'),
(133, 27, 'Español', 'espanol', 'es'),
(134, 27, 'Espanol', 'espanol-1', 'fr'),
(135, 27, 'الاسبانية', 'الاسبانية', 'ar'),
(136, 28, 'Estonian', 'estonian', 'en'),
(137, 28, '爱沙尼亚语', '爱沙尼亚语', 'zh'),
(138, 28, 'Estonio', 'estonio', 'es'),
(139, 28, 'Estonien', 'estonien', 'fr'),
(140, 28, 'الاستونية', 'الاستونية', 'ar'),
(141, 29, 'Basque', 'basque', 'en'),
(142, 29, '巴斯克', '巴斯克', 'zh'),
(143, 29, 'Vasco', 'vasco', 'es'),
(144, 29, 'Basque', 'basque-1', 'fr'),
(145, 29, 'الباسك', 'الباسك', 'ar'),
(146, 30, 'Persian', 'persian', 'en'),
(147, 30, '波斯语', '波斯语', 'zh'),
(148, 30, 'Persa', 'persa', 'es'),
(149, 30, 'Persan', 'persan', 'fr'),
(150, 30, 'الفارسية', 'الفارسية', 'ar'),
(151, 31, 'Finnish', 'finnish', 'en'),
(152, 31, '芬兰', '芬兰', 'zh'),
(153, 31, 'Finlandés', 'finlandes', 'es'),
(154, 31, 'Finlandais', 'finlandais', 'fr'),
(155, 31, 'الفنلندية', 'الفنلندية', 'ar'),
(156, 32, 'Fiji', 'fiji', 'en'),
(157, 32, '斐', '斐', 'zh'),
(158, 32, 'Fiyi', 'fiyi', 'es'),
(159, 32, 'Fidji', 'fidji', 'fr'),
(160, 32, 'فيجي', 'فيجي', 'ar'),
(161, 33, 'Faeroese', 'faeroese', 'en'),
(162, 33, '法罗群岛', '法罗群岛', 'zh'),
(163, 33, 'Faeroese', 'faeroese-1', 'es'),
(164, 33, 'Féroé', 'feroe', 'fr'),
(165, 33, 'فاروية', 'فاروية', 'ar'),
(166, 34, 'French', 'french', 'en'),
(167, 34, '法国', '法国', 'zh'),
(168, 34, 'Francés', 'frances', 'es'),
(169, 34, 'Français', 'francais', 'fr'),
(170, 34, 'الفرنسية', 'الفرنسية', 'ar'),
(171, 35, 'Frisian', 'frisian', 'en'),
(172, 35, '弗里斯兰', '弗里斯兰', 'zh'),
(173, 35, 'Frisio', 'frisio', 'es'),
(174, 35, 'Frison', 'frison', 'fr'),
(175, 35, 'الفريزية', 'الفريزية', 'ar'),
(176, 36, 'Irish', 'irish', 'en'),
(177, 36, '爱尔兰的', '爱尔兰的', 'zh'),
(178, 36, 'Irlandés', 'irlandes', 'es'),
(179, 36, 'Irlandais', 'irlandais', 'fr'),
(180, 36, 'الايرلندية', 'الايرلندية', 'ar'),
(181, 37, 'Scots/Gaelic', 'scotsgaelic', 'en'),
(182, 37, '苏格兰/盖尔', '苏格兰盖尔', 'zh'),
(183, 37, 'Escoceses / gaélico', 'escoceses-gaelico', 'es'),
(184, 37, 'Écossais / gaélique', 'ecossais-gaelique', 'fr'),
(185, 37, 'الاسكتلندية', 'الاسكتلندية', 'ar'),
(186, 38, 'Galician', 'galician', 'en'),
(187, 38, '加利西亚', '加利西亚', 'zh'),
(188, 38, 'Gallego', 'gallego', 'es'),
(189, 38, 'Galicien', 'galicien', 'fr'),
(190, 38, 'الجاليكية', 'الجاليكية', 'ar'),
(191, 39, 'Guarani', 'guarani', 'en'),
(192, 39, '瓜拉尼', '瓜拉尼', 'zh'),
(193, 39, 'Guaraní', 'guarani-1', 'es'),
(194, 39, 'Guarani', 'guarani-2', 'fr'),
(195, 39, 'الجواراني', 'الجواراني', 'ar'),
(196, 40, 'Gujarati', 'gujarati', 'en'),
(197, 40, '古吉拉特语', '古吉拉特语', 'zh'),
(198, 40, 'Gujarati', 'gujarati-1', 'es'),
(199, 40, 'Gujarati', 'gujarati-2', 'fr'),
(200, 40, 'الغوجاراتية', 'الغوجاراتية', 'ar'),
(201, 41, 'Hausa', 'hausa', 'en'),
(202, 41, '豪萨语', '豪萨语', 'zh'),
(203, 41, 'Hausa', 'hausa-1', 'es'),
(204, 41, 'Hausa', 'hausa-2', 'fr'),
(205, 41, 'الهوسا', 'الهوسا', 'ar'),
(206, 42, 'Hindi', 'hindi', 'en'),
(207, 42, '印地语', '印地语', 'zh'),
(208, 42, 'Hindi', 'hindi-1', 'es'),
(209, 42, 'Hindi', 'hindi-2', 'fr'),
(210, 42, 'الهندية', 'الهندية', 'ar'),
(211, 43, 'Croatian', 'croatian', 'en'),
(212, 43, '克罗地亚', '克罗地亚', 'zh'),
(213, 43, 'Croata', 'croata', 'es'),
(214, 43, 'Croate', 'croate', 'fr'),
(215, 43, 'الكرواتية', 'الكرواتية', 'ar'),
(216, 44, 'Hungarian', 'hungarian', 'en'),
(217, 44, '匈牙利', '匈牙利', 'zh'),
(218, 44, 'Húngaro', 'hungaro', 'es'),
(219, 44, 'Hongrois', 'hongrois', 'fr'),
(220, 44, 'الهنغارية', 'الهنغارية', 'ar'),
(221, 45, 'Armenian', 'armenian', 'en'),
(222, 45, '亚美尼亚', '亚美尼亚', 'zh'),
(223, 45, 'Armenio', 'armenio', 'es'),
(224, 45, 'Arménien', 'armenien', 'fr'),
(225, 45, 'الأرمنية', 'الأرمنية', 'ar'),
(226, 46, 'Interlingua', 'interlingua', 'en'),
(227, 46, '国际语', '国际语', 'zh'),
(228, 46, 'Interlingua', 'interlingua-1', 'es'),
(229, 46, 'Interlingua', 'interlingua-2', 'fr'),
(230, 46, 'الإنترلنغوا', 'الإنترلنغوا', 'ar'),
(231, 47, 'Interlingue', 'interlingue', 'en'),
(232, 47, '国际语', '国际语-1', 'zh'),
(233, 47, 'Interlingue', 'interlingue-1', 'es'),
(234, 47, 'Interlingue', 'interlingue-2', 'fr'),
(235, 47, 'الإنترلنغوا', 'الإنترلنغوا-1', 'ar'),
(236, 48, 'Inupiak', 'inupiak', 'en'),
(237, 48, '伊努必语', '伊努必语', 'zh'),
(238, 48, 'Inupiak', 'inupiak-1', 'es'),
(239, 48, 'Inupiak', 'inupiak-2', 'fr'),
(240, 48, 'إنوبياك', 'إنوبياك', 'ar'),
(241, 49, 'Indonesian', 'indonesian', 'en'),
(242, 49, '印度尼西亚', '印度尼西亚', 'zh'),
(243, 49, 'Indonesio', 'indonesio', 'es'),
(244, 49, 'Indonésien', 'indonesien', 'fr'),
(245, 49, 'الاندونيسية', 'الاندونيسية', 'ar'),
(246, 50, 'Icelandic', 'icelandic', 'en'),
(247, 50, '冰岛的', '冰岛的', 'zh'),
(248, 50, 'Islandés', 'islandes', 'es'),
(249, 50, 'Islandais', 'islandais', 'fr'),
(250, 50, 'الأيسلندية', 'الأيسلندية', 'ar'),
(251, 51, 'Italian', 'italian', 'en'),
(252, 51, '意大利', '意大利', 'zh'),
(253, 51, 'Italiano', 'italiano', 'es'),
(254, 51, 'Italien', 'italien', 'fr'),
(255, 51, 'الايطالية', 'الايطالية', 'ar'),
(256, 52, 'Hebrew', 'hebrew', 'en'),
(257, 52, '希伯来语', '希伯来语', 'zh'),
(258, 52, 'Hebreo', 'hebreo', 'es'),
(259, 52, 'Hébreu', 'hebreu', 'fr'),
(260, 52, 'العبرية', 'العبرية', 'ar'),
(261, 53, 'Japanese', 'japanese', 'en'),
(262, 53, '日本', '日本', 'zh'),
(263, 53, 'Japonés', 'japones', 'es'),
(264, 53, 'Japonais', 'japonais', 'fr'),
(265, 53, 'اليابانية', 'اليابانية', 'ar'),
(266, 54, 'Yiddish', 'yiddish', 'en'),
(267, 54, '意第绪语', '意第绪语', 'zh'),
(268, 54, 'Yídish', 'yidish', 'es'),
(269, 54, 'Yiddish', 'yiddish-1', 'fr'),
(270, 54, 'الييدية', 'الييدية', 'ar'),
(271, 55, 'Javanese', 'javanese', 'en'),
(272, 55, '爪哇', '爪哇', 'zh'),
(273, 55, 'Javanés', 'javanes', 'es'),
(274, 55, 'Javanais', 'javanais', 'fr'),
(275, 55, 'الجاوية', 'الجاوية', 'ar'),
(276, 56, 'Georgian', 'georgian', 'en'),
(277, 56, '格鲁吉亚', '格鲁吉亚', 'zh'),
(278, 56, 'Georgiano', 'georgiano', 'es'),
(279, 56, 'Géorgien', 'georgien', 'fr'),
(280, 56, 'الجورجية', 'الجورجية', 'ar'),
(281, 57, 'Kazakh', 'kazakh', 'en'),
(282, 57, '哈萨克人', '哈萨克人', 'zh'),
(283, 57, 'Kazajo', 'kazajo', 'es'),
(284, 57, 'Kazakh', 'kazakh-1', 'fr'),
(285, 57, 'الكازاخستانية', 'الكازاخستانية', 'ar'),
(286, 58, 'Greenlandic', 'greenlandic', 'en'),
(287, 58, '格陵兰', '格陵兰', 'zh'),
(288, 58, 'Groenlandés', 'groenlandes', 'es'),
(289, 58, 'Groenlandais', 'groenlandais', 'fr'),
(290, 58, 'جرينلاند', 'جرينلاند', 'ar'),
(291, 59, 'Cambodian', 'cambodian', 'en'),
(292, 59, '柬埔寨', '柬埔寨', 'zh'),
(293, 59, 'Camboyano', 'camboyano', 'es'),
(294, 59, 'Cambodgien', 'cambodgien', 'fr'),
(295, 59, 'الكمبودية', 'الكمبودية', 'ar'),
(296, 60, 'Kannada', 'kannada', 'en'),
(297, 60, '卡纳达语', '卡纳达语', 'zh'),
(298, 60, 'Kannada', 'kannada-1', 'es'),
(299, 60, 'Kannada', 'kannada-2', 'fr'),
(300, 60, 'الكانادا', 'الكانادا', 'ar'),
(301, 61, 'Korean', 'korean', 'en'),
(302, 61, '朝鲜的', '朝鲜的', 'zh'),
(303, 61, 'Coreano', 'coreano', 'es'),
(304, 61, 'Coréen', 'coreen', 'fr'),
(305, 61, 'الكورية', 'الكورية', 'ar'),
(306, 62, 'Kashmiri', 'kashmiri', 'en'),
(307, 62, '克什米尔', '克什米尔', 'zh'),
(308, 62, 'Kashmiri', 'kashmiri-1', 'es'),
(309, 62, 'Kashmiri', 'kashmiri-2', 'fr'),
(310, 62, 'الكشميرية', 'الكشميرية', 'ar'),
(311, 63, 'Kurdish', 'kurdish', 'en'),
(312, 63, '库尔德', '库尔德', 'zh'),
(313, 63, 'Kurdo', 'kurdo', 'es'),
(314, 63, 'Kurde', 'kurde', 'fr'),
(315, 63, 'الكردية', 'الكردية', 'ar'),
(316, 64, 'Kirghiz', 'kirghiz', 'en'),
(317, 64, '吉尔吉斯人', '吉尔吉斯人', 'zh'),
(318, 64, 'Kirghiz', 'kirghiz-1', 'es'),
(319, 64, 'Kirghiz', 'kirghiz-2', 'fr'),
(320, 64, 'القيرغيزية', 'القيرغيزية', 'ar'),
(321, 65, 'Latin', 'latin', 'en'),
(322, 65, '拉丁', '拉丁', 'zh'),
(323, 65, 'Latín', 'latin-1', 'es'),
(324, 65, 'Latin', 'latin-2', 'fr'),
(325, 65, 'اللاتينية', 'اللاتينية', 'ar'),
(326, 66, 'Lingala', 'lingala', 'en'),
(327, 66, '林加拉语', '林加拉语', 'zh'),
(328, 66, 'Lingala', 'lingala-1', 'es'),
(329, 66, 'Lingala', 'lingala-2', 'fr'),
(330, 66, 'لينجالا', 'لينجالا', 'ar'),
(331, 67, 'Laothian', 'laothian', 'en'),
(332, 67, '老挝语', '老挝语', 'zh'),
(333, 67, 'Laothiano', 'laothiano', 'es'),
(334, 67, 'Laothien', 'laothien', 'fr'),
(335, 67, 'اللاوثية', 'اللاوثية', 'ar'),
(336, 68, 'Lithuanian', 'lithuanian', 'en'),
(337, 68, '立陶宛', '立陶宛', 'zh'),
(338, 68, 'Lituano', 'lituano', 'es'),
(339, 68, 'Lituanien', 'lituanien', 'fr'),
(340, 68, 'الليتوانية', 'الليتوانية', 'ar'),
(341, 69, 'Latvian/Lettish', 'latvianlettish', 'en'),
(342, 69, '拉脱维亚语/列托语', '拉脱维亚语列托语', 'zh'),
(343, 69, 'Letón / Lettish', 'leton-lettish', 'es'),
(344, 69, 'Letton', 'letton', 'fr'),
(345, 69, 'اللاتفية', 'اللاتفية', 'ar'),
(346, 70, 'Malagasy', 'malagasy', 'en'),
(347, 70, '马尔加什', '马尔加什', 'zh'),
(348, 70, 'Madagascarí', 'madagascari', 'es'),
(349, 70, 'Malgache', 'malgache', 'fr'),
(350, 70, 'الملغاشية', 'الملغاشية', 'ar'),
(351, 71, 'Maori', 'maori', 'en'),
(352, 71, '毛利', '毛利', 'zh'),
(353, 71, 'Maorí', 'maori-1', 'es'),
(354, 71, 'Maori', 'maori-2', 'fr'),
(355, 71, 'الماوري', 'الماوري', 'ar'),
(356, 72, 'Macedonian', 'macedonian', 'en'),
(357, 72, '马其顿', '马其顿', 'zh'),
(358, 72, 'Macedónio', 'macedonio', 'es'),
(359, 72, 'Macédonien', 'macedonien', 'fr'),
(360, 72, 'المقدونية', 'المقدونية', 'ar'),
(361, 73, 'Malayalam', 'malayalam', 'en'),
(362, 73, '马拉雅拉姆语', '马拉雅拉姆语', 'zh'),
(363, 73, 'Malayalam', 'malayalam-1', 'es'),
(364, 73, 'Malayalam', 'malayalam-2', 'fr'),
(365, 73, 'المالايالامية', 'المالايالامية', 'ar'),
(366, 74, 'Mongolian', 'mongolian', 'en'),
(367, 74, '蒙', '蒙', 'zh'),
(368, 74, 'Mongol', 'mongol', 'es'),
(369, 74, 'Mongol', 'mongol-1', 'fr'),
(370, 74, 'المنغولية', 'المنغولية', 'ar'),
(371, 75, 'Moldavian', 'moldavian', 'en'),
(372, 75, '摩尔多瓦', '摩尔多瓦', 'zh'),
(373, 75, 'Moldavo', 'moldavo', 'es'),
(374, 75, 'Moldave', 'moldave', 'fr'),
(375, 75, 'المولدوفا', 'المولدوفا', 'ar'),
(376, 76, 'Marathi', 'marathi', 'en'),
(377, 76, '马拉', '马拉', 'zh'),
(378, 76, 'Marathi', 'marathi-1', 'es'),
(379, 76, 'Marathi', 'marathi-2', 'fr'),
(380, 76, 'الماراثية', 'الماراثية', 'ar'),
(381, 77, 'Malay', 'malay', 'en'),
(382, 77, '马来语', '马来语', 'zh'),
(383, 77, 'Malayo', 'malayo', 'es'),
(384, 77, 'Malais', 'malais', 'fr'),
(385, 77, 'الملايو', 'الملايو', 'ar'),
(386, 78, 'Maltese', 'maltese', 'en'),
(387, 78, '马耳他语', '马耳他语', 'zh'),
(388, 78, 'Maltés', 'maltes', 'es'),
(389, 78, 'Maltais', 'maltais', 'fr'),
(390, 78, 'المالطية', 'المالطية', 'ar'),
(391, 79, 'Burmese', 'burmese', 'en'),
(392, 79, '缅甸语', '缅甸语', 'zh'),
(393, 79, 'Birmano', 'birmano', 'es'),
(394, 79, 'Birman', 'birman', 'fr'),
(395, 79, 'البورمية', 'البورمية', 'ar'),
(396, 80, 'Nauru', 'nauru', 'en'),
(397, 80, '瑙鲁', '瑙鲁', 'zh'),
(398, 80, 'Nauru', 'nauru-1', 'es'),
(399, 80, 'Nauru', 'nauru-2', 'fr'),
(400, 80, 'الناورو', 'الناورو', 'ar'),
(401, 81, 'Nepali', 'nepali', 'en'),
(402, 81, '尼泊尔', '尼泊尔', 'zh'),
(403, 81, 'Nepalí', 'nepali-1', 'es'),
(404, 81, 'Népalais', 'nepalais', 'fr'),
(405, 81, 'النيبالية', 'النيبالية', 'ar'),
(406, 82, 'Dutch', 'dutch', 'en'),
(407, 82, '荷兰人', '荷兰人', 'zh'),
(408, 82, 'Holandés', 'holandes', 'es'),
(409, 82, 'Néerlandais', 'neerlandais', 'fr'),
(410, 82, 'الهولندية', 'الهولندية', 'ar'),
(411, 83, 'Norwegian', 'norwegian', 'en'),
(412, 83, '挪威', '挪威', 'zh'),
(413, 83, 'Noruego', 'noruego', 'es'),
(414, 83, 'Norvégien', 'norvegien', 'fr'),
(415, 83, 'النرويجية', 'النرويجية', 'ar'),
(416, 84, 'Occitan', 'occitan', 'en'),
(417, 84, '奥克', '奥克', 'zh'),
(418, 84, 'Occitano', 'occitano', 'es'),
(419, 84, 'Occitan', 'occitan-1', 'fr'),
(420, 84, 'الأوكيتانية', 'الأوكيتانية', 'ar'),
(421, 85, '(Afan)/Oromoor/Oriya', 'afanoromoororiya', 'en'),
(422, 85, '（阿凡）/ Oromoor/奥里亚', '（阿凡）-oromoor奥里亚', 'zh'),
(423, 85, '(Afan)/Oromoor/Oriya', 'afanoromoororiya-1', 'es'),
(424, 85, '(Afan)/Oromoor/Oriya', 'afanoromoororiya-2', 'fr'),
(425, 85, 'افان', 'افان', 'ar'),
(426, 86, 'Punjabi', 'punjabi', 'en'),
(427, 86, '旁遮普', '旁遮普', 'zh'),
(428, 86, 'Punjabi', 'punjabi-1', 'es'),
(429, 86, 'Punjabi', 'punjabi-2', 'fr'),
(430, 86, 'البنجابية', 'البنجابية', 'ar'),
(431, 87, 'Polish', 'polish', 'en'),
(432, 87, '抛光', '抛光', 'zh'),
(433, 87, 'Polaco', 'polaco', 'es'),
(434, 87, 'Polonais', 'polonais', 'fr'),
(435, 87, 'البولندية', 'البولندية', 'ar'),
(436, 88, 'Pashto/Pushto', 'pashtopushto', 'en'),
(437, 88, '普什图语/普什图语', '普什图语普什图语', 'zh'),
(438, 88, 'Pashto/Pushto', 'pashtopushto-1', 'es'),
(439, 88, 'Pashto/Pushto', 'pashtopushto-2', 'fr'),
(440, 88, 'البشتو', 'البشتو', 'ar'),
(441, 89, 'Portuguese', 'portuguese', 'en'),
(442, 89, '葡萄牙语', '葡萄牙语', 'zh'),
(443, 89, 'Portugués', 'portugues', 'es'),
(444, 89, 'Portugais', 'portugais', 'fr'),
(445, 89, 'البرتغالية', 'البرتغالية', 'ar'),
(446, 90, 'Quechua', 'quechua', 'en'),
(447, 90, '克丘亚语', '克丘亚语', 'zh'),
(448, 90, 'Quechua', 'quechua-1', 'es'),
(449, 90, 'Quechua', 'quechua-2', 'fr'),
(450, 90, 'الكيشوا', 'الكيشوا', 'ar'),
(451, 91, 'Rhaeto-Romance', 'rhaeto-romance', 'en'),
(452, 91, '里托罗曼', '里托罗曼', 'zh'),
(453, 91, 'Rhaeto-Romance', 'rhaeto-romance-1', 'es'),
(454, 91, 'Rhéto-Romance', 'rheto-romance', 'fr'),
(455, 91, 'راتو رمانس', 'راتو-رمانس', 'ar'),
(456, 92, 'Kirundi', 'kirundi', 'en'),
(457, 92, '基隆迪', '基隆迪', 'zh'),
(458, 92, 'Kirundi', 'kirundi-1', 'es'),
(459, 92, 'Kirundi', 'kirundi-2', 'fr'),
(460, 92, 'الكيروندي', 'الكيروندي', 'ar'),
(461, 93, 'Romanian', 'romanian', 'en'),
(462, 93, '罗马尼亚', '罗马尼亚', 'zh'),
(463, 93, 'Rumano', 'rumano', 'es'),
(464, 93, 'Roumain', 'roumain', 'fr'),
(465, 93, 'الرومانية', 'الرومانية', 'ar'),
(466, 94, 'Russian', 'russian', 'en'),
(467, 94, '俄语', '俄语', 'zh'),
(468, 94, 'Ruso', 'ruso', 'es'),
(469, 94, 'Russe', 'russe', 'fr'),
(470, 94, 'الروسية', 'الروسية', 'ar'),
(471, 95, 'Kinyarwanda', 'kinyarwanda', 'en'),
(472, 95, '卢旺达语', '卢旺达语', 'zh'),
(473, 95, 'Kinyarwanda', 'kinyarwanda-1', 'es'),
(474, 95, 'Kinyarwanda', 'kinyarwanda-2', 'fr'),
(475, 95, 'الكينيارواندا', 'الكينيارواندا', 'ar'),
(476, 96, 'Sanskrit', 'sanskrit', 'en'),
(477, 96, '梵文', '梵文', 'zh'),
(478, 96, 'Sánscrito', 'sanscrito', 'es'),
(479, 96, 'Sanskrit', 'sanskrit-1', 'fr'),
(480, 96, 'السنسكريتية', 'السنسكريتية', 'ar'),
(481, 97, 'Sindhi', 'sindhi', 'en'),
(482, 97, '信德', '信德', 'zh'),
(483, 97, 'Sindhi', 'sindhi-1', 'es'),
(484, 97, 'Sindhi', 'sindhi-2', 'fr'),
(485, 97, 'السندية', 'السندية', 'ar'),
(486, 98, 'Sangro', 'sangro', 'en'),
(487, 98, '桑格罗', '桑格罗', 'zh'),
(488, 98, 'Sangro', 'sangro-1', 'es'),
(489, 98, 'Sangro', 'sangro-2', 'fr'),
(490, 98, 'السانجرو', 'السانجرو', 'ar'),
(491, 99, 'Serbo-Croatian', 'serbo-croatian', 'en'),
(492, 99, '塞尔维亚 - 克罗地亚语', '塞尔维亚-克罗地亚语', 'zh'),
(493, 99, 'Serbocroata', 'serbocroata', 'es'),
(494, 99, 'Serbo-croate', 'serbo-croate', 'fr'),
(495, 99, 'الصربية الكرواتية', 'الصربية-الكرواتية', 'ar'),
(496, 100, 'Singhalese', 'singhalese', 'en'),
(497, 100, '僧伽罗人', '僧伽罗人', 'zh'),
(498, 100, 'Cingalés', 'cingales', 'es'),
(499, 100, 'Cingalais', 'cingalais', 'fr'),
(500, 100, 'السنهالية', 'السنهالية', 'ar'),
(501, 101, 'Slovak', 'slovak', 'en'),
(502, 101, '斯洛伐克', '斯洛伐克', 'zh'),
(503, 101, 'Eslovaco', 'eslovaco', 'es'),
(504, 101, 'Slovaque', 'slovaque', 'fr'),
(505, 101, 'السلوفاكية', 'السلوفاكية', 'ar'),
(506, 102, 'Slovenian', 'slovenian', 'en'),
(507, 102, '斯洛文尼亚', '斯洛文尼亚', 'zh'),
(508, 102, 'Esloveno', 'esloveno', 'es'),
(509, 102, 'Slovène', 'slovene', 'fr'),
(510, 102, 'السلوفينية', 'السلوفينية', 'ar'),
(511, 103, 'Samoan', 'samoan', 'en'),
(512, 103, '萨摩亚', '萨摩亚', 'zh'),
(513, 103, 'Samoano', 'samoano', 'es'),
(514, 103, 'Samoan', 'samoan-1', 'fr'),
(515, 103, 'الساموا', 'الساموا', 'ar'),
(516, 104, 'Shona', 'shona', 'en'),
(517, 104, '绍纳语', '绍纳语', 'zh'),
(518, 104, 'Shona', 'shona-1', 'es'),
(519, 104, 'Shona', 'shona-2', 'fr'),
(520, 104, 'الشونا', 'الشونا', 'ar'),
(521, 105, 'Somali', 'somali', 'en'),
(522, 105, '索马里', '索马里', 'zh'),
(523, 105, 'Somalí', 'somali-1', 'es'),
(524, 105, 'Somali', 'somali-2', 'fr'),
(525, 105, 'الصومالية', 'الصومالية', 'ar'),
(526, 106, 'Albanian', 'albanian', 'en'),
(527, 106, '阿尔巴尼亚人', '阿尔巴尼亚人', 'zh'),
(528, 106, 'Albanés', 'albanes', 'es'),
(529, 106, 'Albanais', 'albanais', 'fr'),
(530, 106, 'الألبانية', 'الألبانية', 'ar'),
(531, 107, 'Serbian', 'serbian', 'en'),
(532, 107, '塞尔维亚', '塞尔维亚', 'zh'),
(533, 107, 'Serbio', 'serbio', 'es'),
(534, 107, 'Serbe', 'serbe', 'fr'),
(535, 107, 'الصربية', 'الصربية', 'ar'),
(536, 108, 'Siswati', 'siswati', 'en'),
(537, 108, '斯瓦蒂语', '斯瓦蒂语', 'zh'),
(538, 108, 'Siswati', 'siswati-1', 'es'),
(539, 108, 'Siswati', 'siswati-2', 'fr'),
(540, 108, 'السيسواتي', 'السيسواتي', 'ar'),
(541, 109, 'Sesotho', 'sesotho', 'en'),
(542, 109, '塞索托语', '塞索托语', 'zh'),
(543, 109, 'Sesotho', 'sesotho-1', 'es'),
(544, 109, 'Sesotho', 'sesotho-2', 'fr'),
(545, 109, 'السيسوتو', 'السيسوتو', 'ar'),
(546, 110, 'Sundanese', 'sundanese', 'en'),
(547, 110, '巽', '巽', 'zh'),
(548, 110, 'Sundanés', 'sundanes', 'es'),
(549, 110, 'Sundanais', 'sundanais', 'fr'),
(550, 110, 'السودانية', 'السودانية', 'ar'),
(551, 111, 'Swedish', 'swedish', 'en'),
(552, 111, '瑞典', '瑞典', 'zh'),
(553, 111, 'Sueco', 'sueco', 'es'),
(554, 111, 'Suédois', 'suedois', 'fr'),
(555, 111, 'السويدية', 'السويدية', 'ar'),
(556, 112, 'Swahili', 'swahili', 'en'),
(557, 112, '斯瓦希里', '斯瓦希里', 'zh'),
(558, 112, 'Swahili', 'swahili-1', 'es'),
(559, 112, 'Swahili', 'swahili-2', 'fr'),
(560, 112, 'السواحيلية', 'السواحيلية', 'ar'),
(561, 113, 'Tamil', 'tamil', 'en'),
(562, 113, '泰米尔人', '泰米尔人', 'zh'),
(563, 113, 'Tamil', 'tamil-1', 'es'),
(564, 113, 'Tamil', 'tamil-2', 'fr'),
(565, 113, 'التاميل', 'التاميل', 'ar'),
(566, 114, 'Tegulu', 'tegulu', 'en'),
(567, 114, '泰卢固语', '泰卢固语', 'zh'),
(568, 114, 'Tegulu', 'tegulu-1', 'es'),
(569, 114, 'Télougou', 'telougou', 'fr'),
(570, 114, 'التيلجو', 'التيلجو', 'ar'),
(571, 115, 'Tajik', 'tajik', 'en'),
(572, 115, '塔吉克', '塔吉克', 'zh'),
(573, 115, 'Tayiko', 'tayiko', 'es'),
(574, 115, 'Tadjik', 'tadjik', 'fr'),
(575, 115, 'الطاجيكية', 'الطاجيكية', 'ar'),
(576, 116, 'Thai', 'thai', 'en'),
(577, 116, '泰国', '泰国', 'zh'),
(578, 116, 'Tailandés', 'tailandes', 'es'),
(579, 116, 'Thaïlandais', 'thailandais', 'fr'),
(580, 116, 'التايلاندية', 'التايلاندية', 'ar'),
(581, 117, 'Tigrinya', 'tigrinya', 'en'),
(582, 117, '提格雷语', '提格雷语', 'zh'),
(583, 117, 'Tigrinya', 'tigrinya-1', 'es'),
(584, 117, 'Tigrinya', 'tigrinya-2', 'fr'),
(585, 117, 'التغرينية', 'التغرينية', 'ar'),
(586, 118, 'Turkmen', 'turkmen', 'en'),
(587, 118, '土库曼', '土库曼', 'zh'),
(588, 118, 'Turcomanos', 'turcomanos', 'es'),
(589, 118, 'Turkmène', 'turkmene', 'fr'),
(590, 118, 'التركمانية', 'التركمانية', 'ar'),
(591, 119, 'Tagalog', 'tagalog', 'en'),
(592, 119, '他加禄语', '他加禄语', 'zh'),
(593, 119, 'Tagalo', 'tagalo', 'es'),
(594, 119, 'Tagalog', 'tagalog-1', 'fr'),
(595, 119, 'التاغالوغية', 'التاغالوغية', 'ar'),
(596, 120, 'Setswana', 'setswana', 'en'),
(597, 120, '茨瓦纳语', '茨瓦纳语', 'zh'),
(598, 120, 'Setswana', 'setswana-1', 'es'),
(599, 120, 'Setswana', 'setswana-2', 'fr'),
(600, 120, 'الستسوانا', 'الستسوانا', 'ar'),
(601, 121, 'Tonga', 'tonga', 'en'),
(602, 121, '汤加', '汤加', 'zh'),
(603, 121, 'Tonga', 'tonga-1', 'es'),
(604, 121, 'Tonga', 'tonga-2', 'fr'),
(605, 121, 'التونجا', 'التونجا', 'ar'),
(606, 122, 'Turkish', 'turkish', 'en'),
(607, 122, '土耳其', '土耳其', 'zh'),
(608, 122, 'Turco', 'turco', 'es'),
(609, 122, 'Turc', 'turc', 'fr'),
(610, 122, 'التركية', 'التركية', 'ar'),
(611, 123, 'Tsonga', 'tsonga', 'en'),
(612, 123, '特松加', '特松加', 'zh'),
(613, 123, 'Tsonga', 'tsonga-1', 'es'),
(614, 123, 'Tsonga', 'tsonga-2', 'fr'),
(615, 123, 'التسونجا', 'التسونجا', 'ar'),
(616, 124, 'Tatar', 'tatar', 'en'),
(617, 124, '鞑靼', '鞑靼', 'zh'),
(618, 124, 'Tártaro', 'tartaro', 'es'),
(619, 124, 'Tatar', 'tatar-1', 'fr'),
(620, 124, 'التتار', 'التتار', 'ar'),
(621, 125, 'Twi', 'twi', 'en'),
(622, 125, 'Twi', 'twi-1', 'zh'),
(623, 125, 'Twi', 'twi-2', 'es'),
(624, 125, 'Twi', 'twi-3', 'fr'),
(625, 125, 'التوي', 'التوي', 'ar'),
(626, 126, 'Ukrainian', 'ukrainian', 'en'),
(627, 126, '乌克兰', '乌克兰', 'zh'),
(628, 126, 'Ucranio', 'ucranio', 'es'),
(629, 126, 'Ukrainien', 'ukrainien', 'fr'),
(630, 126, 'الأوكرانية', 'الأوكرانية', 'ar'),
(631, 127, 'Urdu', 'urdu', 'en'),
(632, 127, '乌尔都语', '乌尔都语', 'zh'),
(633, 127, 'Urdu', 'urdu-1', 'es'),
(634, 127, 'Ourdou', 'ourdou', 'fr'),
(635, 127, 'الأوردية', 'الأوردية', 'ar'),
(636, 128, 'Uzbek', 'uzbek', 'en'),
(637, 128, '乌兹别克', '乌兹别克', 'zh'),
(638, 128, 'Uzbeko', 'uzbeko', 'es'),
(639, 128, 'Ouzbek', 'ouzbek', 'fr'),
(640, 128, 'الأوزبكية', 'الأوزبكية', 'ar'),
(641, 129, 'Vietnamese', 'vietnamese', 'en'),
(642, 129, '越南', '越南', 'zh'),
(643, 129, 'Vietnamita', 'vietnamita', 'es'),
(644, 129, 'Vietnamien', 'vietnamien', 'fr'),
(645, 129, 'الفيتنامية', 'الفيتنامية', 'ar'),
(646, 130, 'Volapuk', 'volapuk', 'en'),
(647, 130, '沃拉普克语', '沃拉普克语', 'zh'),
(648, 130, 'Volapuk', 'volapuk-1', 'es'),
(649, 130, 'Volapuk', 'volapuk-2', 'fr'),
(650, 130, 'الفولابوك', 'الفولابوك', 'ar'),
(651, 131, 'Wolof', 'wolof', 'en'),
(652, 131, '沃洛夫语', '沃洛夫语', 'zh'),
(653, 131, 'Wolof', 'wolof-1', 'es'),
(654, 131, 'Wolof', 'wolof-2', 'fr'),
(655, 131, 'الولوف', 'الولوف', 'ar'),
(656, 132, 'Xhosa', 'xhosa', 'en'),
(657, 132, '科萨', '科萨', 'zh'),
(658, 132, 'Xhosa', 'xhosa-1', 'es'),
(659, 132, 'Xhosa', 'xhosa-2', 'fr'),
(660, 132, 'الخوزا', 'الخوزا', 'ar'),
(661, 133, 'Yoruba', 'yoruba', 'en'),
(662, 133, '约鲁巴', '约鲁巴', 'zh'),
(663, 133, 'Yoruba', 'yoruba-1', 'es'),
(664, 133, 'Yoruba', 'yoruba-2', 'fr'),
(665, 133, 'اليوروبا', 'اليوروبا', 'ar'),
(666, 134, 'Chinese', 'chinese', 'en'),
(667, 134, '中文', '中文', 'zh'),
(668, 134, 'Chino', 'chino', 'es'),
(669, 134, 'Chinois', 'chinois', 'fr'),
(670, 134, 'الصينية', 'الصينية', 'ar'),
(671, 135, 'Zulu', 'zulu', 'en'),
(672, 135, '祖鲁', '祖鲁', 'zh'),
(673, 135, 'Zulú', 'zulu-1', 'es'),
(674, 135, 'Zoulou', 'zoulou', 'fr'),
(675, 135, 'الزولو', 'الزولو', 'ar');

-- --------------------------------------------------------

--
-- Table structure for table `eventic_order`
--

DROP TABLE IF EXISTS `eventic_order`;
CREATE TABLE IF NOT EXISTS `eventic_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `paymentgateway_id` int(11) DEFAULT NULL,
  `payment_id` int(11) DEFAULT NULL,
  `reference` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `note` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL,
  `ticket_fee` decimal(10,2) NOT NULL,
  `ticket_price_percentage_cut` int(11) NOT NULL,
  `currency_ccy` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `currency_symbol` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_2F14A4F44C3A3BB` (`payment_id`),
  KEY `IDX_2F14A4F4A76ED395` (`user_id`),
  KEY `IDX_2F14A4F459CA0035` (`paymentgateway_id`)
) ENGINE=InnoDB AUTO_INCREMENT=175 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `eventic_order_element`
--

DROP TABLE IF EXISTS `eventic_order_element`;
CREATE TABLE IF NOT EXISTS `eventic_order_element` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `eventticket_id` int(11) DEFAULT NULL,
  `unitprice` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_261BAAD18D9F6D38` (`order_id`),
  KEY `IDX_261BAAD1182CEB62` (`eventticket_id`)
) ENGINE=InnoDB AUTO_INCREMENT=201 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `eventic_order_ticket`
--

DROP TABLE IF EXISTS `eventic_order_ticket`;
CREATE TABLE IF NOT EXISTS `eventic_order_ticket` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderelement_id` int(11) DEFAULT NULL,
  `reference` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `scanned` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_111E8938EE04F0C1` (`orderelement_id`)
) ENGINE=InnoDB AUTO_INCREMENT=195 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `eventic_organizer`
--

DROP TABLE IF EXISTS `eventic_organizer`;
CREATE TABLE IF NOT EXISTS `eventic_organizer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(35) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `facebook` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `twitter` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `instagram` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `googleplus` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `linkedin` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `youtubeurl` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `logo_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `logo_size` int(11) DEFAULT NULL,
  `logo_mime_type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `logo_original_name` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `logo_dimensions` longtext COLLATE utf8_unicode_ci COMMENT '(DC2Type:simple_array)',
  `cover_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cover_size` int(11) DEFAULT NULL,
  `cover_mime_type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cover_original_name` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cover_dimensions` longtext COLLATE utf8_unicode_ci COMMENT '(DC2Type:simple_array)',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `views` int(11) NOT NULL,
  `showvenuesmap` tinyint(1) NOT NULL,
  `showfollowers` tinyint(1) NOT NULL,
  `showreviews` tinyint(1) NOT NULL,
  `show_event_date_stats_on_scanner_app` tinyint(1) DEFAULT NULL,
  `allow_tap_to_check_in_on_scanner_app` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_C5EEB9A9989D9B62` (`slug`),
  UNIQUE KEY `UNIQ_C5EEB9A9A76ED395` (`user_id`),
  KEY `IDX_C5EEB9A9F92F3E70` (`country_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `eventic_organizer_category`
--

DROP TABLE IF EXISTS `eventic_organizer_category`;
CREATE TABLE IF NOT EXISTS `eventic_organizer_category` (
  `Organizer_id` int(11) NOT NULL,
  `Category_Id` int(11) NOT NULL,
  PRIMARY KEY (`Organizer_id`,`Category_Id`),
  KEY `IDX_BB88F7D79F5D9622` (`Organizer_id`),
  KEY `IDX_BB88F7D715E3697` (`Category_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `eventic_page`
--

DROP TABLE IF EXISTS `eventic_page`;
CREATE TABLE IF NOT EXISTS `eventic_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `eventic_page`
--

INSERT INTO `eventic_page` (`id`, `updated_at`) VALUES
(1, '2019-10-08 17:36:51'),
(2, '2019-10-08 17:38:44'),
(3, '2019-10-08 17:39:03'),
(4, '2019-10-08 17:39:27'),
(5, '2020-07-09 15:21:21'),
(6, '2020-07-09 15:25:35');

-- --------------------------------------------------------

--
-- Table structure for table `eventic_page_translation`
--

DROP TABLE IF EXISTS `eventic_page_translation`;
CREATE TABLE IF NOT EXISTS `eventic_page_translation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `translatable_id` int(11) DEFAULT NULL,
  `title` varchar(35) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci,
  `locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_3B97CBF2989D9B62` (`slug`),
  UNIQUE KEY `eventic_page_translation_unique_translation` (`translatable_id`,`locale`),
  KEY `IDX_3B97CBF22C2AC5D3` (`translatable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `eventic_page_translation`
--

INSERT INTO `eventic_page_translation` (`id`, `translatable_id`, `title`, `slug`, `content`, `locale`) VALUES
(1, 1, 'Terms of service', 'terms-of-service', '<p>The standard Lorem Ipsum passage, used since the 1500s</p><p>\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"</p><p><br /></p><p>Section 1.10.32 of \"de Finibus Bonorum et Malorum\", written by Cicero in 45 BC</p><p>\"Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?\"</p><p><br /></p><p>1914 translation by H. Rackham</p><p>\"But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it? But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that produces no resultant pleasure?\"</p><p><br /></p><p><span style=\"font-size:.805rem;\">Section 1.10.33 of \"de Finibus Bonorum et Malorum\", written by Cicero in 45 BC</span><br /></p><p>\"At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.\"</p><p><br /></p><p>1914 translation by H. Rackham</p><p>\"On the other hand, we denounce with righteous indignation and dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, so blinded by desire, that they cannot foresee the pain and trouble that are bound to ensue; and equal blame belongs to those who fail in their duty through weakness of will, which is the same as saying through shrinking from toil and pain. These cases are perfectly simple and easy to distinguish. In a free hour, when our power of choice is untrammelled and when nothing prevents our being able to do what we like best, every pleasure is to be welcomed and every pain avoided. But in certain circumstances and owing to the claims of duty or the obligations of business it will frequently occur that pleasures have to be repudiated and annoyances accepted. The wise man therefore always holds in these matters to this principle of selection: he rejects pleasures to secure other greater pleasures, or else he endures pains to avoid worse pains.\"</p>', 'en'),
(2, 2, 'Privacy policy', 'privacy-policy', '<p style=\"font-size:12.88px;\">The standard Lorem Ipsum passage, used since the 1500s</p><p style=\"font-size:12.88px;\">\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"</p><p style=\"font-size:12.88px;\"><br /></p><p style=\"font-size:12.88px;\">Section 1.10.32 of \"de Finibus Bonorum et Malorum\", written by Cicero in 45 BC</p><p style=\"font-size:12.88px;\">\"Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?\"</p><p style=\"font-size:12.88px;\"><br /></p><p style=\"font-size:12.88px;\">1914 translation by H. Rackham</p><p style=\"font-size:12.88px;\">\"But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it? But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that produces no resultant pleasure?\"</p><p style=\"font-size:12.88px;\"><br /></p><p style=\"font-size:12.88px;\"><span style=\"font-size:.805rem;\">Section 1.10.33 of \"de Finibus Bonorum et Malorum\", written by Cicero in 45 BC</span><br /></p><p style=\"font-size:12.88px;\">\"At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.\"</p><p style=\"font-size:12.88px;\"><br /></p><p style=\"font-size:12.88px;\">1914 translation by H. Rackham</p><p style=\"font-size:12.88px;\">\"On the other hand, we denounce with righteous indignation and dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, so blinded by desire, that they cannot foresee the pain and trouble that are bound to ensue; and equal blame belongs to those who fail in their duty through weakness of will, which is the same as saying through shrinking from toil and pain. These cases are perfectly simple and easy to distinguish. In a free hour, when our power of choice is untrammelled and when nothing prevents our being able to do what we like best, every pleasure is to be welcomed and every pain avoided. But in certain circumstances and owing to the claims of duty or the obligations of business it will frequently occur that pleasures have to be repudiated and annoyances accepted. The wise man therefore always holds in these matters to this principle of selection: he rejects pleasures to secure other greater pleasures, or else he endures pains to avoid worse pains.\"</p>', 'en'),
(3, 3, 'Cookie policy', 'cookie-policy', '<p style=\"font-size:12.88px;\">The standard Lorem Ipsum passage, used since the 1500s</p><p style=\"font-size:12.88px;\">\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"</p><p style=\"font-size:12.88px;\"><br /></p><p style=\"font-size:12.88px;\">Section 1.10.32 of \"de Finibus Bonorum et Malorum\", written by Cicero in 45 BC</p><p style=\"font-size:12.88px;\">\"Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?\"</p><p style=\"font-size:12.88px;\"><br /></p><p style=\"font-size:12.88px;\">1914 translation by H. Rackham</p><p style=\"font-size:12.88px;\">\"But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it? But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that produces no resultant pleasure?\"</p><p style=\"font-size:12.88px;\"><br /></p><p style=\"font-size:12.88px;\"><span style=\"font-size:.805rem;\">Section 1.10.33 of \"de Finibus Bonorum et Malorum\", written by Cicero in 45 BC</span><br /></p><p style=\"font-size:12.88px;\">\"At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.\"</p><p style=\"font-size:12.88px;\"><br /></p><p style=\"font-size:12.88px;\">1914 translation by H. Rackham</p><p style=\"font-size:12.88px;\">\"On the other hand, we denounce with righteous indignation and dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, so blinded by desire, that they cannot foresee the pain and trouble that are bound to ensue; and equal blame belongs to those who fail in their duty through weakness of will, which is the same as saying through shrinking from toil and pain. These cases are perfectly simple and easy to distinguish. In a free hour, when our power of choice is untrammelled and when nothing prevents our being able to do what we like best, every pleasure is to be welcomed and every pain avoided. But in certain circumstances and owing to the claims of duty or the obligations of business it will frequently occur that pleasures have to be repudiated and annoyances accepted. The wise man therefore always holds in these matters to this principle of selection: he rejects pleasures to secure other greater pleasures, or else he endures pains to avoid worse pains.\"</p>', 'en'),
(4, 4, 'GDPR compliance', 'gdpr-compliance', '<p style=\"font-size:12.88px;\">The standard Lorem Ipsum passage, used since the 1500s</p><p style=\"font-size:12.88px;\">\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"</p><p style=\"font-size:12.88px;\"><br /></p><p style=\"font-size:12.88px;\">Section 1.10.32 of \"de Finibus Bonorum et Malorum\", written by Cicero in 45 BC</p><p style=\"font-size:12.88px;\">\"Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?\"</p><p style=\"font-size:12.88px;\"><br /></p><p style=\"font-size:12.88px;\">1914 translation by H. Rackham</p><p style=\"font-size:12.88px;\">\"But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it? But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that produces no resultant pleasure?\"</p><p style=\"font-size:12.88px;\"><br /></p><p style=\"font-size:12.88px;\"><span style=\"font-size:.805rem;\">Section 1.10.33 of \"de Finibus Bonorum et Malorum\", written by Cicero in 45 BC</span><br /></p><p style=\"font-size:12.88px;\">\"At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.\"</p><p style=\"font-size:12.88px;\"><br /></p><p style=\"font-size:12.88px;\">1914 translation by H. Rackham</p><p style=\"font-size:12.88px;\">\"On the other hand, we denounce with righteous indignation and dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, so blinded by desire, that they cannot foresee the pain and trouble that are bound to ensue; and equal blame belongs to those who fail in their duty through weakness of will, which is the same as saying through shrinking from toil and pain. These cases are perfectly simple and easy to distinguish. In a free hour, when our power of choice is untrammelled and when nothing prevents our being able to do what we like best, every pleasure is to be welcomed and every pain avoided. But in certain circumstances and owing to the claims of duty or the obligations of business it will frequently occur that pleasures have to be repudiated and annoyances accepted. The wise man therefore always holds in these matters to this principle of selection: he rejects pleasures to secure other greater pleasures, or else he endures pains to avoid worse pains.\"</p>', 'en'),
(5, 5, 'Pricing and fees', 'pricing-and-fees', '<p style=\"font-size:12.88px;\">The standard Lorem Ipsum passage, used since the 1500s</p><p style=\"font-size:12.88px;\">\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"</p><p style=\"font-size:12.88px;\"><br /></p><p style=\"font-size:12.88px;\">Section 1.10.32 of \"de Finibus Bonorum et Malorum\", written by Cicero in 45 BC</p><p style=\"font-size:12.88px;\">\"Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?\"</p><p style=\"font-size:12.88px;\"><br /></p><p style=\"font-size:12.88px;\">1914 translation by H. Rackham</p><p style=\"font-size:12.88px;\">\"But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it? But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that produces no resultant pleasure?\"</p><p style=\"font-size:12.88px;\"><br /></p><p style=\"font-size:12.88px;\"><span style=\"font-size:.805rem;\">Section 1.10.33 of \"de Finibus Bonorum et Malorum\", written by Cicero in 45 BC</span><br /></p><p style=\"font-size:12.88px;\">\"At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.\"</p><p style=\"font-size:12.88px;\"><br /></p><p style=\"font-size:12.88px;\">1914 translation by H. Rackham</p><p style=\"font-size:12.88px;\">\"On the other hand, we denounce with righteous indignation and dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, so blinded by desire, that they cannot foresee the pain and trouble that are bound to ensue; and equal blame belongs to those who fail in their duty through weakness of will, which is the same as saying through shrinking from toil and pain. These cases are perfectly simple and easy to distinguish. In a free hour, when our power of choice is untrammelled and when nothing prevents our being able to do what we like best, every pleasure is to be welcomed and every pain avoided. But in certain circumstances and owing to the claims of duty or the obligations of business it will frequently occur that pleasures have to be repudiated and annoyances accepted. The wise man therefore always holds in these matters to this principle of selection: he rejects pleasures to secure other greater pleasures, or else he endures pains to avoid worse pains.\"</p>', 'en'),
(6, 6, 'About us', 'about-us', '<p style=\"font-size:12.88px;\">The standard Lorem Ipsum passage, used since the 1500s</p><p style=\"font-size:12.88px;\">\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"</p><p style=\"font-size:12.88px;\"><br /></p><p style=\"font-size:12.88px;\">Section 1.10.32 of \"de Finibus Bonorum et Malorum\", written by Cicero in 45 BC</p><p style=\"font-size:12.88px;\">\"Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?\"</p><p style=\"font-size:12.88px;\"><br /></p><p style=\"font-size:12.88px;\">1914 translation by H. Rackham</p><p style=\"font-size:12.88px;\">\"But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it? But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that produces no resultant pleasure?\"</p><p style=\"font-size:12.88px;\"><br /></p><p style=\"font-size:12.88px;\"><span style=\"font-size:.805rem;\">Section 1.10.33 of \"de Finibus Bonorum et Malorum\", written by Cicero in 45 BC</span><br /></p><p style=\"font-size:12.88px;\">\"At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.\"</p><p style=\"font-size:12.88px;\"><br /></p><p style=\"font-size:12.88px;\">1914 translation by H. Rackham</p><p style=\"font-size:12.88px;\">\"On the other hand, we denounce with righteous indignation and dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, so blinded by desire, that they cannot foresee the pain and trouble that are bound to ensue; and equal blame belongs to those who fail in their duty through weakness of will, which is the same as saying through shrinking from toil and pain. These cases are perfectly simple and easy to distinguish. In a free hour, when our power of choice is untrammelled and when nothing prevents our being able to do what we like best, every pleasure is to be welcomed and every pain avoided. But in certain circumstances and owing to the claims of duty or the obligations of business it will frequently occur that pleasures have to be repudiated and annoyances accepted. The wise man therefore always holds in these matters to this principle of selection: he rejects pleasures to secure other greater pleasures, or else he endures pains to avoid worse pains.\"</p>', 'en'),
(7, 1, 'Conditions d\'utilisation', 'conditions-dutilisation', '<p>Le passage de Lorem Ipsum standard, utilisé depuis 1500</p><p>Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l\'imprimerie depuis les années 1500, quand un imprimeur anonyme assembla ensemble des morceaux de texte pour réaliser un livre spécimen de polices de texte. Il n\'a pas fait que survivre cinq siècles, mais s\'est aussi adapté à la bureautique informatique, sans que son contenu n\'en soit modifié. Il a été popularisé dans les années 1960 grâce à la vente de feuilles Letraset contenant des passages du Lorem Ipsum, et, plus récemment, par son inclusion dans des applications de mise en page de texte, comme Aldus PageMaker.</p><p><br /></p><p>Section 1.10.32 du \"De Finibus Bonorum et Malorum\" de Ciceron (45 av. J.-C.)</p><p>On sait depuis longtemps que travailler avec du texte lisible et contenant du sens est source de distractions, et empêche de se concentrer sur la mise en page elle-même. L\'avantage du Lorem Ipsum sur un texte générique comme \'Du texte. Du texte. Du texte.\' est qu\'il possède une distribution de lettres plus ou moins normale, et en tout cas comparable avec celle du français standard. De nombreuses suites logicielles de mise en page ou éditeurs de sites Web ont fait du Lorem Ipsum leur faux texte par défaut, et une recherche pour \'Lorem Ipsum\' vous conduira vers de nombreux sites qui n\'en sont encore qu\'à leur phase de construction. Plusieurs versions sont apparues avec le temps, parfois par accident, souvent intentionnellement (histoire d\'y rajouter de petits clins d\'oeil, voire des phrases embarassantes).</p><p><span style=\"font-size:.805rem;\"><br /></span></p><p><span style=\"font-size:.805rem;\">Traduction de H. Rackham (1914)</span><br /></p><p>Contrairement à une opinion répandue, le Lorem Ipsum n\'est pas simplement du texte aléatoire. Il trouve ses racines dans une oeuvre de la littérature latine classique datant de 45 av. J.-C., le rendant vieux de 2000 ans. Un professeur du Hampden-Sydney College, en Virginie, s\'est intéressé à un des mots latins les plus obscurs, consectetur, extrait d\'un passage du Lorem Ipsum, et en étudiant tous les usages de ce mot dans la littérature classique, découvrit la source incontestable du Lorem Ipsum. Il provient en fait des sections 1.10.32 et 1.10.33 du \"De Finibus Bonorum et Malorum\" (Des Suprêmes Biens et des Suprêmes Maux) de Cicéron. Cet ouvrage, très populaire pendant la Renaissance, est un traité sur la théorie de l\'éthique. Les premières lignes du Lorem Ipsum, \"Lorem ipsum dolor sit amet...\", proviennent de la section 1.10.32.</p><p><br /></p><p>Section 1.10.33 du \"De Finibus Bonorum et Malorum\" de Ciceron (45 av. J.-C.)</p><p>Plusieurs variations de Lorem Ipsum peuvent être trouvées ici ou là, mais la majeure partie d\'entre elles a été altérée par l\'addition d\'humour ou de mots aléatoires qui ne ressemblent pas une seconde à du texte standard. Si vous voulez utiliser un passage du Lorem Ipsum, vous devez être sûr qu\'il n\'y a rien d\'embarrassant caché dans le texte. Tous les générateurs de Lorem Ipsum sur Internet tendent à reproduire le même extrait sans fin, ce qui fait de lipsum.com le seul vrai générateur de Lorem Ipsum. Iil utilise un dictionnaire de plus de 200 mots latins, en combinaison de plusieurs structures de phrases, pour générer un Lorem Ipsum irréprochable. Le Lorem Ipsum ainsi obtenu ne contient aucune répétition, ni ne contient des mots farfelus, ou des touches d\'humour.</p>', 'fr'),
(8, 1, 'شروط الخدمة', 'شروط-الخدمة', '<p style=\"text-align:right;\">نص لوريم إيبسوم القياسي والمستخدم منذ القرن الخامس عشر</p><p style=\"text-align:right;\">لوريم إيبسوم(Lorem Ipsum) هو ببساطة نص شكلي (بمعنى أن الغاية هي الشكل وليس المحتوى) ويُستخدم في صناعات المطابع ودور النشر. كان لوريم إيبسوم ولايزال المعيار للنص الشكلي منذ القرن الخامس عشر عندما قامت مطبعة مجهولة برص مجموعة من الأحرف بشكل عشوائي أخذتها من نص، لتكوّن كتيّب بمثابة دليل أو مرجع شكلي لهذه الأحرف. خمسة قرون من الزمن لم تقضي على هذا النص، بل انه حتى صار مستخدماً وبشكله الأصلي في الطباعة والتنضيد الإلكتروني. انتشر بشكل كبير في ستينيّات هذا القرن مع إصدار رقائق \"ليتراسيت\" (Letraset) البلاستيكية تحوي مقاطع من هذا النص، وعاد لينتشر مرة أخرى مؤخراَ مع ظهور برامج النشر الإلكتروني مثل \"ألدوس بايج مايكر\" (Aldus PageMaker) والتي حوت أيضاً على نسخ من نص لوريم إيبسوم.</p><p style=\"text-align:right;\"><br /></p><p style=\"text-align:right;\">القسم 1.10.32 من \"حول أقاصي الخير والشر\" (de Finibus Bonorum et Malorum) لمؤلفه شيشيرون (Cicero) في سنة 45 قبل الميلاد</p><p style=\"text-align:right;\">هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي للنص أو شكل توضع الفقرات في الصفحة التي يقرأها. ولذلك يتم استخدام طريقة لوريم إيبسوم لأنها تعطي توزيعاَ طبيعياَ -إلى حد ما- للأحرف عوضاً عن استخدام \"هنا يوجد محتوى نصي، هنا يوجد محتوى نصي\" فتجعلها تبدو (أي الأحرف) وكأنها نص مقروء. العديد من برامح النشر المكتبي وبرامح تحرير صفحات الويب تستخدم لوريم إيبسوم بشكل إفتراضي كنموذج عن النص، وإذا قمت بإدخال \"lorem ipsum\" في أي محرك بحث ستظهر العديد من المواقع الحديثة العهد في نتائج البحث. على مدى السنين ظهرت نسخ جديدة ومختلفة من نص لوريم إيبسوم، أحياناً عن طريق الصدفة، وأحياناً عن عمد كإدخال بعض العبارات الفكاهية إليها.</p><p style=\"text-align:right;\"><br /></p><p style=\"text-align:right;\"><span style=\"font-size:.805rem;\">ترجمة هـ. راكهام (H. Rackham) في عام 1914</span><br /></p><p style=\"text-align:right;\">خلافاَ للإعتقاد السائد فإن لوريم إيبسوم ليس نصاَ عشوائياً، بل إن له جذور في الأدب اللاتيني الكلاسيكي منذ العام 45 قبل الميلاد، مما يجعله أكثر من 2000 عام في القدم. قام البروفيسور \"ريتشارد ماك لينتوك\" (Richard McClintock) وهو بروفيسور اللغة اللاتينية في جامعة هامبدن-سيدني في فيرجينيا بالبحث عن أصول كلمة لاتينية غامضة في نص لوريم إيبسوم وهي \"consectetur\"، وخلال تتبعه لهذه الكلمة في الأدب اللاتيني اكتشف المصدر الغير قابل للشك. فلقد اتضح أن كلمات نص لوريم إيبسوم تأتي من الأقسام 1.10.32 و 1.10.33 من كتاب \"حول أقاصي الخير والشر\" (de Finibus Bonorum et Malorum) للمفكر شيشيرون (Cicero) والذي كتبه في عام 45 قبل الميلاد. هذا الكتاب هو بمثابة مقالة علمية مطولة في نظرية الأخلاق، وكان له شعبية كبيرة في عصر النهضة. السطر الأول من لوريم إيبسوم \"Lorem ipsum dolor sit amet..\" يأتي من سطر في القسم 1.20.32 من هذا الكتاب.</p><p style=\"text-align:right;\"><br /></p><p style=\"text-align:right;\">القسم 1.10.33 من \"حول أقاصي الخير والشر\" (de Finibus Bonorum et Malorum) لمؤلفه شيشيرون (Cicero) في سنة 45 قبل الميلاد</p><p style=\"text-align:right;\">هنالك العديد من الأنواع المتوفرة لنصوص لوريم إيبسوم، ولكن الغالبية تم تعديلها بشكل ما عبر إدخال بعض النوادر أو الكلمات العشوائية إلى النص. إن كنت تريد أن تستخدم نص لوريم إيبسوم ما، عليك أن تتحقق أولاً أن ليس هناك أي كلمات أو عبارات محرجة أو غير لائقة مخبأة في هذا النص. بينما تعمل جميع مولّدات نصوص لوريم إيبسوم على الإنترنت على إعادة تكرار مقاطع من نص لوريم إيبسوم نفسه عدة مرات بما تتطلبه الحاجة، يقوم مولّدنا هذا باستخدام كلمات من قاموس يحوي على أكثر من 200 كلمة لا تينية، مضاف إليها مجموعة من الجمل النموذجية، لتكوين نص لوريم إيبسوم ذو شكل منطقي قريب إلى النص الحقيقي. وبالتالي يكون النص الناتح خالي من التكرار، أو أي كلمات أو عبارات غير لائقة أو ما شابه. وهذا ما يجعله أول مولّد نص لوريم إيبسوم حقيقي على الإنترنت.</p><div style=\"text-align:right;\"><br /></div>', 'ar'),
(9, 2, 'Politique de confidentialité', 'politique-de-confidentialite', '<p style=\"font-size:12.88px;\">Le passage de Lorem Ipsum standard, utilisé depuis 1500</p><p style=\"font-size:12.88px;\">Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l\'imprimerie depuis les années 1500, quand un imprimeur anonyme assembla ensemble des morceaux de texte pour réaliser un livre spécimen de polices de texte. Il n\'a pas fait que survivre cinq siècles, mais s\'est aussi adapté à la bureautique informatique, sans que son contenu n\'en soit modifié. Il a été popularisé dans les années 1960 grâce à la vente de feuilles Letraset contenant des passages du Lorem Ipsum, et, plus récemment, par son inclusion dans des applications de mise en page de texte, comme Aldus PageMaker.</p><p style=\"font-size:12.88px;\"><br /></p><p style=\"font-size:12.88px;\">Section 1.10.32 du \"De Finibus Bonorum et Malorum\" de Ciceron (45 av. J.-C.)</p><p style=\"font-size:12.88px;\">On sait depuis longtemps que travailler avec du texte lisible et contenant du sens est source de distractions, et empêche de se concentrer sur la mise en page elle-même. L\'avantage du Lorem Ipsum sur un texte générique comme \'Du texte. Du texte. Du texte.\' est qu\'il possède une distribution de lettres plus ou moins normale, et en tout cas comparable avec celle du français standard. De nombreuses suites logicielles de mise en page ou éditeurs de sites Web ont fait du Lorem Ipsum leur faux texte par défaut, et une recherche pour \'Lorem Ipsum\' vous conduira vers de nombreux sites qui n\'en sont encore qu\'à leur phase de construction. Plusieurs versions sont apparues avec le temps, parfois par accident, souvent intentionnellement (histoire d\'y rajouter de petits clins d\'oeil, voire des phrases embarassantes).</p><p style=\"font-size:12.88px;\"><span style=\"font-size:.805rem;\"><br /></span></p><p style=\"font-size:12.88px;\"><span style=\"font-size:.805rem;\">Traduction de H. Rackham (1914)</span><br /></p><p style=\"font-size:12.88px;\">Contrairement à une opinion répandue, le Lorem Ipsum n\'est pas simplement du texte aléatoire. Il trouve ses racines dans une oeuvre de la littérature latine classique datant de 45 av. J.-C., le rendant vieux de 2000 ans. Un professeur du Hampden-Sydney College, en Virginie, s\'est intéressé à un des mots latins les plus obscurs, consectetur, extrait d\'un passage du Lorem Ipsum, et en étudiant tous les usages de ce mot dans la littérature classique, découvrit la source incontestable du Lorem Ipsum. Il provient en fait des sections 1.10.32 et 1.10.33 du \"De Finibus Bonorum et Malorum\" (Des Suprêmes Biens et des Suprêmes Maux) de Cicéron. Cet ouvrage, très populaire pendant la Renaissance, est un traité sur la théorie de l\'éthique. Les premières lignes du Lorem Ipsum, \"Lorem ipsum dolor sit amet...\", proviennent de la section 1.10.32.</p><p style=\"font-size:12.88px;\"><br /></p><p style=\"font-size:12.88px;\">Section 1.10.33 du \"De Finibus Bonorum et Malorum\" de Ciceron (45 av. J.-C.)</p><p style=\"font-size:12.88px;\">Plusieurs variations de Lorem Ipsum peuvent être trouvées ici ou là, mais la majeure partie d\'entre elles a été altérée par l\'addition d\'humour ou de mots aléatoires qui ne ressemblent pas une seconde à du texte standard. Si vous voulez utiliser un passage du Lorem Ipsum, vous devez être sûr qu\'il n\'y a rien d\'embarrassant caché dans le texte. Tous les générateurs de Lorem Ipsum sur Internet tendent à reproduire le même extrait sans fin, ce qui fait de lipsum.com le seul vrai générateur de Lorem Ipsum. Iil utilise un dictionnaire de plus de 200 mots latins, en combinaison de plusieurs structures de phrases, pour générer un Lorem Ipsum irréprochable. Le Lorem Ipsum ainsi obtenu ne contient aucune répétition, ni ne contient des mots farfelus, ou des touches d\'humour.</p>', 'fr'),
(10, 2, 'سياسة الخصوصية', 'سياسة-الخصوصية', '<p style=\"text-align:right;\">نص لوريم إيبسوم القياسي والمستخدم منذ القرن الخامس عشر</p><p style=\"text-align:right;\">لوريم إيبسوم(Lorem Ipsum) هو ببساطة نص شكلي (بمعنى أن الغاية هي الشكل وليس المحتوى) ويُستخدم في صناعات المطابع ودور النشر. كان لوريم إيبسوم ولايزال المعيار للنص الشكلي منذ القرن الخامس عشر عندما قامت مطبعة مجهولة برص مجموعة من الأحرف بشكل عشوائي أخذتها من نص، لتكوّن كتيّب بمثابة دليل أو مرجع شكلي لهذه الأحرف. خمسة قرون من الزمن لم تقضي على هذا النص، بل انه حتى صار مستخدماً وبشكله الأصلي في الطباعة والتنضيد الإلكتروني. انتشر بشكل كبير في ستينيّات هذا القرن مع إصدار رقائق \"ليتراسيت\" (Letraset) البلاستيكية تحوي مقاطع من هذا النص، وعاد لينتشر مرة أخرى مؤخراَ مع ظهور برامج النشر الإلكتروني مثل \"ألدوس بايج مايكر\" (Aldus PageMaker) والتي حوت أيضاً على نسخ من نص لوريم إيبسوم.</p><p style=\"text-align:right;\"><br /></p><p style=\"text-align:right;\">القسم 1.10.32 من \"حول أقاصي الخير والشر\" (de Finibus Bonorum et Malorum) لمؤلفه شيشيرون (Cicero) في سنة 45 قبل الميلاد</p><p style=\"text-align:right;\">هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي للنص أو شكل توضع الفقرات في الصفحة التي يقرأها. ولذلك يتم استخدام طريقة لوريم إيبسوم لأنها تعطي توزيعاَ طبيعياَ -إلى حد ما- للأحرف عوضاً عن استخدام \"هنا يوجد محتوى نصي، هنا يوجد محتوى نصي\" فتجعلها تبدو (أي الأحرف) وكأنها نص مقروء. العديد من برامح النشر المكتبي وبرامح تحرير صفحات الويب تستخدم لوريم إيبسوم بشكل إفتراضي كنموذج عن النص، وإذا قمت بإدخال \"lorem ipsum\" في أي محرك بحث ستظهر العديد من المواقع الحديثة العهد في نتائج البحث. على مدى السنين ظهرت نسخ جديدة ومختلفة من نص لوريم إيبسوم، أحياناً عن طريق الصدفة، وأحياناً عن عمد كإدخال بعض العبارات الفكاهية إليها.</p><p style=\"text-align:right;\"><br /></p><p style=\"text-align:right;\"><span style=\"font-size:.805rem;\">ترجمة هـ. راكهام (H. Rackham) في عام 1914</span><br /></p><p style=\"text-align:right;\">خلافاَ للإعتقاد السائد فإن لوريم إيبسوم ليس نصاَ عشوائياً، بل إن له جذور في الأدب اللاتيني الكلاسيكي منذ العام 45 قبل الميلاد، مما يجعله أكثر من 2000 عام في القدم. قام البروفيسور \"ريتشارد ماك لينتوك\" (Richard McClintock) وهو بروفيسور اللغة اللاتينية في جامعة هامبدن-سيدني في فيرجينيا بالبحث عن أصول كلمة لاتينية غامضة في نص لوريم إيبسوم وهي \"consectetur\"، وخلال تتبعه لهذه الكلمة في الأدب اللاتيني اكتشف المصدر الغير قابل للشك. فلقد اتضح أن كلمات نص لوريم إيبسوم تأتي من الأقسام 1.10.32 و 1.10.33 من كتاب \"حول أقاصي الخير والشر\" (de Finibus Bonorum et Malorum) للمفكر شيشيرون (Cicero) والذي كتبه في عام 45 قبل الميلاد. هذا الكتاب هو بمثابة مقالة علمية مطولة في نظرية الأخلاق، وكان له شعبية كبيرة في عصر النهضة. السطر الأول من لوريم إيبسوم \"Lorem ipsum dolor sit amet..\" يأتي من سطر في القسم 1.20.32 من هذا الكتاب.</p><p style=\"text-align:right;\"><br /></p><p style=\"text-align:right;\">القسم 1.10.33 من \"حول أقاصي الخير والشر\" (de Finibus Bonorum et Malorum) لمؤلفه شيشيرون (Cicero) في سنة 45 قبل الميلاد</p><p style=\"text-align:right;\">هنالك العديد من الأنواع المتوفرة لنصوص لوريم إيبسوم، ولكن الغالبية تم تعديلها بشكل ما عبر إدخال بعض النوادر أو الكلمات العشوائية إلى النص. إن كنت تريد أن تستخدم نص لوريم إيبسوم ما، عليك أن تتحقق أولاً أن ليس هناك أي كلمات أو عبارات محرجة أو غير لائقة مخبأة في هذا النص. بينما تعمل جميع مولّدات نصوص لوريم إيبسوم على الإنترنت على إعادة تكرار مقاطع من نص لوريم إيبسوم نفسه عدة مرات بما تتطلبه الحاجة، يقوم مولّدنا هذا باستخدام كلمات من قاموس يحوي على أكثر من 200 كلمة لا تينية، مضاف إليها مجموعة من الجمل النموذجية، لتكوين نص لوريم إيبسوم ذو شكل منطقي قريب إلى النص الحقيقي. وبالتالي يكون النص الناتح خالي من التكرار، أو أي كلمات أو عبارات غير لائقة أو ما شابه. وهذا ما يجعله أول مولّد نص لوريم إيبسوم حقيقي على الإنترنت.</p><div style=\"text-align:right;\"><br style=\"font-size:12.88px;\" /></div>', 'ar'),
(11, 3, 'Politique relative aux cookies', 'politique-relative-aux-cookies', '<p style=\"font-size:12.88px;\">Le passage de Lorem Ipsum standard, utilisé depuis 1500</p><p style=\"font-size:12.88px;\">Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l\'imprimerie depuis les années 1500, quand un imprimeur anonyme assembla ensemble des morceaux de texte pour réaliser un livre spécimen de polices de texte. Il n\'a pas fait que survivre cinq siècles, mais s\'est aussi adapté à la bureautique informatique, sans que son contenu n\'en soit modifié. Il a été popularisé dans les années 1960 grâce à la vente de feuilles Letraset contenant des passages du Lorem Ipsum, et, plus récemment, par son inclusion dans des applications de mise en page de texte, comme Aldus PageMaker.</p><p style=\"font-size:12.88px;\"><br /></p><p style=\"font-size:12.88px;\">Section 1.10.32 du \"De Finibus Bonorum et Malorum\" de Ciceron (45 av. J.-C.)</p><p style=\"font-size:12.88px;\">On sait depuis longtemps que travailler avec du texte lisible et contenant du sens est source de distractions, et empêche de se concentrer sur la mise en page elle-même. L\'avantage du Lorem Ipsum sur un texte générique comme \'Du texte. Du texte. Du texte.\' est qu\'il possède une distribution de lettres plus ou moins normale, et en tout cas comparable avec celle du français standard. De nombreuses suites logicielles de mise en page ou éditeurs de sites Web ont fait du Lorem Ipsum leur faux texte par défaut, et une recherche pour \'Lorem Ipsum\' vous conduira vers de nombreux sites qui n\'en sont encore qu\'à leur phase de construction. Plusieurs versions sont apparues avec le temps, parfois par accident, souvent intentionnellement (histoire d\'y rajouter de petits clins d\'oeil, voire des phrases embarassantes).</p><p style=\"font-size:12.88px;\"><span style=\"font-size:.805rem;\"><br /></span></p><p style=\"font-size:12.88px;\"><span style=\"font-size:.805rem;\">Traduction de H. Rackham (1914)</span><br /></p><p style=\"font-size:12.88px;\">Contrairement à une opinion répandue, le Lorem Ipsum n\'est pas simplement du texte aléatoire. Il trouve ses racines dans une oeuvre de la littérature latine classique datant de 45 av. J.-C., le rendant vieux de 2000 ans. Un professeur du Hampden-Sydney College, en Virginie, s\'est intéressé à un des mots latins les plus obscurs, consectetur, extrait d\'un passage du Lorem Ipsum, et en étudiant tous les usages de ce mot dans la littérature classique, découvrit la source incontestable du Lorem Ipsum. Il provient en fait des sections 1.10.32 et 1.10.33 du \"De Finibus Bonorum et Malorum\" (Des Suprêmes Biens et des Suprêmes Maux) de Cicéron. Cet ouvrage, très populaire pendant la Renaissance, est un traité sur la théorie de l\'éthique. Les premières lignes du Lorem Ipsum, \"Lorem ipsum dolor sit amet...\", proviennent de la section 1.10.32.</p><p style=\"font-size:12.88px;\"><br /></p><p style=\"font-size:12.88px;\">Section 1.10.33 du \"De Finibus Bonorum et Malorum\" de Ciceron (45 av. J.-C.)</p><p style=\"font-size:12.88px;\">Plusieurs variations de Lorem Ipsum peuvent être trouvées ici ou là, mais la majeure partie d\'entre elles a été altérée par l\'addition d\'humour ou de mots aléatoires qui ne ressemblent pas une seconde à du texte standard. Si vous voulez utiliser un passage du Lorem Ipsum, vous devez être sûr qu\'il n\'y a rien d\'embarrassant caché dans le texte. Tous les générateurs de Lorem Ipsum sur Internet tendent à reproduire le même extrait sans fin, ce qui fait de lipsum.com le seul vrai générateur de Lorem Ipsum. Iil utilise un dictionnaire de plus de 200 mots latins, en combinaison de plusieurs structures de phrases, pour générer un Lorem Ipsum irréprochable. Le Lorem Ipsum ainsi obtenu ne contient aucune répétition, ni ne contient des mots farfelus, ou des touches d\'humour.</p>', 'fr');
INSERT INTO `eventic_page_translation` (`id`, `translatable_id`, `title`, `slug`, `content`, `locale`) VALUES
(12, 3, 'سياسة ملفات الارتباط', 'سياسة-ملفات-الارتباط', '<p style=\"text-align:right;\">نص لوريم إيبسوم القياسي والمستخدم منذ القرن الخامس عشر</p><p style=\"text-align:right;\">لوريم إيبسوم(Lorem Ipsum) هو ببساطة نص شكلي (بمعنى أن الغاية هي الشكل وليس المحتوى) ويُستخدم في صناعات المطابع ودور النشر. كان لوريم إيبسوم ولايزال المعيار للنص الشكلي منذ القرن الخامس عشر عندما قامت مطبعة مجهولة برص مجموعة من الأحرف بشكل عشوائي أخذتها من نص، لتكوّن كتيّب بمثابة دليل أو مرجع شكلي لهذه الأحرف. خمسة قرون من الزمن لم تقضي على هذا النص، بل انه حتى صار مستخدماً وبشكله الأصلي في الطباعة والتنضيد الإلكتروني. انتشر بشكل كبير في ستينيّات هذا القرن مع إصدار رقائق \"ليتراسيت\" (Letraset) البلاستيكية تحوي مقاطع من هذا النص، وعاد لينتشر مرة أخرى مؤخراَ مع ظهور برامج النشر الإلكتروني مثل \"ألدوس بايج مايكر\" (Aldus PageMaker) والتي حوت أيضاً على نسخ من نص لوريم إيبسوم.</p><p style=\"text-align:right;\"><br /></p><p style=\"text-align:right;\">القسم 1.10.32 من \"حول أقاصي الخير والشر\" (de Finibus Bonorum et Malorum) لمؤلفه شيشيرون (Cicero) في سنة 45 قبل الميلاد</p><p style=\"text-align:right;\">هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي للنص أو شكل توضع الفقرات في الصفحة التي يقرأها. ولذلك يتم استخدام طريقة لوريم إيبسوم لأنها تعطي توزيعاَ طبيعياَ -إلى حد ما- للأحرف عوضاً عن استخدام \"هنا يوجد محتوى نصي، هنا يوجد محتوى نصي\" فتجعلها تبدو (أي الأحرف) وكأنها نص مقروء. العديد من برامح النشر المكتبي وبرامح تحرير صفحات الويب تستخدم لوريم إيبسوم بشكل إفتراضي كنموذج عن النص، وإذا قمت بإدخال \"lorem ipsum\" في أي محرك بحث ستظهر العديد من المواقع الحديثة العهد في نتائج البحث. على مدى السنين ظهرت نسخ جديدة ومختلفة من نص لوريم إيبسوم، أحياناً عن طريق الصدفة، وأحياناً عن عمد كإدخال بعض العبارات الفكاهية إليها.</p><p style=\"text-align:right;\"><br /></p><p style=\"text-align:right;\"><span style=\"font-size:.805rem;\">ترجمة هـ. راكهام (H. Rackham) في عام 1914</span><br /></p><p style=\"text-align:right;\">خلافاَ للإعتقاد السائد فإن لوريم إيبسوم ليس نصاَ عشوائياً، بل إن له جذور في الأدب اللاتيني الكلاسيكي منذ العام 45 قبل الميلاد، مما يجعله أكثر من 2000 عام في القدم. قام البروفيسور \"ريتشارد ماك لينتوك\" (Richard McClintock) وهو بروفيسور اللغة اللاتينية في جامعة هامبدن-سيدني في فيرجينيا بالبحث عن أصول كلمة لاتينية غامضة في نص لوريم إيبسوم وهي \"consectetur\"، وخلال تتبعه لهذه الكلمة في الأدب اللاتيني اكتشف المصدر الغير قابل للشك. فلقد اتضح أن كلمات نص لوريم إيبسوم تأتي من الأقسام 1.10.32 و 1.10.33 من كتاب \"حول أقاصي الخير والشر\" (de Finibus Bonorum et Malorum) للمفكر شيشيرون (Cicero) والذي كتبه في عام 45 قبل الميلاد. هذا الكتاب هو بمثابة مقالة علمية مطولة في نظرية الأخلاق، وكان له شعبية كبيرة في عصر النهضة. السطر الأول من لوريم إيبسوم \"Lorem ipsum dolor sit amet..\" يأتي من سطر في القسم 1.20.32 من هذا الكتاب.</p><p style=\"text-align:right;\"><br /></p><p style=\"text-align:right;\">القسم 1.10.33 من \"حول أقاصي الخير والشر\" (de Finibus Bonorum et Malorum) لمؤلفه شيشيرون (Cicero) في سنة 45 قبل الميلاد</p><p style=\"text-align:right;\">هنالك العديد من الأنواع المتوفرة لنصوص لوريم إيبسوم، ولكن الغالبية تم تعديلها بشكل ما عبر إدخال بعض النوادر أو الكلمات العشوائية إلى النص. إن كنت تريد أن تستخدم نص لوريم إيبسوم ما، عليك أن تتحقق أولاً أن ليس هناك أي كلمات أو عبارات محرجة أو غير لائقة مخبأة في هذا النص. بينما تعمل جميع مولّدات نصوص لوريم إيبسوم على الإنترنت على إعادة تكرار مقاطع من نص لوريم إيبسوم نفسه عدة مرات بما تتطلبه الحاجة، يقوم مولّدنا هذا باستخدام كلمات من قاموس يحوي على أكثر من 200 كلمة لا تينية، مضاف إليها مجموعة من الجمل النموذجية، لتكوين نص لوريم إيبسوم ذو شكل منطقي قريب إلى النص الحقيقي. وبالتالي يكون النص الناتح خالي من التكرار، أو أي كلمات أو عبارات غير لائقة أو ما شابه. وهذا ما يجعله أول مولّد نص لوريم إيبسوم حقيقي على الإنترنت.</p><div style=\"text-align:right;\"><br style=\"font-size:12.88px;\" /></div>', 'ar'),
(13, 4, 'Conformité au RGPD', 'conformite-au-rgpd', '<p style=\"font-size:12.88px;\">Le passage de Lorem Ipsum standard, utilisé depuis 1500</p><p style=\"font-size:12.88px;\">Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l\'imprimerie depuis les années 1500, quand un imprimeur anonyme assembla ensemble des morceaux de texte pour réaliser un livre spécimen de polices de texte. Il n\'a pas fait que survivre cinq siècles, mais s\'est aussi adapté à la bureautique informatique, sans que son contenu n\'en soit modifié. Il a été popularisé dans les années 1960 grâce à la vente de feuilles Letraset contenant des passages du Lorem Ipsum, et, plus récemment, par son inclusion dans des applications de mise en page de texte, comme Aldus PageMaker.</p><p style=\"font-size:12.88px;\"><br /></p><p style=\"font-size:12.88px;\">Section 1.10.32 du \"De Finibus Bonorum et Malorum\" de Ciceron (45 av. J.-C.)</p><p style=\"font-size:12.88px;\">On sait depuis longtemps que travailler avec du texte lisible et contenant du sens est source de distractions, et empêche de se concentrer sur la mise en page elle-même. L\'avantage du Lorem Ipsum sur un texte générique comme \'Du texte. Du texte. Du texte.\' est qu\'il possède une distribution de lettres plus ou moins normale, et en tout cas comparable avec celle du français standard. De nombreuses suites logicielles de mise en page ou éditeurs de sites Web ont fait du Lorem Ipsum leur faux texte par défaut, et une recherche pour \'Lorem Ipsum\' vous conduira vers de nombreux sites qui n\'en sont encore qu\'à leur phase de construction. Plusieurs versions sont apparues avec le temps, parfois par accident, souvent intentionnellement (histoire d\'y rajouter de petits clins d\'oeil, voire des phrases embarassantes).</p><p style=\"font-size:12.88px;\"><span style=\"font-size:.805rem;\"><br /></span></p><p style=\"font-size:12.88px;\"><span style=\"font-size:.805rem;\">Traduction de H. Rackham (1914)</span><br /></p><p style=\"font-size:12.88px;\">Contrairement à une opinion répandue, le Lorem Ipsum n\'est pas simplement du texte aléatoire. Il trouve ses racines dans une oeuvre de la littérature latine classique datant de 45 av. J.-C., le rendant vieux de 2000 ans. Un professeur du Hampden-Sydney College, en Virginie, s\'est intéressé à un des mots latins les plus obscurs, consectetur, extrait d\'un passage du Lorem Ipsum, et en étudiant tous les usages de ce mot dans la littérature classique, découvrit la source incontestable du Lorem Ipsum. Il provient en fait des sections 1.10.32 et 1.10.33 du \"De Finibus Bonorum et Malorum\" (Des Suprêmes Biens et des Suprêmes Maux) de Cicéron. Cet ouvrage, très populaire pendant la Renaissance, est un traité sur la théorie de l\'éthique. Les premières lignes du Lorem Ipsum, \"Lorem ipsum dolor sit amet...\", proviennent de la section 1.10.32.</p><p style=\"font-size:12.88px;\"><br /></p><p style=\"font-size:12.88px;\">Section 1.10.33 du \"De Finibus Bonorum et Malorum\" de Ciceron (45 av. J.-C.)</p><p style=\"font-size:12.88px;\">Plusieurs variations de Lorem Ipsum peuvent être trouvées ici ou là, mais la majeure partie d\'entre elles a été altérée par l\'addition d\'humour ou de mots aléatoires qui ne ressemblent pas une seconde à du texte standard. Si vous voulez utiliser un passage du Lorem Ipsum, vous devez être sûr qu\'il n\'y a rien d\'embarrassant caché dans le texte. Tous les générateurs de Lorem Ipsum sur Internet tendent à reproduire le même extrait sans fin, ce qui fait de lipsum.com le seul vrai générateur de Lorem Ipsum. Iil utilise un dictionnaire de plus de 200 mots latins, en combinaison de plusieurs structures de phrases, pour générer un Lorem Ipsum irréprochable. Le Lorem Ipsum ainsi obtenu ne contient aucune répétition, ni ne contient des mots farfelus, ou des touches d\'humour.</p>', 'fr'),
(14, 4, 'الامتثال للقانون العام لحماية البيا', 'الامتثال-للقانون-العام-لحماية-البيا', '<p style=\"text-align:right;\">نص لوريم إيبسوم القياسي والمستخدم منذ القرن الخامس عشر</p><p style=\"text-align:right;\">لوريم إيبسوم(Lorem Ipsum) هو ببساطة نص شكلي (بمعنى أن الغاية هي الشكل وليس المحتوى) ويُستخدم في صناعات المطابع ودور النشر. كان لوريم إيبسوم ولايزال المعيار للنص الشكلي منذ القرن الخامس عشر عندما قامت مطبعة مجهولة برص مجموعة من الأحرف بشكل عشوائي أخذتها من نص، لتكوّن كتيّب بمثابة دليل أو مرجع شكلي لهذه الأحرف. خمسة قرون من الزمن لم تقضي على هذا النص، بل انه حتى صار مستخدماً وبشكله الأصلي في الطباعة والتنضيد الإلكتروني. انتشر بشكل كبير في ستينيّات هذا القرن مع إصدار رقائق \"ليتراسيت\" (Letraset) البلاستيكية تحوي مقاطع من هذا النص، وعاد لينتشر مرة أخرى مؤخراَ مع ظهور برامج النشر الإلكتروني مثل \"ألدوس بايج مايكر\" (Aldus PageMaker) والتي حوت أيضاً على نسخ من نص لوريم إيبسوم.</p><p style=\"text-align:right;\"><br /></p><p style=\"text-align:right;\">القسم 1.10.32 من \"حول أقاصي الخير والشر\" (de Finibus Bonorum et Malorum) لمؤلفه شيشيرون (Cicero) في سنة 45 قبل الميلاد</p><p style=\"text-align:right;\">هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي للنص أو شكل توضع الفقرات في الصفحة التي يقرأها. ولذلك يتم استخدام طريقة لوريم إيبسوم لأنها تعطي توزيعاَ طبيعياَ -إلى حد ما- للأحرف عوضاً عن استخدام \"هنا يوجد محتوى نصي، هنا يوجد محتوى نصي\" فتجعلها تبدو (أي الأحرف) وكأنها نص مقروء. العديد من برامح النشر المكتبي وبرامح تحرير صفحات الويب تستخدم لوريم إيبسوم بشكل إفتراضي كنموذج عن النص، وإذا قمت بإدخال \"lorem ipsum\" في أي محرك بحث ستظهر العديد من المواقع الحديثة العهد في نتائج البحث. على مدى السنين ظهرت نسخ جديدة ومختلفة من نص لوريم إيبسوم، أحياناً عن طريق الصدفة، وأحياناً عن عمد كإدخال بعض العبارات الفكاهية إليها.</p><p style=\"text-align:right;\"><br /></p><p style=\"text-align:right;\"><span style=\"font-size:.805rem;\">ترجمة هـ. راكهام (H. Rackham) في عام 1914</span><br /></p><p style=\"text-align:right;\">خلافاَ للإعتقاد السائد فإن لوريم إيبسوم ليس نصاَ عشوائياً، بل إن له جذور في الأدب اللاتيني الكلاسيكي منذ العام 45 قبل الميلاد، مما يجعله أكثر من 2000 عام في القدم. قام البروفيسور \"ريتشارد ماك لينتوك\" (Richard McClintock) وهو بروفيسور اللغة اللاتينية في جامعة هامبدن-سيدني في فيرجينيا بالبحث عن أصول كلمة لاتينية غامضة في نص لوريم إيبسوم وهي \"consectetur\"، وخلال تتبعه لهذه الكلمة في الأدب اللاتيني اكتشف المصدر الغير قابل للشك. فلقد اتضح أن كلمات نص لوريم إيبسوم تأتي من الأقسام 1.10.32 و 1.10.33 من كتاب \"حول أقاصي الخير والشر\" (de Finibus Bonorum et Malorum) للمفكر شيشيرون (Cicero) والذي كتبه في عام 45 قبل الميلاد. هذا الكتاب هو بمثابة مقالة علمية مطولة في نظرية الأخلاق، وكان له شعبية كبيرة في عصر النهضة. السطر الأول من لوريم إيبسوم \"Lorem ipsum dolor sit amet..\" يأتي من سطر في القسم 1.20.32 من هذا الكتاب.</p><p style=\"text-align:right;\"><br /></p><p style=\"text-align:right;\">القسم 1.10.33 من \"حول أقاصي الخير والشر\" (de Finibus Bonorum et Malorum) لمؤلفه شيشيرون (Cicero) في سنة 45 قبل الميلاد</p><p style=\"text-align:right;\">هنالك العديد من الأنواع المتوفرة لنصوص لوريم إيبسوم، ولكن الغالبية تم تعديلها بشكل ما عبر إدخال بعض النوادر أو الكلمات العشوائية إلى النص. إن كنت تريد أن تستخدم نص لوريم إيبسوم ما، عليك أن تتحقق أولاً أن ليس هناك أي كلمات أو عبارات محرجة أو غير لائقة مخبأة في هذا النص. بينما تعمل جميع مولّدات نصوص لوريم إيبسوم على الإنترنت على إعادة تكرار مقاطع من نص لوريم إيبسوم نفسه عدة مرات بما تتطلبه الحاجة، يقوم مولّدنا هذا باستخدام كلمات من قاموس يحوي على أكثر من 200 كلمة لا تينية، مضاف إليها مجموعة من الجمل النموذجية، لتكوين نص لوريم إيبسوم ذو شكل منطقي قريب إلى النص الحقيقي. وبالتالي يكون النص الناتح خالي من التكرار، أو أي كلمات أو عبارات غير لائقة أو ما شابه. وهذا ما يجعله أول مولّد نص لوريم إيبسوم حقيقي على الإنترنت.</p><div style=\"text-align:right;\"><br style=\"font-size:12.88px;\" /></div>', 'ar'),
(15, 5, 'Prix et frais', 'prix-et-frais', '<p style=\"font-size:12.88px;\">Le passage de Lorem Ipsum standard, utilisé depuis 1500</p><p style=\"font-size:12.88px;\">Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l\'imprimerie depuis les années 1500, quand un imprimeur anonyme assembla ensemble des morceaux de texte pour réaliser un livre spécimen de polices de texte. Il n\'a pas fait que survivre cinq siècles, mais s\'est aussi adapté à la bureautique informatique, sans que son contenu n\'en soit modifié. Il a été popularisé dans les années 1960 grâce à la vente de feuilles Letraset contenant des passages du Lorem Ipsum, et, plus récemment, par son inclusion dans des applications de mise en page de texte, comme Aldus PageMaker.</p><p style=\"font-size:12.88px;\"><br /></p><p style=\"font-size:12.88px;\">Section 1.10.32 du \"De Finibus Bonorum et Malorum\" de Ciceron (45 av. J.-C.)</p><p style=\"font-size:12.88px;\">On sait depuis longtemps que travailler avec du texte lisible et contenant du sens est source de distractions, et empêche de se concentrer sur la mise en page elle-même. L\'avantage du Lorem Ipsum sur un texte générique comme \'Du texte. Du texte. Du texte.\' est qu\'il possède une distribution de lettres plus ou moins normale, et en tout cas comparable avec celle du français standard. De nombreuses suites logicielles de mise en page ou éditeurs de sites Web ont fait du Lorem Ipsum leur faux texte par défaut, et une recherche pour \'Lorem Ipsum\' vous conduira vers de nombreux sites qui n\'en sont encore qu\'à leur phase de construction. Plusieurs versions sont apparues avec le temps, parfois par accident, souvent intentionnellement (histoire d\'y rajouter de petits clins d\'oeil, voire des phrases embarassantes).</p><p style=\"font-size:12.88px;\"><span style=\"font-size:.805rem;\"><br /></span></p><p style=\"font-size:12.88px;\"><span style=\"font-size:.805rem;\">Traduction de H. Rackham (1914)</span><br /></p><p style=\"font-size:12.88px;\">Contrairement à une opinion répandue, le Lorem Ipsum n\'est pas simplement du texte aléatoire. Il trouve ses racines dans une oeuvre de la littérature latine classique datant de 45 av. J.-C., le rendant vieux de 2000 ans. Un professeur du Hampden-Sydney College, en Virginie, s\'est intéressé à un des mots latins les plus obscurs, consectetur, extrait d\'un passage du Lorem Ipsum, et en étudiant tous les usages de ce mot dans la littérature classique, découvrit la source incontestable du Lorem Ipsum. Il provient en fait des sections 1.10.32 et 1.10.33 du \"De Finibus Bonorum et Malorum\" (Des Suprêmes Biens et des Suprêmes Maux) de Cicéron. Cet ouvrage, très populaire pendant la Renaissance, est un traité sur la théorie de l\'éthique. Les premières lignes du Lorem Ipsum, \"Lorem ipsum dolor sit amet...\", proviennent de la section 1.10.32.</p><p style=\"font-size:12.88px;\"><br /></p><p style=\"font-size:12.88px;\">Section 1.10.33 du \"De Finibus Bonorum et Malorum\" de Ciceron (45 av. J.-C.)</p><p style=\"font-size:12.88px;\">Plusieurs variations de Lorem Ipsum peuvent être trouvées ici ou là, mais la majeure partie d\'entre elles a été altérée par l\'addition d\'humour ou de mots aléatoires qui ne ressemblent pas une seconde à du texte standard. Si vous voulez utiliser un passage du Lorem Ipsum, vous devez être sûr qu\'il n\'y a rien d\'embarrassant caché dans le texte. Tous les générateurs de Lorem Ipsum sur Internet tendent à reproduire le même extrait sans fin, ce qui fait de lipsum.com le seul vrai générateur de Lorem Ipsum. Iil utilise un dictionnaire de plus de 200 mots latins, en combinaison de plusieurs structures de phrases, pour générer un Lorem Ipsum irréprochable. Le Lorem Ipsum ainsi obtenu ne contient aucune répétition, ni ne contient des mots farfelus, ou des touches d\'humour.</p>', 'fr'),
(16, 5, 'التسعير والرسوم', 'التسعير-والرسوم', '<p style=\"text-align:right;\">نص لوريم إيبسوم القياسي والمستخدم منذ القرن الخامس عشر</p><p style=\"text-align:right;\">لوريم إيبسوم(Lorem Ipsum) هو ببساطة نص شكلي (بمعنى أن الغاية هي الشكل وليس المحتوى) ويُستخدم في صناعات المطابع ودور النشر. كان لوريم إيبسوم ولايزال المعيار للنص الشكلي منذ القرن الخامس عشر عندما قامت مطبعة مجهولة برص مجموعة من الأحرف بشكل عشوائي أخذتها من نص، لتكوّن كتيّب بمثابة دليل أو مرجع شكلي لهذه الأحرف. خمسة قرون من الزمن لم تقضي على هذا النص، بل انه حتى صار مستخدماً وبشكله الأصلي في الطباعة والتنضيد الإلكتروني. انتشر بشكل كبير في ستينيّات هذا القرن مع إصدار رقائق \"ليتراسيت\" (Letraset) البلاستيكية تحوي مقاطع من هذا النص، وعاد لينتشر مرة أخرى مؤخراَ مع ظهور برامج النشر الإلكتروني مثل \"ألدوس بايج مايكر\" (Aldus PageMaker) والتي حوت أيضاً على نسخ من نص لوريم إيبسوم.</p><p style=\"text-align:right;\"><br /></p><p style=\"text-align:right;\">القسم 1.10.32 من \"حول أقاصي الخير والشر\" (de Finibus Bonorum et Malorum) لمؤلفه شيشيرون (Cicero) في سنة 45 قبل الميلاد</p><p style=\"text-align:right;\">هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي للنص أو شكل توضع الفقرات في الصفحة التي يقرأها. ولذلك يتم استخدام طريقة لوريم إيبسوم لأنها تعطي توزيعاَ طبيعياَ -إلى حد ما- للأحرف عوضاً عن استخدام \"هنا يوجد محتوى نصي، هنا يوجد محتوى نصي\" فتجعلها تبدو (أي الأحرف) وكأنها نص مقروء. العديد من برامح النشر المكتبي وبرامح تحرير صفحات الويب تستخدم لوريم إيبسوم بشكل إفتراضي كنموذج عن النص، وإذا قمت بإدخال \"lorem ipsum\" في أي محرك بحث ستظهر العديد من المواقع الحديثة العهد في نتائج البحث. على مدى السنين ظهرت نسخ جديدة ومختلفة من نص لوريم إيبسوم، أحياناً عن طريق الصدفة، وأحياناً عن عمد كإدخال بعض العبارات الفكاهية إليها.</p><p style=\"text-align:right;\"><br /></p><p style=\"text-align:right;\"><span style=\"font-size:.805rem;\">ترجمة هـ. راكهام (H. Rackham) في عام 1914</span><br /></p><p style=\"text-align:right;\">خلافاَ للإعتقاد السائد فإن لوريم إيبسوم ليس نصاَ عشوائياً، بل إن له جذور في الأدب اللاتيني الكلاسيكي منذ العام 45 قبل الميلاد، مما يجعله أكثر من 2000 عام في القدم. قام البروفيسور \"ريتشارد ماك لينتوك\" (Richard McClintock) وهو بروفيسور اللغة اللاتينية في جامعة هامبدن-سيدني في فيرجينيا بالبحث عن أصول كلمة لاتينية غامضة في نص لوريم إيبسوم وهي \"consectetur\"، وخلال تتبعه لهذه الكلمة في الأدب اللاتيني اكتشف المصدر الغير قابل للشك. فلقد اتضح أن كلمات نص لوريم إيبسوم تأتي من الأقسام 1.10.32 و 1.10.33 من كتاب \"حول أقاصي الخير والشر\" (de Finibus Bonorum et Malorum) للمفكر شيشيرون (Cicero) والذي كتبه في عام 45 قبل الميلاد. هذا الكتاب هو بمثابة مقالة علمية مطولة في نظرية الأخلاق، وكان له شعبية كبيرة في عصر النهضة. السطر الأول من لوريم إيبسوم \"Lorem ipsum dolor sit amet..\" يأتي من سطر في القسم 1.20.32 من هذا الكتاب.</p><p style=\"text-align:right;\"><br /></p><p style=\"text-align:right;\">القسم 1.10.33 من \"حول أقاصي الخير والشر\" (de Finibus Bonorum et Malorum) لمؤلفه شيشيرون (Cicero) في سنة 45 قبل الميلاد</p><p style=\"text-align:right;\">هنالك العديد من الأنواع المتوفرة لنصوص لوريم إيبسوم، ولكن الغالبية تم تعديلها بشكل ما عبر إدخال بعض النوادر أو الكلمات العشوائية إلى النص. إن كنت تريد أن تستخدم نص لوريم إيبسوم ما، عليك أن تتحقق أولاً أن ليس هناك أي كلمات أو عبارات محرجة أو غير لائقة مخبأة في هذا النص. بينما تعمل جميع مولّدات نصوص لوريم إيبسوم على الإنترنت على إعادة تكرار مقاطع من نص لوريم إيبسوم نفسه عدة مرات بما تتطلبه الحاجة، يقوم مولّدنا هذا باستخدام كلمات من قاموس يحوي على أكثر من 200 كلمة لا تينية، مضاف إليها مجموعة من الجمل النموذجية، لتكوين نص لوريم إيبسوم ذو شكل منطقي قريب إلى النص الحقيقي. وبالتالي يكون النص الناتح خالي من التكرار، أو أي كلمات أو عبارات غير لائقة أو ما شابه. وهذا ما يجعله أول مولّد نص لوريم إيبسوم حقيقي على الإنترنت.</p><div style=\"text-align:right;\"><br style=\"font-size:12.88px;\" /></div>', 'ar'),
(17, 6, 'À propos de nous', 'a-propos-de-nous', '<p style=\"font-size:12.88px;\">Le passage de Lorem Ipsum standard, utilisé depuis 1500</p><p style=\"font-size:12.88px;\">Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l\'imprimerie depuis les années 1500, quand un imprimeur anonyme assembla ensemble des morceaux de texte pour réaliser un livre spécimen de polices de texte. Il n\'a pas fait que survivre cinq siècles, mais s\'est aussi adapté à la bureautique informatique, sans que son contenu n\'en soit modifié. Il a été popularisé dans les années 1960 grâce à la vente de feuilles Letraset contenant des passages du Lorem Ipsum, et, plus récemment, par son inclusion dans des applications de mise en page de texte, comme Aldus PageMaker.</p><p style=\"font-size:12.88px;\"><br /></p><p style=\"font-size:12.88px;\">Section 1.10.32 du \"De Finibus Bonorum et Malorum\" de Ciceron (45 av. J.-C.)</p><p style=\"font-size:12.88px;\">On sait depuis longtemps que travailler avec du texte lisible et contenant du sens est source de distractions, et empêche de se concentrer sur la mise en page elle-même. L\'avantage du Lorem Ipsum sur un texte générique comme \'Du texte. Du texte. Du texte.\' est qu\'il possède une distribution de lettres plus ou moins normale, et en tout cas comparable avec celle du français standard. De nombreuses suites logicielles de mise en page ou éditeurs de sites Web ont fait du Lorem Ipsum leur faux texte par défaut, et une recherche pour \'Lorem Ipsum\' vous conduira vers de nombreux sites qui n\'en sont encore qu\'à leur phase de construction. Plusieurs versions sont apparues avec le temps, parfois par accident, souvent intentionnellement (histoire d\'y rajouter de petits clins d\'oeil, voire des phrases embarassantes).</p><p style=\"font-size:12.88px;\"><span style=\"font-size:.805rem;\"><br /></span></p><p style=\"font-size:12.88px;\"><span style=\"font-size:.805rem;\">Traduction de H. Rackham (1914)</span><br /></p><p style=\"font-size:12.88px;\">Contrairement à une opinion répandue, le Lorem Ipsum n\'est pas simplement du texte aléatoire. Il trouve ses racines dans une oeuvre de la littérature latine classique datant de 45 av. J.-C., le rendant vieux de 2000 ans. Un professeur du Hampden-Sydney College, en Virginie, s\'est intéressé à un des mots latins les plus obscurs, consectetur, extrait d\'un passage du Lorem Ipsum, et en étudiant tous les usages de ce mot dans la littérature classique, découvrit la source incontestable du Lorem Ipsum. Il provient en fait des sections 1.10.32 et 1.10.33 du \"De Finibus Bonorum et Malorum\" (Des Suprêmes Biens et des Suprêmes Maux) de Cicéron. Cet ouvrage, très populaire pendant la Renaissance, est un traité sur la théorie de l\'éthique. Les premières lignes du Lorem Ipsum, \"Lorem ipsum dolor sit amet...\", proviennent de la section 1.10.32.</p><p style=\"font-size:12.88px;\"><br /></p><p style=\"font-size:12.88px;\">Section 1.10.33 du \"De Finibus Bonorum et Malorum\" de Ciceron (45 av. J.-C.)</p><p style=\"font-size:12.88px;\">Plusieurs variations de Lorem Ipsum peuvent être trouvées ici ou là, mais la majeure partie d\'entre elles a été altérée par l\'addition d\'humour ou de mots aléatoires qui ne ressemblent pas une seconde à du texte standard. Si vous voulez utiliser un passage du Lorem Ipsum, vous devez être sûr qu\'il n\'y a rien d\'embarrassant caché dans le texte. Tous les générateurs de Lorem Ipsum sur Internet tendent à reproduire le même extrait sans fin, ce qui fait de lipsum.com le seul vrai générateur de Lorem Ipsum. Iil utilise un dictionnaire de plus de 200 mots latins, en combinaison de plusieurs structures de phrases, pour générer un Lorem Ipsum irréprochable. Le Lorem Ipsum ainsi obtenu ne contient aucune répétition, ni ne contient des mots farfelus, ou des touches d\'humour.</p>', 'fr'),
(18, 6, 'معلومات عنا', 'معلومات-عنا', '<p style=\"text-align:right;\">نص لوريم إيبسوم القياسي والمستخدم منذ القرن الخامس عشر</p><p style=\"text-align:right;\">لوريم إيبسوم(Lorem Ipsum) هو ببساطة نص شكلي (بمعنى أن الغاية هي الشكل وليس المحتوى) ويُستخدم في صناعات المطابع ودور النشر. كان لوريم إيبسوم ولايزال المعيار للنص الشكلي منذ القرن الخامس عشر عندما قامت مطبعة مجهولة برص مجموعة من الأحرف بشكل عشوائي أخذتها من نص، لتكوّن كتيّب بمثابة دليل أو مرجع شكلي لهذه الأحرف. خمسة قرون من الزمن لم تقضي على هذا النص، بل انه حتى صار مستخدماً وبشكله الأصلي في الطباعة والتنضيد الإلكتروني. انتشر بشكل كبير في ستينيّات هذا القرن مع إصدار رقائق \"ليتراسيت\" (Letraset) البلاستيكية تحوي مقاطع من هذا النص، وعاد لينتشر مرة أخرى مؤخراَ مع ظهور برامج النشر الإلكتروني مثل \"ألدوس بايج مايكر\" (Aldus PageMaker) والتي حوت أيضاً على نسخ من نص لوريم إيبسوم.</p><p style=\"text-align:right;\"><br /></p><p style=\"text-align:right;\">القسم 1.10.32 من \"حول أقاصي الخير والشر\" (de Finibus Bonorum et Malorum) لمؤلفه شيشيرون (Cicero) في سنة 45 قبل الميلاد</p><p style=\"text-align:right;\">هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي للنص أو شكل توضع الفقرات في الصفحة التي يقرأها. ولذلك يتم استخدام طريقة لوريم إيبسوم لأنها تعطي توزيعاَ طبيعياَ -إلى حد ما- للأحرف عوضاً عن استخدام \"هنا يوجد محتوى نصي، هنا يوجد محتوى نصي\" فتجعلها تبدو (أي الأحرف) وكأنها نص مقروء. العديد من برامح النشر المكتبي وبرامح تحرير صفحات الويب تستخدم لوريم إيبسوم بشكل إفتراضي كنموذج عن النص، وإذا قمت بإدخال \"lorem ipsum\" في أي محرك بحث ستظهر العديد من المواقع الحديثة العهد في نتائج البحث. على مدى السنين ظهرت نسخ جديدة ومختلفة من نص لوريم إيبسوم، أحياناً عن طريق الصدفة، وأحياناً عن عمد كإدخال بعض العبارات الفكاهية إليها.</p><p style=\"text-align:right;\"><br /></p><p style=\"text-align:right;\"><span style=\"font-size:.805rem;\">ترجمة هـ. راكهام (H. Rackham) في عام 1914</span><br /></p><p style=\"text-align:right;\">خلافاَ للإعتقاد السائد فإن لوريم إيبسوم ليس نصاَ عشوائياً، بل إن له جذور في الأدب اللاتيني الكلاسيكي منذ العام 45 قبل الميلاد، مما يجعله أكثر من 2000 عام في القدم. قام البروفيسور \"ريتشارد ماك لينتوك\" (Richard McClintock) وهو بروفيسور اللغة اللاتينية في جامعة هامبدن-سيدني في فيرجينيا بالبحث عن أصول كلمة لاتينية غامضة في نص لوريم إيبسوم وهي \"consectetur\"، وخلال تتبعه لهذه الكلمة في الأدب اللاتيني اكتشف المصدر الغير قابل للشك. فلقد اتضح أن كلمات نص لوريم إيبسوم تأتي من الأقسام 1.10.32 و 1.10.33 من كتاب \"حول أقاصي الخير والشر\" (de Finibus Bonorum et Malorum) للمفكر شيشيرون (Cicero) والذي كتبه في عام 45 قبل الميلاد. هذا الكتاب هو بمثابة مقالة علمية مطولة في نظرية الأخلاق، وكان له شعبية كبيرة في عصر النهضة. السطر الأول من لوريم إيبسوم \"Lorem ipsum dolor sit amet..\" يأتي من سطر في القسم 1.20.32 من هذا الكتاب.</p><p style=\"text-align:right;\"><br /></p><p style=\"text-align:right;\">القسم 1.10.33 من \"حول أقاصي الخير والشر\" (de Finibus Bonorum et Malorum) لمؤلفه شيشيرون (Cicero) في سنة 45 قبل الميلاد</p><p style=\"text-align:right;\">هنالك العديد من الأنواع المتوفرة لنصوص لوريم إيبسوم، ولكن الغالبية تم تعديلها بشكل ما عبر إدخال بعض النوادر أو الكلمات العشوائية إلى النص. إن كنت تريد أن تستخدم نص لوريم إيبسوم ما، عليك أن تتحقق أولاً أن ليس هناك أي كلمات أو عبارات محرجة أو غير لائقة مخبأة في هذا النص. بينما تعمل جميع مولّدات نصوص لوريم إيبسوم على الإنترنت على إعادة تكرار مقاطع من نص لوريم إيبسوم نفسه عدة مرات بما تتطلبه الحاجة، يقوم مولّدنا هذا باستخدام كلمات من قاموس يحوي على أكثر من 200 كلمة لا تينية، مضاف إليها مجموعة من الجمل النموذجية، لتكوين نص لوريم إيبسوم ذو شكل منطقي قريب إلى النص الحقيقي. وبالتالي يكون النص الناتح خالي من التكرار، أو أي كلمات أو عبارات غير لائقة أو ما شابه. وهذا ما يجعله أول مولّد نص لوريم إيبسوم حقيقي على الإنترنت.</p><div style=\"text-align:right;\"><br style=\"font-size:12.88px;\" /></div>', 'ar'),
(19, 1, 'Términos de servicio', 'terminos-de-servicio', '<p>1914 traducción de H. Rackham</p><p><span style=\"font-size:.805rem;\">Pero debo explicarte cómo nació toda esta idea errónea de denunciar el placer y alabar el dolor y te daré una descripción completa del sistema y expondré las enseñanzas reales del gran explorador de la verdad, el maestro constructor de la felicidad humana. Nadie rechaza, no le gusta o evita el placer en sí mismo, porque es placer, sino porque aquellos que no saben cómo perseguir el placer racionalmente encuentran consecuencias que son extremadamente dolorosas. Tampoco hay nadie que ame, persiga o desee obtener el dolor por sí mismo, porque es dolor, pero porque ocasionalmente se dan circunstancias en las que el trabajo y el dolor pueden procurarle un gran placer.Para tomar un ejemplo trivial, ¿quién de nosotros emprende un ejercicio físico laborioso, excepto para obtener algún beneficio de él? Pero, ¿quién tiene derecho a criticar a un hombre que elige disfrutar de un placer que no tiene consecuencias molestas, o uno que evita un dolor que no produce ningún placer resultante? \"</span><br /></p><p><span style=\"font-size:.805rem;\">Sección 1.10.33 de \"de Finibus Bonorum et Malorum\", escrito por Cicerón en el 45 a. C.</span><br /></p><p><span style=\"font-size:.805rem;\">\"En vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint spectacati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolor fuidegam. rerum facilis est et expedita distinio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat. \"</span><br /></p><p><span style=\"font-size:.805rem;\">1914 traducción de H. Rackham</span><br /></p><p><span style=\"font-size:.805rem;\">\"Por otro lado, denunciamos con justa indignación y disgusto a los hombres que están tan engañados y desmoralizados por los encantos del placer del momento, tan cegados por el deseo, que no pueden prever el dolor y la angustia que seguramente sobrevendrán; La culpa es de quienes fallan en su deber por debilidad de la voluntad, que es lo mismo que decir por rehuir el trabajo y el dolor. Estos casos son perfectamente simples y fáciles de distinguir. En una hora libre, cuando nuestro poder de elección está libre y cuando nada impide que podamos hacer lo que más nos gusta, todo placer debe ser bienvenido y todo dolor evitado. Pero en determinadas circunstancias y debido a las exigencias del deber o las obligaciones de los negocios, con frecuencia ocurrirá que los placeres deban ser repudiados. y las molestias aceptadas. Por lo tanto, el sabio siempre se apega en estos asuntos a este principio de selección: rechaza los placeres para conseguir otros placeres mayores, o bien soporta dolores para evitar dolores peores \".</span><br /></p>', 'es'),
(20, 2, 'Política de privacidad', 'politica-de-privacidad', '<p style=\"font-size:12.88px;\">1914 traducción de H. Rackham</p><p style=\"font-size:12.88px;\"><span style=\"font-size:.805rem;\">Pero debo explicarte cómo nació toda esta idea errónea de denunciar el placer y alabar el dolor y te daré una descripción completa del sistema y expondré las enseñanzas reales del gran explorador de la verdad, el maestro constructor de la felicidad humana. Nadie rechaza, no le gusta o evita el placer en sí mismo, porque es placer, sino porque aquellos que no saben cómo perseguir el placer racionalmente encuentran consecuencias que son extremadamente dolorosas. Tampoco hay nadie que ame, persiga o desee obtener el dolor por sí mismo, porque es dolor, pero porque ocasionalmente se dan circunstancias en las que el trabajo y el dolor pueden procurarle un gran placer.Para tomar un ejemplo trivial, ¿quién de nosotros emprende un ejercicio físico laborioso, excepto para obtener algún beneficio de él? Pero, ¿quién tiene derecho a criticar a un hombre que elige disfrutar de un placer que no tiene consecuencias molestas, o uno que evita un dolor que no produce ningún placer resultante? \"</span><br /></p><p style=\"font-size:12.88px;\"><span style=\"font-size:.805rem;\">Sección 1.10.33 de \"de Finibus Bonorum et Malorum\", escrito por Cicerón en el 45 a. C.</span><br /></p><p style=\"font-size:12.88px;\"><span style=\"font-size:.805rem;\">\"En vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint spectacati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolor fuidegam. rerum facilis est et expedita distinio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat. \"</span><br /></p><p style=\"font-size:12.88px;\"><span style=\"font-size:.805rem;\">1914 traducción de H. Rackham</span><br /></p><p style=\"font-size:12.88px;\"><span style=\"font-size:.805rem;\">\"Por otro lado, denunciamos con justa indignación y disgusto a los hombres que están tan engañados y desmoralizados por los encantos del placer del momento, tan cegados por el deseo, que no pueden prever el dolor y la angustia que seguramente sobrevendrán; La culpa es de quienes fallan en su deber por debilidad de la voluntad, que es lo mismo que decir por rehuir el trabajo y el dolor. Estos casos son perfectamente simples y fáciles de distinguir. En una hora libre, cuando nuestro poder de elección está libre y cuando nada impide que podamos hacer lo que más nos gusta, todo placer debe ser bienvenido y todo dolor evitado. Pero en determinadas circunstancias y debido a las exigencias del deber o las obligaciones de los negocios, con frecuencia ocurrirá que los placeres deban ser repudiados. y las molestias aceptadas. Por lo tanto, el sabio siempre se apega en estos asuntos a este principio de selección: rechaza los placeres para conseguir otros placeres mayores, o bien soporta dolores para evitar dolores peores \".</span></p>', 'es'),
(21, 3, 'Política de cookies', 'politica-de-cookies', '<p style=\"font-size:12.88px;\">1914 traducción de H. Rackham</p><p style=\"font-size:12.88px;\"><span style=\"font-size:.805rem;\">Pero debo explicarte cómo nació toda esta idea errónea de denunciar el placer y alabar el dolor y te daré una descripción completa del sistema y expondré las enseñanzas reales del gran explorador de la verdad, el maestro constructor de la felicidad humana. Nadie rechaza, no le gusta o evita el placer en sí mismo, porque es placer, sino porque aquellos que no saben cómo perseguir el placer racionalmente encuentran consecuencias que son extremadamente dolorosas. Tampoco hay nadie que ame, persiga o desee obtener el dolor por sí mismo, porque es dolor, pero porque ocasionalmente se dan circunstancias en las que el trabajo y el dolor pueden procurarle un gran placer.Para tomar un ejemplo trivial, ¿quién de nosotros emprende un ejercicio físico laborioso, excepto para obtener algún beneficio de él? Pero, ¿quién tiene derecho a criticar a un hombre que elige disfrutar de un placer que no tiene consecuencias molestas, o uno que evita un dolor que no produce ningún placer resultante? \"</span><br /></p><p style=\"font-size:12.88px;\"><span style=\"font-size:.805rem;\">Sección 1.10.33 de \"de Finibus Bonorum et Malorum\", escrito por Cicerón en el 45 a. C.</span><br /></p><p style=\"font-size:12.88px;\"><span style=\"font-size:.805rem;\">\"En vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint spectacati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolor fuidegam. rerum facilis est et expedita distinio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat. \"</span><br /></p><p style=\"font-size:12.88px;\"><span style=\"font-size:.805rem;\">1914 traducción de H. Rackham</span><br /></p><p style=\"font-size:12.88px;\"><span style=\"font-size:.805rem;\">\"Por otro lado, denunciamos con justa indignación y disgusto a los hombres que están tan engañados y desmoralizados por los encantos del placer del momento, tan cegados por el deseo, que no pueden prever el dolor y la angustia que seguramente sobrevendrán; La culpa es de quienes fallan en su deber por debilidad de la voluntad, que es lo mismo que decir por rehuir el trabajo y el dolor. Estos casos son perfectamente simples y fáciles de distinguir. En una hora libre, cuando nuestro poder de elección está libre y cuando nada impide que podamos hacer lo que más nos gusta, todo placer debe ser bienvenido y todo dolor evitado. Pero en determinadas circunstancias y debido a las exigencias del deber o las obligaciones de los negocios, con frecuencia ocurrirá que los placeres deban ser repudiados. y las molestias aceptadas. Por lo tanto, el sabio siempre se apega en estos asuntos a este principio de selección: rechaza los placeres para conseguir otros placeres mayores, o bien soporta dolores para evitar dolores peores \".</span></p>', 'es'),
(22, 4, 'Cumplimiento de GDPR', 'cumplimiento-de-gdpr', '<p style=\"font-size:12.88px;\">1914 traducción de H. Rackham</p><p style=\"font-size:12.88px;\"><span style=\"font-size:.805rem;\">Pero debo explicarte cómo nació toda esta idea errónea de denunciar el placer y alabar el dolor y te daré una descripción completa del sistema y expondré las enseñanzas reales del gran explorador de la verdad, el maestro constructor de la felicidad humana. Nadie rechaza, no le gusta o evita el placer en sí mismo, porque es placer, sino porque aquellos que no saben cómo perseguir el placer racionalmente encuentran consecuencias que son extremadamente dolorosas. Tampoco hay nadie que ame, persiga o desee obtener el dolor por sí mismo, porque es dolor, pero porque ocasionalmente se dan circunstancias en las que el trabajo y el dolor pueden procurarle un gran placer.Para tomar un ejemplo trivial, ¿quién de nosotros emprende un ejercicio físico laborioso, excepto para obtener algún beneficio de él? Pero, ¿quién tiene derecho a criticar a un hombre que elige disfrutar de un placer que no tiene consecuencias molestas, o uno que evita un dolor que no produce ningún placer resultante? \"</span><br /></p><p style=\"font-size:12.88px;\"><span style=\"font-size:.805rem;\">Sección 1.10.33 de \"de Finibus Bonorum et Malorum\", escrito por Cicerón en el 45 a. C.</span><br /></p><p style=\"font-size:12.88px;\"><span style=\"font-size:.805rem;\">\"En vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint spectacati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolor fuidegam. rerum facilis est et expedita distinio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat. \"</span><br /></p><p style=\"font-size:12.88px;\"><span style=\"font-size:.805rem;\">1914 traducción de H. Rackham</span><br /></p><p style=\"font-size:12.88px;\"><span style=\"font-size:.805rem;\">\"Por otro lado, denunciamos con justa indignación y disgusto a los hombres que están tan engañados y desmoralizados por los encantos del placer del momento, tan cegados por el deseo, que no pueden prever el dolor y la angustia que seguramente sobrevendrán; La culpa es de quienes fallan en su deber por debilidad de la voluntad, que es lo mismo que decir por rehuir el trabajo y el dolor. Estos casos son perfectamente simples y fáciles de distinguir. En una hora libre, cuando nuestro poder de elección está libre y cuando nada impide que podamos hacer lo que más nos gusta, todo placer debe ser bienvenido y todo dolor evitado. Pero en determinadas circunstancias y debido a las exigencias del deber o las obligaciones de los negocios, con frecuencia ocurrirá que los placeres deban ser repudiados. y las molestias aceptadas. Por lo tanto, el sabio siempre se apega en estos asuntos a este principio de selección: rechaza los placeres para conseguir otros placeres mayores, o bien soporta dolores para evitar dolores peores \".</span></p>', 'es'),
(23, 5, 'Precios y tarifas', 'precios-y-tarifas', '<p style=\"font-size:12.88px;\">1914 traducción de H. Rackham</p><p style=\"font-size:12.88px;\"><span style=\"font-size:.805rem;\">Pero debo explicarte cómo nació toda esta idea errónea de denunciar el placer y alabar el dolor y te daré una descripción completa del sistema y expondré las enseñanzas reales del gran explorador de la verdad, el maestro constructor de la felicidad humana. Nadie rechaza, no le gusta o evita el placer en sí mismo, porque es placer, sino porque aquellos que no saben cómo perseguir el placer racionalmente encuentran consecuencias que son extremadamente dolorosas. Tampoco hay nadie que ame, persiga o desee obtener el dolor por sí mismo, porque es dolor, pero porque ocasionalmente se dan circunstancias en las que el trabajo y el dolor pueden procurarle un gran placer.Para tomar un ejemplo trivial, ¿quién de nosotros emprende un ejercicio físico laborioso, excepto para obtener algún beneficio de él? Pero, ¿quién tiene derecho a criticar a un hombre que elige disfrutar de un placer que no tiene consecuencias molestas, o uno que evita un dolor que no produce ningún placer resultante? \"</span><br /></p><p style=\"font-size:12.88px;\"><span style=\"font-size:.805rem;\">Sección 1.10.33 de \"de Finibus Bonorum et Malorum\", escrito por Cicerón en el 45 a. C.</span><br /></p><p style=\"font-size:12.88px;\"><span style=\"font-size:.805rem;\">\"En vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint spectacati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolor fuidegam. rerum facilis est et expedita distinio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat. \"</span><br /></p><p style=\"font-size:12.88px;\"><span style=\"font-size:.805rem;\">1914 traducción de H. Rackham</span><br /></p><p style=\"font-size:12.88px;\"><span style=\"font-size:.805rem;\">\"Por otro lado, denunciamos con justa indignación y disgusto a los hombres que están tan engañados y desmoralizados por los encantos del placer del momento, tan cegados por el deseo, que no pueden prever el dolor y la angustia que seguramente sobrevendrán; La culpa es de quienes fallan en su deber por debilidad de la voluntad, que es lo mismo que decir por rehuir el trabajo y el dolor. Estos casos son perfectamente simples y fáciles de distinguir. En una hora libre, cuando nuestro poder de elección está libre y cuando nada impide que podamos hacer lo que más nos gusta, todo placer debe ser bienvenido y todo dolor evitado. Pero en determinadas circunstancias y debido a las exigencias del deber o las obligaciones de los negocios, con frecuencia ocurrirá que los placeres deban ser repudiados. y las molestias aceptadas. Por lo tanto, el sabio siempre se apega en estos asuntos a este principio de selección: rechaza los placeres para conseguir otros placeres mayores, o bien soporta dolores para evitar dolores peores \".</span></p>', 'es'),
(24, 6, 'Sobre nosotros', 'sobre-nosotros', '<p style=\"font-size:12.88px;\">1914 traducción de H. Rackham</p><p style=\"font-size:12.88px;\"><span style=\"font-size:.805rem;\">Pero debo explicarte cómo nació toda esta idea errónea de denunciar el placer y alabar el dolor y te daré una descripción completa del sistema y expondré las enseñanzas reales del gran explorador de la verdad, el maestro constructor de la felicidad humana. Nadie rechaza, no le gusta o evita el placer en sí mismo, porque es placer, sino porque aquellos que no saben cómo perseguir el placer racionalmente encuentran consecuencias que son extremadamente dolorosas. Tampoco hay nadie que ame, persiga o desee obtener el dolor por sí mismo, porque es dolor, pero porque ocasionalmente se dan circunstancias en las que el trabajo y el dolor pueden procurarle un gran placer.Para tomar un ejemplo trivial, ¿quién de nosotros emprende un ejercicio físico laborioso, excepto para obtener algún beneficio de él? Pero, ¿quién tiene derecho a criticar a un hombre que elige disfrutar de un placer que no tiene consecuencias molestas, o uno que evita un dolor que no produce ningún placer resultante? \"</span><br /></p><p style=\"font-size:12.88px;\"><span style=\"font-size:.805rem;\">Sección 1.10.33 de \"de Finibus Bonorum et Malorum\", escrito por Cicerón en el 45 a. C.</span><br /></p><p style=\"font-size:12.88px;\"><span style=\"font-size:.805rem;\">\"En vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint spectacati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolor fuidegam. rerum facilis est et expedita distinio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat. \"</span><br /></p><p style=\"font-size:12.88px;\"><span style=\"font-size:.805rem;\">1914 traducción de H. Rackham</span><br /></p><p style=\"font-size:12.88px;\"><span style=\"font-size:.805rem;\">\"Por otro lado, denunciamos con justa indignación y disgusto a los hombres que están tan engañados y desmoralizados por los encantos del placer del momento, tan cegados por el deseo, que no pueden prever el dolor y la angustia que seguramente sobrevendrán; La culpa es de quienes fallan en su deber por debilidad de la voluntad, que es lo mismo que decir por rehuir el trabajo y el dolor. Estos casos son perfectamente simples y fáciles de distinguir. En una hora libre, cuando nuestro poder de elección está libre y cuando nada impide que podamos hacer lo que más nos gusta, todo placer debe ser bienvenido y todo dolor evitado. Pero en determinadas circunstancias y debido a las exigencias del deber o las obligaciones de los negocios, con frecuencia ocurrirá que los placeres deban ser repudiados. y las molestias aceptadas. Por lo tanto, el sabio siempre se apega en estos asuntos a este principio de selección: rechaza los placeres para conseguir otros placeres mayores, o bien soporta dolores para evitar dolores peores \".</span></p>', 'es');

-- --------------------------------------------------------

--
-- Table structure for table `eventic_payment`
--

DROP TABLE IF EXISTS `eventic_payment`;
CREATE TABLE IF NOT EXISTS `eventic_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `client_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `client_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `total_amount` int(11) DEFAULT NULL,
  `currency_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `details` longtext NOT NULL,
  `firstname` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastname` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `postalcode` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `street` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `street2` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_1CDDDF948D9F6D38` (`order_id`),
  KEY `IDX_1CDDDF94F92F3E70` (`country_id`)
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `eventic_payment_gateway`
--

DROP TABLE IF EXISTS `eventic_payment_gateway`;
CREATE TABLE IF NOT EXISTS `eventic_payment_gateway` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `organizer_id` int(11) DEFAULT NULL,
  `gateway_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `factory_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `config` longtext NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `gateway_logo_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL,
  `number` int(11) DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_9D4780D7989D9B62` (`slug`),
  KEY `IDX_9D4780D7876C4DDA` (`organizer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `eventic_payment_gateway`
--

INSERT INTO `eventic_payment_gateway` (`id`, `organizer_id`, `gateway_name`, `factory_name`, `config`, `name`, `slug`, `gateway_logo_name`, `enabled`, `number`, `updated_at`) VALUES
(2, NULL, 'offline', 'offline', '{}', 'Point of sale', 'point-of-sale', '5e73318b09fc5563188447.png', 1, 0, '2020-03-19 04:47:07'),
(3, NULL, 'offline', 'offline', '{}', 'Free', 'free', '5e8ca4adcbc0a396442162.jpg', 1, 0, '2020-04-07 12:05:01');

-- --------------------------------------------------------

--
-- Table structure for table `eventic_payment_token`
--

DROP TABLE IF EXISTS `eventic_payment_token`;
CREATE TABLE IF NOT EXISTS `eventic_payment_token` (
  `hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `details` longtext COLLATE utf8_unicode_ci COMMENT '(DC2Type:object)',
  `after_url` longtext COLLATE utf8_unicode_ci,
  `target_url` longtext COLLATE utf8_unicode_ci NOT NULL,
  `gateway_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`hash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `eventic_payout_request`
--

DROP TABLE IF EXISTS `eventic_payout_request`;
CREATE TABLE IF NOT EXISTS `eventic_payout_request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `organizer_id` int(11) DEFAULT NULL,
  `payment_gateway_id` int(11) DEFAULT NULL,
  `event_date_id` int(11) DEFAULT NULL,
  `payment` longtext DEFAULT NULL,
  `reference` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `note` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4AE2AE43876C4DDA` (`organizer_id`),
  KEY `IDX_4AE2AE4362890FD5` (`payment_gateway_id`),
  KEY `IDX_4AE2AE433DC09FC4` (`event_date_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `eventic_pointofsale`
--

DROP TABLE IF EXISTS `eventic_pointofsale`;
CREATE TABLE IF NOT EXISTS `eventic_pointofsale` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `organizer_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_5D78D6FAA76ED395` (`user_id`),
  KEY `IDX_5D78D6FA876C4DDA` (`organizer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `eventic_review`
--

DROP TABLE IF EXISTS `eventic_review`;
CREATE TABLE IF NOT EXISTS `eventic_review` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `rating` int(11) NOT NULL,
  `headline` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `details` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `visible` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_3D9D9182989D9B62` (`slug`),
  KEY `IDX_3D9D918271F7E88B` (`event_id`),
  KEY `IDX_3D9D9182A76ED395` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `eventic_scanner`
--

DROP TABLE IF EXISTS `eventic_scanner`;
CREATE TABLE IF NOT EXISTS `eventic_scanner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `organizer_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_241A84B0A76ED395` (`user_id`),
  KEY `IDX_241A84B0876C4DDA` (`organizer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `eventic_settings`
--

DROP TABLE IF EXISTS `eventic_settings`;
CREATE TABLE IF NOT EXISTS `eventic_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `eventic_settings`
--

INSERT INTO `eventic_settings` (`id`, `key`, `value`) VALUES
(1, 'currency_ccy', 'USD'),
(2, 'currency_symbol', '$'),
(3, 'currency_position', 'right'),
(4, 'feed_name', 'Events RSS feed'),
(6, 'feed_description', 'Latest events'),
(7, 'feed_events_limit', '100'),
(8, 'img_loader', 'assets/img/placeholders/img-404.jpg'),
(9, 'blog_comments_enabled', 'no'),
(10, 'facebook_app_id', ''),
(11, 'disqus_subdomain', ''),
(12, 'newsletter_enabled', 'no'),
(13, 'mailchimp_api_key', ''),
(14, 'mailchimp_list_id', ''),
(15, 'homepage_show_search_box', 'no'),
(16, 'homepage_events_number', '12'),
(17, 'homepage_categories_number', '8'),
(18, 'homepage_blogposts_number', '8'),
(19, 'homepage_show_call_to_action', 'yes'),
(20, 'show_terms_of_service_page', 'yes'),
(21, 'terms_of_service_page_content', 'terms_of_service_page_content'),
(22, 'show_privacy_policy_page', 'yes'),
(23, 'privacy_policy_page_content', 'privacy_policy_page_content'),
(24, 'show_cookie_policy_page', 'yes'),
(25, 'cookie_policy_page_content', 'cookie_policy_page_content'),
(26, 'show_gdpr_compliance_page', 'yes'),
(27, 'gdpr_compliance_page_content', 'gdpr_compliance_page_content'),
(28, 'terms_of_service_page_slug', 'terms-of-service'),
(29, 'privacy_policy_page_slug', 'privacy-policy'),
(30, 'cookie_policy_page_slug', 'cookie-policy'),
(31, 'gdpr_compliance_page_slug', 'gdpr-compliance'),
(32, 'ticket_fee_online', '0.00'),
(33, 'ticket_fee_pos', '0.00'),
(34, 'checkout_timeleft', '1800'),
(35, 'organizer_payout_paypal_enabled', 'yes'),
(36, 'organizer_payout_stripe_enabled', 'yes'),
(37, 'online_ticket_price_percentage_cut', '0'),
(38, 'pos_ticket_price_percentage_cut', '0'),
(39, 'blog_posts_per_page', '9'),
(40, 'events_per_page', '10'),
(41, 'show_map_button', 'no'),
(42, 'show_calendar_button', 'yes'),
(43, 'show_rss_feed_button', 'yes'),
(44, 'show_category_filter', 'yes'),
(45, 'show_location_filter', 'yes'),
(46, 'show_date_filter', 'yes'),
(47, 'show_ticket_price_filter', 'yes'),
(48, 'show_audience_filter', 'yes'),
(49, 'venue_comments_enabled', 'no'),
(50, 'show_tickets_left_on_cart_modal', 'yes'),
(51, 'website_name', 'Eventic'),
(52, 'website_slug', 'eventic'),
(54, 'website_root_url', 'yourdomain.com'),
(55, 'website_description_en', 'Event Management And Ticket Sales'),
(56, 'website_keywords_en', 'organize my event, tickets online, buy tickets'),
(57, 'contact_email', 'contact@yourdomain.com'),
(58, 'contact_phone', '+123456789'),
(59, 'contact_fax', '+123456789'),
(60, 'contact_address', '4916  Wyatt Street, 33128 Miami (FL), United States'),
(61, 'facebook_url', 'https://www.facebook.com'),
(62, 'instagram_url', 'https://www.instagram.com'),
(63, 'youtube_url', 'https://www.youtube.com'),
(64, 'twitter_url', 'https://www.twitter.com'),
(65, 'primary_color', '#f67611'),
(66, 'no_reply_email', 'no-reply@yourdomain.com'),
(67, 'show_back_to_top_button', 'yes'),
(68, 'show_cookie_policy_bar', 'yes'),
(69, 'custom_css', ''),
(70, 'google_analytics_code', ''),
(71, 'website_description_fr', 'Gestion d\'événements et vente de billets'),
(74, 'website_description_ar', 'إدارة الأحداث ومبيعات التذاكر'),
(75, 'website_keywords_fr', 'organiser mon événement, billets en ligne, acheter des billets'),
(78, 'website_keywords_ar', 'تنظيم الحدث الخاص بي ، التذاكر عبر الإنترنت ، شراء التذاكر'),
(79, 'mail_server_transport', ''),
(80, 'mail_server_host', ''),
(81, 'mail_server_port', NULL),
(82, 'mail_server_encryption', NULL),
(83, 'mail_server_auth_mode', NULL),
(84, 'mail_server_username', ''),
(85, 'mail_server_password', ''),
(86, 'google_recaptcha_enabled', 'no'),
(87, 'google_recaptcha_site_key', ''),
(88, 'google_recaptcha_secret_key', ''),
(89, 'social_login_facebook_enabled', 'no'),
(90, 'social_login_facebook_id', ''),
(91, 'social_login_facebook_secret', ''),
(92, 'social_login_google_id', ''),
(93, 'social_login_google_secret', ''),
(94, 'social_login_google_enabled', 'no'),
(95, 'app_environment', 'prod'),
(96, 'maintenance_mode', '0'),
(97, 'maintenance_mode_custom_message', ''),
(98, 'app_theme', 'orange'),
(99, 'app_layout', 'container'),
(100, 'website_url', 'http://yourdomain.com'),
(101, 'website_description_es', 'Gestión de eventos y venta de entradas'),
(102, 'website_keywords_es', 'organizar mi evento, entradas online, comprar entradas');

-- --------------------------------------------------------

--
-- Table structure for table `eventic_thread`
--

DROP TABLE IF EXISTS `eventic_thread`;
CREATE TABLE IF NOT EXISTS `eventic_thread` (
  `id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `permalink` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_commentable` tinyint(1) NOT NULL,
  `num_comments` int(11) NOT NULL,
  `last_comment_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `eventic_ticket_reservation`
--

DROP TABLE IF EXISTS `eventic_ticket_reservation`;
CREATE TABLE IF NOT EXISTS `eventic_ticket_reservation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eventticket_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `orderelement_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `expires_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_716DEA9F182CEB62` (`eventticket_id`),
  KEY `IDX_716DEA9FA76ED395` (`user_id`),
  KEY `IDX_716DEA9FEE04F0C1` (`orderelement_id`)
) ENGINE=InnoDB AUTO_INCREMENT=167 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `eventic_user`
--

DROP TABLE IF EXISTS `eventic_user`;
CREATE TABLE IF NOT EXISTS `eventic_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `organizer_id` int(11) DEFAULT NULL,
  `scanner_id` int(11) DEFAULT NULL,
  `pointofsale_id` int(11) DEFAULT NULL,
  `isorganizeronhomepageslider_id` int(11) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `username` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `confirmation_token` varchar(180) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `gender` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `firstname` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastname` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `street` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `street2` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `postalcode` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `avatar_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avatar_size` int(11) DEFAULT NULL,
  `avatar_mime_type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avatar_original_name` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avatar_dimensions` longtext COLLATE utf8_unicode_ci COMMENT '(DC2Type:simple_array)',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `facebook_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `facebook_access_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `google_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `google_access_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `api_key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `facebook_profile_picture` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_D01C6A2292FC23A8` (`username_canonical`),
  UNIQUE KEY `UNIQ_D01C6A22A0D96FBF` (`email_canonical`),
  UNIQUE KEY `UNIQ_D01C6A22989D9B62` (`slug`),
  UNIQUE KEY `UNIQ_D01C6A22C05FB297` (`confirmation_token`),
  UNIQUE KEY `UNIQ_D01C6A22C912ED9D` (`api_key`),
  UNIQUE KEY `UNIQ_D01C6A22876C4DDA` (`organizer_id`),
  UNIQUE KEY `UNIQ_D01C6A2267C89E33` (`scanner_id`),
  UNIQUE KEY `UNIQ_D01C6A2218E07BF3` (`pointofsale_id`),
  KEY `IDX_D01C6A22F2709FF9` (`isorganizeronhomepageslider_id`),
  KEY `IDX_D01C6A22F92F3E70` (`country_id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `eventic_user`
--

INSERT INTO `eventic_user` (`id`, `organizer_id`, `scanner_id`, `pointofsale_id`, `isorganizeronhomepageslider_id`, `country_id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `confirmation_token`, `password_requested_at`, `roles`, `gender`, `firstname`, `lastname`, `slug`, `street`, `street2`, `city`, `state`, `postalcode`, `phone`, `birthdate`, `avatar_name`, `avatar_size`, `avatar_mime_type`, `avatar_original_name`, `avatar_dimensions`, `created_at`, `updated_at`, `deleted_at`, `facebook_id`, `facebook_access_token`, `google_id`, `google_access_token`, `api_key`, `facebook_profile_picture`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, 'administrator', 'administrator', 'administrator@yourdomain.com', 'administrator@yourdomain.com', 1, 'IyGzEV46y9UDotJJUd6wjZ1xgBI7/rCRT3ZSi6Xc.Ag', '$2y$13$jxwSWnS/e/LFjSyzYVXKLOdlvtKljfxuFE25M6KB0MGo8jxhj4lXq', '2020-11-28 06:31:23', NULL, NULL, 'a:2:{i:0;s:16:\"ROLE_SUPER_ADMIN\";i:1;s:18:\"ROLE_ADMINISTRATOR\";}', NULL, 'Administrator', 'Administrator', 'administrator', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-09-27 08:01:04', '2020-11-28 06:31:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL);
-- --------------------------------------------------------

--
-- Table structure for table `eventic_venue`
--

DROP TABLE IF EXISTS `eventic_venue`;
CREATE TABLE IF NOT EXISTS `eventic_venue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `organizer_id` int(11) DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `seatedguests` int(11) DEFAULT NULL,
  `standingguests` int(11) DEFAULT NULL,
  `neighborhoods` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `foodbeverage` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pricing` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `availibility` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hidden` tinyint(1) NOT NULL,
  `showmap` tinyint(1) NOT NULL,
  `quoteform` tinyint(1) NOT NULL,
  `street` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `street2` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `postalcode` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `lat` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lng` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `listedondirectory` tinyint(1) NOT NULL,
  `contactemail` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4BAC2C61876C4DDA` (`organizer_id`),
  KEY `IDX_4BAC2C61C54C8C93` (`type_id`),
  KEY `IDX_4BAC2C61F92F3E70` (`country_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `eventic_venue_amenity`
--

DROP TABLE IF EXISTS `eventic_venue_amenity`;
CREATE TABLE IF NOT EXISTS `eventic_venue_amenity` (
  `Venue_id` int(11) NOT NULL,
  `Amenity_Id` int(11) NOT NULL,
  PRIMARY KEY (`Venue_id`,`Amenity_Id`),
  KEY `IDX_8A89D31EB9D15CEC` (`Venue_id`),
  KEY `IDX_8A89D31E45463477` (`Amenity_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `eventic_venue_image`
--

DROP TABLE IF EXISTS `eventic_venue_image`;
CREATE TABLE IF NOT EXISTS `eventic_venue_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `venue_id` int(11) DEFAULT NULL,
  `image_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_size` int(11) DEFAULT NULL,
  `image_mime_type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_original_name` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_dimensions` longtext COLLATE utf8_unicode_ci COMMENT '(DC2Type:simple_array)',
  `position` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_F3EE32A540A73EBA` (`venue_id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `eventic_venue_translation`
--

DROP TABLE IF EXISTS `eventic_venue_translation`;
CREATE TABLE IF NOT EXISTS `eventic_venue_translation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `translatable_id` int(11) DEFAULT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_3A06BD63989D9B62` (`slug`),
  UNIQUE KEY `eventic_venue_translation_unique_translation` (`translatable_id`,`locale`),
  KEY `IDX_3A06BD632C2AC5D3` (`translatable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `eventic_venue_type`
--

DROP TABLE IF EXISTS `eventic_venue_type`;
CREATE TABLE IF NOT EXISTS `eventic_venue_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hidden` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `eventic_venue_type`
--

INSERT INTO `eventic_venue_type` (`id`, `hidden`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 0, '2019-07-16 20:41:58', '2019-07-16 20:41:58', NULL),
(2, 0, '2019-07-16 20:42:58', '2019-07-16 20:42:58', NULL),
(3, 0, '2019-07-16 20:43:45', '2019-07-16 20:43:45', NULL),
(4, 0, '2019-07-16 20:44:44', '2019-07-16 20:44:44', NULL),
(5, 0, '2019-07-16 20:45:20', '2019-07-16 20:45:20', NULL),
(6, 0, '2019-07-16 20:46:26', '2019-07-16 20:46:26', NULL),
(7, 0, '2019-07-16 20:47:37', '2019-07-16 20:47:37', NULL),
(8, 0, '2019-07-16 20:48:20', '2019-07-16 20:48:20', NULL),
(9, 0, '2019-07-16 20:48:58', '2019-07-16 20:48:58', NULL),
(10, 0, '2019-07-16 20:49:39', '2019-07-16 20:49:39', NULL),
(11, 0, '2019-07-16 20:51:13', '2019-07-16 20:51:13', NULL),
(12, 0, '2019-07-16 20:52:35', '2019-07-16 20:52:35', NULL),
(13, 0, '2019-07-16 20:53:29', '2019-07-16 20:53:29', NULL),
(14, 0, '2019-07-16 20:54:08', '2019-07-16 20:54:08', NULL),
(15, 0, '2019-07-16 20:54:54', '2019-07-16 20:54:54', NULL),
(16, 0, '2019-07-16 20:55:55', '2019-07-16 20:55:55', NULL),
(17, 0, '2019-07-16 20:56:40', '2019-07-16 20:56:40', NULL),
(18, 0, '2019-07-16 20:57:18', '2019-07-16 20:57:18', NULL),
(19, 0, '2019-07-16 20:58:46', '2020-04-21 14:05:36', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `eventic_venue_type_translation`
--

DROP TABLE IF EXISTS `eventic_venue_type_translation`;
CREATE TABLE IF NOT EXISTS `eventic_venue_type_translation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `translatable_id` int(11) DEFAULT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_9FD9786F989D9B62` (`slug`),
  UNIQUE KEY `eventic_venue_type_translation_unique_translation` (`translatable_id`,`locale`),
  KEY `IDX_9FD9786F2C2AC5D3` (`translatable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=96 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `eventic_venue_type_translation`
--

INSERT INTO `eventic_venue_type_translation` (`id`, `translatable_id`, `name`, `slug`, `locale`) VALUES
(1, 1, 'Banquet Hall', 'banquet-hall', 'en'),
(2, 1, '宴会厅', '宴会厅', 'zh'),
(3, 1, 'Salón de banquetes', 'salon-de-banquetes', 'es'),
(4, 1, 'Salle de banquet', 'salle-de-banquet', 'fr'),
(5, 1, 'قاعة الولائم', 'قاعة-الولائم', 'ar'),
(6, 2, 'Bar', 'bar', 'en'),
(7, 2, '酒吧', '酒吧', 'zh'),
(8, 2, 'Bar', 'bar-1', 'es'),
(9, 2, 'Bar', 'bar-2', 'fr'),
(10, 2, 'حانة', 'حانة', 'ar'),
(11, 3, 'Boat', 'boat', 'en'),
(12, 3, '船', '船', 'zh'),
(13, 3, 'Bote', 'bote', 'es'),
(14, 3, 'Bateau', 'bateau', 'fr'),
(15, 3, 'سفينة', 'سفينة', 'ar'),
(16, 4, 'Brewery', 'brewery', 'en'),
(17, 4, '酿酒厂', '酿酒厂', 'zh'),
(18, 4, 'Cervecería', 'cerveceria', 'es'),
(19, 4, 'Brasserie', 'brasserie', 'fr'),
(20, 4, 'مصنع الجعة', 'مصنع-الجعة', 'ar'),
(21, 5, 'Cafe', 'cafe', 'en'),
(22, 5, '咖啡店', '咖啡店', 'zh'),
(23, 5, 'Café', 'cafe-1', 'es'),
(24, 5, 'Café', 'cafe-2', 'fr'),
(25, 5, 'مقهى', 'مقهى', 'ar'),
(26, 6, 'Co-working space', 'co-working-space', 'en'),
(27, 6, '共同工作空间', '共同工作空间', 'zh'),
(28, 6, 'Espacio de trabajo conjunto', 'espacio-de-trabajo-conjunto', 'es'),
(29, 6, 'Espace coworking', 'espace-coworking', 'fr'),
(30, 6, 'ساحة للعمل الجماعي', 'ساحة-للعمل-الجماعي', 'ar'),
(31, 7, 'Conference center', 'conference-center', 'en'),
(32, 7, '会议中心', '会议中心', 'zh'),
(33, 7, 'Centro de conferencias', 'centro-de-conferencias', 'es'),
(34, 7, 'Centre de conférence', 'centre-de-conference', 'fr'),
(35, 7, 'مركز مؤتمرات', 'مركز-مؤتمرات', 'ar'),
(36, 8, 'Country Club', 'country-club', 'en'),
(37, 8, '乡村俱乐部', '乡村俱乐部', 'zh'),
(38, 8, 'Club de Campo', 'club-de-campo', 'es'),
(39, 8, 'Country Club', 'country-club-1', 'fr'),
(40, 8, 'نادي ريفي', 'نادي-ريفي', 'ar'),
(41, 9, 'Event Space', 'event-space', 'en'),
(42, 9, '活动空间', '活动空间', 'zh'),
(43, 9, 'Evento espacial', 'evento-espacial', 'es'),
(44, 9, 'Espace événementiel', 'espace-evenementiel', 'fr'),
(45, 9, 'مساحة الحدث', 'مساحة-الحدث', 'ar'),
(46, 10, 'Gallery', 'gallery', 'en'),
(47, 10, '画廊', '画廊', 'zh'),
(48, 10, 'Galería', 'galeria', 'es'),
(49, 10, 'Galerie', 'galerie', 'fr'),
(50, 10, 'صالة عرض', 'صالة-عرض', 'ar'),
(51, 11, 'Gym', 'gym', 'en'),
(52, 11, '健身房', '健身房', 'zh'),
(53, 11, 'Sala de deporte', 'sala-de-deporte', 'es'),
(54, 11, 'Salle de sport', 'salle-de-sport', 'fr'),
(55, 11, 'قاعة رياضة', 'قاعة-رياضة', 'ar'),
(56, 12, 'Hotel', 'hotel', 'en'),
(57, 12, '旅馆', '旅馆', 'zh'),
(58, 12, 'Hotel', 'hotel-1', 'es'),
(59, 12, 'Hôtel', 'hotel-2', 'fr'),
(60, 12, 'فندق', 'فندق', 'ar'),
(61, 13, 'Loft', 'loft', 'en'),
(62, 13, '阁楼', '阁楼', 'zh'),
(63, 13, 'Desván', 'desvan', 'es'),
(64, 13, 'Grenier', 'grenier', 'fr'),
(65, 13, 'دور علوي', 'دور-علوي', 'ar'),
(66, 14, 'Meeting space', 'meeting-space', 'en'),
(67, 14, '会议空间', '会议空间', 'zh'),
(68, 14, 'Espacio para reuniones', 'espacio-para-reuniones', 'es'),
(69, 14, 'Espace de réunion', 'espace-de-reunion', 'fr'),
(70, 14, 'مساحة الاجتماع', 'مساحة-الاجتماع', 'ar'),
(71, 15, 'Museum', 'museum', 'en'),
(72, 15, '博物馆', '博物馆', 'zh'),
(73, 15, 'Museo', 'museo', 'es'),
(74, 15, 'Musée', 'musee', 'fr'),
(75, 15, 'متحف', 'متحف', 'ar'),
(76, 16, 'Restaurant', 'restaurant', 'en'),
(77, 16, '餐厅', '餐厅', 'zh'),
(78, 16, 'Restaurante', 'restaurante', 'es'),
(79, 16, 'Restaurant', 'restaurant-1', 'fr'),
(80, 16, 'مطعم', 'مطعم', 'ar'),
(81, 17, 'Stadium', 'stadium', 'en'),
(82, 17, '体育场', '体育场', 'zh'),
(83, 17, 'Estadio', 'estadio', 'es'),
(84, 17, 'Stade', 'stade', 'fr'),
(85, 17, 'ملعب', 'ملعب', 'ar'),
(86, 18, 'Theater', 'theater', 'en'),
(87, 18, '剧院', '剧院', 'zh'),
(88, 18, 'Teatro', 'teatro', 'es'),
(89, 18, 'Théâtre', 'theatre', 'fr'),
(90, 18, 'مسرح', 'مسرح', 'ar'),
(91, 19, 'Other', 'other', 'en'),
(92, 19, '其他', '其他', 'zh'),
(93, 19, 'Otra', 'otra', 'es'),
(94, 19, 'Autre', 'autre', 'fr'),
(95, 19, 'آخر', 'آخر', 'ar');

-- --------------------------------------------------------

--
-- Table structure for table `eventic_vote`
--

DROP TABLE IF EXISTS `eventic_vote`;
CREATE TABLE IF NOT EXISTS `eventic_vote` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comment_id` int(11) DEFAULT NULL,
  `voter_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `value` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_79F390FF8697D13` (`comment_id`),
  KEY `IDX_79F390FEBB4B8AD` (`voter_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `eventic_menu`
--

DROP TABLE IF EXISTS `eventic_menu`;
CREATE TABLE IF NOT EXISTS `eventic_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `eventic_menu`
--

INSERT INTO `eventic_menu` (`id`) VALUES
(1),
(2),
(3),
(4);
COMMIT;

--
-- Table structure for table `eventic_menu_translation`
--

DROP TABLE IF EXISTS `eventic_menu_translation`;
CREATE TABLE IF NOT EXISTS `eventic_menu_translation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `translatable_id` int(11) DEFAULT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `header` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_44D78BCC989D9B62` (`slug`),
  UNIQUE KEY `eventic_menu_translation_unique_translation` (`translatable_id`,`locale`),
  KEY `IDX_44D78BCC2C2AC5D3` (`translatable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `eventic_menu_translation`
--

INSERT INTO `eventic_menu_translation` (`id`, `translatable_id`, `name`, `header`, `slug`, `locale`) VALUES
(1, 1, 'Header menu', NULL, 'header-menu', 'en'),
(2, 1, 'Menu d\'en-tête', NULL, 'menu-d-en-tete', 'fr'),
(3, 1, 'قائمة أعلى الصفحة', NULL, 'قائمة-أعلى-الصفحة', 'ar'),
(4, 2, 'First Footer Section Menu', 'Useful Links', 'first-footer-section-menu', 'en'),
(5, 2, 'Menu de la première section de pied de page', 'Liens utiles', 'menu-de-la-premiere-section-de-pied-de-page', 'fr'),
(6, 2, 'القائمة الأولى لأدنى الصفحة', 'روابط مفيدة', 'القائمة-الأولى-لأدنى-الصفحة', 'ar'),
(7, 3, 'Second Footer Section Menu', 'My Account', 'second-footer-section-menu', 'en'),
(8, 3, 'Menu de la deuxième section de pied de page', 'Mon compte', 'menu-de-la-deuxieme-section-de-pied-de-page', 'fr'),
(9, 3, 'القائمة الثانية لأدنى الصفحة', 'حسابي', 'القائمة-الثانية-لأدنى-الصفحة', 'ar'),
(10, 4, 'Third Footer Section Menu', 'Event Categories', 'third-footer-section-menu', 'en'),
(11, 4, 'Menu de la troisième section de pied de page', 'Catégories d\'événements', 'menu-de-la-troisieme-section-de-pied-de-page', 'fr'),
(12, 4, 'القائمة الثالثة لأدنى الصفحة', 'فئات الأحداث', 'القائمة-الثالثة-لأدنى-الصفحة', 'ar'),
(13, 2, 'Menú de la sección del primer pie de página', 'Enlaces útiles', 'menu-de-la-seccion-del-primer-pie-de-pagina', 'es'),
(14, 1, 'Menú de encabezado', NULL, 'menu-de-encabezado', 'es'),
(15, 3, 'Menú de la sección del segundo pie de página', 'Mi cuenta', 'menu-de-la-seccion-del-segundo-pie-de-pagina', 'es'),
(16, 4, 'Menú de la sección del tercer pie de página', 'Categorías de eventos', 'menu-de-la-seccion-del-tercer-pie-de-pagina', 'es');

--
-- Table structure for table `eventic_menu_element`
--

DROP TABLE IF EXISTS `eventic_menu_element`;
CREATE TABLE IF NOT EXISTS `eventic_menu_element` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) DEFAULT NULL,
  `icon` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `position` int(11) NOT NULL,
  `custom_link` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8CAA77C9CCD7E912` (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `eventic_menu_element`
--

INSERT INTO `eventic_menu_element` (`id`, `menu_id`, `icon`, `link`, `position`, `custom_link`) VALUES
(1, 1, 'fas fa-home', '/en', 0, NULL),
(2, 1, 'fas fa-calendar', '/en/events', 1, NULL),
(3, 1, 'fas fa-stream', 'categories_dropdown', 2, NULL),
(4, 1, 'fas fa-compass', '/en/venues', 3, NULL),
(5, 1, 'fas fa-question-circle', '/en/help-center', 4, NULL),
(6, 1, 'fas fa-newspaper', '/en/blog', 5, NULL),
(7, 1, 'fas fa-ticket-alt', '/en/dashboard/attendee/my-tickets', 6, NULL),
(8, 1, 'fas fa-calendar-plus', '/en/dashboard/organizer/my-events/add', 7, NULL),
(9, 2, NULL, '/en/page/about-us', 0, NULL),
(10, 2, NULL, '/en/help-center', 1, NULL),
(11, 2, NULL, '/en/blog', 2, NULL),
(12, 2, NULL, '/en/venues', 3, NULL),
(13, 2, NULL, '/en/contact', 4, NULL),
(14, 3, NULL, '/en/signup/attendee', 0, NULL),
(15, 3, NULL, '/en/signup/organizer', 1, NULL),
(16, 3, NULL, '/en/dashboard/attendee/my-tickets', 2, NULL),
(17, 3, NULL, '/en/resetting/request', 3, NULL),
(18, 3, NULL, '/en/page/pricing-and-fees', 4, NULL),
(19, 4, NULL, 'footer_categories_section', 0, NULL),
(20, 4, NULL, '/en/categories', 1, NULL);

--
-- Table structure for table `eventic_menu_element_translation`
--

DROP TABLE IF EXISTS `eventic_menu_element_translation`;
CREATE TABLE IF NOT EXISTS `eventic_menu_element_translation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `translatable_id` int(11) DEFAULT NULL,
  `label` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_CEDB3B23989D9B62` (`slug`),
  UNIQUE KEY `eventic_menu_element_translation_unique_translation` (`translatable_id`,`locale`),
  KEY `IDX_CEDB3B232C2AC5D3` (`translatable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `eventic_menu_element_translation`
--

INSERT INTO `eventic_menu_element_translation` (`id`, `translatable_id`, `label`, `slug`, `locale`) VALUES
(1, 1, 'Home', 'home', 'en'),
(2, 1, 'Accueil', 'accueil', 'fr'),
(3, 1, 'الصفحة الرئيسية', 'الصفحة-الرئيسية', 'ar'),
(4, 2, 'Browse Events', 'browse-events', 'en'),
(5, 2, 'Événements', 'evenements', 'fr'),
(6, 2, 'أحداث', 'أحداث', 'ar'),
(7, 3, 'Explore', 'explore', 'en'),
(8, 3, 'Explorer', 'explorer', 'fr'),
(9, 3, 'تصفح', 'تصفح', 'ar'),
(10, 4, 'Venues', 'venues', 'en'),
(11, 4, 'Lieux', 'lieux', 'fr'),
(12, 4, 'الأماكن', 'الأماكن', 'ar'),
(13, 5, 'How It works?', 'how-it-works', 'en'),
(14, 5, 'Comment ça marche?', 'comment-ca-marche', 'fr'),
(15, 5, 'كيفية الإشتغال', 'كيفية-الإشتغال', 'ar'),
(16, 6, 'Blog', 'blog', 'en'),
(17, 6, 'Blog', 'blog-1', 'fr'),
(18, 6, 'المدونة', 'المدونة', 'ar'),
(19, 7, 'My tickets', 'my-tickets', 'en'),
(20, 7, 'Mes billets', 'mes-billets', 'fr'),
(21, 7, 'تذاكري', 'تذاكري', 'ar'),
(22, 8, 'Add my event', 'add-my-event', 'en'),
(23, 8, 'Ajouter mon événement', 'ajouter-mon-evenement', 'fr'),
(24, 8, 'إنشاء حدث', 'إنشاء-حدث', 'ar'),
(25, 9, 'About us', 'about-us', 'en'),
(26, 9, 'À propos de nous', 'a-propos-de-nous', 'fr'),
(27, 9, 'معلومات عنا', 'معلومات-عنا', 'ar'),
(28, 10, 'Help center', 'help-center', 'en'),
(29, 10, 'Centre d\'aide', 'centre-daide', 'fr'),
(30, 10, 'مركز المساعدة', 'مركز-المساعدة', 'ar'),
(31, 11, 'Blog', 'blog-2', 'en'),
(32, 11, 'Blog', 'blog-3', 'fr'),
(33, 11, 'المدونة', 'المدونة-1', 'ar'),
(34, 12, 'Venues', 'venues-1', 'en'),
(35, 12, 'Lieux', 'lieux-1', 'fr'),
(36, 12, 'الأماكن', 'الأماكن-1', 'ar'),
(37, 13, 'Send us an email', 'send-us-an-email', 'en'),
(38, 13, 'Envoyez-nous un e-mail', 'envoyez-nous-un-e-mail', 'fr'),
(39, 13, 'مراسلتنا على البريد الاليكتروني', 'مراسلتنا-على-البريد-الاليكتروني', 'ar'),
(40, 14, 'Create an account', 'create-an-account', 'en'),
(41, 14, 'Créer un compte', 'creer-un-compte', 'fr'),
(42, 14, 'إنشاء حساب', 'إنشاء-حساب', 'ar'),
(43, 15, 'Sell tickets online', 'sell-tickets-online', 'en'),
(44, 15, 'Vendre des billets en ligne', 'vendre-des-billets-en-ligne', 'fr'),
(45, 15, 'بيع التذاكر عبر الإنترنت', 'بيع-التذاكر-عبر-الإنترنت', 'ar'),
(46, 16, 'My tickets', 'my-tickets-1', 'en'),
(47, 16, 'Mes billets', 'mes-billets-1', 'fr'),
(48, 16, 'تذاكري', 'تذاكري-1', 'ar'),
(49, 17, 'Forgot your password ?', 'forgot-your-password', 'en'),
(50, 17, 'Mot de passe oublié ?', 'mot-de-passe-oublie', 'fr'),
(51, 17, 'نسيت رقمك السري ؟', 'نسيت-رقمك-السري-؟', 'ar'),
(52, 18, 'Pricing and fees', 'pricing-and-fees', 'en'),
(53, 18, 'Tarifs et Frais', 'tarifs-et-frais', 'fr'),
(54, 18, 'التسعير والرسوم', 'التسعير-والرسوم', 'ar'),
(55, 19, 'No text', 'no-text', 'en'),
(56, 20, 'All categories', 'all-categories', 'en'),
(57, 20, 'Toutes les catégories', 'toutes-les-categories', 'fr'),
(58, 20, 'جميع الفئات', 'جميع-الفئات', 'ar'),
(59, 1, 'Página principal', 'pagina-principal', 'es'),
(60, 2, 'Buscar eventos', 'buscar-eventos', 'es'),
(61, 3, 'Explorar', 'explorar', 'es'),
(62, 4, 'Lugares', 'lugares', 'es'),
(63, 5, '¿Cómo funciona?', 'como-funciona', 'es'),
(64, 6, 'Blog', 'blog-4', 'es'),
(65, 7, 'Mis entradas', 'mis-entradas', 'es'),
(66, 8, 'Agregar mi evento', 'agregar-mi-evento', 'es'),
(67, 9, 'Sobre nosotros', 'sobre-nosotros', 'es'),
(68, 10, 'Centro de ayuda', 'centro-de-ayuda', 'es'),
(69, 11, 'Blog', 'blog-5', 'es'),
(70, 12, 'Lugares', 'lugares-1', 'es'),
(71, 13, 'Envianos un email', 'envianos-un-email', 'es'),
(72, 14, 'Crea una cuenta', 'crea-una-cuenta', 'es'),
(73, 15, 'Vender entradas online', 'vender-entradas-online', 'es'),
(74, 16, 'Mis entradas', 'mis-entradas-1', 'es'),
(75, 17, 'Olvidaste tu contraseña ?', 'olvidaste-tu-contrasena', 'es'),
(76, 18, 'Precios y tarifas', 'precios-y-tarifas', 'es'),
(77, 20, 'Todas las categorias', 'todas-las-categorias', 'es');



--
-- Table structure for table `migration_versions`
--

DROP TABLE IF EXISTS `migration_versions`;
CREATE TABLE IF NOT EXISTS `migration_versions` (
  `version` varchar(14) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `eventic_amenity_translation`
--
ALTER TABLE `eventic_amenity_translation`
  ADD CONSTRAINT `FK_3C354FF82C2AC5D3` FOREIGN KEY (`translatable_id`) REFERENCES `eventic_amenity` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `eventic_audience_translation`
--
ALTER TABLE `eventic_audience_translation`
  ADD CONSTRAINT `FK_5CF81D362C2AC5D3` FOREIGN KEY (`translatable_id`) REFERENCES `eventic_audience` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `eventic_blog_post`
--
ALTER TABLE `eventic_blog_post`
  ADD CONSTRAINT `FK_E66028C712469DE2` FOREIGN KEY (`category_id`) REFERENCES `eventic_blog_post_category` (`id`);

--
-- Constraints for table `eventic_blog_post_category_translation`
--
ALTER TABLE `eventic_blog_post_category_translation`
  ADD CONSTRAINT `FK_BAF151EA2C2AC5D3` FOREIGN KEY (`translatable_id`) REFERENCES `eventic_blog_post_category` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `eventic_blog_post_translation`
--
ALTER TABLE `eventic_blog_post_translation`
  ADD CONSTRAINT `FK_6A7C548D2C2AC5D3` FOREIGN KEY (`translatable_id`) REFERENCES `eventic_blog_post` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `eventic_cart_element`
--
ALTER TABLE `eventic_cart_element`
  ADD CONSTRAINT `FK_FFABA270182CEB62` FOREIGN KEY (`eventticket_id`) REFERENCES `eventic_event_date_ticket` (`id`),
  ADD CONSTRAINT `FK_FFABA270A76ED395` FOREIGN KEY (`user_id`) REFERENCES `eventic_user` (`id`);

--
-- Constraints for table `eventic_category_translation`
--
ALTER TABLE `eventic_category_translation`
  ADD CONSTRAINT `FK_3CFC55AB2C2AC5D3` FOREIGN KEY (`translatable_id`) REFERENCES `eventic_category` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `eventic_comment`
--
ALTER TABLE `eventic_comment`
  ADD CONSTRAINT `FK_E58109F5E2904019` FOREIGN KEY (`thread_id`) REFERENCES `eventic_thread` (`id`),
  ADD CONSTRAINT `FK_E58109F5F675F31B` FOREIGN KEY (`author_id`) REFERENCES `eventic_user` (`id`);

--
-- Constraints for table `eventic_country_translation`
--
ALTER TABLE `eventic_country_translation`
  ADD CONSTRAINT `FK_1AAA1D022C2AC5D3` FOREIGN KEY (`translatable_id`) REFERENCES `eventic_country` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `eventic_event`
--
ALTER TABLE `eventic_event`
  ADD CONSTRAINT `FK_E1933DCB12469DE2` FOREIGN KEY (`category_id`) REFERENCES `eventic_category` (`id`),
  ADD CONSTRAINT `FK_E1933DCB376C51EF` FOREIGN KEY (`isonhomepageslider_id`) REFERENCES `eventic_homepage_hero_setting` (`id`),
  ADD CONSTRAINT `FK_E1933DCB876C4DDA` FOREIGN KEY (`organizer_id`) REFERENCES `eventic_organizer` (`id`),
  ADD CONSTRAINT `FK_E1933DCBF92F3E70` FOREIGN KEY (`country_id`) REFERENCES `eventic_country` (`id`);

--
-- Constraints for table `eventic_eventdate_pointofsale`
--
ALTER TABLE `eventic_eventdate_pointofsale`
  ADD CONSTRAINT `FK_7E37EBFC18E07BF3` FOREIGN KEY (`pointofsale_id`) REFERENCES `eventic_pointofsale` (`id`),
  ADD CONSTRAINT `FK_7E37EBFC733DA6BA` FOREIGN KEY (`eventdate_id`) REFERENCES `eventic_event_date` (`id`);

--
-- Constraints for table `eventic_eventdate_scanner`
--
ALTER TABLE `eventic_eventdate_scanner`
  ADD CONSTRAINT `FK_A911049367C89E33` FOREIGN KEY (`scanner_id`) REFERENCES `eventic_scanner` (`id`),
  ADD CONSTRAINT `FK_A9110493733DA6BA` FOREIGN KEY (`eventdate_id`) REFERENCES `eventic_event_date` (`id`);

--
-- Constraints for table `eventic_event_audience`
--
ALTER TABLE `eventic_event_audience`
  ADD CONSTRAINT `FK_F46FAEC788818ADD` FOREIGN KEY (`Event_id`) REFERENCES `eventic_event` (`id`),
  ADD CONSTRAINT `FK_F46FAEC797946D63` FOREIGN KEY (`Audience_Id`) REFERENCES `eventic_audience` (`id`);

--
-- Constraints for table `eventic_event_date`
--
ALTER TABLE `eventic_event_date`
  ADD CONSTRAINT `FK_D30F7AD340A73EBA` FOREIGN KEY (`venue_id`) REFERENCES `eventic_venue` (`id`),
  ADD CONSTRAINT `FK_D30F7AD371F7E88B` FOREIGN KEY (`event_id`) REFERENCES `eventic_event` (`id`);

--
-- Constraints for table `eventic_event_date_ticket`
--
ALTER TABLE `eventic_event_date_ticket`
  ADD CONSTRAINT `FK_E8B0FCF9733DA6BA` FOREIGN KEY (`eventdate_id`) REFERENCES `eventic_event_date` (`id`);

--
-- Constraints for table `eventic_event_image`
--
ALTER TABLE `eventic_event_image`
  ADD CONSTRAINT `FK_6A4E8E5E71F7E88B` FOREIGN KEY (`event_id`) REFERENCES `eventic_event` (`id`);

--
-- Constraints for table `eventic_event_language`
--
ALTER TABLE `eventic_event_language`
  ADD CONSTRAINT `FK_DD794B6A88818ADD` FOREIGN KEY (`Event_id`) REFERENCES `eventic_event` (`id`),
  ADD CONSTRAINT `FK_DD794B6A91E91181` FOREIGN KEY (`Language_Id`) REFERENCES `eventic_language` (`id`);

--
-- Constraints for table `eventic_event_subtitle`
--
ALTER TABLE `eventic_event_subtitle`
  ADD CONSTRAINT `FK_5827AD6E88818ADD` FOREIGN KEY (`Event_id`) REFERENCES `eventic_event` (`id`),
  ADD CONSTRAINT `FK_5827AD6E91E91181` FOREIGN KEY (`Language_Id`) REFERENCES `eventic_language` (`id`);

--
-- Constraints for table `eventic_event_translation`
--
ALTER TABLE `eventic_event_translation`
  ADD CONSTRAINT `FK_2FCD2BD62C2AC5D3` FOREIGN KEY (`translatable_id`) REFERENCES `eventic_event` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `eventic_favorites`
--
ALTER TABLE `eventic_favorites`
  ADD CONSTRAINT `FK_B853A82F88818ADD` FOREIGN KEY (`Event_id`) REFERENCES `eventic_event` (`id`),
  ADD CONSTRAINT `FK_B853A82FFD57CEAB` FOREIGN KEY (`User_Id`) REFERENCES `eventic_user` (`id`);

--
-- Constraints for table `eventic_following`
--
ALTER TABLE `eventic_following`
  ADD CONSTRAINT `FK_2D8545399F5D9622` FOREIGN KEY (`Organizer_id`) REFERENCES `eventic_organizer` (`id`),
  ADD CONSTRAINT `FK_2D854539FD57CEAB` FOREIGN KEY (`User_Id`) REFERENCES `eventic_user` (`id`);

--
-- Constraints for table `eventic_help_center_article`
--
ALTER TABLE `eventic_help_center_article`
  ADD CONSTRAINT `FK_75F977E312469DE2` FOREIGN KEY (`category_id`) REFERENCES `eventic_help_center_category` (`id`);

--
-- Constraints for table `eventic_help_center_article_translation`
--
ALTER TABLE `eventic_help_center_article_translation`
  ADD CONSTRAINT `FK_54AB40302C2AC5D3` FOREIGN KEY (`translatable_id`) REFERENCES `eventic_help_center_article` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `eventic_help_center_category`
--
ALTER TABLE `eventic_help_center_category`
  ADD CONSTRAINT `FK_9BE9AD17727ACA70` FOREIGN KEY (`parent_id`) REFERENCES `eventic_help_center_category` (`id`);

--
-- Constraints for table `eventic_help_center_category_translation`
--
ALTER TABLE `eventic_help_center_category_translation`
  ADD CONSTRAINT `FK_2B8AFEF52C2AC5D3` FOREIGN KEY (`translatable_id`) REFERENCES `eventic_help_center_category` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `eventic_homepage_hero_setting_translation`
--
ALTER TABLE `eventic_homepage_hero_setting_translation`
  ADD CONSTRAINT `FK_5DD4B1372C2AC5D3` FOREIGN KEY (`translatable_id`) REFERENCES `eventic_homepage_hero_setting` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `eventic_language_translation`
--
ALTER TABLE `eventic_language_translation`
  ADD CONSTRAINT `FK_E82162722C2AC5D3` FOREIGN KEY (`translatable_id`) REFERENCES `eventic_language` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `eventic_order`
--
ALTER TABLE `eventic_order`
  ADD CONSTRAINT `FK_2F14A4F44C3A3BB` FOREIGN KEY (`payment_id`) REFERENCES `eventic_payment` (`id`),
  ADD CONSTRAINT `FK_2F14A4F459CA0035` FOREIGN KEY (`paymentgateway_id`) REFERENCES `eventic_payment_gateway` (`id`),
  ADD CONSTRAINT `FK_2F14A4F4A76ED395` FOREIGN KEY (`user_id`) REFERENCES `eventic_user` (`id`);

--
-- Constraints for table `eventic_order_element`
--
ALTER TABLE `eventic_order_element`
  ADD CONSTRAINT `FK_261BAAD1182CEB62` FOREIGN KEY (`eventticket_id`) REFERENCES `eventic_event_date_ticket` (`id`),
  ADD CONSTRAINT `FK_261BAAD18D9F6D38` FOREIGN KEY (`order_id`) REFERENCES `eventic_order` (`id`);

--
-- Constraints for table `eventic_order_ticket`
--
ALTER TABLE `eventic_order_ticket`
  ADD CONSTRAINT `FK_111E8938EE04F0C1` FOREIGN KEY (`orderelement_id`) REFERENCES `eventic_order_element` (`id`);

--
-- Constraints for table `eventic_organizer`
--
ALTER TABLE `eventic_organizer`
  ADD CONSTRAINT `FK_C5EEB9A9A76ED395` FOREIGN KEY (`user_id`) REFERENCES `eventic_user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_C5EEB9A9F92F3E70` FOREIGN KEY (`country_id`) REFERENCES `eventic_country` (`id`);

--
-- Constraints for table `eventic_organizer_category`
--
ALTER TABLE `eventic_organizer_category`
  ADD CONSTRAINT `FK_BB88F7D715E3697` FOREIGN KEY (`Category_Id`) REFERENCES `eventic_category` (`id`),
  ADD CONSTRAINT `FK_BB88F7D79F5D9622` FOREIGN KEY (`Organizer_id`) REFERENCES `eventic_organizer` (`id`);

--
-- Constraints for table `eventic_page_translation`
--
ALTER TABLE `eventic_page_translation`
  ADD CONSTRAINT `FK_3B97CBF22C2AC5D3` FOREIGN KEY (`translatable_id`) REFERENCES `eventic_page` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `eventic_payment`
--
ALTER TABLE `eventic_payment`
  ADD CONSTRAINT `FK_1CDDDF948D9F6D38` FOREIGN KEY (`order_id`) REFERENCES `eventic_order` (`id`),
  ADD CONSTRAINT `FK_1CDDDF94F92F3E70` FOREIGN KEY (`country_id`) REFERENCES `eventic_country` (`id`);

--
-- Constraints for table `eventic_payment_gateway`
--
ALTER TABLE `eventic_payment_gateway`
  ADD CONSTRAINT `FK_9D4780D7876C4DDA` FOREIGN KEY (`organizer_id`) REFERENCES `eventic_organizer` (`id`);

--
-- Constraints for table `eventic_payout_request`
--
ALTER TABLE `eventic_payout_request`
  ADD CONSTRAINT `FK_4AE2AE433DC09FC4` FOREIGN KEY (`event_date_id`) REFERENCES `eventic_event_date` (`id`),
  ADD CONSTRAINT `FK_4AE2AE4362890FD5` FOREIGN KEY (`payment_gateway_id`) REFERENCES `eventic_payment_gateway` (`id`),
  ADD CONSTRAINT `FK_4AE2AE43876C4DDA` FOREIGN KEY (`organizer_id`) REFERENCES `eventic_organizer` (`id`);

--
-- Constraints for table `eventic_pointofsale`
--
ALTER TABLE `eventic_pointofsale`
  ADD CONSTRAINT `FK_5D78D6FA876C4DDA` FOREIGN KEY (`organizer_id`) REFERENCES `eventic_organizer` (`id`),
  ADD CONSTRAINT `FK_5D78D6FAA76ED395` FOREIGN KEY (`user_id`) REFERENCES `eventic_user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `eventic_review`
--
ALTER TABLE `eventic_review`
  ADD CONSTRAINT `FK_3D9D918271F7E88B` FOREIGN KEY (`event_id`) REFERENCES `eventic_event` (`id`),
  ADD CONSTRAINT `FK_3D9D9182A76ED395` FOREIGN KEY (`user_id`) REFERENCES `eventic_user` (`id`);

--
-- Constraints for table `eventic_scanner`
--
ALTER TABLE `eventic_scanner`
  ADD CONSTRAINT `FK_241A84B0876C4DDA` FOREIGN KEY (`organizer_id`) REFERENCES `eventic_organizer` (`id`),
  ADD CONSTRAINT `FK_241A84B0A76ED395` FOREIGN KEY (`user_id`) REFERENCES `eventic_user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `eventic_ticket_reservation`
--
ALTER TABLE `eventic_ticket_reservation`
  ADD CONSTRAINT `FK_716DEA9F182CEB62` FOREIGN KEY (`eventticket_id`) REFERENCES `eventic_event_date_ticket` (`id`),
  ADD CONSTRAINT `FK_716DEA9FA76ED395` FOREIGN KEY (`user_id`) REFERENCES `eventic_user` (`id`),
  ADD CONSTRAINT `FK_716DEA9FEE04F0C1` FOREIGN KEY (`orderelement_id`) REFERENCES `eventic_order_element` (`id`);

--
-- Constraints for table `eventic_user`
--
ALTER TABLE `eventic_user`
  ADD CONSTRAINT `FK_D01C6A2218E07BF3` FOREIGN KEY (`pointofsale_id`) REFERENCES `eventic_pointofsale` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_D01C6A2267C89E33` FOREIGN KEY (`scanner_id`) REFERENCES `eventic_scanner` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_D01C6A22876C4DDA` FOREIGN KEY (`organizer_id`) REFERENCES `eventic_organizer` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_D01C6A22F2709FF9` FOREIGN KEY (`isorganizeronhomepageslider_id`) REFERENCES `eventic_homepage_hero_setting` (`id`),
  ADD CONSTRAINT `FK_D01C6A22F92F3E70` FOREIGN KEY (`country_id`) REFERENCES `eventic_country` (`id`);

--
-- Constraints for table `eventic_venue`
--
ALTER TABLE `eventic_venue`
  ADD CONSTRAINT `FK_4BAC2C61876C4DDA` FOREIGN KEY (`organizer_id`) REFERENCES `eventic_organizer` (`id`),
  ADD CONSTRAINT `FK_4BAC2C61C54C8C93` FOREIGN KEY (`type_id`) REFERENCES `eventic_venue_type` (`id`),
  ADD CONSTRAINT `FK_4BAC2C61F92F3E70` FOREIGN KEY (`country_id`) REFERENCES `eventic_country` (`id`);

--
-- Constraints for table `eventic_venue_amenity`
--
ALTER TABLE `eventic_venue_amenity`
  ADD CONSTRAINT `FK_8A89D31E45463477` FOREIGN KEY (`Amenity_Id`) REFERENCES `eventic_amenity` (`id`),
  ADD CONSTRAINT `FK_8A89D31EB9D15CEC` FOREIGN KEY (`Venue_id`) REFERENCES `eventic_venue` (`id`);

--
-- Constraints for table `eventic_venue_image`
--
ALTER TABLE `eventic_venue_image`
  ADD CONSTRAINT `FK_F3EE32A540A73EBA` FOREIGN KEY (`venue_id`) REFERENCES `eventic_venue` (`id`);

--
-- Constraints for table `eventic_venue_translation`
--
ALTER TABLE `eventic_venue_translation`
  ADD CONSTRAINT `FK_3A06BD632C2AC5D3` FOREIGN KEY (`translatable_id`) REFERENCES `eventic_venue` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `eventic_venue_type_translation`
--
ALTER TABLE `eventic_venue_type_translation`
  ADD CONSTRAINT `FK_9FD9786F2C2AC5D3` FOREIGN KEY (`translatable_id`) REFERENCES `eventic_venue_type` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `eventic_vote`
--
ALTER TABLE `eventic_vote`
  ADD CONSTRAINT `FK_79F390FEBB4B8AD` FOREIGN KEY (`voter_id`) REFERENCES `eventic_user` (`id`),
  ADD CONSTRAINT `FK_79F390FF8697D13` FOREIGN KEY (`comment_id`) REFERENCES `eventic_comment` (`id`);
COMMIT;

--
-- Constraints for table `eventic_menu_translation`
--
ALTER TABLE `eventic_menu_translation`
  ADD CONSTRAINT `FK_44D78BCC2C2AC5D3` FOREIGN KEY (`translatable_id`) REFERENCES `eventic_menu` (`id`) ON DELETE CASCADE;
COMMIT;

--
-- Constraints for table `eventic_menu_element`
--
ALTER TABLE `eventic_menu_element`
  ADD CONSTRAINT `FK_8CAA77C9CCD7E912` FOREIGN KEY (`menu_id`) REFERENCES `eventic_menu` (`id`);
COMMIT;

--
-- Constraints for table `eventic_menu_element_translation`
--
ALTER TABLE `eventic_menu_element_translation`
  ADD CONSTRAINT `FK_CEDB3B232C2AC5D3` FOREIGN KEY (`translatable_id`) REFERENCES `eventic_menu_element` (`id`) ON DELETE CASCADE;
COMMIT;

CREATE UNIQUE INDEX UNIQ_E0F45684D2D95D97 ON eventic_currency (ccy);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
