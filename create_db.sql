CREATE DATABASE simple_news;
USE simple_news;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `registration_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `is_admin` tinyint(1) DEFAULT '0',
  `google_id` varchar(255) DEFAULT NULL,
  `facebook_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `google_id` (`google_id`),
  UNIQUE KEY `facebook_id` (`facebook_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `articles`;
CREATE TABLE `articles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `content` text,
  `author_id` int DEFAULT NULL,
  `publish_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `is_published` tinyint(1) DEFAULT '1',
  `category_id` int DEFAULT NULL,
  `views` int DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `author_id` (`author_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`),
  CONSTRAINT `articles_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `ci_sessions`;
CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `article_id` int DEFAULT NULL,
  `content` text,
  `date_posted` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `article_id` (`article_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`),
  CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `images`;
CREATE TABLE `images` (
  `id` int NOT NULL AUTO_INCREMENT,
  `article_id` int DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `upload_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `article_id` (`article_id`),
  CONSTRAINT `images_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO users (email, password_hash, name, registration_date, is_admin, google_id, facebook_id)
VALUES
('admin@admin.lv', '$2y$10$H7Zw8czvi7akatBfUhhve.IfpyRjlAB3AL8OAaZHXmQQRn4cyo6MC', 'Sabine', NOW(), true, NULL, NULL);

INSERT INTO categories (name)
VALUES
('Sports'),
('Tehnologijas'),
('Zinas'),
('Izklaide');

INSERT INTO articles (title, content, author_id, publish_date, is_published, category_id)
VALUES
('Merzļikins priecājas būt izlasē, atvainojas aizskartajiem faniem un nav priecīgs par mediju attieksmi ', 'Vārtsargs Elvis Merzļikins saviem komandas biedriem Latvijas hokeja izlasē ir gatavs atdot visu, tomēr atgriešanās dzimtenē viņam bijusi ar divējādām sajūtām, pirmdien sarunā ar Latvijas žurnālistiem teica hokejists.<br>Merzļikins pagājušajā nedēļā noslēdza sezonu Nacionālajā hokeja līgā (NHL), kur Kolumbusas "Blue Jackets" sastāvā 41 mačā izcīnīja 13 uzvaras, vidēji ielaida 3,45 ripas un atvairīja 89,7% metienu. Svētdien viņš ieradās Latvijā un jau pirmdienas rītā pievienojās izlases treniņiem, gatavojoties pasaules čempionātam.', 1, NOW(), true, 1),
('Jokičs, Dončičs vai Gildžess-Aleksandrs – kurš būs NBA sezonas vērtīgākais spēlētājs? ', 'Uz Nacionālās basketbola asociācijas (NBA) sezonas vērtīgākā spēlētāja jeb MVP balvu pretendē Nikola Jokičs no Denveras "Nuggets", Luka Dončičs no Dalasas "Mavericks" un Šejs Gildžess-Aleksandrs no Oklahomasitijas "Thunder", svētdien paziņoja līga.<br>Jokičs starp trim finālistiem uz MVP balvu ir jau ceturto gadu pēc kārtas, pie balvas tiekot 2021. un 2022.gadā, bet pērn finišēja otrais aiz Filadelfijas "76ers" spēlētāja Džoela Embīda.<br>Embīds un Milvoki "Bucks" spēlētājs Jannis Adetokunbo bija MVP finālisti līdzās Jokičam katrā no iepriekšējām divām sezonām, taču šosezon viņus nomainīja Gildžess-Aleksandrs un Dončičs.', 1, NOW(), true, 1),
('Netflix peļņai un abonentu skaitam būtisks kāpums', 'ASV filmu un televīzijas seriālu straumēšanas platforma "Netflix" ceturtdien paziņoja, ka šī gada pirmajā ceturksnī būtiski pieaugusi gan peļņa, gan abonentu skaits.<br>"Netflix" abonentu skaits pirmajā ceturksnī palielinājies par 9,3 miljoniem un sasniedzis 269,6 miljonus.<br>Vienlaikus uzņēmuma peļņa šī gada pirmajos trīs mēnešos pieaugusi līdz 2,3 miljardiem eiro, salīdzinot ar 1,3 miljardiem eiro attiecīgajā laika periodā pirms gada.', 1, NOW(), true, 2),
('AS Balticom uzspiež pakalpojumus deviņdesmito gadu stilā?', '"Dienas Biznesa" (DB) rīcībā ir nonākusi informācija, ka elektronisko sakaru pakalpojuma sniedzējs AS “Balticom” cenšas uzspiest klientiem tās pakalpojuma “modernizāciju”, bet, ja piekrišana netiek saņemta vai netiek atbildēts uz telefonu zvaniem, AS “Balticom” negaidīti atslēdz iepriekš jau apmaksātu pakalpojumu.<br>Šķita, ka tamlīdzīgas komercprakses izpausmes ir deviņdesmito gadu pagātne, tāpēc DB nolēma izpētīt, vai tiešām AS “Balticom” bezbailīgi uzskata, ka viņiem ir imunitāte pret patērētāju tiesībām.<br>Informāciju par šādu atgadījumu sniedza kāds DB lasītājs, kurš pastāstīja, ka šaubas par AS “Balticom” profesionalitāti viņam radušās jau īsi pēc līguma noslēgšanas, kad AS “Balticom” darbinieki uzstādot pakalpojumu nodarījuši kaitējumu īpašumam – izurbuši caurumus grīdās un sienās, krustām šķērsām izlaiduši kabeļus cauri visai mājai un beigās atstājuši uz zemes mētājamies dažādus vadus, kas galu galā ar internetu apgādā arī kaimiņu īpašumu. Samierinājies ar nepatīkamo pieredzi, viņš līgumu nelauza un tālākā sadarbībā nekas neliecināja, ka radīsies problēmas – AS “Balticom” internets bijis labs, vienīgi nav bijis patīkami, ka TV kanālu klāstā bijuši daudzi Krievijas propagandas kanāli, piebilda DB lasītājs, nu jau bijušais AS “Balticom” klients.', 1, NOW(), true, 2),
('Polija gatava izvietot kodolieročus savā teritorijā, paziņo Duda', 'Polija ir gatava savā teritorijā izvietot kodolieročus NATO programmas "Nuclear Sharing" ietvaros, intervijā medijam "Fakt" atklājis Polijas prezidents Andžejs Duda.<br>Kā stāsta prezidents, šis jautājums jau kādu laiku ir Polijas-ASV sarunu temats.<br>"Atzīstos, kad man par to jautāja, es paudu mūsu gatavību," teica Duda.<br>Viņš atzīmē, ka Krievija pastiprina Karaļauču militarizāciju un ir izvietojusi kodolieročus Baltkrievijā.', 1, NOW(), true, 3),
('Ukraiņi sašāvuši cara Nikolaja II meitas iesvētītu kuģi', 'Glābšanas kuģi "Komūna" ("Коммуна") ūdenī nolaida 1913. gadā Sanktpēterburgā, un par tā krustmāti kļuva Krievijas impērijas pēdējā cara Nikolaja II meita kņaziene Marija. Neticamā kārtā 111 gadus vecais kuģis ir izdzīvojis līdz mūsdienām un joprojām atrodas Krievijas jūras spēku Melnās jūras flotes dienestā. Aizvadītajās brīvdienās Ukrainas jūras spēki šo kuģi sašāva, un tas vairs nav spējīgs pildīt dienesta pienākukmus.<br>Kreisera "Moskva", kas bija arī Krievijas Melnās jūras flotes flagmanis, nogremdēšana pagaidām ir viena no lielākajām ukraiņu uzvarām Krievijas karā pret Ukrainu. 13. aprīlī "Moskva" trāpīja divas Ukrainas pretkuģu raķetes "Neptun". Uz kreisera izcēlās ugunsgrēks, pēc vairākām stundām tas nogrima un šobrīd guļ aptuveni 90 metru dziļumā Melnās jūras dzelmē netālu no Odesas. Uz kuģa atradās ne tikai raķetes un cits nopietns bruņojums, bet arī kristiešu relikvija – dažus milimetrus liela skaida no krusta, pie kura bija piesists Jēzus Kristus.', 1, NOW(), true, 3),
('Apmeklētajiem durvis vērs jaunā Piejūras brīvdabas muzeja ēka Ventspilī', 'Šī gada 27. aprīlī Ventspilī apmeklētajiem atvērs jauno Piejūras brīvdabas muzeja ekspozīciju, tāpat jaunumi gaidīs muzeja āra teritorijā.<br>Kā "Delfi" informē Ventspils muzeja pārstāvji, jaunā Piejūras brīvdabas muzeja ēka ir daļa no apjomīgā projekta "Ziemeļkurzemes kultūrvēsturiskā un dabas mantojuma saglabāšana, eksponēšana un tūrisma piedāvājuma attīstība". 2018. gada 17. janvārī tika parakstīts līgums ar Centrālo finanšu un līgumu aģentūru par šī projekta īstenošanu, kura ietvaros Ventspils muzejs kopā ar Ventspils Komunālo pārvaldi īstenoja divas aktivitātes – tika izveidota infrastruktūra Ventspilī, dienvidrietumu rajonā, Pelēkās kāpas sasniedzamībai un saglabāšanai un Ventspils Piejūras brīvdabas muzeja apbūve.', 1, NOW(), true, 4),
('Teilore Svifta ar jauno albumu pārspēj vēl vienu rekordu', 'Teilores Sviftas jaunais albums “Mocīto dzejnieku nodaļa” (“The Tortured Poets Department”) platformā “Spotify” kļuvis par visvairāk straumēto vienas dienas laikā, raksta britu raidsabiedrība BBC.<br>Svifta arī kļuvusi par visstraumētāko mākslinieci vienas dienas laikā.<br>Jaunais un fanu ilgi gaidītais albums tika laists klajā piektdien un tajā ir 31 skaņdarbs, kurā popzvaigzne izdzied savas sirdssāpes un dusmas uz bijušajiem partneriem.', 1, NOW(), true, 4);


INSERT INTO images (article_id, image_path, upload_date)
VALUES
(1, 'uploads/merzlikins.jpg', NOW()),
(2, 'uploads/nba.jpg', NOW()),
(3, 'uploads/netflix.jpg', NOW()),
(4, 'uploads/balticom.jpg', NOW()),
(5, 'uploads/polija.jpg', NOW()),
(6, 'uploads/kugis.jpg', NOW()),
(7, 'uploads/ventspils.jpg', NOW()),
(8, 'uploads/taylor.jpg', NOW());

